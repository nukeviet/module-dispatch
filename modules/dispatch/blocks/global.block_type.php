<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2014 VINADES., JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 3/9/2010 23:25
 */

if (!defined('NV_MAINFILE'))
    die('Stop!!!');

if (!nv_function_exists('nv_type_blocks')) {
    /**
     * nv_block_config_type_blocks()
     *
     * @param mixed $module
     * @param mixed $data_block
     * @param mixed $lang_block
     * @return
     */
    function nv_block_config_type_blocks($module, $data_block, $lang_block)
    {
        global $db, $language_array, $module_array_cat, $module_file, $site_mods, $nv_Cache;

        $html = "";
        $html .= "<div class=\"form-group\">";
        $html .= "	<label class=\"control-label col-sm-6\">" . $lang_block['catid'] . ":</label>";
        $html .= "	<div class=\"col-sm-9\"><select name=\"config_type\" class=\"form-control\">\n";
        $sql = "SELECT * FROM " . NV_PREFIXLANG . "_" . $site_mods[$module]['module_data'] . "_type WHERE parentid = 0 ORDER BY weight ASC";
        $list = $nv_Cache->db($sql, 'id', $module);
        foreach ($list as $l) {
            $xtitle_i = "";
            if ($l['parentid'] > 0) {
                for ($i = 1; $i <= $l['lev']; $i++) {
                    $xtitle_i .= "----";
                }
            }
            $sel = ($data_block['type'] == $l['id']) ? ' selected' : '';
            $html .= "<option value=\"" . $l['id'] . "\" " . $sel . ">" . $xtitle_i . $l['title'] . "</option>\n";
        }
        $html .= "	</select></div>\n";
        $html .= "</div>";
        $html .= "<div class=\"form-group\">";
        $html .= "	<label class=\"control-label col-sm-6\">" . $lang_block['numrow'] . ":</label>";
        $html .= "	<div class=\"col-sm-5\"><input type=\"text\" name=\"config_numrow\" class=\"form-control\" size=\"5\" value=\"" . $data_block['numrow'] . "\"/></div>";
        $html .= "</div>";
        return $html;
    }

    /**
     * nv_block_config_type_blocks_submit()
     *
     * @param mixed $module
     * @param mixed $lang_block
     * @return
     */
    function nv_block_config_type_blocks_submit($module, $lang_block)
    {
        global $nv_Request;
        $return = array();
        $return['error'] = array();
        $return['config'] = array();
        $return['config']['type'] = $nv_Request->get_int('config_type', 'post', 0);
        $return['config']['numrow'] = $nv_Request->get_int('config_numrow', 'post', 0);
        return $return;
    }

    /**
     * nv_type_blocks()
     *
     * @param mixed $block_config
     * @return
     */
    function nv_type_blocks($block_config)
    {
        global $module_data, $module_name, $module_file, $global_array_cat, $lang_module, $my_head, $db, $module_info, $site_mods;

        $module = $block_config['module'];

        $xtpl = new XTemplate("block_hits.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $site_mods[$module]['module_theme']);
        $xtpl->assign('BASESITE', NV_BASE_SITEURL);
        $xtpl->assign('LANG', $lang_module);
        $xtpl->assign('module', $module);
        $a_t1 = array();
        $a_t = array();
        $query = "SELECT id FROM " . NV_PREFIXLANG . "_" . $site_mods[$module]['module_data'] . "_type WHERE status=1 AND (id=" . $block_config['type'] . " OR parentid= " . $block_config['type'] . ")";
        $re = $db->query($query);
        while ($row = $re->fetch()) {
            $a_t1[] = $row['id'];
        }

        $query = "SELECT id FROM " . NV_PREFIXLANG . "_" . $site_mods[$module]['module_data'] . "_type WHERE id=" . $block_config['type'] . " OR parentid IN (" . implode(',', $a_t1) . ")";
        $re = $db->query($query);
        while ($row = $re->fetch()) {
            $a_t[] = $row['id'];
        }

        $sql = "SELECT id, alias, title,from_time, code, groups_view,file FROM " . NV_PREFIXLANG . "_" . $site_mods[$module]['module_data'] . "_document WHERE type IN (" . implode(',', $a_t) . ") ORDER BY date_iss DESC, id DESC LIMIT 0 ," . $block_config['numrow'];
        $result = $db->query($sql);
        $chk_topview = $result->rowCount();

        if ($chk_topview) {
            while ($row = $result->fetch()) {
                if (nv_user_in_groups($row['groups_view'])) {
                    $row['link'] = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module . "&amp;" . NV_OP_VARIABLE . "=detail/" . $row['alias'];

                    if (nv_date('d.m.Y', $row['from_time']) == nv_date('d.m.Y', NV_CURRENTTIME)) {
                        $row['title'] = $row['title'] . "<img src=\"" . NV_BASE_SITEURL . "themes/" . $module_info['template'] . "/images/" . $module_file . "/new.gif\">";
                    }
                    $fileupload = explode(",", $row['file']);

                    $i = 0;
                    foreach ($fileupload as $f) {
                        $i = $i + 1;
                        $xtpl->assign('FILEUPLOAD', $f);
                        $xtpl->assign('i', $i);
                        $xtpl->parse('main.topviews.loop.loop1');
                    }

                    $xtpl->assign('topviews', $row);
                    $xtpl->parse('main.topviews.loop');
                }
            }
            $xtpl->parse('main.topviews');

        }
        $xtpl->parse('main');
        return $xtpl->text('main');
    }

}

if (defined('NV_SYSTEM')) {
    $content = nv_type_blocks($block_config);
}
