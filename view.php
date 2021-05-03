<?php
session_start();
require_once('db_info.php');

if(empty($_GET['id'])){
	header("Location: /");
}

$update_link='';
$delete_link='';

$filtered_diaryidx=mysqli_real_escape_string($conn,$_GET['id']);
$sql="select content, datetime, locked, idx, nickname from diaries left join users on author=idx where diaryidx={$filtered_diaryidx};";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_array($result);

$locked=htmlspecialchars($row['locked']);

if($locked=='T' && (empty($_SESSION['idx']) || $_SESSION['idx']!=$row['idx'])){
    echo("
        <script>
            alert('비밀글입니다.');
            window.stop();
            history.back();
        </script>
    ");
}else{      //보안성 향상
    $content=htmlspecialchars($row['content']);
    $nickname=htmlspecialchars($row['nickname']);
    $datetime=htmlspecialchars($row['datetime']);
    
    $year=substr($datetime, 0, 4);
    $month=substr($datetime, 5, 2);
    $date=substr($datetime, 8, 2);
    $time=substr($datetime, 11);
    
    $datestr="{$year}년 {$month}월 {$date}일";
    
    if(isset($_SESSION['idx'])){
        if($_SESSION['idx']===$row['idx']){
            $update_link="<p class='update_link'><a href='update?id={$filtered_diaryidx}'>수정하기</a></p>";
            $delete_link="
                <form action='process_delete' method='post'>
                    <input type='hidden' name='diaryidx' value='{$filtered_diaryidx}'>
                    <input type='hidden' name='idx' value='{$_SESSION['idx']}'>
                    <input type='submit' class='delete_button' value='삭제하기'>
                </form>
            ";
        }
    }
}

include('lib/head.php');
include('lib/header.php');
include('lib/modal.php');
?>
<main>
    <div class="container">
        <div class="diarywrapper">
            <h4 class="viewdate"><?=$datestr?></h4>
            <p class="viewprev"><i class='fas fa-caret-left'></i> 이전 일기</p>
            <p class="viewnext">다음 일기 <i class='fas fa-caret-right'></i></p>
            <div class="viewcontentbox">
                <p class="viewcontent"><?=$content?></p>
                <p class="viewtime">작성 시각: <?=$time?></p>
            </div>
            <div class="modifybtn d-flex justify-content-end">
                <?=$update_link?>
                <?=$delete_link?>
            </div>
        </div>
    </div>
</main>
<?php
include('lib/footer.php');
?>