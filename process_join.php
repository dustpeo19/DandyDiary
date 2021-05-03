<?php
require_once('db_info.php');

$filtered=array(
    'userid'=>mysqli_real_escape_string($conn,$_POST['userid']),
    'password'=>mysqli_real_escape_string($conn,$_POST['password']),
    'nickname'=>mysqli_real_escape_string($conn,$_POST['nickname'])
);

$sql="
    insert into users(userid,password,nickname)
    values(
        '{$filtered['userid']}',
        '{$filtered['password']}',
        '{$filtered['nickname']}'
    )
";

$result=mysqli_query($conn,$sql);

if($result===false){
    echo '회원가입 과정에서 문제가 발생하였습니다. 관리자에게 문의해주세요.';
}else{
?>
<script>
    alert("멋쟁이 일기장에 가입하신 것을 축하드립니다!");
    location.href='/';
</script>
<?php
}
?>