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
	'id'=>'list'
);

require_once 'header.php';
?>
<article id="user-list" class="small-12 columns">
	<div class="row">
		<!--
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
		-->
		
		<div id="side-col" class="small-12 medium-4 columns">
		<div class="row colapse">
			<?php
			logme($list['id']);
			$image =  get_image("lists/images/",$list['id'],'300h');
			if ($image) : ?>
				<div class="portrait-img small-12 columns">
					<img src="<?php echo $image; ?>" class="portrait" />
				</div>
				
			<?php endif;?>	
			<header>
			<h2 class="title"><?php echo $list['title']; ?></h2>
			<p class="tagline">
				<?php echo $list['tagline']; ?>
			</p>
			<?php if (!$list['description']==null) :?>
				<p class="description"><?php echo $list['description'] ?></p>
			<?php endif;?>
			</header>					
		</div>			
	</div>
		
		<div id="list-box" class="small-12 medium-7 large-8 columns">
			<ol class="row">
			<?php
			
			foreach($women as $index=>$woman) {
				$order_number=$index+1;
				//name
			?>
			
			<li class="woman small-12 columns">
					<?php
						$image =  get_image("women/images/",$woman['id'],'300h');
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
					<?php if (!$woman['description']==null) :?>
						<div class="description">
							<p><?php echo $woman['description'] ?></p>
						</div>
					<?php endif;?>	
					</div>				
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
			
			$similar = $data_source->getAllPublicLists();
			foreach ($similar as $list) :?> 
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
		</div>
	</div>
	
	
	
	
	
	
</article>
<?php
require_once 'footer.php';
?>