<!DOCTYPE html>
<html lang="ja" dir="ltr">
<!--dir="ltr"は左から右に読む言語との宣言-->
  <head>
    <meta charset="utf-8">
    <title>為替レート自動収集</title>
    <link rel="stylesheet" href="stylesheet.css">
  </head>
<?php
//データベースへの接続(PDOオブジェクトの生成)
$dsn = 'データベース名';
$user = 'tt-527.99sv-coco';
$password = 'パスワード';
$pdo = new PDO($dsn,$user,$password);

require_once("./phpQuery-onefile.php");
$html = file_get_contents("https://www.gaitameonline.com/rateaj/getrate");
$array = phpQuery::newDocument($html)->text();
$split=explode(',',$array);
$cnt=count($split);
$j=1;
$k=1;
$m=1;
for ($i=0; $i <$cnt ; $i++) {
  if(($i+4)%6 == 0){
    $split1=explode(':',$split[$i]);
    $split2=explode('"',$split1[1]);
    $bids[$j] = $split2[1];//bid
    $j=$j+1;
  }
  if (($i+3)%6 == 0) {
    $split1=explode(':',$split[$i]);
    $split2=explode('"',$split1[1]);
    $pairs[$k] = $split2[1];//pair
    $k=$k+1;
  }
  if(($i+2)%6 == 0){
    $split1=explode(':',$split[$i]);
    $split2=explode('"',$split1[1]);
    $asks[$m] = $split2[1];//ask
    $m=$m+1;
  }
}
for ($i=1; $i <=24 ; $i++) {
  $date=date("Y/m/d H:i:s");
  $pair=$pairs[$i];
  $bid=$bids[$i];
  $ask=$asks[$i];
  $sql="UPDATE exchange set date='$date',bid='$bid',ask='$ask' where pair='$pair'";
  $stmt=$pdo->prepare($sql);
  $stmt->bindParam(1, $date, PDO::PARAM_STR);
  $stmt->bindParam(2, $pair, PDO::PARAM_STR);
  $stmt->bindParam(3, $bid, PDO::PARAM_STR);
  $stmt->bindParam(4, $ask, PDO::PARAM_STR);
  $stmt->execute();
}
 ?>
</html>
