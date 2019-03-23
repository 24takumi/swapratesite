<!DOCTYPE html>
<html lang="ja" dir="ltr">
<!--dir="ltr"は左から右に読む言語との宣言-->
  <head>
    <meta charset="utf-8">
    <title>cURL為替レート自動収集INSERT</title>
    <link rel="stylesheet" href="stylesheet.css">
  </head>
  <table border>
  <?php
  $dsn = 'データベース名';
  $user = 'ユーザー名';
  $password = 'パスワード';
  $pdo = new PDO($dsn,$user,$password);

    //テーブルの作成
    $sql="CREATE TABLE exchange"
    ."("
    ."date char(30),"//日時
    ."pair char(10),"//通貨ペア
    ."bid float,"//売り
    ."ask float"//買い
    .");";
    $stmt=$pdo->query($sql);

    $url = "https://www.gaitameonline.com/rateaj/getrate";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    $json = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($json, true);

    //print(var_dump($result));
    //print($result->{"currencyPairCode"});
    $i=1;
    for($j=0;$j<=23;$j++){
      $sql=$pdo->prepare("INSERT INTO exchange(date,pair,bid,ask) VALUES(:date,:pair,:bid,:ask)");
      $sql->bindParam(':date',$date,PDO::PARAM_STR);
      $sql->bindParam(':pair',$pair,PDO::PARAM_STR);
      $sql->bindParam(':bid',$bid,PDO::PARAM_STR);
      $sql->bindParam(':ask',$ask,PDO::PARAM_STR);

      $date=date("Y/m/d H:i:s");
      $pair=$result["quotes"][$j]["currencyPairCode"];
      $bid=$result["quotes"][$j]["bid"];
      $ask=$result["quotes"][$j]["ask"];
      $sql->execute();

      echo "<tr>";
      echo "<td>".$i."</td>";
      echo "<td>".$result["quotes"][$j]["currencyPairCode"]."</td>";
      echo "<td>".$result["quotes"][$j]["bid"]."</td>";
      echo "<td>".$result["quotes"][$j]["ask"]."</td>";
      echo "</tr>";
      $i=$i+1;
    }
  ?>
  </table>
</html>
