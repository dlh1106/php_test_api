<?php
//controller

function member_login(){
    session_start();
    $uid = "dlh1106"; //프론트에서 넘겨받는다고 가정
    $upw = "ehgns5545";

    $auth = new AUTH();
    $res = $auth->login_chk($uid,$upw);
    if($res["is_login"]){// 로그인 성공시
        $info = $res["info"];
        $_SESSION["uidx"] = $info["idx"];
        $_SESSION["kname"] = $info["kname"];
        $_SESSION["email"] = $info["email"];
        echo "
        <script>
            location.href = '/session_test';
        </script>
        ";
    }else{
        echo "로그인 실패";
    }
    
}

function member_logout(){
    session_start();
    session_destroy();
    echo "
    <script>
        location.href = '/session_test';
    </script>
    ";
}


function member_add(){
    // 프론트에서 넘겨받는다고 가정
    $kname = "이도훈"; 
    $nickname = "dlh1107";
    $upw = "ehgns5545@";
    $mobile = "010-9843-5545";
    $email = "dlh1106@naver.com";
    $gender = "M";
    
    $member = new Member();

    $rtn = [];
    $rtn = $member->add($kname, $nickname, $upw, $mobile, $email, $gender);
    
    return $rtn;
}

function member_view(){
    $member_idx = 2; // 프론트에서 넘겨받는다고 가정

    $member = new member();

    $rtn = [];
    $rtn = $member->view($member_idx);

    return $rtn;
}

function member_list(){
    $page = 1; // 프론트에서 넘겨받는다고 가정
    $pagesize = 30;
    $kname = "";
    $email = "";

    $member = new member();

    $rtn = [];
    $rtn = $member->list($page, $pagesize, $kname, $email);
    
    return $rtn;
}

function order_list(){
    $member_idx = 3; // 프론트에서 넘겨받는다고 가정

    $member = new member();

    $rtn = [];
    $rtn = $member->order_list($member_idx);
    
    return $rtn;
}
?>