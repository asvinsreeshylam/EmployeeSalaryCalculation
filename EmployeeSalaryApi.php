<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type');

$site = $_SERVER['DOCUMENT_ROOT'];
require_once 'DbConnect.php';
require 'CalculateSalary.php';
$id = (int) $_REQUEST['id'];

if ($id > 0) {
    $data = findQuery("select Employee.*,BandSalary.Salary Salary from Employee inner join BandSalary on BandSalary.id=Employee.Band where Employee.id=$id ");
}

if (!$data) {
    $message = "false";
    $data2[] = array("error" => "Employee not found");

} else {
    $Salary = CalculateSalary($id);

    $message = "true";
    $data2[] = array(

        "Salary" => $Salary,

    );

}

echo json_encode(array("Status" => $message, "data" => $data2));
return;
