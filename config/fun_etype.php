<?php

function update()
{ }
function delete()
{ }
function insert()
{ }

function select_etype()
{
    $sql = "select * from etypes ";
    $GLOBALS['db']->setQuery($sql);
    return $GLOBALS['db']->loadArrayList();
}
function select_with_param($data = array(), $columns = "*")
{
    $sql = "select  $columns from etypes where ";
    foreach ($data as $columns => $value) {
        $sql .= $columns . "='" . $value . "' and ";
    }
    $sql = substr($sql, 0, -4);
    $GLOBALS['db']->setQuery($sql);
    return $GLOBALS['db']->loadArrayList();
}
