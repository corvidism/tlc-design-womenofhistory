<?php
/*
 * USER LIST
 * 
 * contains:
 * 
 * title
 * cover image
 * description
 * owner
 * list of women (similar to search.php)
 * -- drag&drop (on default - position is 0; when list is rearranged by drag&drop, the positions are saved into db)
 * -- comment (why is this woman in this list)
 */

require_once 'DataSource.php';
require_once 'sensitive.php'; //this goes from the folder this is run from, not from the one this file is in -_-
require_once 'functions.php';

	

$data_source = new DataSource(); 
$id = $_GET['id'];
$list = $data_source->getListById($id);
 
//header settings:
$page = array(
	'title'=> $list['title'],
);

require_once 'header.php';
?>

<?php
require_once 'footer.php';
?>