<?php

include_once("database.php");

//default from and to date 

$query = "SELECT * FROM freezer WHERE device_id='$database->freezer_selected_device' ORDER BY id desc limit 1";
    
$result = $database->connection->query($query);

while($r = mysqli_fetch_array($result)) 
{
    $to_updated_time = $r['time_stamp'];
}


$query = "SELECT * FROM freezer WHERE device_id='$database->freezer_selected_device' ORDER BY id DESC limit 7";
    
$result = $database->connection->query($query);

while($r = mysqli_fetch_array($result)) 
{
    $from_updated_time = $r['time_stamp'];
}
    

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <link href="vendor/datetimepicker/jquery.datetimepicker.css" rel="stylesheet"> 
    <script src="vendor/datetimepicker/jquery.js"></script>
    
<!-- display chart customization  -->
<script>
function dsptemp(tempb,time) 
{

            var ctx = 
            document.getElementById('fridge_temp').getContext('2d');
            var myChart = new Chart(ctx, {
            type: 'line',
            data: {
            labels: time,
            datasets: [{
            
            label: 'Temperature',
            data: tempb, // json value received used in method
            
            backgroundColor: ["#FEECF4"],
            borderColor: ["#F54394"],
            borderWidth: 1
            }]
            },
            options: {
            responsive: true,
            scales: {
            yAxes: [{
                ticks: {
                suggestedMin : 400,
                suggestedMax : 500,
                stepSize: 1,
                
                },
                scaleLabel: {
                    color: "rgba(0, 0, 0, 0)",
                display: true,
                labelString: 'TEMP Values'
                }
            }],
            xAxes: [{
                scaleLabel: {
                    color: "rgba(0, 0, 0, 0)",
                display: true,
                labelString: 'Date Time'
                }
            }]
            }
        }

    });
 }

</script>

<!-- when button clicked with from and to with time this function fetches data between the date time from db  -->

<!-- if button not clicked when the page loads by default it will take the from and to date from the php code and chart will be displayed --> 

<script>

$(document).ready(function ()
{
    $('#btn_search').click(function () {
        
        var from_date = $('#demo_from').val();        
        var to_date = $('#demo_to').val();
        var cannister = $('#cannister').val();

        var data,  tempb = [], time = [];
  

        if (from_date != '' && to_date != '') {

                alert(cannister);

                function formatParams( params ){
                    return "?" + Object
                            .keys(params)
                            .map(function(key){
                            return key+"="+encodeURIComponent(params[key])
                            })
                            .join("&")
                    }


                var endpoint = "json_search.php";
                var params = { 'from_date': from_date, 'to_date': to_date, 'cannister':cannister };                                
                var url = endpoint + formatParams(params);

                console.log(url);
                                
                var requestURL = url;                
                var request = new XMLHttpRequest({mozSystem: true}); // create http request
                request.onreadystatechange = function() {
                if(request.readyState == 4 && request.status == 200) {

                    console.log(request.responseText);

                    data = JSON.parse(request.responseText);

                    console.log(data);

                    for (var i=0; i<data.length;i++) {
                                                
                        tempb.push(data[i].temperature);                        
                        time.push(data[i].time_stamp);
                        
                    }                                
                    dsptemp(tempb,time);            
                }
                }
                request.open('GET', requestURL);
                request.send(); // send the request

        }        
        else {
          alert("Please Select the Date");
        }

      }); //end btn click



    var from_date = "<?php echo $from_updated_time; ?>"
    var to_date = "<?php echo $to_updated_time; ?>" 
    var cannister = "<?php echo $database->freezer_selected_device; ?>"

    var data,  tempb = [],  time = [];

                    function formatParams( params )
                    {
                    return "?" + Object
                            .keys(params)
                            .map(function(key){
                            return key+"="+encodeURIComponent(params[key])
                            })
                            .join("&")
                    }


                var endpoint = "json_search.php";
                var params = { 'from_date': from_date, 'to_date': to_date, 'cannister':cannister };                                
                var url = endpoint + formatParams(params);

                console.log(url);
                               
                var requestURL = url;                
                var request = new XMLHttpRequest({mozSystem: true}); // create http request
                request.onreadystatechange = function() {
                if(request.readyState == 4 && request.status == 200) {

                    console.log(request.responseText);

                    data = JSON.parse(request.responseText);

                    console.log(data);

                    for (var i=0; i<data.length;i++) {
                                                

                        tempb.push(data[i].temperature);                        
                        time.push(data[i].time_stamp);
                        
                    }                
   
                    dsptemp(tempb,time);            
                }
                }
                request.open('GET', requestURL);
                request.send(); // send the request
                

}); //end doc */
</script>        


</head>

<body>
            <!-- form where from and to date and time to be selected -->
            
                    <div class="col-md-2">                    

                        <form method='post' action='freezer_data.php'>    
                            <input type="text" name="from_date" id="demo_from" class="form-control dateFilter" placeholder="From Date" />
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="to_date" id="demo_to" class="form-control dateFilter" placeholder="To Date" />
                        </div>
                            <input type="hidden" name="cannister" id="cannister" class="form-control dateFilter" value="<?php echo $database->freezer_selected_device; ?>" />
                        <div class="col-md-2">
                            <input type="button" name="search" id="btn_search" value="Search" class="btn btn-primary" />
                        </div>
                        </form>

                    </div>


                        <!-- //chart.js display chart  -->
                        
                        <div id="chartContainer" style="width: 100%;float: left;">
                             <canvas id="fridge_temp" width="auto" height="100"></canvas>
                        </div>


<!-- Bootstrap core JavaScript-->
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- chart.js plugins -->
<script src="vendor/chart.js/Chart.min.js"></script>

<!-- datetime picker -->
<script src="vendor/datetimepicker/build/jquery.datetimepicker.full.min.js"></script>

<script>

//invoke the date and time picker

jQuery('#demo_from').datetimepicker();

jQuery('#demo_to').datetimepicker();

</script>

</body>
</html>
                                
    
