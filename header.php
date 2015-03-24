<!DOCTYPE HTML>
<!--[if IE 6]><![endif]-->

<?php

require_once 'site_settings.php';
?>
 
<html>
	<head>
		<meta charset="utf-8" />
	    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta http-equiv="x-ua-compatible" content="ie=edge">

		<title><?php echo $page['title']." – ".$site['title']; ?></title>
		
		<link rel="apple-touch-icon" href="apple-touch-icon.png">
		<!-- Place favicon.ico in the root directory -->
		
	    <link rel="stylesheet" href="css/normalize.css" />
		<link rel="stylesheet" href="css/foundation.min.css" />
		
	    <link rel="stylesheet" href="stylesheets/screen.css" />
	    
	    <script src="modernizr.js"></script>
  </head>
	<body class="no-js" id="outline">
		<nav id="navline">
			<ul>
			<li><a href="#">The Lucy Collective</a></li>
			<li><a href="#">Home</a></li>
			<li><a href="#">Lists</a></li>
			<li><a href="#">Links</a></li>
			<li><a href="#">Stats</a></li>	
			</ul>
			
			
			
			<div id="user-controls">
				<img id="user-icon" src="" />
				<a href="#" title="your user profile">Annathecrow</a>
				<ul>
					<li><a href="">My lists</a></li>
					<li><a href="#">Settings</a></li>
				</ul>
				<a href="#">(logout)</a>
			</div>
		</nav>