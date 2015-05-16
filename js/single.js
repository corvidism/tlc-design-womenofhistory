smallScreen['in'] = function() {
		$(".lists").insertAfter(".links");
		//var img = $(".portrait-img img");
		//var height = img.height();	
		//img.css("top",-height/3);
	
};

largeScreen['in']=function() {
		console.log("moving lists");
		$(".lists").insertAfter(".portrait-img");
		//$(".portrait-img img").css("top","0");
};

enquire.register("screen and (max-width:"+ smallScreen.max+")", {
	match: smallScreen['in'],
}).register("screen and (min-width:"+ mediumScreen.min+")", {
	match: largeScreen['in'],
});


