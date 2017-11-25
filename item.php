<?php
// Written by Piotr Swiderski
// stefan91kg@gmail.com / psswiderski@gmail.com
// Based on "The Complete Web Development Masterclass: Beginner To Advanced!" on udemy.com
// 11.2017
?>
<?php
include 'includes/database.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Product detail</title>
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
  <script  src="https://code.jquery.com/jquery-1.12.0.js"></script>
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<body>
  <?php include 'includes/header.php'; ?>
  <div class="container">
    <div class="row">
      <ol class="breadcrumb">
        <li><a href="index.php">Home</a></li>
        <?php
        if(isset($_GET['item_id'])){
          $sql = "SELECT * FROM items WHERE item_id = '$_GET[item_id]' ";
          $run = mysqli_query($conn, $sql);
          while($rows = mysqli_fetch_assoc($run)){
            $item_cat = ucwords($rows['item_cat']);
            $item_id=$rows['item_id'];

            echo "
            <li><a href='category.php?category=$item_cat'>$item_cat</a></li>
            <li class='active'>$rows[item_title]</li>
            ";
        ?>
      </ol>
    </div>
    <div class="row">
      <?php
          echo "
          <div class='col-md-8'>
            <h3 class='pp-title'>I$rows[item_title]</h3>
            <div class='top'>Image</div>
            <h4 class='pp-decs-head'>Description</h4>
            <div class='pp-desc-detail'>$rows[item_description]</div>
          </div>
          ";
        }
      }
      ?>
    <div class='col-md-4'></div>
    <aside class="col-md-4">
      <a href='buyn.php?check_item_id=<?php echo $item_id;?>' class='btn btn-success btn-lg'>Buy</a><br><br>
      <ul class="list-group">
        <li class="list-group item">
          <div class="row">
            <div class="col-md-4">Icon</div>
            <div class="col-md-8">Delivery time info</div>
          </div>
        </li>
        <li class="list-group item">
          <div class="row">
            <div class="col-md-4">Icon</div>
            <div class="col-md-8">Returns info</div>
          </div>
        </li>
        <li class="list-group item">
          <div class="row">
            <div class="col-md-4">Icon</div>
            <div class="col-md-8">Product consultant contact</div>
          </div>
        </li>
      </ul>
    </aside>
    </div>
    <div class="page-header">
      <h4>Related items</h4>
    </div>
    <section class="row">
      <?php
        $rel_sql = "SELECT * FROM items ORDER BY rand() LIMIT 4";
        $rel_run = mysqli_query($conn, $rel_sql);
        while ($rel_rows = mysqli_fetch_assoc($rel_run)){
          $disc_price = $rel_rows['item_price'] - $rel_rows['item_discount'];
          $item_title=str_replace(' ', '-', $rel_rows['item_title']);
          $item_id=str_replace(' ', '-', $rel_rows['item_id']);
          echo "
          <div class='col-md-3'>
            <div class='col-md-12 single-item noPadding'>
              <div class='top'></div>
              <div class='bottom'>
                <h3 class='item-title'><a href='item.php?item_title=$item_title&item_id=$item_id'>$rel_rows[item_title]</a></h3>
                <div class='pull-right cutted-price text-muted'><del>$ $rel_rows[item_price]</del></div>
                <div class='clearfix'></div>
                <div class='pull-right discounted-price'>$ $disc_price</div>
              </div>
            </div>
          </div>";

        }
      ?>


    </section>
  </div><br><br><br><br><br>
  <?php include 'includes/footer.php'; ?>

  </body>
</html>
