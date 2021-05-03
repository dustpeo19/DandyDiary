<?php
session_start();
include('lib/head.php');
include('lib/header.php');
include('lib/modal.php');
?>
<main>
    <div class="container">
        <form action="process_join" method="POST">
            <fieldset class="joinfield">
                <legend class="joinlegend">회원가입</legend>
                <p>
                    <label for="userid">아이디</label>
                    <input id="userid" type="text" name="userid" required>
                </p>
                <p>
                    <label for="password">비밀번호</label>
                    <input id="password" type="password" name="password" required>
                </p>
                <p>
                    <label for="nickname">닉네임</label>
                    <input id="nickname" type="text" name="nickname" required>
                </p>
            </fieldset>
            <div class="joinbtn">
                <input type="submit" value="가입하기">
            </div>
        </form>
    </div>
</main>
<?php
include('lib/footer.php');
?>