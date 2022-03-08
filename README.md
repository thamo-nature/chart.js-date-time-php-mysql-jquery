# chart.js-date-time-php-mysql-jquery
chart.js to plot graph between selected date with time </br>
chart.js fetches data from mysql db through jquery XHTML request.</br>

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
  
    //when button clicked
  
    $('#btn_search').click(function () {
        
        //variables from form
  
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


//when button not clicked assign variables from php 
                                                     
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


<script>

//invoke the date and time picker

jQuery('#demo_from').datetimepicker();

jQuery('#demo_to').datetimepicker();

</script>
