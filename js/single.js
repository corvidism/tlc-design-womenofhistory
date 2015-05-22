smallScreen['in'] = function() {
		$(".lists").insertAfter(".links").removeClass("moved");
		//var img = $(".portrait-img img");
		//var height = img.height();	
		//img.css("top",-height/3);
	
};

largeScreen['in']=function() {
		console.log("moving lists");
		$(".lists").insertAfter(".portrait-img").addClass("moved");
		//$(".portrait-img img").css("top","0");
};

xxlargeScreen['in']=function() {
	console.log("x-large in");
	$("#wrapper").css("max-width","110rem");
	$("article.woman > .row > header").removeClass("large-5").addClass("large-4");
	$(".specs").css("margin-top","5rem");
	$(".inner > .row").children(".columns").addClass("large-6");
	$(".lists.moved").removeClass("large-6");
	//add class large-12
	//change wrapper width
};

xxlargeScreen['out']=function(){
	console.log("x-large out");
	$("#wrapper").css("max-width","62.5rem");	
	$("article.woman > .row > header").removeClass("large-4").addClass("large-5");
	$(".specs").css("margin-top","0");
	$(".inner > .row").children(".columns").removeClass("large-6");
	//same as above, only backwards
};

enquire.register("screen and (max-width:"+ xxlargeScreen.min +")", {
	match: xxlargeScreen['out'],
}).register("screen and (min-width:"+ xxlargeScreen.min+")", {
	match: xxlargeScreen['in'],
});

enquire.register("screen and (max-width:"+ smallScreen.max+")", {
	match: smallScreen['in'],
}).register("screen and (min-width:"+ mediumScreen.min+")", {
	match: largeScreen['in'],
});


//when hover over
//header
//story
//links
//lists
//stats

//clickables = [];
clickables = ['header','.specs','.story','.links','.lists','.portrait-img'];


for (var i=0;i<clickables.length;i++) {
	$(clickables[i]).hover(function(e){
		$(this).find(".edit-link").css("visibility","visible");
	},function(e){
		$(this).find(".edit-link").css("visibility","hidden");
	});
}

editing = {
	'edit-header':function(){
		console.log("editing header");
		//oldContent = $("header").detach();
		//newContent = $("<header></header>")
		//replace the things with input fields/textareas
		//and a "done" link
		//when clicked, update the original
	},
	'edit-story':function(){
		
	},
	'edit-links':function(){
		$('#modalLinks').foundation('reveal','open');
	},
	'edit-portrait':function(){
		$('#modalPortrait').foundation('reveal','open');
	},
		
};


$(".edit-link").click(function(e){
	e.preventDefault();
	var what = $(this).attr("id");
	
	console.log(what);
	if(typeof editing[what] == 'function') {
		editing[what]();
	}
		
});
