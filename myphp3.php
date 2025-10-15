<?php
//HTML文を出力 HTMLの開始
print("<HTML>\n");

//HTML文を出力 HEADの開始
print("<HEAD>\n");

//文字コードをUTF-8と指定
print("<META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=\"UTF-8\">\n");

//HTML文を出力 TITLEの指定
print("<TITLE>myphp3</TITLE>\n");

//HTML文を出力 HEADの終了
print("</HEAD>\n");

//HTML文を出力 BODYの開始
print("<BODY>\n");

//HTML文を出力 登録確認
print("<b>新規登録</b><br><br>");

//HTML文を出力 FORMの開始
print("<FORM action=myphp3-1.php method=post>");

//HTML文を出力 入力フィールドの説明
print("新規登録するデータを入力してください<br><br>");

//HTML文を出力 TABLEの開始
print("<TABLE border=1>");

//HTML文を出力 入力フィールドの指定
print("<tr><td><b>学籍番号</b></td><td>" . "<INPUT type=text name=s_number size=40 maxlengh=10 required></td></tr>");

//HTML文を出力 入力フィールドの指定
print("<tr><td><b>名前</b></td><td>" . "<INPUT type=text name=name size=40 maxlengh=40 required></td></tr>");

//HTML文を出力 入力フィールドの指定
print("<tr><td><b>授業名</b></td><td>" . "<INPUT type=text name=subject size=60 maxlengh=60 required></td></tr>");

print("<tr><td><b>提出状況</b></td><td><select name=\"sub\" required><option value=\"\">選択してください</option><option value=\"提出済み\">提出済み</option><option value=\"未提出\">未提出</option></select></td></tr>");
print('<tr><td><b>提出日</b></td><td>' . '<input type="date" name="day" id="day" required></td></tr>');

//HTML文を出力 TABLEの終了
print("</TABLE><br>");

//HTML文を出力 確認ボタン
print("<INPUT type=submit value=登録>");

//HTML文を出力 取消ボタン
print("<INPUT type=reset value=取消><br>");

//HTML文を出力 FORMの終了
print("</FORM>");

//HTML文を出力 BODYの終了
print("</BODY>\n");

//HTML文を出力 HTMLの終了
print("</HTML>\n");
?>
<br>
<a href="myphp.php">メニュー</a><br>