
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