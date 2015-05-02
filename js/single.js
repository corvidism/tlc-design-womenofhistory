smallScreen['in'] = function() {
		$(".lists").insertAfter(".links");		
};

largeScreen['in']=function() {
		console.log("moving lists");
		$(".lists").insertAfter(".portrait-img");
};

enquire.register("screen and (max-width:"+ smallScreen.max+")", {
	match: smallScreen['in'],
}).register("screen and (min-width:"+ mediumScreen.min+")", {
	match: largeScreen['in'],
});