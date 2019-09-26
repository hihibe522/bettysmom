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

$colname_rs_product2 = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_rs_product2 = $_SESSION['MM_Username'];
}
mysql_select_db($database_conn_bettysmom, $conn_bettysmom);
$query_rs_product2 = sprintf("SELECT * FROM member WHERE account = %s", GetSQLValueString($colname_rs_product2, "text"));
$rs_product2 = mysql_query($query_rs_product2, $conn_bettysmom) or die(mysql_error());
$row_rs_product2 = mysql_fetch_assoc($rs_product2);
$totalRows_rs_product2 = mysql_num_rows($rs_product2);
?>
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

</head>

<body>

    <!-- beam為在第1層的梁 -->
    <div class="beam" id="product2-1">
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
                            <?php if ($totalRows_rs_product2 == 0) { // Show if recordset empty ?>
                              <li> <a class="nav-link" href="login.php" id="navbarDropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="far fa-user"></i>會員登入&emsp;&emsp; </a></li>
                              <?php } // Show if recordset empty ?>
                            
                            <?php if ($totalRows_rs_product2 > 0) { // Show if recordset not empty ?>
                            <li>
                            <a class="nav-link " href="<?php echo $logoutAction ?>" id="navbarDropdown " role="button " aria-haspopup="true " aria-expanded="false ">
                            <i class="far fa-user "></i> Hi!<?php echo $row_rs_product2['name']; ?>，點我登出&emsp;&emsp;
                            </a>
                            </li>
                            <?php } // Show if recordset not empty ?>

                            <?php if ($totalRows_rs_product2 > 0) { // Show if recordset not empty ?>
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
    <div class="container ">
        <section>

            <div name="producttitle " class="row " style="margin-top:2%; ">
                <h1>堅果塔</h1>
            </div>
            <hr color="#DF493F ">
            <div class="card mb-3 " style="max-width: 100%; border:0px; ">
                <div class="row no-gutters ">
                    <div class="col-md-6 col-mg-6 ">
                        <img src="img/productpage_img/IMG_1218.png " class="card-img " alt="... ">
                    </div>
                    <div class="col-md-6 col-mg-6 ">
                        <div class="card-body ">
                            <h5 class="card-title ">堅果塔</h5>
                            <p class="card-text ">嚴選新鮮飽滿堅果與果乾，手作塔皮，回歸自然風味。</p>
                            <p class="card-text "><small class="text-muted "></small></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="productbeam" id="product2-2">
            </div>

            <div class="row " style="margin-top:2%; ">
                <h1>雪Q餅</h1>
            </div>
            <hr color="#DF493F ">
            <div class="card mb-3 " style="max-width: 100%;border:0px; ">
                <div class="row no-gutters ">
                    <div class="col-md-6 col-mg-6 ">
                        <img src="img/productpage_img/IMG_1212.png " class="card-img " alt="... ">
                    </div>
                    <div class="col-md-6 col-mg-6 ">
                        <div class="card-body ">
                            <h5 class="card-title ">雪Q餅</h5>
                            <p class="card-text ">嚴選新鮮果乾與堅果，與甜蜜棉花糖交織，一塊接一塊。</p>
                            <p class="card-text "><small class="text-muted "></small></p>
                        </div>
                    </div>

                </div>
            </div>

            <div class="productbeam" id="product2-3">
            </div>

            <div name="producttitle " class="row " style="margin-top:2%; ">
                <h1>酥點類</h1>
            </div>
            <hr color="#DF493F ">
            <div class="card mb-3 " style="max-width: 100%; border:0px;" id="product2-3">
                <div class="row no-gutters ">
                    <div class="col-md-6 col-mg-6 ">
                        <img src="img/productpage_img/IMG_1210.png " class="card-img " alt="... ">
                    </div>
                    <div class="col-md-6 col-mg-6 ">
                        <div class="card-body ">
                            <h5 class="card-title ">鳳梨酥</h5>
                            <p class="card-text ">手工製作，採用新鮮鳳梨，表面更透著金黃色澤，讓餅皮散發懷舊香味。</p>
                            <p class="card-text "><small class="text-muted "></small></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3 " style="max-width: 100%;border:0px; " id="product2-2">
                <div class="row no-gutters ">
                    <div class="col-md-6 col-mg-6 ">
                        <img src="img/productpage_img/IMG_1208.png " class="card-img " alt="... ">
                    </div>
                    <div class="col-md-6 col-mg-6 ">
                        <div class="card-body ">
                            <h5 class="card-title ">蛋黃酥</h5>
                            <p class="card-text ">綿密紅豆包覆下，與現烤蛋黃搭配，香酥完美比例。</p>
                            <p class="card-text "><small class="text-muted "></small></p>
                        </div>
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

    <script src="js/jquery-3.4.1.min.js "></script>
    <script src="js/bootstrap.min.js "></script>



</body>

</html>
<?php
mysql_free_result($rs_product2);
?>
