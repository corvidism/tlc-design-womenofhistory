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

<div id="wrapper" class="row">
	<header id="pagetitle" class="collumn small-12">
		<h1>
			<span id="subtitle">The Lucy Collective: </span>
			Women of History
		</h1>
	</header>
	
	<section role="search" id="search-box">
		<h2>Search</h2>		
		<form>
			<div class="row search-row minimized">
				<div class="small-12 columns">
					<p>Search where...</p>
					<p><em>anything</em> is <em>thing</em> <a href="">(change)</a></p>
				</div>
			</div>
			<div class="row collapse search-row" id="search-row-1">
				<div class="small-12 medium-3 columns">
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
				<div class="small-12 medium-2 columns no-label-col" id="search-mode-toggle">
					<div class="row">
						<div class="large-10 small-12 columns small-centered">
							<input type="radio" name="search_mode_1" value="is" id="search_is" checked><label for="search_is" id="label-search-mode-is" class="button small">is</label>
						    <input type="radio" name="search_mode_1" value="not" id="search_not"><label for="search_not" id="label-search-mode-not" class="button small">is NOT</label>
						</div>
					</div>
				</div>
				<div class="small-12 medium-5 columns no-label-col">
					<input type="text" placeholder="thing" />
				</div>
				<div class="small-12 medium-1 columns no-label-col">
					<a class="button postfix" href="" id="search-btn">Search</a>
				</div>
				<div class="small-12 medium-1 columns no-label-col">
					<a class="plus-query button postfix" href="" id="plus-query-1">+<span class="plus-query-text">&nbsp;add a parameter</span></a>					
				</div>
			</div>
			<div class="row collapse search-row">
				<div class="large-12 columns">
					<p><a href="">AND</a>/<a href="">OR</a></p>
				</div>
			</div>
			<div class="row collapse search-row added-row" id="search-row-2">
				<div class="small-12 medium-3 columns">
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
				<div class="small-12 medium-2 columns no-label-col" id="search-mode-toggle">
					<div class="row">
						<div class="large-10 small-12 columns small-centered">
							<input type="radio" name="search_mode_2" value="is" id="search_is" checked><label for="search_is" id="label-search-mode-is" class="button small">is</label>
						    <input type="radio" name="search_mode_2" value="not" id="search_not"><label for="search_not" id="label-search-mode-not" class="button small">is NOT</label>
						</div>
					</div>
				</div>
				<div class="small-12 medium-5 columns no-label-col">
					<input type="text" placeholder="thing" />
				</div>
				<div class="small-12 medium-1 columns no-label-col">
					<a class="button postfix" href="" id="search-btn">Search</a>
				</div>
				<div class="small-12 medium-1 columns no-label-col">
					<a class="plus-query button postfix" href="" id="plus-query-1">+<span class="plus-query-text">&nbsp;add a parameter</span></a>					
				</div>
			</div>
		</form>
</section>
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
				if ($year[0] == "-") {
					return substr($year,1,strlen($year))."BCE";
				} else {
					return $year."CE";
				}
				
				//don't echo empty year - if the second date is empty, echo only the first one
			}
			
			foreach($women as $index=>$item) {
			?>
				<li class="woman" id="woman-<?php $item['id']; ?>">
					<header>
						<h3><?php echo $item['name']; ?></h3>
						<span class="period" data-birth="<?php echo $item['date_born']; ?>" data-death="<?php echo $item['date_died']; ?>"><?php echo form_date($item['date_born'])." – ".form_date($item['date_died']); ?></span>	
					</header>
					<p class="tagline"><?php echo $item['tagline']; ?></p>
					<a href="">(more)</a>
					<footer>
						<ul>
							<li><a href="#">add to list</a></li>
							<li><a href="#">like</a></li>
							<li><a href="#">select</a></li>
							<li><a href="#">hide</a></li>
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