<?php
session_start();
require_once('db_info.php');

settype($_POST['id'],'integer');

$filtered=array(
    'diaryidx'=>mysqli_real_escape_string($conn,$_POST['diaryidx']),
    'content'=>mysqli_real_escape_string($conn,$_POST['content']),
    'idx'=>mysqli_real_escape_string($conn,$_POST['idx'])
);

if(empty($_SESSION['idx']) || $_SESSION['idx']!=$filtered['idx']){
    echo("
        <script>
            alert('잘못된 접근입니다.');
            window.stop();
            location.href='/';
        </script>
    ");
}else{      //보안성 향상
    if(isset($_POST['lockedcheckbox'])){
        $filtered['locked']='T';
    }else{
        $filtered['locked']='F';
    }
    
    $sql="
        update diaries set
            content='{$filtered['content']}',
            locked='{$filtered['locked']}'
        where
            diaryidx='{$filtered['diaryidx']}'
    ";
    
    $result=mysqli_query($conn,$sql);
    if($result===false){
        echo '저장하는 과정에서 문제가 발생하였습니다. 관리자에게 문의해주세요.</br><a href="list">돌아가기</a>';
    }else{
        header("Location: view?id={$filtered['diaryidx']}");
    }
}
?>