<?php

//returns data from db

include_once("database.php");


if(isset($_GET["from_date"], $_GET["to_date"]))
{
    $cannister = $_GET['cannister'];

    $query = "SELECT * FROM freezer WHERE device_id='$cannister' and time_stamp BETWEEN '".$_GET["from_date"]."' AND '".$_GET["to_date"]."' ORDER BY id desc";
    
    $result = $database->connection->query($query);

    $data = array();

    while($r = mysqli_fetch_array($result)) 
    {
        $data[] = $r;
    }

    print json_encode($data);

}

?>