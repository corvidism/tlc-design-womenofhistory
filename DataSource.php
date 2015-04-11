<?php

class DataSource 
{
	private $data;
	private $db_pdo;
	private $db_calls;
	
	public function __construct($pdo_connection) {
		$this->data = Array();
		$this->db_calls = Array();
		$this->db = $pdo_connection;
		//establish a db connection
		//load data
	}
	
	public function getAllWomen() {
		if (!isset($this->db_calls['women']) || !$this->db_calls['women'] instanceof PDOStatement) {
			$this->db_calls['women'] = $this->db->query("SELECT * FROM `women`");	
		}
		
		$this->data['women'] = $this->db_calls['women']->FetchAll();
		return $this->data['women'];
	}
	
	public function getWomanBy($what,$value) {
		if ($what = 'id') {
			return $this->getWomanById($value);
		}
	}
	
	public function getWomanById($id) {
		if (is_nan($id)) return false;
		if (!isset($this->db_calls['single']) || !$this->db_calls['single'] instanceof PDOStatement) {
			$this->db_calls['single'] = $this->db->prepare("SELECT * FROM `women` WHERE `id` = ?");	
		}
		$this->db_calls['single']->bindValue(1,$id);
		$this->db_calls['single']->execute();
		$woman = $this->db_calls['single']->Fetch();
		//get category title
		//get tags 
		//get awards
		
		return $woman;		
	}
}

?>