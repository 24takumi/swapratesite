
  <?php
  //ユーザー名を返します
  function username($data){
  //データベースへの接続(PDOオブジェクトの生成)
  $dsn = 'データベース名';
  $user = 'ユーザー名';
  $password = 'パスワード';
  $pdo = new PDO($dsn,$user,$password);

  session_start();
    if (isset($data)){
      return $_SESSION['bridgename'];
    }else{
      return "ゲスト";
    }
  }
   ?>
