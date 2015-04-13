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
	
	private function setupCall($title,$query) {
		if (!isset($this->db_calls[$title]) || !$this->db_calls[$title] instanceof PDOStatement) {
			$this->db_calls[$title] = $this->db->prepare($query);	
		}
	}
	
	public function getAllWomen() {
		if (!isset($this->db_calls['women']) || !$this->db_calls['women'] instanceof PDOStatement) {
			$this->db_calls['women'] = $this->db->query("SELECT * FROM `women`"); 
			//TODO: load only necessary columns (e.g. not 'story' when on search.php);
				
		}		
		$this->data['women'] = $this->db_calls['women']->FetchAll();
		
		//future: this should return an array of Woman objects. 
		//related to above: how to deal with incomplete records?
		//should Woman do its own db queries? (probably not.) but what then?
		return $this->data['women'];
	}
	
	public function getWomanBy($what,$value) {
		if ($what = 'id') {
			return $this->getWomanById($value);
		}
	}
	
	public function getCategoryById($id) {
		if (is_nan($id)) return false;
		$this->setupCall('category',"SELECT * FROM `categories` WHERE `id` = ? LIMIT 1");
		$this->db_calls['category']->bindValue(1,$id);
		$this->db_calls['category']->execute();
		$category = $this->db_calls['category']->Fetch();
		return $category;
	}
	
	
	
	public function getWomanById($id) {
		if (is_nan($id)) return false;
		$this->setupCall('single',"SELECT * FROM `women` WHERE `id` = ? LIMIT 1");
		$this->db_calls['single']->bindValue(1,$id);
		$this->db_calls['single']->execute();
		$woman = $this->db_calls['single']->Fetch();
		$woman['category']=$this->getCategoryById($woman['category']); //is it okay to overwrite like this?
		
		$this->setupCall('tags',"SELECT tags.id,tags.title FROM tags, tag_woman WHERE (tag_woman.her_id=? and tags.id=tag_woman.tag_id)");
		$this->db_calls['tags']->bindValue(1,$woman['id']);
		$this->db_calls['tags']->execute();
		$tags = $this->db_calls['tags']->FetchAll();
		$woman['tags'] = array_column($tags, 'title', 'id');
		//get awards
		
		return $woman;		
	}
	
	public function getLinksByWoman($her_id) {
		if (is_nan($id)) return false;
		$this->setupCall('links',"SELECT id, title,url,description, is_authored FROM links WHERE (her_id=?)");
		$this->db_calls['links']->bindValue(1,$her_id);
		$this->db_calls['links']->execute();
		$links = $this->db_calls['links']->FetchAll();
		return $links;
	}

	public function getPublicListsByWoman($her_id) {
		if (is_nan($id)) return false;
		$this->setupCall('lists',"SELECT lists.id, lists.title,lists.created_by,lists.description FROM lists, list_woman WHERE (list_woman.her_id=? and lists.id=list_woman.list_id and lists.private=0)");
		$this->db_calls['lists']->bindValue(1,$her_id);
		$this->db_calls['lists']->execute();
		$lists = $this->db_calls['lists']->FetchAll();
		return $lists;
	}
}

?>