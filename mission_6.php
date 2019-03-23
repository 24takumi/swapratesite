<!DOCTYPE html>
<html lang="ja" dir="ltr">
<!--dir="ltr"は左から右に読む言語との宣言-->
  <head>
    <meta charset="utf-8">
    <title>ホーム</title>
    <link rel="stylesheet" href="stylesheet.css">
  </head>
  <body>
    <div class="pagebody">
      <div class="header">
        <div class="header-logo"><a href="http://tt-527.99sv-coco.com/mission_6.php">FXスワッパ―'s</a></div>
        <div class="header-list">
          <ul>
            <li id="menu01"><a href="http://tt-527.99sv-coco.com/bulletin_board.php">掲示板</a></li>
            <li id="menu02"><a href="http://tt-527.99sv-coco.com/swap_rate.php">スワップ金利比較</a></li>
            <li id="menu03"><a href="http://tt-527.99sv-coco.com/login.php">ログイン</a></li>
            <li id="menu04"><a href="http://tt-527.99sv-coco.com/register.php">ユーザー登録</a></li>
          </ul>
        </div>
        <div class="header-username">
          アカウント名:
          <?php
          session_start();
          require "logon.php";
          echo username($_SESSION['bridgename']);
          ?>
          /<a href="http://tt-527.99sv-coco.com/logout.php">ログアウト</a>
        </div>
      </div>
      <div class="copy-container">
        <h1>FXスワッパ―<span>'s</span></h1>
        <h2>各社のスワップ金利の自動収集＆掲示板サイトです</h2>
      </div>
    </div>
  </body>
</html>
