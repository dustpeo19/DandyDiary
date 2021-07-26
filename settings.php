<?php
session_start();
require_once('db_info.php');

if(empty($_SESSION['idx'])){
	header("Location: login.php");
}

$sql="select * from users where idx={$_SESSION['idx']}";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_array($result);

$idx=htmlspecialchars($row['idx']);
$cur_password=htmlspecialchars($row['password']);
$cur_nickname=htmlspecialchars($row['nickname']);

include('lib/head.php');
include('lib/header.php');
include('lib/modal.php');
?>
<main>
    <div class="container">
        <form action="process_settings.php" method="POST">
            <fieldset class="joinfield">
                <legend class="joinlegend">정보수정</legend>
                <input type="hidden" name="idx" value="<?=$idx?>">
                <p>
                    <label for="password">비밀번호</label>
                    <input id="password" type="password" name="password" value="<?=$cur_password?>" required>
                </p>
                <p>
                    <label for="nickname">닉네임</label>
                    <input id="nickname" type="text" name="nickname" value="<?=$cur_nickname?>" required>
                </p>
            </fieldset>
            <div class="joinbtn">
                <input type="submit" value="수정 완료">
            </div>
        </form>
    </div>
</main>
<?php
include('lib/footer.php');
?>