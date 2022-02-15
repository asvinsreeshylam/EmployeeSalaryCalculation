   <?php
require_once 'DbConnect.php';
require_once 'CalculateManagerSalary.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type');

$data = file_get_contents('php://input');
$data = json_decode($data, true);

$id = $data['id'];

if (!filter_var($id, FILTER_VALIDATE_INT)) {

    $message = "false";
    $data2[] = array("error" => "Please Enter Valid Employee");

    echo json_encode(array("Status" => $message, "data" => $data2));
    return;
    

}

$db = new CalculateSalary();
$db->CalculateEmpSalary($id);


?>