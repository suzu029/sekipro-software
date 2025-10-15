<?php
//HTML文を出力　HTMLの開始
print("<HTML>\n");

//HTML文を出力　HEADの開始
print("<HEAD>\n");

//文字コードをUTF-8と指定
print("<META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=\"UTF-8\">\n");

//HTML文を出力　TITLEの指定
print("<TITLE>myphp7</TITLE>\n");

//HTML文を出力　HEADの終了
print("</HEAD>\n");

//頁内に表示する行数
$maxline = 5;

//DBへ接続開始 サーバー名--localhost ユーザー名--root パスワード--root
$dbHandle = mysqli_connect("localhost","root","171641")
  or die("can not connect db\n");
  
//MySQLのクライアントの文字コードをutf8に設定
mysqli_set_charset($dbHandle, "utf8");

//使用するdb名を指定する  testを指定
mysqli_select_db($dbHandle,"movie",);

//GETで渡された?pageを取り出し$pageにセット
$page=filter_input(INPUT_GET,'page');

//頁数がセットされていない場合は頁数に1をセット
if ($page < 1) {
	$page = 1;
}
//開始行を算出
$startline =  ($page - 1) * $maxline;

//終了行を算出
$endline   =  $page * $maxline -1;

//SQL文 actor表から全行を取り出し、1列目の昇順に整列する
$sql = "select * from actor order by 1";

//SQL文を実行する
$rs = mysqli_query($dbHandle, $sql);

//列数を取得する
$num = mysqli_num_fields($rs);

//取得した行数から最終頁を算出
//ceil(数値)は小数点以下を切り上げる関数
$maxpage = ceil(mysqli_num_rows($rs) / $maxline);

//HTML文を出力　テーブルの開始を指定
print("<table border=1>");

//現在の頁/最終頁を表示
print("<caption valign='top' align='right'>Page ".$page."/".$maxpage."</caption>");

//test表の列数と同じ回数を繰り返す
for ($i=0;$i<$num;$i++){

//HTML文を出力　列名を <td>で囲んで出力
	$finfo = mysqli_fetch_field($rs);
	print("<td><b>".$finfo->name."</b></td>");
}

//SQL文を実行する
$rs = mysqli_query($dbHandle, $sql);

//mysqli_data_seekによりtest表内の指定した行に移動する
mysqli_data_seek($rs,$startline);

//$iに$startlineを代入
$i=$startline;

//最終行でなく　かつ　$i<=$endlineの条件の間
//test表から行を取り出す
while($row=mysqli_fetch_array($rs) and $i<=$endline){

//HTML文を出力　表の行の開始<tr> を出力
	print("<tr>");
	
//test表の列数と同じ回数を繰り返す
	for($j=0;$j<$num;$j++){
	
//HTML文を出力　列の内容を <td>で囲んで出力
		print("<td>".$row[$j]."</td>");
	}

//HTML文を出力　表の改行</tr> を出力
	print("</tr>");
		
//$iに1を加算
	$i = $i + 1;

}	
//HTML文を出力　caption を出力
print("<caption align='bottom'>");

//現在表示している頁が１ページより後の頁の場合は前の頁のリンクを作成
if ($page > 1) {
		$i = $page - 1;
//HTML文を出力　.$pageに指定された頁数をセットしてGETで渡すリンクを作成
	print("<a href='myphp7.php?page=".$i ."'>前頁</a>");
}

//現在表示している頁が１ページではなく最終頁ではない場合は前頁と次頁を
//区切る「・」を出力
if ($page <> 1 and $page <> $maxpage) {
	print("・");
}

//現在表示している頁が最終頁より前の頁の場合は前の頁のリンクを作成
if ($page < $maxpage) {
			$i = $page + 1;
//HTML文を出力　.$pageに指定された頁数をセットしてGETで渡すリンクを作成
			print("<a href='myphp7.php?page=".$i ."'>次頁</a>");
}
///HTML文を出力　改行
print("<br>");

//出力可能な頁数数分繰り返す
for ($i=1;$i<=$maxpage;$i++) {

//現在の頁の時は [ ]で囲む
	if ($i==$page){
		print("[".$i."]");
	} else {
//HTML文を出力　.$pageに指定された頁数をGETで渡すリンクを作成
		print("<a href='myphp7.php?page=".$i."'>$i</a>");
	}
//最終頁以外では頁間を区切る「・」を出力
	if ($i <> $maxpage) {
		print("・");
	}
}

//HTML文を出力　テーブルの終了を指定
print("</table>");

//HTML文を出力　/caption を出力
print("</caption>");

//結果レコードをメモリから開放
mysqli_free_result($rs);

//DBへの接続を切断
mysqli_close($dbHandle);

?>　
<br>
<a href="myphp.php">メニュー</a><br>
