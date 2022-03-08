<?php

require_once 'config.php';

global $database;

class Database{

    public $connection;
  
    public $freezer_selected_device;
  
   function __construct()
   {
     $this->open_db_connection();
     $this->freezer_selected_device();
   }
  
      public function open_db_connection(){
         
        //    $this->connection = new mysqli("localhost", "usrDbRIdashTest", "2,h6uc1+cm+]1bsd", "roboicsi_dbRIdashTest__device_console");
           $this->connection = new mysqli("localhost", "root", "", "smartivf");

           if($this->connection->connect_errno){

              die("connection failed".$this->connection->connect_error);
          }

      }
  
  
    public function query($sql){

        $result = $this->connection->query($sql);
        
        $this->confirm_query($result);

        return $result;
    }
  
        // default freezer
    public function default_freezer()
        {
            if(empty($_SESSION['freezer_device_id']))
            {    
                $query = 'SELECT device_id FROM freezer order by id desc limit 1';
    
                $result =  $this->connection->query($query);
    
                while($row = mysqli_fetch_array($result))
                {
                    $_SESSION['freezer_device_id'] = $row['device_id'];
                   
                }
                $this->freezer_selected_device = $_SESSION['freezer_device_id'];
            }
    
        }
  
 $database = new Database();

?>
