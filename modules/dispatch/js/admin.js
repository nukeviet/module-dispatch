/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
 * @Createdate Tue, 19 Jul 2011 09:07:26 GMT
 */

 function nv_chang_cat_weight( catid )
{
   var nv_timer = nv_settimeout_disable( 'weight' + catid, 2000 );
   var newpos = document.getElementById( 'weight' + catid ).options[document.getElementById( 'weight' + catid ).selectedIndex].value;
   nv_ajax( "post", script_name, nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=cat&changeweight=1&catid=' + catid + '&new=' + newpos + '&num=' + nv_randomPassword( 8 ), '', 'nv_chang_cat_weight_result' );
   return;
}

//  ---------------------------------------

function nv_chang_cat_weight_result( res )
{
   if ( res != 'OK' )
   {
      alert( nv_is_change_act_confirm[2] );
   }
   clearTimeout( nv_timer );
   window.location.href = window.location.href;
   return;
}

//  ---------------------------------------

function nv_chang_cat_status( catid )
{
   var nv_timer = nv_settimeout_disable( 'change_status' + catid, 2000 );
   nv_ajax( "post", script_name, nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=cat&changestatus=1&catid=' + catid + '&num=' + nv_randomPassword( 8 ), '', 'nv_chang_cat_status_res' );
   return;
}

//  ---------------------------------------

function nv_chang_cat_status_res( res )
{
   if( res != 'OK' )
   {
      alert( nv_is_change_act_confirm[2] );
      window.location.href = window.location.href;
   }
   return;
}

//  ---------------------------------------

function nv_cat_del( catid )
{
   if ( confirm( cat_del_cofirm ) )
   {
      nv_ajax( 'post', script_name, nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=cat&del=1&catid=' + catid, '', 'nv_cat_del_result' );
   }
   return false;
}

//  ---------------------------------------

function nv_cat_del_result( res )
{
   if( res == 'OK' )
   {
      window.location.href = window.location.href;
   }
   else
   {
      alert( nv_is_del_confirm[2] );
   }
   return false;
}

//  ---------------------------------------
function nv_chang_de_weight( deid )
{
   var nv_timer = nv_settimeout_disable( 'weight' + deid, 2000 );
   var newpos = document.getElementById( 'weight' + deid ).options[document.getElementById( 'weight' + deid ).selectedIndex].value;
   nv_ajax( "post", script_name, nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=departments&changeweight=1&deid=' + deid + '&new=' + newpos + '&num=' + nv_randomPassword( 8 ), '', 'nv_chang_de_weight_result' );
   return;
}

//  ---------------------------------------

function nv_chang_de_weight_result( res )
{
   if ( res != 'OK' )
   {
      alert( nv_is_change_act_confirm[2] );
   }
   clearTimeout( nv_timer );
   window.location.href = window.location.href;
   return;
}

//  ---------------------------------------

function nv_de_del( deid )
{
   if ( confirm( de_del_cofirm ) )
   {
      nv_ajax( 'post', script_name, nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=departments&del=1&deid=' + deid, '', 'nv_de_del_result' );
   }
   return false;
}

//  ---------------------------------------

function nv_de_del_result( res )
{
   if( res == 'OK' )
   {
      window.location.href = window.location.href;
   }
   else
   {
      alert( nv_is_del_confirm[2] );
   }
   return false;
}

//---------------------------------------
function nv_file_additem() {
	var a = '<input class="txt" value="" name="fileupload[]" id="fileupload'
			+ file_items + '" style="width : 300px" maxlength="255" />';
	
		
	
	a += '&nbsp;<input type="button" value="'
			+ file_selectfile
			+ '" name="selectfile" onclick="nv_open_browse_file( \''
			+ nv_base_adminurl
			+ "index.php?"
			+ nv_name_variable
			+ "=upload&popup=1&area=fileupload"
			+ file_items
			+ "&path="
			+ file_dir
			+ "&type=file', 'NVImg', 850, 500, 'resizable=no,scrollbars=no,toolbar=no,location=no,status=no' ); return false; \" /><br />";
	$("#fileupload_items").append(a);
	file_items++
}
// ------------------------------
function nv_pro_del( fid )
{
	if ( confirm( pro_del_cofirm ) )
   {
      nv_ajax( 'post', script_name, nv_name_variable + '=' + nv_module_name + '&del=1&id=' + fid, '', 'nv_pro_del_result' );
   }
   return false;
}

//  ---------------------------------------

function nv_pro_del_result( res )
{
   if( res == 'OK' )
   {
      window.location.href = window.location.href;
   }
   else
   {
      alert( nv_is_del_confirm[2] );
   }
   return false;
}

//  ----------------------------------------
function nv_chang_type_weight( typeid )
{
   var nv_timer = nv_settimeout_disable( 'weight' + typeid, 2000 );
   var newpos = document.getElementById( 'weight' + typeid ).options[document.getElementById( 'weight' + typeid ).selectedIndex].value;
   nv_ajax( "post", script_name, nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=type&changeweight=1&typeid=' + typeid + '&new=' + newpos + '&num=' + nv_randomPassword( 8 ), '', 'nv_chang_type_weight_result' );
   return;
}

//  ---------------------------------------

function nv_chang_type_weight_result( res )
{
   if ( res != 'OK' )
   {
      alert( nv_is_change_act_confirm[2] );
   }
   clearTimeout( nv_timer );
   window.location.href = window.location.href;
   return;
}

//  ---------------------------------------

function nv_chang_type_status( typeid )
{
   var nv_timer = nv_settimeout_disable( 'change_status' + typeid, 2000 );
   nv_ajax( "post", script_name, nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=type&changestatus=1&typeid=' + typeid + '&num=' + nv_randomPassword( 8 ), '', 'nv_chang_type_status_res' );
   return;
}

//  ---------------------------------------

function nv_chang_type_status_res( res )
{
   if( res != 'OK' )
   {
      alert( nv_is_change_act_confirm[2] );
      window.location.href = window.location.href;
   }
   return;
}

//  ---------------------------------------

function nv_type_del( typeid )
{
   if ( confirm( type_del_cofirm ) )
   {
      nv_ajax( 'post', script_name, nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=type&del=1&typeid=' + typeid, '', 'nv_type_del_result' );
   }
   return false;
}

//  ---------------------------------------

function nv_type_del_result( res )
{
   if( res == 'OK' )
   {
      window.location.href = window.location.href;
   }
   else
   {
      alert( nv_is_del_confirm[2] );
   }
   return false;
}

//  ---------------------------------------
function nv_link(singer){
	
	var nv_timer = nv_settimeout_disable('from_signer_' + singer, 500);
	var new_status = document.getElementById('from_signer_' + singer).options[document.getElementById('from_signer_' + singer).selectedIndex].value;	
	
	if(new_status!=0)
	{
		$('#hienthi').show();
		nv_ajax( "post", script_name, nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=add_document&action=1&singer='+new_status,'hienthi','' );
	}
}
//--------------------------
function nv_view_group(idwho){
	
	var nv_timer = nv_settimeout_disable('who_view_' + idwho, 500);
	var new_status = document.getElementById('who_view_' + idwho).options[document.getElementById('who_view_' + idwho).selectedIndex].value;	
		
	$('#nhom').show();
	nv_ajax( "post", script_name, nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=add_document&view=1&who='+new_status,'nhom','' );
	
	
}
//--------------------------

function nv_clear_text()
{
	$('input[type=text]').val("")
}
//---------------------------------------