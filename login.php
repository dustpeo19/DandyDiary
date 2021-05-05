<?php
session_start();

if(isset($_SESSION['idx'])){
	header("Location: /");
}

include('lib/head.php');
include('lib/header.php');
include('lib/modal.php');
?>
<main>
    <div class="container">
        <form action="process_login.php" method="post">
            <h2>LOG-IN</h2>
            <input type="text" class="form-control" name="login_id" placeholder="ID">
            <input type="password" class="form-control" name="login_pw" placeholder="PW"></br>
            <button type="submit" class="loginbtn">로그인</button></br>
            <div class="button-wrap d-flex">
                <button type="button" class="join-link" onclick="goToJoin();">회원가입</button>
                <button type="button" class="forgotpw-link" onclick="goToForgotpw();">비밀번호 찾기</button>
            </div>
        </form>
    </div>
</main>
<?php
include('lib/footer.php');
?>