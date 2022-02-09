<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type');

$site = $_SERVER['DOCUMENT_ROOT'];
require_once 'DbConnect.php';

$id = (int) $_REQUEST['id'];

if ($id > 0) {
    $data = findQuery("select Employee.*,BandSalary.Name Band from Employee inner join BandSalary on BandSalary.id=Employee.Band where Employee.id=$id ");
} else {
    $data = findQuery("select Employee.*,BandSalary.Name Band from Employee inner join BandSalary on BandSalary.id=Employee.Band order by Employee.id Desc  ");
}

if (!$data) {
    $message = "false";
    $data2[] = array("error" => "No details found");

} else {
    for ($i = 0; $i < count($data); $i++) {
        if ($data[$i]['id']) {
            $manager = "";
            $ManagedBy = $data[$i]['ManagedBy'];

            if ($ManagedBy > 0) {
                $dataMngdBy = findQuery("select Employee.Name from Employee where id= $ManagedBy  ");

                $manager = $dataMngdBy[0]['Name'];
            }

            $message = "true";
            $data2[] = array(
                "id" => $data[$i]['id'],
                "Name" => $data[$i]['Name'],
                "Age" => $data[$i]['Age'],
                "Band" => $data[$i]['Band'],
                "Rating" => $data[$i]['Rating'],
                "ManagedBy" => $manager,

            );

        }
    }
}
echo json_encode(array("Status" => $message, "data" => $data2));
return;
