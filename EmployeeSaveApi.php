<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type');

include_once 'DbConnect.php';
include_once 'Datamodels.php';
include_once 'Validations.php';

$data = file_get_contents('php://input');
$data = json_decode($data, true);


$db = new Validate();
$Valid=$db->Validate($data);




foreach ($data as $key => $value) {
 
     $data['_id']=rand(10,10000);
}




if ($Valid!=1) {

    //$example = $data;

    $db = new CRUD();
    $db->Saverecords("EmployeeMaster", $data);

    $message = "True";
    $data2[] = array("error" => "Saved Successfully");
    echo json_encode(array("Status" => $message, "data" => $data2));
    return;

} 
else{
     $message = "false";
    $data2[] = array("error" => "Error while Saving");
    echo json_encode(array("Status" => $message, "data" => $data2));
    return;
}
?>
