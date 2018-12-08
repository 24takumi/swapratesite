  <?php
  //スワップ金利の合計を返すユーザー関数です
  function swap($data){
  //データベースへの接続(PDOオブジェクトの生成)
  $dsn = 'データベース名';
  $user = 'ユーザー名';
  $password = 'パスワード';
  $pdo = new PDO($dsn,$user,$password);

  session_start();
    if (isset($data)){
      switch ($data) {
        case 'CADJPYbuy':
          return $spsum=$pdo->query("SELECT sum(CADJPYbuy) FROM YJFX")->fetchColumn();
          break;
        case 'AUDJPYbuy':
          return $spsum=$pdo->query("SELECT sum(AUDJPYbuy) FROM YJFX")->fetchColumn();
          break;
        case 'EURUSDbuy':
          return $spsum=$pdo->query("SELECT sum(EURUSDbuy) FROM YJFX")->fetchColumn();
          break;
        case 'NZDJPYbuy':
          return $spsum=$pdo->query("SELECT sum(NZDJPYbuy) FROM YJFX")->fetchColumn();
          break;
        case 'EURGBPbuy':
          return $spsum=$pdo->query("SELECT sum(EURGBPbuy) FROM YJFX")->fetchColumn();
          break;
        case 'GBPUSDbuy':
          return $spsum=$pdo->query("SELECT sum(GBPUSDbuy) FROM YJFX")->fetchColumn();
          break;
        case 'ZARJPYbuy':
          return $spsum=$pdo->query("SELECT sum(ZARJPYbuy) FROM YJFX")->fetchColumn();
          break;
        case 'EURCHFbuy':
          return $spsum=$pdo->query("SELECT sum(EURCHFbuy) FROM YJFX")->fetchColumn();
          break;
        case 'AUDUSDbuy':
          return $spsum=$pdo->query("SELECT sum(AUDUSDbuy) FROM YJFX")->fetchColumn();
          break;
        case 'USDCHFbuy':
          return $spsum=$pdo->query("SELECT sum(USDCHFbuy) FROM YJFX")->fetchColumn();
          break;
        case 'EURJPYbuy':
          return $spsum=$pdo->query("SELECT sum(EURJPYbuy) FROM YJFX")->fetchColumn();
          break;
        case 'GBPCHFbuy':
          return $spsum=$pdo->query("SELECT sum(GBPCHFbuy) FROM YJFX")->fetchColumn();
          break;
        case 'NZDUSDbuy':
          return $spsum=$pdo->query("SELECT sum(NZDUSDbuy) FROM YJFX")->fetchColumn();
          break;
        case 'USDJPYbuy':
          return $spsum=$pdo->query("SELECT sum(USDJPYbuy) FROM YJFX")->fetchColumn();
          break;
        case 'EURAUDbuy':
          return $spsum=$pdo->query("SELECT sum(EURAUDbuy) FROM YJFX")->fetchColumn();
          break;
        case 'AUDCHFbuy':
          return $spsum=$pdo->query("SELECT sum(AUDCHFbuy) FROM YJFX")->fetchColumn();
          break;
        case 'GBPJPYbuy':
          return $spsum=$pdo->query("SELECT sum(GBPJPYbuy) FROM YJFX")->fetchColumn();
          break;
        case 'CHFJPYbuy':
          return $spsum=$pdo->query("SELECT sum(CHFJPYbuy) FROM YJFX")->fetchColumn();
          break;
        case 'CADJPYsell':
          return $spsum=$pdo->query("SELECT sum(CADJPYsell) FROM YJFX")->fetchColumn();
          break;
        case 'AUDJPYsell':
          return $spsum=$pdo->query("SELECT sum(AUDJPYsell) FROM YJFX")->fetchColumn();
          break;
        case 'EURUSDsell':
          return $spsum=$pdo->query("SELECT sum(EURUSDsell) FROM YJFX")->fetchColumn();
          break;
        case 'NZDJPYsell':
          return $spsum=$pdo->query("SELECT sum(NZDJPYsell) FROM YJFX")->fetchColumn();
          break;
        case 'EURGBPsell':
          return $spsum=$pdo->query("SELECT sum(EURGBPsell) FROM YJFX")->fetchColumn();
          break;
        case 'GBPUSDsell':
          return $spsum=$pdo->query("SELECT sum(GBPUSDsell) FROM YJFX")->fetchColumn();
          break;
        case 'ZARJPYsell':
          return $spsum=$pdo->query("SELECT sum(ZARJPYsell) FROM YJFX")->fetchColumn();
          break;
        case 'EURCHFsell':
          return $spsum=$pdo->query("SELECT sum(EURCHFsell) FROM YJFX")->fetchColumn();
          break;
        case 'AUDUSDsell':
          return $spsum=$pdo->query("SELECT sum(AUDUSDsell) FROM YJFX")->fetchColumn();
          break;
        case 'USDCHFsell':
          return $spsum=$pdo->query("SELECT sum(USDCHFsell) FROM YJFX")->fetchColumn();
          break;
        case 'EURJPYsell':
          return $spsum=$pdo->query("SELECT sum(EURJPYsell) FROM YJFX")->fetchColumn();
          break;
        case 'GBPCHFsell':
          return $spsum=$pdo->query("SELECT sum(GBPCHFsell) FROM YJFX")->fetchColumn();
          break;
        case 'NZDUSDsell':
          return $spsum=$pdo->query("SELECT sum(NZDUSDsell) FROM YJFX")->fetchColumn();
          break;
        case 'USDJPYsell':
          return $spsum=$pdo->query("SELECT sum(USDJPYsell) FROM YJFX")->fetchColumn();
          break;
        case 'EURAUDsell':
          return $spsum=$pdo->query("SELECT sum(EURAUDsell) FROM YJFX")->fetchColumn();
          break;
        case 'AUDCHFsell':
          return $spsum=$pdo->query("SELECT sum(AUDCHFsell) FROM YJFX")->fetchColumn();
          break;
        case 'GBPJPYsell':
          return $spsum=$pdo->query("SELECT sum(GBPJPYsell) FROM YJFX")->fetchColumn();
          break;
        case 'CHFJPYsell':
          return $spsum=$pdo->query("SELECT sum(CHFJPYsell) FROM YJFX")->fetchColumn();
          break;

        default:
          return $spsum="error";
          break;
      }
    }else{
      return $spsum="error";
    }
  }

   ?>
