<!DOCTYPE html>
<html>

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>

<body>


      <form style="width: 175px; text-align: center; position: absolute; top: 35%; left: 45%;" method="post"> 

      <h2>Login</h2> 

      <div class="form-group">
        <input type="text" placeholder="PurchaseID" name="pid" class="form-control"> 
      </div>

        <input type="submit" value="Login" name="submit" class="btn btn-primary btn-sm">
        <a href="index.php">
            <input class="btn btn-primary btn-sm" type="button" type="button" value="Back" />
        </a>
        <br><br>

        <?php

        error_reporting(0);

        session_start();

      if (isset($_POST['submit'])){

          if($_POST['pid'] == ''){
                echo "Please fill all fields";
          }

          else{
            $db = new SQLite3('C:\xampp\htdocs\myDB.db');
            $sql = "SELECT Purchase_ID FROM Stock_Purchases WHERE Purchase_ID =:pid AND Status='pending'";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':pid', $_POST['pid'], SQLITE3_TEXT);
            $result= $stmt->execute();
            $arrayResult = [];

            while($row=$result->fetchArray(SQLITE3_NUM)){ // how to read the result from the query
              $arrayResult = $row;                              
            }


            if($arrayResult[0] == $_POST['pid']){
              header("Location: supplierpage.php");

              $_SESSION['pid'] = $_POST['pid'];
            }

            else{

              echo"invalid login code";
            }



          }
      }
      ?>

      </form> 

</body>

</html>