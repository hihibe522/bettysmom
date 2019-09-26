<?php require_once('Connections/conn_bettysmom.php'); ?>



<?php
//加入購物車Class的宣告
require_once('cart/EDcart.php');
session_start();
$cart =& $_SESSION['edCart']; 
if(!is_object($cart)) $cart = new edCart(); 

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$colname_rs_cartprocess = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_rs_cartprocess = $_SESSION['MM_Username'];
}
mysql_select_db($database_conn_bettysmom, $conn_bettysmom);
$query_rs_cartprocess = sprintf("SELECT * FROM member WHERE account = %s", GetSQLValueString($colname_rs_cartprocess, "text"));
$rs_cartprocess = mysql_query($query_rs_cartprocess, $conn_bettysmom) or die(mysql_error());
$row_rs_cartprocess = mysql_fetch_assoc($rs_cartprocess);
$totalRows_rs_cartprocess = mysql_num_rows($rs_cartprocess);
?>


<?php
//執行購物車動作
$DoSomeThing = (isset($_GET['A']) ? $_GET['A'] : "");
switch($DoSomeThing){
case "Add":
	$cart->add_item($_GET['prono'],$_GET['qty'],$_GET['price'],$_GET['name'],isset($_GET['pic'])?$_GET['pic']:'');
	break;
case "Remove":
	$cart->del_item($_GET['prono']);
	break;
case "Empty":
	$cart->empty_cart();
	break;
case "Update":
	for($startNO=0;$startNO < $_GET['itemcount'];$startNO++){
		$cart->edit_item($_GET['itemid'][$startNO],$_GET['qty'][$startNO]);
	}
	break;			
}
?>



<div style="position:fixed; right:0; top:500;">
<h1><a href="bill.php">點我跳到bill.php</a></h1>
<br>
<h1><a href="market.php">點我跳到market.php</a></h1>
<div>

<?php header ("Location:bill.php");?>



<?php if ($totalRows_rs_cartprocess == 0) { // Show if recordset empty ?>
<?php $cart->empty_cart();?>
<?php header ("Location:market.php?nonlogin=1");?>
<?php } // Show if recordset empty ?>


<?php 
mysql_free_result($rs_cartprocess);
?>
