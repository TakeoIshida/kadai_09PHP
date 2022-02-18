<?php

//最初にSESSIONを開始！！ココ大事！！
session_start();

//POST値を受け取る
$lid = $_POST['lid'];
$lpw = $_POST['lpw'];

//1.  DB接続します
require_once('funcs.php');
$pdo = db_conn();

//2. データ登録SQL作成
// gs_user_tableに、IDとWPがあるか確認する。
$stmt = $pdo->prepare('SELECT * FROM gs_user_table WHERE lid = :lid AND lpw=:lpw');
$stmt->bindValue(':lid', $lid, PDO::PARAM_STR);
$stmt->bindValue(':lpw', $lpw, PDO::PARAM_STR);
$status = $stmt->execute();

//3. SQL実行時にエラーがある場合STOP
if($status === false){
    sql_error($stmt);
}

//4. 抽出データ数を取得
$val = $stmt->fetch();

//if(password_verify($lpw, $val['lpw'])){ //* PasswordがHash化の場合はこっちのIFを使う
// if( $val['id'] != ''){
//     //Login成功時 該当レコードがあればSESSIONに値を代入
//     //成功したら＝つまりDBにlogin.phpで入力されたらパスワード、IDがあった場合この部分が実行される。
//     //サーバー側にデータを保持します=session_id;
//     //$val = DBから取得した値が入っているものになります
  
//     // $val = DBから取得した値が入っているものになります😀
//     $_SESSION['chk_ssid'] = session_id();
//     $_SESSION['kanri_flg'] = $val['kanri_flg'];
//     $_SESSION['name'] = $val['name'];
//     header('Location: kadaimap.php');
// }else{
//     //Login失敗時(Logout経由)
//     header('Location: login.php');
// } 
if($val['id'] != '' && $val['kanri_flg'] == 1){
    $_SESSION['chk_ssid'] = session_id();
    $_SESSION['kanri_flg'] = $val['kanri_flg'];
    $_SESSION['name'] = $val['name'];
    header('Location: kadaimap.php');
}elseif($val['id'] != '' && $val['kanri_flg'] == 0){
    $_SESSION['chk_ssid'] = session_id();
    $_SESSION['kanri_flg'] = $val['kanri_flg'];
    $_SESSION['name'] = $val['name'];
    header('Location: kadaimap2.php');

}
else{
    //Login失敗時(Logout経由)
    header('Location: login.php');
}




exit();
