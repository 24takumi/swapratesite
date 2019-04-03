<!DOCTYPE html>
<html lang="ja" dir="ltr">
<!--dir="ltr"は左から右に読む言語との宣言-->
  <head>
    <meta charset="utf-8">
  </head>
  <?php
  $dsn = 'データベース名';
  $user = 'ユーザー名';
  $password = 'パスワード';
  $pdo = new PDO($dsn,$user,$password);


  //テーブルYJFX1の作成
  $sql="CREATE TABLE YJFX"
  ."("
  ."id int,"//主キー
  ."created_at char(255),"
  ."updated_at char(255),"
  ."year char(255),"
  ."month char(255),"
  ."day int,"
  ."USDJPYsp TINYINT,"
  ."USDJPYbuy SMALLINT,"
  ."USDJPYsell SMALLINT,"
  ."EURJPYsp TINYINT,"
  ."EURJPYbuy SMALLINT,"
  ."EURJPYsell SMALLINT,"
  ."EURUSDsp TINYINT,"
  ."EURUSDbuy SMALLINT,"
  ."EURUSDsell SMALLINT,"
  ."AUDJPYsp TINYINT,"
  ."AUDJPYbuy SMALLINT,"
  ."AUDJPYsell SMALLINT,"
  ."NZDJPYsp TINYINT,"
  ."NZDJPYbuy SMALLINT,"
  ."NZDJPYsell SMALLINT,"
  ."GBPJPYsp TINYINT,"
  ."GBPJPYbuy SMALLINT,"
  ."GBPJPYsell SMALLINT,"
  ."CHFJPYsp TINYINT,"
  ."CHFJPYbuy SMALLINT,"
  ."CHFJPYsell SMALLINT,"
  ."CADJPYsp TINYINT,"
  ."CADJPYbuy SMALLINT,"
  ."CADJPYsell SMALLINT,"
  ."GBPUSDsp TINYINT,"
  ."GBPUSDbuy SMALLINT,"
  ."GBPUSDsell SMALLINT,"
  ."ZARJPYsp TINYINT,"
  ."ZARJPYbuy SMALLINT,"
  ."ZARJPYsell SMALLINT,"
  ."AUDUSDsp TINYINT,"
  ."AUDUSDbuy SMALLINT,"
  ."AUDUSDsell SMALLINT,"
  ."NZDUSDsp TINYINT,"
  ."NZDUSDbuy SMALLINT,"
  ."NZDUSDsell SMALLINT,"
  ."CNHJPYsp TINYINT,"
  ."CNHJPYbuy SMALLINT,"
  ."CNHJPYsell SMALLINT,"
  ."HKDJPYsp TINYINT,"
  ."HKDJPYbuy SMALLINT,"
  ."HKDJPYsell SMALLINT,"
  ."EURGBPsp TINYINT,"
  ."EURGBPbuy SMALLINT,"
  ."EURGBPsell SMALLINT,"
  ."EURAUDsp TINYINT,"
  ."EURAUDbuy SMALLINT,"
  ."EURAUDsell SMALLINT,"
  ."USDCHFsp TINYINT,"
  ."USDCHFbuy SMALLINT,"
  ."USDCHFsell SMALLINT,"
  ."EURCHFsp TINYINT,"
  ."EURCHFbuy SMALLINT,"
  ."EURCHFsell SMALLINT,"
  ."GBPCHFsp TINYINT,"
  ."GBPCHFbuy SMALLINT,"
  ."GBPCHFsell SMALLINT,"
  ."AUDCHFsp TINYINT,"
  ."AUDCHFbuy SMALLINT,"
  ."AUDCHFsell SMALLINT,"
  ."CADCHFsp TINYINT,"
  ."CADCHFbuy SMALLINT,"
  ."CADCHFsell SMALLINT,"
  ."USDHKDsp TINYINT,"
  ."USDHKDbuy SMALLINT,"
  ."USDHKDsell SMALLINT"
  .");";
  $stmt=$pdo->query($sql);

   ?>
  <?php
  //毎月のテーブルを新規で自動作成する
  //今月の最後の日を求める
  $d = new DateTime();
  $d->setDate($d->format('Y'), $d->format('m'), 1);
  $d->modify('+1 month -1 day');
  $end_day=$d->format('d');//今月の最後を返す
  $current_month=$d->format('m');
  $monthmax = intval($pdo->query("SELECT max(month) FROM YJFX")->fetchColumn());
  $daymax = intval($pdo->query("SELECT max(day) FROM YJFX where month='" . $monthmax . "' ")->fetchColumn());

  $current_month_nonzero=$d->format('n');

  $day_max_i= intval($pdo->query("SELECT max(day) FROM YJFX where month='" . $current_month . "' ")->fetchColumn());

  if($monthmax<$current_month_nonzero){
    for ($i=1; $i <=$end_day ; $i++) {//今月の最後まで日付などを振る
      $sql=$pdo->prepare("INSERT INTO YJFX (id,created_at,updated_at,year,month,day) VALUES(:id,:created_at,:updated_at,:year,:month,:day)");
      $sql->bindParam(':id',$id,PDO::PARAM_STR);
      $sql->bindParam(':created_at',$created_at,PDO::PARAM_STR);
      $sql->bindParam(':updated_at',$updated_at,PDO::PARAM_STR);
      $sql->bindParam(':year',$year,PDO::PARAM_STR);
      $sql->bindParam(':month',$month,PDO::PARAM_STR);
      $sql->bindParam(':day',$day,PDO::PARAM_STR);

      $id_max = intval($pdo->query("SELECT max(id) FROM YJFX")->fetchColumn());
      $id=$id_max+1;
      $created_at=date("Y/m/d H:i:s");
      $updated_at=date("Y/m/d H:i:s");

      $year=$d->format('Y');
      $month=$d->format('m');
      $day_max = intval($pdo->query("SELECT max(day) FROM YJFX where month='" . $current_month . "' ")->fetchColumn());
      $day=$day_max+1;

      $sql->execute();
    }
  }
   ?>

  <?php //今日の日付
  $current_date=date("d");

   ?>

  <?php
  require_once("./phpQuery-onefile.php");

  $url = "https://www.yjfx.jp/gaikaex/mark/swap/calendar.php";
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_HEADER, false);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_TIMEOUT, 60);
  $html = curl_exec($ch);
  curl_close($ch);

  $array = phpQuery::newDocument($html)->find(".tbl_list")->text();
  // 正規表現
  $pattern = "#\n|\r\n|\r#";
  // 改行コードをマッチング。空文字と置換して出力
  $str = preg_replace( $pattern, '', $array );
  //日(月)などを半角スペースに
  $str = preg_replace("/\(.+?\)/", '', $str);//(文字列など)を全て空文字に置換
  $str = preg_replace("(日)", '', $str);//日を空文字に置き換え
  //連続する空白を一つの空白にする
  $str = preg_replace('/\s(?=\s)/', '', $str);
  //取引日で分割→11月で分割→" "で分割
  //分割した配列をさらに1から順に再配列
  $m=0;
  $split1=explode("取引",$str);
  $cnt1=count($split1);

  for ($i=1; $i <$cnt1 ; $i++) {//$iを1から始めることで最初の空白の配列をループしない
    $split2=explode($current_month_nonzero."月",$split1[$i]);
    $cnt2=count($split2);

    for ($j=1; $j <$cnt2 ; $j++) {//$jを1から始めることで列名の配列をループしない
      $split3=explode(' ',$split2[$j]);

      if($j>=1){
        if ($i==1) {
          $sp1=USDJPYsp;
          $buy1=USDJPYbuy;
          $sell1=USDJPYsell;
          $sp2=EURJPYsp;
          $buy2=EURJPYbuy;
          $sell2=EURJPYsell;
          $sp3=EURUSDsp;
          $buy3=EURUSDbuy;
          $sell3=EURUSDsell;
          $sp4=AUDJPYsp;
          $buy4=AUDJPYbuy;
          $sell4=AUDJPYsell;
        }elseif($i==2){
          $sp1=NZDJPYsp;
          $buy1=NZDJPYbuy;
          $sell1=NZDJPYsell;
          $sp2=GBPJPYsp;
          $buy2=GBPJPYbuy;
          $sell2=GBPJPYsell;
          $sp3=CHFJPYsp;
          $buy3=CHFJPYbuy;
          $sell3=CHFJPYsell;
          $sp4=CADJPYsp;
          $buy4=CADJPYbuy;
          $sell4=CADJPYsell;
        }elseif($i==3){
          $sp1=GBPUSDsp;
          $buy1=GBPUSDbuy;
          $sell1=GBPUSDsell;
          $sp2=ZARJPYsp;
          $buy2=ZARJPYbuy;
          $sell2=ZARJPYsell;
          $sp3=AUDUSDsp;
          $buy3=AUDUSDbuy;
          $sell3=AUDUSDsell;
          $sp4=NZDUSDsp;
          $buy4=NZDUSDbuy;
          $sell4=NZDUSDsell;
        }elseif($i==4){
          $sp1=CNHJPYsp;
          $buy1=CNHJPYbuy;
          $sell1=CNHJPYsell;
          $sp2=HKDJPYsp;
          $buy2=HKDJPYbuy;
          $sell2=HKDJPYsell;
          $sp3=EURGBPsp;
          $buy3=EURGBPbuy;
          $sell3=EURGBPsell;
          $sp4=EURAUDsp;
          $buy4=EURAUDbuy;
          $sell4=EURAUDsell;
        }elseif($i==5){
          $sp1=USDCHFsp;
          $buy1=USDCHFbuy;
          $sell1=USDCHFsell;
          $sp2=EURCHFsp;
          $buy2=EURCHFbuy;
          $sell2=EURCHFsell;
          $sp3=GBPCHFsp;
          $buy3=GBPCHFbuy;
          $sell3=GBPCHFsell;
          $sp4=AUDCHFsp;
          $buy4=AUDCHFbuy;
          $sell4=AUDCHFsell;
        }elseif($i==6){
          $sp1=CADCHFsp;
          $buy1=CADCHFbuy;
          $sell1=CADCHFsell;
          $sp2=USDHKDsp;
          $buy2=USDHKDbuy;
          $sell2=USDHKDsell;
        }
      }

      if($split3[0]<=$current_date){
        $p_day=$split3[0];
        $flag = intval($pdo->query("SELECT day FROM YJFX WHERE month='" . $current_month . "' AND day='" . $p_day . "' ")->fetchColumn());
        if($flag==""){
          if($i>=1 && $i<=5){
            $updated_at=date("Y/m/d H:i:s");
            $days=$split3[0];
            $sp1s=$split3[1];
            $buy1s=$split3[2];
            $sell1s=$split3[3];
            $sp2s=$split3[4];
            $buy2s=$split3[5];
            $sell2s=$split3[6];
            $sp3s=$split3[7];
            $buy3s=$split3[8];
            $sell3s=$split3[9];
            $sp4s=$split3[10];
            $buy4s=$split3[11];
            $sell4s=$split3[12];
            $sql="UPDATE YJFX set updated_at='$updated_at',{$sp1}='$sp1s',{$buy1}='$buy1s',{$sell1}='$sell1s',{$sp2}='$sp2s',{$buy2}='$buy2s',{$sell2}='$sell2s',{$sp3}='$sp3s',{$buy3}='$buy3s',{$sell3}='$sell3s',{$sp4}='$sp4s',{$buy4}='$buy4s',{$sell4}='$sell4s' WHERE day='$days' and month='$current_month'";
            $stmt=$pdo->prepare($sql);
            $stmt->execute();
          }
          if($i==6){
            $updated_at=date("Y/m/d H:i:s");
            $days=$split3[0];
            $sp1s=$split3[1];
            $buy1s=$split3[2];
            $sell1s=$split3[3];
            $sp2s=$split3[4];
            $buy2s=$split3[5];
            $sell2s=$split3[6];
            $sql="UPDATE YJFX set updated_at='$updated_at',{$sp1}='$sp1s',{$buy1}='$buy1s',{$sell1}='$sell1s',{$sp2}='$sp2s',{$buy2}='$buy2s',{$sell2}='$sell2s' WHERE day='$days' and month='$current_month'";
            $stmt=$pdo->prepare($sql);
            $stmt->execute();
          }
        }
      }
    }
  }
  ?>
</html>
