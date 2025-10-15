<?php
//HTML文を出力 HTMLの開始
print("<HTML>\n");
print("<HEAD>\n");
print("<META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=\"UTF-8\">\n");
print("<TITLE>myphp5-1</TITLE>\n");
print("</HEAD>\n");
print("<BODY>\n");


$dbHost = "localhost";
$dbUser = "root";
$dbPass = "171641"; 
$dbName = "student";

$dbHandle = mysqli_connect($dbHost, $dbUser, $dbPass)
    or die("DB接続エラー: " . mysqli_connect_error());
mysqli_set_charset($dbHandle, "utf8");
mysqli_select_db($dbHandle, $dbName);

// フォームが送信されたかどうかをチェック（更新処理か、初期表示か）
// 「更新」ボタンが押された場合（新しい値がPOSTされている場合）
if (isset($_POST['update_submit'])) {
    // フォームから送信された新しい値とレコードIDを受け取る
    $record_id = filter_input(INPUT_POST, 'record_id', FILTER_VALIDATE_INT);
    $s_number = filter_input(INPUT_POST, 's_number'); // 編集フォームからの値
    $name = filter_input(INPUT_POST, 'name');         // 編集フォームからの値
    $subject = filter_input(INPUT_POST, 'subject');   // 編集フォームからの値
    $sub = filter_input(INPUT_POST, 'sub');           // 編集フォームからの値

    if ($record_id === false || $record_id === null) {
        print("エラー: 不正なレコードIDです。<br>");
    } else {
        // ★★★ 更新処理を実行 ★★★
        $stmt_update = mysqli_prepare($dbHandle, "UPDATE submission SET s_number=?, name=?, subject=?, sub=? WHERE id=?");
        if ($stmt_update) {
            mysqli_stmt_bind_param($stmt_update, "ssssi", $s_number, $name, $subject, $sub, $record_id); // 'ssssi' は各変数の型
            if (mysqli_stmt_execute($stmt_update)) {
                print("<b>データを更新しました。</b><br><br>");
            } else {
                print("データの更新に失敗しました: " . htmlspecialchars(mysqli_error($dbHandle)) . "<br>");
            }
            mysqli_stmt_close($stmt_update);
        } else {
            print("SQLステートメントの準備に失敗しました: " . htmlspecialchars(mysqli_error($dbHandle)) . "<br>");
        }
    }

    // 更新後のデータを再度取得して表示（確認用）
    $display_id = $record_id; // 更新したIDのデータを表示
    
} else {
    // 初めてmyphp5-1.phpにアクセスした場合（myphp5.phpから「変更」ボタンで来た場合）
    $display_id = filter_input(INPUT_POST, 'record_id', FILTER_VALIDATE_INT);
    if ($display_id === false || $display_id === null) {
        print("エラー: 有効なレコードIDが指定されていません。<br>");
        mysqli_close($dbHandle);
        print ("<br><a href=myphp5.php>戻る</a><br>");
        print("</BODY>\n");
        print("</HTML>\n");
        exit();
    }
}


$stmt_select = mysqli_prepare($dbHandle, "SELECT * FROM submission WHERE id = ?");
if ($stmt_select) {
    mysqli_stmt_bind_param($stmt_select, "i", $display_id);
    mysqli_stmt_execute($stmt_select);
    $rs = mysqli_stmt_get_result($stmt_select);
    $row = mysqli_fetch_array($rs);

    if ($row) {
        print("<b>登録内容変更</b><br><br>");
        print("変更したい項目を入力後、変更ボタンを押してください。<br>");
        
        // 編集フォームの開始
        print("<FORM action='myphp5-1.php' method='post'>");
        print("<TABLE border=1>");
        print("<tr><th>列名</th><th>変更前</th><th>変更後</th></tr>");

        // 列情報を取得
        $finfo_array = mysqli_fetch_fields($rs);

        foreach ($finfo_array as $index => $finfo) {
            print("<tr><td><b>" . htmlspecialchars($finfo->name) . "</b></td><td>" . htmlspecialchars($row[$finfo->name]) . "</td>");

            // ここに、お預かりしたコード片のロジックを組み込みます
            // 列名で判断するのがより堅牢です
            if ($finfo->name == 'id') {
                // IDはhiddenで渡す（変更不可）
                print("<td><input type='hidden' name='record_id' value='" . htmlspecialchars($row['id']) . "'>" . htmlspecialchars($row['id']) . "</td>");
            } elseif ($finfo->name == 's_number') {
                // 学籍番号も通常は変更不可（hidden）にするか、特別な編集フィールドにするか
                // ここでは表示しつつhiddenで渡す例
                print("<td><input type='text' name='s_number' value='" . htmlspecialchars($row['s_number']) . "' size='8' maxlength='8'></td>");
            } elseif ($finfo->name == 'name') {
                print("<td><input type='text' name='name' value='" . htmlspecialchars($row['name']) . "' size='40' maxlength='40'></td>");
            } elseif ($finfo->name == 'subject') {
                print("<td><input type='text' name='subject' value='" . htmlspecialchars($row['subject']) . "' size='60' maxlength='60'></td>");
            } elseif ($finfo->name == 'sub') {
                print("<td><input type='text' name='sub' value='" . htmlspecialchars($row['sub']) . "' size='40' maxlength='40'></td>");
            } else {
                // その他の列は表示のみ (編集不可)
                print("<td>" . htmlspecialchars($row[$finfo->name]) . "</td>");
            }
            print("</tr>");
        }
        print("</TABLE><br>");

        // 更新ボタンと取消ボタン
        print("<input type='submit' name='update_submit' value='変更'>"); // name='update_submit' を追加して、フォーム送信を識別
        print("<input type='reset' value='取消'><br>");
        print("</FORM>");

    } else {
        print("指定されたID [" . htmlspecialchars($display_id) . "] のデータは登録されていません。<br>");
    }

    mysqli_free_result($rs);
    mysqli_stmt_close($stmt_select);
} else {
    print("SQLステートメントの準備に失敗しました: " . htmlspecialchars(mysqli_error($dbHandle)) . "<br>");
}

mysqli_close($dbHandle);

print ("<br><a href=myphp5.php>戻る</a><br>");
print("</BODY>\n");
print("</HTML>\n");
?>
<br>
<a href="myphp.php">メニュー</a><br>