<?php include '../includes/database.php'?>
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
                  <li><a href='#'>Edit</a></li>
                  <li><a href='#'>Delete</a></li>
                </ul>
            </div>
          </td>
        </tr>
        ";
        $c++;
      }
    ?>
  </tbody>
</table>
