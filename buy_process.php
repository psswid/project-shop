<?php
  //session_start();   wykomentowane, bo sesja z buy.php juz jest
  include 'includes/database.php';
  if(isset($_REQUEST['check_del_id'])){
    $check_del_sql = "DELETE FROM checkout WHERE check_id = '$_REQUEST[check_del_id]' ";
    $check_del_run = mysqli_query($conn, $check_del_sql);
  }
  if(isset($_REQUEST['up_check_qty'])){
    $up_check_qty_sql = "UPDATE checkout SET check_qty = '$_REQUEST[up_check_qty]' WHERE check_id = '$_REQUEST[up_check_id]' ";
    $up_check_qty_run = mysqli_query($conn, $up_check_qty_sql);
  }
  $c = 1;
  $i = 0;
  $total = 0;
  $delivery_charges = 0;
  $for_total = 0;

  echo "
      <table class='table'>
            <thead>
              <tr>
                <th>No.</th>
                <th>Item</th>
                <th class='text-center'>Quantity</th>
                <th class='text-center'>Delete</th>
                <th class='text-center'>Price</th>
                <th class='text-center'>Total</th>
              </tr>
            </thead>
            <tbody >
          ";

  $check_sel_sql = "SELECT * FROM checkout c JOIN items i ON c.check_item = i.item_id WHERE c.check_ref = '$_SESSION[ref]' ";
  $check_sel_run = mysqli_query($conn, $check_sel_sql);
  $check_sel_rows = mysqli_fetch_assoc($check_sel_run);
  if(!$check_sel_rows){
    echo "No results.";
  }else{
    do {
      ++$i;

      $discounted_price = $check_sel_rows['item_price'] - $check_sel_rows['item_discount'];
      $sub_total = $discounted_price * $check_sel_rows['check_qty'];
      $total = $total + $sub_total;
      $delivery_charges += $check_sel_rows['item_delivery'];

      for($s=1; $s<=$i; ++$s){
        $for_discounted_price = $check_sel_rows['item_price'] - $check_sel_rows['item_discount'];
        $for_sub_total = $for_discounted_price * $check_sel_rows['check_qty'];
        $for_total = $for_total + $for_sub_total;
      }
      echo "
        <tr>
          <td>$c</td>
          <td>$check_sel_rows[item_title]</td>"; ?>
          <td class='text-right'><input type='number' style='width: 50px;' onblur="up_check_qty(this.value, '<?php echo (htmlspecialchars($check_sel_rows['check_id'])); ?>')" value='<?php echo ($check_sel_rows['check_qty']); ?> '/>
          <?php echo "<input type='number' style='width: 50px;'  onblur=up_check_qty(this.value, '$check_sel_rows[check_id]' value='$check_sel_rows[check_qty]')>";?></td>
          <td class='text-right'><button class='btn btn-danger'  onclick="del_func(<?php echo $check_sel_rows['check_id']; ?>)";>Delete</button></td>
          <?php echo "<td class='text-right'>$discounted_price</td>
          <td class='text-right'>$for_sub_total</td>
        </tr>";
      $c++;
    }while($check_sel_rows = mysqli_fetch_assoc($check_sel_run));
  }
  $_SESSION['overall_total'] =  $total + $delivery_charges;
  echo "
  </table>
        </tbody>
        <table class='table'>
          <thead>
            <tr>
              <th class='text-center' colspan='2'>Order Summary</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class=''>Subtotal</td>
              <td class='text-center'>$total</td>
            </tr>
            <tr>
              <td class=''>Delivery charges</td>
              <td class='text-center'>$delivery_charges</td>
            </tr>
            <tr>
              <td class=''>Total</td>
              <td class='text-center'>$_SESSION[overall_total]</td>
            </tr>
          </tbody>
        </table>
  ";
?>
