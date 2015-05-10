list = {
	'selected':0,	
};

search = {
	'queryCount':1,
};

$("#add-query").click(function(e) {
	//copy search block
	//clear contents
	//move button
	console.log("clicked");
	lastAnd = $("#last-and");
	search.queryCount++;
	newQuery = $("#search-query-1").clone();
	newQuery.attr("id","search-query-"+search.queryCount);
	newQuery.find("select.field").val("any");
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

$("#searchform").on("click","select",function(e){
	select= $(this);
	field = select.val();
	fieldInput = select.closest(".search-query").find(".field-input");
	
	
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


selects = $("#searchform .select select");
selects.each(function(){
	select = $(this);
	selectText = select.find("option:selected").text();
	selectVal = select.val();
	newSelect = $('<span data-selected="'+selectVal+'">'+selectText+'</span>');
	newSelect.click(function(e){
		//open a drawer
		//select shit
		//close drawer
		//update hidden field
	});
	select.replaceWith(newSelect);
	newSelect.after('<input type="hidden" name="field" value="" />');
});


$("#search-button").click(function(e){
	e.preventDefault();
	//I need to intercept this and add the values from the fake selects
});

//replace selects with divs and lists (mostly to make sure that shit will look the same in all browsers)

//when I scroll lower than the position of the search-button, the search-box is appended a fixed-position div that says the search string in small type