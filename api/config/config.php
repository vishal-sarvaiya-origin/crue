<?php

session_start();
date_default_timezone_set("Asia/Kolkata");

class DataBase
{

    private $connection;

    public function __construct()
    {
        $this->connection = new mysqli("localhost", "root", "", "db_crue");
        return $this->connection;
    }

    public function INSERT($tbl, $data)
    {

        $k = array_keys($data);
        $v = array_values($data);
        $key = implode("`,`", $k);
        $val = implode("','", $v);
        $q = "INSERT INTO `$tbl` (`$key`) VALUES ('$val')";
        //echo $q;
        return $this->connection->query($q);
    }

    public function SELECT($tbl, $field = NULL, $where = NULL, $op = "AND")
    {

        //print_r($where);
        if (isset($field)) {
            $f = implode("`,`", $field);
            $q = "SELECT `$f` FROM `$tbl`";
        } else {

            $q = "SELECT * FROM `$tbl`";
        }
        if (isset($where)) {
            $q .= " WHERE ";
            foreach ($where as $key => $value) {
                $q .= " `$key` = '$value' $op ";
            }

            $q = rtrim($q, "$op ");
            //echo $q;
        }

        return $this->connection->query($q);
    }

    public function DELETE($tbl, $where)
    {
        $q = "DELETE FROM `$tbl`";
        $q .= " WHERE ";
        foreach ($where as $key => $value) {
            $q .= "`$key`='$value' AND";
        }
        $q = rtrim($q, " AND ");
        return $this->connection->query($q);
    }

    public function count_record($tbl, $where = NULL)
    {
        $q = "SELECT COUNT(*) as cn FROM `$tbl`";
        if (isset($where)) {
            $q .= " where ";
            foreach ($where as $key => $value) {
                $q .= " `$key` = '$value' AND ";
            }
            $q = rtrim($q, " AND ");
        }

        $ans = $this->connection->query($q);
        $a = $ans->fetch_object();
        return $a->cn;
    }

    public function ROW_QUERY($q)
    {
        return $this->connection->query($q);
    }

    public function UPDATE($tbl, $set, $where)
    {
        $q = "UPDATE `$tbl` SET ";
        foreach ($set as $key => $val) {
            $q .= " `$key` = '$val' ,";
        }
        $q = rtrim($q, ',');
        $q = $q . " WHERE ";

        foreach ($where as $key => $val) {
            $q .= " `$key` = '$val'";
        }
        //echo $q;
        return $this->connection->query($q);
    }
}
