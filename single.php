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
			
			if (!$image) : ?>
				<header class="small-12 columns">
				<h2 class="name"><?php echo $woman['name'] ?></h2>
				<p class="tagline"><?php echo $woman['tagline'] ?></p>	
				</header>			
			<?php 
			$tagline_done=true;
			else :
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
			endif; ?>			
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
	<div class="specs medium-8 large-8 columns">
			<div class="category">
				<?php
					if ($woman['category']) {
						echo '<a href="search.php?category='.$woman['category']['id'].'">'.$woman['category']['title'].'</a>';
					} else {
						echo "(none)";
					}				 
				?></div>
			<?php
				$non_priv_groups =array();
				
				
				if($woman['is_poc']) {
					if ($woman['ethnicity']) {
						$non_priv_groups[]='<strong><a title="ethnicity" href="search.php?field=ethnicity&value='.$woman['ethnicity'].'">'.$woman['ethnicity'].'</a><a href="search.php?is_poc=1" title="woman of color"><sup>woc</sup></a></strong>';
					} else {
						$non_priv_groups[]='<strong><a href="search.php?is_poc=1">woman of color</a></strong>';
					}
				} else {
					if ($woman['ethnicity']) {
						$non_priv_groups[]='<a title="ethnicity" href="search.php?field=ethnicity&value='.$woman['ethnicity'].'">'.$woman['ethnicity'].'</a>';
					}
				}
				
				if ($woman['is_queer']) {
					$non_priv_groups[]='gender identity, orientation: <strong><a title="gender identity" href="search.php?field=gender_identity?value='.$woman['gender_identity'].'">'.$woman['gender_identity'].'</a>, <a title="orientation" href="search.php?field=orientation&value='.$woman['orientation'].'">'.$woman['orientation'].'</a><a href="search.php?is_queer=1" title="lesbian, bisexual, transexual or queer woman"><sup>LBTQA</sup></a></strong>';				
				} else {
					$non_priv_groups[]='<a title="gender identity" href="search.php?field=gender_identity&value='.$woman['gender_identity'].'">'.$woman['gender_identity'].'</a>, <a title="orientation" href="search.php?field=orientation&value='.$woman['orientation'].'">'.$woman['orientation'].'</a>';
				}
				
				if ($woman['has_disability']) {
					if ($woman['disability']) {
						$non_priv_groups[]='<strong><a title="disability" href="search.php?field=disability&value='.$woman['disability'].'">'.$woman['disability'].'</a><a href="search.php?has_disability=1" title="woman with disability"><sup>dis</sup></a></strong>';
					} else {
						$non_priv_groups[]='<strong><a title="disability" href="search.php?has_disability=1">woman with disability</a></strong>';
					}
				} else {
					$non_priv_groups[]='<a title="disability" href="search.php?has_disability=0">able-bodied</a>';
				}
				
				
				if (!sizeof($non_priv_groups)==0) {
					echo '
					<div class="non_priv_groups">
					'.implode(" | ", $non_priv_groups).'
					</div>
					';
				}
			?>
			<div class="tags"> 
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
	<div class="inner small-12 medium-8 end columns">
		<div class="row">
	<div class="story small-12 columns">
			<?php
				  
				$date_place = format_date_place($woman,$form='long');
				 
				if ($date_place != "") {
					echo "<p class=\"dates\">($date_place)</p>";
				} 
			?>
			
			<?php
				if ($woman['story']==null || $woman['story'] == "") {
					//echo '<a class="edit-link" href="single.php?woman='.$woman['id'].'&edit=true">(add story)</a>';
					echo '<p class="notice">There is no story for '.$woman['name'].'. <a class="edit-link" href="single.php?woman='.$woman['id'].'&edit=true">Edit the page</a> to tell it.</p>';
				} else {
					echo $woman['story']; 
				};
			?>
		</div>
		
		
			<div class="successes small-12 columns">
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
			<div class="links small-12 columns">
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
			
			<div class="lists small-12 columns">
			<h3>Featured in these lists</h3>
			<ul class="small-block-grid-3">
			<?php
			
			$lists = $data_source->getPublicListsByWoman($woman['id']);
			foreach($lists as $list)  : 
				?>
				<li class="row">
					<div class="list-desc small-10 columns">
						<a class="thumb-box" href="list.php?id=<?php echo $list['id'] ?>"><?php 
								$img = get_image("lists/images/",$list['id'],'300h');
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
			<p class="notice"><a href="">Add</a> <?php echo $woman['name']?> to a list...</p>
		</div>
		<div class="comments small-12 columns">
			<h3>Comments (4)</h3>
			<p class="notice"><a href="">Show</a> comments...</p>
			<div class="comments-inner">
				
			</div>
		</div>		
		</div>
		
		
		
				</div>
				<footer>
				<p>
				Created by <a href=""><?php echo $woman['created_by']; ?></a>; last edited by <a href=""><?php echo $woman['last_edited_by']; ?></a> on <?php echo form_date($woman['last_edited_at'],true); ?>. <a id="full-page-edit-link" class="edit-link" href="single.php?woman=<?php echo $woman['id']; ?>&edit=true">(Edit page)</a>	
				</p>
				
			</footer>
	</div>
</article>

			
<?php
require_once 'footer.php';
?>


