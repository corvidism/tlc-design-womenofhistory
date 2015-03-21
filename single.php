<?php
require_once 'mock_data.php';
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8" />
	    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>The Lucy Collective: Women of History</title>
		<link rel="stylesheet" href="css/foundation.min.css" />
	    <link rel="stylesheet" href="css/normalize.css" />
	    <link rel="stylesheet" href="css/base.css" />
	    <script src="modernizr.js"></script>
  </head>
	<body class="no-js">
		<div id="wrapper" class="row">
			<div id="search-box">
				
			</div>
			<div id="list-box" class="collumn large-12">
				<ul>
					<?php
					
					define("D_FORMAT","");
					
					function form_date($dateformat,$date) {
						#TODO replace this by proper date function!
						
						if ($date < 0) {
							return abs($date)."BCE";
						} else {
							return abs($date)."CE";
						}
					}
					
					foreach($mock_data as $index=>$item) {
					?>
						<li class="w-item" id="<?php $index; ?>">
							<h3><?php echo $item['name']; ?></h3>
							<span class="period" data-birth="<?php echo $item['date_born']; ?>" data-death="<?php echo $item['date_died']; ?>"><?php echo form_date(D_FORMAT,$item['date_born'])." – ".form_date(D_FORMAT,$item['date_died']); ?></span>
							<p class="tagline"><?php echo $item['tagline']; ?></p>
						</li>
					<?php	
					} #end of foreach			
					?>
				</ul>
			</div>
		</div>
		<script src="js/jquery-1.11.2.min.js"></script>
		<script src="js/foundation.min.js"></script>
	</body>
</html>


