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
<article id="user-list">
	<h2><?php echo $list['title']; ?></h2>
	<img src="" class="list-cover">
	<div class="list-desc">
		<?php echo $list['description']; ?>
	</div>
	<ol class="list-women">
		<li></li>
	</ol>
	<div>
		<h3>Similar lists</h3>
	</div>
	
	
</article>
<?php
require_once 'footer.php';
?>