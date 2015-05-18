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
	'title'=> 'Search Lists',
	'id'=>'list-search'
);
require_once 'header.php';

require_once 'functions.php';
require_once 'DataSource.php';
	
$data_source = new DataSource(); 

$lists = $data_source->getAllPublicLists();
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
		<?php
			if ($lists === null) : ?>
				<p class="no-result">
					Sorry, nothing matches this query.
				</p>
		<?php ; else :?>
			<ol>
			<?php foreach($lists as $list) : ?>
				<li>
					<?php
						$image =  get_image("lists/images/",$list['id'],'300h');
						if ($image) {
							//echo '<img src="'.$image.'">';
							echo '<div class="img-side img-set" style="background-image:url('.$image.')"></div>';
						} else {
							echo '<div class="img-side"></div>';
						}
					?>
					<h3><a href="list.php?id=<?php echo $list['id']; ?>"><?php echo $list['title']; ?></a></h3>
					<p class="search-tagline">
						<?php echo $list['tagline'];?>
					</p>
				</li>
		<?php endforeach; ?>
			</ol>
		<?php endif; ?>
	</div>


<?php
require_once 'footer.php';
?>