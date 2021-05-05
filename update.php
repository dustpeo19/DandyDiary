<?php
session_start();
require_once('db_info.php');

if(empty($_GET['id'])){
	header("Location: /");
}

$locked_check='';

if(isset($_GET['id'])){
    $filtered_diaryidx=mysqli_real_escape_string($conn,$_GET['id']);
    $sql="select content, author, datetime, locked from diaries where diaryidx={$filtered_diaryidx};";
    $result=mysqli_query($conn,$sql);
    $row=mysqli_fetch_array($result);

    $author=htmlspecialchars($row['author']);

    if(empty($_SESSION['idx']) || $_SESSION['idx']!=$author){
        echo("
            <script>
                alert('잘못된 접근입니다.');
                window.stop();
                location.href='/';
            </script>
        ");
    }else{      //보안성 향상
        $content=htmlspecialchars($row['content']);
        $datetime=htmlspecialchars($row['datetime']);
        $locked=htmlspecialchars($row['locked']);
        
        $year=substr($datetime, 0, 4);
        $month=substr($datetime, 5, 2);
        $date=substr($datetime, 8, 2);
        $datestr="{$year}년 {$month}월 {$date}일";
        
        if($locked=='T'){
            $locked_check='checked';
        }
    }
}

include('lib/head.php');
include('lib/header.php');
include('lib/modal.php');
?>

<main>
    <div class="container">
        <h3 class="diarytitle"><?=$datestr?>의 일기 <small>수정하기</small></h3>
        <form action="process_update.php" method="POST">
            <input type="hidden" name="diaryidx" value="<?=$filtered_diaryidx?>">
            <input type="hidden" name="idx" value="<?=$author?>">
            <textarea name="content" class="form-control" id="content" rows="10" placeholder="내용을 입력하세요" required><?=$content?></textarea>
            <div class="d-flex justify-content-end">
                <div class="lockedcheck">
                    <input type="checkbox" name="lockedcheckbox" id="lockedcheckbox" value="locked" <?=$locked_check?>>
                    <label for="lockedcheckbox">비밀글</label>
                </div>
                <div class="submitbtn">
                    <input type="submit" value="수정">
                </div>
            </div>
        </form>
    </div>
</main>
<?php
include('lib/footer.php');
?>