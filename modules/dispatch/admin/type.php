<?php

/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
 * @Createdate Tue, 19 Jul 2011 09:07:26 GMT
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

/**
 * nv_FixWeighttype()
 * 
 * @param integer $parentid
 * @return
 */
function nv_FixWeighttype ( $parentid = 0 )
{
    global $db, $module_data;
    
    $sql = "SELECT `id` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_type` WHERE `parentid`=" . $parentid . " ORDER BY `weight` ASC";
    $result = $db->sql_query( $sql );
    $weight = 0;
    while ( $row = $db->sql_fetchrow( $result ) )
    {
        $weight ++;
        $db->sql_query( "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_type` SET `weight`=" . $weight . " WHERE `id`=" . $row['id'] );
    }
}

/**
 * nv_del_type()
 * 
 * @param mixed $typeid
 * @return
 */
function nv_del_type ( $typeid )
{
    global $db, $module_data;
                     
    $sql = "DELETE FROM `" . NV_PREFIXLANG . "_" . $module_data . "_document` WHERE `typeid`=" . $typeid ;
    $db->sql_query( $sql );
    
    $sql = "SELECT `id` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_type` WHERE `parentid`=" . $typeid;
    $result = $db->sql_query( $sql );
    while ( list( $id ) = $db->sql_fetchrow( $result ) )
    {
        nv_del_type( $id );
    }
    
    $sql = "DELETE FROM `" . NV_PREFIXLANG . "_" . $module_data . "_type` WHERE `id`=" . $typeid;
    $db->sql_query( $sql );
    nv_insert_logs( NV_LANG_DATA, $module_data, "delete dispatch" ,'', $admin_info['userid'],'' );
}

$array = array();
$error = "";

//them chu de
if ( $nv_Request->isset_request( 'add', 'get' ) )
{
	
	$page_title = $lang_module['type_add']; 
    $is_error = false;
    if ( $nv_Request->isset_request( 'submit', 'post' ) )
    {
        $array['parentid'] = $nv_Request->get_int( 'parentid', 'post', 0 );
        $array['title'] = filter_text_input( 'title', 'post', '', 1 );        
        
        $array['alias'] = change_alias($array['title']);
       
        if ( empty( $array['title'] ) )
        {
            $error = $lang_module['type_err_notitle'];
            $is_error = true;
        }
        else
        {
            if ( ! empty( $array['parentid'] ) )
            {
                $sql = "SELECT COUNT(*) AS count FROM `" . NV_PREFIXLANG . "_" . $module_data . "_type` WHERE `id`=" . $array['parentid'];
                $result = $db->sql_query( $sql );
                list( $count ) = $db->sql_fetchrow( $result );
                
                if ( ! $count )
                {
                    $error = $lang_module['type_err_noexist'];
                    $is_error = true;
                }
            }
            
            if ( ! $is_error )
            {
                $sql = "SELECT COUNT(*) AS count FROM `" . NV_PREFIXLANG . "_" . $module_data . "_type` WHERE `alias`=" . $db->dbescape($array['alias']);
                $result = $db->sql_query( $sql );
                list( $count ) = $db->sql_fetchrow( $result );
                
                if ( $count )
                {
                    $error = $lang_module['type_err_exist'];
                    $is_error = true;
                }
            }
        }
         
        if ( ! $is_error )
        {                        
            $sql = "SELECT MAX(weight) AS new_weight FROM `" . NV_PREFIXLANG . "_" . $module_data . "_type` WHERE `parentid`=" . $array['parentid'];
            $result = $db->sql_query( $sql );
            list( $new_weight ) = $db->sql_fetchrow( $result );
            $new_weight = ( int )$new_weight;
            $new_weight ++;
            
            $sql = "INSERT INTO `" . NV_PREFIXLANG . "_" . $module_data . "_type` VALUES (
            NULL, 
            " . $array['parentid'] . ", 
            '',
            " . $db->dbescape( $array['title'] ) . ",
            " . $new_weight . ", 
            1)";
           
            $typeid = $db->sql_query_insert_id( $sql );
            $query = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_type` SET 
                		`alias`=" . $db->dbescape( $array['alias'] . "-" . $typeid ) . " WHERE `id`=" . $typeid;
             $db->sql_query( $query );
            
            if ( ! $typeid )
            {
                $error = $lang_module['type_err_save'];
                $is_error = true;
            }
            else
            {
            	nv_insert_logs( NV_LANG_DATA, $module_name, $lang_module['type_add'] ,$array['title'], $admin_info['userid'] );
                nv_del_moduleCache( $module_name );
                Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=type" );
                exit();
            }
        }
    }
    else
    {
        $array['parentid'] = 0;
        $array['title'] = "";
        $array['alias'] = "";
        $array['description'] = "";
    }
    
    $listtypes = array( 
        array( 
        'id' => 0, 'name' => $lang_module['type_maintype'], 'selected' => "" 
    ) 
    );
    $listtypes = $listtypes + nv_listtypes( $array['parentid'] );           
    $xtpl = new XTemplate( "type_add.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
    $xtpl->assign( 'FORM_ACTION', NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $op . "&amp;add=1" );
    $xtpl->assign( 'LANG', $lang_module );
    $xtpl->assign( 'DATA', $array );
    
    if ( ! empty( $error ) )
    {
        $xtpl->assign( 'ERROR', $error );
        $xtpl->parse( 'main.error' );
    }
    
    foreach ( $listtypes as $type )
    {
        $xtpl->assign( 'LISTTYPES', $type );
        $xtpl->parse( 'main.parentid' );
    }
            
    $xtpl->parse( 'main' );
    $contents = $xtpl->text( 'main' );
    
    include ( NV_ROOTDIR . "/includes/header.php" );
    echo nv_admin_theme( $contents );
    include ( NV_ROOTDIR . "/includes/footer.php" );
    
    exit();
}


//Sua chu de
if ( $nv_Request->isset_request( 'edit', 'get' ) )
{
    $page_title = $lang_module['type_edit'];
    
    $typeid = $nv_Request->get_int( 'typeid', 'get', 0 );
    
    if ( empty( $typeid ) )
    {
        Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=type" );
        exit();
    }
    
    $sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_type` WHERE `id`=" . $typeid;
    $result = $db->sql_query( $sql );
    $numtype = $db->sql_numrows( $result );
    
    if ( $numtype != 1 )
    {
        Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=type" );
        exit();
    }
    
    $row = $db->sql_fetchrow( $result );
    
    $is_error = false;
    
    if ( $nv_Request->isset_request( 'submit', 'post' ) )
    {
        $array['parentid'] = $nv_Request->get_int( 'parentid', 'post', 0 );
        $array['title'] = filter_text_input( 'title', 'post', '', 1 );
        $array['introduction'] = filter_text_input( 'introduction', 'post', '' );
        
        
        $array['alias'] = change_alias($array['title']);

        if ( empty( $array['title'] ) )
        {
            $error = $lang_module['type_err_notitle'];
            $is_error = true;
        }
        else
        {
            if ( ! empty( $array['parentid'] ) )
            {
                $sql = "SELECT COUNT(*) AS count FROM `" . NV_PREFIXLANG . "_" . $module_data . "_type` WHERE `id`=" . $array['parentid'];
                $result = $db->sql_query( $sql );
                list( $count ) = $db->sql_fetchrow( $result );
                
                if ( ! $count )
                {
                    $error = $lang_module['type_err_noexist'];
                    $is_error = true;
                }
            }
            
            if ( ! $is_error )
            {
                $sql = "SELECT COUNT(*) AS count FROM `" . NV_PREFIXLANG . "_" . $module_data . "_type` WHERE `id`!=" . $typeid . " AND `alias`=" . $db->dbescape($array['alias']);
                $result = $db->sql_query( $sql );
                list( $count ) = $db->sql_fetchrow( $result );
                if ( $count )
                {
                    $error = $lang_module['type_err_exist'];
                    $is_error = true;
                }
            }
        }
        
        if ( ! $is_error )
        {                        
            if ( $array['parentid'] != $row['parentid'] )
            {
                $sql = "SELECT MAX(weight) AS new_weight FROM `" . NV_PREFIXLANG . "_" . $module_data . "_type` WHERE `parentid`=" . $array['parentid'];
                $result = $db->sql_query( $sql );
                list( $new_weight ) = $db->sql_fetchrow( $result );
                $new_weight = ( int )$new_weight;
                $new_weight ++;
            }
            else
            {
                $new_weight = $row['weight'];
            }
            
            $sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_type` SET 
            `parentid`=" . $array['parentid'] . ", 
            `title`=" . $db->dbescape( $array['title'] ) . ", 
            `alias`='',            
            `weight`=" . $new_weight . " 
            WHERE `id`=" . $typeid;
            $result = $db->sql_query( $sql );
            
            $query = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_type` SET 
                		`alias`=" . $db->dbescape( $array['alias'] . "-" . $typeid ) . " WHERE `id`=" . $typeid;
                    $db->sql_query( $query );
            
            if ( ! $result )
            {
                $error = $lang_module['type_err_update'];
                $is_error = true;
            }
            else
            {
                if ( $array['parentid'] != $row['parentid'] )
                {
                    nv_FixWeighttype( $row['parentid'] );
                }
                
                nv_del_moduleCache( $module_name );
                nv_insert_logs( NV_LANG_DATA, $module_name, $lang_module['type_edit'] ,$array['title'], $admin_info['userid'] );
                Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=type" );
                exit();
            }
        }
    }
    else
    {
        $array['parentid'] = ( int )$row['parentid'];
        $array['title'] = $row['title'];
        $array['alias'] = $row['alias'];
        
    }
    
   $listtypes = array( 
        array( 
        'id' => 0, 'name' => $lang_module['type_maintype'], 'selected' => "" 
    ) 
    );
    $listtypes = $listtypes + nv_listtypes( $array['parentid'] ); 
            
    $xtpl = new XTemplate( "type_add.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
    $xtpl->assign( 'FORM_ACTION', NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $op . "&amp;edit=1&amp;typeid=" . $typeid );
    $xtpl->assign( 'LANG', $lang_module );
    $xtpl->assign( 'DATA', $array );
    
    if ( ! empty( $error ) )
    {
        $xtpl->assign( 'ERROR', $error );
        $xtpl->parse( 'main.error' );
    }
    
    foreach ( $listtypes as $type )
    {
        $xtpl->assign( 'LISTTYPES', $type );
        $xtpl->parse( 'main.parentid' );
    }
            
    $xtpl->parse( 'main' );
    $contents = $xtpl->text( 'main' );
    
    include ( NV_ROOTDIR . "/includes/header.php" );
    echo nv_admin_theme( $contents );
    include ( NV_ROOTDIR . "/includes/footer.php" );
    
    exit();
}


//Xoa chu de
if ( $nv_Request->isset_request( 'del', 'post' ) )
{
    if ( ! defined( 'NV_IS_AJAX' ) ) die( 'Wrong URL' );
    
    $typeid = $nv_Request->get_int( 'typeid', 'post', 0 );
    
    if ( empty( $typeid ) )
    {
        die( "NO" );
    }
    
    $sql = "SELECT COUNT(*) AS count, `parentid` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_type` WHERE `id`=" . $typeid;
    $result = $db->sql_query( $sql );
    list( $count, $parentid ) = $db->sql_fetchrow( $result );
    
    if ( $count != 1 )
    {
        die( "NO" );
    }
    
    nv_del_type( $typeid );
    nv_FixWeighttype( $parentid );
    nv_del_moduleCache( $module_name );
    
    die( "OK" );
}
//Chinh thu tu chu de
if ( $nv_Request->isset_request( 'changeweight', 'post' ) )
{
    if ( ! defined( 'NV_IS_AJAX' ) ) die( 'Wrong URL' );
    
    $typeid = $nv_Request->get_int( 'typeid', 'post', 0 );
    $new = $nv_Request->get_int( 'new', 'post', 0 );
    
    if ( empty( $typeid ) ) die( "NO" );
    
    $query = "SELECT `parentid` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_type` WHERE `id`=" . $typeid;
    $result = $db->sql_query( $query );
    $numrows = $db->sql_numrows( $result );
    if ( $numrows != 1 ) die( 'NO' );
    list( $parentid ) = $db->sql_fetchrow( $result );
    
    $query = "SELECT `id` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_type` WHERE `id`!=" . $typeid . " AND `parentid`=" . $parentid . " ORDER BY `weight` ASC";
    $result = $db->sql_query( $query );
    $weight = 0;
    while ( $row = $db->sql_fetchrow( $result ) )
    {
        $weight ++;
        if ( $weight == $new ) $weight ++;
        $sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_type` SET `weight`=" . $weight . " WHERE `id`=" . $row['id'];
        $db->sql_query( $sql );
    }
    $sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_type` SET `weight`=" . $new . " WHERE `id`=" . $typeid;
    $db->sql_query( $sql );
    
    nv_del_moduleCache( $module_name );
    
    die( "OK" );
}

//Kich hoat - dinh chi
if ( $nv_Request->isset_request( 'changestatus', 'post' ) )
{
    if ( ! defined( 'NV_IS_AJAX' ) ) die( 'Wrong URL' );
    
    $typeid = $nv_Request->get_int( 'typeid', 'post', 0 );
    
    if ( empty( $typeid ) ) die( "NO" );
    
    $query = "SELECT `status` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_type` WHERE `id`=" . $typeid;
    $result = $db->sql_query( $query );
    $numrows = $db->sql_numrows( $result );
    if ( $numrows != 1 ) die( 'NO' );
    
    list( $status ) = $db->sql_fetchrow( $result );
    $status = $status ? 0 : 1;
    
    $sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_type` SET `status`=" . $status . " WHERE `id`=" . $typeid;
    $db->sql_query( $sql );
    
    nv_del_moduleCache( $module_name );
    
    die( "OK" );
}


//Danh sach chu de
$page_title = $lang_module['type_list'];

$pid = $nv_Request->get_int( 'pid', 'get', 0 );

$sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_type` WHERE `parentid`=" . $pid . " ORDER BY `weight` ASC";
$result = $db->sql_query( $sql );
$num = $db->sql_numrows( $result );

if ( ! $num )
{
    if ( $pid )
    {
        Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=type" );
       
    }
    else
    {
    	
        Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=type&add=1" );
        
    }
    exit();
}

if ( $pid )
{
    $sql2 = "SELECT `title`,`parentid` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_type` WHERE `id`=" . $pid;
    $result2 = $db->sql_query( $sql2 );
    list( $parentid, $parentid2 ) = $db->sql_fetchrow( $result2 );
    $caption = sprintf( $lang_module['table_type2'], $parentid );
    $parentid = "<a href=\"" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=type&amp;pid=" . $parentid2 . "\">" . $parentid . "</a>";
}
else
{
    $caption = $lang_module['table_type1'];
    $parentid = $lang_module['type_maintype'];
}

$list = array();
$a = 0;

while ( $row = $db->sql_fetchrow( $result ) )
{
    $numsub = $db->sql_numrows( $db->sql_query( "SELECT `id` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_type` WHERE parentid=" . $row['id'] ) );
    if ( $numsub )
    {
        $numsub = " (<a href=\"" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=type&amp;pid=" . $row['id'] . "\">" . $numsub . " " . $lang_module['type_sub'] . "</a>)";
    }
    else
    {
        $numsub = "";
    }
    
    $weight = array();
    for ( $i = 1; $i <= $num; $i ++ )
    {
        $weight[$i]['title'] = $i;
        $weight[$i]['pos'] = $i;
        $weight[$i]['selected'] = ( $i == $row['weight'] ) ? " selected=\"selected\"" : "";
    }
    
    $class = ( $a % 2 ) ? " class=\"second\"" : "";
    
    $list[$row['id']] = array(  //
        'id' => ( int )$row['id'], //
		'title' => $row['title'], //
		'titlelink' => NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;typeid=" . $row['id'], //
		'numsub' => $numsub, //
		'parentid' => $parentid, //
		'weight' => $weight, //
    	'status' => $row['status'] ? " checked=\"checked\"" : "", //		
		'class' => $class  //
    );
    
    $a ++;
}

$xtpl = new XTemplate( "type_list.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
$xtpl->assign( 'ADD_NEW_TYPE', NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=type&amp;add=1" );
$xtpl->assign( 'TABLE_CAPTION', $caption );
$xtpl->assign( 'GLANG', $lang_global );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
$xtpl->assign( 'MODULE_NAME', $module_name );
$xtpl->assign( 'OP', $op );

foreach ( $list as $row )
{
    $xtpl->assign( 'ROW', $row );
    
    foreach ( $row['weight'] as $weight )
    {
        $xtpl->assign( 'WEIGHT', $weight );
        $xtpl->parse( 'main.row.weight' );
    }
    
    $xtpl->assign( 'EDIT_URL', NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=type&amp;edit=1&amp;typeid=" . $row['id'] );
    $xtpl->parse( 'main.row' );
}

$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_admin_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>