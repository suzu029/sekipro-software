<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>PHPカレンダー</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">
    <style>
      .container { font-family: 'Noto Sans', sans-serif; margin-top: 0px; }
      h3 { margin-bottom: 30px; }
      th { height: 30px; text-align: center; }
      td { height: 100px; }
      .today { background: orange; }
      th:nth-of-type(1), td:nth-of-type(1) { color: red; }
      th:nth-of-type(7), td:nth-of-type(7) { color: blue; }
      .holiday { color: red; }
      .green { color: green; }
    </style>
</head>

<body>
    <div class="container">
        <h3><a href="?ym=<?php echo $prev; ?>">&lt;</a><?php echo $html_title; ?><a href="?ym=<?php echo $next; ?>">&gt;</a></h3><a href="myphp.php">メニュー</a><br>
        <table class="table table-bordered">
            <tr>
                <th>日</th>
                <th>月</th>
                <th>火</th>
                <th>水</th>
                <th>木</th>
                <th>金</th>
                <th>土</th>
            </tr>
            <?php
                foreach ($weeks as $week) {
                    echo $week;
                }
            ?>
        </table>

        <!--
        <hr>
        <h4>予約フォーム</h4>
        <form action="cal.php" method="post">
            <div class="form-group">
                <label for="name">お名前</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="山田太郎" required>
            </div>
            <div class="form-group">
                <label for="number">電話番号</label>
                <input type="tel" class="form-control" name="number" id="number" placeholder="08012349876" required>
            </div>
            <div class="form-group">
                <label for="member">人数</label>
                <input type="number" class="form-control" name="member" id="member" required>
            </div>
            <div class="form-group">
                <label for="day">日付</label>
                <input type="date" class="form-control" name="day" id="day" required>
            </div>
            <button type="submit" class="btn btn-primary">送信</button>
            <button type="reset" class="btn btn-default">リセット</button>
            -->
        </form>
    </div>
</body>
</html>