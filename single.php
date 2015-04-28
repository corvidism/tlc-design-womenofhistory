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
		<p class="dates">
			<!--
				TODO: conditionals for missing places of birth/death!
			-->
			(Born 
			<?php
				echo form_date($woman['date_born'],true);
				 
				 //possible? "12th century" ??
				 
				 //only one date, no place: "(245354 BCE)" "(12th January 1245)"
				 //only one date, place: "(124 BCE, Akkadian Empire)"
				 //two dates, place born: "(123 BCE - 100 BCE, Rome)"
				 //two dates, place died: "(123 CE, ? - 156 CE, Athenes)"
				 //two dates with days, place born: "(12th September 1645 - 23rd January 1680, Nova Scotia, USA)"
				 //two dates with days, both places: "(3rd November 1853, Boston, USA - 15th March, Gallway, Ireland)"
				 
				 /* date born -- place born -- date died -- place died
				  * 1 0 0 0 "1233344 BCE"
				  * 0 1 0 0 --
				  * 0 0 1 0 "? - 123 CE"
				  * 0 0 0 1 --
				  * 1 1 0 0 "123 CE, Rome"
				  * 0 1 1 0 "?, Rome - 123 CE, ?" "? - 123 CE, Rome"
				  * 0 0 1 1 --
				  * 1 0 1 0 "123 CE - 124 BCE"
				  * 0 1 0 1 --
				  * 1 0 0 1 --
				  * 1 1 1 0 "123 CE - 167 CE, Rome" "123 CE, Rome - 167 CE, ?"
				  * 0 1 1 1 "?, Rome - 123 CE, Athenes"
				  * 1 1 1 1 "123 CE, Rome - 167, Athenes"
				  * 
				  * --> block place until date is entered
				  * --> block date_died until date_born is entered
				  * --> checkbox ("same as place born"); or maybe just automatically?
				 */
				 
				 // 1 0 0 0 "1233344 BCE"
				 //echo "($db)";
				  
				 // 1 1 0 0 "123 CE, Rome"
				 //echo "($db, $pb)";
				 
				 // 0 0 1 0 "? - 123 CE"
				 // 1 0 1 0 "123 CE - 124 BCE"
				 // --> 1 0 1 0
				 //echo "($db - $dd)";
				 
				 // 0 1 1 0  "? - 123 CE, Rome"
				 // 1 1 1 0 "123 CE - 167 CE, Rome"
				 // --> 1 1 1 0
				 //echo "($db - $dd, $pb)";
				 
				 // 1 1 1 0 "123 CE, Rome - 167 CE, ?"
				 // 0 1 1 1 "?, Rome - 123 CE, Athenes"
				 // 1 1 1 1 "123 CE, Rome - 167 CE, Athenes
				 // 0 1 1 0 "?, Rome - 123 CE, ?"
				 // --> 1 1 1 1
				 //echo "($db, $pb - $dd, $pd)";				 
				 
				 $db=$woman['date_born'];
				 $pb=$woman['place_born'];
				 $dd=$woman['date_died'];
				 $pd=$woman['place_died'];
				 if (is_null($db)) {
				 	$date_place = "";
					// 0 0 0 0
				 } elseif (is_null($pb)) {
				 	$date_place ="$db";
					// 1 0 0 0
					if (!is_null($dd)) {
						$date_place =" - $dd";
						// 1 0 1 0
					}
				 } elseif (is_null($dd)) {
				 	$date_place = "$db, $pb";
					// 1 1 0 0
				 } elseif (is_null($pd)) {
				 	$date_place = "$db - $dd, $db";
					// 1 1 1 0
				 } else {
				 	$date_place = "$db, $pb - $dd, $pd";
					// 1 1 1 1
				 };
				 
				 
				 
			?>
			
			 <span><?php
				?></span> in <span><?php echo $woman['place_born']?></span>, died <span><?php echo form_date($woman['date_died'],true) ?> in <span><?php echo $woman['place_died']?></span></span>)
		</p>
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


