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
require_once 'functions.php';

	

$data_source = new DataSource(); 
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
<article class="woman small-12 columns">
	<div class="row">
		
	
	<div class="portrait-img small-12 large-4 columns">
		<img src="<?php echo get_image("women/images/",$woman['id']); ?>" class="portrait" />	
	</div>
	
	<header class="small-12 large-5 columns">
		<h2 class="name"><?php echo $woman['name']?></h2>
		<p class="tagline"><?php echo $woman['tagline']; ?></p>
	</header>
	<div class="specs large-3 columns">
		<?php
			$non_priv_groups = "";
			if ($woman['is_poc']) {
				$non_priv_groups.= '<p class="is_poc"><strong><a href="search.php?is_poc=1">woman of color</a></strong></p>';
			}
			
			if ($woman['is_queer']) {
				$non_priv_groups.= "<p><strong>LGBTQ</strong></p>";
				
			}
			if ($woman['has_disability']) {
				$non_priv_groups.= "<p><strong>woman with disability</strong></p>";
			}
			
			if ($woman['ethnicity']) {
				$non_priv_groups.= '<p class="ethnicity"><strong>ethnicity: </strong><a href="search.php?ethnicity='.$woman['ethnicity'].'">'.$woman['ethnicity'].'</a></p>';
			}
			
			if (!$non_priv_groups == "") {
				echo '
				<div class="non_priv_groups">
				'.$non_priv_groups.'
				</div>
				';
			}
		?>
		<div class="category_and_tags">
			<p class="category"><strong>category: </strong>
			<?php
				if ($woman['category']) {
					echo '<a href="search.php?category='.$woman['category']['id'].'">'.$woman['category']['title'].'</a>';
				} else {
					echo "(none)";
				}				 
			?></p>
			<p class="tags"><strong>tags:</strong> 
				<?php
					$tags = explode(",",$woman['tags']);
					$taglinks = array();
					foreach($tags as $tag) {
						$taglinks[] = '<a href="search.php?tags='.$tag.'">'.$tag.'</a>';
					}
					echo implode(", ",$taglinks); 
				?>
			</p>	
		</div>	
	</div>
	<div class="story large-8 columns push-large-4">
			<?php
				 $db=form_date($woman['date_born'],true);
				 $pb=$woman['place_born'];
				 $dd=form_date($woman['date_died'],true);
				 $pd=$woman['place_died'];
				 
				 if (is_null($db)) {
				 	$date_place = "";
					// 0 0 0 0
				 } elseif (is_null($pb)) {
				 	$date_place ="$db";
					// 1 0 0 0
					if (!is_null($dd)) {
						$date_place .=" – $dd";
						// 1 0 1 0
					}
				 } elseif (is_null($dd)) {
				 	$date_place = "$db, $pb";
					// 1 1 0 0
				 } elseif (is_null($pd)) {
				 	$date_place = "$db – $dd, $db";
					// 1 1 1 0
				 } else {
				 	$date_place = "$db, $pb – $dd, $pd";
					// 1 1 1 1
				 };
				 
				if ($date_place != "") {
					echo "<p class=\"dates\">($date_place)</p>";
				} 
			?>
			
			<?php
				if ($woman['story']==null || $woman['story'] == "") {
					//echo '<a class="edit-link" href="single.php?woman='.$woman['id'].'&edit=true">(add story)</a>';
					echo '(This record has no story. <a class="edit-link" href="single.php?woman='.$woman['id'].'&edit=true">Edit it</a> to tell the story of '.$woman['name'].'!)';
				} else {
					echo $woman['story']; 
				};
			?>
			</div>
	
		<div class="inner small-12 columns">
			
			
			
			
				
			
			
			
			
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
				<h3>Links</h3>
				<?php
				$links = $data_source->getLinksByWoman($woman['id']);
				if ($links == null): 
					echo '(This record has no links. <a class="edit-link" href="single.php?woman='.$woman['id'].'&edit=true">Edit it</a> to add links that relate to '.$woman['name'].' somehow - articles, books, illustrations...)';
				else:
					echo "<ul>";
					foreach ($links as $link):?>
						<li>
							<h4>
							<?php
							
							$link_split = explode("/",$link['url']);
							//temporary:
							$link_root = substr($link['url'], 0,strpos($link['url'],"/",9));
							echo '<img src="http://www.google.com/s2/favicons?domain='.$link_root.'">';
							//TODO: grab and store the actual favicon from the site (when scraping it)
							?>
							<a href="<?php echo $link['url'] ?>"><?php echo $link['title'] ?></a></h4>
							<p><?php echo $link['description'] ?></p>
						</li>						
					<?php 
					endforeach;
					echo "</ul>";
				endif;		
				?>
			</div>
			<div class="lists">
				<h3>Featured in these lists</h3>
				<ul>
				<?php
				
				$lists = $data_source->getPublicListsByWoman($woman['id']);
				foreach($lists as $list)  : ?>
					<li class="row">
						<div class="thumb-wrap small-2 column"><img class="thumb" src="<?php echo get_image("lists/images/",$list['id']); ?>"></div>
						<div class="list-desc small-10 columns">
							<h4><a href="list.php?id=<?php echo $list['id'] ?>"><?php echo $list['title'] ?></a></h4>
							<?php echo $list['description'] ?>
						</div>
					</li>						
				<?php 
				endforeach;
				?>
				</ul>
			</div>
			
			<footer>
				<p>
				Last edited by <a href="">annathecrow</a> on 23th March 2015.	
				</p>
				
			</footer>
		</div>
	</div>
</article>

			
<?php
require_once 'footer.php';
?>


