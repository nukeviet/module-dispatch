<?php

/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
 * @Createdate Tue, 19 Jul 2011 09:07:26 GMT
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

//tao du lieu cho lich su giao dich
$my_head = "<script type=\"text/javascript\" src=\"" . NV_BASE_SITEURL . "js/popcalendar/popcalendar.js\"></script>\n";
$my_head .= "<script type=\"text/javascript\" src=\"" . NV_BASE_SITEURL . "js/shadowbox/shadowbox.js\"></script>\n";
$my_head .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . NV_BASE_SITEURL . "js/shadowbox/shadowbox.css\" />\n";
$my_head .= "<script type=\"text/javascript\">\n";
$my_head .= "Shadowbox.init({\n";
$my_head .= "});\n";
$my_head .= "</script>\n";

$array['parentid'] = $catid = $array['type'] = $array['from_signer'] = $array['from_depid'] = 0;
$arr_de['parentid'] = $array['statusid'] = $deid = $id = 0;
$arr_imgs = $arr_img = $list_de = $lis = $listde = array();
$array['from_time'] = $array['date_iss'] = $array['date_first'] = $array['date_die'] = $array['who_view'] = $check = $to_person = $to_recipient = $error = '';
$array['groups_view'] = array();
$id = $nv_Request->get_int( 'id', 'get', 0 );

// System groups user
$groups_list = nv_groups_list();

$array_who = array( 
    $lang_global['who_view0'], $lang_global['who_view1'], $lang_global['who_view2'] 
);

if ( ! empty( $groups_list ) )
{
    $array_who[] = $lang_global['who_view3'];
}

$sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_document` WHERE `id`=" . $id;
$result = $db->sql_query( $sql );
$num = $db->sql_numrows( $result );
if ( $num > 0 )
{
    $array = $db->sql_fetchrow( $result );
    $array['parentid'] = $array['catid'];
    $array['statusid'] = $array['status'];
    $array['groups_view'] = explode(",", $array['groups_view'] );
    $arr_imgs = explode( ',', $array['file'] );
    
    $sql1 = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_de_do` WHERE `doid`=" . $id;
    
    $result1 = $db->sql_query( $sql1 );
    $nu = $db->sql_numrows( $result1 );
    if ( $nu > 0 )
    {
        while ( $r = $db->sql_fetchrow( $result1 ) )
        {
            $listde[] = $r['deid'];            
        }
    
    }

}

if ( $nv_Request->isset_request( 'submit', 'post' ) )
{
    
    $id = $nv_Request->get_int( 'id', 'post', 0 );
    
    $gr = array();
    
    $gr = $nv_Request->get_typed_array( 'groups_view', 'post', '' );
    $array['groups_view'] = implode( ",", $gr );
    $array['who_view'] = $nv_Request->get_int( 'who_view', 'post', 0 );
    $array['parentid'] = $nv_Request->get_int( 'parentid', 'post', 0 );
    $array['type'] = $nv_Request->get_int( 'typeid', 'post', 0 );
    $array['from_depid'] = $nv_Request->get_int( 'from_depid', 'post', 0 );
    $array['title'] = $nv_Request->get_string( 'title', 'post', '', '' );
    $array['alias'] = change_alias( $array['title'] );
    $array['code'] = $nv_Request->get_string( 'code', 'post', '' );
    $array['to_org'] = $nv_Request->get_string( 'to_org', 'post', '' );
    $array['from_org'] = $nv_Request->get_string( 'from_org', 'post', '' );
    $array['from_signer'] = $nv_Request->get_int( 'from_signer', 'post', 0 );
    $array['content'] = $nv_Request->get_string( 'content', 'post', '' );
    $array['statusid'] = $nv_Request->get_int( 'statusid', 'post', 0 );
    $arr_img = $nv_Request->get_typed_array( 'fileupload', 'post', 'string' );
    $array['from_time'] = filter_text_input( 'from_time', 'post', '', '' );
    
    
    if ( ! empty( $array['from_time'] ) )
    {
        unset( $m );
        if ( preg_match( "/^([0-9]{1,2})\.([0-9]{1,2})\.([0-9]{4})$/", $array['from_time'], $m ) )
        {
            $array['from_time'] = mktime( 0, 0, 0, $m[2], $m[1], $m[3] );
        }
        else
        {
            die( $lang_module['in_result_errday'] );
        }
    }
    else
    {
        $array['from_time'] = '';
    }
    
    $array['date_iss'] = filter_text_input( 'date_iss', 'post', '', 1 );
    
    if ( ! empty( $array['date_iss'] ) )
    {
        unset( $m );
        if ( preg_match( "/^([0-9]{1,2})\.([0-9]{1,2})\.([0-9]{4})$/", $array['date_iss'], $m ) )
        {
            $array['date_iss'] = mktime( 0, 0, 0, $m[2], $m[1], $m[3] );
        }
        else
        {
            die( $lang_module['in_result_errday'] );
        }
    }
    else
    {
        $array['date_iss'] = '';
    }
    
    $array['date_first'] = filter_text_input( 'date_first', 'post', '', 1 );
    
    if ( ! empty( $array['date_first'] ) )
    {
        unset( $m );
        if ( preg_match( "/^([0-9]{1,2})\.([0-9]{1,2})\.([0-9]{4})$/", $array['date_first'], $m ) )
        {
            $array['date_first'] = mktime( 0, 0, 0, $m[2], $m[1], $m[3] );
        }
        else
        {
            die( $lang_module['in_result_errday'] );
        }
    }
    else
    {
        $array['date_first'] = '';
    }
    
    $array['date_die'] = filter_text_input( 'date_die', 'post', '', 1 );
    
    if ( ! empty( $array['date_die'] ) )
    {
        unset( $m );
        if ( preg_match( "/^([0-9]{1,2})\.([0-9]{1,2})\.([0-9]{4})$/", $array['date_die'], $m ) )
        {
            $array['date_die'] = mktime( 0, 0, 0, $m[2], $m[1], $m[3] );
        }
        else
        {
            die( $lang_module['in_result_errday'] );
        }
    }
    else
    {
        $array['date_die'] = 0;
    }
    
    $cut = strlen( NV_BASE_SITEURL . "uploads/" . $module_name . "/" );
    
    foreach ( $arr_img as $arr )
    {
        $arr_imgs[] = substr( $arr, $cut, strlen( $arr ) );
    }
    $array['file'] = ( ! empty( $arr_imgs ) ) ? implode( ",", $arr_imgs ) : "";
    
    $listde = $nv_Request->get_typed_array( 'deid', 'post', 'int' );
        
    if ( $error == '' )
    {
        
        if ( $array['title'] == "" )
        {
            $error = $lang_module['error_title'];
        }
        else if ( $array['code'] == '' )
        {
            $error = $lang_module['error_code'];
        }
        else if ( $array['from_time'] == '' )
        {
            $error = $lang_module['error_from_time'];
        }
        else if ( $array['from_signer'] == '' )
        {
            $error = $lang_module['error_si'];
        }
        else if ( $array['date_iss'] == '' )
        {
            $error = $lang_module['error_iss'];
        }
        else if ( $array['date_first'] == '' )
        {
            $error = $lang_module['error_first'];
        }
        else if ( $array['from_org'] == '' )
        {
            $error = $lang_module['error_souce'];
        }
        else if ( $array['date_iss'] > $array['date_first'] )
        {
            $error = $lang_module['error_iss_first'];
        }
        else if ( $array['from_time'] > $array['date_iss'] )
        {
            $error = $lang_module['error_iss_time'];
            
        }
        else if ( $array['date_die'] != 0 && ( $array['date_die'] < $array['date_first'] ) )
        {
            $error = $lang_module['error_die_first'];
        }
        else
        { 
            if ( $id != 0 )
            {
                $sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_document` SET 
                    `catid` = " . $array['parentid'] . ",
                    `type` = " . $array['type'] . ",                    
                    `title` = " . $db->dbescape( $array['title'] ) . ",
                    `alias` = '',
					`code` = '" . $array['code'] . "',
					`content`= " . $db->dbescape( $array['content'] ) . ",
					`file` = " . $db->dbescape( $array['file'] ) . ",
					`from_org` = " . $db->dbescape( $array['from_org'] ) . ",
					`to_org` = " . $db->dbescape( $array['to_org'] ) . ",
					`from_depid` = " . $array['from_depid'] . ",
					`from_signer` = " . $array['from_signer'] . ",
					`from_time` = " . $array['from_time'] . ",					
					`date_iss` = " . $array['date_iss'] . ",
					`date_first` = " . $array['date_first'] . ",
					`date_die` = " . $array['date_die'] . ",
					`who_view` = " . $array['who_view'] . ",
					`groups_view` = " . $db->dbescape( $array['groups_view'] ) . ",
					`status` = " . $array['statusid'] . " WHERE `id` = " . $id;
                
                if ( $db->sql_query( $sql ) )
                {
                    $db->sql_query( "DELETE FROM `" . NV_PREFIXLANG . "_" . $module_data . "_de_do` WHERE `doid` =" . $id );
                    $query = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_document` SET 
                		`alias`=" . $db->dbescape( $array['alias'] . "-" . $id ) . " WHERE `id`=" . $id;
                    $db->sql_query( $query );
                    
                    if ( ! empty( $listde ) )
                    {
                        foreach ( $listde as $k  )
                        {
                            
                            $sql1 = "INSERT INTO `" . NV_PREFIXLANG . "_" . $module_data . "_de_do` VALUES (
								NULL,					
								" . $id . ", 
								" . $k . "		
								)";
                            
                            $db->sql_query( $sql1 );
                        }
                    }
                    
                    Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=main" );
                    exit();
                
                }
                else
                {
                    $error = $lang_module['error_update'];
                }
            }
            else
            {
                $sql = "INSERT INTO `" . NV_PREFIXLANG . "_" . $module_data . "_document` VALUES (
					NULL, 
					" . $array['type'] . ", 
					" . $array['parentid'] . ",'',
					" . $db->dbescape( $array['title'] ) . ",
					" . $db->dbescape( $array['code'] ) . ",
					" . $db->dbescape( $array['content'] ) . ",
					" . $db->dbescape( $array['file'] ) . ",
					" . $db->dbescape( $array['from_org'] ) . "," . $array['from_depid'] . ",
					" . $array['from_signer'] . ",
					" . $array['from_time'] . ",
					" . $array['date_iss'] . ",
					" . $array['date_first'] . ",
					" . $array['date_die'] . "," . $db->dbescape( $array['to_org'] ) . "," . $array['who_view'] . "," . $db->dbescape( $array['groups_view'] ) . "," . $array['statusid'] . ",0
					)";
                
                $array['id'] = $db->sql_query_insert_id( $sql );
                
                if ( $array['id'] > 0 )
                {
                    $query = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_document` SET 
                	`alias`=" . $db->dbescape( $array['alias'] . "-" . $array['id'] ) . " WHERE `id`=" . $array['id'];
                    $db->sql_query( $query );
                    if ( ! empty( $listde ) )
                    {
                        foreach ( $listde as $k  )
                        {
                            
                            $sql1 = "INSERT INTO `" . NV_PREFIXLANG . "_" . $module_data . "_de_do` VALUES (
							NULL,					
							" . $array['id'] . ",
							" . $k . "					
							 					
							)";
                            
                            $db->sql_query( $sql1 );
                        }
                    }
                    
                    Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=main" );
                    exit();
                
                }
                else
                {
                    $error = $lang_module['error_insert'];
                }
            }
        }
    }
}

$who_view = $array['who_view'];
$arrs['who_view'] = array();

foreach ( $array_who as $key => $who )
{
    $arrs['who_view'][] = array( 
        'key' => $key, //
		'title' => $who, //
		'selected' => $key == $who_view ? " selected=\"selected\"" : ""  //
    );
}

$groups_view = $array['groups_view'];

$arrs['groups_view'] = array();
if ( ! empty( $groups_list ) )
{
    foreach ( $groups_list as $key => $title )
    {
        if ( ! empty( $groups_view ) )
        {
            $arrs['groups_view'][] = array( 
                'key' => $key, //
				'title' => $title, //
				'checked' => in_array( $key, $array['groups_view'] ) ? " checked=\"checked\"" : ""  //
            );
        }
        else
        {
            $arrs['groups_view'][] = array( 
                'key' => $key, //
'title' => $title, //
'checked' => ""  //
            );
        }
    }
}

$fileupload_num = count( $arr_img );
$listcats = nv_listcats( $array['parentid'], 0 );
$listtypes = nv_listtypes( $array['type'], 0 );
$listdes = array( 
    array( 
    'id' => 0, 'parentid' => 0, 'alias' => '', 'title' => $lang_module['chos_de'], 'name' => $lang_module['chos_de'], 'selected' => '', 'checked' => '' 
) 
);
$listdes = $listdes + nv_listdes( $array['from_depid'], 0 );

$listsinger = nv_signerList( $array['from_signer'] );

foreach ( $listdes as $li )
{
    if ( ! empty( $listdes ) )
    {
        foreach ( $listde as $l )
        {
            if ( $l == $li['id'] )
            {
                $check = ' checked= "checked" '; 
            }
            else
            {
                $check = '';
            }
        
        }
    }
    else
    {
        $check = '';
    }
    if ( $li['id'] != 0 )
    {
        $lis[] = array( 
            'id' => ( int )$li['id'], //			
			'alias' => $li['alias'], //
			'name' => $li['title'], // 
			'checked' => $check, //

        );
    }

}

foreach ( $arr_status as $a )
{
    $as[] = array( 
        'id' => $a['id'], //
'name' => $a['name'], //
'selected' => $a['id'] == $array['statusid'] ? " selected=\"selected\"" : ""  //
    );
}
$xtpl = new XTemplate( "add_document.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
$xtpl->assign( 'MODULE_NAME', $module_name );
$xtpl->assign( 'OP', $op );
$xtpl->assign( 'id', $id );
$xtpl->assign( 'FILES_DIR', NV_UPLOADS_DIR . '/' . $module_name );
$xtpl->assign( 'fileupload_num', $fileupload_num );
$xtpl->assign( 'FORM_ACTION', NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $op );

if ( $array['from_time'] != '' )
{
    $array['from_time'] = date( "d.m.Y", $array['from_time'] );
}

if ( $array['date_iss'] != '' )
{
    $array['date_iss'] = date( "d.m.Y", $array['date_iss'] );
}

if ( $array['date_first'] != '' )
{
    $array['date_first'] = date( "d.m.Y", $array['date_first'] );
}

if ( $array['date_die'] != '' && $array['date_die'] != 0 )
{
    $array['date_die'] = date( "d.m.Y", $array['date_die'] );
}

$xtpl->assign( 'DATA', $array );

foreach ( $listcats as $cat )
{
    $xtpl->assign( 'LISTCATS', $cat );
    $xtpl->parse( 'inter.parentid' );
}

foreach ( $listtypes as $type )
{
    $xtpl->assign( 'LISTTYPES', $type );
    $xtpl->parse( 'inter.typeid' );
}

foreach ( $listsinger as $singer )
{
    $xtpl->assign( 'LISSIS', $singer );
    $xtpl->parse( 'inter.from_signer' );
}

foreach ( $listdes as $de )
{
    $xtpl->assign( 'LISTDES', $de );
    $xtpl->parse( 'inter.from_depid' );
}

foreach ( $as as $a )
{
    $xtpl->assign( 'LISTSTATUS', $a );
    $xtpl->parse( 'inter.statusid' );
}

foreach ( $lis as $de )
{
    $xtpl->assign( 'ROW', $de );
    $xtpl->parse( 'inter.loop' );
}
$a = 0;
if ( ! empty( $arr_imgs ) )
{
    $str = NV_BASE_SITEURL . "uploads/" . $module_name . "/";
    if ( $arr_imgs[0] != '' )
    {
        foreach ( $arr_imgs as $file )
        {
            
            if ( file_exists( NV_UPLOADS_REAL_DIR . "/" . $module_name . "/" . $file ) )
            {
                $xtpl->assign( 'FILEUPLOAD', array( 
                    'value' => $str . $file, 'key' => $a 
                ) );
                $xtpl->parse( 'inter.fileupload' );
                $a ++;
            }
        }
    }
    else
    {
        $xtpl->parse( 'inter.fileupload' );
    }

}
else
{
    $xtpl->parse( 'inter.fileupload' );
}
if ( $error != '' )
{
	
    $xtpl->assign( 'ERROR', $error );
    $xtpl->parse( 'inter.error' );
}
foreach ( $arrs['who_view'] as $who )
{
    $xtpl->assign( 'WHO_VIEW', $who );
    $xtpl->parse( 'inter.who_view' );
}
if ( $nv_Request->isset_request( 'who', 'post' ) )
{
    $whos = $nv_Request->get_int( 'who', 'post', 0 );
    if ( $whos == 3 )
    {
        if ( ! empty( $arrs['groups_view'] ) )
        {
            foreach ( $arrs['groups_view'] as $group )
            {
                $xtpl->assign( 'GROUPS_VIEW', $group );
                $xtpl->parse( 'inter.group_view_empty.groups_view' );
            }
            $xtpl->parse( 'inter.group_view_empty' );
            $contents = $xtpl->text( 'inter.group_view_empty' );
        }
    }
    else
    {
        $contents = '';
    }
    include ( NV_ROOTDIR . "/includes/header.php" );
    echo $contents;
    include ( NV_ROOTDIR . "/includes/footer.php" );
    exit();
}

if ( ! empty( $array['groups_view'] )  && $array['who_view']==3)
{
    if ( ! empty( $arrs['groups_view'] ) )
    {
        foreach ( $arrs['groups_view'] as $group )
        {
            $xtpl->assign( 'GROUPS_VIEW', $group );
            $xtpl->parse( 'inter.group_view_empty.groups_view' );
        }
        $xtpl->parse( 'inter.group_view_empty' );
        $contents = $xtpl->text( 'inter.group_view_empty' );
    }
}

if ( $nv_Request->isset_request( 'action', 'post' ) )
{
    $signer = $nv_Request->get_int( 'singer', 'post', 0 );
    $sql = "SELECT `positions` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_signer` WHERE `id`=" . $signer;
    $result = $db->sql_query( $sql );
    list( $position ) = $db->sql_fetchrow( $result );
    die( $lang_module['positions'] . ": " . $position );
}
$xtpl->parse( 'inter' );
$contents = $xtpl->text( 'inter' );

$page_title = $lang_module['add_document'];

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_admin_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>