<?php require_once('Connections/conn_bettysmom.php'); ?>
<?php
//加入購物車Class的宣告
require_once('cart/EDcart.php');
session_start();
$cart =& $_SESSION['edCart']; 
if(!is_object($cart)) $cart = new edCart(); 
?>

<?php unset($_SESSION['edCart'])?>

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

$colname_rs_success = "-1";
if (isset($_SESSION['OrderID'])) {
  $colname_rs_success = $_SESSION['OrderID'];
}
mysql_select_db($database_conn_bettysmom, $conn_bettysmom);
$query_rs_success = sprintf("SELECT * FROM bill WHERE bill_id = %s", GetSQLValueString($colname_rs_success, "int"));
$rs_success = mysql_query($query_rs_success, $conn_bettysmom) or die(mysql_error());
$row_rs_success = mysql_fetch_assoc($rs_success);
$totalRows_rs_success = mysql_num_rows($rs_success);

$colname_rs_successdetail = "-1";
if (isset($_SESSION['OrderID'])) {
  $colname_rs_successdetail = $_SESSION['OrderID'];
}
mysql_select_db($database_conn_bettysmom, $conn_bettysmom);
$query_rs_successdetail = sprintf("SELECT * FROM billdetail WHERE bill_id = %s", GetSQLValueString($colname_rs_successdetail, "int"));
$rs_successdetail = mysql_query($query_rs_successdetail, $conn_bettysmom) or die(mysql_error());
$row_rs_successdetail = mysql_fetch_assoc($rs_successdetail);
$totalRows_rs_successdetail = mysql_num_rows($rs_successdetail);
?>

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
            <link rel="stylesheet" href="css/success.css">
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
                                <img src="img/logo180.png" alt="" class="navbar-brand">
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
                                    <?php if ($totalRows_rs_success == 0) { // Show if recordset empty ?>
                                    <li>
                                        <a class="nav-link" href="login.php" id="navbarDropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="far fa-user"></i>會員登入&emsp;&emsp; </a>
                                    </li>
                                    <?php } // Show if recordset empty ?>

                                    <?php if ($totalRows_rs_success > 0) { // Show if recordset not empty ?>
                                    <li>
                                        <a class="nav-link " href="<?php echo $logoutAction ?>" id="navbarDropdown " role="button " aria-haspopup="true " aria-expanded="false ">
                                            <i class="far fa-user "></i> Hi!
                                            <?php echo $row_rs_success['name']; ?>，點我登出&emsp;&emsp;
                                        </a>
                                    </li>
                                    <?php } // Show if recordset not empty ?>

                                    <?php if ($totalRows_rs_success > 0) { // Show if recordset not empty ?>
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
            <div class="container" style="height:780px;">
                <section >
                    <div class="list">
                        <div class="header">
                            <h2>感謝您的訂購</h2>
                            <h3>完成訂購請於3日內於指定帳戶匯款，收到款項後將盡速為您準備訂單</h3>
                        </div>
                        <div class="main" >
                            <h4>訂購人資訊</h4> 
                            <div class="info" style="background-color:#FFF99D;">                                 
                                <table>
                                        <td width="100"><b>訂購日期:</b></td>
                                        <td width="400"><?php echo $row_rs_success['date']; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="100"><b>訂單編號:</b></td>
                                        <td width="400"><?php echo $row_rs_success['bill_id']; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="100"><b>姓名:</b></td>
                                        <td width="400"><?php echo $row_rs_success['name']; ?></td>
                                    </tr>
                                    <tr>                          
                                        <td width="100"><b>聯絡電話:</b> </td>
                                        <td width="400"><?php echo $row_rs_success['phonenumber']; ?></td>
                                    </tr>
                                    <tr>    
                                        <td width="100"><b>寄送地址:</b></td>
                                        <td width="400"><?php echo $row_rs_success['address']; ?></td>
                                    </tr>                                   
                                </table>
                            </div>
                            <br>
                            <h4>訂單內容</h4>
                            <div class="bill"  style="background-color:#FFF99D;">
                                <table>
                                    <tr>
                                        <th>產品名稱</th>
                                        <th>單價</th>
                                        <th>數量</th>
                                        <th>金額</th>
                                    </tr>
                                    <?php do { ?>
                                    <tr>
                                        <td name="product_name">
                                            <?php echo $row_rs_successdetail['product_name']; ?>
                                        </td>
                                        <td name="product_price">
                                            <?php echo $row_rs_successdetail['product_price']; ?>
                                        </td>
                                        <td name="quantity">
                                            <?php echo $row_rs_successdetail['quantity']; ?>個</td>
                                        <td>
                                        <script>  
                                            sum= <?php echo $row_rs_successdetail['product_price']; ?>*<?php echo $row_rs_successdetail['quantity']; ?>;
                                            document.write(sum);      
                                        </script>
                                        </td>
                                    </tr>
                                    <?php } while ($row_rs_successdetail = mysql_fetch_assoc($rs_successdetail)); ?>
                                </table>

                                <hr style="height:1px;border:none;border-top:1px dashed #555555;">
                                <table>
                                    <tr>
                                        <td colspan="3">小計:
                                            <?php echo $row_rs_success['subprice']; ?>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>

                                    </tr>
                                    <tr>
                                        <td colspan="3">運費:
                                            <?php echo $row_rs_success['shipping']; ?>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>

                                    </tr>
                                    <tr>
                                        <td colspan="4">總金額:
                                            <?php echo $row_rs_success['totalprice']; ?>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td>&nbsp;</td>

                                    </tr>
                                </table>
                            </div>
                            <div style="text-align: center;">
                            <button type="button" class="btn btn-info btn-lg" onclick="location.href='index.php'">回首頁</button>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
           
            <footer>
                <div class="row">
                    <div class="col-sm-12 col-md-4 col-lg-4" style="background-color:
                            #E7B483;padding-top:1rem; padding-left:1rem;">
                        <ui class="text" style="list-style-type:none">
                            <li>&nbsp;<i class="fas fa-phone-volume"></i>&nbsp;(049)2318661</li>
                            <li>&nbsp;<i class="fas fa-mobile-alt"></i>&nbsp;&nbsp;0934318661</li>
                            <li><i class="fas fa-home"></i>&nbsp;(542)南投縣草屯鎮敦和路72-6號(敦和國小旁)</li>
                        </ui>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4" id="wordtextboxcenter" style="background-color: #E7B483;padding-top:1rem;">
                        <label for="exampleFormControlInput1">訂閱電子報</label>
                        <br>
                        <div class="input-group text" id="textboxcenter">
                            <input type="email" class="form-control-sm" placeholder="Email
                                    address" aria-label="Recipient 's username" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-outline-primary" type="button">OK</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4 footerlogo" style="background-color:#E7B483; padding-top:1rem; padding-left: 1rem;">

                        <img style="margin:3% 5% 7% 0%;" class="img-responsive" src="img/iglogo.png" alt="iglogo">
                        <img style="margin:3% 5% 7% 0%;" class="img-responsive" src="img/facebooklogo.png" alt="facebooklogo">
                        <img style="margin:3% 5% 7% 0%;" class="img-responsive" src="img/linelogo.png" alt="linelogo">
                    </div>
                </div>
            </footer>
            <script src="js/jquery-3.4.1.min.js"></script>
            <script src="js/bootstrap.min.js"></script>
        </body>
        
</html>

<?php
mysql_free_result($rs_success);
mysql_free_result($rs_successdetail);
?>

