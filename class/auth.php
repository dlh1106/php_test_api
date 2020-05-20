<?
class AUTH{

    private $db;

    function __construct(){
        $this->db = new PDO_Lib("test");
        // print_r($this->db);
    }

    //암호화
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

    function login(string $uid, string $upw){
        


    }

    function logout(){
        session_destroy();
    }

}











?>