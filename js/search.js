list = {
	'selected':0,	
	'page':1,
	'loading':false,
	'complete':false,
	'imgSideWidth':0,	
};

search = {
	'queryCount':1,
	'dropdowns': {},
};

origTopMargin = $("li.women").css("margin-top");

xxlargeScreen['in']=function() {
	console.log("x-large in");
	$("#wrapper").css("max-width","110rem");
	var women = $("li.woman");
	women.addClass("large-6");
	women.css("margin-top","-5rem");
	women.first().css("margin-top","0");
	$("li.woman:odd").addClass("large-offset-6");	
	
	//add class large-12
	//change wrapper width
};

xxlargeScreen['out']=function(){
	console.log("x-large out");
	$("#wrapper").css("max-width","62.5rem");
	$("li.woman").removeClass("large-6").css("margin-top",origTopMargin);
	$("li.woman:odd").removeClass("large-offset-6");
	//same as above, only backwards
};

enquire.register("screen and (max-width:"+ xxlargeScreen.min +")", {
	match: xxlargeScreen['out'],
}).register("screen and (min-width:"+ xxlargeScreen.min+")", {
	match: xxlargeScreen['in'],
});

$("#add-query").click(function(e) {
	//copy search block
	//clear contents
	//move button
	console.log("clicked");
	lastAnd = $("#last-and");
	search.queryCount++;
	
	newQuery = $("#search-query-1").clone();
	newQuery.attr("id","search-query-"+search.queryCount);
	
	newQuery.find("#field").attr("data-val","any").text("her anything");
	newQuery.find("#strict").attr("data-val","no").text("contains");
	
	//fix for demo, so they don't get submitted 
	newQuery.find("select").attr("name","");
	newQuery.find("input").val("").attr("name","");
	
	
	var selects = newQuery.find(".select span");
	selects.each(function(){
		select = $(this);
		var oldId = select.attr("id");
		var newId = oldId+"-"+search.queryCount;
		select.attr("id",newId);
		select.closest(".select").find(".dropdown").attr("id",newId+"-dropdown");
	});
		
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
	if (e.target.nodeName == "A") return true;
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
	var selectName = select.attr("name");	
	console.log("making dropdown of "+selectName);
	var dropdown = $('<ul class="dropdown" id="'+selectName+'-dropdown" data-dropdown-for="'+selectName+'"></ul>').hide();
		select.find("option").each(function(e){
			var opt = $(this);
			var item = $('<li data-val="'+opt.val()+'"><a href="" >'+opt.text()+'</a></li>');
			/*
			item.click(function(e){
				e.preventDefault();
				var li=$(this);
				console.log(li.attr("data-val"));
				$("#hidden-"+selectName).val(li.attr("data-val"));
				$("#"+selectName).text(li.text());
				dropdown.hide();								
			});//maybe using .on on the list would be faster!
			*/
			dropdown.append(item);
		});
		return dropdown;
}

//.select span
//dropdown
$("#searchform").on("click",".select span",function(e){
	var selSpan = $(this);
	var selName = selSpan.attr("id");
	console.log("opening "+selName);
	selSpan.closest(".select").find(".dropdown").toggle();
	selSpan.closest(".select").toggleClass("opened");
	e.stopPropagation();
});

$("#searchform").on("click",".select .dropdown li",function(e){
	e.preventDefault();
	var li=$(this);
	var dropdown = li.closest(".dropdown");
	var selectName = dropdown.attr("id").replace("-dropdown","");
	$("#hidden-"+selectName).val(li.attr("data-val"));
	$("#"+selectName).text(li.text());
	dropdown.hide();
						
});

selects = $("#searchform .select select");
selects.each(function(){
	var select = $(this);
	var selectText = select.find("option:selected").text();
	var selectName = select.attr("name");
	var selectVal = select.val();
	var newSelect = $('<span id="'+selectName+'" data-value="'+selectVal+'">'+selectText+'</span>');
	console.log(newSelect);
	newSelect.hidden = $('<input type="hidden" id="hidden-'+selectName+'" name="'+selectName+'" value="'+selectVal+'" />');
	select.replaceWith(newSelect);
	newSelect.after(makeDropdown(select));
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
			$("li.woman").last().after('<div id="end-of-results" class="notice small-12 columns">No more results.</div>');
			list.complete = true;
			list.loading = false;
		} else {
			$("li.woman:visible").last().after('<div id="loader" class="notice small-12 columns">loading...</div>');
			setTimeout(loadMore,2000);
		}		
	}
   });
   
$("body").click(function(e){
	$("#searchform .dropdown").hide();
});
   
/*

$(".img-side").hover(function(e){
	var imgDiv=$(this);
	if (list.imgSideWidth==0) {
		list.imgSideWidth = imgDiv.width();
		console.log("saving width: "+list.imgSideWidth);
	}
	if (imgDiv.hasClass("wide")) {
		console.log("closing");
		imgDiv.width(list.imgSideWidth);
		imgDiv.removeClass("wide");
	} else {
		console.log("opening");
		var newWidth = list.imgSideWidth*8;
		imgDiv.width(newWidth).addClass("wide");
	};	
	e.stopPropagation();
});

*/
/*
$(".img-side.img-set").click(function(e){
	  $( "#book" ).animate({
    opacity: 0.25,
    left: "+=50",
    height: "toggle"
  }, 5000, function() {
    // Animation complete.
  });
	var imgDiv=$(this);
	if (list.imgSideWidth==0) {
		list.imgSideWidth = imgDiv.width();
		list.imgWideWidth = list.imgSideWidth*8;
		console.log("saving width: "+list.imgSideWidth);
	}
	if (imgDiv.hasClass("wide")) {
		console.log("closing");
		//imgDiv.width(list.imgSideWidth);
		imgDiv.removeClass("wide");
		imgDiv.animate({
			width:list.imgSideWidth
		},500);		
	} else {
		console.log("opening");
		imgDiv.addClass("wide");
		imgDiv.animate({
			width:list.imgWideWidth
		},500);
		//imgDiv.width(list.imgWideWidth).addClass("wide");
	};	
	e.stopPropagation();
});
*/

//when I scroll lower than the position of the search-button, the search-box is appended a fixed-position div that says the search string in small type