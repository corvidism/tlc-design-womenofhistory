$("body").removeClass("no-js");

list = {
	'selected':0,	
};

search = {
	'queryCount':1,
};

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
		$("#list-actions").hide();
	} else if (oldSelected==0 && list.selected > 0) {
		$("#list-actions").show();
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