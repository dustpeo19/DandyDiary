<?php
session_start();
include('db_info.php');

settype($_POST['id'],'integer');

$filtered_diaryidx=mysqli_real_escape_string($conn,$_POST['diaryidx']);
$filtered_idx=mysqli_real_escape_string($conn,$_POST['idx']);

if(empty($_SESSION['idx']) || $_SESSION['idx']!=$filtered_idx){
    echo("
        <script>
            alert('잘못된 접근입니다.');
            window.stop();
            location.href='/';
        </script>
    ");
}else{      //보안성 향상
    $sql="
        delete from diaries where diaryidx={$filtered_diaryidx}
    ";
    $result=mysqli_query($conn,$sql);
    
    if($result===false){
        echo '삭제하는 과정에서 문제가 발생하였습니다. 관리자에게 문의해주세요.</br><a href="list">돌아가기</a>';
    }else{
        header("Location: list");
    }
}
?>