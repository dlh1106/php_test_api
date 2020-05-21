<?
class AUTH{

    private $db;

    function __construct(){
        $this->db = new PDO_Lib("test");
        // print_r($this->db);
    }

    //단방향 암호화
    // ref : https://offbyone.tistory.com/347
    function sha_pass(string $type, string $pass){
        $rtn = "";
        switch($type){
            case 'sha256':
            case 'sha512':
            $rtn = base64_encode(hash($type, $pass, true));
            break;
        }
    
        if($rtn!=""){
            return $rtn; 
        }else{
            return false;
        }
    }

    function login_chk(string $uid, string $upw){
        $upw = $this->sha_pass("sha512",$upw); //단방향 암호화

        $sql = "SELECT idx, kname, email  
                from `member` 
                where nickname = :nickname 
                and upw = :upw";
        $param = [];
        $param["nickname"] = $uid;
        $param["upw"] = $upw;

        $rtn = [];
        $rtn["is_login"] = false; 
        $info = $this->db->queryOne($sql,$param);       
        if($info!=false){
            $rtn["is_login"] = true; //로그인 성공
            $rtn["info"] = $info;
        }
        return $rtn;
    }


}











?>