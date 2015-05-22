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
				'max-width':'62.5rem',
				'max-width-xxlarge':'110rem',
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
			
			
			tour= {
				'start':function(){
					$("#"+tour.stops[0]).foundation('reveal','open');
				},
				'next':function(el){
					var id = $(el).closest(".reveal-modal").attr("id");
					//console.log("this id:" +id);
					var nextId = tour.stops[tour.stops.indexOf(id)+1];
					//console.log("next id:"+nextId);
					if (nextId>=tour.stops.length || $("#"+nextId).length == 0) {
						//console.log("no next");
						$("#"+id).foundation('reveal','close');
					} else {
						$("#"+nextId).foundation('reveal','open');
					}
				},
				'prev':function(el){
					var id = $(el).closest(".reveal-modal").attr("id");
					var prevId = tour.stops[tour.stops.indexOf(id)-1];
					if (prevId>=tour.stops.length || $("#"+prevId).length == 0) {
						//console.log("no next");
						$("#"+id).foundation('reveal','close');
					} else {
						$("#"+prevId).foundation('reveal','open');
					}
				},
				'init':function(){
					modals = $("#modals .reveal-modal");
					if (modals.length == 0) {return false};
					modals.each(function(){
						var id = $(this).attr("id");
						if (id!= null || id!='') {
							tour.stops.push($(this).attr("id"));
						}						
					});
					
				},
				'stops':[],
			}
			tour.init();
			if (tour.stops.length == 0) {
				$("#explain").addClass("inactive");
			} else {
				$("#modals .next").click(function(){
				tour.next(this);
			});
			
			$("#modals .prev").click(function(){
				tour.prev(this);
			});
			
			$("#explain").click(function(e){
				if (tour.stops.length!=0) {
					tour.start();
				}
				e.preventDefault();
			});
			}
			
			
		</script>
		<?php
		if (isset($page['id'])) {
			echo '<script src="js/'.$page['id'].'.js"></script>';
		}
		?>		
		<script> $(document).foundation(); </script>
	</body>
</html>