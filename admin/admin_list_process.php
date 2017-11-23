<?php include '../includes/database.php';

  if(isset($_REQUEST['del_item_id'])){
    $del_sql = "DELETE FROM items WHERE item_id = '$_REQUEST[del_item_id]' ";
    mysqli_query($conn, $del_sql);
  }

  if(isset($_REQUEST['up_item_id'])){
    $item_id = $_REQUEST['up_item_id']; //$brandid = isset($_POST['bidg']) ? $_POST['bidg']: '';
    $item_title = mysqli_real_escape_string($conn, strip_tags($_REQUEST['item_title']));
    $item_description = mysqli_real_escape_string($conn, $_REQUEST['item_description']);
    $item_category = mysqli_real_escape_string($conn, strip_tags($_REQUEST['item_category']));
    $item_qty = mysqli_real_escape_string($conn, strip_tags($_REQUEST['item_qty']));
    $item_cost = mysqli_real_escape_string($conn, strip_tags($_REQUEST['item_cost']));
    $item_price = mysqli_real_escape_string($conn, strip_tags($_REQUEST['item_price']));
    $item_discount = mysqli_real_escape_string($conn, strip_tags($_REQUEST['item_discount']));
    $item_delivery = mysqli_real_escape_string($conn, strip_tags($_REQUEST['item_delivery']));


    // $item_ins_sql = "INSERT INTO items ( item_title, item_description, item_cat, item_qty, item_cost, item_price, item_discount, item_delivery) VALUES ( '$item_title', '$item_description', '$item_category', '$item_qty', '$item_cost', '$item_price', '$item_discount', '$item_delivery');";
    $item_up_sql = "UPDATE items SET item_title = '$item_title', item_description = '$item_description', item_cat = '$item_category', item_qty = '$item_qty', item_cost = '$item_cost', item_price = '$item_price', item_discount = '$item_discount', item_delivery = '$item_delivery' WHERE item_id = '$item_id' ";
    $item_up_run = mysqli_query($conn, $item_up_sql);
  }
?>
<table class="table table-bordered">
  <thead><!-- Kilka rzeczy do poprawienia jest.
          1. Item description po edycji się zamiast aktualizowac - usuwa
        2. Nacisnieciu Submit po edycji pozycji ajax aktualizuje wartoś, np item title, ale 'nie wraca' do strony, pozostaje ciemne tło, jak modal zjedzie
      3. NAJWAŻNIEJSZE - Edit nie działa w pętli, niezależnie od wyboru pozycji, w kursie ciągle prowadzący operował tylko na jednej pozycji, więcej nawet nie dodał i nie sprawdził-->
    <tr>
      <th>No.</th>
      <th>image</th>
      <th>Item title</th>
      <th>Item description</th>
      <th>Item category</th>
      <th>Item quantity</th>
      <th>item price</th>
      <th>Item cost</th>
      <th>Item discount</th>
      <th>After discount</th>
      <th>Item delivery</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $c=1;
      $sel_sql = "SELECT * FROM items";
      $sel_run = mysqli_query($conn, $sel_sql);
      while($rows = mysqli_fetch_assoc($sel_run)){
        $discounted_price = $rows['item_price'] - $rows['item_discount'];
        echo
        "
        <tr>
          <td>$c</td>
          <td>Image</td>
          <td>$rows[item_title]</td>
          <td>"; echo strip_tags($rows['item_description']); echo"</td>
          <td>$rows[item_cat]</td>
          <td>$rows[item_qty]</td>
          <td>$rows[item_price]</td>
          <td>$rows[item_cost]</td>
          <td>$rows[item_discount]</td>
          <td>$discounted_price</td>
          <td>$rows[item_delivery]</td>
          <td>
            <div class='dropdown'>
                <button class='btn btn-danger dropdown-toggle' data-toggle='dropdown'>Actions <span class='caret'></span></button>
                <ul class='dropdown-menu dropdown-menu-right'>
                  <li>
                    <a href='#edit_modal' data-toggle='modal'>Edit</a>

                  </li;"; ?>
                  <li><a href="javascript:;" onclick="del_item(<?php echo $rows['item_id'];?>)">Delete</a></li>
          <?php  echo "</ul>
            </div>
            <div class='modal fade' id='edit_modal'>
              <div class='modal-dialog'>
                <div class='modal-content'>
                <div class='modal-header'>
                  <button class='close' data-dismiss='modal'>x</button>
                  <h4>Edit item id: $rows[item_id]</h4>
                </div>

                <div class='modal-body'>
                  <div id='form1'>
                    <div class='form-group'>
                      <label>Item title</label>
                      <input type='text' id='item_title' value='$rows[item_title]' class='form-control'>
                    </div>
                    <div class='form-group'>
                      <label>Item description</label>
                      <input type='text'  id='item_description' value='$rows[item_description]' class='form-control'>
                    </div>
                    <div class='form-group'>
                      <label>Item category</label>
                      <select class'form-control' id='item_category'>
                        <option>Select category</option>";

                          $cat_sql = "SELECT * FROM item_cat";  //Nie ogarniam się się odawliło przy item description, nie pobierało mi z bazy tej wartości. Dopiero jak dałem echo $rows[item_description] to nagle zaskoczyło pobieranie wartości.
                          $cat_run = mysqli_query($conn, $cat_sql);
                          $cat_rows = mysqli_fetch_assoc($cat_run);
                          if(!$cat_rows){
                            echo "No result";
                          }else{
                            do{

                              $cat_name = ucwords($cat_rows['cat_name']);
                            if($cat_rows['cat_slug'] ==' '){
                              $cat_slug=$cat_rows['cat_name'];
                            }else{
                              $cat_slug = $cat_rows['cat_slug'];
                            }
                            if($cat_slug == $rows['item_cat']){
                              echo "
                                <option selected value='$cat_slug'>$cat_rows[cat_name]</option>
                              ";
                            }else{
                              echo "
                                <option value='$cat_slug'>$cat_rows[cat_name]</option>
                              ";
                            }
                            }while($cat_rows = mysqli_fetch_assoc($cat_run));}

                    echo "</select>
                    </div>
                    <div class='form-group'>
                      <label>Item quantity</label>
                      <input  type='number' value='$rows[item_qty]'  id='item_qty' class='form-control'>
                    </div>
                    <div class='form-group'>
                      <label>Item cost</label>
                      <input  type='number' value='$rows[item_cost]'  id='item_cost' class='form-control'>
                    </div>
                    <div class='form-group'>
                      <label>Item price</label>
                      <input  type='number' value='$rows[item_price]' id='item_price' class='form-control'>
                    </div>
                    <div class='form-group'>
                      <label>Item discount</label>
                      <input  type='number' value='$rows[item_discount]' id='item_discount' class='form-control'>
                    </div>
                    <div class='form-group'>
                      <label>Item delivery charge</label>
                      <input  type='number' value='$rows[item_delivery]' id='item_delivery' class='form-control'>
                    </div>
                    <div class='form-group'>
                      <input type='number' id='up_item_id' value='$rows[item_id]'>"; ?>
                      <button onclick="javascript: edit_item();" class='btn btn-primary btn-block'>Submit</button>
                    </div>
                  </div>
                </div>
                <div class='modal-footer'>
                  <button class='btn btn-danger' data-dismiss='modal'>Close</button>
                </div>
                </div>
              </div>
            </div>
          </td>
        </tr>
        "<?php
        $c++;
      }
    ?>
  </tbody>
</table>
