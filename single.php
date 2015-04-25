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

<article class="woman row">
	<div class="portrait-img small-12 medium-4 medium-push-8 columns">
		<img src="<?php echo get_image("women/images/",$woman['id']); ?>" class="portrait" />	
	</div>
	
	<div class="inner small-12  medium-8 medium-pull-4 columns">
		<header>
			<h2><?php echo $woman['name']?></h2>
			<p class="dates">
				<span class="born"></span><span class="died"></span>
			</p>
			<p class="tagline"><?php echo $woman['tagline']; ?></p>
		
		</header>
		<div class="non_priv_groups">
			<?php
				if ($woman['is_poc']) {
					echo '<p class="is_poc"><strong><a href="search.php?is_poc=1">woman of color</a></strong></p>';
				}
				
				if ($woman['is_queer']) {
					echo "<p><strong>LGBTQ</strong></p>";
					//echo gender and sex.id
				}
				if ($woman['has_disability']) {
					echo "<p><strong>woman with disability</strong></p>";
					//echo dis
				}
			?>
			<?php
			
				if ($woman['ethnicity']) {
					echo '<p class="ethnicity"><strong>ethnicity: </strong><a href="search.php?ethnicity='.$woman['ethnicity'].'">'.$woman['ethnicity'].'</a></p>';
				}				 
			?>	
		</div>
		
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
					foreach ($woman['tags'] as $tag_id=>$tag_title) {
						$tag_ar[] = '<a href="search.php?tags='.$tag_id.'">'.$tag_title.'</a>';
					};
					echo implode(', ',$tag_ar); 
				?>
			</p>	
		</div>		
		
		
		<div class="story">
			<?php echo $woman['story']; ?>
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
			<ul>
				<?php
					$links = $data_source->getLinksByWoman($woman['id']);
					
					foreach($links as $link)  : 
						?>
						<li>
							<img class="thumb" src="<?php echo get_image("links/images/",$link['id']); ?>">
							<h4><a href="<?php echo $link['url'] ?>"><?php echo $link['title'] ?></a></h4>
							<p><?php echo $link['description'] ?></p>
						</li>						
					<?php 
					endforeach;
				?>
			</ul>
			
		</div>
		<div class="lists">
			<h3>Featured in these lists</h3>
			<ul>
			<?php
			
			$lists = $data_source->getPublicListsByWoman($woman['id']);
			foreach($lists as $list)  : ?>
				<li>
					<img class="thumb" src="<?php echo get_image("lists/images/",$list['id']); ?>">
					<h4><a href="lists.php?id=<?php echo $list['id'] ?>"><?php echo $list['title'] ?></a></h4>
					<!--
					<?php echo $list['description'] ?>
					<span class="by"><a href="user.php?u=<?php echo $list['created_by'] ?>">created by <?php echo $list['created_by'] ?></a></span>
					-->
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
	
</article>


			
<?php
require_once 'footer.php';
?>


