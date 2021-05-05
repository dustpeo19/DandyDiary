<?php
session_start();
require_once('db_info.php');

$filtered=array(
    'id'=>mysqli_real_escape_string($conn,$_POST['login_id']),
    'pw'=>mysqli_real_escape_string($conn,$_POST['login_pw'])
);

$sql="select * from users where userid='{$filtered['id']}'";
$result=mysqli_query($conn,$sql);

if(mysqli_num_rows($result)==1){
    $row=mysqli_fetch_array($result);

    if($row['password']===$filtered['pw']){
        $_SESSION['idx']=$row['idx'];
        $_SESSION['userid']=$row['userid'];
        $_SESSION['nickname']=$row['nickname'];

        if(isset($_SESSION['userid'])){
            header("Location: /");
        }else{
            echo('session failed');
        }
    }else{
?>
<script>
        alert("아이디 또는 비밀번호를 다시 확인하세요.");
        location.href='/';
</script>
<?php
    }
}else{
?>
<script>
    alert("아이디 또는 비밀번호를 다시 확인하세요.");
    location.href='/';
</script>
<?php
}
?>