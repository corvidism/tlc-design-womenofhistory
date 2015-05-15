<?php
/*
 * SINGLE
 * 
 * single view of a woman
 * contains all from db (save some utility stuff like ids)
 * 
 */

require_once 'DataSource.php';
require_once 'functions.php';

	

$data_source = new DataSource(); 
$id = $_GET['woman'];
$woman = $data_source->getWomanBy('id',$id);
//this should probably return an object Woman() with methods to echo values...

//if False, redirect to 404

//header settings:
$page = array(
	'title'=> $woman['name'],
	'id'=>'single'
);

require_once 'header.php';

?>
<article class="woman small-12 columns">
	<div class="row">
	<div id="side-col" class="small-12 medium-4 columns">
		<div class="row colapse">
			<?php
			//if the portrait is missing, echo the tagline here
			$image =  get_image("women/images/",$woman['id'],'1000h');
			if (!$image) {
				echo '<header>';
				echo '<h2 class="name">'.$woman['name'].'</h2>';
				echo '<p class="tagline">'.$woman['tagline'].'</p>';
				echo '</header>';
				$tagline_done=true;
			} else {
				$tagline_done=false;
				echo '<div class="portrait-img small-12 columns">
					<img src="'.$image.'" class="portrait" />	
				</div>';
				echo '<div class="other-portraits">';
				for ($i =0; $i <= rand(0, 5);$i++) {
					$rnd_img = get_image("women/images/_thumbs",$woman['id']);
					if ($rnd_img) {
						echo '<div class="img-box"><img src="'.$rnd_img.'"></div>';
					}					 
				}
				echo '</div>';
			}
			?>		
		</div>			
	</div>
	
	<header class="small-12 medium-8 large-5 columns">
		<?php
			
			if (!$tagline_done) {
				echo '<h2 class="name">'.$woman['name'].'</h2>';
				echo '<p class="tagline">'.$woman['tagline'].'</p>';
			} else {
				echo '<p></p>';
			}
		?>
	</header>
	<div class="specs medium-8 large-3 columns">
		<?php
			$non_priv_groups = "";
			
			if($woman['is_poc']) {
				if ($woman['ethnicity']) {
					$non_priv_groups.='<div><strong><a href="search.php?field=ethnicity&value='.$woman['ethnicity'].'">'.$woman['ethnicity'].'</a><a href="search.php?is_poc=1" title="woman of color"><sup>woc</sup></a></strong></div>';
				} else {
					$non_priv_groups.='<div><strong><a href="search.php?is_poc=1">woman of color</a></strong></div>';
				}
			} else {
				if ($woman['ethnicity']) {
					$non_priv_groups.='<div>(<a href="search.php?field=ethnicity&value='.$woman['ethnicity'].'">'.$woman['ethnicity'].'</a>)</div>';
				}
			}
			
			if ($woman['is_queer']) {
				$non_priv_groups.='<div><strong><a href="search.php?field=gender_identity?value='.$woman['gender_identity'].'">'.$woman['gender_identity'].'</a>, <a href="search.php?field=orientation&value='.$woman['orientation'].'">'.$woman['orientation'].'</a><a href="search.php?is_queer=1" title="lesbian, bisexual, transexual or queer woman"><sup>LBTQA</sup></a></strong></div>';				
			} else {
				$non_priv_groups.='<div>(<a href="search.php?field=gender_identity&value='.$woman['gender_identity'].'">'.$woman['gender_identity'].'</a>, <a href="search.php?field=orientation&value='.$woman['orientation'].'">'.$woman['orientation'].')</a></div>';
			}
			
			if ($woman['has_disability']) {
				if ($woman['disability']) {
					$non_priv_groups.='<div><strong><a href="search.php?field=disability&value='.$woman['disability'].'">'.$woman['disability'].'</a><a href="search.php?has_disability=1" title="woman with disability"><sup>dis</sup></a></strong></div>';
				} else {
					$non_priv_groups.='<div><strong><a href="search.php?has_disability=1">woman with disability</a></strong></div>';
				}
			} else {
				$non_priv_groups.='<div><a href="search.php?has_disability=0">(able-bodied)</a></div>';
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
			<div class="category"><strong>category: </strong>
			<?php
				if ($woman['category']) {
					echo '<a href="search.php?category='.$woman['category']['id'].'">'.$woman['category']['title'].'</a>';
				} else {
					echo "(none)";
				}				 
			?></div>
			<div class="tags"><strong>tags:</strong> 
				<?php
					$tags = explode(",",$woman['tags']);
					$taglinks = array();
					foreach($tags as $tag) {
						$taglinks[] = '<a href="search.php?tags='.$tag.'">'.$tag.'</a>';
					}
					echo implode(", ",$taglinks); 
				?>
			</div>	
		</div>	
	</div>
	<div class="inner small-12 medium-8 columns">
	<div class="story">
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
					echo '<p class="notice">(This record has no story. <a class="edit-link" href="single.php?woman='.$woman['id'].'&edit=true">Edit it</a> to tell the story of '.$woman['name'].'!)</p>';
				} else {
					echo $woman['story']; 
				};
			?>
		</div>
		
		
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
					echo '<p class="notice">(This record has no links. <a class="edit-link" href="single.php?woman='.$woman['id'].'&edit=true">Edit it</a> to add links that relate to '.$woman['name'].' somehow - articles, books, illustrations...)</p>';
				else:
					echo "<ul>";
					foreach ($links as $link):?>
						<li>
							<h4>
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
			<ul class="small-block-grid-3">
			<?php
			
			$lists = $data_source->getPublicListsByWoman($woman['id']);
			foreach($lists as $list)  : 
				?>
				<li class="row">
					<div class="list-desc small-10 columns">
						<a class="thumb-box" href="list.php?id=<?php echo $list['id'] ?>"><?php 
								$img = get_image("lists/images/_thumbs/",$list['id']);
								if ($img==false) {
									//echo placeholder
									echo '<div class="thumb-placeholder">...</div>';
								} else {
									echo '<img class="thumb" src="'.$img.'">';
								}
							?><?php echo $list['title'] ?></a>					
					</div>
				</li>										
			<?php
				 
			endforeach;
			?>
			</ul>
			<div class="notice"><a href="">Add</a> <?php echo $woman['name']?> to a list...</div>
		</div>
		<div class="comments">
			<h3>Comments (4)</h3>
			<div class="notice"><a href="">show</a> comments...</div>
			<div class="comments-inner">
				
			</div>
		</div>		
		</div>
		
		
		
	<footer>
				<p>
				Last edited by <a href="">annathecrow</a> on 23th March 2015.	
				</p>
				
			</footer>
	</div>
</article>

			
<?php
require_once 'footer.php';
?>


