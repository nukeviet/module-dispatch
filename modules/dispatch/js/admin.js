/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Tue, 19 Jul 2011 09:07:26 GMT
 */

function nv_chang_cat_weight(catid) {
	var nv_timer = nv_settimeout_disable('weight' + catid, 2000);
	var newpos = document.getElementById( 'weight' + catid ).options[document.getElementById('weight' + catid).selectedIndex].value;
	$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=cat&nocache=' + new Date().getTime(), 'changeweight=1&catid=' + catid + '&new=' + newpos + '&num=' + nv_randomPassword(8), function(res) {
		nv_chang_cat_weight_result( res );
	});
	return;
}

//  ---------------------------------------

function nv_chang_cat_weight_result(res) {
	if (res != 'OK') {
		alert(nv_is_change_act_confirm[2]);
	}
	clearTimeout(nv_timer);
	window.location.href = window.location.href;
	return;
}

//  ---------------------------------------

function nv_chang_cat_status(catid) {
	var nv_timer = nv_settimeout_disable('change_status' + catid, 2000);
	$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=cat&nocache=' + new Date().getTime(), 'changestatus=1&catid=' + catid + '&num=' + nv_randomPassword(8), function(res) {
		nv_chang_cat_status_res( res );
	});
	return;
}

//  ---------------------------------------

function nv_chang_cat_status_res(res) {
	if (res != 'OK') {
		alert(nv_is_change_act_confirm[2]);
		window.location.href = window.location.href;
	}
	return;
}

//  ---------------------------------------

function nv_cat_del(catid) {
	if (confirm(cat_del_cofirm)) {
		$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=cat&nocache=' + new Date().getTime(), 'del=1&catid=' + catid + '&num=' + nv_randomPassword(8), function(res) {
			nv_cat_del_result( res );
		});
	}
	return false;
}

//  ---------------------------------------

function nv_cat_del_result(res) {
	if (res == 'OK') {
		window.location.href = window.location.href;
	} else {
		alert(nv_is_del_confirm[2]);
	}
	return false;
}

//  ---------------------------------------
function nv_chang_de_weight(deid) {
	var nv_timer = nv_settimeout_disable('weight' + deid, 2000);
	var newpos = document.getElementById( 'weight' + deid ).options[document.getElementById('weight' + deid).selectedIndex].value;
	$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=departments&nocache=' + new Date().getTime(), 'changeweight=1&deid=' + deid + '&new=' + newpos + '&num=' + nv_randomPassword(8), function(res) {
		nv_chang_de_weight_result( res );
	});
	return;
}

//  ---------------------------------------

function nv_chang_de_weight_result(res) {
	if (res != 'OK') {
		alert(nv_is_change_act_confirm[2]);
	}
	clearTimeout(nv_timer);
	window.location.href = window.location.href;
	return;
}

//  ---------------------------------------

function nv_de_del(deid) {
	if (confirm(de_del_cofirm)) {
		$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=departments&nocache=' + new Date().getTime(), 'del=1&deid=' + deid + '&num=' + nv_randomPassword(8), function(res) {
			nv_de_del_result( res );
		});
	}
	return false;
}

//  ---------------------------------------

function nv_de_del_result(res) {
	if (res == 'OK') {
		window.location.href = window.location.href;
	} else {
		alert(nv_is_del_confirm[2]);
	}
	return false;
}

//---------------------------------------
function nv_file_additem() {
	var a = '<input class="form-control w400 pull-left" value="" name="fileupload[]" id="fileupload' + file_items + '" style="margin-right: 5px" maxlength="255" />';
	a += '&nbsp;<input class="btn btn-primary" type="button" value="' + file_selectfile + '" name="selectfile" onclick="nv_open_browse( \'' + nv_base_adminurl + "index.php?" + nv_name_variable + "=upload&popup=1&area=fileupload" + file_items + "&path=" + file_dir + "&type=file', 'NVImg', 850, 500, 'resizable=no,scrollbars=no,toolbar=no,location=no,status=no' ); return false; \" /><br />";
	$("#fileupload_items").append('<label>' + a + '</label>');
	file_items++;
}

// ------------------------------
function nv_pro_del(fid) {
	if (confirm(pro_del_cofirm)) {
		$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&nocache=' + new Date().getTime(), 'del=1&id=' + fid + '&num=' + nv_randomPassword(8), function(res) {
			alert(res);
			nv_pro_del_result( res );
		});
	}
	return false;
}

//  ---------------------------------------

function nv_pro_del_result(res) {
	if (res == 'OK') {
		window.location.href = window.location.href;
	} else {
		alert(nv_is_del_confirm[2]);
	}
	return false;
}

//  ----------------------------------------
function nv_chang_type_weight(typeid) {
	var nv_timer = nv_settimeout_disable('weight' + typeid, 2000);
	var newpos = document.getElementById( 'weight' + typeid ).options[document.getElementById('weight' + typeid).selectedIndex].value;
	$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=type&nocache=' + new Date().getTime(), 'changeweight=1&typeid=' + typeid + '&new=' + newpos + '&num=' + nv_randomPassword(8), function(res) {
		nv_chang_type_weight_result( res );
	});
	return;
}

//  ---------------------------------------

function nv_chang_type_weight_result(res) {
	if (res != 'OK') {
		alert(nv_is_change_act_confirm[2]);
	}
	clearTimeout(nv_timer);
	window.location.href = window.location.href;
	return;
}

//  ---------------------------------------

function nv_chang_type_status(typeid) {
	var nv_timer = nv_settimeout_disable('change_status' + typeid, 2000);
	nv_ajax("post", script_name, nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=type&changestatus=1&typeid=' + typeid + '&num=' + nv_randomPassword(8), '', 'nv_chang_type_status_res');
	$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=type&nocache=' + new Date().getTime(), 'changestatus=1&typeid=' + typeid + '&num=' + nv_randomPassword(8), function(res) {
		nv_chang_type_status_res( res );
	});
	return;
}

//  ---------------------------------------

function nv_chang_type_status_res(res) {
	if (res != 'OK') {
		alert(nv_is_change_act_confirm[2]);
		window.location.href = window.location.href;
	}
	return;
}

//  ---------------------------------------

function nv_type_del(typeid) {
	if (confirm(type_del_cofirm)) {
		$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=type&nocache=' + new Date().getTime(), 'del=1&typeid=' + typeid + '&num=' + nv_randomPassword(8), function(res) {
			nv_type_del_result( res );
		});
	}
	return false;
}

//  ---------------------------------------

function nv_type_del_result(res) {
	if (res == 'OK') {
		window.location.href = window.location.href;
	} else {
		alert(nv_is_del_confirm[2]);
	}
	return false;
}

//  ---------------------------------------
function nv_link(singer) {

	var nv_timer = nv_settimeout_disable('from_signer_' + singer, 500);
	var new_status = document.getElementById('from_signer_' + singer).options[document.getElementById('from_signer_' + singer).selectedIndex].value;

	if (new_status != 0) {
		$('#hienthi').show();
		$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=add_document&nocache=' + new Date().getTime(), 'action=1&singer=' + new_status + '&num=' + nv_randomPassword(8), function(res) {
			$('#hienthi').html( res );
		});
	}
}

//--------------------------

function nv_clear_text() {
	$('input[type=text]').val("")
}

//---------------------------------------