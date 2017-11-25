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
  <title>Document</title>
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
  <script  src="https://code.jquery.com/jquery-1.12.0.js"></script>
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<body>
<?php
include 'includes/header.php';
?>
  <div class="container">
    <div class="row">
      <?php
        if(isset($_GET['category'])){
          $sql = "SELECT * FROM items WHERE item_cat = '$_GET[category]'";
          $run = mysqli_query($conn, $sql);
          while($rows = mysqli_fetch_assoc($run)){
            $discounted_price = $rows['item_price'] - $rows['item_discount'];
            $item_title = str_replace(' ', '-', $rows['item_title']);
            $item_id = str_replace(' ', '-', $rows['item_id']);
            echo "
            <div class='col-md-3'>
              <div class='col-md-12 single-item noPadding'>
                <div class='top'></div>
                <div class='bottom'>
                  <h3 class='item-title'><a href='item.php?item_title=$item_title&item_id=$item_id'>$rows[item_title]</a></h3>
                  <div class='pull-right cutted-price text-muted'><del>$ $rows[item_price]</del></div>
                  <div class='clearfix'></div>
                  <div class='pull-right discounted-price'>$ $discounted_price</div>
                </div>
              </div>
            </div>
            ";
          }
        }
      ?>

    </div>
  </div>
    <div class="clearfix"></div>
    <?php include 'includes/footer.php'; ?>
</body>
</html>
