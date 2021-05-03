<?php
session_start();

$written_content='';
$written_locked='';

if(isset($_SESSION['written_content'])){
    $written_content=$_SESSION['written_content'];
    unset($_SESSION['written_content']);
}
if(isset($_SESSION['written_locked'])){
    if($_SESSION['written_locked']=='T'){
        $written_locked='checked';
    }
    unset($_SESSION['written_locked']);
}

include('lib/head.php');
include('lib/header.php');
include('lib/modal.php');
?>

<main>
    <div class="container">
        <h3 class="diarytitle">오늘의 일기</h3>
        <form action="process_create" method="POST">
            <textarea name="content" class="form-control" id="content" rows="10" placeholder="내용을 입력하세요" required><?=$written_content?></textarea>
            <div class="d-flex justify-content-end">
                <div class="lockedcheck">
                    <input type="checkbox" name="lockedcheckbox" id="lockedcheckbox" value="locked" <?=$written_locked?>>
                    <label for="lockedcheckbox">비밀글</label>
                </div>
                <div class="submitbtn">
                    <input type="submit" value="작성">
                </div>
            </div>
        </form>
    </div>
</main>
<?php
include('lib/footer.php');
?>