<?php
//セッション
session_start();
 ?>
<!DOCTYPE html>
<html lang="ja" dir="ltr">
<!--dir="ltr"は左から右に読む言語との宣言-->
  <head>
    <meta charset="utf-8">
    <title>ログイン</title>
    <link rel="stylesheet" href="stylesheet.css">
  </head>
  <?php
  //データベースへの接続(PDOオブジェクトの生成)
  $dsn = 'データベース名';
  $user = 'ユーザー名';
  $password = 'パスワード';
  $pdo = new PDO($dsn,$user,$password);

  if($_POST['flag']=="formsend"){
    $name=$_POST['name'];
    //sqlインジェクションにも強い
    //  SQL文 :nameは、名前付きプレースホルダ
    $sql='SELECT*FROM passwordmaster where name=:name';
    // プリペアドステートメントを作成
    $stmt=$pdo->prepare($sql);
    // プレースホルダと変数をバインド
    $stmt->bindParam(":name",$name);
    $stmt->execute(); //実行
    // データを取得
	  $results = $stmt->fetch(PDO::FETCH_ASSOC);
    //値の確認用
      /*echo $results['id'].',';
      echo $results['name'].',';
      echo $results['password'].',';
      echo $results['salt'].'<br>';*/
    $PW=$results['password'];
    $salt=$results['salt'];
    $encrypted_password = crypt($_POST['password'], $salt); //入力パスワードとDBのソルトでハッシュ化
		if ($encrypted_password == $PW) {
      $_SESSION['bridgename']=$_POST['name'];
      //ログイン後のページに飛ばす
      header( 'Location: http://n24xfree.php.xdomain.jp/public_html/mission_6.php' ) ;
      exit ;
    }else{
      $loginflag= 'ニックネーム、もしくはパスワードが間違っています';
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
      <h2>ログイン</h2>
      <?php
        echo $loginflag;
       ?>
       <br>
      <div class="register">
        <form action="login.php" method="post">
          <input type="text" name="name" placeholder="ニックネーム" value="" class="hoge"><br>
          <input type="text" name="password" placeholder="パスワード" value="" class="hoge"><br>
          <input type="submit" value="ログイン">
          <input type="hidden" name="flag" value="formsend">
        </form>
      </div>
    </div>
  </body>
</html>
