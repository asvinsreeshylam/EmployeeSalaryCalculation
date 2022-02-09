<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type');
$site = $_SERVER['DOCUMENT_ROOT'];
require_once 'DbConnect.php';

$data = file_get_contents('php://input');
$data = json_decode($data, true);

$id = $data['id'];
$Name = $data['Name'];
$Age = (int) $data['Age'];
$Band = $data['Band'];
$Rating = (int) $data['Rating'];
$ManagedBy = (int) $data['ManagedBy'];

unset($data['id']);

$dataCheckBandSalary = findQuery("select * from BandSalary where Name=UPPER('$Band')");

if (!$dataCheckBandSalary) {
    $message = "false";
    $data2[] = array("error" => "SalaryBand not found ");
    echo json_encode(array("Status" => $message, "data" => $data2));
    return;
}

$Band = $dataCheckBandSalary[0]['id'];
$data['Band'] = $Band;

if ($Name . trim() == '') {

    $message = "false";
    $data2[] = array("error" => "Name Missing");
    echo json_encode(array("Status" => $message, "data" => $data2));
    return;

}

if ($Age <= 0) {

    $message = "false";
    $data2[] = array("error" => "Age is incorrect ");
    echo json_encode(array("Status" => $message, "data" => $data2));
    return;

}

if ($Rating > 5) {

    $message = "false";
    $data2[] = array("error" => "Rating exceeded prescribed range ");
    echo json_encode(array("Status" => $message, "data" => $data2));
    return;

}

if ($Rating <= 0) {

    $message = "false";
    $data2[] = array("error" => "Please select rating");
    echo json_encode(array("Status" => $message, "data" => $data2));
    return;

}

if ($ManagedBy > 0) {

    $dataCheckmangedby = findQuery("select BandSalary.* from BandSalary
 left join Employee on BandSalary.id=Employee.Band where Employee.id=$ManagedBy
 ");

    if ($dataCheckmangedby) {

        $ManagedBy = $dataCheckmangedby[0]['id'];
        $data['ManagedBy'] = $ManagedBy;

        if ($ManagedBy == 3 && $Band == 1) {

            $message = "false";
            $data2[] = array("error" => "Manager cannot manage a junior employee");
            echo json_encode(array("Status" => $message, "data" => $data2));
            return;

        }

    } else {

        $message = "false";
        $data2[] = array("error" => "Manger not found ");
        echo json_encode(array("Status" => $message, "data" => $data2));
        return;
    }

}

if ($id > 0) {
    $dataCheck = findQuery("select * from Employee where id=$id");
}

if (!$dataCheck) {

    $id = saveArray('Employee', $data, 0);

    $message = "True";
    $data2[] = array("error" => "Saved Successfully");
    echo json_encode(array("Status" => $message, "data" => $data2));
    return;

} else {
    $id = saveArray('Employee', $data, $id);
    $message = "True";
    $data2[] = array("error" => "updated Successfully");
    echo json_encode(array("Status" => $message, "data" => $data2));
    return;
}
