<?php
/*
 * WOMEN SEARCH
 * 
 * listing of women
 * = main page
 * 
 */

//header settings:
$page = array(
	'title'=> 'Search',
);
require_once 'header.php';
 
require_once 'DataSource.php';
require_once 'sensitive.php'; //this goes from the folder this is run from, not from the one this file is in -_-
	
$dsn = "mysql:dbname=".DB_Name;
try {
   	$pdo = new PDO($dsn,DB_User,DB_Pass);
} catch(PDOException $e) {
    die('Could not connect to the database:<br/>' . $e);
}
$data_source = new DataSource($pdo); 
$women = $data_source->getAllWomen();



?>
<canvas id="header-graphics">	
</canvas>

<div id="wrapper" class="row">
	<header id="pagetitle" class="collumn large-12">
		<h1>
			<span id="subtitle">The Lucy Collective: </span>
			Women of History
		</h1>
	</header>
	
	<section role="search" id="search-box">
		<h2>Search</h2>
		<form>
			
		</form>			
	</section>
	<div id="list-box" class="collumn large-12">
		<h2>Results</h2>
		<ol>
			<?php
			
			define("D_FORMAT","");
			
			function form_date($date) {
				//stupid formatting shiv. should be done somewhere else, not sure where tho. On db load?
				
				
				
				$date_array = explode("/", $date);
				
				//see if the format is "*/00/00" - if so, strip the last part, it's just a year.
				//if not, turn this into a proper PHP date, then use PHP formatting to spit it out properly
				
				$year = $date_array[0];
				if ($year[0] == "-") {
					return substr($year,1,strlen($year))."BCE";
				} else {
					return $year."CE";
				}
				
				//don't echo empty year - if the second date is empty, echo only the first one
			}
			
			foreach($women as $index=>$item) {
			?>
				<li class="w-item" id="woman-<?php $item['id']; ?>">
					<h3><?php echo $item['name']; ?></h3>
					<span class="period" data-birth="<?php echo $item['date_born']; ?>" data-death="<?php echo $item['date_died']; ?>"><?php echo form_date($item['date_born'])." – ".form_date($item['date_died']); ?></span>
					<p class="tagline"><?php echo $item['tagline']; ?></p>
				</li>
			<?php	
			} #end of foreach			
			?>
		</ol>
	</div>
	<footer id="pagefooter">
			
		</footer>
</div>
<?php

require_once 'footer.php';
?>