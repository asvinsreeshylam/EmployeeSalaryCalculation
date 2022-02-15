<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type');

$site = $_SERVER['DOCUMENT_ROOT'];
require_once 'DbConnect.php';

$id = (int) $_REQUEST['id'];

if ($id > 0) {
    $db = new CRUD();
    $results = $db->FindRecords("EmployeeMaster", ['_id' => $id]);

    foreach ($results as $row) {
        $data[] = (array) $row;
    }

} else {
    $db = new CRUD();
    $results = $db->FindRecords("EmployeeMaster", []);

    foreach ($results as $row) {
        $data[] = (array) $row;
    }
}




if (!$data) {
    $message = "false";
    $data2[] = array("error" => "No details found");
    echo json_encode(array("Status" => $message, "data" => $data2));
return;


} else {

   for ($i = 0; $i < count($data); $i++) {

        $MangedByid = $data[$i]['ManagedBy'];
        $Band = $data[$i]['Band'];

        $Manager = "";

        

            if ($MangedByid > 0) {
                $results = $db->FindRecords("EmployeeMaster", ['_id' => $MangedByid]);
                $datamangerResult = $results->toArray();

                foreach ($datamangerResult as $row) {
    $datamanger[] = (array) $row;
}


                $manager = $datamanger[0]['Name'];
               

            }
        

        if ($Band) {

            if ($Band > 0) {
                $results = $db->FindRecords("EmployeeCategory", ['_id' => $Band]);
                $dataBandResult = $results->toArray();

                 foreach ($dataBandResult as $row) {
    $dataBand[] = (array) $row;
}

                $Band = $dataBand[0]['Name'];

            }
        }

        $message = "true";
        $data2[] = array(
            "id" => $data[$i]['_id'],
            "Name" => $data[$i]['Name'],
            "Age" => $data[$i]['Age'],
            "Band" => $Band,
            "Rating" => $data[$i]['Rating'],
            "ManagedBy" => $manager,

        );

    }

    echo json_encode(array("Status" => $message, "data" => $data2));
    return;
}
