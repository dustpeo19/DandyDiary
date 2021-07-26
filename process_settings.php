<?php
session_start();
require_once('db_info.php');

$filtered=array(
    'idx'=>mysqli_real_escape_string($conn,$_POST['idx']),
    'new_password'=>mysqli_real_escape_string($conn,$_POST['password']),
    'new_nickname'=>mysqli_real_escape_string($conn,$_POST['nickname'])
);

if(empty($_SESSION['idx']) || $_SESSION['idx']!=$filtered['idx']){
    echo("
        <script>
            alert('잘못된 접근입니다.');
            window.stop();
            location.href='/';
        </script>
    ");
	header("Location: /");
}else{
	$sql="
        update users set
            password='{$filtered['new_password']}',
            nickname='{$filtered['new_nickname']}'
        where
            idx='{$_SESSION['idx']}'
    ";

    $result=mysqli_query($conn,$sql);

    if($result===false){
        echo '수정 과정에서 문제가 발생하였습니다. 관리자에게 문의해주세요.</br><a href="/">돌아가기</a>';
    }else{
		$_SESSION['nickname']=$filtered['new_nickname'];
        header("Location: /");
    }
}
?>