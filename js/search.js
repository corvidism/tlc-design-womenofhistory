list = {
	'selected':0,	
	'page':1,
	'loading':false,
	'complete':false,	
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
	newQuery.find("select").attr("name","");
	newQuery.find("input").val("").attr("name","");
	
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


$("li.woman").click(function(e){
	console.log("clickety:");
	console.log(e.originalEvent.originalTarget.tagName);
	if (e.originalEvent.originalTarget.tagName == "A") return true;
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

$("#sel-all").click(function(e){
	number = $("li.woman").addClass("selected").size();
	list.selected = number; 
	console.log(number);
	e.preventDefault();
});
$("#sel-none").click(function(e){
	$("li.woman").removeClass("selected");
	list.selected = 0;
	$("#list-actions").css("visibility","hidden");
	e.preventDefault();
});

$("#add-to-list ul a").click(function(e){
	e.preventDefault();
	//open a pop-up window:
	//select list
	//AJAX
	//update
	//some animation
});

$("#sort-actions .f-dropdown a").click(function(e){
	var clicked = $(this);
	var drop = clicked.closest(".f-dropdown");
	Foundation.libs.dropdown.close(drop);
	$('#sort-actions a[data-dropdown="'+drop.attr('id')+'"]').text(clicked.text());
	e.preventDefault();
});


function makeDropdown(select) {
	var name = select.attr("name");
	var dropdown = $('<ul class="dropdown" id="'+name+'-dropdown"></ul>').hide();
		select.find("option").each(function(e){
			var opt = $(this);
			var item = $('<li data-val="'+opt.val()+'"><a href="" >'+opt.text()+'</a></li>');
			item.click(function(e){
				e.preventDefault();
				var li=$(this);
				console.log(li.attr("data-val"));
				$("#hidden-"+name).val(li.attr("data-val"));
				$("#"+name).text(li.text());
				dropdown.hide();								
			});//maybe using .on on the list would be faster!
			dropdown.append(item);
		});
		return dropdown;
}

selects = $("#searchform .select select");
selects.each(function(){
	var select = $(this);
	var selectText = select.find("option:selected").text();
	var selectName = select.attr("name");
	var selectVal = select.val();
	var newSelect = $('<span id="'+selectName+'" data-value="'+selectVal+'">'+selectText+'</span>');
	console.log(newSelect);
	newSelect.hidden = $('<input type="hidden" id="hidden-'+selectName+'" name="'+selectName+'" value="'+selectVal+'" />');
	newSelect.click(function(e){
		console.log("open dropdown "+selectName);
		if (newSelect.dropdown == null) {
			newSelect.dropdown = makeDropdown(select);
			newSelect.dropdown.show();
			newSelect.after(newSelect.dropdown);
			newSelect.closest(".select").addClass("opened");
		} else {
			newSelect.dropdown.toggle();
			newSelect.closest(".select").toggleClass("opened");
		};
		
		//add list - fixed height, scrollbar
		//open a drawer
		//select shit
		//close drawer
		//update hidden field
	});
	select.replaceWith(newSelect);
	newSelect.after(newSelect.hidden);	
});


$("#joyride-start").click(function(e){
	//$(document).foundation('joyride', 'start');
	e.preventDefault();
});

$("#submit-button").click(function(e){
	//console.log($("#searchform").serializeArray());
	//$(this).field($("search-"));
	//e.preventDefault();
	//I need to intercept this and add the values from the fake selects
});

$("#nonpriv-groups input").change(function(e){
	$("#searchform").submit();
});

function getDocHeight() {
    var D = document;
    return Math.max(
        D.body.scrollHeight, D.documentElement.scrollHeight,
        D.body.offsetHeight, D.documentElement.offsetHeight,
        D.body.clientHeight, D.documentElement.clientHeight
    );
}

function loadMore() {
	$(".page-"+list.page).show();
	$("#loader").remove();
	list.loading=false;
}


$(window).scroll(function() {
	if(!list.loading && !list.complete && ($(window).scrollTop() + $(window).height() >= (getDocHeight()-100))) {
		list.loading=true;
		list.page++;
		var women = $("li.woman");
		if ($("li.woman:visible").length==women.length) {
			$("li.woman").last().after('<div id="end-of-results" class="notice">No more results.</div>');
			list.complete = true;
			list.loading = false;
		} else {
			$("li.woman:visible").last().after('<div id="loader" class="notice">loading...</div>');
			setTimeout(loadMore,2000);
		}		
	}
   });


//when I scroll lower than the position of the search-button, the search-box is appended a fixed-position div that says the search string in small type