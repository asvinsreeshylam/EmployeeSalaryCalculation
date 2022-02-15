   <?php
require_once 'DbConnect.php';

class CalculateSalary
{

    public function GetEmployeeDetails($id)
    {
        $db = new CRUD();

        $EmployeeMasterresults = $db->FindRecords("EmployeeMaster", ['_id' => $id]);
        $EmployeeMasterResult = $EmployeeMasterresults->toArray();

        foreach ($EmployeeMasterResult as $row) {
            $data[] = (array) $row;
        }

        if (!$data) {
            $message = "false";
            $data2[] = array("error" => "Employee details not found");
            echo json_encode(array("Status" => $message, "data" => $data2));
            exit();

        } else {

            $Band = $data[0]['Band'];
            $Rating = $data[0]['Rating'];

            $EmployeeCategoryresults = $db->FindRecords("EmployeeCategory", ['_id' => $Band]);
            $EmployeeCategoryResult = $EmployeeCategoryresults->toArray();

            foreach ($EmployeeCategoryResult as $row) {
                $dataBand[] = (array) $row;

            }

            $data = array_merge($data, $dataBand);

            return $data;

        }

    }

    public function GetmanagedEmployeeDetails($id)
    {

        $db = new CRUD();

        $results = $db->FindRecords("EmployeeMaster", ['ManagedBy' => $id]);
        $dataBandResult = $results->toArray();

        foreach ($dataBandResult as $row) {
            $dataBand[] = (array) $row;

        }

        $result = $dataBand;

        return $result;

    }

    public function GetBandDetails($id)
    {

        $db = new CRUD();

        $resultsalary = $db->FindRecords("EmployeeCategory", ['_id' => $id]);
        $dataBandssalaryResult = $resultsalary->toArray();

        foreach ($dataBandssalaryResult as $row) {
            $dataBand[] = (array) $row;

        }

        $result = $dataBand;

        return $result;

    }

    public function CalculateEmpSalary($id)
    {

        $DataResultSet = self::GetEmployeeDetails($id);

        if ($DataResultSet[0]['Band'] == 1) {

            $db = new JuniorEmployeeSalary();
            $DataResultSet = $db->CalculateSalary($id);

            $message = "true";
            $data2[] = array(

                "Salary" => $DataResultSet[1]['Salary'],

            );

        } elseif ($DataResultSet[0]['Band'] == 2) {

            $db = new SenoirEmployeeSalary();
            $DataResultSet = $db->CalculateSalary($id);
            $message = "true";
            $data2[] = array(

                "Salary" => $DataResultSet[1]['Salary'],

            );

        } else {
            $db = new ManagerSalary();

            $DataResultSet = $db->CalculateSalary($id);
            $message = "true";
            $data2[] = array(

                "Salary" => $DataResultSet,

            );
        }

        echo json_encode(array("Status" => $message, "data" => $data2));
        return;

    }

}

class JuniorEmployeeSalary extends CalculateSalary
{
    public function CalculateSalary($id)
    {

        $data = parent::GetEmployeeDetails($id);

        return $data;

    }

}

class SenoirEmployeeSalary extends JuniorEmployeeSalary
{
    public function CalculateSalary($id)
    {
        $data = parent::CalculateSalary($id);

        $Salary = $data[1]['Salary'] + ($data[1]['Salary'] * $data[0]['Rating'] / 5);

        $data[1]['Salary'] = $Salary;

        return $data;

    }

}

class ManagerSalary extends SenoirEmployeeSalary
{
    public function CalculateSalary($id)
    {

        $data = parent::CalculateSalary($id);
        $Salary = $data[1]['Salary'];

        $dataBand = self::GetmanagedEmployeeDetails($id);

        for ($i = 0; $i < count($dataBand); $i++) {
            $Ratingsalary += 1000 * $dataBand[$i]['Rating'] / 5;

            $dataBandresult = self::GetBandDetails($dataBand[$i]['Band']);

            $SalaryBand = $dataBandresult[0]['Salary'];

            if ($dataBand[$i]['Rating'] >= 4) {

                $EmpSalary += ($SalaryBand * 20) / 100;

            }

        }

        $Salary = $Salary + $Ratingsalary + $EmpSalary;

        return $Salary;

    }

}
?>