<?php
require_once 'DbConnect.php';

function CalculatemanagerSalary($id, $Salary)
{
    $datamngd = findQuery("select Employee.*,BandSalary.Salary from Employee
 inner join BandSalary on BandSalary.id=Employee.Band where Employee.ManagedBy=$id ");

    $EmpSalary = $Salary;

    if ($datamngd) {

        for ($i = 0; $i < count($datamngd); $i++) {
            $rating = $datamngd[$i]['Rating'];

            $EmpSalary += 1000 * $rating / 5;

            if ($rating >= 4) {
                $EmpSalary += ($datamngd[$i]['Salary'] * 20) / 100;
            }
        }

    }

    return $EmpSalary;

}
