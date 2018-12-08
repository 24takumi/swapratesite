<?php
//DBへ接続
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn,$user,$password);
 ?>
<?php
//ユーザー関数を使う準備
session_start();
require "../logon.php";
 ?>
 <?php
 //テーブル名をsuremanagerより呼び出す。
 $url="http://tt-527.99sv-coco.com".$_SERVER['REQUEST_URI'];//このページのURLを出すグローバル変数
 //  SQL文 :nameは、名前付きプレースホルダ
 $sql='SELECT*FROM suremanager where url=:url';
 // プリペアドステートメントを作成
 $stmt=$pdo->prepare($sql);
 // プレースホルダと変数をバインド
 $stmt->bindParam(":url",$url);
 $stmt->execute(); //実行
 // データを取得
 $results = $stmt->fetch(PDO::FETCH_ASSOC);
 $table_name=$results[category]."_".$results[id];
 $title=$results[sure_name];

 //テーブルの作成
 $sql="CREATE TABLE ".$table_name
 ."("
 ."id INT,"//主キー
 ."name char(255),"//掲示板に表示する名前
 ."comment char(255),"//掲示板に表示するコメント
 ."timer char(255),"//現在の日付時刻
 ."username char(255)"//誰が書いたかわかるようにするため
 .");";
 $stmt=$pdo->query($sql);
  ?>
<!DOCTYPE html>
<html lang="ja" dir="ltr">
<!--dir="ltr"は左から右に読む言語との宣言-->
  <head>
    <meta charset="utf-8">
    <title><?php echo $title ?></title>
    <link rel="stylesheet" href="../stylesheet.css">
  </head>



   <?php
   //一時ファイルができているか（アップロードされているか）チェック
   if(is_uploaded_file($_FILES['up_file']['tmp_name'])){
     //テーブルの作成
     $sql="CREATE TABLE upload_file_manager"
     ."("
     ."id INT,"//主キー
     ."filename char(255),"//アップロードされたファイル名
     ."file_url char(255),"//ファイルのURL
     ."username char(255)"//誰がアップロードしたか
     .");";
     $stmt=$pdo->query($sql);

     $sql=$pdo->prepare("INSERT INTO upload_file_manager (id,filename,file_url,username) VALUES(:id,:filename,:file_url,:username)");//動作確認済み
     $sql->bindParam(':id',$id,PDO::PARAM_STR);
     $sql->bindParam(':filename',$filename,PDO::PARAM_STR);
     $sql->bindParam(':file_url',$file_url,PDO::PARAM_STR);
     $sql->bindParam(':username',$username,PDO::PARAM_STR);

     $id_max = intval($pdo->query("SELECT max(id) FROM upload_file_manager")->fetchColumn());//動作確認済み
     //echo $id_max;
     $id=$id_max+1;
     $filename=$_FILES['up_file']['name'];
     $file_ext=explode(".",$_FILES['up_file']['name']);
     $file_url="http://tt-527.99sv-coco.com/sure/uploadfiles/".$id.".".$file_ext[1];
     $username=username($_SESSION['bridgename']);
     $sql->execute();
     //一字ファイルを保存ファイルにコピーできたか
     if(move_uploaded_file($_FILES['up_file']['tmp_name'],"./uploadfiles/".$id.".".$file_ext[1])){
         //正常
         $msg= "アップロードしました";
     }else{
         //コピーに失敗（だいたい、ディレクトリがないか、パーミッションエラー）
         $msg= "error while saving.";
     }
   }

   //formから送信されたのをPOSTで受取、DBに書き込む
     if(!empty($_POST['comments']) || !empty($_POST['flag'])){
       $sql=$pdo->prepare("INSERT INTO $table_name (id,name,comment,timer,username) VALUES(:id,:name,:comment,:timer,:username)");//動作確認済み
       $sql->bindParam(':id',$id,PDO::PARAM_STR);
       $sql->bindParam(':name',$name,PDO::PARAM_STR);
       $sql->bindParam(':comment',$comment,PDO::PARAM_STR);
       $sql->bindParam(':timer',$timer,PDO::PARAM_STR);
       $sql->bindParam(':username',$username,PDO::PARAM_STR);

       $id_max = intval($pdo->query("SELECT max(id) FROM $table_name")->fetchColumn());//動作確認済み
       //echo $id_max;
       $id=$id_max+1;
       if(empty($_POST['anonymous'])){
         $name=username($_SESSION['bridgename']);
       }else{
         $name=$_POST['anonymous'];
       }
       if(!empty($_POST['flag'])){
         if($file_ext[1]=="jpg" || $file_ext[1]=="png" || $file_ext[1]=="JPG" || $file_ext[1]=="PNG" || $file_ext[1]=="gif" || $file_ext[1]=="GIF" || $file_ext[1]=="bpm"){
  	       $comment="<img src=\"".$file_url."\">";
  	     }elseif($file_ext[1]=="mp4"){
           //$comment="<video><source src=\"".$file_url."\"></video>";
           $comment="<video autoplay loop muted controls width=\"400px\">
              <source src=\"".$file_url."\" type=\"video/mp4\" />
              </video>";
  		   }else{
           $comment="<a href=\"".$file_url."\">".$file_url."</a>";
         }
       }else{
         $comment=$_POST['comments'];
       }
       $timer=date("Y/m/d H:i:s");
       $username=username($_SESSION['bridgename']);
       $sql->execute();
     }
    ?>
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
          echo username($_SESSION['bridgename']);
          ?>
          /<a href="http://tt-527.99sv-coco.com/logout.php">ログアウト</a>
        </div>
      </div>
      <h2 class="keiziban_title"><?php echo $title ?></h2>
      <br>
      <div class="hyouzi">
        <?php
        //表示機能
        $sql="SELECT*FROM $table_name";
        $results=$pdo->query($sql);
        foreach($results as $row){
          echo $row['id'].",";
          echo $row['name'].",";
          echo $row['timer'].'<br>';
          echo "&nbsp;&nbsp;&nbsp;";
          echo $row['comment'].'<br>';
        }
        ?>
      </div>
      <hr>
      <div class="write">
        <form method="post" action="<?php echo $url ?>">
          名前:<?php
          echo username($_SESSION['bridgename']);
          ?>
          <?php
          //↓のif動作確認済み
          if(username($_SESSION['bridgename']) != "ゲスト"){
            echo "<input type='checkbox' name='anonymous' value='名無しさん'>匿名";
          }
           ?><br>
      		<input type="text" name="comments" placeholder="コメント" value="" size="40"><br>
          <input type="submit" value="送信">
      		<input type="hidden" name="user" value="<?php
          echo username($_SESSION['bridgename']);
          ?>" size="40"><br>
      	</form>
        <br>
        <form method="post" action="<?php echo $url ?>" enctype="multipart/form-data">
        ファイル:<input type="file" name="up_file"><br>
        <input type="submit" value="upload">
        <input type="hidden" name="flag" value="1">
      </form><br>
        <?php
        echo $msg;
         ?>
      </div>
    </div>
  </body>
</html>
