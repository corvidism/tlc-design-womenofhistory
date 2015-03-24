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
<div id="search-box">
				
			</div>
			<div id="list-box" class="collumn large-12">
				<ul>
					<?php
					
					define("D_FORMAT","");
					
					function form_date($dateformat,$date) {
						#TODO replace this by proper date function!
						
						if ($date < 0) {
							return abs($date)."BCE";
						} else {
							return abs($date)."CE";
						}
					}
					
					foreach($women as $index=>$item) {
					?>
						<li class="w-item" id="<?php $index; ?>">
							<h3><?php echo $item['name']; ?></h3>
							<span class="period" data-birth="<?php echo $item['date_born']; ?>" data-death="<?php echo $item['date_died']; ?>"><?php echo form_date(D_FORMAT,$item['date_born'])." – ".form_date(D_FORMAT,$item['date_died']); ?></span>
							<p class="tagline"><?php echo $item['tagline']; ?></p>
						</li>
					<?php	
					} #end of foreach			
					?>
				</ul>
			</div>
<?php

require_once 'footer.php';
?>