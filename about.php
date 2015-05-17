<?php

/*
 * ABOUT 
 * 
 * what is this site about. Same as on thelucycollective.com, but more fleshed out (there will be a link). Thanks to creators and other people. Links to social media. 
 * 
 */
//header settings:
$page = array(
	'title'=> 'About',
	'id'=>'about'
);

require_once 'header.php';
?>
<div class="large-4 columns">
	<h2>About</h2>
	<p class="tagline">What this site is really about.</p>
</div>
<div class="large-12 columns">
	
</div>
<div class="large-8 large-offset-4 columns content">
	<p>This is a WIP version of a site I've been planning for about a year. The goal of this is to design the structure and map possible user interaction before I start the long process of <em>really</em> building it.</p>
	<h3>CZ: O této verzi</h3>
		<p>Stručný výcuc toho, co je napsané ve VSKP.</p>
	<h3>What works</h3>
	<p>There are things that work.</p>
	<h3>What doesn't work</h3>
	<h4 id="missing-link-search">Link Search</h4>
	<p>Explanation.</p>
	<h4 id="missing-link-search">Comments</h4>
	<p>Some more explanation</p>
</div>
<footer id="pagefooter" class="large-12 columns">
	Copyleft, who made this, why, year, etc.
</footer>
<?php
require_once 'footer.php';
?>