<?
$_hoon["router"] = true;

if(file_exists(dirname(__FILE__)."/rest/".$_hoon["param"][2].".php")) {
	include(dirname(__FILE__)."/rest/".$_hoon["param"][2].".php");
	if($_hoon["router"]) {
		$_hoon["router"] = $_hoon["param"][3];
	}
}

if($_hoon["router"] !== false) {

	$rtn = @call_user_func($_hoon["router"], $_hoon["param"]);
	if($rtn!= null) {
        echo ( isset($_REQUEST["callback"]) ? $_REQUEST["callback"] . '(' : '') . json_encode($rtn) . (isset($_REQUEST["callback"]) ? ')' : '');
    }
}
?>