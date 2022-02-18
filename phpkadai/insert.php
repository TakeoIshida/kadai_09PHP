<?php
  
  $name = $_POST['name'];
  $address = $_POST['address'];
  $hyouka = $_POST['hyouka'];
  $kutikomi = $_POST['kutikomi'];

/**
 * 1. index.phpのフォームの部分がおかしいので、ここを書き換えて、
 * insert.phpにPOSTでデータが飛ぶようにしてください。
 * 2. insert.phpで値を受け取ってください。
 * 3. 受け取ったデータをバインド変数に与えてください。
 * 4. index.phpフォームに書き込み、送信を行ってみて、実際にPhpMyAdminを確認してみてください！
 */

//1. POSTデータ取得
// echo $name;
// echo $email;
// echo $content;

//2. DB接続します
// try {
//   //ID:'root', Password: 'root'
//   $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','root');
// } catch (PDOException $e) {
//   exit('DBConnectError:'.$e->getMessage());
// }
require_once('funcs.php');
$pdo = db_conn();
//３．データ登録SQL作成

// 1. SQL文を用意
$stmt = $pdo->prepare("INSERT INTO gs_shop_table(id, name, address, hyouka, kutikomi, indate)VALUES(NULL, :name, :address, :hyouka, :text, sysdate())");

//  2. バインド変数を用意
$stmt->bindValue(':name', $name, PDO:: PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':address', $address, PDO:: PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':hyouka', $hyouka, PDO:: PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':text', $kutikomi, PDO:: PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)

//  3. 実行
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("ErrorMessage:".$error[2]);
}else{
  //５．index.phpへリダイレクト
  header("Location: kadaimap2ver2.php");
  exit;

}
?>
