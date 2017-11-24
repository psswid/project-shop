<?php include "../includes/database.php";?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Orders | Admin panel</title>
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <script  src="https://code.jquery.com/jquery-1.12.0.js"></script>
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  <script>
    function get_order_list(){
      xmlhttp = new XMLHttpRequest();

      xmlhttp.onreadystatechange = function (){
        if(xmlhttp.readyState == 4 && xmlhttp.status == 200){

          document.getElementById('get_order_list_data').innerHTML = xmlhttp.responseText;
        }
      }

      xmlhttp.open('GET', 'order_list_process.php', true);
      xmlhttp.send();
    }

    function order_status(order_status, order_id){
      if(order_status == 1){
        order_status = 0;
      }else{
        order_status = 1;
      }
      xmlhttp.onreadystatechange = function(){
        if(xmlhttp.readyState == 4 && xmlhttp.status == 200){

          document.getElementById('get_order_list_data').innerHTML = xmlhttp.responseText;
        }
      }
      xmlhttp.open('GET', 'order_list_process.php?order_status='+order_status+'&order_id='+order_id, true);
      xmlhttp.send();
    }
    function return_status(order_return_status, order_id){
      if(order_return_status == 1){
        order_return_status = 0;
      }else{
        order_return_status = 1;
      }
      xmlhttp.onreadystatechange = function(){
        if(xmlhttp.readyState == 4 && xmlhttp.status == 200){

          document.getElementById('get_order_list_data').innerHTML = xmlhttp.responseText;
        }
      }
      xmlhttp.open('GET', 'order_list_process.php?order_return_status='+order_return_status+'&order_id='+order_id, true);
      xmlhttp.send();
    }
  </script>
</head>
<body onload = "get_order_list();">
<?php include "includes/header.php";?>
  <div class="container">
    <div id="get_order_list_data">

    </div>

  </div>
<?php include "includes/footer.php";?>
</body>
</html>
