<?php
// var_dump($_POST);
// exit();
// 
// $date = $_POST['date'];
// var_dump($date);
// exit();

// $memo = $_POST["memo"];
// var_dump($memo);
// exit();

// 未定義またはNULLではないかを確認するには isset() 
// 配列かどうか確認するには is_array()
// if文を使い、値を確認し、未定義でもNULLでもなく、配列だった場合に $date = $_POST['date']; として値を受け取ります
if (isset($_POST['date']) && is_array($_POST['date'])) {
    // $date = $_POST['date'];// 配列
    $date = implode("、", $_POST["date"]); // 文字列
    // var_dump($date);
    // exit();
}

$name = $_POST["name"]; // データ受け取り
// $date = $_POST["date"];// 上述済
$memo = $_POST["memo"];
// $write_data = "{$name} {implode(" | ",$date)} {$memo}\n"; // スペース区切りで最後に改行→文字化け
$write_data = "{$name} {$date} {$memo}\n"; // スペース区切りで最後に改行
// var_dump($write_data);// OK

$file = fopen('data/questionary.csv', 'a'); // ファイルを開く 引数はa
flock($file, LOCK_EX); // ファイルをロック
fwrite($file, $write_data); // データに書き込み，
flock($file, LOCK_UN); // ロック解除
fclose($file); // ファイルを閉じる
header("Location:questionary_read.php"); // ファイルを閉じる // 出力画面に移動
