<?php

require_once('../config.php');

include_once('functions.php');

include DIR.'model/Conexao.class.php';
include DIR.'model/Banco.class.php';
include DIR.'model/Upload.class.php';

$return = array();

if(isset($_POST['action'])) {
	switch (strip_tags($_POST['action'])) {
		case 'login':
			$username = strip_tags($_POST['username']);
			$password = hash("sha512",$_POST['pass'].HASH);

			$banco = new Banco();
			$banco->setTable('users');
			$banco->setColumns(['id','name','active']);
			$banco->setWhere("username = '{$username}' AND password = '{$password}'");
			$user = $banco->query();
			if($user->count){
				if($user->result[0]->active){
					$access = new Banco();
					$access->setTable('access_log');
					$access->setColumns(['user','ip','agent']);
					$access->setValues([$user->result[0]->id,$_SERVER['REMOTE_ADDR'],$_SERVER['HTTP_USER_AGENT']]);
					$access->insert();

					$_SESSION['logado']['dados'] = $user->result[0];

					$banco = new Banco();
					$banco->setTable('pages');
					$banco->setWhere('id IN (SELECT page_id FROM profile_page LEFT JOIN users ON (users.profile_id=profile_page.profile_id) WHERE users.id = '.$user->result[0]->id.')');
					$banco->setOrder('pages.name');
					$_menu = $banco->query();

					foreach($_menu->result as $page){
						$_SESSION['logado']['pages'][$page->url] = $page;
					}

					if(isset($_POST['remember'])){
						setcookie('username',$username,time()+3600*24*30,DIR);
						setcookie('password',$password,time()+3600*24*30,'../');
						$return['remember']=true;
					}

					$return['success'] = true;
					$return['app']['location'] = LINK.'home';
				} else {
					$return['alert']['title'] = 'Usuário desativado';
					$return['alert']['text'] = 'Entre em contato com o responsável';
					$return['alert']['type'] = 'warning';
					$return['success'] = false;
				}
			} else {
				$return['alert']['title'] = 'Dados incorretos';
				$return['alert']['text'] = 'Verifique as informações digitadas.';
				$return['alert']['type'] = 'danger';
				$return['success'] = false;
			}
			break;

		case 'add':
			$ignore_name = ['action','table'];

			foreach($_POST as $k=>$v){
				if(!is_array($v)){
					if(!in_array($k,$ignore_name)){
						$_columns[]=$k;
						if($k=='password'){
							$_values[] = hash("sha512",$v.HASH);
						} else {
							$_values[]=strip_tags($v);
						}
					}
				} else {
					$foreign_table = $k;
					$foreign_cols = explode('_', $foreign_table);
					$foreign_col[0] = $foreign_cols[0].'_id';
					$foreign_col[1] = $foreign_cols[1].'_id';
					$foreign_sql_cols = implode(',', $foreign_col);
					foreach($v as $fv){
						$foreign_sql_val[] = $fv;
					}
				}
			}

			if(isset($_FILES['image_id'])){
				$return['image_id']=$_FILES['image_id'];
				$upload = new Upload();
				$return['image'] = $upload->send($_FILES['image_id']);
				$banco_img = new Banco();
				$banco_img->setTable('images');
				$banco_img->setColumns('image');
				$banco_img->setValues($return['image']);
				$return['image_sql'] = $banco_img->insert();
				$_columns[]='image_id';
				$_values[]=$return['image_sql']->id;
			}

			$banco = new Banco();
			$banco->setColumns($_columns);
			$banco->setValues($_values);
			$banco->setTable($_POST['table']);
			$add = $banco->insert();

			if($_POST['table']=='pages'){
				$banco_adm = new Banco();
				$banco_adm->setTable('profiles');
				$banco_adm->setWhere('root = 1');
				$result_adm = $banco_adm->query();
				foreach($result_adm->result as $adms){
					$banco_prof_root = new Banco();
					$banco_prof_root->setTable('profile_page');
					$banco_prof_root->setColumns(['profile_id','page_id']);
					$banco_prof_root->setValues([$adms->id,$add->id]);
					$banco_prof_root->insert();
				}
			}

			$return['banco'] = $add;
			$return['success']=$add->status;
			if($add->status){
				if(isset($foreign_sql_val)){
					foreach($foreign_sql_val as $k=>$v){
						$banco = new Banco();
						$banco->setTable($foreign_table);
						$banco->setColumns($foreign_sql_cols);
						$banco->setValues([$add->id,$v]);
						$return['foreign'][] = $banco->insert();
					}
				}

				$return['alert']['title'] = 'Cadastro inserido';
				$return['alert']['text'] = 'Cadastro gravado com sucesso.';
				$return['alert']['type'] = 'success';
			} else {
				$return['alert']['title'] = 'Erro';
				$return['alert']['text'] = 'Não foi possível registrar. Tente novamente.';
				$return['alert']['type'] = 'danger';
			}
			break;

		case 'edit':
			$ignore_name = ['action','table','id'];

			$return['post'] = $_POST;

			foreach($_POST as $k=>$v){
				if(!is_array($v)){
					if(!in_array($k,$ignore_name)){
						$_columns[]=$k;
						if($k=='password'){
							$_values[] = hash("sha512",$v.HASH);
						} else {
							$_values[]=strip_tags($v);
						}
					}
				} else {
					$foreign_table = $k;
					$foreign_cols = explode('_', $foreign_table);
					$foreign_col[0] = $foreign_cols[0].'_id';
					$foreign_col[1] = $foreign_cols[1].'_id';
					$foreign_sql_cols = implode(',', $foreign_col);
					foreach($v as $fv){
						$foreign_sql_val[] = $fv;
					}
				}
			}

			if(isset($_FILES['image_id']) && isset($_FILES['image_id']['tmp_name'])){
				$return['image_id']=$_FILES['image_id'];
				$upload = new Upload();
				$return['image'] = $upload->send($_FILES['image_id']);

				$banco_img = new Banco();
				$banco_img->setTable($_POST['table']);
				$banco_img->setWhere("image_id IS NOT NULL AND id=".$_POST['id']);
				$checa_img = $banco_img->query();
				$return['checa_img'] = $checa_img;
				
				$banco_img = new Banco();
				$banco_img->setTable('images');
				$banco_img->setColumns('image');
				$banco_img->setValues($return['image']);

				if($checa_img->count>0){
					$banco_img->setWhere("id = ".$checa_img->result[0]->image_id);
					$banco_img->update();
				} else {
					$return['image_sql'] = $banco_img->insert();
					$_columns[]='image_id';
					$_values[]=$return['image_sql']->id;
				}
			}

			$banco = new Banco();
			$banco->setColumns($_columns);
			$banco->setValues($_values);
			$banco->setTable($_POST['table']);
			$banco->setWhere('id = '.$_POST['id']);
			$edit = $banco->update();

			$return['banco'] = $edit;
			$return['success']=$edit->status;
			if($edit->status){
				if(isset($foreign_sql_val)){
					$banco = new Banco();
					$banco->setTable($foreign_table);
					$banco->setWhere($foreign_col[0].' = '.$_POST['id']);
					$banco->delete();
					foreach($foreign_sql_val as $k=>$v){
						$banco = new Banco();
						$banco->setTable($foreign_table);
						$banco->setColumns($foreign_sql_cols);
						$banco->setValues([$_POST['id']	,$v]);
						$return['foreign'][] = $banco->insert();
					}
				}

				$return['alert']['title'] = 'Cadastro atualizado';
				$return['alert']['text'] = 'Cadastro atualizado com sucesso.';
				$return['alert']['type'] = 'success';
			} else {
				$return['alert']['title'] = 'Erro';
				$return['alert']['text'] = 'Não foi possível atualizar. Tente novamente.';
				$return['alert']['type'] = 'danger';
			}
			break;
			break;

		case 'delete':
			$id = $_POST['id'];
			$table = strip_tags($_POST['table']);

			if(intval($id) && !empty($table)){
				$banco = new Banco();
				$banco->setTable($table);
				$banco->setWhere('id = '.$id);
				$sql = $banco->query();
				if($sql->count==1){
					$delete = $banco->delete();
					$return['success']=$delete->status;
				}
			} else {
				$return['success']=false;
			}
			break;
	}
}

echo json_encode($return);

?>
