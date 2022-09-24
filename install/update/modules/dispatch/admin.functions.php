<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Tue, 19 Jul 2011 09:07:26 GMT
 */

if (!defined('NV_ADMIN') or !defined('NV_MAINFILE') or !defined('NV_IS_MODADMIN')) die('Stop!!!');

$submenu['add_document'] = $lang_module['add_document'];
$submenu['cat'] = $lang_module['cat'];
$submenu['type'] = $lang_module['type'];
$submenu['signer'] = $lang_module['signer'];
$submenu['departments'] = $lang_module['departments'];

$allow_func = array(
    'main',
    'departments',
    'cat',
    'add_document',
    'signer',
    'type'
);
global $arr_status;
$arr_status = array(
    '0' => array(
        'id' => '0',
        'name' => $lang_module['dis_sta0']
    ),
    '1' => array(
        'id' => '1',
        'name' => $lang_module['dis_sta1']
    ),
    '2' => array(
        'id' => '2',
        'name' => $lang_module['dis_sta2']
    )
);

define('NV_IS_FILE_ADMIN', true);

/**
 * nv_setcats1()
 *
 * @param mixed $list2
 * @param mixed $id
 * @param mixed $list
 * @param integer $m
 * @param integer $num
 * @return
 */
function nv_setcats1($list2, $id, $list, $m = 0, $num = 0)
{
    $num++;
    $defis = "";
    for ($i = 0; $i < $num; $i++) {
        $defis .= "--";
    }
    
    if (isset($list[$id])) {
        foreach ($list[$id] as $value) {
            if ($value['id'] != $m) {
                $list2[$value['id']] = $value;
                $list2[$value['id']]['name'] = "|" . $defis . "&gt; " . $list2[$value['id']]['name'];
                if (isset($list[$value['id']])) {
                    $list2 = nv_setcats1($list2, $value['id'], $list, $m, $num);
                }
            }
        }
    }
    return $list2;
}

/**
 * nv_listcats()
 *
 * @param mixed $parentid
 * @param integer $m
 * @return
 */
function nv_listcats($parentid, $m = 0)
{
    global $db, $module_data;
    
    $sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_cat` ORDER BY `parentid`,`weight` ASC";
    
    $result = $db->query($sql);
    $list = array();
    while ($row = $result->fetch()) {
        $list[$row['parentid']][] = array(
            'id' => (int) $row['id'],
            'parentid' => (int) $row['parentid'],
            'title' => $row['title'],
            'alias' => $row['alias'],
            'introduction' => $row['introduction'],
            'weight' => (int) $row['weight'],
            'status' => $row['status'],
            'name' => $row['title'],
            'addtime' => $row['addtime'],
            'selected' => $parentid == $row['id'] ? " selected=\"selected\"" : ""
        );
    }
    
    if (empty($list)) {
        return $list;
    }
    
    $list2 = array();
    foreach ($list[0] as $value) {
        if ($value['id'] != $m) {
            $list2[$value['id']] = $value;
            if (isset($list[$value['id']])) {
                $list2 = nv_setcats1($list2, $value['id'], $list, $m);
            }
        }
    }
    
    return $list2;
}

/**
 * nv_settype1()
 *
 * @param mixed $list2
 * @param mixed $id
 * @param mixed $list
 * @param integer $m
 * @param integer $num
 * @return
 */
function nv_settypes1($list2, $id, $list, $m = 0, $num = 0)
{
    $num++;
    $defis = "";
    for ($i = 0; $i < $num; $i++) {
        $defis .= "--";
    }
    
    if (isset($list[$id])) {
        foreach ($list[$id] as $value) {
            if ($value['id'] != $m) {
                $list2[$value['id']] = $value;
                $list2[$value['id']]['name'] = "|" . $defis . "&gt; " . $list2[$value['id']]['name'];
                if (isset($list[$value['id']])) {
                    $list2 = nv_settypes1($list2, $value['id'], $list, $m, $num);
                }
            }
        }
    }
    return $list2;
}

/**
 * nv_listtypes()
 *
 * @param mixed $parentid
 * @param integer $m
 * @return
 */
function nv_listtypes($parentid, $m = 0)
{
    global $db, $module_data;
    
    $sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_type` ORDER BY `parentid`,`weight` ASC";
    
    $result = $db->query($sql);
    $list = array();
    while ($row = $result->fetch()) {
        $list[$row['parentid']][] = array(
            'id' => (int) $row['id'],
            'parentid' => (int) $row['parentid'],
            'title' => $row['title'],
            'alias' => $row['alias'],
            'weight' => (int) $row['weight'],
            'status' => $row['status'],
            'name' => $row['title'],
            'selected' => $parentid == $row['id'] ? " selected=\"selected\"" : ""
        );
    }
    
    if (empty($list)) {
        return $list;
    }
    
    $list2 = array();
    foreach ($list[0] as $value) {
        if ($value['id'] != $m) {
            $list2[$value['id']] = $value;
            if (isset($list[$value['id']])) {
                $list2 = nv_settypes1($list2, $value['id'], $list, $m);
            }
        }
    }
    
    return $list2;
}

/**
 * nv_setdes1()
 *
 * @param mixed $list2
 * @param mixed $id
 * @param mixed $list
 * @param integer $m
 * @param integer $num
 * @return
 */
function nv_setdes1($list2, $id, $list, $m = 0, $num = 0)
{
    $num++;
    $defis = "";
    $des = "";
    for ($i = 0; $i < $num; $i++) {
        $defis .= "--";
    
    }
    
    if (isset($list[$id])) {
        foreach ($list[$id] as $value) {
            if ($value['id'] != $m) {
                $list2[$value['id']] = $value;
                $list2[$value['id']]['name'] = "|" . $defis . "&gt; " . $list2[$value['id']]['name'];
                if (isset($list[$value['id']])) {
                    $list2 = nv_setcats1($list2, $value['id'], $list, $m, $num);
                }
            }
        }
    }
    return $list2;
}

/**
 * nv_listdes()
 *
 * @param mixed $parentid
 * @param integer $m
 * @return
 */
function nv_listdes($parentid, $m = 0)
{
    global $db, $module_data;
    
    $sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_departments` ORDER BY `parentid`,`weight` ASC";
    
    $result = $db->query($sql);
    $list = array();
    while ($row = $result->fetch()) {
        $list[$row['parentid']][] = array(
            'id' => (int) $row['id'],
            'parentid' => (int) $row['parentid'],
            'title' => $row['title'],
            'alias' => $row['alias'],
            'introduction' => $row['introduction'],
            'weight' => (int) $row['weight'],
            'head' => $row['head'],
            'name' => $row['title'],
            'addtime' => $row['addtime'],
            'selected' => $parentid == $row['id'] ? " selected=\"selected\"" : "",
            'checked' => $parentid == $row['id'] ? " checked=\"checked\"" : ""
        );
    }
    
    if (empty($list)) {
        return $list;
    }
    
    $list2 = array();
    foreach ($list[0] as $value) {
        if ($value['id'] != $m) {
            $list2[$value['id']] = $value;
            if (isset($list[$value['id']])) {
                $list2 = nv_setdes1($list2, $value['id'], $list, $m);
            }
        }
    }
    
    return $list2;
}

function nv_signerList($idsigner)
{
    global $db, $module_data;
    
    $sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_signer` ORDER BY `weight` ASC";
    $result = $db->query($sql);
    $list = array();
    while ($row = $result->fetch()) {
        $list[$row['id']] = array(
            'id' => $row['id'],
            'name' => $row['name'],
            'positions' => $row['positions'],
            'weight' => (int) $row['weight'],
            'selected' => $idsigner == $row['id'] ? " selected=\"selected\"" : ""
        );
    }
    
    return $list;
}

function fix_signerWeight()
{
    global $db, $module_data;
    
    $sql = "SELECT `id` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_signer` ORDER BY `weight` ASC";
    $result = $db->query($sql);
    $weight = 0;
    while ($row = $result->fetch()) {
        $weight++;
        $query = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_signer` SET `weight`=" . $weight . " WHERE `id`=" . $row['id'];
        $db->query($query);
    }
}

?>