<!DOCTYPE html>
<html lang="ja" dir="ltr">
<!--dir="ltr"は左から右に読む言語との宣言-->
  <head>
    <meta charset="utf-8">
  </head>
  <?php
  //DBへ接続
  $dsn = 'データベース名';
  $user = 'ユーザー名';
  $password = 'パスワード';
  $pdo = new PDO($dsn,$user,$password);
  //テーブルYJFX1の作成
  $sql="CREATE TABLE swap_calculate"
  ."("
  ."id int,"//主キー
  ."created_at char(255),"//作成した日付
  ."updated_at char(255),"//更新した日付
  ."pairs char(10),"//通貨ペア
  ."Buy_Sell char(10),"//売りか買いか
  ."spread float,"//為替スプレッド
  ."payday float,"//為替差損をペイするまでの日数
  ."unit int,"//購入通貨量
  ."company char(30),"//会社名
  ."swap_point float"//スワップポイント
  .");";
  $stmt=$pdo->query($sql);

  ?>

  <?php
  //取得した為替レートのペアを配列に格納
  $pair = array('','GBPNZD','CADJPY','GBPAUD','AUDJPY','AUDNZD','EURCAD','EURUSD','NZDJPY','USDCAD','EURGBP','GBPUSD','ZARJPY','EURCHF','CHFJPY','AUDUSD','USDCHF','EURJPY','GBPCHF','EURNZD','NZDUSD','USDJPY','EURAUD','AUDCHF','GBPJPY');
   ?>
  <?php
  //最初にテーブルの枠組みのみ作成
  $id_max = intval($pdo->query("SELECT max(id) FROM swap_calculate")->fetchColumn());
  if($id_max<48){//取得した為替レートが24通貨ペアで売り買いの2パターンがあるため
    for ($i=1; $i <=24 ; $i++) {
      for ($k=1; $k <=2 ; $k++) {
        $sql=$pdo->prepare("INSERT INTO swap_calculate (id,created_at,updated_at,pairs,Buy_Sell) VALUES(:id,:created_at,:updated_at,:pairs,:Buy_Sell)");
        $sql->bindParam(':id',$id,PDO::PARAM_STR);
        $sql->bindParam(':created_at',$created_at,PDO::PARAM_STR);
        $sql->bindParam(':updated_at',$updated_at,PDO::PARAM_STR);
        $sql->bindParam(':pairs',$pairs,PDO::PARAM_STR);
        $sql->bindParam(':Buy_Sell',$Buy_Sell,PDO::PARAM_STR);

        $id_max = intval($pdo->query("SELECT max(id) FROM swap_calculate")->fetchColumn());
        $id=$id_max+1;
        $created_at=date("Y/m/d H:i:s");
        $updated_at=date("Y/m/d H:i:s");
        $pairs=$pair[$i];
        if($k==1){
          $Buy_Sell="buy";
        }else{
          $Buy_Sell="sell";
        }
        $sql->execute();
      }
    }
  }
   ?>

   <?php
   //スワップ金利は一つの通貨ペアに対して買いスワップと売りスワップがあるため二重ループで処理します。
   for ($i=1; $i <=24 ; $i++) {
     for ($k=1; $k <=2 ; $k++) {
       $updated_at=date("Y/m/d H:i:s");
       $pairs=$pair[$i];
       //為替の売値と買値からスプレッドを計算します。
       $bid=$pdo->query("SELECT bid FROM exchange WHERE pair='$pair[$i]'")->fetchColumn();
       $ask=$pdo->query("SELECT ask FROM exchange WHERE pair='$pair[$i]'")->fetchColumn();
       $spread=$ask-$bid;
       //カラム名を変数として用意します。例）EURUSDsp,EURUSDbuy,EURUSDsellなど
       //内側のループが1回目の時は買いスワップの処理、2回目の時は売りスワップの処理を行います。
       if($k==1){
         $Buy_Sell="buy";
         $currency=substr($pair[$i],0,3);
       }else{
         $Buy_Sell="sell";
         $currency=substr($pair[$i],3,3);
         $JPY_currency=substr($pair[$i],0,3);
       }
       //対円の通貨ペアの場合の修正
       if($currency=="JPY"){
         $currency=$JPY_currency;
       }
       $currencys=$currency."JPY";
       //保有通貨の対円レートを取得し1万円で何通貨保有できるか計算します。
       $rate=$pdo->query("SELECT ask FROM exchange WHERE pair='$currencys'")->fetchColumn();
       $unit=floor(10000/$rate);

       //ユーザー定義関数を使用し、スワップ金利の合計とスワップ付与日数の合計を出します。
       $company="YJFX";//現在は1社しかないため直接入力
       $swap_column=$pair[$i].$Buy_Sell;//対象通貨のスワップポイントのカラム名
       session_start();
       require_once "swap_function.php";
       $spsum=swap($swap_column);
       require_once "swap_day.php";
       $spday=swapday($pair[$i]);

       //通貨ペアが存在しない場合は、ユーザー関数はerrorを返すのでその処理を行います。
       if($spsum=="error"){
         $swap_point=0;
         $payday=0;
       }else{
         $sp=$spsum/$spday/10000;//平均スワップポイントを計算します
         $swap_point=$unit*$sp;//1単位当たりのスワップポイント*保有数=証拠金1万円当たりの1日に受け取れるスワップポイント
         $payday=ceil($spread/$swap_point);//スワップポイントでスプレッドを何日でペイできるか
       }
       $sql="UPDATE swap_calculate set updated_at='$updated_at',spread='$spread',payday='$payday',unit='$unit',company='$company',swap_point='$swap_point' WHERE pairs='$pairs' AND Buy_Sell='$Buy_Sell'";
       $stmt=$pdo->prepare($sql);
       $stmt->execute();
     }
   }
    ?>
</html>
