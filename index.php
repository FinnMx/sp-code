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
        <input type="text" placeholder="Username" name="username" class="form-control"> 
      </div>

      <div class="form-group">
        <input type="password" placeholder="Password" name ="password" class="form-control"> 
      </div>

        <input type="submit" value="Login" name="submit" class="btn btn-primary btn-sm">
        <br><br>
        <a href="SupplierLogin.php">
            <input class="btn btn-primary btn-sm" type="button" value="SupplierLogin" />
        </a>
        <br><br>
        <?php
      error_reporting(0);

      if (isset($_POST['submit'])){

          if($_POST['username']== '' || $_POST['password'] == ''){
                echo "Please fill all fields";
          }

          else{
            $db = new SQLite3('C:\xampp\htdocs\myDB.db');
            $sql = "SELECT Username, Password, Access_level FROM Users WHERE Username =:username";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':username', $_POST['username'], SQLITE3_TEXT);
            $result= $stmt->execute();
            $arrayResult = [];

            while($row=$result->fetchArray(SQLITE3_NUM)){ // how to read the result from the query
              $arrayResult = $row;                              
            }


            if($arrayResult[0] == $_POST['username'] && $arrayResult[1] == $_POST['password'] && $arrayResult[2] == 1){
              header("Location: employeepage.php");
              }
            elseif ($arrayResult[0] == $_POST['username'] && $arrayResult[1] == $_POST['password'] && $arrayResult[2] == 2) {
              header("Location: managerpage.php");
            }
            else{
              echo"invalid login";
            }


          }
      }
      ?>

      </form> 

    

</body>

</html>