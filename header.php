<!DOCTYPE HTML>
<!--[if IE 6]><![endif]-->

<?php

require_once 'site_settings.php';
?>
 
<html lang="en">
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
		
	    <script src="js/vendor/modernizr.js"></script>
  </head>
	<body class="no-js" id="" >
	<nav class="top-bar" data-topbar role="navigation">	
		<ul class="title-area">
		    <li class="name">
		    	<h1><a id="menutitle" href="">Women of History</a></h1>
		    </li>
		    <li class="toggle-topbar"><a href="#"><span>Menu</span></a></li>
		  </ul>	
		<section class="top-bar-section">
		     <ul class="left">
		    	<li><a href="search.php">The Women</a></li>
				<li><a href="list-seach.php">User Lists</a></li>
				<li><a href="link-search.php">Links</a></li>
				<li><a href="stats.php">Infographics</a></li>
				<li><a href="about.php">About</a></li>
		      </ul>
		       <ul class="right">
		    	<li class="has-dropdown">
			      <a href="#">annathecrow</a>
			      <ul class="dropdown">
			        <li  class="active"><a href="user/lists.php">My lists</a></li>
					<li><a href="user/settings.php">Settings</a></li>
					<li><a href="user/logout.php">(logout)</a></li>
			      </ul>
			    </li>
		    </ul>
		    </ul>
		  </section>
		</nav>
		
<div id="wrapper" class="row">
	<header id="pagetitle" class="collumn small-12 centered">
		<h1>
			<span id="subtitle">The Lucy Collective: </span>
			Women of History
		</h1>
	</header>