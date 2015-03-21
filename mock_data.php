<?php

#sorting by name - use nationality (place born), or ethnicity if specified
	
$empty = array(
	"name"=>"",
	"date_born"=>0,
	"date_died"=>0,
	"place_born"=>array(
		"place"=>"",
		"coords"=>"0,0",
	),
	"place_died"=>array(
		"place"=>"0",
		"coords"=>"0",
	),
	"categories"=>"",#this will be a foreign key in the db
	"awards"=>array(),
	"inventions"=>array(),
	"firsts"=>array(),
	"tagline"=>"",
	"about"=>"",
	"portrait"=>"",  #id - there will be a function to fetch images from file storage
	"tags"=>array(),
	"orientation"=>"",#standardised - lesbian, bisexual, asexual/aromantic, other, unknown; additional options possible
	"gender_identity"=>"", #standardised - cis woman, trans woman, trans man, bigender, pangender, agender, genderfluid, other, unknown; additional options possible
	"links"=>array(
		array(
			"id"=>0,
			"her_id"=>0, #NEVER EMPTY
			"title"=>"",
			"url"=>"",
			"description"=>"",
			"thumbnail"=>"", #blob
			"her_authorship"=>false,
		),
	),
	"feeds"=>array(
		array(
			"type"=>"",
			"url"=>"", #when it's rss
			"hashtag"=>"", #when it's a twitter/tumblr feed
		),
	),
	"last_edited_by"=>"", #user_id or IP
	"last_edited_at"=>"", #date			
);

$mock_data = array();

$mock_data[] = array(
	"name"=>"Lucy (Dinkinesh)",
	"date_born"=>-3220000,
	"date_died"=>"", #empty means unspecified means just approximate date known
	"place_born"=>array(
	"place"=>"Hadar, Ethiopia",
	"coords"=>"14.241808,40.300394",
	),
	"place_died"=>array(
	"place"=>"Hadar, Ethiopia",
	"coords"=>"14.241808,40.300394",
	),
	"categories"=>array("hominids"),#this will be a foreign key in the db
	"awards"=>array(),
	"inventions"=>array(),
	"firsts"=>array(),
	"tagline"=>"Lucy, our beloved ancestor, was a female Australopithecus Afarensis, a precursor to Homo Sapiens.",
	"about"=>"",
	"portrait"=>"",  #id - there will be a function to fetch images from file storage
	"tags"=>array('originals', 'The Lucy Collective'),
	"orientation"=>"unknown",#standardised - lesbian, bisexual, asexual/aromantic, other, unknown; additional options possible
	"gender_identity"=>"unknown", #standardised - cis woman, trans woman, trans man, bigender, pangender, agender, genderfluid, other, unknown
	"links"=>array(),
	"feeds"=>array()			
);	


$mock_data[] = array(
	"name"=>"Enheduanna",
	"date_born"=>-2300,
	"date_died"=>"",
	"place_born"=>array(
	"place"=>"",
	"coords"=>"0,0",
	),
	"place_died"=>array(
	"place"=>"0",
	"coords"=>"0",
	),
	"categories"=>"",#this will be a foreign key in the db
	"awards"=>array(),
	"inventions"=>array(),
	"firsts"=>array("oldest writer known by name"),
	"tagline"=>"A Sumerian priestess of Inanna, the first writer in history known by name.",
	"about"=>"",
	"portrait"=>"",  #id - there will be a function to fetch images from file storage
	"tags"=>array(),
	"orientation"=>"straight",#standardised - lesbian, bisexual, asexual/aromantic, other, unknown; additional options possible
	"gender_identity"=>"cis woman", #standardised - cis woman, trans woman, trans man, bigender, pangender, agender, genderfluid, other, unknown; additional options possible
	"links"=>array(
		array(
			"id"=>0,
			"her_id"=>0, #NEVER EMPTY
			"title"=>"",
			"url"=>"",
			"description"=>"",
			"thumbnail"=>"", #blob
			"her_authorship"=>false,
		),
	),
	"feeds"=>array(
		array(
			"type"=>"",
			"url"=>"", #when it's rss
			"hashtag"=>"", #when it's a twitter/tumblr feed
		),
	),			
);	

$mock_data[] = array(
	"name"=>"Murasaki Shikibu",
	"date_born"=>-978,
	"date_died"=>-1025,
	"place_born"=>array(
	"place"=>"",
	"coords"=>"0,0",
	),
	"place_died"=>array(
	"place"=>"0",
	"coords"=>"0",
	),
	"categories"=>"",#this will be a foreign key in the db
	"awards"=>array(),
	"inventions"=>array(),
	"firsts"=>array(""),
	"tagline"=>"She wrote Tale of Genji, which is probably the world's oldest novel.",
	"about"=>"",
	"portrait"=>"",  #id - there will be a function to fetch images from file storage
	"tags"=>array(),
	"orientation"=>"straight",#standardised - lesbian, bisexual, asexual/aromantic, other, unknown; additional options possible
	"gender_identity"=>"cis woman", #standardised - cis woman, trans woman, trans man, bigender, pangender, agender, genderfluid, other, unknown; additional options possible
	"links"=>array(
		array(
			"id"=>0,
			"her_id"=>0, #NEVER EMPTY
			"title"=>"",
			"url"=>"",
			"description"=>"",
			"thumbnail"=>"", #blob
			"her_authorship"=>false,
		),
	),
	"feeds"=>array(
		array(
			"type"=>"",
			"url"=>"", #when it's rss
			"hashtag"=>"", #when it's a twitter/tumblr feed
		),
	),			
);	

$mock_data[] = array(
	"name"=>"Emma Orczy",
	"date_born"=>1865,
	"date_died"=>1947,
	"place_born"=>array(
	"place"=>"",
	"coords"=>"0,0",
	),
	"place_died"=>array(
	"place"=>"0",
	"coords"=>"0",
	),
	"categories"=>"",#this will be a foreign key in the db
	"awards"=>array(),
	"inventions"=>array(),
	"firsts"=>array(""),
	"tagline"=>"She created the Scarlet Pimpernel, the precursor to characters like Batman and other masked vigilantes.",
	"about"=>"",
	"portrait"=>"",  #id - there will be a function to fetch images from file storage
	"tags"=>array(),
	"orientation"=>"straight",#standardised - lesbian, bisexual, asexual/aromantic, other, unknown; additional options possible
	"gender_identity"=>"cis woman", #standardised - cis woman, trans woman, trans man, bigender, pangender, agender, genderfluid, other, unknown; additional options possible
	"links"=>array(
		array(
			"id"=>0,
			"her_id"=>0, #NEVER EMPTY
			"title"=>"",
			"url"=>"",
			"description"=>"",
			"thumbnail"=>"", #blob
			"her_authorship"=>false,
		),
	),
	"feeds"=>array(
		array(
			"type"=>"",
			"url"=>"", #when it's rss
			"hashtag"=>"", #when it's a twitter/tumblr feed
		),
	),			
);	

$mock_data[] = array(
	"name"=>"Mary Shelley",
	"date_born"=>1797,
	"date_died"=>1851,
	"place_born"=>array(
	"place"=>"",
	"coords"=>"0,0",
	),
	"place_died"=>array(
	"place"=>"0",
	"coords"=>"0",
	),
	"categories"=>"",#this will be a foreign key in the db
	"awards"=>array(),
	"inventions"=>array(),
	"firsts"=>array("oldest writer known by name"),
	"tagline"=>"Brilliant mathematician, daughter of Byron, and the author of the first program.",
	"about"=>"",
	"portrait"=>"",  #id - there will be a function to fetch images from file storage
	"tags"=>array(),
	"orientation"=>"straight",#standardised - lesbian, bisexual, asexual/aromantic, other, unknown; additional options possible
	"gender_identity"=>"cis woman", #standardised - cis woman, trans woman, trans man, bigender, pangender, agender, genderfluid, other, unknown; additional options possible
	"links"=>array(
		array(
			"id"=>0,
			"her_id"=>0, #NEVER EMPTY
			"title"=>"",
			"url"=>"",
			"description"=>"",
			"thumbnail"=>"", #blob
			"her_authorship"=>false,
		),
	),
	"feeds"=>array(
		array(
			"type"=>"",
			"url"=>"", #when it's rss
			"hashtag"=>"", #when it's a twitter/tumblr feed
		),
	),			
);

$mock_data[] = array(
	"name"=>"Ada Lovelace",
	"date_born"=>1815,
	"date_died"=>1852,
	"place_born"=>array(
	"place"=>"",
	"coords"=>"0,0",
	),
	"place_died"=>array(
	"place"=>"0",
	"coords"=>"0",
	),
	"categories"=>"",#this will be a foreign key in the db
	"awards"=>array(),
	"inventions"=>array(),
	"firsts"=>array("oldest writer known by name"),
	"tagline"=>"Author of the first science fiction novel (which she wrote as a teenage girl, by the way).",
	"about"=>"",
	"portrait"=>"",  #id - there will be a function to fetch images from file storage
	"tags"=>array(),
	"orientation"=>"straight",#standardised - lesbian, bisexual, asexual/aromantic, other, unknown; additional options possible
	"gender_identity"=>"cis woman", #standardised - cis woman, trans woman, trans man, bigender, pangender, agender, genderfluid, other, unknown; additional options possible
	"links"=>array(
		array(
			"id"=>0,
			"her_id"=>0, #NEVER EMPTY
			"title"=>"",
			"url"=>"",
			"description"=>"",
			"thumbnail"=>"", #blob
			"her_authorship"=>false,
		),
	),
	"feeds"=>array(
		array(
			"type"=>"",
			"url"=>"", #when it's rss
			"hashtag"=>"", #when it's a twitter/tumblr feed
		),
	),			
);
	
$mock_data[] = array(
	"name"=>"Rosalind Franklin",
	"date_born"=>1920,
	"date_died"=>1958,
	"place_born"=>array(
	"place"=>"",
	"coords"=>"0,0",
	),
	"place_died"=>array(
	"place"=>"0",
	"coords"=>"0",
	),
	"categories"=>"",#this will be a foreign key in the db
	"awards"=>array(),
	"inventions"=>array(),
	"firsts"=>array("oldest writer known by name"),
	"tagline"=>"A scientist who discovered the shape of DNA.",
	"about"=>"",
	"portrait"=>"",  #id - there will be a function to fetch images from file storage
	"tags"=>array(),
	"orientation"=>"straight",#standardised - lesbian, bisexual, asexual/aromantic, other, unknown; additional options possible
	"gender_identity"=>"cis woman", #standardised - cis woman, trans woman, trans man, bigender, pangender, agender, genderfluid, other, unknown; additional options possible
	"links"=>array(
		array(
			"id"=>0,
			"her_id"=>0, #NEVER EMPTY
			"title"=>"",
			"url"=>"",
			"description"=>"",
			"thumbnail"=>"", #blob
			"her_authorship"=>false,
		),
	),
	"feeds"=>array(
		array(
			"type"=>"",
			"url"=>"", #when it's rss
			"hashtag"=>"", #when it's a twitter/tumblr feed
		),
	),			
);
	
?>