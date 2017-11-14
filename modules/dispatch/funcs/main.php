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
$se = $from = $to = $from_signer = 0;
$type = '';
$code = $content = '';

$array = array();
$error = '';
$sql = "FROM " . NV_PREFIXLANG . "_" . $module_data . "_document WHERE id!=0";
$base_url = NV_BASE_SITEURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name;

$listcats = nv_listcats(0);
$listdes = nv_listdes(0);
$listtypes = nv_listtypes($type);
$page_title = $lang_module['table'];

if ($nv_Request->isset_request("se", "get")) {
    $page_title = $lang_module['list_se'];
    $se = $nv_Request->get_int('se', 'get', 0);
}
if ($nv_Request->isset_request("type", "get")) {
    $type = $nv_Request->get_int('type', 'get', 0);
    if ($type != 0) {
        $page_title = sprintf($lang_module['cv_list_by_type'], $listtypes[$type]['title']);
        $a_t = array();
        $query = "SELECT id FROM " . NV_PREFIXLANG . "_" . $module_data . "_type WHERE id=" . $type . " OR parentid= " . $type;
        $re = $db->query($query);
        while ($row = $re->fetch()) {
            $a_t[] = $row['id'];
        }
        $query = "SELECT id FROM " . NV_PREFIXLANG . "_" . $module_data . "_type WHERE id IN (" . implode(',', $a_t) . ")";
        $re = $db->query($query);
        if ($row = $re->fetch()) {
            $a_t[] = $row['id'];
        }

        $sql .= " AND type IN (" . implode(',', $a_t) . ")";

        $base_url .= "&amp;type=" . $type;
    }
}

if ($nv_Request->isset_request("from", "get")) {

    $from = $nv_Request->get_title('from', 'get,post', '');

    unset($m);
    if (preg_match("/^([0-9]{1,2})\.([0-9]{1,2})\.([0-9]{4})$/", $from, $m)) {
        $from = mktime(0, 0, 0, $m[2], $m[1], $m[3]);
    } else {
        $from = 0;
    }

    if ($from != 0) {
        $sql .= " AND from_time >= " . $from;
        $base_url .= "&amp;from =" . $from;
    }
}
if ($nv_Request->isset_request("to", "get")) {
    $to = $nv_Request->get_title('to', 'get,post', '');

    unset($m);
    if (preg_match("/^([0-9]{1,2})\.([0-9]{1,2})\.([0-9]{4})$/", $to, $m)) {
        $to = mktime(0, 0, 0, $m[2], $m[1], $m[3]);
    } else {
        $to = 0;
    }
    if ($to != 0) {

        $sql .= " AND from_time <= " . $to;
        $base_url .= "&amp;to=" . $to;
    }
}

if ($nv_Request->isset_request("from_signer", "get")) {
    $from_signer = $nv_Request->get_int('from_signer', 'get', 0);

    if ($from_signer != 0) {
        $sql .= " AND from_signer=" . $from_signer;
        $base_url .= "&amp;from_signer=" . $from_signer;
    }
}

if ($nv_Request->isset_request("title", "get")) {
    $title = $nv_Request->get_title('title', 'get', '');
    if ($title != '') {
        $page_title = sprintf($lang_module['print_title'], '...' . $title . '...');
    }
    $sql .= " AND title LIKE '%" . $db->dblikeescape($title) . "%' ";
    $base_url .= "&amp;title=" . urlencode($title);
}
if ($nv_Request->isset_request("code", "get")) {
    $code = $nv_Request->get_title('code', 'get', '');
    if ($code != '') {
        $page_title = sprintf($lang_module['print_code'], '...' . $code . '...');
    }
    $sql .= " AND code LIKE '%" . $db->dblikeescape($code) . "%' ";
    $base_url .= "&amp;code=" . urlencode($code);
}

if ($nv_Request->isset_request("content", "get")) {
    $content = $nv_Request->get_title('content', 'get', '');
    $sql .= " AND content LIKE '%" . $db->dblikeescape($content) . "%' ";
    $base_url .= "&amp;content=" . urlencode($content);
}

$sql1 = "SELECT COUNT(*) " . $sql;

$result1 = $db->query($sql1);
$all_page = $result1->fetchColumn();

if (!$all_page) {
    $error = $lang_module['search_empty'];
}

$sql .= " ORDER BY from_time DESC";

$page = $nv_Request->get_int('page', 'get', 0);
$per_page = 30;
$sql2 = "SELECT * " . $sql . " LIMIT " . $page . ", " . $per_page;

$query2 = $db->query($sql2);

$array = array();
$i = 0;

while ($row = $query2->fetch()) {
    $i = $i + 1;

    if ($listtypes[$row['type']]['status'] == 1 && nv_user_in_groups($row['groups_view'])) {
        if (nv_date('d.m.Y', $row['from_time']) == nv_date('d.m.Y', NV_CURRENTTIME)) {
            $row['code'] = $row['code'] . "<img src=\"" . NV_BASE_SITEURL . "themes/" . $module_info['template'] . "/images/" . $module_file . "/new.gif\">";
        }
        if (strlen($row['content']) > 100) {
            $row['content'] = nv_clean60($row['content'], 100);
        }
        $row['to_org'] = '- ' . $row['to_org'];
        if (strpos($row['to_org'], ',')) {
            $row['to_org'] = str_replace(',', '<br />- ', $row['to_org']);

        }

        $array[$row['id']] = array(
            'id' => (int) $row['id'],
            'stt' => $i,
            'title' => $row['title'],
            'code' => $row['code'],
            'from_org' => $row['from_org'],
            'to_org' => $row['to_org'],
            'cat' => $listcats[$row['catid']]['title'],
            'type' => $listtypes[$row['type']]['title'],
            'file' => $row['file'],
            'content' => $row['content'],
            'link_type' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . "&amp;type=" . $row['type'],
            'link_cat' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . "&amp;type=" . $row['type'] . "&catid=" . $row['catid'],
            'from_times' => $row['from_time'],
            'from_time' => nv_date('d.m.Y', $row['from_time']),
            'status' => $arr_status[$row['status']]['name'],
            'link_code' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . "&amp;op=detail/" . $row['alias']
        );
    }
}

if (empty($array)) {
    $error = $lang_module['error_rows'];
}

$contents = nv_theme_congvan_main($error, $array, $page_title, $base_url, $all_page, $per_page, $page, $type, $se, $to, $from, $from_signer, $content, $code);

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';