<?php
//controller

function member_login(){

}

function member_logout(){

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