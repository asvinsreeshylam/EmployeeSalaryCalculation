<?php
error_reporting(1);
ini_set('max_execution_time', 0);
ini_set('post_max_size', '64M');
ini_set('upload_max_filesize', '64M');
if (!session_start()) {session_start();}

$ENVPATH = __DIR__ . '\.env';

if (!file_exists($ENVPATH)) {
    print_r("Please add .env file");
    exit();
}

require_once realpath(__DIR__ . '/vendor/autoload.php');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);

$dotenv->load();

if (!$_ENV['SERVER']) {
    print_r("Please add server name in .env file");
    exit();
}

if (!$_ENV['USER']) {
    print_r("Please add User name in .env file");
    exit();
}
if (!$_ENV['DATABASENAME']) {
    print_r("Please add Database name in .env file");
    exit();
}

function dblink()
{
    $server = $_ENV['SERVER'];
    $pwd = $_ENV['PASSWORD'];
    $user = $_ENV['USER'];
    $dbname = $_ENV['DATABASENAME'];

    return $con = mysqli_connect("localhost", $user, $pwd, $dbname);
}

function saveArray($table, $arr, $id = 0, $link = "")
{
    $fieldis = keyvalueis($arr);
    $valueis = keyvalueis($arr, 1);
    $stordata = implode(",", $valueis);
    $fieldname = implode(",", $fieldis);
    if (!$link) {
        $link = dblink();
    }
    if ($id == 0) {
        $sql = "insert into $table($fieldname)values($stordata)";
        mysqli_query($link, $sql) or die(mysqli_error($link));
        return mysqli_insert_id($link); //$lastid = lastid();
    } else {
        updateArray($table, $fieldis, $valueis, $id);return $id;
    }
}

function updateArray($table, $f, $v, $id)
{
    $link = dblink();
    for ($i = 0; $i < count($f); $i++) {
        $key = $f[$i];
        $uvalue = $v[$i];
        $query = "update $table set $key=$uvalue where id=$id";
        mysqli_query($link, $query) or die(mysqli_error());
    }
}

function keyvalueis($arr, $t = 0)
{
    $rarry = array();
    foreach ($arr as $key => $value) {
        $value = "'" . mysql_ready($value) . "'";if ($t == 0) {$value = $key;}
        array_push($rarry, $value);
    }
    return $rarry;
}

function mysql_ready($var)
{
    if (get_magic_quotes_gpc()) {$var = stripslashes($var);}
    $link = dblink();
    $var = mysqli_real_escape_string($link, $var);
    return $var;

}

function updateQuery($query, $link = "")
{
    if (!$link) {
        $link = dblink();
    }
    mysqli_query($link, $query) or die(mysqli_error());
}

function get($obj, $rt = null)
{if (isset($_REQUEST[$obj]) && !empty($_REQUEST[$obj])) {return $_REQUEST[$obj];} else {return $rt;}}
function post($obj, $rt = null)
{if (isset($_POST[$obj]) && !empty($_POST[$obj])) {return $_POST[$obj];} else {return $rt;}}

function findQuery($sql = "", $link = "")
{
    $fieldtype = array();
    $fieldvalue = array();
    $type = array();
    $data = array();
    if (!$link) {
        $link = dblink();
    }
    $rs = mysqli_query($link, $sql) or die(mysqli_error());
    $countrow = mysqli_num_rows($rs);
    $countoffield = mysqli_num_fields($rs);
    $finfo = $rs->fetch_fields();
    foreach ($finfo as $val) {
        array_push($fieldtype, $val->name);
        array_push($type, $val->type);
    }
    for ($i = 0; $i < $countrow; $i++) {
        $fieldvalue[$i] = mysqli_fetch_row($rs);
        $data[$i] = array_combine($fieldtype, $fieldvalue[$i]);

    }
    return $data;
}
