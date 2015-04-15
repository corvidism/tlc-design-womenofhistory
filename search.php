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

<!-- TODO: add this with javascript - it won't run on anything that doesn't use JS anyway, and it takes space in HTML-only -->

	<section role="search" id="search-box">
		<h2>Search</h2>		
		<form>
			<ol>
				<!--
				<li class="row collapse search-row minimized" id="search-row-2">
					<div class="small-12 medium columns">
						<label>Search where...</label>
						<p><em>anything</em> is <em>thing</em> <a href="">(change)</a></p>
					</div>					
				</li>
				-->
				<li class="row collapse search-row" id="search-row-2">
					<div class="small-10 medium-4 columns">
						<label class="explanatory">Search where...</label>
							<select>
								<option value="any">anything</option>
								<option value="name">name</option>
								<option value="place_born">place of birth</option>
								<option value="place_died">place of death</option>
								<option value="date_born">date of birth</option>
								<option value="date_died">date of death</option>
								<option value="inventions">inventions</option>
								<option value="firsts">firsts</option>
								<option value="story">story</option>
								<option value="tags">tags</option>
								<option value="category">category</option>
								<option value="links">links</option>
								<option value="ethnicity">ethnicity</option>
							</select>
						
					</div>
					<div class="small-2 medium-1 columns no-label-col">
						<p class="mode-toggle centered">is</p>
					</div>
					<div class="small-12 medium-5 columns no-label-col">
						<input type="text" placeholder="thing" />
					</div>
					<div class="small-12 medium-2 columns no-label-col">
							<p class="logic-toggle centered"><a href="" class="selected">and</a>/<a href="">or</a></p>
					</div>
				</li>
				<li class="row collapse search-row added-row" id="search-row-3">
					
					<div class="small-10 medium-4 columns">
						<label class="explanatory">Search where...</label>
							<select>
								<option value="any">anything</option>
								<option value="name">name</option>
								<option value="place_born">place of birth</option>
								<option value="place_died">place of death</option>
								<option value="date_born">date of birth</option>
								<option value="date_died">date of death</option>
								<option value="inventions">inventions</option>
								<option value="firsts">firsts</option>
								<option value="story">story</option>
								<option value="tags">tags</option>
								<option value="category">category</option>
								<option value="links">links</option>
								<option value="ethnicity">ethnicity</option>
							</select>
						
					</div>
					<div class="small-2 medium-1 columns no-label-col">
						<p class="mode-toggle centered">is</p>
					</div>
					<div class="small-12 medium-5 columns no-label-col">
						<input type="text" placeholder="thing" />
					</div>
					<div class="small-12 medium-1 columns no-label-col">
						<a class="button postfix" href="" id="search-btn">Search</a>
					</div>
					<div class="small-12 medium-1 columns no-label-col">
						<a class="plus-query last button postfix" href="">+<span class="plus-query-text">&nbsp;add a parameter</span></a>					
					</div>
				</li>
			</ol>
			<div>
				Sort by:<br><br>
			</div>
			<div>
				add search to list:<br>
				select all<br>
				deselect all<br>
				add selected to list:<br>
				
			</div>
		</form>
		
		
</section>
	<form id="searchline">
			Search where <select><option>this</option><option>that</option></select> is <input type="text">. <br>(add search parameter)
		</form>
		
		<form id="searchline2">
			<p>Search where <span>something</span> is&nbsp;</p>
			<p> <span>something</span>.</p>
				
			<span class="addp">(add search parameter)</span>
			<ul>
				<li>test 0</li>
				<li class="one">test 1</li>
				<li class="two">test 2</li>
				<li class="three">test 3</li>
				<li class="four">test 4</li>
				<li class="five">test 5</li>
			</ul>
		</form>
	<div id="list-box">
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
				if (isset($year[0]) && $year[0] == "-") {
					return substr($year,1,strlen($year))."BCE";
				} else {
					return $year."CE";
				}
				
				//don't echo empty year - if the second date is empty, echo only the first one
			}
			
			
			foreach($women as $index=>$item) {
				error_log($item['id']);
			?>
				<li class="woman" id="woman-<?php echo $item['id']; ?>">
					<header>
						<h3><a href="single.php?woman=<?php echo $item['id']; ?>"><?php echo $item['name']; ?></a></h3>
						<span class="period" data-birth="<?php echo $item['date_born']; ?>" data-death="<?php echo $item['date_died']; ?>"><?php echo form_date($item['date_born'])." – ".form_date($item['date_died']); ?></span>	
					</header>
					<p class="tagline"><?php echo $item['tagline']; ?></p>
					<footer>
						<ul class="action-buttons" class="row collapse">
							<li class="small-3 columns"><a href="#" class="select">select</a></li>
							<li class="small-6 columns"><a href="#" class="add-to-list">add to list:</a></li>
							<li class="small-3 columns"><a href="" class="more">(more)</a></li>
						</ul>
					</footer>
				</li>
			<?php	
			} #end of foreach			
			?>
		</ol>
		<div class="pagination-centered">
			<ul class="pagination">
				<li class="arrow unavailable"><a href="">&laquo;</a></li>
				<li class="current"><a href="">1</a></li>
				<li><a href="">2</a></li>
				<li><a href="">3</a></li>
				<li><a href="">4</a></li>
				<li class="arrow"><a href="">&raquo;</a></li>
			</ul>
		</div>
		
	</div>
	<footer id="pagefooter">
			
		</footer>
</div>
<?php

require_once 'footer.php';
?>