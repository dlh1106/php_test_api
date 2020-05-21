
<?
//ini_set('session.cookie_domain', '.vrpia.net' );

// error_reporting(E_ALL);
// ini_set("display_errors", 0);
error_reporting(0);
ini_set("display_errors", 0);
ini_set("session.cookie_httponly", 1);
header("X-Frame-Options: SAMEORIGIN");
header("X-XSS-Protection: 1");
header('X-Content-Type-Options: nosniff');
header('Access-Control-Allow-Methods: GET,POST,OPTIONS');
session_start();

if(isset($_SERVER['HTTP_ORIGIN'])) {
	header("Access-Control-Allow-Origin: ".$_SERVER['HTTP_ORIGIN']);
	header('Access-Control-Allow-Credentials: true');
	header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
}

include $_SERVER["DOCUMENT_ROOT"]."/class/lib/pdo_lib.php";
include $_SERVER["DOCUMENT_ROOT"]."/class/auth.php";
include $_SERVER["DOCUMENT_ROOT"]."/class/member.php";

$_hoon = [];
$_hoon["param"] = [];
if(isset($_SERVER["PATH_INFO"])) {
	$_hoon["param"] = explode("/", $_SERVER["PATH_INFO"]);
}
$_hoon["domain"] =  parse_url($_SERVER['HTTP_HOST']);
$_hoon["domain"] = (isset($_hoon["domain"]["path"]))?$_hoon["domain"]["path"]:$_hoon["domain"]["host"];
$_hoon["title"] = "Title";
$_hoon["router"] = false;

function loadpage($dir,$fn)
{
    if($fn=="") $fn="main";
	if(file_exists("./".$dir."/".$fn.".php")) {
		$rtn = "./".$dir."/".$fn.".php";
	} else {
		http_response_code(404);
		$rtn = "./404.php";
		include "404.php";
		die();
	}
	return $rtn;
}

switch($_hoon["domain"])
{			
    default:
		$_hoon["filename"] = loadpage("src/main", $_hoon["param"][1]);
		break;
		

}
require $_hoon["filename"];
?>
