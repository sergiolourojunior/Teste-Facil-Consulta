<?php

class Agenda extends Conexao {

	private $id;
	private $id_medico;
	private $data;
	private $agendado;

	public function get() {
		try {
			$sql = "SELECT * FROM agenda";
			if(is_numeric($this->id_medico)) $sql.= " WHERE id_medico = :id_medico";
			$sql.= " ORDER BY data ASC";

			$bd = $this->conexao->prepare($sql);
			if(is_numeric($this->id_medico)) $bd->bindValue(':id_medico', $this->id_medico);
			$bd->execute();

			return (object) $bd->fetchAll(PDO::FETCH_OBJ);
		} catch(Exception $e) {
			return $e->getMessage();
		}
	}

    public function save() {
        try {
            if(!is_numeric($this->id_medico)) return false;
            if(empty($this->data)) return false;

            $check = $this->conexao->query("SELECT id FROM agenda WHERE id_medico = ".$this->id_medico." AND data = '".$this->data."'");

            if($check->rowCount()==0) {
                $sql = "INSERT INTO agenda (id_medico, data) VALUES (:id_medico, :data)";
                $bd = $this->conexao->prepare($sql);
                $bd->bindValue(':id_medico', $this->id_medico);
                $bd->bindValue(':data', $this->data);
                return $bd->execute();
            }

            return false;
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

	public function delete() {
		try {
            if(!is_numeric($this->id)) return false;
			if(!is_numeric($this->id_medico)) return false;
			
			$sql = "DELETE FROM agenda WHERE id = :id AND id_medico = :id_medico AND agendado = 0";
			$bd = $this->conexao->prepare($sql);
            $bd->bindValue(':id', $this->id);
			$bd->bindValue(':id_medico', $this->id_medico);
			
			return $bd->execute();
		} catch(Exception $e) {
			return $e->getMessage();
		}
	}

	public function agendar() {
		try {
			if(!is_numeric($this->id)) return false;

			$check = $this->conexao->query("SELECT id FROM agenda WHERE agendado = 0 AND id = {$this->id}");
			if($check->rowCount()==0) return false;

			$sql = "UPDATE agenda SET agendado = 1 WHERE agendado = 0 AND id = :id";
			$bd = $this->conexao->prepare($sql);
			$bd->bindValue(':id', $this->id);

			return $bd->execute();
		} catch(Exception $e) {
			return $e->getMessage();
		}
	}

    public function getCalendar() {
        try {
            if(!is_numeric($this->id_medico)) return false;

            $sql = "SELECT DISTINCT(DATE_FORMAT(data, '%Y-%m-%d')) as date FROM agenda WHERE id_medico = :id_medico";
            $bd = $this->conexao->prepare($sql);
            $bd->bindValue(':id_medico', $this->id_medico);
            $bd->execute();

            $datas = $bd->fetchAll(PDO::FETCH_ASSOC);

            foreach($datas as $k=>$d) {
                $data_temp = date('Y-m-d', strtotime($d['date']));
                $sql_horarios = "SELECT *, DATE_FORMAT(data, '%H:%i') as hora FROM agenda WHERE DATE_FORMAT(data, '%Y-%m-%d') = '".$data_temp."' AND id_medico = ".$this->id_medico;
                $bd_horarios = $this->conexao->query($sql_horarios);

                $datas[$k]['horarios'] = $bd_horarios->fetchAll(PDO::FETCH_OBJ);
            } 

            return $datas;

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
    public function getIdMedico()
    {
        return $this->id_medico;
    }

    /**
     * @param mixed $id_medico
     *
     * @return self
     */
    public function setIdMedico($id_medico)
    {
        $this->id_medico = $id_medico;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     *
     * @return self
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAgendado()
    {
        return $this->agendado;
    }

    /**
     * @param mixed $agendado
     *
     * @return self
     */
    public function setAgendado($agendado)
    {
        $this->agendado = $agendado;

        return $this;
    }
}

?>