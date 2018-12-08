<?php
//スワップ付与日数の合計を返すユーザー関数です。
function swapday($data){
//データベースへの接続(PDOオブジェクトの生成)
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn,$user,$password);

session_start();
  if (isset($data)){
    switch ($data) {
      case 'CADJPY':
        return $spsum=$pdo->query("SELECT sum(CADJPYsp) FROM YJFX")->fetchColumn();
        break;
      case 'AUDJPY':
        return $spsum=$pdo->query("SELECT sum(AUDJPYsp) FROM YJFX")->fetchColumn();
        break;
      case 'EURUSD':
        return $spsum=$pdo->query("SELECT sum(EURUSDsp) FROM YJFX")->fetchColumn();
        break;
      case 'NZDJPY':
        return $spsum=$pdo->query("SELECT sum(NZDJPYsp) FROM YJFX")->fetchColumn();
        break;
      case 'EURGBP':
        return $spsum=$pdo->query("SELECT sum(EURGBPsp) FROM YJFX")->fetchColumn();
        break;
      case 'GBPUSD':
        return $spsum=$pdo->query("SELECT sum(GBPUSDsp) FROM YJFX")->fetchColumn();
        break;
      case 'ZARJPY':
        return $spsum=$pdo->query("SELECT sum(ZARJPYsp) FROM YJFX")->fetchColumn();
        break;
      case 'EURCHF':
        return $spsum=$pdo->query("SELECT sum(EURCHFsp) FROM YJFX")->fetchColumn();
        break;
      case 'AUDUSD':
        return $spsum=$pdo->query("SELECT sum(AUDUSDsp) FROM YJFX")->fetchColumn();
        break;
      case 'USDCHF':
        return $spsum=$pdo->query("SELECT sum(USDCHFsp) FROM YJFX")->fetchColumn();
        break;
      case 'EURJPY':
        return $spsum=$pdo->query("SELECT sum(EURJPYsp) FROM YJFX")->fetchColumn();
        break;
      case 'GBPCHF':
        return $spsum=$pdo->query("SELECT sum(GBPCHFsp) FROM YJFX")->fetchColumn();
        break;
      case 'NZDUSD':
        return $spsum=$pdo->query("SELECT sum(NZDUSDsp) FROM YJFX")->fetchColumn();
        break;
      case 'USDJPY':
        return $spsum=$pdo->query("SELECT sum(USDJPYsp) FROM YJFX")->fetchColumn();
        break;
      case 'EURAUD':
        return $spsum=$pdo->query("SELECT sum(EURAUDsp) FROM YJFX")->fetchColumn();
        break;
      case 'AUDCHF':
        return $spsum=$pdo->query("SELECT sum(AUDCHFsp) FROM YJFX")->fetchColumn();
        break;
      case 'GBPJPY':
        return $spsum=$pdo->query("SELECT sum(GBPJPYsp) FROM YJFX")->fetchColumn();
        break;
      case 'CHFJPY':
        return $spsum=$pdo->query("SELECT sum(CHFJPYsp) FROM YJFX")->fetchColumn();
        break;
      default:
        return $spsum="error";
        break;
    }
  }else{
    return "error";
  }
}

 ?>
