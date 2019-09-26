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
if (!isset($_SESSION)) {
  session_start();
}

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

$colname_rs_login = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_rs_login = $_SESSION['MM_Username'];
}
mysql_select_db($database_conn_bettysmom, $conn_bettysmom);
$query_rs_login = sprintf("SELECT * FROM member WHERE account = %s", GetSQLValueString($colname_rs_login, "text"));
$rs_login = mysql_query($query_rs_login, $conn_bettysmom) or die(mysql_error());
$row_rs_login = mysql_fetch_assoc($rs_login);
$totalRows_rs_login = mysql_num_rows($rs_login);
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['username'])) {
  $loginUsername=$_POST['username'];
  $password=$_POST['passwd'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "member.php";
  $MM_redirectLoginFailed = "login.php?errMsg=1";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_conn_bettysmom, $conn_bettysmom);
  
  $LoginRS__query=sprintf("SELECT account, password FROM member WHERE account=%s AND password=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $conn_bettysmom) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<?php /*start inputVar script*/ if (isset($_GET['resOK'])){ ?>
                          <script>
						  alert("恭喜!註冊帳號成功!請登入會員訂購 :)") 
                          </script>
<?php } /*end inputVar script*/ ?>
       
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>~蓓蒂司蔓Betty's mom麵包坊~</title>
    <!-- bootstraps -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- fontawesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <!-- selfset -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/member.css">

    
        
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
                            <?php if ($totalRows_rs_login == 0) { // Show if recordset empty ?>
                            <li>
                                <a class="nav-link" href="login.php" id="navbarDropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="far fa-user"></i>會員登入&emsp;&emsp;
                                </a>
                            </li> 
                            <?php $cart->empty_cart();//只要帳號資料集是空的就清空購物車 ?>
                            <?php } // Show if recordset empty ?>
                           
                            <?php if ($totalRows_rs_login > 0) { // Show if recordset not empty ?>
                                <li>
                                <a class="nav-link " href="<?php echo $logoutAction ?>" id="navbarDropdown " role="button " aria-haspopup="true " aria-expanded="false ">
                                    <i class="far fa-user "></i> Hi!<?php echo $row_rs_login['name']; ?>，點我登出&emsp;&emsp;
                                </a>
                            </li>
                            
                            <?php } // Show if recordset not empty ?>

                            <?php if ($totalRows_rs_login > 0) { // Show if recordset not empty ?>
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

    <div class="container">
        <section style="height:800px;">
            <div class="col-sm-12 col-md-12 col-lg-12" style="padding-top: 20%">
                <div class="card">
                    <h5 class="card-header">會員登入</h5>
                    <div class="card-body">
                        <form ACTION="<?php echo $loginFormAction; ?>" METHOD="POST">
                            <div class="form-group">
                                <label for="exampleInputID">帳號ID</label>
                                <input name="username" type="text" class="form-control" id="username" size="15">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputpassword">密碼</label>
                                <input name="passwd" type="password" class="form-control" id="passwd" size="15">
                            </div>
                                <?php /*start inputVar script*/ if (isset($_GET['errMsg'])){ ?>
                                <p style="text-align:center; font-size:1rem; color:red;">帳號或密碼錯誤，請重新輸入</p>
                                <?php } /*end inputVar script*/ ?>
                            <div class="btn1">
                                <button type="submit" class="btn btn-danger" style="font-size:1rem; height:35px;">登入</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="btn1">
                  <?php if ($totalRows_rs_login == 0) { // Show if recordset empty ?>
  <button class="btn btn-info" style="margin: 2% 0% 0% 0%; width:60%; height:40px; font-size:1rem;" onclick="location.href='register.php'">註冊新會員</button>
  <?php } // Show if recordset empty ?>
                </div>
            </div>
        </section>

    </div>
    <footer>
        <div class="row ">
            <div class=" col-sm-12 col-md-4 col-lg-4 " style="background-color: #E7B483;padding-top:1rem; padding-left:1rem; ">
                <ui class="text " style="list-style-type:none ">
                    <li>&nbsp;<i class="fas fa-phone-volume "></i>&nbsp;(049)2318661</li>
                    <li>&nbsp;<i class="fas fa-mobile-alt "></i>&nbsp;&nbsp;0934318661</li>
                    <li><i class="fas fa-home "></i>&nbsp;(542)南投縣草屯鎮敦和路72-6號(敦和國小旁)</li>
                </ui>
            </div>
            <div class=" col-sm-12 col-md-4 col-lg-4 " id="wordtextboxcenter" style="background-color: #E7B483;padding-top:1rem; ">

                <label for="exampleFormControlInput1 ">訂閱電子報</label>
                <br>
                <div class="input-group text " id="textboxcenter">
                    <input type="email " class="form-control-sm " placeholder="Email address " aria-label="Recipient 's username" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-outline-primary" type=" button ">OK</button>
                    </div>
                </div>

            </div>
            <div class=" col-sm-12 col-md-4 col-lg-4 footerlogo " style="background-color:#E7B483; padding-top:1rem; padding-left: 1rem">

                <a href="https://www.instagram.com/hsiangyisheng/"><img style="margin:3% 5% 7% 0%; " class="img-responsive " src="img/iglogo.png " alt="iglogo "></a>
                <img style="margin:3% 5% 7% 0%; " class="img-responsive " src="img/facebooklogo.png " alt="facebooklogo ">
                <img style="margin:3% 5% 7% 0%; " class="img-responsive " src="img/linelogo.png " alt="linelogo ">
            </div>
        </div>
    </footer>
    <script src="js/jquery-3.4.1.min.js "></script>
    <script src="js/bootstrap.min.js "></script>
</body>

</html>
<?php
mysql_free_result($rs_login);
?>
