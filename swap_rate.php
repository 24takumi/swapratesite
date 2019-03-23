<?php
session_start();
 ?>
<!DOCTYPE html>
<html lang="ja" dir="ltr">
<!--dir="ltr"は左から右に読む言語との宣言-->
  <head>
    <meta charset="utf-8">
    <title>スワップポイント比較表</title>
    <link rel="stylesheet" href="stylesheet.css">
  </head>
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
      <div class="copy-container">
        <h1>スワップポイント比較表</h1>
        <div class="attention">
          <p>証拠金1万円で購入できる通貨量に対する1日当たりのスワップ金利が多い順にランキングにしました。</p>
          <p>※1通貨に満たない分は切り捨てです。レバレッジは1で計算しています。</p>
        </div>
        <table border>
          <tr>
          <td>ランキング</td>
          <td>通貨ペア</td>
          <td>売/買</td>
          <td>スワップポイント</td>
          <td>通貨量</td>
          <td>会社</td>
          </tr>
          <?php
          //データベースへの接続(PDOオブジェクトの生成)
          $dsn = 'mysql:dbname=n24xfree_user;host=mysql1.php.xdomain.ne.jp';
          $user = 'n24xfree_db';
          $password = '24datetkm';
          // データベースへの接続を表すPDOインスタンスを生成
          $pdo = new PDO($dsn,$user,$password);

          //表示機能
          $sql="SELECT*FROM swap_calculate WHERE swap_point!='0' ORDER BY swap_point DESC";
          $results=$pdo->query($sql);
          $i=1;
          foreach($results as $row){
            echo "<tr>";
            echo "<td>".$i."</td>";
            echo "<td>".$row['pairs']."</td>";
            echo "<td>".$row['Buy_Sell']."</td>";
            echo "<td>".$row['swap_point']."</td>";
            echo "<td>".$row['unit']."</td>";
            echo "<td>".$row['company']."</td>";
            echo "</tr>";
            $i=$i+1;
          }
          ?>
        </table>

      </div>
    </div>
  </body>
</html>
