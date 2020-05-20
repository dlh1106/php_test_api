<?php

class Member {

    private $db;

    function __construct(){
        $this->db = new PDO_Lib("test");
        // print_r($this->db);
    }
   
    // 회원 가입
   
    function add(string $kname, string $nickname, string $upw, string $mobile, string $email, string $gender="") {

        $idata = [];
        $idata["kname"] = $kname;
        $idata["nickname"] = $nickname;

        $chk = preg_match("/^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%*#?&])[A-Za-z\d$@$!%*#?&]{10,}$/",$upw); //영문 대문자, 영문 소문자, 특수 문자, 숫자 각 1개 이상씩 포함

        if($chk==0){
            $rtn["err"] = 201;
            $rtn["err_msg"] = "비밀번호는 영문 대문자, 영문 소문자, 특수 문자, 숫자 각 1개 이상씩 포함하세요";
            return $rtn;
        }

        $auth = new AUTH();

        $upw = $auth->sha_pass("sha512",$upw); //암호화
        $idata["upw"] = $upw;
        $chk = preg_match("/^\d{3}-\d{3,4}-\d{4}$/",$mobile); //휴대전화 형식
        
        if($chk==0){
            $rtn["err"] = 203;
            $rtn["err_msg"] = "올바른 휴대전화 형식이 아닙니다 ex)000-0000-0000";
            return $rtn;
        }
        $idata["mobile"] = $mobile;
        $chk = preg_match("/^[0-9A-Z]([-_\.]?[0-9A-Z])*@[0-9A-Z]([-_\.]?[0-9A-Z])*\.[A-Z]{2,20}$/i",$email); //이메일 형식
        if($chk==0){
            $rtn["err"] = 202;
            $rtn["err_msg"] = "올바른 이메일 형식이 아닙니다";
            return $rtn;
        }
        $idata["email"] = $email;
        $idata["gender"] = $gender;
        $idata["createdate"] = date("Y-m-d h:i:s");
        
        $rtn = [];
        $chk = ["kname","nickname","upw","mobile","email"]; // 필수값 체크
        for($i=0;$i<count($chk);$i++){
            if($idata[$chk[$i]]==""){
                $rtn["err"] = 204;
                $rtn["err_msg"] = "필수값을 확인하세요";
                return $rtn;
            }
        }
        $sql = "SELECT count(*) as cnt 
                from `member` 
                where nickname = :nickname"; //아이디 중복 체크

        $temp = $this->db->queryOne($sql,["nickname"=>$idata["nickname"]]);
        if($temp["cnt"]>0){
            $rtn["err"] = 205;
            $rtn["err_msg"] = "중복된 닉네임이 존재합니다";
            return $rtn;
        }

        $rtn = $this->db->insData("`member`", $idata); 
        return $rtn;
    }

    //회원정보 조회
    function view(int $idx){
        $rtn = [];
        $sql = "SELECT kname, nickname, mobile, email, gender, createdate 
                from `member` 
                where idx = :idx";

        $info = $this->db->queryOne($sql,["idx"=>$idx]);
        switch($info["gender"]){
            case 'M':
                $info["gender"] = "남자";
            break;
            case 'F':
                $info["gender"] = "여자";
            break;

        }
        
        if(!empty($info)){
            $rtn["err"] = 0;
            $rtn["info"] = $info;
        }
        return $rtn;
    }

    //회원목록
    function list(int $page, int $pagesize, string $kname="", string $email=""){
        $rtn = [];
        if($page<1){
            $page = 1;
        }
        $pos = ($page-1)*$pagesize;
        $limit = " limit ".$pos.", ".$pagesize;


        $where = "";
        $param = [];
        //검색 조건
        if($kname!=""){
            $where .= " AND kname like :kname ";
            $param["kname"] = '%'.$kname.'%';
        }
        if($email!=""){
            $where .= " AND email like :email ";
            $param["email"] = '%'.$email.'%';
        }

        $sql = "SELECT idx, kname, nickname, mobile, email, gender, createdate 
                from `member` 
                where 1 ".$where.$limit;        

        $list = $this->db->queryAll($sql, $param);

        $sql = "SELECT order_num, name, createdate 
                from `order` 
                where member_idx = :member_idx
                order by idx desc
                limit 1";

        for($i=0;$i<count($list);$i++){
            $info = $this->db->queryOne($sql, ["member_idx"=>$list[$i]["idx"]]);
            $list[$i]["order"] = $info;
        }
        
        if(!empty($list)){
            $rtn["err"] = 0;
            $rtn["list"] = $list;
        }
        return $rtn;
    }

    //단일회원 주문 목록 조회
    function order_list(int $member_idx){
        $rtn = [];
        $sql = "SELECT idx, name, order_num, createdate
                from `order`  
                where member_idx = :member_idx";

        $list = $this->db->queryAll($sql, ["member_idx"=>$member_idx]);
        if(!empty($list)){
            $rtn["err"] = 0;
            $rtn["list"] = $list;
        }
        return $rtn;
    }
}




?>