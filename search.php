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
	
$data_source = new DataSource(); 


/*
 * query:
 * any=%S
 * name=%S
 * place_born=%S
 * place_died=%S
 * date_born
 * date_died
 * inventions=%S
 * firsts=%S
 * story=%S
 * tags=%S,%S
 * category=%S
 * links=%S
 * ethnicity=%S
 * is_poc=%B
 * has_disability=%B
 * is_queer=%B
 * 
 * glue char=","
 * equals: "this is string" --> any=this%20is%20string
 * contains: "this is string" --> any=this,is,string
 * 
 * and: --> "this is "
 * 
 * 
 * orderby=%S
 * sort=%S
*/

/* what to do:
 * get query
 * (format query?)
 * pass the query to DataSource
 * get only selected women  
 */
/*
$params = array(
	'any'=>'',
	'name' =>'',
	'place_born'=>'',
	'place_died'=>'',
	'date_born'=>'',
	'date_died'=>'',
	'inventions'=>'',
	'firsts'=>'',
 	'story'=>'',
 	'tags'=>'', // 'that,this,else'
 	'category'=>'',
 	'links'=>'',
 	'ethnicity'=>'',
 	'is_poc'=>'',
 	'has_disability'=>'',
 	'is_queer'=>'',
 	'logic'=>'', //	'1||2&&3'
 	'strict'=>'' // '1,0,0'
);

if (isset($_GET['field'])) {
	$params[$_GET['field']]=$_GET['value'];
	if (isset($_GET['strict'])&&$_GET['strict']=='yes') {
		$params['strict']='1';
	}	
}
*/
//the above - future question: how to combine multiple queries?
$query = array();
$query['field'] = (isset($_GET['field']))?$_GET['field']:null;
$query['value'] = (isset($_GET['value']))?$_GET['value']:null;
$query['strict'] = (isset($_GET['strict']))?$_GET['strict']:null;
$query['nonpriv_groups'] = (isset($_GET['nonpriv_groups']))?$_GET['nonpriv_groups']:null;
if ($query['field'] === null) {
	$women = $data_source->getAllWomen();
} else {
	$women = $data_source->getWomen($query);
}



?>

	<section role="search" id="search-box" class="medium-5 large-4 columns">
		<form id="searchform" method="GET">
			<span>Search where</span>
			<div class="search-query" id="search-query-1">
				<div class="select">
				<select name="field">
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
				<option value="yes">contains precisely</option>
			</select>
			</div>
			<input type="text" class="field-input" name="value" autocomplete="off" placeholder="something">
			</div>
			<label id="last-and">and... <a id="add-query" href="">(+)</a></label>
			<div id="nonpriv-groups">
				<span class="show-only">Show only</span>
				<!--
				<ul>
					<li><label for="is_poc">women of color</label><input name="nonpriv_groups[]" value="is_poc" id="is_poc" type="checkbox"/></li>
					<li><label for="has_disability">women with disability</label><input name="nonpriv_groups[]" value="has_disability" id="has_disability" type="checkbox"/></li>
					<li><label for="is_queer">LGBTQ women</label><input name="nonpriv_groups[]" value="is_queer" id="is_queer" type="checkbox"/></li>
				</ul>
				-->
				<ul>
					<li>
						<div class="switch-box">
							<div class="switch small round">
								<input id="is_poc" name="is_poc" type="checkbox">
								<label for="is_poc"></label>
							</div>
						</div>
						<div class="switch-label">women of color</div>						
					</li>					
					<li>
						<div class="switch-box">
							<div class="switch small round">
								<input id="has_disability" name="has_disability" type="checkbox">
								<label for="has_disability"></label>
							</div>
						</div>
						<div class="switch-label">women with disability</div>						
					</li>
					<li>
						<div class="switch-box">
							<div class="switch small round">
								<input id="is_queer" name="is_queer" type="checkbox">
								<label for="is_queer"></label>
							</div>
						</div>
						<div class="switch-label">LGBTQ women</div>						
					</li>
				</ul>
			</div>
			<div class="right"><button id="submit-button" type="submit">Search</button></div>
			
		</form>
		
	</section>		
	<div id="list-box" class="medium-7 large-7 columns">
		<div id="list-sort-controls" class="row">
			<!--
				sort-actions first in small
				sort-actions padding in medium and smaller 
			-->
			<div id="sort-actions" class="small-12 medium-6 medium-push-6 columns">
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
			<div id="list-actions" class="small-12 medium-6 medium-pull-6 columns">
				<ul>
					<li><a href="" id="sel-all">select all</a> | <a id="sel-none" href="">select none</a></li>
					<li><a href="" id="add-to-list">add selected to list</a></li>
				</ul>
			</div>
		</div>
		<?php
		if ($women === null) : ?>
				<p class="no-result">
					Sorry, nothing matches this query.
				</p>
		<?php ; else :?>
			<ol>
			<?php
			
			foreach($women as $index=>$woman) {
				//name
			?>
				<li class="woman row" id="woman-<?php echo $woman['id']; ?>">
					<header class="small-12 columns">
						<h3 class=""><a href="single.php?woman=<?php echo $woman['id']; ?>"><?php echo $woman['name']; ?></a></h3>
					</header>
					<div class="woman-top medium-7 large-6 columns">
					
					<p class="search-tagline"><?php echo $woman['tagline']; ?> <a class="more" href="single.php?woman=<?php echo $woman['id']; ?>">(...)</a></p>
					
					</div>
					<div class="specs small-12 medium-5 large-3 columns">
						<ul>
						<li><span class="period" data-birth="<?php echo $woman['date_born']; ?>" data-death="<?php echo $woman['date_died']; ?>"><?php echo form_date($woman['date_born'])." –&nbsp;".form_date($woman['date_died']); ?></span></li>
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
		<?php endif; ?>
	</div>
	<footer id="pagefooter">
			
		</footer>
</div>
<?php

require_once 'footer.php';
?>