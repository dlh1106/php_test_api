<?php
/**
 * 
 * ref : http://idchowto.com/?p=20119
 */
error_reporting(E_ALL);
ini_set("display_errors", 1);
class PDO_Lib
{

    var $pdo;


    var $query;
    var $sql;

    function __construct($tg="")
    {

        include $_SERVER["DOCUMENT_ROOT"]."/class/config/db_info.php";

        if($tg=="") {
            $tg = "default";
        }
        if(isset($dbinfo[$tg])) {
            $db_host = $dbinfo[$tg]["host"];
            $db_port = $dbinfo[$tg]["port"];
            $db_name = $dbinfo[$tg]["db"];
            $db_user = $dbinfo[$tg]["user"];
            $db_pass = $dbinfo[$tg]["pwd"];
        }
        try {
            $this->pdo = new PDO('mysql:host='.$db_host.';port='.$db_port.';dbname='.$db_name, $db_user, $db_pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            // 에러 출력하지 않음
            //$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
            // Warning만 출력
            //$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            // 에러 출력
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        return;
    }

    function __destruct()
    {
        $this->free();
        $this->pdo = null;
    }

    function query($sql, $arr_bindparam = array())
    {
        $sql = trim($sql);
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->execute($arr_bindparam);
        return true;
    }

    function queryOne($sql, $arr_bindparam = array()) {
        $sql = trim($sql);
        $this->stmt = $this->pdo->prepare(trim($sql));
        $this->stmt->execute($arr_bindparam);
        $this->stmt->setFetchMode(PDO::FETCH_ASSOC);
        $row= $this->stmt->fetch();
        return $row;
    }

    function queryAll($sql, $arr_bindparam = array()) {
        $sql = trim($sql);
        $this->stmt = $this->pdo->prepare(trim($sql));
        $this->stmt->execute($arr_bindparam);
        $this->stmt->setFetchMode(PDO::FETCH_ASSOC);
        $rows = $this->stmt->fetchAll();
        return $rows;
    }


    function delData($table, $idx, $field="idx")
    {
        $idx = trim($idx);
        $this->query("delete from $table where $field =:idx", ["idx"=>$idx]);
        $rtn = array();
        $rtn["err"] = 0;
        // if(!$this->commit()) {
        //     $rtn["err"] = 801;
        //     $rtn["err_msg"] = "Transaction commit failed";
        // }
        return $rtn;
    }

	function insData($table, $data)
	{
        $ar_fields = array();
        $ar_vfields = array();
		foreach($data as $key => $value)
		{
            $ar_fields[] = $key;
            $ar_vfields[] = ":".$key;
        }
        $fields = implode(",", $ar_fields);
        $vfields = implode(",", $ar_vfields);
        $sql = "INSERT INTO $table ($fields) VALUES ($vfields)";
        $this->query($sql, $data);
        $idx = $this->pdo->lastInsertId();
        $rtn = array();
        $rtn["idx"] = $idx;
        $rtn["err"] = 0;
        // if(!$this->commit()) {
        //     $rtn["err"] = 801;
        //     $rtn["err_msg"] = "Transaction commit failed";
        // }
		return $rtn;
	}
	
	function upData($table, $data, $idx, $field="idx")
	{
        $ar_fields = array();
        $ar_vfields = array();
		foreach($data as $key => $value)
		{
            $ar_fields[] = $key."=:".$key;
        }
        $fields = implode(",", $ar_fields);
        $sql = "UPDATE $table SET $fields WHERE $field=:$field";
        $data[$field] = $idx;
        $this->query($sql, $data);
        $rtn = array();
        $rtn["idx"] = $idx;
        $rtn["err"] = 0;
        // if(!$this->commit()) {
        //     $rtn["err"] = 801;
        //     $rtn["err_msg"] = "Transaction commit failed";
        // }

        return $rtn;
	}
    
    function commit() {
		return $this->pdo->commit();
    }

    function free()
    {
        if(is_object($this->query))
            mysqli_free_result($this->query);
    }

    function error($err)
    {
        echo $err."\n";
        exit;
    }

    function sql($string,$data) {
        $indexed=$data==array_values($data);
        foreach($data as $k=>$v) {
            if(is_string($v)) $v="'$v'";
            if($indexed) $string=preg_replace('/\?/',$v,$string,1);
            else $string=str_replace(":$k",$v,$string);
        }
        return $string;
    }
}
?>
