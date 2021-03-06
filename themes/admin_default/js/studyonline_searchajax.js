/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Wed, 24 Dec 2014 06:56:00 GMT
 */
 
function split(val) {
	return val.split(/,\s*/);
}

function extractLast(term) {
	return split(term).pop();
}

$("#teacher_search").bind("keydown", function(event) {
	if (event.keyCode === $.ui.keyCode.TAB && $(this).data("ui-autocomplete").menu.active) {
		event.preventDefault();
	}
}).autocomplete({
	source : function(request, response) {
		$.getJSON(script_name + "?" + nv_name_variable + "=" + nv_module_name + "&" + nv_fc_variable + "=teacherajax", {
			term : extractLast(request.term)
		}, response);
	},
	search : function() {
		// custom minLength
		var term = extractLast(this.value);
		if (term.length < 2) {
			return false;
		}
	},
	focus : function() {
	  //no action
	},
	select : function(event, ui) {
		// add placeholder to get the comma-and-space at the end
		
            nv_add_element( 'teacherid', ui.item.key, ui.item.value );
            $(this).val('');
        
        return false;
	}
});

$("#khoahoc_search").bind("keydown", function(event) {
	if (event.keyCode === $.ui.keyCode.TAB && $(this).data("ui-autocomplete").menu.active) {
		event.preventDefault();
	}
}).autocomplete({
	source : function(request, response) {
		$.getJSON(script_name + "?" + nv_name_variable + "=" + nv_module_name + "&" + nv_fc_variable + "=khoahocajax", {
			term : extractLast(request.term)
		}, response);
	},
	search : function() {
		// custom minLength
		var term = extractLast(this.value);
		if (term.length < 2) {
			return false;
		}
	},
	focus : function() {
	  //no action
	},
	select : function(event, ui) {
		// add placeholder to get the comma-and-space at the end
		
            nv_add_element( 'khoahocid', ui.item.key, ui.item.value );
            $(this).val('');
        
        return false;
	}
});

$("#keywords-search").bind("keydown", function(event) {
	if (event.keyCode === $.ui.keyCode.TAB && $(this).data("ui-autocomplete").menu.active) {
		event.preventDefault();
	}

    if(event.keyCode==13){
        var keywords_add= $("#keywords-search").val();
        keywords_add = trim( keywords_add );
        if( keywords_add != '' ){
            nv_add_element( 'keywords', keywords_add, keywords_add );
            $(this).val('');
        }
        return false;
	}

}).autocomplete({
	source : function(request, response) {
		$.getJSON(script_name + "?" + nv_name_variable + "=" + nv_module_name + "&" + nv_fc_variable + "=tagsajax", {
			term : extractLast(request.term)
		}, response);
	},
	search : function() {
		// custom minLength
		var term = extractLast(this.value);
		if (term.length < 2) {
			return false;
		}
	},
	focus : function() {
	  //no action
	},
	select : function(event, ui) {
		// add placeholder to get the comma-and-space at the end
		if(event.keyCode!=13){
            nv_add_element( 'keywords', ui.item.value, ui.item.value );
            $(this).val('');
           }
        return false;
	}
});

function nv_add_element( idElment, key, value ){
   var html = "<span title=\"" + value + "\" class=\"uiToken removable\" ondblclick=\"$(this).remove();\">" + value + "<input type=\"hidden\" value=\"" + key + "\" name=\"" + idElment + "[]\" autocomplete=\"off\"><a onclick=\"$(this).parent().remove();\" href=\"javascript:void(0);\" class=\"remove uiCloseButton uiCloseButtonSmall\"></a></span>";
    $("#" + idElment).append( html );
	return false;
}