<?php
SESSION_start();
require_once('db_info.php');

$filtered=array(
    'content'=>mysqli_real_escape_string($conn,$_POST['content'])
);

if(isset($_POST['lockedcheckbox'])){
    $filtered['locked']='T';
}else{
    $filtered['locked']='F';
}

if(isset($_SESSION['idx'])){
    $filtered['author']=mysqli_real_escape_string($conn,$_SESSION['idx']);
}else{
    $_SESSION['written_content']=$filtered['content'];
    $_SESSION['written_locked']=$filtered['locked'];
?>
<script>
    alert("로그인 후 작성 가능합니다.");
    location.href="login";
</script>
<?php
}

$sql="
    insert into diaries(content,author,datetime,locked)
    values(
        '{$filtered['content']}',
        '{$filtered['author']}',
        now(),
        '{$filtered['locked']}'
    )
";
$result=mysqli_query($conn,$sql);

header("Location: my");
?>