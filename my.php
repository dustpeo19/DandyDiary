<?php
session_start();
require_once('db_info.php');

if(empty($_SESSION['idx'])){
	header("Location: login");
}

$sql="select * from diaries left join users on diaries.author=users.idx where idx='{$_SESSION['idx']}' order by datetime desc";
$result=mysqli_query($conn,$sql);
$diaryidx_list=array();
$datetime_list=array();
$nickname_list=array();
$locked_list=array();

while($row=mysqli_fetch_array($result)){
    $escaped_diaryidx=htmlspecialchars($row['diaryidx']);
    array_push($diaryidx_list,$escaped_diaryidx);           //id값으로 인덱싱할 때 필요
    
    $escaped_datetime=htmlspecialchars($row['datetime']);
    array_push($datetime_list,$escaped_datetime);
    
    $escaped_nickname=htmlspecialchars($row['nickname']);
    array_push($nickname_list,$escaped_nickname);
    
    $escaped_locked=htmlspecialchars($row['locked']);
    array_push($locked_list,$escaped_locked);
}

$diary_list='';

for($i=0;$i<count($diaryidx_list);$i++){
    $locked_icon="";
    if($locked_list[$i]=='T'){
        $locked_icon="<i class='fas fa-lock listlock'></i>";
    }
    $ni=count($diaryidx_list)-$i;             //반복문으로 인덱싱
    $diary_list=$diary_list."
        <tr>
            <td>{$ni}</td>
            <td><a href='view?id={$diaryidx_list[$i]}'>{$datetime_list[$i]} {$locked_icon}</a></td>
            <td>{$nickname_list[$i]}</td>
        </tr>
    ";
}

include('lib/head.php');
include('lib/header.php');
include('lib/modal.php');
?>
<main>
    <div class="container">
        <h4>내가 쓴 일기</h4>
        <table class="diarylist">
            <thead>
                <tr>
                    <th width="70">번호</th>
                    <th width="500">날짜</th>
                    <th width="120">작성자</th>
                </tr>
            </thead>
            <tbody>
                <?=$diary_list?>
            </tbody>
        </table>
    </div>
</main>
<?php
include('lib/footer.php');
?>