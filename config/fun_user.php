<?php

function update_user()
{ }
function delete_user()
{ }
function insert_user($data = array())
{
    $sql = "insert into users(uid,login,mdp,role) value('10',";
    foreach ($data as $columns => $value) {
        $sql .=  "'" . $value . "',";
    }
    $sql = substr($sql, 0, -1) . ")";
    $GLOBALS['db']->insert($sql);
    $lastid = $GLOBALS['db']->lastId("users", "uid");
    return $lastid;
}

function select_user()
{ }
function select_with_param_user($data = array())
{
    $sql = "select * from users where ";
    foreach ($data as $columns => $value) {
        $sql .= $columns . "='" . $value . "' and ";
    }
    $sql = substr($sql, 0, -4);
    if ($GLOBALS['db']->getListCount($sql) == 0) {
        return false;
    }
    $_SESSION["statu"] = "En ligne";
    $_SESSION["user_info"] = $GLOBALS['db']->loadArrayList_table($sql);
    return true;
}
