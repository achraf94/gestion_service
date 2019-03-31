<?php

$db->setTable("enseignants", "eid");
function update_ens()
{ }
function delete_ens()
{ }
function insert_ens($data)
{
    $sql = "insert into enseignants(eid,uid,nom,prenom,email,tel,etid,annee,pic) value('10',";
    foreach ($data as $columns => $value) {
        $sql .=  "'" . $value . "',";
    }
    $sql = substr($sql, 0, -1) . ")";
    $GLOBALS['db']->insert($sql);
}

function select_ens()
{

    $sql = "select * from enseignants ";
    $GLOBALS['db']->setQuery($sql);
    return $GLOBALS['db']->loadArrayList();
}
function select_with_param_ens($data = array())
{
    $sql = "select * from enseignants where ";
    foreach ($data as $columns => $value) {
        $sql .= $columns . "='" . $value . "' and ";
    }
    $sql = substr($sql, 0, -4);
    $GLOBALS['db']->setQuery($sql);
    return $GLOBALS['db']->loadArrayList();
}
