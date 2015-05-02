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
		
		<link rel="stylesheet" href="fonts/andadasc/stylesheet.css" />
		<link rel="stylesheet" href="fonts/archery/stylesheet.css" />
		<link rel="stylesheet" href="fonts/economica/stylesheet.css" />
		<link rel="stylesheet" href="fonts/josefinslab1/stylesheet.css" />
		<link rel="stylesheet" href="fonts/josefinslab2/stylesheet.css" />
		<link rel="stylesheet" href="fonts/kelly-matchbook-ostrich/stylesheet.css" />
		<link rel="stylesheet" href="fonts/sixcaps/stylesheet.css" />
		
		<link rel="stylesheet" href="stylesheets/screen.css" />	
		
	    <script src="js/vendor/modernizr.js"></script>
  </head>
	<body class="no-js style0" id="" >
	<nav class="top-bar" data-topbar role="navigation">	
		<ul class="title-area">
		    <li class="name">
		    	<h1><a id="menutitle" href="index.php">Women of History</a></h1>
		    </li>
		    <li class="toggle-topbar"><a href="#"><span>Menu</span></a></li>
		  </ul>	
		<section class="top-bar-section">
		     <ul class="left">
		    	<li><a href="search.php">The Women</a></li>
				<li><a href="list-search.php">Lists</a></li>
				<li><a href="link-search.php">Links</a></li>
				<li><a href="stats.php">Infographics</a></li>
				<li><a href="about.php">About</a></li>
		      </ul>
		       <ul class="right">
		    	<li class="has-dropdown">
			      <a href="user-profile.php">annathecrow</a>
			      <ul class="dropdown">
			      	<li><a href="#" id="style-switch">(cycle styles)</a></li>
			        <li><a href="user/lists.php">My lists</a></li>
					<li><a href="user/settings.php">Settings</a></li>
					<li><a href="user/logout.php">(logout)</a></li>
			      </ul>
			    </li>
		    </ul>
		    </ul>
		  </section>
		</nav>
		
<div id="wrapper" class="row">