<?php
include_once 'DbConnect.php';
include_once 'Datamodels.php';

class Validate
{

    public function Validate($data)
    {
        $Model = new Datamodels();

        foreach ($data as $key => $value) {
            $Model->__set($key, $value);
        }

        foreach ($data as $key => $value) {
            $Model->__get($key);

        }

        $id = $Model->id;
        $Name = $Model->Name;
        $Age = $Model->Age;
        $Band = $Model->Band;
        $Rating = $Model->Rating;
        $ManagedBy = $Model->ManagedBy;

        if (!filter_var($Band, FILTER_VALIDATE_INT)) {

            echo ("SalaryBand not found");
            return 1;

        }

        $db = new CRUD();
        $results = $db->FindRecords("EmployeeCategory", ['_id' => $Band]);

        foreach ($results as $Salaryband) {
            $SalaryBandid = $Salaryband->_id;

        }

        if (!$SalaryBandid) {
            $message = "false";
            $data2[] = array("error" => "SalaryBand not found ");
            echo json_encode(array("Status" => $message, "data" => $data2));
            return 1;
        }

        

        if (filter_var($Age, FILTER_VALIDATE_INT, array("options" => array("min_range" => 0, "max_range" => 100))) === false) {

            $message = "false";
            $data2[] = array("error" => "Age is incorrect ");
            echo json_encode(array("Status" => $message, "data" => $data2));
            return 1;

        }

        if (filter_var($Rating, FILTER_VALIDATE_INT, array("options" => array("min_range" => 0, "max_range" => 5))) === false) {

            $message = "false";
            $data2[] = array("error" => "Rating is not within the legal range");
            echo json_encode(array("Status" => $message, "data" => $data2));
            return 1;

        }

        if ($ManagedBy > 0) {

            $dataEmployeeExist = $db->FindRecords("EmployeeMaster", ['_id' => $ManagedBy]);

            foreach ($dataEmployeeExist as $EmployeeMaster) {
                $Empid = $EmployeeMaster->_id;
                $EmpBand = $EmployeeMaster->Band;


            }

            if ($Empid) {

                $dataCheckmangedby = $db->FindRecords("EmployeeCategory", ['_id' => $EmpBand]);

                foreach ($dataCheckmangedby as $dataCheckmanged) {
                    $Bandid = $dataCheckmanged->_id;
                   

                }

                if ($Bandid == 3 && $Band == 1) {

                    $message = "false";
                    $data2[] = array("error" => "Manager cannot manage a junior employee");
                    echo json_encode(array("Status" => $message, "data" => $data2));
                    return 1;

                }

            } else {

                $message = "false";
                $data2[] = array("error" => "Manger not found ");
                echo json_encode(array("Status" => $message, "data" => $data2));
                return 1;
            }

        }

    }

}
