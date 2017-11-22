<?php include '../includes/database.php';

  if(isset($_REQUEST['del_item_id'])){
    $del_sql = "DELETE FROM items WHERE item_id = '$_REQUEST[del_item_id]' ";
    mysqli_query($conn, $del_sql);
  }
?>
<table class="table table-bordered">
  <thead>
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
        echo"
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
                  <h4>Add new item to base:</h4>
                  
                </div>
                <div class='modal-body'>
                  <form method='post'>
                    <div class='form-group'>
                      <label>Item title</label>
                      <input type='text' name='item_title' value='$rows[item_title]' class='form-control'>
                    </div>
                    <div class='form-group'>
                      <label>Item description</label>
                      <input type='text'  name='item_description' value='$rows[item_description]' class='form-control'>
                    </div>
                    <div class='form-group'>
                      <label>Item category</label>
                      <select class'form-control' name='item_category'>
                        <option>Select category</option>";

                          $cat_sql = "SELECT * FROM item_cat";
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
                      <input  type='number' value='$rows[item_qty]'  name='item_qty' class='form-control'>
                    </div>
                    <div class='form-group'>
                      <label>Item cost</label>
                      <input  type='number' value='$rows[item_cost]'  name='item_cost' class='form-control'>
                    </div>
                    <div class='form-group'>
                      <label>Item price</label>
                      <input  type='number' value='$rows[item_price]' name='item_price' class='form-control'>
                    </div>
                    <div class='form-group'>
                      <label>Item discount</label>
                      <input  type='number' value='$rows[item_discount]' name='item_discount' class='form-control'>
                    </div>
                    <div class='form-group'>
                      <label>Item delivery charge</label>
                      <input  type='number' value='$rows[item_delivery]' name='item_delivery' class='form-control'>
                    </div>
                    <div class='form-group'>
                      <input  type='submit' name='item_submit' class='btn btn-primary btn-block'>
                    </div>
                  </form>
                </div>
                <div class='modal-footer'>
                  <button class='btn btn-danger' data-dismiss='modal'>Close</button>
                </div>
                </div>
              </div>
            </div>
          </td>
        </tr>
        ";
        $c++;
      }
    ?>
  </tbody>
</table>
