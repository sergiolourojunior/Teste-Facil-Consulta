<?php

require_once('../config.php');

include_once('functions.php');

include DIR.'model/Conexao.class.php';
include DIR.'model/Medico.class.php';
include DIR.'model/Agenda.class.php';

$return = array();

if(isset($_POST['action'])) {
	switch (strip_tags($_POST['action'])) {
		case 'login':
			$email = strip_tags($_POST['email']);
			$pass = strip_tags($_POST['pass']);

			if(empty($email)) { $return = array('success' => false, 'text' => 'Campo E-mail não pode ser vazio!'); break; }
			if(empty($pass)) { $return = array('success' => false, 'text' => 'Campo Senha não pode ser vazio!'); break; }
			if(!validaEmail($email)) { $return = array('success' => false, 'text' => 'Utilize um e-mail válido.'); break; }

			$m = new Medico();
			$m->setEmail($email);
			if($m->findByEmail()) {
				$m->setSenha($pass);

				if($m->login()) {
					$return['success'] = true;
					$return['location'] = LINK.'agenda';
				} else {
					$return['success'] = false;
					$return['text'] = 'Dados de acesso não conferem.';
				}
			} else {
				$return['success'] = false;
				$return['text'] = 'Usuário não cadastrado.';
			}

			break;

		case 'register':
			
			$name = strip_tags($_POST['name']);
			$email = strip_tags($_POST['email']);
			$pass = strip_tags($_POST['pass']);
			$pass_confirm = strip_tags($_POST['pass-confirm']);
			$address = strip_tags($_POST['address']);

			if(empty($name)) { $return = array('success' => false, 'text' => 'Campo Nome não pode ser vazio!'); break; }
			if(empty($email)) { $return = array('success' => false, 'text' => 'Campo E-mail não pode ser vazio!'); break; }
			if(empty($pass)) { $return = array('success' => false, 'text' => 'Campo Senha não pode ser vazio!'); break; }
			if(empty($address)) { $return = array('success' => false, 'text' => 'Campo Endereço do Consultório não pode ser vazio!'); break; }

			if(strlen($name) > 112) { $return = array('success' => false, 'text' => 'Campo Nome deve ter no máximo 112 caracteres!'); break; }
			if(strlen($email) > 112) { $return = array('success' => false, 'text' => 'Campo E-mail deve ter no máximo 112 caracteres!'); break; }
			if(strlen($pass) > 112) { $return = array('success' => false, 'text' => 'Campo Senha deve ter no máximo 112 caracteres!'); break; }
			if(strlen($address) > 112) { $return = array('success' => false, 'text' => 'Campo Endereço do Consultório deve ter no máximo 112 caracteres!'); break; }

			if(strlen($name) < 6) { $return = array('success' => false, 'text' => 'Campo Nome deve ter no mínimo 6 caracteres!'); break; }
			if(strlen($email) < 6) { $return = array('success' => false, 'text' => 'Campo E-mail deve ter no mínimo 6 caracteres!'); break; }
			if(strlen($pass) < 6) { $return = array('success' => false, 'text' => 'Campo Senha deve ter no mínimo 6 caracteres!'); break; }
			if(strlen($address) < 6) { $return = array('success' => false, 'text' => 'Campo Endereço do Consultório deve ter no mínimo 6 caracteres!'); break; }

			if(!validaEmail($email)) { $return = array('success' => false, 'text' => 'Utilize um e-mail válido.'); break; }

			if($pass==$pass_confirm) {
				$m = new Medico();
				$m->setEmail($email);
				if(!$m->findByEmail()) {
					$m->setNome($name);
					$m->setSenha($pass);
					$m->setEnderecoConsultorio($address);
					if($m->save()) {
						$m->login();
						$return['success'] = true;
						$return['location'] = LINK.'agenda';
					} else {
						$return['success'] = false;
						$return['text'] = 'Houve um erro! Tente novamente.';
					}
				} else {
					$return['success'] = false;
					$return['text'] = 'E-mail já cadastrado.';
				}
			} else {
				$return['success'] = false;
				$return['text'] = 'As senhas não combinam.';
			}

			break;

		case 'perfil':

			$name = strip_tags($_POST['name']);
			$address = strip_tags($_POST['address']);

			if(empty($name)) { $return = array('success' => false, 'text' => 'Campo Nome não pode ser vazio!'); break; }
			if(empty($address)) { $return = array('success' => false, 'text' => 'Campo Endereço do Consultório não pode ser vazio!'); break; }
			
			if(strlen($name) > 112) { $return = array('success' => false, 'text' => 'Campo Nome deve ter no máximo 112 caracteres!'); break; }
			if(strlen($address) > 112) { $return = array('success' => false, 'text' => 'Campo Endereço do Consultório deve ter no máximo 112 caracteres!'); break; }
			
			if(strlen($name) < 6) { $return = array('success' => false, 'text' => 'Campo Nome deve ter no mínimo 6 caracteres!'); break; }
			if(strlen($address) < 6) { $return = array('success' => false, 'text' => 'Campo Endereço do Consultório deve ter no mínimo 6 caracteres!'); break; }

			$m = new Medico();
			$m->setId($_SESSION['logado']['id']);
			$m->setEmail($_SESSION['logado']['email']);
			$m->setNome($name);
			$m->setEnderecoConsultorio($address);

			if($m->save()) {
				$return['success'] = true;
				$return['location'] = LINK.'perfil';
			} else {
				$return = false;
				$return['text'] = 'Houve um erro! Tenten novamente.';
			}

			break;

		case 'senha':

			$pass = strip_tags($_POST['pass']);
			$pass_confirm = strip_tags($_POST['pass-confirm']);

			if(empty($pass)) { $return = array('success' => false, 'text' => 'Campo Senha não pode ser vazio!'); break; }
			if(strlen($pass) > 112) { $return = array('success' => false, 'text' => 'Campo Senha deve ter no máximo 112 caracteres!'); break; }
			if(strlen($pass) < 6) { $return = array('success' => false, 'text' => 'Campo Senha deve ter no mínimo 6 caracteres!'); break; }

			if($pass==$pass_confirm) {
				$m = new Medico();
				$m->setId($_SESSION['logado']['id']);
				$m->setSenha($pass);

				if($m->changePassword()) {
					$return['success'] = true;
					$return['text'] = 'Senha alterada com sucesso!';
				} else {
					$return = false;
					$return['text'] = 'Houve um erro! Tenten novamente.';
				}
			} else {
				$return = false;
				$return['text'] = 'As senhas não combinam.';
			}

			break;

		case 'excluir_conta':
			$m = new Medico();
			$m->setId($_SESSION['logado']['id']);
			if($m->delete()) {
				session_destroy();
				$return['success'] = true;
				$return['location'] = LINK.'registro';
			} else {
				$return = false;
				$return['text'] = 'Houve um erro! Tente novamente.';
			}
			break;

		case 'delete_calendar':

			$id = strip_tags($_POST['id']);

			if(!is_numeric($id)) { $return = array('success' => false, 'text' => 'Houve um erro! Atualize a página.'); break; }

			$a = new Agenda();
			$a->setIdMedico($_SESSION['logado']['id']);
			$a->setId($id);

			if($a->delete()) {
				$return['success'] = true;
				$return['location'] = LINK.'agenda';
			} else {
				$return = false;
				$return['text'] = 'Houve um erro! Tente novamente.';
			}

			break;

		case 'calendar':

			$data = strip_tags($_POST['data']);

			if(empty($data)) { $return = array('success' => false, 'text' => 'Campo Data e Hora não pode ser vazio!'); break; }

			$a = new Agenda();
			$a->setIdMedico($_SESSION['logado']['id']);
			$a->setData(date('Y-m-d H:i:s', strtotime($data)));
			if($a->save()) {
				$return['success'] = true;
				$return['location'] = LINK.'agenda';
			} else {
				$return = false;
				$return['text'] = 'Houve um erro! Tente novamente.';
			}


			break;

		case 'agendar':

			$id = strip_tags($_POST['id']);

			if(!is_numeric($id)) { $return = array('success' => false, 'location' => LINK.'agendamento'); break; }

			$a = new Agenda();
			$a->setId($id);
			$return['success'] = $a->agendar();
			$return['location'] = LINK.'agendamento';

			break;
	}
}

echo json_encode($return);

?>
