<?php

date_default_timezone_set('Asia/Tokyo');

$dsn="mysql:host=localhost;dbname=student;charset=utf8";
$user="root";
$pass="171641";

function getreservation(PDO $db){
    $ps = $db->query("select * from submission");
    $reservation = [];
    foreach ($ps as $out){
        $day_out = date('Y-m-d', strtotime((string)$out['day']));
    
    if (!isset($reservation[$day_out])) {
            $reservation[$day_out] = [];
        }
        $reservation[$day_out][] = [
            'name' => htmlspecialchars($out['name'], ENT_QUOTES),
            'subject' => htmlspecialchars($out['subject'], ENT_QUOTES),
            'sub' => htmlspecialchars($out['sub'], ENT_QUOTES),
        ];
        
    } 
    ksort($reservation);
    return $reservation;
}

function display_to_Holidays($date, array $Holidays_array): string {
    if (isset($Holidays_array[$date])) {
        return "<br/><span class='holiday'>" . htmlspecialchars($Holidays_array[$date], ENT_QUOTES) . "</span>";
    }
    return '';
}


function reservation($date,$reservation_array){
    if(!isset($reservation_array[$date])){
        return '';
    }

    $output = '';
    foreach ($reservation_array[$date] as $reservation_info){
        $output .= "<br/><span class = 'black'>";
        //$output .= "<strong>".$reservation_info['name']."</strong><br/>";
        $output .=  $reservation_info['subject']."<br/>";
        $output .=  $reservation_info['sub']."<br/>";
        $output .= "</span>"; 
    }
    return $output;
}

try {
    $db = new PDO($dsn, $user, $pass);
    // エラーモードを例外に設定
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "データベース接続エラー: " . $e->getMessage();
    exit;
}

if (isset($_POST['name']) && isset($_POST['subject']) && isset($_POST['sub']) && isset($_POST['day'])) {
    $name = $_POST['name'];
    $subject = $_POST['subject'];
    $sub = $_POST['sub'];
    $day = $_POST['day'];

    $stmt = $db->prepare("INSERT INTO submission (name, subject, sub, day) VALUES (:name, :subject, :sub, :day)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':subject', $subject);
    $stmt->bindParam(':sub', $sub);
    $stmt->bindParam(':day', $day);
    
    $stmt->execute();
}

$reservation_array = getreservation($db);

$Holidays_array = []; 

if (isset($_GET['ym'])) {
    $ym = $_GET['ym'];
} else {
    $ym = date('Y-m');
}

$timestamp = strtotime($ym . '-01');
if ($timestamp === false) {
    $ym = date('Y-m');
    $timestamp = strtotime($ym . '-01');
}

$today = date('Y-m-j');
$html_title = date('Y年n月', $timestamp);
$prev = date('Y-m', strtotime('-1 month', $timestamp));
$next = date('Y-m', strtotime('+1 month', $timestamp));
$day_count = date('t', $timestamp);
$youbi = date('w', $timestamp);
$weeks = [];
$week = '';

$week .= str_repeat('<td></td>', $youbi);

// カレンダーのループ
for ($day = 1; $day <= $day_count; $day++, $youbi++) {
    $date = $ym . '-' . $day;
    $Holidays_day = display_to_Holidays($date, $Holidays_array);
    $reservation = reservation($date, $reservation_array);
    
    if ($today == $date) {
        $week .= '<td class="today">' . $day;
    } elseif (!empty($Holidays_day)) {
        $week .= '<td class="holiday">' . $day . $Holidays_day;
    } elseif (!empty($reservation)) {
        $week .= '<td>' . $day . $reservation;
    } else {
        $week .= '<td>' . $day;
    }
    $week .= '</td>';
    
    if ($youbi % 7 == 6 || $day == $day_count) {
        if ($day == $day_count) {
            $week .= str_repeat('<td></td>', 6 - ($youbi % 7));
        }
        $weeks[] = '<tr>' . $week . '</tr>';
        $week = '';
    }
}
include 'view.php';
?>

