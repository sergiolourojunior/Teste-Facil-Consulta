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
		$sql = 'SELECT * FROM medico';
		$sql.= is_numeric($this->id) ? " WHERE id :id" : '';

		$query = $this->conexao->prepare($sql);
		if(is_numeric($this->id)) $query->bindValue(':id', $this->id);
		$query->execute();

		if(is_numeric($this->id)) {
			$d = $sql->fetch(PDO::FETCH_OBJ);
			$this->nome = $d->nome;
			$this->email = $d->email;
			$this->senha = $d->senha;
			$this->endereco_consultorio = $d->endereco_consultorio;
			$this->data_criacao = $d->data_criacao;
			$this->data_alteracao = $d->data_alteracao;

			return $this;
		}

		return (object) $query->fetchAll(PDO::FETCH_OBJ);
	}

	public function save() {
		$check = $this->conexao->query("select id from medico where email = '{$this->email}'");

		if(!is_numeric($this->id) && $check->rowCount()==0) {
			$sql = $this->conexao->prepare('INSERT INTO medico (nome, email, senha, endereco_consultorio) VALUE (:nome, :email, :senha, :endereco_consultorio)');
		} elseif(is_numeric($this->id) && $check->rowCount()==1) {
			$sql = $this->conexao->prepare('UPDATE medico SET nome = :nome, email = :email, senha = :senha, endereco_consultorio = :endereco_consultorio WHERE id = :id');
			$sql->bindValue(':id', $this->id);
		} else {
			return false;
		}

		$sql->bindValue(':nome', $this->nome);
		$sql->bindValue(':email', $this->email);
		$sql->bindValue(':senha', $this->senha);
		$sql->bindValue(':endereco_consultorio', $this->endereco_consultorio);

		$sql->execute();

		$this->id = $this->conexao->lastInsertId();

		return $this;
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