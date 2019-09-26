
<?php require_once('Connections/conn_bettysmom.php'); ?>



<?php
//加入購物車Class的宣告
require_once('cart/EDcart.php');
session_start();
$cart =& $_SESSION['edCart']; 
if(!is_object($cart)) $cart = new edCart(); 
?>


<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "login.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO bill (`date`, account, name, phonenumber, address, shipping, subprice, totalprice) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['date'], "date"),
                       GetSQLValueString($_POST['account'], "text"),
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['phonenumber'], "text"),
                       GetSQLValueString($_POST['address'], "text"),
                       GetSQLValueString($_POST['shipping'], "int"),
                       GetSQLValueString($_POST['subprice'], "int"),
                       GetSQLValueString($_POST['totalprice'], "int"));

  mysql_select_db($database_conn_bettysmom, $conn_bettysmom);
  $Result1 = mysql_query($insertSQL, $conn_bettysmom) or die(mysql_error());

//取得最新的訂單編號
  $max_id = mysql_insert_id();
  $_SESSION['OrderID'] = $max_id; //將編號存入Session值中

//將購物車的詳細內容一筆筆寫入資料表
  if($cart->itemcount > 0) {
    	foreach($cart->get_contents() as $item) {
	  	$insertSQL = sprintf("INSERT INTO billdetail (bill_id, product_id, product_name, product_price, quantity) VALUES (%s, %s, %s, %s, %s)",
    	                   GetSQLValueString($max_id, "int"),
        	               GetSQLValueString($item['id'], "int"),
        	               GetSQLValueString($item['info'], "text"),				   
            	           GetSQLValueString($item['price'], "int"),
                	       GetSQLValueString($item['qty'], "int")); 
		mysql_select_db($database_conn_bettysmom, $conn_bettysmom);
		$Result1 = mysql_query($insertSQL, $conn_bettysmom) or die(mysql_error()); 
		}
  }

  $insertGoTo = "success.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>


<?php
$colname_rs_check = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_rs_check = $_SESSION['MM_Username'];
}
mysql_select_db($database_conn_bettysmom, $conn_bettysmom);
$query_rs_check = sprintf("SELECT * FROM member WHERE account = %s", GetSQLValueString($colname_rs_check, "text"));
$rs_check = mysql_query($query_rs_check, $conn_bettysmom) or die(mysql_error());
$row_rs_check = mysql_fetch_assoc($rs_check);
$totalRows_rs_check = mysql_num_rows($rs_check);
?>


<?php
//購物車為空時重新導向指定頁
if ($cart->itemcount == 0){
    echo ("目前購物車為空");
    header("Location:market.php?errMsg=1");
}
?>

<?php if ($totalRows_rs_check == 0) { // Show if recordset empty ?>
<?php $cart->empty_cart();?>
<?php header ("Location:market.php?nonlogin=1");?>
<?php } // Show if recordset empty ?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <!-- animate -->
        <link rel="stylesheet" href="css/animate.css">
        <!-- bootstraps -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <!-- fontawesome -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
        <!-- selfset -->
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/market.css">
        <link rel="stylesheet" href="css/bill.css">
        <title>~蓓蒂司蔓Betty's mom麵包坊~</title>
    </head>

    <body>
        <!-- beam為在第1層的梁 -->
        <div class="beam">
        </div>
         <!-- header為第50層固定在螢幕最上方．裡面包container(使nav的寬度固定在中間)) -->
        <header>
            <div class="container">
                <nav class="navbar navbar-light navbar-expand-md justify-content-between" style="background-color: #A2D9E7; ">
                    <div class="container-fluid">
                    <a href="index.php">    
                    <img src="img/logo180.png" alt="" class="navbar-brand" >
                    </a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".dual-nav">
                                                    <span class="navbar-toggler-icon"></span>
                                                </button>
                        <div class="navbar-collapse collapse dual-nav w-50 order-1 order-md-0">
                            <ul class="navbar-nav ">
                                <li class="nav-item ">
                                    <a class="nav-link" href="about.php" id="navbarDropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                                                    品牌故事&emsp;&emsp;
                                                                </a>
                                </li>
                                <li class="nav-item dropdown ">
                                    <a class="nav-link" href="product1.php" id="navbarDropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                                                麵包/蛋糕&emsp;&emsp;
                                                        </a>
                                    <div class="dropdown-menu ">
                                    <a class="dropdown-item" href="product1.php?#product1-1">手撕土司</a>
                                        <a class="dropdown-item" href="product1.php?#product1-2">法國麵包</a>
                                        <a class="dropdown-item" href="product1.php?#product1-3">蛋糕</a>
                                    </div>
                                </li>
                                <li class="nav-item dropdown ">
                                    <a class="nav-link" href="product2.php" id="navbarDropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                                        手工點心&emsp;&emsp;
                                                        </a>
                                    <div class="dropdown-menu ">
                                        <a class="dropdown-item" href="product2.php?#product2-1">堅果塔</a>
                                        <a class="dropdown-item" href="product2.php?#product2-2">雪Q餅</a>
                                        <a class="dropdown-item" href="product2.php?#product2-3">酥點類</a>
                                    </div>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link" href="market.php" id="navbarDropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                                            前往購物&emsp;&emsp;
                                                        </a>
                                </li>
                                <?php if ($totalRows_rs_check == 0) { // Show if recordset empty ?>
                                <li> <a class="nav-link" href="login.php" id="navbarDropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="far fa-user"></i>會員登入&emsp;&emsp; </a></li>
                                <?php } // Show if recordset empty ?>
                                
                            <?php if ($totalRows_rs_check > 0) { // Show if recordset not empty ?>
                                <li>
                                <a class="nav-link " href="<?php echo $logoutAction ?>" id="navbarDropdown " role="button " aria-haspopup="true " aria-expanded="false ">
                                <i class="far fa-user "></i> Hi!<?php echo $row_rs_check['name']; ?>，點我登出&emsp;&emsp;
                                </a>
                                </li>
                                <?php } // Show if recordset not empty ?>

                            <?php if ($totalRows_rs_check > 0) { // Show if recordset not empty ?>
                                    <li>
                                    <a class="nav-link " href="member.php" id="navbarDropdown " role="button " aria-haspopup="true " aria-expanded="false ">
                                        <i class="fas fa-user-tag"></i>會員管理&emsp;&emsp;
                                    </a>
                                </li>
                                <?php } // Show if recordset not empty ?>

                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </header>

        <!-- 為在第1層beam的下面，裡面包section，放置主要內容 -->

        <div class="container billheight">
            <section>
                <form action="<?php echo $editFormAction; ?>" method="POST" name="form2" id="form2">
                    <div class="carList card w-80">                 
                    <div class="carTitle">訂單確認</div>   
                     
                      <table>
                        <tr>
                          <th width="20%">產品名稱</th>
                          <th>單價</th>
                          <th>數量</th>
                          <th>金額</th>
                         
                        </tr>

                        <!-- 購物車重複區域開始 -->
                        
                        <?php
                        if($cart->itemcount > 0) {
                            foreach($cart->get_contents() as $item) {
                        ?>
                        <tr>
                          <td name="product_name"><input type="hidden" name="itemid[]" id="itemid[]" value="<?php echo $item['id'];?>">
                            <?php echo $item['info'];?></td>
                          <td name="product_price"><?php echo $item['price'];?></td>
                          <td><?php echo $item['qty'];?>個 </td>
                          <td><?php echo $item['subtotal'];?></td>
                          
                        </tr>
                        <?php
                            }
                        }
                        ?>
                        <!-- 購物車重複區域結束 -->
                         
                   
                      </table>
                     
                     
                        <hr style="height:1px;border:none;border-top:2px solid #555555;">

                        <div id="sobtotal">小計:<?php echo $cart->total;?></div>
                        <div id="shipping">運費:<?php echo $cart->deliverfee;?></div>
                        <div id="total">總金額:<?php echo $cart->grandtotal;?></div>
                        
                         <hr style="height:1px;border:none;border-top:2px solid
                        #555555;">

                        
                        <div class="info">
                        <input name="member_id" id="member_id" type="hidden" value="<?php echo $row_rs_check['member_id']; ?>">
                        <input name="account" id="account" type="hidden" value="<?php echo $row_rs_check['account']; ?>">
                        <input name="date" id="date" type="hidden" value="<?php echo $date= date("Y/m/d H:i:s"); ?>">
                        <input name="shipping" id="shipping" type="hidden" value="<?php echo $cart->deliverfee;?>">
                        <input name="subprice" id="subprice" type="hidden" value="<?php echo $cart->total;?>">
                        <input name="totalprice" id="totalprice" type="hidden" value="<?php echo $cart->grandtotal;?>">
                        <div class="carTitle">客戶資訊</div>
                        <br><p>請確認客戶資訊內容</p>
                            <div class="input-group input-group-sm mb-3">
                              
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="">帳號ID</span>
                                    <?php echo $row_rs_check['account']; ?>
                                </div>
                            </div>
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="">姓名</span>
                                </div>
                                <input name="name" type="text" class="form-control" value="<?php echo $row_rs_check['name']; ?>" aria-label="Sizing 
                                  example input">
                            </div>
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="">聯絡電話</span>
                                </div>
                                <input name="phonenumber" type="phonenumber"
                                    class="form-control" value="<?php echo $row_rs_check['phonenumber']; ?>" aria-label="Sizing
                                    example input">
                            </div>
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="">寄送地址</span>
                                </div>
                                <input name="address" type="text"
                                    class="form-control" value="<?php echo $row_rs_check['address']; ?>" aria-label="Sizing
                                    example input">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="btn col-sm-12 col-md-6 col-lg-5">
                                <button type="button" class="btn btn-warning btn-lg" onclick="location.href='bill.php'">回購物車修改</button>
                                <input name="itemcount" type="hidden" value="<?php echo $cart->itemcount;?>">  
                            </div>                   
                                                           
                            <div class="btn col-sm-12 col-md-6 col-lg-4">
                                <button type="submit" class="btn btn-danger btn-lg">送出訂單</button>
                            </div>
                        </div>
                        <input type="hidden" name="MM_insert" value="form2">                    
                </form>    
            </section>

        </div>

        <footer style="position: fixed; bottom: 0;width: 100%;">
            <div class="row">
                <div class="col-sm-12 col-md-4 col-lg-4"
                    style="background-color:
                    #E7B483;padding-top:1rem; padding-left:1rem;">
                    <ui class="text" style="list-style-type:none">
                        <li>&nbsp;<i class="fas fa-phone-volume"></i>&nbsp;(049)2318661</li>
                        <li>&nbsp;<i class="fas fa-mobile-alt"></i>&nbsp;&nbsp;0934318661</li>
                        <li><i class="fas fa-home"></i>&nbsp;(542)南投縣草屯鎮敦和路72-6號(敦和國小旁)</li>
                    </ui>
                </div>
                <div class="col-sm-12 col-md-4 col-lg-4" id="wordtextboxcenter"
                    style="background-color: #E7B483;padding-top:1rem;">

                    <label for="exampleFormControlInput1">訂閱電子報</label>
                    <br>
                    <div class="input-group text" id="textboxcenter">
                        <input type="email" class="form-control-sm"
                            placeholder="Email address" aria-label="Recipient 's
                            username" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-outline-primary"
                                type="button">OK</button>
                        </div>
                    </div>

                </div>
                <div class="col-sm-12 col-md-4 col-lg-4 footerlogo"
                    style="background-color:#E7B483;
                    padding-top:1rem; padding-left: 1rem">

                    <img style="margin:3% 5% 7% 0%;" class="img-responsive"
                        src="img/iglogo.png" alt="iglogo">
                    <img style="margin:3% 5% 7% 0%;" class="img-responsive"
                        src="img/facebooklogo.png" alt="facebooklogo">
                    <img style="margin:3% 5% 7% 0%;" class="img-responsive"
                        src="img/linelogo.png" alt="linelogo">
                </div>
            </div>
        </footer>
        <script src="js/jquery-3.4.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>

</html>



<?php
mysql_free_result($rs_check);
?>
