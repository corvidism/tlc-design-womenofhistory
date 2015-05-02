</div>		
		<script src="js/jquery-1.11.2.min.js"></script>
		<script src="js/foundation.min.js"></script>
		<script src="js/enquire.min.js"></script>
		<script>
			$("body").removeClass("no-js");
			smallScreen = {
				'max':'40em',
			};
			
			mediumScreen = {
				'min':'40.063em',
				'max':'64em',
			};
			
			largeScreen = {
				'min':'64.063em',
				'max':'90em',
			};
			
			xlargeScreen = {
				'min':'90.063em',
				'max':'120em',
			};
			
			xxlargeScreen = {
				'min':'120.063em',
			};
		</script>
		<?php
		if (isset($page['id'])) {
			echo '<script src="js/'.$page['id'].'.js"></script>';
		}
		?>		
		<script> $(document).foundation(); </script>
	</body>
</html>