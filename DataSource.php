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
	private $display_cols;
	
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
		
		$this->display_cols = array(
				'id',
				//'last_edited_at',
				//'created_at',
				//'last_edited_by',
				//'created_by',
				'name',
				'category',
				'date_born',
				'date_died',
				'place_born',
				'place_died',
				'inventions',
				'firsts',
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
	}
	
	private function quoteField($field) {
    return "`".str_replace("`","``",$field)."`";
	}
	
	private function setupCall($title,$query) {
		if (!isset($this->db_calls[$title]) || !$this->db_calls[$title] instanceof PDOStatement) {
			$this->db_calls[$title] = $this->db->prepare($query);	
		}
	}
	
	public function getAllWomen() {
		if (!isset($this->db_calls['women']) || !$this->db_calls['women'] instanceof PDOStatement) {
			$columns_needed = $this->display_cols;
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
	
	
	public function getWomen($params) {
		//logme($params);
		$field = $params['field'];
		$value = $params['value'];
		$strict = ($params['strict']=='yes')?true:false;
		$nonpriv_groups = $params['nonpriv_groups'];
		
		$columns_needed = $this->display_cols;
		
		$searchable_cols = array(
				//'id',
				//'last_edited_at',
				//'created_at',
				//'last_edited_by',
				//'created_by',
				'name',
				'category',
				'date_born',
				'date_died',
				'place_born',
				'place_died',
				'inventions',
				'firsts',
				'tagline',
				'story',
				'orientation',
				'gender_identity',
				'ethnicity',
				'disability',
				'tags',
		);
		//this is BAAAAAD. TODO: Some optimalization needed.
		
		//multidimensional array: 'colname' 'returned y/n' 'searched y/n'
		
		if ($field == 'any') {
			$search_cols = $searchable_cols;
		} else {
			$key = array_search($field, $searchable_cols);
			if ($key === false) {
				throw new Exception('Wrong field name');
			} else {
				$search_cols = array($searchable_cols[$key]); //the only el in the array is the field
			}
		}	
		$results = array();
		foreach ($search_cols as $search_col) {
			$quoted_col = $this->quoteField($search_col);
			if ($strict) {
				$field_part = $quoted_col." LIKE :value";
				$query_str = "SELECT ".implode(",",$columns_needed)." FROM `women` WHERE ".$field_part;
				$this->db_calls['search_women'] = $this->db->prepare($query_str);
				$this->db_calls['search_women']->bindValue(":value","%".$value."%");
				//WRONG BEHAVIOR. On strict, it should match whole words only, not parts. Solution: REGEXP, FULLTEXT indexing the table, ? 						
			} else {
				$value = addslashes($value);
				$words = preg_split('/\W/', $value);
				$v_array = array();
				foreach ($words as $word) {
					$v_array[]=$quoted_col." LIKE (:value)";
				};
				$field_part = implode(" AND ",$v_array);
				$query_str = "SELECT ".implode(",",$columns_needed)." FROM `women` WHERE ".$field_part;
				$this->db_calls['search_women'] = $this->db->prepare($query_str);
				$this->db_calls['search_women']->bindValue(":value","%".$value."%");
				
			};
			
			$this->db_calls['search_women']->execute();
			if ($this->db_calls['search_women']->rowCount()>0) {
				$results[$search_col] = $this->db_calls['search_women']->FetchAll();
				
			} else {
				return null;
			}; 			
		}
		
		
		//merge results:
		$women = array_unique(call_user_func_array("array_merge", $results),SORT_REGULAR);
		//future: possibly signalize in what column it was found?
		
		if (!is_null($nonpriv_groups)) {
			foreach ($women as $index=>$woman) {
				$matched = false;
				if (in_array('is_poc', $nonpriv_groups)) {
					$matched = ($woman['is_poc'] == '1' || $woman['is_poc'] == 'on'); 
					//logme("matching is_poc");
				}
				if (in_array('is_queer', $nonpriv_groups)) {
					$matched = ($woman['is_queer'] == '1' || $woman['is_queer'] == 'on');
					//logme("matching is_queer"); 
				}
				if (in_array('has_disability', $nonpriv_groups)) {
					$matched = ($woman['has_disability'] == '1' || $woman['has_disability'] == 'on');
					//logme("matching has_disability"); 
				}
				if (!$matched) {
					unset($women[$index]);
				}
			}			
		}
		
		if (empty($women)) {
			return null;
		} else {
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
			
			return $women;
		} 
	}

	public function getWomenByList($list_id) {
		if (is_nan($list_id)) return false;
		$query="select ".implode(",",$this->display_cols).",list_woman.description from women,list_woman where id=list_woman.her_id and list_woman.list_id=?";	
		$this->setupCall('women_by_list', $query);
		$this->db_calls['women_by_list']->bindValue(1,$list_id);
		$this->db_calls['women_by_list']->execute();
		
		if ($this->db_calls['women_by_list']->rowCount()>0) {
			$women = $this->db_calls['women_by_list']->FetchAll();
			
		}; //else do nothing
		
		if (empty($women)) {
			return null;
		} else {
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
			
			return $women;
		} 
		
		
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
	
	
	public function getAllPublicLists() {
		$this->setupCall('all_lists',"SELECT * FROM lists");
		$this->db_calls['all_lists']->execute();
		$lists = $this->db_calls['all_lists']->FetchAll();
		return $lists;
	}
}

?>