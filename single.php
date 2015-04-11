<?php
/*
 * SINGLE
 * 
 * single view of a woman
 * contains all from db (save some utility stuff like ids)
 * 
 */

require_once 'DataSource.php';
require_once 'sensitive.php'; //this goes from the folder this is run from, not from the one this file is in -_-
	
$dsn = "mysql:dbname=".DB_Name;
try {
   	$pdo = new PDO($dsn,DB_User,DB_Pass);
} catch(PDOException $e) {
    die('Could not connect to the database:<br/>' . $e);
}
$data_source = new DataSource($pdo); 
$id = $_GET['woman'];
$woman = $data_source->getWomanBy('id',$id);
//this should probably return an object Woman() with methods to echo values...

//if False, redirect to 404

//header settings:
$page = array(
	'title'=> $woman['name'],
);

require_once 'header.php';
?>

<article class="woman">
	<div class="portrait-img">
		<img src="women/images/<?php printf("%'.09d\n", $woman['id']) ?>_01.jpg" class="portrait" />	
	</div>
	
	<div class="inner">
		<h2><?php echo $woman['name']?></h2>
		<p class="dates">
			<span class="born"></span><span class="died"></span>
		</p>
		<p class="tagline"><?php echo $woman['tagline']; ?></p>
		<div class="specs">
			<p class="category"><?php echo $woman['category']; ?></p>
			<p class="tags"></p>
			<p class="ethnicity"></p>
			<p class="poc"><strong></strong>, <span class="ethnicity"></span></p>
			<p class="lgbt"><strong></strong>, <span class="gender_identity"></span></p>
			<p class="has_disability"><strong></strong>, <span class="disability"></span></p>	
		</div>
		
		<div class="story">
			<?php echo $woman['story']; ?>
		</div>
		
		<div class="successes">
			<ul class="awards">
				<li></li>
			</ul>
			<ul class="firsts">
				<li></li>
			</ul>
			<ul class="inventions">
				<li></li>
			</ul>
		</div>
		<div class="links">
			
		</div>
		<div class="in_lists">
			
		</div>
		
		
		<footer>
			Last edited by <a href="">annathecrow</a> on 23th March 2015.
		</footer>
	</div>
	
</article>


			
<?php
require_once 'footer.php';
?>


