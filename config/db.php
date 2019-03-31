<?php

class db
{
    private $PDOInstance = null;
    private static $instance = null;
    var $_sql;
    var $dbo;
    var $recordset;
    var $table;
    var $fields;
    var $assign;
    var $primary;
    var $foreign;
    var $msg;
    var $database;
    var $array;
    const DEFAULT_SQL_USER = 'root';
    const DEFAULT_SQL_HOST = 'localhost';
    const DEFAULT_SQL_PASS = '';
    const DEFAULT_SQL_DBNAME = '2019_projet5_services';
    const DEFAULT_SQL_OPERAION = array();

    public function __construct()
    {
        $this->PDOInstance = new PDO('mysql:host=' .  self::DEFAULT_SQL_HOST . ';dbname=' .  self::DEFAULT_SQL_DBNAME, self::DEFAULT_SQL_USER, self::DEFAULT_SQL_PASS, self::DEFAULT_SQL_OPERAION);
    }
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new db();
        }
        return self::$instance;
    }
    function setPrimary($key)
    {
        $this->primary = $key;
    }

    // Set foreign key
    function setForeign($key)
    {
        $this->foreign = $key;
    }

    function setWho($Who)
    {
        $this->Who = $Who;
    }
    function setField()
    {

        $q = "show columns from '" . $this->table . "'";
        $this->setQuery($q);
        $rows = $this->loadObjectList();
        $fields = new stdClass();
        foreach ($rows as $row) {
            $name = $row->Filed;
            $fields->$name = $row->Type;
        }
        $this->fields = get_object_vars($fields);
    }
    function setTable($t, $key = null, $fg = null, $Who = null)
    {

        $this->table = $t;
        $this->setField();
        $this->setPrimary($key);
        $this->setForeign($fg);
        $this->setWho($Who);
    }
    function getTable()
    {
        return $this->table;
    }
    function getQuery()
    {
        return $this->_sql;
    }
    function setQuery($sql)
    {
        $this->_sql = $sql;
    }

    function query()
    {
        $this->recordset = $this->PDOInstance->prepare($this->_sql);
        return $this->recordset;
    }
    function execute()
    {
        $cur = $this->query();
        $cur->execute();
    }
    function loadResult()
    {
        $ret = null;
        try {
            $cur = $this->query();
            $cur->execute();
            $ret = $cur->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->msg = $e->getMessage();
        }
        return $ret;
    }
    function loadObject()
    {
        $cur = $this->query();
        $cur->execute();
        if ($object = $cur->fetch(PDO::FETCH_OBJ)) {
            $ret = $object;
        }
        $cur->closeCursor();
        return $ret;
    }
    function loadObjectList()
    {
        $cur = $this->query();
        $array = array();
        try {
            $cur->execute();
            $array = $cur->fetchAll(PDO::FETCH_OBJ);
            $cur->closeCursor();
        } catch (PDOException $e) {
            $this->msg = $e->getMessage();
        }
        return $array;
    }
    function loadArrayList()
    {

        $cur = $this->query();
        try {
            $cur->execute();

            $array = array();
            while ($row = $cur->fetch(PDO::FETCH_ASSOC)) {
                $array[] = $row;
            }
        } catch (PDOException $e) {
            $this->msg = $e->getMessage();
        }
        $cur->closeCursor();

        return $array;
    }
    function getListCount($query)
    {
        $this->setQuery($query);
        $rows = $this->loadObjectList();
        return count($rows);
    }
    function exec($q = "")
    {
        $this->setQuery($q);
        $this->query();
        $this->execute();
    }
    function lastId($table, $primary)
    {
        $q = "select max( $primary ) as lastid from $table";
        $this->setQuery($q);
        $cur = $this->query();
        $cur->execute();
        return  $this->loadArrayList()[0]["lastid"];
    }
    function insert($q)
    {
        $this->setMsg($q);
        $this->setQuery($q);
        $this->query();
        $this->execute();
    }
    function setMsg($info)
    {
        $this->msg = $info;
    }


    function loadArrayList_table($q)
    {
        $this->setMsg($q);
        $this->setQuery($q);
        $this->query();
        return $this->loadArrayList();
    }
}
