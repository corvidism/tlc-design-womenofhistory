<?php
//$current= "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
//$target = $current."search.php";
//header('Location: '.$target);
// OR: header('Location: http://www.yoursite.com/home-page.html', true, 302);
//exit;
?>

<?php
/*
 * INDEX
 * 
 * splash page
 * simple search line
 * some intro
 */

//header settings:
$page = array(
	'title'=> 'Intro',
	'id'=>'index',
);

require_once 'header.php';
?>
<div id="intro" class="small-12 columns">
	<div class="row">
		<div class="large-6 columns large-centered">
			<p>
			Welcome to Women of History.
		</p>
	<p>
		There goes some intro text. Maybe two or three lines, not sure what yet. Lorem ipsum text other text more text. I don't think there will be any line breaks inside it but that shouldn't matter.
	</p>
		</div>
	</div>
	<div class="row">
		<div class="large-8 columns large-centered">
			Show women whose name is xy. Search.
		</div>
	</div>
</div>
<?php
require_once 'footer.php';
?>