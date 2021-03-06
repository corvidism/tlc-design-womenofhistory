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
$query = array();
$query['field'] = (isset($_GET['field']))?$_GET['field']:null;
$query['value'] = (isset($_GET['value']))?$_GET['value']:null;
$query['strict'] = (isset($_GET['strict']))?$_GET['strict']:null;
$query['nonpriv_groups'] = (isset($_GET['nonpriv_groups']))?$_GET['nonpriv_groups']:array();
if ($query['field'] === null) {
	$women = $data_source->getAllWomen();
} else {
	$women = $data_source->getWomen($query);
}
logme($query);


?>

	<section role="search" id="search-box" class="medium-5 large-4 columns">
		<form id="searchform" method="GET">
			<span>Search where</span>
			<div class="search-query" id="search-query-1">
				<div class="select">
				<select name="field">
					<?php
				$fields=array(
					'any'=>'her anything',
					'name' =>'her name',
					'place_born'=>'her place of birth',
					'place_died'=>'her place of death',
					'date_born'=>'her date of birth',
					'date_died'=>'her date of death',
					'firsts'=>'her firsts',
				 	'story'=>'her story',
				 	'tags'=>'her tags', // 'that,this,else'
				 	'category'=>'her category',
				 	'links'=>'her links',
				 	'ethnicity'=>'her ethnicity',
				 	'orientation'=>'her orientation',
				 	'gender_identity'=>'her gender identity'					
				);
				
				foreach ($fields as $field_id=>$field) {
					$selected = (isset($query['field']) && $query['field'] == $field_id)?'selected':'';
					echo '<option '.$selected.' value="'.$field_id.'">'.$field.'</option>';					
				}
			?>
			</select>
			</div>
			<div class="select">
			<select name="strict">
				<?php
				$fields=array(
					'no' =>'contains',
					'yes'=>'contains precisely',					
				);
				
				foreach ($fields as $field_id=>$field) {
					$selected = (isset($query['strict']) && $query['strict'] == $field_id)?'selected':'';
					echo '<option '.$selected.' value="'.$field_id.'">'.$field.'</option>';					
				}
			?>
			</select>
			</div>
			<input type="text" class="field-input" name="value" autocomplete="off" placeholder="something" value="<?php
				if (isset($query['value'])) echo $query['value'];
			?>">
			</div>
			<label id="last-and">and... <a id="add-query" href="">(+)</a></label>
			
			<div><button id="submit-button" type="submit">Submit</button></div>
			<div id="nonpriv-groups">
				<ul>
					<li>
						<div class="switch-box">
							<div class="switch small round">
								<input id="is_poc" name="nonpriv_groups[]" value="is_poc" type="checkbox" <?php if (in_array('is_poc', $query['nonpriv_groups'])) { echo 'checked';} ?>>
								<label for="is_poc"></label>
							</div>
						</div>
						<div class="switch-label">only women of color</div>						
					</li>					
					<li>
						<div class="switch-box">
							<div class="switch small round">
								<input id="has_disability" name="nonpriv_groups[]" value="has_disability" type="checkbox" <?php if (in_array('has_disability', $query['nonpriv_groups'])) { echo 'checked';} ?>>
								<label for="has_disability"></label>
							</div>
						</div>
						<div class="switch-label">only women with disability</div>						
					</li>
					<li>
						<div class="switch-box">
							<div class="switch small round">
								<input id="is_queer" name="nonpriv_groups[]" value="is_queer" type="checkbox" <?php if (in_array('is_queer', $query['nonpriv_groups'])) { echo 'checked';} ?>>
								<label for="is_queer"></label>
							</div>
						</div>
						<div class="switch-label">only LBTQA women</div>						
					</li>
				</ul>
			</div>
		</form>
		
	</section>		
	<div id="list-box" class="medium-7 large-7 columns interactive">
		<?php
		if ($women === null) : ?>
				<p id="no-result">
					Sorry, nothing found. <a href="search.php">Clear search?</a>
				</p>
		<?php ; else :?>
			<?php if ($query['field']!=NULL) : ?>
				<div id="query-count">Shown <?php echo sizeof($women); ?> results. <a href="search.php">Clear search.</a></div>
				
			<?php endif; ?>
		
			<div id="list-sort-controls" class="row">
			<div id="sort-actions" class="small-12 medium-6 medium-push-6 columns">
				<div>order by: <a data-dropdown="order_by" aria-controls="order_by" aria-expanded="false">date added</a>
<ul id="order_by" class="f-dropdown" data-dropdown-content aria-hidden="true" tabindex="-1">
  <li><a data-val="created_on" href="">date added</a></li>
  <li><a data-val="name" href="">name</a></li>
  <li><a data-val="period" href="">time period</a></li>
</ul> | <a data-dropdown="sort-direction" aria-controls="sort-direction" aria-expanded="false">last to first</a>
<ul id="sort-direction" class="f-dropdown" data-dropdown-content aria-hidden="true" tabindex="-1">
  <li><a data-val="asc" href="">last to first</a></li>
  <li><a data-val="desc" href="">first to last</a></li>
</ul> </div>
			</div>
			<div id="list-actions" class="small-12 medium-6 medium-pull-6 columns">
				<ul>
					<li><a href="" id="sel-all">select all</a> | <a id="sel-none" href="">select none</a></li>
					<li><a data-dropdown="add-to-list" aria-controls="add-to-list" aria-expanded="false">+ add selected to list</a>
<ul id="add-to-list" class="f-dropdown" data-dropdown-content aria-hidden="true" tabindex="-1">
  <li><a href="">Favorites</a></li>
  <li><a href="">My List</a></li>
  <li><a href="">My Other List</a></li>
</ul></li>
				</ul>
			</div>
		</div>
			
			
			<ol class="row">
			<?php
			
			foreach($women as $index=>$woman) {
				//name
			?>
				<li class="woman <?php
					echo 'page-'.(floor($index/10)+1); //page number
				 ?> small-12 columns" id="woman-<?php echo $woman['id']; ?>">
					<?php
						$image =  get_image("women/images/",$woman['id'],'600h');
						if ($image) {
							//echo '<img src="'.$image.'">';
							echo '<div class="img-side img-set" style="background-image:url('.$image.')"></div>';
						} else {
							echo '<div class="img-side"></div>';
						}
					?>
					<div class="woman-cont">
						<header>
						<h3 class=""><a href="single.php?woman=<?php echo $woman['id']; ?>"><?php echo $woman['name']; ?></a></h3>
						<div class="dataline">
							<?php
							
							$nonprivs = array();
							
							if ($woman['is_poc']) {
								$nonprivs[] = '<strong class="is_poc"><a href="search.php?is_poc=1">woman of color</a></strong>';
							}
							if ($woman['is_queer']) {
								$nonprivs[] = '<strong class="is_queer"><a href="search.php?is_queer=1">LBTQA</a></strong>';
								//echo gender and sex.id
							}
							if ($woman['has_disability']) {
								$nonprivs[] = '<strong class="has_disability"><a href="search.php?has_disability=1">woman with disability</a></strong>';
							}
							
							if (sizeof($nonprivs)!=0) {
								echo implode(", ",$nonprivs)." | ";
							}							
						?>
							<span class="period" data-birth="<?php echo $woman['date_born']; ?>" data-death="<?php echo $woman['date_died']; ?>"><?php echo format_date_place($woman); ?></span> | 
							<a href="search.php?category=<?php echo $woman['category']['id']; ?>"><?php echo $woman['category']['title']; ?></a>
						</div>
					</header>
					<div class="search-tagline"><?php echo $woman['tagline']; ?> <a class="more" href="single.php?woman=<?php echo $woman['id']; ?>">(...)</a></div>
					<div class="tags">
						<?php
							$tags = explode(",",$woman['tags']);
							$taglinks = array();
							foreach($tags as $tag) {
								$taglinks[] = '<a href="search.php?field=tags&value='.$tag.'">'.$tag.'</a>';
							}
							echo implode(", ",$taglinks);
						?>
					</div>
					<footer class="actions">
						<div><a data-dropdown="add-to-list-<?php echo $woman['id']; ?>" aria-controls="add-to-list-<?php echo $woman['id']; ?>" aria-expanded="false">+ add to list</a>
<ul id="add-to-list-<?php echo $woman['id']; ?>" class="f-dropdown" data-dropdown-content aria-hidden="true" tabindex="-1">
  <li><a href="">Favorites</a></li>
  <li><a href="">My List</a></li>
  <li><a href="">My Other List</a></li>
</ul></div>						
					</footer>	
					</div>				
				</li>
			<?php	
			} #end of foreach			
			?>
		</ol>
		<?php endif; ?>
	</div>

<div id="modals">
	<div id="modalSearch" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
	  <h3 id="modalTitle">WIP: Complex search</h3>
	  <img class="img-left" src="misc/images/bits-ideas02_cr_res.jpg" />
	  <p>
	  	The idea for the final version of search is to let the user combine multiple search queries as freely as possible. The matching rules options will change depending on what will be searched in (e.x. "before", "after" for dates, hierarchically organized categories etc.), and it will be possible to change how will the queries be combined. 
	  </p>
	  <a class="close-reveal-modal" aria-label="Close">&#215;</a>
  	</div>
</div>
<?php

require_once 'footer.php';
?>