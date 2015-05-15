<?php
$current= "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
if (strpos($_SERVER['REQUEST_URI'], 'index.php')) {
	$current = str_replace('index.php', '', $current);
}
$target = $current."search.php";
header('Location: '.$target);
// OR: header('Location: http://www.yoursite.com/home-page.html', true, 302);
exit;
?>