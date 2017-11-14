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

if (!nv_function_exists('nv_dispathch_category')) {

    /**
     * nv_block_config_dispathch_category()
     *
     * @param mixed $module
     * @param mixed $data_block
     * @param mixed $lang_block
     * @return
     */
    function nv_block_config_dispathch_category($module, $data_block, $lang_block)
    {
        global $db, $language_array;
        $html = "<select name=\"config_title_length\" class=\"form-control\">\n";
        $html .= "<option value=\"\">" . $lang_block['title_length'] . "</option>\n";
        for ($i = 0; $i < 100; $i++) {
            $sel = ($data_block['title_length'] == $i) ? ' selected' : '';

            $html .= "<option value=\"" . $i . "\" " . $sel . ">" . $i . "</option>\n";
        }
        $html .= "</select></td>\n";
        return '<div class="form-group"><label class="control-label col-sm-6">' . $lang_block['title_length'] . ':</label><div class="col-sm-9">' . $html . '</div></div>';
    }

    /**
     * nv_block_config_dispathch_category_submit()
     *
     * @param mixed $module
     * @param mixed $lang_block
     * @return
     */
    function nv_block_config_dispathch_category_submit($module, $lang_block)
    {
        global $nv_Request;
        $return = array();
        $return['error'] = array();
        $return['config'] = array();
        $return['config']['title_length'] = $nv_Request->get_int('config_title_length', 'post', 0);
        return $return;
    }

    /**
     * nv_dispathch_category()
     *
     * @param mixed $block_config
     * @return
     */
    function nv_dispathch_category($block_config)
    {
        global $module_array_cat, $module_info, $site_mods, $global_config;

        $module = $block_config['module'];
        $module_theme = $site_mods[$module]['module_theme'];

        if (file_exists(NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_theme . '/block_category.tpl')) {
            $block_theme = $module_info['template'];
        } elseif (file_exists(NV_ROOTDIR . '/themes/' . $global_config['site_theme'] . '/modules/' . $module_theme . '/block_category.tpl')) {
            $block_theme = $global_config['site_theme'];
        } else {
            $block_theme = 'default';
        }

        if (file_exists(NV_ROOTDIR . '/themes/' . $module_info['template'] . '/css/jquery.metisMenu.css')) {
            $block_css = $module_info['template'];
        } elseif (file_exists(NV_ROOTDIR . '/themes/' . $global_config['site_theme'] . '/css/jquery.metisMenu.css')) {
            $block_theme = $global_config['site_theme'];
        } else {
            $block_theme = 'default';
        }

        $xtpl = new XTemplate("block_category.tpl", NV_ROOTDIR . "/themes/" . $block_theme . "/modules/" . $module_theme);
        $xtpl->assign('NV_ASSETS_DIR', NV_ASSETS_DIR);
        $xtpl->assign('TEMPLATE', $block_theme);
        $xtpl->assign('TEMPLATE_CSS', $block_css);
        $xtpl->assign('UNIQUE_KEY_ID', $site_mods[$module]['module_theme']);
        $xtpl->assign('BLOCK_ID', $block_config['bid']);

        $title_length = $block_config['title_length'];

        if (!empty($module_array_cat)) {
            foreach ($module_array_cat as $cat) {
                if ($cat['parentid'] == 0) {
                    $cat['title0'] = $cat['title'];
                    if (!empty($title_length)) {
                        $cat['title0'] = nv_clean60($cat['title'], $title_length);
                    }
                    $xtpl->assign('CAT', $cat);

                    if (!empty($cat['subcatid'])) {
                        $xtpl->assign('SUBCAT', nv_dispathch_sub_category($cat['subcatid'], $title_length));
                        $xtpl->parse('main.cat.subcat');
                    }

                    $xtpl->parse('main.cat');
                }
            }

            $xtpl->parse('main');
            return $xtpl->text('main');
        }
    }

    /**
     * nv_dispathch_sub_category()
     *
     * @param mixed $list_sub
     * @param mixed $title_length
     * @return
     */
    function nv_dispathch_sub_category($list_sub, $title_length)
    {
        global $module_array_cat;
        if (empty($list_sub)) {
            return "";
        } else {
            $list = explode(",", $list_sub);
            $html = "<ul>\n";
            foreach ($list as $catid) {

                $html .= "<li>\n";
                $html .= "<a title=\"" . $module_array_cat[$catid]['title'] . "\" href=\"" . $module_array_cat[$catid]['link'] . "\">" . (!empty($title_length) ? nv_clean60($module_array_cat[$catid]['title'], $title_length) : $module_array_cat[$catid]['title']) . "</a>\n";
                if (!empty($module_array_cat[$catid]['subcatid']))
                    $html .= nv_dispathch_sub_category($module_array_cat[$catid]['subcatid'], $title_length);
                $html .= "</li>\n";
            }
            $html .= "</ul>\n";
            return $html;
        }
    }
}

if (defined('NV_SYSTEM')) {
    global $site_mods, $module_name, $global_array_cat, $module_array_cat, $nv_Cache;
    $module = $block_config['module'];
    if (isset($site_mods[$module])) {
        $module_array_cat = array();
        $sql = "SELECT id, parentid, title, alias FROM `" . NV_PREFIXLANG . "_" . $site_mods[$module]['module_data'] . "_type` ORDER BY `parentid`,`weight` ASC";
        $list = $nv_Cache->db($sql, 'id', $module);
        foreach ($list as $l) {
            $module_array_cat[$l['id']] = $l;
            $module_array_cat[$l['id']]['subcatid'] = '';
            $module_array_cat[$l['id']]['link'] = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module . "&amp;op=main&type=" . $l['id'];
            if ($module_array_cat[$l['id']]['parentid'] != 0) {
                if ($module_array_cat[$module_array_cat[$l['id']]['parentid']]['subcatid'] == '') {
                    $module_array_cat[$module_array_cat[$l['id']]['parentid']]['subcatid'] = $module_array_cat[$l['id']]['id'];
                } else {
                    $module_array_cat[$module_array_cat[$l['id']]['parentid']]['subcatid'] = $module_array_cat[$module_array_cat[$l['id']]['parentid']]['subcatid'] . "," . $module_array_cat[$l['id']]['id'];
                }
            }

        }

        $content = nv_dispathch_category($block_config);
    }
}
