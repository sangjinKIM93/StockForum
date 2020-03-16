<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php
      setcookie("name", "value", time()+60*60*60);
      echo "<script>self.close();</script>";

      // if(isset($_POST["option"])){
      //   setcookie("name", "value", time()+60*60*60); 
      //   echo "<script>self.close();</script>";
      // }
     ?>
  </body>
</html>
