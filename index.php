<?php
$current= $_SERVER['REQUEST_SCHEME']."://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
$target = $current."search.php";
header('Location: '.$target);
// OR: header('Location: http://www.yoursite.com/home-page.html', true, 302);
exit;

?>