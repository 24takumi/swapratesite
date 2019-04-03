<!DOCTYPE html>
<html lang="ja" dir="ltr">
<!--dir="ltr"は左から右に読む言語との宣言-->
  <head>
    <meta charset="utf-8">
    <title>掲示板</title>
    <link rel="stylesheet" href="stylesheet.css">
  </head>
  <?php
  $dsn = 'データベース名';
  $user = 'ユーザー名';
  $password = 'パスワード';
  $pdo = new PDO($dsn,$user,$password);
   ?>
  <body>
    <div class="pagebody">
      <div class="header">
        <div class="header-logo"><a href="http://tt-527.99sv-coco.com/mission_6.php">FXスワッパ―'s</a></div>
        <div class="header-list">
          <ul>
            <li id="menu01"><a href="http://tt-527.99sv-coco.com/bulletin_board.php">掲示板</a></li>
            <li id="menu02"><a href="http://tt-527.99sv-coco.com/swap_rate.php">スワップ比較</a></li>
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
      <h3>掲示板の新規作成</h3>
      <div class="bulletin">
        <br>
        <form class="suremake" method="post" action="bulletin_board.php">
          <select name="category">
            カテゴリ名:
            <option value="USD_JPY">USD/JPY</option>
            <option value="EUR_USD">EUR/USD</option>
            <option value="EUR_JPY">EUR/JPY</option>
            <option value="extra">その他</option>
          </select>
      		<input type="text" name="sure_name" placeholder="新しい掲示板のタイトルを入力してください" size="40"><br>
      		<input type="submit" value="作成">
          <input type="hidden" name="flag" value="1">
      	</form>
        <?php
        //全部表示できた！
        //echo $_POST['category'];
        //echo $_POST['sure_name'];
        //userのidの呼び出し
        $name=$_SESSION['bridgename'];
        //echo $name;
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

        //テーブルの作成
        $sql="CREATE TABLE suremanager"
        ."("
        ."id INT,"
        ."category char(255),"
        ."sure_name char(255),"
        ."url char(255),"
        ."userid INT"
        .");";
        $stmt=$pdo->query($sql);

        //入力機能
        if(!empty($_POST['category'])){
          //echo "表示1";
          if(!empty($_POST['sure_name'])){
            //echo "表示2";
            if ($_POST['flag']==1) {
              $sql=$pdo->prepare("INSERT INTO suremanager(id,category,sure_name,url,userid) VALUES(:id,:category,:sure_name,:url,:userid)");
              $sql->bindParam(':id',$id,PDO::PARAM_STR);
              $sql->bindParam(':category',$category,PDO::PARAM_STR);
              $sql->bindParam(':sure_name',$sure_name,PDO::PARAM_STR);
              $sql->bindParam(':url',$url,PDO::PARAM_STR);
              $sql->bindParam(':userid',$userid,PDO::PARAM_STR);

              $id_max = intval($pdo->query("SELECT max(id) FROM suremanager")->fetchColumn());
              //echo $id_max;
              $id=$id_max+1;
              $category=$_POST['category'];
              $sure_name=$_POST['sure_name'];
              $url="http://tt-527.99sv-coco.com/"."sure"."/".$_POST['category']."_".$id.".php";
              $userid=$results['id'];
              $sql->execute();

              $sure_name=$_POST['category']."_".$id;
              //echo $sure_name;
              // ファイルをsureディレクトリにコピーする
              copy('bulletin_sample.php', 'sure/bulletin_sample.php');
              chmod('sure/bulletin_sample.php',0777);
              rename("sure/bulletin_sample.php", "sure/{$sure_name}.php");
            }
          }
        }
         ?>
      </div>
      <h3>掲示板一覧</h3>
      <div class="sureichiran">
        <?php
        $id_max = intval($pdo->query("SELECT max(id) FROM suremanager")->fetchColumn());
        for ($i=1; $i <=$id_max ; $i++) {
          //  SQL文 :nameは、名前付きプレースホルダ
          $sql='SELECT*FROM suremanager where id=:id';
          // プリペアドステートメントを作成
          $stmt=$pdo->prepare($sql);
          // プレースホルダと変数をバインド
          $stmt->bindParam(":id",$i);
          $stmt->execute(); //実行
          // データを取得
          $results = $stmt->fetch(PDO::FETCH_ASSOC);
          print '<a href="' . $results['url'] . '">' . $results['sure_name'] . '</a><br/>';
        }
         ?>
      </div>
    </div>
  </body>
</html>
