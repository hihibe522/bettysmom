<?php require_once('Connections/conn_bettysmom.php'); ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE member SET password=%s, name=%s, gender=%s, phonenumber=%s, email=%s, birthday=%s, address=%s WHERE member_id=%s",
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['gender'], "text"),
                       GetSQLValueString($_POST['phonenumber'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['birthday'], "date"),
                       GetSQLValueString($_POST['address'], "text"),
                       GetSQLValueString($_POST['member_id'], "int"));

  mysql_select_db($database_conn_bettysmom, $conn_bettysmom);
  $Result1 = mysql_query($updateSQL, $conn_bettysmom) or die(mysql_error());

  $updateGoTo = "member.php?revOK=1";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rs_revise = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_rs_revise = $_SESSION['MM_Username'];
}
mysql_select_db($database_conn_bettysmom, $conn_bettysmom);
$query_rs_revise = sprintf("SELECT * FROM member WHERE account = %s", GetSQLValueString($colname_rs_revise, "text"));
$rs_revise = mysql_query($query_rs_revise, $conn_bettysmom) or die(mysql_error());
$row_rs_revise = mysql_fetch_assoc($rs_revise);
$totalRows_rs_revise = mysql_num_rows($rs_revise);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- bootstraps -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- fontawesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <!-- selfset -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/member.css">
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
                            <?php if ($totalRows_rs_revise == 0) { // Show if recordset empty ?>
                              <li> <a class="nav-link" href="login.php" id="navbarDropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="far fa-user"></i>會員登入&emsp;&emsp; </a></li>
                              <?php } // Show if recordset empty ?>
                            
                            <?php if ($totalRows_rs_revise > 0) { // Show if recordset not empty ?>
                            <li>
                            <a class="nav-link " href="<?php echo $logoutAction ?>" id="navbarDropdown " role="button " aria-haspopup="true " aria-expanded="false ">
                            <i class="far fa-user "></i> Hi!<?php echo $row_rs_revise['name']; ?>，點我登出&emsp;&emsp;
                            </a>
                            </li>
                            <?php } // Show if recordset not empty ?>

                            <?php if ($totalRows_rs_revise > 0) { // Show if recordset not empty ?>
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
    
  <div class="container" style="margin-top: 10%;margin-bottom: 10%;">
        <section>

            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <h5 class="card-header">修改會員資料</h5>
                    <div class="card-body">
                      <form action="<?php echo $editFormAction; ?>" METHOD="POST" name="form2" id="form2">
                            <div class="form-group">
                                <p>
                                  <label for="exampleInputID">帳號ID</label>
                                </p><?php echo $row_rs_revise['account']; ?>
                              <input name="member_id" type="hidden" id="member_id" value="<?php echo $row_rs_revise['member_id']; ?>">
                            </div>
                            <div class="form-group">
                              <label for="exampleInputpassword">修改密碼</label>
                                <input type="password" name="password" class="form-control" placeholder="" value="<?php echo $row_rs_revise['password']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputname">姓名</label>
                                <input type="text" class="form-control" name="name" placeholder="" value="<?php echo $row_rs_revise['name']; ?>">
                            </div>
                            <div class="form-group">
                                性別
                                <input  <?php if (!(strcmp($row_rs_revise['gender'],"m"))) {echo "checked=\"checked\"";} ?>  type="radio" name="gender" value="m" checked>
                                男性
                                <input  <?php if (!(strcmp($row_rs_revise['gender'],"f"))) {echo "checked=\"checked\"";} ?>  type="radio" name="gender"  value="f">
                                女性
                          </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Enter email" value="<?php echo $row_rs_revise['email']; ?>" aria-describedby="emailHelp">
                                
                            </div>
                            <div class="form-group">
                                <label for="exampleInputtel">聯絡電話</label>
                                <input type="tel" name="phonenumber" class="form-control" placeholder="phone number" value="<?php echo $row_rs_revise['phonenumber']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputbirth">生日</label>
                                <input type="date" name="birthday" class="form-control" placeholder="" value="<?php echo $row_rs_revise['birthday']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputaddress">寄送地址</label>
                                <input type="text" name="address" class="form-control" placeholder="縣市/鄉鎮/路街/號" value="<?php echo $row_rs_revise['address']; ?>">
                            </div>
                            <div class="btn1">
                              <button type="reset" class="btn btn-outline-info" style="margin: 0% 5% 0% 0%; font-size:1rem; " onclick="">重設</button>
                                <button type="submit" class="btn btn-danger" style="font-size:1rem;">儲存</button>
                            </div>
                            <input type="hidden" name="MM_update" value="form2">
                        </form>
                    </div>
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

                <img style="margin:3% 5% 7% 0%; " class="img-responsive " src="img/iglogo.png " alt="iglogo ">
                <img style="margin:3% 5% 7% 0%; " class="img-responsive " src="img/facebooklogo.png " alt="facebooklogo ">
                <img style="margin:3% 5% 7% 0%; " class="img-responsive " src="img/linelogo.png " alt="linelogo ">
            </div>
        </div>
    </footer>



    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
<?php
mysql_free_result($rs_revise);
?>
