
<?php
  session_start();
  include 'includes/database.php';
  if(isset($_GET['check_item_id'])){
    $date = date('Y-m-d h:i:s');
    $rand_num = mt_rand();
    if(isset($_SESSION['ref'])){

    }else{
      $_SESSION['ref'] = $date.'_'.$rand_num;
    }
    $check_sql = "INSERT INTO checkout (check_item, check_ref, check_timing, check_qty) VALUES ('$_GET[check_item_id]', '$_SESSION[ref]', '$date', 1)";
    if($check_run = mysqli_query($conn, $check_sql)){
      ?> <script> window.location = "buyn.php"; </script> <?php
    }

    }

    if(isset($_POST['order_submit'])){
      $name = mysqli_real_escape_string($conn, strip_tags($_POST['name']));
      $email = mysqli_real_escape_string($conn, strip_tags($_POST['email']));
      $connumb = mysqli_real_escape_string($conn, strip_tags($_POST['contact']));
      $state = mysqli_real_escape_string($conn, strip_tags($_POST['state']));
      $delivery_adress = mysqli_real_escape_string($conn, strip_tags($_POST['deliveryAdress']));


      $order_ins_sql = "INSERT INTO orders (order_name, order_email, order_con_numb, order_state, order_delivery_adress, order_checkout_ref, order_total) VALUES ('$name', '$email', '$connumb', '$state', '$delivery_adress', '$_SESSION[ref]', '$_SESSION[overall_total]')";
      $order_ins_sql = mysqli_query($conn, $order_ins_sql);

    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Shopping Cart</title>
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
  <script  src="https://code.jquery.com/jquery-1.12.0.js"></script>
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  <script>
    function ajax_func(){
      xmlhttp = new XMLHttpRequest();

      xmlhttp.onreadystatechange = function(){
        if(xmlhttp.readyState == 4 && xmlhttp.status == 200){

          document.getElementById('get_processed_data').innerHTML = xmlhttp.responseText;
        }
      }

      xmlhttp.open('GET', 'buy_process.php', true);
      xmlhttp.send();
    }
    function del_func(check_id){

      xmlhttp.onreadystatechange = function(){
        if(xmlhttp.readyState == 4 && xmlhttp.status == 200){

          document.getElementById('get_processed_data').innerHTML = xmlhttp.responseText;
        }
      }
      xmlhttp.open('GET', 'buy_process.php?check_del_id='+check_id, true);
      xmlhttp.send();
    }
    function up_check_qty(check_qty, check_id){

      xmlhttp.onreadystatechange = function(){
        if(xmlhttp.readyState == 4 && xmlhttp.status == 200){

          document.getElementById('get_processed_data').innerHTML = xmlhttp.responseText;
        }
      }
      xmlhttp.open('GET', 'buy_process.php?up_check_qty='+check_qty+'&up_check_id='+check_id, true);
      xmlhttp.send();
    }

  </script>
</head>
<body onload = "ajax_func();">
  <?php include 'includes/header.php'; ?>
  <div class="container">
    <div class="page-header">
      <h2 class='pull-left'>Check Out</h2>
      <div class='pull-right'><button class="btn btn-success" data-toggle="modal" data-target="#proceed_modal" data-backdrop="static" data-keyboard="false">Proceed</button></div>
      <div id="proceed_modal" class="modal fade">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header"><button class="close" data-dismiss="modal">x</button></div>
            <div class="modal-body">
              <form method="post">
                <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" id="name" name="name" class="form-control" placeholder="Full Name">
                </div>
                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" id="email" name="email"class="form-control" placeholder="Email adress">
                </div>
                <div class="form-group">
                  <label for="con_numb">Contact Number</label>
                  <input type="text" id="connumb" name="contact" class="form-control" placeholder="Contact number">
                </div>
                <div class="form-group">
                  <label for="con_numb">State</label>
                  <input type="text" id="state" name="state" class="form-control" placeholder="Contact number">
                </div>
                <div class="form-group">
                  <label for="con_numb">Delivery adress</label>
                  <input type="text" id="deliveryAdress" name="deliveryAdress" class="form-control" placeholder="Delivery adress">
                </div>
                <!-- <div class="form-group">
                  <label for="adress">Delivery adress</label>
                  <textarea name="adress" name="deliveryAdress" id="deliveryAdress" cols="10" rows="10" class="form-control"></textarea>
                </div> -->
                <div class="form-group">
                  <input type="submit" name="order_submit" class="btn btn-danger btn-block">
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button class="btm btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">Order Details</div>
      <div class="panel-body">

        <?php include 'buy_process.php'; ?>


      </div>
    </div>
  </div>

  <br><br><br><br><br>
  <?php include 'includes/footer.php'; ?>
</body>
</html>
