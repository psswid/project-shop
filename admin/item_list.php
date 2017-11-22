<?php include "../includes/database.php";
  if(isset($_POST['item_submit'])){
    $item_title = mysqli_real_escape_string($conn, strip_tags($_POST['item_title']));
    $item_description = mysqli_real_escape_string($conn, $_POST['item_description']);
    $item_category = mysqli_real_escape_string($conn, strip_tags($_POST['item_category']));
    $item_qty = mysqli_real_escape_string($conn, strip_tags($_POST['item_qty']));
    $item_cost = mysqli_real_escape_string($conn, strip_tags($_POST['item_cost']));
    $item_price = mysqli_real_escape_string($conn, strip_tags($_POST['item_price']));
    $item_discount = mysqli_real_escape_string($conn, strip_tags($_POST['item_discount']));
    $item_delivery = mysqli_real_escape_string($conn, strip_tags($_POST['item_delivery']));

    if(isset($_FILES['item_image']['name'])){
      $file_name = $_FILES['item_image']['name'];
      $path_address = "../images/items/$file_name";
      $path_address_db = "images/items/$file_name";
      $img_confirm = 1;
      $file_type = pathinfo($_FILES['item_image']['name'], PATHINFO_EXTENSION);
        if($_FILES['item_image']['size']>200000){
          $img_confirm = 0;
          echo "Size too big";
        }
        if($file_type!='jpg' && $file_type!='png' && $file_type!='gif'){
          $img_confirm = 0;
          echo "Wrong image type";
        }
        if($img_confirm == 0){

        }else{
          if(move_uploaded_file($_FILES['item_image']['tmp_name'], $path_address)){
            $item_ins_sql = "INSERT INTO items (item_image, item_title, item_description, item_cat, item_qty, item_cost, item_price, item_discount, item_delivery) VALUES ('$path_address_db', '$item_title', '$item_description', '$item_category', '$item_qty', '$item_cost', '$item_price', '$item_discount', '$item_delivery');";
            $item_ins_run = mysqli_query($conn, $item_ins_sql);
          }
        }
    }
  }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Item list | Admin panel</title>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script  src="https://code.jquery.com/jquery-1.12.0.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="https://cdn.tinymce.com/4/tinymce.min.js"></script>
    <script>tinymce.init({ selector:'textarea' });</script>
    <script>
      function get_item_list_data(){

        xmlhttp = new XMLHttpRequest();

        xmlhttp.onreadystatechange = function(){
          if(xmlhttp.readyState == 4 && xmlhttp.status == 200){

            document.getElementById('get_item_list_data').innerHTML = xmlhttp.responseText;
          }
        }

        xmlhttp.open('GET', 'admin_list_process.php', true);
        xmlhttp.send();
      }
      function del_item(item_id){
        xmlhttp.onreadystatechange = function(){
          if(xmlhttp.readyState == 4 && xmlhttp.status == 200){

            document.getElementById('get_item_list_data').innerHTML = xmlhttp.responseText;
          }
        }

        xmlhttp.open('GET', 'admin_list_process.php?del_item_id='+item_id, true);
        xmlhttp.send();
      }

    </script>
  </head>
  <body onload="get_item_list_data();">
    <?php include "includes/header.php";?>
    <div class="container-fluid">
      <button class="btn btn-danger" data-toggle="modal" data-backdrop="static" date-keyboard="false" data-target="#add_new_item">Add new item</button>
      <div id= "add_new_item" class="modal fade">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button class="close" data-dismiss = "modal">x</button>
              <h4>Add new item to base:</h4>
            </div>
            <div class="modal-body">
              <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="">Item image</label>
                  <input  type="file" name = "item_image" class = "form-control">
                </div>
                <div class="form-group">
                  <label for="">Item title</label>
                  <input type="text" name = "item_title" class = "form-control">
                </div>
                <div class="form-group">
                  <label for="">Item description</label>
                  <textarea  name = "item_description" class = "form-control"></textarea>
                </div>
                <div class="form-group">
                  <label for="">Item category</label>
                  <select class="form-control" name="item_category">
                    <option value="">Select category</option>
                    <?php

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
                        echo "
                          <option value='$cat_slug'>$cat_rows[cat_name]</option>
                        ";}while($cat_rows = mysqli_fetch_assoc($cat_run));}
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="">Item quantity</label>
                  <input  type="number"  name = "item_qty" class = "form-control">
                </div>
                <div class="form-group">
                  <label for="">Item cost</label>
                  <input  type="number"  name = "item_cost" class = "form-control">
                </div>
                <div class="form-group">
                  <label for="">Item price</label>
                  <input  type="number" name = "item_price" class = "form-control">
                </div>
                <div class="form-group">
                  <label for="">Item discount</label>
                  <input  type="number" name = "item_discount" class = "form-control">
                </div>
                <div class="form-group">
                  <label for="">Item delivery charge</label>
                  <input  type="number" name = "item_delivery" class = "form-control">
                </div>
                <div class="form-group">
                  <input  type="submit" name = "item_submit" class = "btn btn-primary btn-block">
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button class="btn btn-danger" data-dismiss = "modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      <div id="get_item_list_data"></div>

    </div>
    <?php include "includes/footer.php";?>
  </body>
</html>
