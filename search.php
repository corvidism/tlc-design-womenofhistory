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
	'id' => 'search',
);
require_once 'header.php';
require_once 'functions.php';
require_once 'DataSource.php';
require_once 'sensitive.php'; //this goes from the folder this is run from, not from the one this file is in -_-
	
$data_source = new DataSource(); 
$women = $data_source->getAllWomen();

?>

<!-- TODO: add this with javascript - it won't run on anything that doesn't use JS anyway, and it takes space in HTML-only -->

	<section role="search" id="search-box" class="medium-5 large-4 columns">
		<form id="searchform">
			<label>Search where</label>
			<div class="search-query" id="search-query-1">
				<div class="select">
				<select name="what">
								<option value="any">her anything</option>
								<option value="name">her name</option>
								<option value="place_born">her place of birth</option>
								<option value="place_died">her place of death</option>
								<option value="date_born">her date of birth</option>
								<option value="date_died">her date of death</option>
								<option value="inventions">her inventions</option>
								<option value="firsts">her firsts</option>
								<option value="story">her story</option>
								<option value="tags">her tags</option>
								<option value="category">her category</option>
								<option value="links">her links</option>
								<option value="ethnicity">her ethnicity</option>
			</select>
			</div>
			<div class="select">
			<select name="strict">
				<option value="no">contains</option>
				<option value="yes">equals</option>
			</select>
			</div>
			<input type="text" name="any" autocomplete="off" placeholder="short to medium input string">
			</div>
			<label id="last-and">and... <a id="add-query" href="">(+)</a></label>
			<div class="right"><a id="search-submit" href="">search</a></div>
			
		</form>
	</section>		
	<div id="list-box" class="medium-7 large-8 columns">
		<div id="list-sort-controls" class="row">
			<div id="list-actions" class="small-12 medium-6 columns">
				<ul>
					<li><a href="" id="select-all">select all</a>&nbsp;–&nbsp;</li>
					<li><a href=""id="select-none">select none</a>&nbsp;–&nbsp;</li>
					<li><a href="" id="add-to-list">add to list</a></li>
				</ul>
			</div>
			<div id="sort-actions" class="small-12 medium-6 columns">
				<label>order by:</label>
				<div class="select">
					<select name="order-by">
					<option value="added">date added</option>
					<option value="alphabet">name</option>
					<!--<option value="alphabet">last name</option>-->
					<option value="period">time period</option>
					</select> 
				</div>&nbsp;–&nbsp;
				<div class="select sort active">
				<select name="sort-added">
					<option value="desc">last to first</option>
					<option value="asc">first to last</option>
				</select>
				</div>
				<div class="select sort">
				<select name="sort-alphabet">
					<option value="asc">A to Z</option>
					<option value="desc">Z to A</option>
				</select>
				</div>
				<div class="select sort">
				<select name="sort-period">
					<option value="desc">youngest to oldest</option>
					<option value="asc">oldest to youngest</option>	
				</select>
				</div>
			</div>
		</div>
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
			
			
			foreach($women as $index=>$woman) {
				//name
			?>
				<li class="woman row" id="woman-<?php echo $woman['id']; ?>">
					<header class="small-12 columns">
						<h3 class=""><a href="single.php?woman=<?php echo $woman['id']; ?>"><?php echo $woman['name']; ?></a></h3>
					</header>
					<div class="woman-top medium-7 large-6 columns">
						<!--<div class="portrait"><img src="women/images/000000005.jpg"></div>
							
						<span class="period" data-birth="<?php echo $woman['date_born']; ?>" data-death="<?php echo $woman['date_died']; ?>"><?php echo form_date($woman['date_born'])." – ".form_date($woman['date_died']); ?></span>
							-->
					
					<p class="tagline"><?php echo $woman['tagline']; ?> <a href="single.php?woman=<?php echo $woman['id']; ?>">(...)</a></p>
					
					</div>
					<div class="specs small-12 medium-5 large-3 columns">
						<ul>
						<li><span class="period" data-birth="<?php echo $woman['date_born']; ?>" data-death="<?php echo $woman['date_died']; ?>"><?php echo form_date($woman['date_born'])." – ".form_date($woman['date_died']); ?></span></li>
						<li class="category"><a href="search.php?category=<?php echo $woman['category']['id']; ?>"><?php echo $woman['category']['title']; ?></a></li>
						<?php
							if ($woman['is_poc']) {
								echo '<li class="is_poc"><strong><a href="search.php?is_poc=1">woman of color</a></strong></li>';
							}
							
							if ($woman['is_queer']) {
								echo '<li><strong><a href="search.php?is_queer=1">LGBTQ</a></strong></li>';
								//echo gender and sex.id
							}
							if ($woman['has_disability']) {
								echo '<li><strong><a href="search.php?has_disability=1">woman with disability</a></strong></li>';
								//echo dis
							}
						?>						
					</ul>
					</div>
					<div class="tags small-12 medium-6 large-3 columns">
						<?php
						$tags = explode(",",$woman['tags']);
						$taglinks = array();
						foreach($tags as $tag) {
							$taglinks[] = '<a href="search.php?tags='.$tag.'">'.$tag.'</a>';
						}
						echo implode(", ",$taglinks);
				?>
					</div>
					<footer class="large-6 columns">						
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