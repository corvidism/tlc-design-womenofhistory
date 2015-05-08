<?php
/*
 * USER LIST
 * 
 * contains:
 * 
 * title
 * cover image
 * description
 * owner
 * list of women (similar to search.php)
 * -- drag&drop (on default - position is 0; when list is rearranged by drag&drop, the positions are saved into db)
 * -- comment (why is this woman in this list)
 */

require_once 'DataSource.php';
require_once 'functions.php';

	

$data_source = new DataSource(); 
$id = $_GET['id'];
$list = $data_source->getListById($id);
$women = $data_source->getWomenByList($id);
 
//header settings:
$page = array(
	'title'=> $list['title']." – Lists",
);

require_once 'header.php';
?>
<article id="user-list" class="small-12 columns">
	<div class="row">
		<div class="small-12 medium-5 large-4 columns">
			<img src="<?php echo get_image("lists/images/",$list['id']); ?>" class="list-cover" />
			<h2 class="title"><?php echo $list['title']; ?></h2>
			<p class="tagline">
				<?php echo $list['tagline']; ?>
			</p>
			<?php if (!$list['description']==null) :?>
				<div class="description"><?php echo $list['description'] ?></div>
			<?php endif;?>
		</div>
		
		<div id="list-box" class="small-12 medium-7 large-8 columns">
			<ol>
			<?php
			
			foreach($women as $index=>$woman) {
				$order_number=$index+1;
				//name
			?>
				<li class="woman row" id="woman-<?php echo $woman['id']; ?>">
					<header class="small-12 columns">
						<h3 class=""><a href="single.php?woman=<?php echo $woman['id']; ?>"><?php echo $order_number.". ".$woman['name']; ?></a></h3>
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
					<?php if (!$woman['description']==null) :?>
						<div class="small-12 columns description">
							<p><?php echo $woman['description'] ?></p>
						</div>
					<?php endif;?>
				</li>
			<?php	
			} #end of foreach			
			?>
		</ol>
		</div>
		<div id="">
			
		</div>
		<div class="small-12 medium-4 columns">
			<h3>Similar lists</h3>
			<?php
				
			?>
			<ul class="small-block-grid-3">
			<?php
			
			$similar = $data_source->getListById(1);
			for ($i=0; $i < 3 ; $i++) :?> 
				<li class="row">
					<div class="list-desc small-10 columns">
						<a class="thumb-box" href="list.php?id=<?php echo $similar['id'] ?>"><img class="thumb" src="<?php echo get_image("lists/images/",$similar['id']); ?>"><?php echo $similar['title'] ?></a>					
					</div>
				</li>
			<?php 
				endfor;
			?>			
			</ul>
		</div>
	</div>
	
	
	
	
	
	
</article>
<?php
require_once 'footer.php';
?>