<?php
/*
 * LIST SEARCH
 * 
 * listing of lists
 * search by title, creator, woman contained, description, tags
 * sort by time, title, creator 
 */

//header settings:
$page = array(
	'title'=> 'User Lists',
);
require_once 'header.php';

require_once 'functions.php';
require_once 'DataSource.php';
	
$data_source = new DataSource(); 

$lists = $data_source->getAllLists();
?>

<section role="search" id="search-box" class="medium-5 large-4 columns">
		<form id="searchform" method="GET">
			<span>Search where</span>
			<div class="search-query" id="search-query-1">
				<div class="select">
				<select name="field">
								<option value="any">list title</option>
								<option value="name">list tagline</option>
								<option value="place_born">list description</option>
								<option value="place_died">list comments</option>								
			</select>
			</div>
			<div class="select">
			<select name="strict">
				<option value="no">contains</option>
				<option value="yes">contains precisely</option>
			</select>
			</div>
			<input type="text" class="field-input" name="value" autocomplete="off" placeholder="something">
			</div>
			
			<div class="right"><button id="submit-button" type="submit">Search</button></div>
			
		</form>
		
	</section>		
	<div id="list-box" class="medium-7 large-7 columns">
	</div>


<?php
require_once 'footer.php';
?>