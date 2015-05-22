<?php

//STATISTICS
//various visualisations done from the db data

//timeline
//...
//??????

//header settings:
$page = array(
	'title'=> 'Statistics and visualisations',
	'id'=>'stats',
);

require_once 'header.php';
?>
<div class="large-4 columns">
	<h2>WIP: Stats</h2>
	<p class="tagline">Infographics, statistics, data visualisations.</p>
</div>
<div class="large-12 columns">
	
</div>
<div class="medium-6 large-4 columns">
	
	<img src="misc/images/bits-ideas034_cr_res.jpg">
</div>
<div class="medium-6 large-8 columns content">
	<p>Since this website will contain a large amount of structured data, it makes sense to find ways to visualize it in various ways. It might be interesting to see a timeline of women scientists, a graph of women on the site grouped by continent of birth, or even something as silly as the complete amount of words in all stories on the site. </p>
	<p>This could be a static section, or it might be periodically updated - perhaps working in tandem with the social media presence of this site (something that would make sense for a website of this topic).</p>
	<p>Other possibility is to offer a free data API and share the contents of the database with other developers. This encourages interraction with a community, and often produces remarkable projects.</p>
</div>
<?php
require_once 'footer.php';
?>