<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Tue, 19 Jul 2011 09:07:26 GMT
 */

if (!defined('NV_IS_MOD_CONGVAN')) die('Stop!!!');

$page_title = $module_info['site_title'];
$key_words = $module_info['keywords'];

$fileupload = array();
$array_data = array();

if (isset($array_op[1]) and preg_match("/^([a-zA-Z0-9\-\_]+)\-([\d]+)$/", $array_op[1], $matches)) {
    $id = $matches[2];
    $alias = $matches[0];

    $listcats = nv_listcats(0);
    $listdes = nv_listdes(0);

    $sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_document WHERE id=" . $id . " AND alias=" . $db->quote($alias);

    $result = $db->query($sql);
    $num = $result->rowCount();
    if ($num != 1) {
        nv_redirect_location(NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name, 1);
    }

    $row = $result->fetch();

    $row['cat'] = $listcats[$row['catid']]['title'];
    $row['status'] = $arr_status[$row['status']]['name'];
    if ($row['from_time'] != 0) {
        $row['from_time'] = nv_date('d.m.Y', $row['from_time']);
    } else {
        $row['from_time'] = '';
    }
    $row['date_iss'] = nv_date('d.m.Y', $row['date_iss']);
    $row['date_first'] = nv_date('d.m.Y', $row['date_first']);
    if ($row['from_time'] != 0) {
        $row['date_die'] = nv_date('d.m.Y', $row['date_die']);
    } else {
        $row['date_die'] = '';
    }

    $row['type_title'] = $arr_type[$row['type']]['title'];

    if ($row['from_depid'] != 0) {
        $row['from_depid'] = $listdes[$row['from_depid']]['title'];
    }

    $query = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_document SET view=view+1 WHERE id=" . $id;

    $db->query($query);

    $listtypes = nv_listtypes($row['type']);

    $row['view'] = $row['view'] + 1;

    $xtpl = new XTemplate($op . ".tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_info['module_theme'] . "/");
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('GLANG', $lang_global);
    $xtpl->assign('MODULE_URL', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . "&" . NV_OP_VARIABLE . "=main&type=" . $row['type']);
    $xtpl->assign('MODULE_URL2', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . "&" . NV_OP_VARIABLE . "=main&type=" . $row['type'] . "&catid=" . $row['catid']);
    $xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
    $xtpl->assign('NV_LANG_INTERFACE', NV_LANG_INTERFACE);
    $xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
    $xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
    $xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
    $xtpl->assign('MODULE_NAME', $module_file);
    $xtpl->assign('OP', $op);
    $xtpl->assign('detail_title', '<span style="font-weight: bold;">Công văn: ' . $row['code'] . '</span>');
    $xtpl->assign('template', $module_info['template']);
    $xtpl->assign('module', $module_name);
    $xtpl->assign('MODULE_LINK', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name);

    $xtpl->assign('TYPELINK', NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=main&type=" . $row['type']);
    $xtpl->assign('TYPENAME', $listtypes[$row['type']]['title']);
    $xtpl->parse('main.if_cat');

    $xtpl->assign('ROW', $row);

    $sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_de_do WHERE doid=" . $id;
    $re = $db->query($sql);
    if ($re->rowCount()) {
        while ($ro = $re->fetch()) {
            $listdes = nv_listdes($ro['deid']);

            $xtpl->assign('dis_de', $listdes[$ro['deid']]['title']);
            $xtpl->parse('main.depid');
        }
    }

    if (!empty($row['file'])) {
        $fileupload = explode(",", $row['file']);
        foreach ($fileupload as $f) {
            $xtpl->assign('FILEUPLOAD', $f);
            $xtpl->parse('main.taifile.row');
        }
        $xtpl->parse('main.taifile');
    }

    $sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_de_do WHERE doid=" . $id;
    $result = $db->query($sql);
    $num = $result->rowCount();
    $i = 0;
    if ($num > 0) {
        $xtpl->assign('de_title', $lang_module['list_de']);
        while ($row = $result->fetch()) {
            $i = $i + 1;
            $row['stt'] = $i;
            $row['name'] = $listdes[$row['deid']]['title'];
            $xtpl->assign('DATA', $row);
            $xtpl->parse('main.de.loop');

        }
        $xtpl->parse('main.de');
    }

    $xtpl->parse('main');
    $contents = $xtpl->text('main');

    include NV_ROOTDIR . '/includes/header.php';
    echo nv_site_theme($contents);
    include NV_ROOTDIR . '/includes/footer.php';

} else {
    nv_redirect_location(NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name, 1);
}