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
	$("<label>and</label>").insertBefore(lastAnd);
	newQuery.insertBefore(lastAnd);
	return false;
});

$("#search-submit").click(function(){
	
	//form query string
	//submit
	return false;
});

$("li.woman").click(function(){
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

$("#select-all").click(function(){
	number = $("li.woman").addClass("selected").size();
	list.selected = number; 
	console.log(number);
	return false;
});
$("#select-none").click(function(){
	$("li.woman").removeClass("selected");
	list.selected = 0;
	$("#list-actions").hide();
	return false;
});