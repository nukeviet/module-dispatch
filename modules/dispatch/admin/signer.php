<?php

/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
 * @Createdate Thu, 14 Apr 2011 12:01:30 GMT
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$signerList = nv_signerList(0);
$page_title = $lang_module['signer'];
$contents = "";

if ( empty( $signerList ) and ! $nv_Request->isset_request( 'add', 'get' ) )
{
    Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=signer&add" );
    die();
}

if ( $nv_Request->isset_request( 'cWeight, id', 'post' ) )
{
    $id = $nv_Request->get_int( 'id', 'post' );
    $cWeight = $nv_Request->get_int( 'cWeight', 'post' );
    if ( ! isset( $signerList[$id] ) ) die( "ERROR" );

    if ( $cWeight > ( $count = count( $signerList ) ) ) $cWeight = $count;

    $sql = "SELECT `id` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_signer` WHERE `id`!=" . $id . " ORDER BY `weight` ASC";
    $result = $db->sql_query( $sql );
    $weight = 0;
    while ( $row = $db->sql_fetchrow( $result ) )
    {
        $weight++;
        if ( $weight == $cWeight ) $weight++;
        $query = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_signer` SET `weight`=" . $weight . " WHERE `id`=" . $row['id'];
        $db->sql_query( $query );
    }
    $query = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_signer` SET `weight`=" . $cWeight . " WHERE `id`=" . $id;
    $db->sql_query( $query );
    nv_del_moduleCache( $module_name );
    nv_insert_logs( NV_LANG_DATA, $module_name, $lang_module['logChangeWeight'], "Id: " . $id, $admin_info['userid'] );
    die( "OK" );
}

if ( $nv_Request->isset_request( 'del', 'post' ) )
{
    $id = $nv_Request->get_int( 'del', 'post', 0 );
        
    if ( ! isset( $signerList[$id] ) ) die( $lang_module['errorsignerNotExists'] );
    $sql = "SELECT COUNT(*) as count FROM `" . NV_PREFIXLANG . "_" . $module_data . "_document` WHERE `from_signer`=" . $id;
    $result = $db->sql_query( $sql );
    $row = $db->sql_fetchrow( $result );
    if ( $row['count'] ) die( $lang_module['errorsignerYesRow'] );

    $query = "DELETE FROM `" . NV_PREFIXLANG . "_" . $module_data . "_signer` WHERE `id` = " . $id;
    $db->sql_query( $query );
    fix_signerWeight();
    nv_del_moduleCache( $module_name );
    nv_insert_logs( NV_LANG_DATA, $module_name, $lang_module['logDelsigner'], "Id: " . $id, $admin_info['userid'] );
    die( "OK" );
}

$xtpl = new XTemplate( $op . ".tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'GLANG', $lang_global );
$xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
$xtpl->assign( 'MODULE_URL', NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE );
$xtpl->assign( 'UPLOADS_DIR_USER', NV_UPLOADS_DIR . '/' . $module_name );
$xtpl->assign( 'UPLOAD_CURRENT', NV_UPLOADS_DIR . '/' . $module_name );

if ( $nv_Request->isset_request( 'add', 'get' ) or $nv_Request->isset_request( 'edit, id', 'get' ) )
{
    $post = array();
    if ( $nv_Request->isset_request( 'edit', 'get' ) )
    {
        $post['id'] = $nv_Request->get_int( 'id', 'get' );
        if ( empty( $post['id'] ) or ! isset( $signerList[$post['id']] ) )
        {
            Header( "Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=signer" );
            die();
        }

        $xtpl->assign( 'PTITLE', $lang_module['editsigner'] );
        $xtpl->assign( 'ACTION_URL', NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=signer&edit&id=" . $post['id'] );
        $log_title = $lang_module['editsigner'];
    }
    else
    {
        $xtpl->assign( 'PTITLE', $lang_module['addsigner'] );
        $xtpl->assign( 'ACTION_URL', NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=signer&add" );
        $log_title = $lang_module['addsigner'];
    }

    if ( $nv_Request->isset_request( 'save', 'post' ) )
    {
        $post['name'] = filter_text_input( 'name', 'post', '', 1 );
        $post['positions'] = filter_text_input( 'positions', 'post', '', 1 );
        if ( empty( $post['name'] ) )
        {
            die( $lang_module['errorIsEmpty'] . ": " . $lang_module['title'] );
        }

        
        if ( isset( $post['id'] ) )
        {
            $query = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_signer` SET 
                    `positions`=" . $db->dbescape( $post['positions'] ) . ", 
                    `name`=" . $db->dbescape( $post['name'] ) . " WHERE `id`=" . $post['id'];
            $db->sql_query( $query );
        }
        else
        {
            $weight = count( $signerList );
            $weight++;

            $query = "INSERT INTO `" . NV_PREFIXLANG . "_" . $module_data . "_signer` VALUES (NULL," . $db->dbescape( $post['name'] ) . "," . $db->dbescape( $post['positions'] ) . ", " . $weight . ",1);";
	        $post['id'] = $db->sql_query_insert_id( $query );
	           
          
        }

        nv_del_moduleCache( $module_name );
        nv_insert_logs( NV_LANG_DATA, $module_name, $log_title, "Id: " . $post['id'], $admin_info['userid'] );
        die( "OK" );
    }

    $post['name'] = ( $nv_Request->isset_request( 'edit', 'get' ) ) ? $signerList[$post['id']]['name'] : "";
    $post['positions'] = ( $nv_Request->isset_request( 'edit', 'get' ) ) ? $signerList[$post['id']]['positions'] : "";

    $xtpl->assign( 'signer', $post );
    $xtpl->parse( 'action' );
    $contents = $xtpl->text( 'action' );

    include ( NV_ROOTDIR . "/includes/header.php" );
    echo nv_admin_theme( $contents );
    include ( NV_ROOTDIR . "/includes/footer.php" );
    exit;
}

if ( $nv_Request->isset_request( 'list', 'get' ) )
{
    $a = 0;
    $count = count( $signerList );
    foreach ( $signerList as $id => $values )
    {
        $values['id'] = $id;
        $xtpl->assign( 'LOOP', $values );
        $xtpl->assign( 'CLASS', $a % 2 ? " class=\"second\"" : "" );

        for ( $i = 1; $i <= $count; $i++ )
        {
            $opt = array( 'value' => $i, 'selected' => $i == $values['weight'] ? " selected=\"selected\"" : "" );
            $xtpl->assign( 'NEWWEIGHT', $opt );
            $xtpl->parse( 'list.loop.option' );
        }
        $xtpl->parse( 'list.loop' );
        $a++;
    }
    $xtpl->parse( 'list' );
    $xtpl->out( 'list' );
    exit;
}

$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_admin_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

?>