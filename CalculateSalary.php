   <?php
require_once 'DbConnect.php';
require 'CalculateManagerSalary.php';
function CalculateSalary($id)
{
    $data = findQuery("select Employee.*,BandSalary.Salary Salary from Employee inner join BandSalary on BandSalary.id=Employee.Band where Employee.id=$id ");

    $Salary = 0;
    if ($data) {
        $Band = $data[0]['Band'];

        if ($Band == 1) {

            $Salary = $data[0]['Salary'];
        } else if ($Band == 2) {
            $Salary = $data[0]['Salary'] + ($data[0]['Salary'] * $data[0]['Rating'] / 5);
        } else {

            $Salary = $data[0]['Salary'] + ($data[0]['Salary'] * $data[0]['Rating'] / 5);
            $Salary = CalculatemanagerSalary($id, $Salary);

        }

    }
    return $Salary;

}
?>