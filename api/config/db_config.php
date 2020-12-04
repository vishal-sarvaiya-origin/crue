<?php
session_start();
date_default_timezone_set("Asia/Kolkata");
define('ENCRYPTION_KEY', 'dfsdfsfsdfvsgsdhgbdsxfgesdgvsdxd');

class db
{

    private $con;

    public function __construct()
    {
        $this->con = new mysqli("localhost", "root", "", "db_crue");
    }

    public function my_insert($tbl, $data)
    {

        $k = array_keys($data);
        $v = array_values($data);
        $key = implode("`,`", $k);
        $val = implode("','", $v);
        $q = "insert into `$tbl` (`$key`)values('$val')";
        return $this->con->query($q);
    }

    public function my_select($tbl, $field = NULL, $where = NULL, $op = "AND")
    {

        //print_r($where);
        if (isset($field)) {
            $f = implode("`,`", $field);
            $q = "select `$f` from `$tbl`";
        } else {

            $q = "select * from `$tbl`";
        }
        if (isset($where)) {
            $q .= " where ";
            foreach ($where as $key => $value) {
                $q .= " `$key` = '$value' $op ";
            }

            $q = rtrim($q, "$op ");
        }

        return $this->con->query($q);
    }

    public function my_delete($tbl, $where)
    {
        $q = "DELETE FROM `$tbl`";
        $q .= " WHERE ";
        foreach ($where as $key => $value) {
            $q .= "`$key`='$value' AND";
        }
        $q = rtrim($q, " AND ");
        return $this->con->query($q);
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

        $ans = $this->con->query($q);
        $a = $ans->fetch_object();
        return $a->cn;
    }

    public function my_query($q)
    {
        return $this->con->query($q);
    }

    public function my_update($tbl, $set, $where)
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


        return $this->con->query($q);
    }
}
