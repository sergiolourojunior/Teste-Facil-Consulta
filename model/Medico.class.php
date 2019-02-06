<?php

class Medico extends Conexao {

	private $id;
	private $nome;
	private $email;
	private $senha;
	private $endereco_consultorio;
	private $data_criacao;
	private $data_alteracao;

	public function get() {
        try {
        	$sql = 'SELECT * FROM medico';
        	$sql.= is_numeric($this->id) ? " WHERE id = :id" : '';
            $sql.= ' ORDER BY nome ASC';

        	$query = $this->conexao->prepare($sql);
        	if(is_numeric($this->id)) $query->bindValue(':id', $this->id);
        	$query->execute();

        	if(is_numeric($this->id)) {
        		$d = $query->fetch(PDO::FETCH_OBJ);
        		$this->nome = $d->nome;
        		$this->email = $d->email;
        		$this->senha = $d->senha;
        		$this->endereco_consultorio = $d->endereco_consultorio;
        		$this->data_criacao = $d->data_criacao;
        		$this->data_alteracao = $d->data_alteracao;

        		return $this;
        	}

        	return (object) $query->fetchAll(PDO::FETCH_OBJ);
        } catch(Exception $e) {
            return $e->getMessage();
        }
	}

	public function save() {
        try {
    		$check = $this->conexao->query("select id from medico where email = '{$this->email}'");

    		if(!is_numeric($this->id) && $check->rowCount()==0) {
    			$sql = $this->conexao->prepare('INSERT INTO medico (nome, email, senha, endereco_consultorio) VALUE (:nome, :email, :senha, :endereco_consultorio)');
    		} elseif(is_numeric($this->id) && $check->rowCount()==1) {
                $_update=true;
                $sql = $this->conexao->prepare('UPDATE medico SET nome = :nome, endereco_consultorio = :endereco_consultorio WHERE id = :id');
    			$sql->bindValue(':id', $this->id);
    		} else {
    			return false;
    		}

    		$sql->bindValue(':nome', $this->nome);
    		if(!isset($_update)) $sql->bindValue(':email', $this->email);
    		if(!isset($_update)) $sql->bindValue(':senha', $this->senha);
    		$sql->bindValue(':endereco_consultorio', $this->endereco_consultorio);

    		$sql->execute();

    		$this->id = $this->conexao->lastInsertId();

    		return $this;
        } catch(Exception $e) {
            return $e->getMessage();
        }
	}

    public function delete(){
        try {
            if(!is_numeric($this->id)) return false;

            $sql = 'DELETE FROM medico where id = :id';
            $bd = $this->conexao->prepare($sql);
            $bd->bindValue(':id', $this->id);
            
            return $bd->execute();
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    public function login() {
        try {
            if(empty($this->email) || empty($this->senha)) return false;

            $sql = "SELECT * FROM medico WHERE email = :email AND senha = :senha";
            $bd = $this->conexao->prepare($sql);
            $bd->bindValue(':email', $this->email);
            $bd->bindValue(':senha', $this->senha);
            $bd->execute();

            if($bd->rowCount()==1) {
                $dados = $bd->fetch(PDO::FETCH_OBJ);
                $_SESSION['logado']['id'] = $dados->id;
                $_SESSION['logado']['nome'] = $dados->nome;
                $_SESSION['logado']['email'] = $dados->email;
                return true;
            }
            
            return false;
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    public function findByEmail() {
        try {
            if(empty($this->email)) return false;

            $sql = "SELECT id FROM medico WHERE email = '".$this->email."'";
            $bd = $this->conexao->query($sql);

            return ($bd->rowCount()>0);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    public function changePassword() {
        try {
            if(empty($this->senha)) return false;

            $sql = "UPDATE medico SET senha = :senha WHERE id = :id";
            $bd = $this->conexao->prepare($sql);
            $bd->bindParam(':senha', $this->senha);
            $bd->bindParam(':id', $this->id);

            return $bd->execute();
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     *
     * @return self
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     *
     * @return self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSenha()
    {
        return $this->senha;
    }

    /**
     * @param mixed $senha
     *
     * @return self
     */
    public function setSenha($senha)
    {
        $this->senha = md5($senha.HASH);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEnderecoConsultorio()
    {
        return $this->endereco_consultorio;
    }

    /**
     * @param mixed $endereco_consultorio
     *
     * @return self
     */
    public function setEnderecoConsultorio($endereco_consultorio)
    {
        $this->endereco_consultorio = $endereco_consultorio;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDataCriacao()
    {
        return $this->data_criacao;
    }

    /**
     * @param mixed $data_criacao
     *
     * @return self
     */
    public function setDataCriacao($data_criacao)
    {
        $this->data_criacao = $data_criacao;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDataAlteracao()
    {
        return $this->data_alteracao;
    }

    /**
     * @param mixed $data_alteracao
     *
     * @return self
     */
    public function setDataAlteracao($data_alteracao)
    {
        $this->data_alteracao = $data_alteracao;

        return $this;
    }
}

?>