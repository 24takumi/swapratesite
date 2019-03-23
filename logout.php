<?php
session_start();
session_destroy();
 ?>
<!DOCTYPE html>
<html lang="ja" dir="ltr">
<!--dir="ltr"は左から右に読む言語との宣言-->
  <head>
    <meta charset="utf-8">
    <title>ログアウト</title>
    <link rel="stylesheet" href="stylesheet.css">
  </head>
  <body>
    <div class="pagebody">
      <div class="header">
        <div class="header-logo">FXスワッパ―'s</div>
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
      <h2>ログアウトしました。</h2>
    </div>
  </body>
</html>
