$("body").removeClass("no-js");

list = {
	'selected':0,	
};

search = {
	'queryCount':1,
};

console.log(Foundation.media_queries);
/*
$.each(Foundation.media_queries, function(index,item){
	enquire.register(item, {
	match: MediaQueryEvent(index,"in"),
	unmatch: MediaQueryEvent(index,"out"),
	setup: MediaQueryEvent(index,"setup"),
	deferSetup:true;
	});
});
*/



smallScreenActions = {
	'in':function() {
		//this matches always!
	},
	'out':function() {
		alert("no longer small screen");
		console.log('small screen out!');
	},
	'setup':function() {
		//nope
	}
	
};

mediumScreenActions = {
	'in':function() {
		console.log('medium screen in');
	},
	'out':function() {
		console.log('large screen out');
	},
	'setup':function() {
		//nope
	}
};

largeScreenActions = {
	'in':function() {
		console.log('large screen in');
	},
	'out':function() {
		console.log('large screen out');
	},
	'setup':function() {
		//nope
	}
};

xlargeScreenActions = {
	'in':function() {
		//nope
	},
	'out':function() {
		console.log('large screen out');
	},
	'setup':function() {
		//nope
	}
};

xxlargeScreenActions = {
	'in':function() {
		//nope
	},
	'out':function() {
		//nothiiing
	},
	'setup':function() {
		//nope
	}
};

$.each(Foundation.media_queries,function(index, item){
	enquire.register(item,{
		match: MediaQueryEventHandler(index,"in"),
		unmatch: MediaQueryEventHandler(index,"out"),
		setup: MediaQueryEventHandler(index,"setup"),
		deferSetup:true
	});
	
});

function MediaQueryEventHandler(query,action) {
	switch (query) {
		case 'small': return smallScreenActions[action];
		case 'medium': return mediumScreenActions[action];
		case 'large': return largeScreenActions[action];
		case 'xlarge': return xlargeScreenActions[action];
		case 'xxlarge': return xxlargeScreenActions[action];
	}
}



$("#add-query").click(function() {
	//copy search block
	//clear contents
	//move button
	console.log("clicked");
	lastAnd = $("#last-and");
	search.queryCount++;
	newQuery = $("#search-query-1").clone();
	newQuery.attr("id","search-query-"+search.queryCount);
	newQuery.find("select.what").val("any");
	newQuery.find("select.strict").val("no");
	newQuery.find("input").val("");
	newLogic = $('<label class="logic and" id="logic-for-'+search.queryCount+'"><em>and</em>/or</label>');
	newLogic.click(function(){
		console.log("logic switch");
		logic = $(this);
		if (logic.hasClass("and")) {
			logic.removeClass("and").addClass("or");
			logic.html("and/<em>or</em>");
		} else {
			logic.removeClass("or").addClass("and");
			logic.html("<em>and</em>/or");
		}	
	});
	newLogic.insertBefore(lastAnd);
	newQuery.insertBefore(lastAnd);
	e.preventDefault();
});

$("#search-submit").click(function(e){
	
	//form query string
	//submit
	e.preventDefault();
});

$("li.woman").click(function(e){
	console.log(e);
	woman=$(this);
	oldSelected = list.selected;
	if (woman.hasClass("selected")) {
		woman.removeClass("selected");
		list.selected--;
	} else {
		woman.addClass("selected");
		list.selected++;
	}
	if (list.selected==0) {
		$("#list-actions").css("visibility","hidden");
	} else if (oldSelected==0 && list.selected > 0) {
		$("#list-actions").css("visibility","visible");
	}
	console.log(list.selected);
});

$("li.woman a").click(function(e){
	e.stopPropagation();	
});

$("#select-all").click(function(){
	number = $("li.woman").addClass("selected").size();
	list.selected = number; 
	console.log(number);
	e.preventDefault();
});
$("#select-none").click(function(){
	$("li.woman").removeClass("selected");
	list.selected = 0;
	$("#list-actions").hide();
	e.preventDefault();
});