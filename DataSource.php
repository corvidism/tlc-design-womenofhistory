<?php
ini_set('log_errors',1);
if ($_SERVER['SERVER_NAME']=='thelucycollective.com') {
	ini_set('error_log','./php_errors.log');
}


require_once '../../sensitive/db_data.php';

class DataSource 
{
	private $data;
	private $db;
	private $db_calls;
	
	public function __construct() {
		$this->data = Array();
		$this->db_calls = Array();
		
		
		$dsn = "mysql:dbname=".DB_Name.";host=".DB_Host;
		try {
		   	$pdo = new PDO($dsn,DB_User,DB_Pass);
		} catch(PDOException $e) {
		    die('Could not connect to the database:<br/>' . $e);
		}		
		$this->db = $pdo;
	}
	
	private function setupCall($title,$query) {
		if (!isset($this->db_calls[$title]) || !$this->db_calls[$title] instanceof PDOStatement) {
			$this->db_calls[$title] = $this->db->prepare($query);	
		}
	}
	
	public function getAllWomen() {
		if (!isset($this->db_calls['women']) || !$this->db_calls['women'] instanceof PDOStatement) {
			$columns_needed = array(
				'id',
				//'last_edited_at',
				//'created_at',
				//'last_edited_by',
				//'created_by',
				'name',
				'category',
				'date_born',
				'date_died',
				//'place_born',
				//'place_died',
				//'inventions',
				//'firsts',
				'tagline',
				//'story',
				'orientation',
				'gender_identity',
				'is_poc',
				'is_queer',
				'ethnicity',
				'has_disability',
				'disability',
				'tags',
			);
			$query_str = "SELECT ".implode(",",$columns_needed)." FROM `women`";
			$this->db_calls['women'] = $this->db->query($query_str);			
		}
		$women = $this->db_calls['women']->FetchAll();
		
		$cat_ids = array_column($women,'category');
		$query_str = "SELECT * FROM `categories` WHERE id IN (".implode(",",$cat_ids).")"; 
		$this->db_calls['cats_tmp']= $this->db->query($query_str);
		$cat_result = $this->db_calls['cats_tmp']->FetchAll();
		$categories = array();
		foreach ($cat_result as $cat) {
			$categories[$cat['id']] = $cat;
		};
		foreach($women as $id=>$woman) {
			$women[$id]['category']= $categories[$woman['category']];
			
		};
		//logme('$women outside the loop: ');
		//logme($women);
		$this->data['women'] = $women; 
		//logme($this->data['women']);
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
		
		//$this->setupCall('tags',"SELECT tags.id,tags.title FROM tags, tag_woman WHERE (tag_woman.her_id=? and tags.id=tag_woman.tag_id)");
		//$this->db_calls['tags']->bindValue(1,$woman['id']);
		//$this->db_calls['tags']->execute();
		//$tags = $this->db_calls['tags']->FetchAll();
		//$woman['tags'] = array_column($tags, 'title', 'id');
		//get awards
		
		return $woman;		
	}
	
	public function getLinksByWoman($her_id) {
		if (is_nan($her_id)) return false;
		$this->setupCall('links',"SELECT id, title,url,description, is_authored FROM links WHERE (her_id=?)");
		$this->db_calls['links']->bindValue(1,$her_id);
		$this->db_calls['links']->execute();
		$links = $this->db_calls['links']->FetchAll();
		return $links;
	}

	public function getPublicListsByWoman($her_id) {
		if (is_nan($her_id)) return false;
		$this->setupCall('her_lists',"SELECT lists.id, lists.title,lists.created_by,lists.description FROM lists, list_woman WHERE (list_woman.her_id=? and lists.id=list_woman.list_id and lists.private=0)");
		$this->db_calls['her_lists']->bindValue(1,$her_id);
		$this->db_calls['her_lists']->execute();
		$lists = $this->db_calls['her_lists']->FetchAll();
		return $lists;
	}
	
	public function getListById($id) {
		if (is_nan($id)) return false;
		$this->setupCall('list',"SELECT * FROM lists WHERE (id=?)");
		$this->db_calls['list']->bindValue(1,$id);
		$this->db_calls['list']->execute();
		$list = $this->db_calls['list']->Fetch();
		return $list;
	}
}

?>