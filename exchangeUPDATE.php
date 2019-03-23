<!DOCTYPE html>
<html lang="ja" dir="ltr">
<!--dir="ltr"は左から右に読む言語との宣言-->
  <head>
    <meta charset="utf-8">
    <title>為替レート自動収集</title>
    <link rel="stylesheet" href="stylesheet.css">
  </head>
<?php
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn,$user,$password);

$url = "https://www.gaitameonline.com/rateaj/getrate";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 60);
$json = curl_exec($ch);
curl_close($ch);

$result = json_decode($json, true);

for($j=0;$j<=23;$j++){
  $date=date("Y/m/d H:i:s");
  $pair=$result["quotes"][$j]["currencyPairCode"];
  $bid=$result["quotes"][$j]["bid"];
  $ask=$result["quotes"][$j]["ask"];
  $sql="UPDATE exchange set date='$date',bid='$bid',ask='$ask' where pair='$pair'";
  $stmt=$pdo->prepare($sql);
  $stmt->bindParam(1, $date, PDO::PARAM_STR);
  $stmt->bindParam(2, $pair, PDO::PARAM_STR);
  $stmt->bindParam(3, $bid, PDO::PARAM_STR);
  $stmt->bindParam(4, $ask, PDO::PARAM_STR);
  //$result=$pdo->query($sql);
  $stmt->execute();
}
 ?>
</html>
