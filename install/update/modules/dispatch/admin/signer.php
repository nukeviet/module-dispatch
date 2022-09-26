<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Thu, 14 Apr 2011 12:01:30 GMT
 */

if (!defined('NV_IS_FILE_ADMIN')) die('Stop!!!');

$signerList = nv_signerList(0);
$page_title = $lang_module['signer'];
$contents = "";

if (empty($signerList) and !$nv_Request->isset_request('add', 'get')) {
    nv_redirect_location(NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=signer&add");
}

if ($nv_Request->isset_request('cWeight, id', 'post')) {
    $id = $nv_Request->get_int('id', 'post');
    $cWeight = $nv_Request->get_int('cWeight', 'post');
    if (!isset($signerList[$id])) die("ERROR");
    
    if ($cWeight > ($count = count($signerList))) $cWeight = $count;
    
    $sql = "SELECT id FROM " . NV_PREFIXLANG . "_" . $module_data . "_signer WHERE id!=" . $id . " ORDER BY weight ASC";
    $result = $db->query($sql);
    $weight = 0;
    
    while ($row = $result->fetch()) {
        $weight++;
        if ($weight == $cWeight) $weight++;
        $query = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_signer SET weight=" . $weight . " WHERE id=" . $row['id'];
        $db->query($query);
    }
    
    $query = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_signer SET weight=" . $cWeight . " WHERE id=" . $id;
    $db->query($query);
    $nv_Cache->delMod($module_name);
    nv_insert_logs(NV_LANG_DATA, $module_name, $lang_module['logChangeWeight'], "Id: " . $id, $admin_info['userid']);
    nv_htmlOutput('OK');
}

if ($nv_Request->isset_request('del', 'post')) {
    $id = $nv_Request->get_int('del', 'post', 0);
    
    if (!isset($signerList[$id])) die($lang_module['errorsignerNotExists']);
    $sql = "SELECT COUNT(*) as count FROM " . NV_PREFIXLANG . "_" . $module_data . "_document WHERE from_signer=" . $id;
    $result = $db->query($sql);
    $row = $result->fetch();
    if ($row['count']) die($lang_module['errorsignerYesRow']);
    
    $query = "DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_signer WHERE id = " . $id;
    $db->query($query);
    fix_signerWeight();
    $nv_Cache->delMod($module_name);
    nv_insert_logs(NV_LANG_DATA, $module_name, $lang_module['logDelsigner'], "Id: " . $id, $admin_info['userid']);
    nv_htmlOutput('OK');
}

$xtpl = new XTemplate($op . ".tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);
$xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
$xtpl->assign('MODULE_URL', NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE);
$xtpl->assign('UPLOADS_DIR_USER', NV_UPLOADS_DIR . '/' . $module_upload);
$xtpl->assign('UPLOAD_CURRENT', NV_UPLOADS_DIR . '/' . $module_upload);

if ($nv_Request->isset_request('add', 'get') or $nv_Request->isset_request('edit, id', 'get')) {
    $post = array();
    if ($nv_Request->isset_request('edit', 'get')) {
        $post['id'] = $nv_Request->get_int('id', 'get');
        if (empty($post['id']) or !isset($signerList[$post['id']])) {
            nv_redirect_location(NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=signer");
        }
        
        $xtpl->assign('PTITLE', $lang_module['editsigner']);
        $xtpl->assign('ACTION_URL', NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=signer&edit&id=" . $post['id']);
        $log_title = $lang_module['editsigner'];
    } else {
        $xtpl->assign('PTITLE', $lang_module['addsigner']);
        $xtpl->assign('ACTION_URL', NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=signer&add");
        $log_title = $lang_module['addsigner'];
    }
    
    if ($nv_Request->isset_request('save', 'post')) {
        $post['name'] = $nv_Request->get_title('name', 'post', '', 1);
        $post['positions'] = $nv_Request->get_title('positions', 'post', '', 1);
        if (empty($post['name'])) {
            die($lang_module['errorIsEmpty'] . ": " . $lang_module['title']);
        }
        
        if (isset($post['id'])) {
            $query = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_signer SET
                    positions=" . $db->quote($post['positions']) . ",
                    name=" . $db->quote($post['name']) . " WHERE id=" . $post['id'];
            $db->query($query);
        } else {
            $weight = count($signerList);
            $weight++;
            
            $query = "INSERT INTO " . NV_PREFIXLANG . "_" . $module_data . "_signer VALUES (NULL," . $db->quote($post['name']) . "," . $db->quote($post['positions']) . ", " . $weight . ",1);";
            $post['id'] = $db->insert_id($query);
        
        }
        
        $nv_Cache->delMod($module_name);
        nv_insert_logs(NV_LANG_DATA, $module_name, $log_title, "Id: " . $post['id'], $admin_info['userid']);
        nv_htmlOutput('OK');
    }
    
    $post['name'] = ($nv_Request->isset_request('edit', 'get')) ? $signerList[$post['id']]['name'] : "";
    $post['positions'] = ($nv_Request->isset_request('edit', 'get')) ? $signerList[$post['id']]['positions'] : "";
    
    $xtpl->assign('signer', $post);
    $xtpl->parse('action');
    $contents = $xtpl->text('action');
    
    include NV_ROOTDIR . '/includes/header.php';
    echo nv_admin_theme($contents);
    include NV_ROOTDIR . '/includes/footer.php';
    exit();
}

if ($nv_Request->isset_request('list', 'get')) {
    $a = 0;
    $count = count($signerList);
    foreach ($signerList as $id => $values) {
        $values['id'] = $id;
        $xtpl->assign('LOOP', $values);
        $xtpl->assign('CLASS', $a % 2 ? " class=\"second\"" : "");
        
        for ($i = 1; $i <= $count; $i++) {
            $opt = array(
                'value' => $i,
                'selected' => $i == $values['weight'] ? " selected=\"selected\"" : ""
            );
            $xtpl->assign('NEWWEIGHT', $opt);
            $xtpl->parse('list.loop.option');
        }
        $xtpl->parse('list.loop');
        $a++;
    }
    $xtpl->parse('list');
    $xtpl->out('list');
    exit();
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';