<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Tue, 19 Jul 2011 09:07:26 GMT
 */

if (!defined('NV_IS_FILE_ADMIN')) die('Stop!!!');

/**
 * nv_FixWeightCat()
 * 
 * @param integer $parentid
 * @return
 */
function nv_FixWeightCat($parentid = 0)
{
    global $db, $module_data;
    
    $sql = "SELECT id FROM " . NV_PREFIXLANG . "_" . $module_data . "_cat WHERE parentid=" . $parentid . " ORDER BY weight ASC";
    $result = $db->query($sql);
    $weight = 0;
    while ($row = $result->fetch()) {
        $weight++;
        $db->query("UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_cat SET weight=" . $weight . " WHERE id=" . $row['id']);
    }
}

/**
 * nv_del_cat()
 * 
 * @param mixed $catid
 * @return
 */
function nv_del_cat($catid)
{
    global $db, $module_data, $admin_info;
    
    $sql = "DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_document WHERE catid=" . $catid;
    $db->query($sql);
    
    $sql = "SELECT id FROM " . NV_PREFIXLANG . "_" . $module_data . "_cat WHERE parentid=" . $catid;
    $result = $db->query($sql);
    while (list ($id) = $result->fetch(3)) {
        nv_del_cat($id);
    }
    
    $sql = "DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_cat WHERE id=" . $catid;
    $db->query($sql);
    
    nv_insert_logs(NV_LANG_DATA, $module_data, "delete dispatch", '', $admin_info['userid'], '');
}

$array = array();
$error = "";

//them chu de
if ($nv_Request->isset_request('add', 'get')) {
    $page_title = $lang_module['cat_add'];
    $is_error = false;
    if ($nv_Request->isset_request('submit', 'post')) {
        $array['parentid'] = $nv_Request->get_int('parentid', 'post', 0);
        $array['title'] = $nv_Request->get_title('title', 'post', '', 1);
        $array['introduction'] = $nv_Request->get_title('introduction', 'post', '');
        $array['alias'] = $nv_Request->get_title('alias', 'post', '');
        $array['alias'] = ($array['alias'] == "") ? change_alias($array['title']) : change_alias($array['alias']);
        
        if (empty($array['title'])) {
            $error = $lang_module['cat_err_notitle'];
            $is_error = true;
        } else {
            if (!empty($array['parentid'])) {
                $sql = "SELECT COUNT(*) AS count FROM " . NV_PREFIXLANG . "_" . $module_data . "_cat WHERE id=" . $array['parentid'];
                $result = $db->query($sql);
                $count = $result->fetchColumn();
                
                if (!$count) {
                    $error = $lang_module['cat_err_noexist'];
                    $is_error = true;
                }
            }
            
            if (!$is_error) {
                $sql = "SELECT COUNT(*) AS count FROM " . NV_PREFIXLANG . "_" . $module_data . "_cat WHERE alias=" . $db->quote($array['alias']);
                $result = $db->query($sql);
                $count = $result->fetchColumn();
                
                if ($count) {
                    $error = $lang_module['cat_err_exist'];
                    $is_error = true;
                }
            }
        }
        
        if (!$is_error) {
            $sql = "SELECT MAX(weight) AS new_weight FROM " . NV_PREFIXLANG . "_" . $module_data . "_cat WHERE parentid=" . $array['parentid'];
            $result = $db->query($sql);
            $new_weight = $result->fetchColumn();
            $new_weight = (int) $new_weight;
            $new_weight++;
            
            $sql = "INSERT INTO " . NV_PREFIXLANG . "_" . $module_data . "_cat VALUES (
                NULL, 
                " . $array['parentid'] . ", 
                " . $db->quote($array['alias']) . ",
                " . $db->quote($array['title']) . ",              
                " . $db->quote($array['introduction']) . ", 
                " . NV_CURRENTTIME . ", 
                " . $new_weight . ", 
                1)";
            
            $catid = $db->insert_id($sql);
            
            if (!$catid) {
                $error = $lang_module['cat_err_save'];
                $is_error = true;
            } else {
                nv_insert_logs(NV_LANG_DATA, $module_name, $lang_module['cat_add'], $array['title'], $admin_info['userid']);
                $nv_Cache->delMod($module_name);
                nv_redirect_location(NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=cat");
            }
        }
    } else {
        $array['parentid'] = 0;
        $array['title'] = "";
        $array['alias'] = "";
        $array['description'] = "";
    }
    
    $listcats = array(
        array(
            'id' => 0,
            'name' => $lang_module['cat_maincat'],
            'selected' => ""
        )
    );
    $listcats = $listcats + nv_listcats($array['parentid']);
    
    $xtpl = new XTemplate("cat_add.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file);
    $xtpl->assign('FORM_ACTION', NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $op . "&amp;add=1");
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('DATA', $array);
    
    if (!empty($error)) {
        $xtpl->assign('ERROR', $error);
        $xtpl->parse('main.error');
    }
    
    foreach ($listcats as $cat) {
        $xtpl->assign('LISTCATS', $cat);
        $xtpl->parse('main.parentid');
    }
    
    $xtpl->parse('main');
    $contents = $xtpl->text('main');
    
    include NV_ROOTDIR . '/includes/header.php';
    echo nv_admin_theme($contents);
    include NV_ROOTDIR . '/includes/footer.php';
    
    exit();
}

//Sua chu de
if ($nv_Request->isset_request('edit', 'get')) {
    $page_title = $lang_module['cat_edit'];
    
    $catid = $nv_Request->get_int('catid', 'get', 0);
    
    if (empty($catid)) {
        nv_redirect_location(NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=cat");
    }
    
    $sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_cat WHERE id=" . $catid;
    $result = $db->query($sql);
    $numcat = $result->rowCount();
    
    if ($numcat != 1) {
        nv_redirect_location(NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=cat");
    }
    
    $row = $result->fetch();
    
    $is_error = false;
    
    if ($nv_Request->isset_request('submit', 'post')) {
        $array['parentid'] = $nv_Request->get_int('parentid', 'post', 0);
        $array['title'] = $nv_Request->get_title('title', 'post', '', 1);
        $array['introduction'] = $nv_Request->get_title('introduction', 'post', '');
        
        $array['alias'] = $nv_Request->get_title('alias', 'post', '');
        $array['alias'] = ($array['alias'] == "") ? change_alias($array['title']) : change_alias($array['alias']);
        
        if (empty($array['title'])) {
            $error = $lang_module['cat_err_notitle'];
            $is_error = true;
        } else {
            if (!empty($array['parentid'])) {
                $sql = "SELECT COUNT(*) AS count FROM " . NV_PREFIXLANG . "_" . $module_data . "_cat WHERE id=" . $array['parentid'];
                $result = $db->query($sql);
                $count = $result->fetchColumn();
                
                if (!$count) {
                    $error = $lang_module['cat_err_noexist'];
                    $is_error = true;
                }
            }
            
            if (!$is_error) {
                $sql = "SELECT COUNT(*) AS count FROM " . NV_PREFIXLANG . "_" . $module_data . "_cat WHERE id!=" . $catid . " AND alias=" . $db->quote($array['alias']);
                $result = $db->query($sql);
                $count = $result->fetchColumn();
                if ($count) {
                    $error = $lang_module['cat_err_exist'];
                    $is_error = true;
                }
            }
        }
        
        if (!$is_error) {
            if ($array['parentid'] != $row['parentid']) {
                $sql = "SELECT MAX(weight) AS new_weight FROM " . NV_PREFIXLANG . "_" . $module_data . "_cat WHERE parentid=" . $array['parentid'];
                $result = $db->query($sql);
                $new_weight = $result->fetchColumn();
                $new_weight = (int) $new_weight;
                $new_weight++;
            } else {
                $new_weight = $row['weight'];
            }
            
            $sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_cat SET 
                parentid=" . $array['parentid'] . ", 
                title=" . $db->quote($array['title']) . ", 
                alias=" . $db->quote($array['alias']) . ", 
                introduction=" . $db->quote($array['introduction']) . ", 
                weight=" . $new_weight . " 
                WHERE id=" . $catid;
            $result = $db->query($sql);
            
            if (!$result) {
                $error = $lang_module['cat_err_update'];
                $is_error = true;
            } else {
                if ($array['parentid'] != $row['parentid']) {
                    nv_FixWeightCat($row['parentid']);
                }
                
                $nv_Cache->delMod($module_name);
                nv_insert_logs(NV_LANG_DATA, $module_name, $lang_module['cat_edit'], $array['title'], $admin_info['userid']);
                nv_redirect_location(NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=cat");
            }
        }
    } else {
        $array['parentid'] = (int) $row['parentid'];
        $array['title'] = $row['title'];
        $array['alias'] = $row['alias'];
        $array['introduction'] = $row['introduction'];
    }
    
    $listcats = array(
        array(
            'id' => 0,
            'name' => $lang_module['cat_maincat'],
            'selected' => ""
        )
    );
    $listcats = $listcats + nv_listcats($array['parentid'], $catid);
    
    $xtpl = new XTemplate("cat_add.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file);
    $xtpl->assign('FORM_ACTION', NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $op . "&amp;edit=1&amp;catid=" . $catid);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('DATA', $array);
    
    if (!empty($error)) {
        $xtpl->assign('ERROR', $error);
        $xtpl->parse('main.error');
    }
    
    foreach ($listcats as $cat) {
        $xtpl->assign('LISTCATS', $cat);
        $xtpl->parse('main.parentid');
    }
    
    $xtpl->parse('main');
    $contents = $xtpl->text('main');
    
    include NV_ROOTDIR . '/includes/header.php';
    echo nv_admin_theme($contents);
    include NV_ROOTDIR . '/includes/footer.php';
    
    exit();
}

//Xoa chu de
if ($nv_Request->isset_request('del', 'post')) {
    if (!defined('NV_IS_AJAX')) die('Wrong URL');
    
    $catid = $nv_Request->get_int('catid', 'post', 0);
    
    if (empty($catid)) {
        die('NO');
    }
    
    $sql = "SELECT COUNT(*) AS count, parentid FROM " . NV_PREFIXLANG . "_" . $module_data . "_cat WHERE id=" . $catid;
    $result = $db->query($sql);
    list ($count, $parentid) = $result->fetch(3);
    
    if ($count != 1) {
        die('NO');
    }
    
    nv_del_cat($catid);
    nv_FixWeightCat($parentid);
    $nv_Cache->delMod($module_name);
    
    nv_htmlOutput('OK');
}

//Chinh thu tu chu de
if ($nv_Request->isset_request('changeweight', 'post')) {
    if (!defined('NV_IS_AJAX')) die('Wrong URL');
    
    $catid = $nv_Request->get_int('catid', 'post', 0);
    $new = $nv_Request->get_int('new', 'post', 0);
    
    if (empty($catid)) die('NO');
    
    $query = "SELECT parentid FROM " . NV_PREFIXLANG . "_" . $module_data . "_cat WHERE id=" . $catid;
    $result = $db->query($query);
    $numrows = $result->rowCount();
    if ($numrows != 1) die('NO');
    $parentid = $result->fetchColumn();
    
    $query = "SELECT id FROM " . NV_PREFIXLANG . "_" . $module_data . "_cat WHERE id!=" . $catid . " AND parentid=" . $parentid . " ORDER BY weight ASC";
    $result = $db->query($query);
    $weight = 0;
    while ($row = $result->fetch()) {
        $weight++;
        if ($weight == $new) $weight++;
        $sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_cat SET weight=" . $weight . " WHERE id=" . $row['id'];
        $db->query($sql);
    }
    $sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_cat SET weight=" . $new . " WHERE id=" . $catid;
    $db->query($sql);
    
    $nv_Cache->delMod($module_name);
    
    nv_htmlOutput('OK');
}

//Kich hoat - dinh chi
if ($nv_Request->isset_request('changestatus', 'post')) {
    if (!defined('NV_IS_AJAX')) die('Wrong URL');
    
    $catid = $nv_Request->get_int('catid', 'post', 0);
    
    if (empty($catid)) die('NO');
    
    $query = "SELECT status FROM " . NV_PREFIXLANG . "_" . $module_data . "_cat WHERE id=" . $catid;
    $result = $db->query($query);
    $numrows = $result->rowCount();
    if ($numrows != 1) die('NO');
    
    $status = $result->fetchColumn();
    $status = $status ? 0 : 1;
    
    $sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_cat SET status=" . $status . " WHERE id=" . $catid;
    $db->query($sql);
    
    $nv_Cache->delMod($module_name);
    
    nv_htmlOutput('OK');
}

//Danh sach chu de
$page_title = $lang_module['cat_list'];

$pid = $nv_Request->get_int('pid', 'get', 0);

$sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_cat WHERE parentid=" . $pid . " ORDER BY weight ASC";
$result = $db->query($sql);
$num = $result->rowCount();

if (!$num) {
    if ($pid) {
        Header("Location: " . NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=cat");
    } else {
        Header("Location: " . NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=cat&add=1");
    }
    exit();
}

if ($pid) {
    $sql2 = "SELECT title,parentid FROM " . NV_PREFIXLANG . "_" . $module_data . "_cat WHERE id=" . $pid;
    $result2 = $db->query($sql2);
    list ($parentid, $parentid2) = $result2->fetch(3);
    $caption = sprintf($lang_module['table_caption2'], $parentid);
    $parentid = "<a href=\"" . NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=cat&amp;pid=" . $parentid2 . "\">" . $parentid . "</a>";
} else {
    $caption = $lang_module['table_caption1'];
    $parentid = $lang_module['cat_maincat'];
}

$list = array();
$a = 0;

while ($row = $result->fetch()) {
    $numsub = $db->query("SELECT id FROM " . NV_PREFIXLANG . "_" . $module_data . "_cat WHERE parentid=" . $row['id'])->rowCount();
    if ($numsub) {
        $numsub = " (<a href=\"" . NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=cat&amp;pid=" . $row['id'] . "\">" . $numsub . " " . $lang_module['cat_sub'] . "</a>)";
    } else {
        $numsub = "";
    }
    
    $weight = array();
    for ($i = 1; $i <= $num; $i++) {
        $weight[$i]['title'] = $i;
        $weight[$i]['pos'] = $i;
        $weight[$i]['selected'] = ($i == $row['weight']) ? " selected=\"selected\"" : "";
    }
    
    $class = ($a % 2) ? " class=\"second\"" : "";
    
    $list[$row['id']] = array(
        'id' => (int) $row['id'],
        'title' => $row['title'],
        'titlelink' => NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;catid=" . $row['id'],
        'numsub' => $numsub,
        'parentid' => $parentid,
        'weight' => $weight,
        'status' => $row['status'] ? " checked=\"checked\"" : "",
        'class' => $class
    );
    
    $a++;
}

$xtpl = new XTemplate("cat_list.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file);
$xtpl->assign('ADD_NEW_CAT', NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=cat&amp;add=1");
$xtpl->assign('TABLE_CAPTION', $caption);
$xtpl->assign('GLANG', $lang_global);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);

foreach ($list as $row) {
    $xtpl->assign('ROW', $row);
    
    foreach ($row['weight'] as $weight) {
        $xtpl->assign('WEIGHT', $weight);
        $xtpl->parse('main.row.weight');
    }
    
    $xtpl->assign('EDIT_URL', NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=cat&amp;edit=1&amp;catid=" . $row['id']);
    $xtpl->parse('main.row');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';