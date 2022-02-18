<?php
//PHP:コード記述/修正の流れ
//1. insert.phpの処理をマルっとコピー。
//   POSTデータ受信 → DB接続 → SQL実行 → 前ページへ戻る
//2. $id = POST["id"]を追加
//3. SQL修正
//   "UPDATE テーブル名 SET 変更したいカラムを並べる WHERE 条件"
//   bindValueにも「id」の項目を追加
//4. header関数"Location"を「select.php」に変更


//1. POSTデータ取得
$name = $_POST['name'];
$address = $_POST['address'];
$hyouka = $_POST['hyouka'];
$kutikomi = $_POST['kutikomi'];
$id = $_POST["id"]; //detail.phpのhiddenで送られたid



//2. DB接続します
//*** function化する！  *****************
// try {
//     $db_name = 'gs_db3';    //データベース名
//     $db_id   = 'root';      //アカウント名
//     $db_pw   = 'root';      //パスワード：XAMPPはパスワード無しに修正してください。
//     $db_host = 'localhost'; //DBホスト
//     $pdo = new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host, $db_id, $db_pw);
// } catch (PDOException $e) {
//     exit('DB Connection Error:' . $e->getMessage());
// }
// function.phpに記述したものを書きますよ。
// これが最初に書く、呼び出したい時

require_once('funcs.php');
$pdo = db_conn();



//３．データ登録SQL作成
//３．データ更新SQL作成
// $stmt = $pdo->prepare("INSERT INTO gs_an_table(name,email,age,content,indate)VALUES(:name,:email,:age,:content,sysdate())");
// $stmt = $pdo->prepare("INSERT INTO gs_shop_table(id, name, address, hyouka, kutikomi, indate)VALUES(NULL, :name, :address, :hyouka, :text, sysdate())");
$stmt = $pdo->prepare( 'UPDATE gs_shop_table SET name = :name, address = :address, hyouka = :hyouka, kutikomi = :text, indate = sysdate() WHERE id = :id;' );


// 数値の場合 PDO::PARAM_INT
// 文字の場合 PDO::PARAM_STR
$stmt->bindValue(':name', $name, PDO:: PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':address', $address, PDO:: PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':hyouka', $hyouka, PDO:: PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':text', $kutikomi, PDO:: PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)

// hiddenで受け取ったidをbindValueを用いて「安全かチェック」をする＝SQLインジェクション対策
$stmt->bindValue(':id', $id, PDO::PARAM_STR);
$status = $stmt->execute(); //実行

//４．データ登録処理後
if ($status === false) {
    sql_error($stmt);
} else {
    redirect('select.php');
};
