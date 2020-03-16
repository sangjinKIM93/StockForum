<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php
      session_start();
      $conn = mysqli_connect("localhost", "root", "tkdwls12!Q", "db");
      $sql = "SELECT * FROM user";
      $result = mysqli_query($conn, $sql);

      $password = $_POST["password"];
      $id = $_POST['id'];

      if(isset($_POST["id_ck"])){
        setcookie("id", $id, time()+60*60); //save cookie
      }

      $i = 0;
      //validation-check
      while($row = mysqli_fetch_array($result)){
        $compare_uid = strcmp($id, $row['email']);
        $compare_password = strcmp($password, $row['password']);
        if($compare_uid == 0 && $compare_password == 0){
          $i = 1;
          $_SESSION["name"] = $row['name'];
          break;
        }
      }
      if($i == 1){
        echo "Welcome to Quant Forum";
        $_SESSION["id"] = $id;
        header("Location:http://localhost/template2/index.php");
      } else {
      ?>
      <script>
        alert("Failed to login");
        history.back();
      </script>
      <?php
      }
      $i = 0;
     ?>
  </body>
</html>
