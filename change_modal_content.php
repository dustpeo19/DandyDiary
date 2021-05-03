<?php
require_once('db_info.php');

if(isset($_SESSION['idx'])){
    $modalhistoryhtml='<p>작성한 일기가 없습니다!</p>';
    $sql="select diaryidx, content, datetime, locked from diaries left join users on diaries.author=users.idx where idx='{$_SESSION['idx']}' order by datetime desc limit 3";
    $result=mysqli_query($conn,$sql);

    $diaryidx_list=array();
    $datetime_list=array();
    $content_list=array();
    $locked_list=array();

    while($row=mysqli_fetch_array($result)){
        $escaped_diaryidx=htmlspecialchars($row['diaryidx']);
        array_push($diaryidx_list,$escaped_diaryidx);

        $escaped_datetime=substr(htmlspecialchars($row['datetime']), 0, 10);
        array_push($datetime_list,$escaped_datetime);
        
        $escaped_content=htmlspecialchars($row['content']);
        if (mb_strlen($escaped_content,'utf-8')>17){
            $escaped_content=mb_substr($escaped_content, 0, 17, 'utf-8').' ...';
        }
        array_push($content_list,$escaped_content);
        
        $escaped_locked=htmlspecialchars($row['locked']);
        array_push($locked_list,$escaped_locked);
    }
    
    if(count($content_list)!=0){
        $modalhistoryhtml='';                   //일기 내용이 있으면 '작성한 일기가 없습니다!' 문구 삭제

        for($i=0; $i<count($content_list); $i++){
            $locked_icon='';
            if($locked_list[$i]=='T'){
                $locked_icon="<i class='fas fa-lock listlock'></i>";
            }
            $modalhistoryhtml=$modalhistoryhtml."
            <a href='view?id={$diaryidx_list[$i]}'>
                <div class='modalhistorybox'>
                    <p class='modalhistorycontent'>$content_list[$i] {$locked_icon}</i></p>
                    <p class='modalhistorydate'>$datetime_list[$i]</p>
                </div>
            </a>
            ";
        }
    }

    $cut_nickname=$_SESSION['nickname'];
    if (mb_strlen($_SESSION['nickname'],'utf-8')>10){
        $cut_nickname=mb_substr($escaped_content, 0, 10, 'utf-8').' ... ';
    }

    $status="
        <div class='mybox'> 
            <p>{$cut_nickname}님 환영합니다!</p>
            <div class='myboxmenu d-flex justify-content-end'>
                <a href='settings'>정보수정</a>
                <a href='process_logout'>로그아웃</a>
            </div>
        </div>
        <div class='modalhistorywrapper'>
            <p>최근 일기</p>
            <div class='modalhistorylist'>
                {$modalhistoryhtml}
            </div>
            <a href='my'><p class='modalhistorymore'>더보기 <i class='fas fa-caret-right'></i></p></a>
        </div>
    ";
}else{
    $status='
        <form action="process_login" method="post">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <p><i class="fas fa-user"></i></p>
        <h2>LOG-IN</h2>
        <input type="text" class="form-control" name="login_id" placeholder="ID">
        <input type="password" class="form-control" name="login_pw" placeholder="PW">
        <button type="submit" class="btn btn-primary loginbtn">로그인</button>
        <div class="button-wrap d-flex justify-content-between">
            <button type="button" class="btn btn-secondary join-link" onclick="goToJoin();">회원가입</button>
            <button type="button" class="btn btn-info forgotpw-link" onclick="goToForgotpw();">비밀번호 찾기</button>
        </div>
    </form>
    ';
}
?>