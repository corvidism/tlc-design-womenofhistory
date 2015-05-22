<?php
/*
 * LINK SEARCH
 * 
 * listing of links
 * searchable for keyword, url (eg. "book", "8tracks.com")
 * sortable by time, title
 */

//header settings:
$page = array(
	'title'=> 'Links',
	'id'=>'links'
);

require_once 'header.php';
?>
<div class="large-4 columns">
	<h2>WIP: Links</h2>
	<p class="tagline">Search through links.</p>
</div>
<div class="large-12 columns">
	
</div>
<div class="large-8 large-offset-4 columns content">
	<p>
		One feature of the final website not covered in this demo is searching through links. This would be useful as a quick way to get resources. For example, it would be easy to generate a reading list by searching for "book" in the link description.
	</p>
</div>
<?php
require_once 'footer.php';
?>