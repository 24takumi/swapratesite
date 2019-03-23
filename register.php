<?php
//セッションスタートの前にhtmlを出力してはいけない
session_start();
 ?>
<!DOCTYPE html>
<html lang="ja" dir="ltr">
<!--dir="ltr"は左から右に読む言語との宣言-->
  <head>
    <meta charset="utf-8">
    <title>ユーザー登録</title>
    <link rel="stylesheet" href="stylesheet.css">
  </head>
  <?php
  $dsn = 'データベース名';
  $user = 'ユーザー名';
  $password = 'パスワード';
  $pdo = new PDO($dsn,$user,$password);

  	//テーブルの作成
  	$sql="CREATE TABLE passwordmaster"
  	."("
  	."id INT,"
  	."name varchar(20),"
  	."password varchar(255),"
  	."salt varchar(26)"
  	.");";
  	$stmt=$pdo->query($sql);

    $stmt = $pdo -> query("SELECT * FROM passwordmaster");
    while($item = $stmt->fetch()) {
    if($item['name'] == $_POST['name']){
      $errormsg = 'ご希望のニックネームは既に使用されています。';
     }
    }
    /*passwordmasterに入力する*/
    if(!empty($_POST['flag'])){
      if($errormsg==""){
        if (!empty($_POST['name']) && !empty($_POST['password'])) {
          if(mb_strlen($_POST['name'])<=20 && mb_strlen($_POST['password'])>=6 && mb_strlen($_POST['password'])<=32){
          $sql=$pdo->prepare("INSERT INTO passwordmaster(id,name,password,salt) VALUES(:id,:name,:password,:salt)");
          $sql->bindParam(':id',$id,PDO::PARAM_STR);
          $sql->bindParam(':name',$name,PDO::PARAM_STR);
          $sql->bindParam(':password',$encrypted_password,PDO::PARAM_STR);
          $sql->bindParam(':salt',$salt,PDO::PARAM_STR);

          $id_max = intval($pdo->query("SELECT max(id) FROM passwordmaster")->fetchColumn());
          $id=$id_max+1;
          $name = $_POST['name'];
          $password = $_POST['password'];
          //saltの作成
          $str='8zQk0fe3BKZ4ULhy7Dw2';
          $salt=str_shuffle($str);
          $encrypted_password = crypt($password, $salt); // 暗号化される（もっと強くしたければこれだけではダメですが、基本はcryptだと思います）
          $sql->execute();

        	header( 'Location: http://n24xfree.php.xdomain.jp/public_html/registerok.php' ) ;
        	exit ;
        }else{
          $error=1;
        }
      }else{
        $error=2;
      }
    }else{
      $error=3;
    }
  }
  	 ?>

  <body>
    <div class="pagebody">
      <div class="header">
        <div class="header-logo"><a href="http://n24xfree.php.xdomain.jp/public_html/mission_6.php">FXスワッパ―'s</a></div>
        <div class="header-list">
          <ul>
            <li id="menu01"><a href="http://n24xfree.php.xdomain.jp/public_html/bulletin_board.php">掲示板</a></li>
            <li id="menu02"><a href="http://n24xfree.php.xdomain.jp/public_html/swap_rate.php">スワップ比較</a></li>
            <li id="menu03"><a href="http://n24xfree.php.xdomain.jp/public_html/login.php">ログイン</a></li>
            <li id="menu04"><a href="http://n24xfree.php.xdomain.jp/public_html/register.php">ユーザー登録</a></li>
          </ul>
        </div>
        <div class="header-username">
          アカウント名:
          <?php
          require "logon.php";
          echo username($_SESSION['bridgename']);
           ?>
          /<a href="http://n24xfree.php.xdomain.jp/public_html/logout.php">ログアウト</a>
        </div>
      </div>
      <br>
      <h2>ユーザー登録</h2>
      <?php
      if ($error==1) {
        echo  '<FONT COLOR="RED">入力条件に沿って入力してください</FONT>';
      }elseif($error==2){
        echo  '<FONT COLOR="RED">空白です</FONT>';
      }elseif($error==3){
        echo $errormsg;
      }
       ?>
      <div class="register">
        <form action="register.php" method="post">
          <input type="text" name="name" placeholder="ニックネームを20文字以下で入力" value="" class="hoge"><br>
          <input type="text" name="password" placeholder="パスワードを6～32文字で入力" value="" class="hoge"><br>
          <input type="submit" value="登録">
          <input type="hidden" name="flag" value="formsend">
        </form>
      </div>
    </div>
  </body>
</html>
