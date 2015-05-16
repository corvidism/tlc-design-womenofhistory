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
			
			pageStyle = {
				'now':0,
				'all': ['style1','style2','style3','style4','style5'],
			};
			
			$("#style-switch").click(function(e){
				oldStyle = pageStyle['now'];
				pageStyle['now']+=1;
				if (pageStyle['now']>=pageStyle['all'].length) {
					pageStyle['now']=0;
				}
				console.log('style switch: '+pageStyle['all'][oldStyle]+' to '+pageStyle['all'][pageStyle['now']]);
				$("body").removeClass(pageStyle['all'][oldStyle]).addClass(pageStyle['all'][pageStyle['now']]);
				e.preventDefault();
			});
		</script>
		<?php
		if (isset($page['id'])) {
			echo '<script src="js/'.$page['id'].'.js"></script>';
		}
		?>		
		<script> $(document).foundation(); </script>
	</body>
</html>