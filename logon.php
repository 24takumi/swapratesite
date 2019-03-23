
  <?php
  function username($data){
  session_start();
    if (isset($data)){
      return $_SESSION['bridgename'];
    }else{
      return "ゲスト";
    }
  }
   ?>
