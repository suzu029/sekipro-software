<?php
//HTML文を出力 HTMLの開始
print("<HTML>\n");

//HTML文を出力 HEADの開始
print("<HEAD>\n");

//文字コードをUTF-8と指定
print("<META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=\"UTF-8\">\n");

print("<link rel=\"stylesheet\" type=\"text/css\" href=\"css/myphp4-1.css\">\n");

//HTML文を出力 TITLEの指定
print("<TITLE>myphp4-1</TITLE>\n");



//HTML文を出力 HEADの終了
print("</HEAD>\n");

//HTML文を出力 BODYの開始
print("<BODY>\n");

// myphp4.phpからPOSTされた record_id を受け取る
$record_id = filter_input(INPUT_POST, 'record_id', FILTER_VALIDATE_INT);

// IDが有効な数値かチェック
if ($record_id === false || $record_id === null) {
    print("エラー: 有効なレコードIDが指定されていません。<br>");
    print ("<br><a href=myphp4.php>削除画面に戻る</a><br>"); // 削除画面に戻るリンク
    print("</BODY>\n");
    print("</HTML>\n");
    exit(); // 処理を中断
}

//DBへ接続開始 サーバー名--localhost ユーザー名--root パスワード--root

$dbHandle = mysqli_connect("localhost","root","171641")
    or die("DB接続エラー: " . mysqli_connect_error());
mysqli_set_charset($dbHandle, "utf8");
mysqli_select_db($dbHandle,"student");


// (オプション: 削除前にどのレコードが削除されるか確認させるための表示)
$stmt_check = mysqli_prepare($dbHandle, "SELECT * FROM submission WHERE id = ?");
if ($stmt_check) {
    mysqli_stmt_bind_param($stmt_check, "i", $record_id);
    mysqli_stmt_execute($stmt_check);
    $rs_check = mysqli_stmt_get_result($stmt_check);
    $row_to_delete = mysqli_fetch_array($rs_check);
    mysqli_free_result($rs_check);
    mysqli_stmt_close($stmt_check);

    if ($row_to_delete) {
        print("以下のレコードを削除します。<br>");
        print("<TABLE border=1>");
        print("<tr><th>ID</th><th>学籍番号</th><th>名前</th><th>科目</th><th>提出状況</th></tr>");
        print("<tr>");
        print("<td>" . htmlspecialchars($row_to_delete['id']) . "</td>");
        print("<td>" . htmlspecialchars($row_to_delete['s_number']) . "</td>");
        print("<td>" . htmlspecialchars($row_to_delete['name']) . "</td>");
        print("<td>" . htmlspecialchars($row_to_delete['subject']) . "</td>");
        print("<td>" . htmlspecialchars($row_to_delete['sub']) . "</td>");
        print("</tr>");
        print("</TABLE><br>");
    } else {
        print("エラー: 削除対象のレコードID [" . htmlspecialchars($record_id) . "] は見つかりませんでした。<br>");
        mysqli_close($dbHandle);
        print ("<br><a href=myphp4.php>削除画面に戻る</a><br>");
        print("</BODY>\n");
        print("</HTML>\n");
        exit();
    }
} 


$stmt_delete = mysqli_prepare($dbHandle, "DELETE FROM submission WHERE id = ?");
if ($stmt_delete) {
    mysqli_stmt_bind_param($stmt_delete, "i", $record_id); // 'i' はidが整数
    if (mysqli_stmt_execute($stmt_delete)) {
        // 削除された行数を取得
        if (mysqli_stmt_affected_rows($stmt_delete) > 0) {
            print("ID [" . htmlspecialchars($record_id) . "] のレコードを**正常に削除しました。**<br>");
        } else {
            print("ID [" . htmlspecialchars($record_id) . "] のレコードは見つかりませんでした。（既に削除されている可能性があります）<br>");
        }
    } else {
        print("レコードの削除に失敗しました: " . htmlspecialchars(mysqli_error($dbHandle)) . "<br>");
    }
    mysqli_stmt_close($stmt_delete);
} 

//DBへの接続を切断
mysqli_close($dbHandle);

//HTML文を出力 削除画面に戻るリンク
print ("<br><a href=myphp4.php>削除画面に戻る</a><br>");

//HTML文を出力 BODYの終了
print("</BODY>\n");

//HTML文を出力 HTMLの終了
print("</HTML>\n");
?>
<br>
<a href="myphp.php">メニュー</a><br>