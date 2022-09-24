<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Tue, 19 Jul 2011 09:07:26 GMT
 */

if (!defined('NV_IS_MOD_CONGVAN')) die('Stop!!!');

/**
 * nv_theme_congvan_main()
 *
 * @param mixed $array_data
 * @return
 */
function nv_theme_congvan_main($error, $array, $page_title, $base_url, $all_page, $per_page, $page, $type, $se, $to, $from, $from_signer, $content, $code)
{
    global $global_config, $module_name, $module_file, $module_data, $lang_module, $module_config, $module_info, $op, $arr_type, $db;

    $xtpl = new XTemplate($op . ".tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_info['module_theme']);
    $xtpl->assign('MODULE_LINK', NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
    $xtpl->assign('tempalte', $module_info['template']);
    $xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
    $xtpl->assign('template', $module_info['template']);
    $xtpl->assign('module', $module_name);
    $xtpl->assign('NV_ASSETS_DIR', NV_ASSETS_DIR);

    $xtpl->assign('MODULE_NAME', $module_name);
    $xtpl->assign('SE_LINK', NV_BASE_SITEURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $op . "&amp;se=1");

    $listtypes = array(
        array(
            'id' => 0,
            'parentid' => '',
            'name' => $lang_module['type12'],
            'alias' => ''
        )
    );

    $listtypes = $listtypes + nv_listtypes($type);

    $listsinger = array(
        array(
            'id' => 0,
            'name' => $lang_module['singer0'],
            'selected' => ''
        )
    );
    $listsinger = $listsinger + nv_signerList($from_signer);

    foreach ($listtypes as $list) {
        if ($list['parentid'] == 0 && $list['id'] != 0) {
            $xtpl->assign('TYPE_LINK', NV_BASE_SITEURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $op . "&amp;type=" . $list['id']);
            $xtpl->assign('title', $list['title']);
            $xtpl->parse('main.type');
        }
    }

    if ($type != 0) {
        $sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_type` WHERE `parentid`=" . $type;
        $result = $db->query($sql);
        if ($result->rowCount() > 0) {
            $xtpl->assign('type_type', sprintf($lang_module['type_type'], $listtypes[$type]['title']));

            while ($ro = $result->fetch()) {
                $pa = $ro['parentid'];
                $xtpl->assign('LINK', NV_BASE_SITEURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $op . "&amp;type=" . $ro['id']);
                $xtpl->assign('title', $ro['title']);
                $xtpl->parse('main.t.con_type');
            }
            $xtpl->parse('main.t');
        }
    }

    if ($error != '') {
        $xtpl->assign('ERROR', $error);
        $xtpl->parse('main.error');
    }
    if ($se == 1) {

        foreach ($listsinger as $singer) {
            $xtpl->assign('LISSIS', $singer);
            $xtpl->parse('main.timkiem.from_signer');
        }

        foreach ($listtypes as $type) {
            $xtpl->assign('LISTTYPES', $type);
            $xtpl->parse('main.timkiem.typeid');
        }

        $xtpl->assign('OP', $op);
        if ($to != 0) {
            $xtpl->assign('TO', nv_date("d.n.Y", $to));
        }
        if ($from != 0) {
            $xtpl->assign('FROM', nv_date("d.n.Y", $from));
        }

        $xtpl->assign('code', $code);
        $xtpl->assign('content', $content);

        $xtpl->parse('main.timkiem');
    } else {
        $xtpl->parse('main.btn_timkiem');
    }

    if (!empty($array)) {
        if ($page_title != '') {
            $xtpl->assign('TABLE_CAPTION', $page_title);
        } else {
            $xtpl->assign('TABLE_CAPTION', $lang_module['table']);
        }
        $xtpl->assign('OP', $op);
        $xtpl->assign('type', $type);
        $xtpl->assign('FORM_ACTION', NV_BASE_SITEURL . "index.php?");

        if (!empty($array)) {
            $a = 0;
            foreach ($array as $row) {
                if (nv_date('d.m.Y', $row['from_times']) == nv_date('d.m.Y', NV_CURRENTTIME)) {
                    $xtpl->assign('CLASS', " class=\"r1\"");
                } else if (nv_date('m.Y', $row['from_times']) == nv_date('m.Y', NV_CURRENTTIME) && (nv_date('d', NV_CURRENTTIME) - nv_date('d', $row['from_times']) == 1)) {
                    $xtpl->assign('CLASS', " class=\"r2\"");
                } else if (nv_date('m.Y', $row['from_times']) == nv_date('m.Y', NV_CURRENTTIME) && (nv_date('d', NV_CURRENTTIME) - nv_date('d', $row['from_times']) == 2)) {
                    $xtpl->assign('CLASS', " class=\"r3\"");
                } else {
                    $xtpl->assign('CLASS', $a % 2 == 1 ? " class=\"second\"" : "");
                }
                $xtpl->assign('ROW', $row);

                if (!empty($row['file'])) {
                    $fileupload = explode(",", $row['file']);
                    $i = 0;
                    foreach ($fileupload as $f) {
                        $i = $i + 1;
                        $xtpl->assign('FILEUPLOAD', $f);
                        $xtpl->assign('i', $i);
                        $xtpl->parse('main.data.row.loop1');
                    }
                }

                $xtpl->parse('main.data.row');
                $a++;

            }
        }

        $generate_page = nv_generate_page($base_url, $all_page, $per_page, $page);

        if (!empty($generate_page)) {
            $xtpl->assign('GENERATE_PAGE', $generate_page);
            $xtpl->parse('main.data.generate_page');
        }
        $xtpl->parse('main.data');
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}