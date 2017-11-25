<?php
// Written by Piotr Swiderski
// stefan91kg@gmail.com / psswiderski@gmail.com
// Based on "The Complete Web Development Masterclass: Beginner To Advanced!" on udemy.com
// 11.2017
?>
<?php include "../includes/database.php";

  if(isset($_REQUEST['order_status'])){
    $up_sql = "UPDATE orders SET order_status='$_REQUEST[order_status]' WHERE order_id='$_REQUEST[order_id]' ";
    $up_run = mysqli_query($conn, $up_sql);
  }
  if(isset($_REQUEST['order_return_status'])){
    $up_sql = "UPDATE orders SET order_return_status='$_REQUEST[order_return_status]' WHERE order_id='$_REQUEST[order_id]' ";
    $up_run = mysqli_query($conn, $up_sql);
  }
?>
<table class="table table-bordered">
  <thead>
    <tr>
      <th>No.</th>
      <th>Buyer Name</th>
      <th>Email</th>
      <th>Contact Number</th>
      <th>State</th>
      <th>Delivery Adress</th>
      <th>Checkout Reference</th>
      <th class="text-right">Total Cost</th>
      <th class="text-center">Order status</th>
      <th class="text-center">Return status</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $c = 1;
      $sql = "SELECT * FROM orders";
      $run = mysqli_query($conn, $sql);
      while($rows = mysqli_fetch_assoc($run)){
        if($rows['order_status']==0){
          $btn_class = 'btn-warning';
          $btn_value = 'Pending';
        }else{
          $btn_class = 'btn-success';
          $btn_value = 'Sent';
        }
        if($rows['order_return_status']==0){
          $ret_btn_value = 'Returned';
        }else{
          $ret_btn_value = 'No return';
        }
        echo "
        <tr>
          <td>$c</td>
          <td>$rows[order_name]</td>
          <td>$rows[order_email]</td>
          <td>$rows[order_con_numb]</td>
          <td>$rows[order_state]</td>
          <td>$rows[order_delivery_adress]</td>
          <td>
            <button class='btn' data-toggle='modal' data-target='#order_checkout_modal$rows[order_id]'>$rows[order_checkout_ref]</button>
            <div class='modal fade' id='order_checkout_modal$rows[order_id]'>
              <div class='modal-dialog'>
                <div class='modal-content'>
                  <div class='modal-header'></div>
                  <div class='modal-body'>
                    <table class='table table-bordered'>
                      <thead>
                        <tr>
                          <th>No.</th>
                          <th>Item</th>
                          <th>qty</th>
                          <th>Price</th>
                          <th>Total</th>
                        </tr>
                      </thead>
                      <tbody>";
                      //$chk_sql = "SELECT * FROM checkout WHERE check_ref = '$rows[order_checkout_ref]'";
                      $chk_sql = "SELECT * FROM checkout c JOIN items i ON c.check_item = i.item_id WHERE c.check_ref = '$rows[order_checkout_ref]' ";
                      $chk_run = mysqli_query($conn, $chk_sql);
                      while($chk_rows = mysqli_fetch_assoc($chk_run)){
                        if($chk_rows['item_title']== ''){
                          $item_title='Data n/a';
                        }else{
                          $item_title = $chk_rows['item_title'];
                        }
                        $total = $chk_rows['check_qty'] * $chk_rows['item_price']; //Cos się tutaj nie zgadza z total i overall total, posprawdzac i dokonczyc
                      echo  "<tr>
                          <td>$c</td>
                          <td>$item_title</td>
                          <td>$chk_rows[check_qty]</td>
                          <td>$chk_rows[item_price]</td>
                          <td>$total</td>
                        </tr>";
                      }
              echo "  </tbody>
                    </table>

                      <table class='table table-bordered'>
                      <thead>
                        <tr>
                          <th colspan=2 class='text-center'>Order Summary</td>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Subtotal</td>
                          <td>quote</td>
                        </tr>
                        <tr>
                          <td>Delivery charges</td>
                          <td>qote</td>
                        </tr>
                        <tr>
                          <td>Total</td>
                          <td>$rows[order_total]</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class='modal-footer'></div>
                </div>
              </div>
            </div>
          </td>
          <td class='text-right'>$rows[order_total]</td>"; ?>
          <td class='text-center'><button onclick="order_status(<?php echo $rows['order_status'].', '.$rows['order_id']; ?>);" class='btn btn-block <?php $btn_class ; ?>'><?php echo $btn_value ;?> </button></td>
          <td class="text-center"><button onclick="return_status(<?php echo $rows['order_return_status'].', '.$rows['order_id']; ?>);" class = 'btn'><?php echo $ret_btn_value ;?></button></td>
        </tr>
        <?php
        $c++;
      }
      ?>
  </tbody>
</table>
