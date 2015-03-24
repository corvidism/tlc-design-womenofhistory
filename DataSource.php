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
}

?>