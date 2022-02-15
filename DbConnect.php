<?php
error_reporting(1);
ini_set('max_execution_time', 0);
ini_set('post_max_size', '64M');
ini_set('upload_max_filesize', '64M');
if (!session_start()) {session_start();}
include_once 'Datamodels.php';

class DBConnect
{

    private $server;
    protected $dbname;
    private $dbport;
    private $conn;

    public function __construct()
    {

        try {

            $ENVPATH = __DIR__ . '\.env';

            if (!file_exists($ENVPATH)) {
                print_r("Please add .env file");
                exit();
            }

            require_once realpath(__DIR__ . '/vendor/autoload.php');

            $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);

            $dotenv->load();

            if (!$_ENV['SERVER']) {
                print_r("Please add server name in .env file");
                exit();
            }

            if (!$_ENV['DATABASENAME']) {
                print_r("Please add Database name in .env file");
                exit();
            }
            if (!$_ENV['PORT']) {
                print_r("Please add Port in .env file");
                exit();
            }

            $Datamodels = new Datamodels();
            $Datamodels->__set("server", $_ENV['SERVER']);
            $Datamodels->__set("dbport", $_ENV['PORT']);
            $Datamodels->__set("dbname", $_ENV['DATABASENAME']);

            $Datamodels->__get("server");
            $Datamodels->__get("dbport");
            $this->$dbname = $Datamodels->__get("dbname");

            $this->conn = new MongoDB\Driver\Manager('mongodb://' . $Datamodels->server . ':' . $Datamodels->dbport);
        } catch (MongoDBDriverExceptionException $e) {
            echo $e->getMessage();
            echo nl2br("n");
        }
    }

    public function dblink()
    {
        return $this->conn;
    }
}

class CRUD extends DBConnect
{

    public function Saverecords($Tablename, $data)
    {

        $conn = parent::dblink();

        $dbname = $this->$dbname . "." . $Tablename;

        $insert = new MongoDB\Driver\BulkWrite();
        $insert->insert($data);

        $result = $conn->executeBulkWrite($dbname, $insert);

        if ($result->getInsertedCount()) {
            return true;
        }
        else{
            return false;

        }

    }

    public function FindRecords($Tablename,$filter)
    {
        $conn = parent::dblink();

        $options = [
            'sort' => ['_id' => -1],
        ];

        $read = new MongoDB\Driver\Query($filter, $option);
        $dbname = $this->$dbname . "." . $Tablename;

          $result = $conn->executeQuery($dbname, $read);



         return $result;





}
}