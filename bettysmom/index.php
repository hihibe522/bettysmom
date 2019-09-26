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

$colname_rs_index = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_rs_index = $_SESSION['MM_Username'];
}
mysql_select_db($database_conn_bettysmom, $conn_bettysmom);
$query_rs_index = sprintf("SELECT * FROM member WHERE account = %s", GetSQLValueString($colname_rs_index, "text"));
$rs_index = mysql_query($query_rs_index, $conn_bettysmom) or die(mysql_error());
$row_rs_index = mysql_fetch_assoc($rs_index);
$totalRows_rs_index = mysql_num_rows($rs_index);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="Description" content="蓓蒂司蔓Betty's mom麵包坊，天然原料製作，提供新鮮創意手作產品、法國麵包、雪Q餅、蛋黃酥，禮盒訂購，更有行內人才知道的歐包系列。歡迎參觀選購~">
    <title>~蓓蒂司蔓Betty's mom麵包坊~</title>

    <!-- bootstraps -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- fontawesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <!-- selfset -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body style="background-image: img/indexbgc.jpg;">

    <!-- beam為在第1層的梁 -->
    <div class="beam">
    </div>

   <!-- header為第50層固定在螢幕最上方．裡面包container(使nav的寬度固定在中間)) -->
    <header>
        <div class="container">
            <nav class="navbar navbar-light navbar-expand-md justify-content-between" style="background-color: #A2D9E7;">
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
                            <?php if ($totalRows_rs_index == 0) { // Show if recordset empty ?>
                              <li> <a class="nav-link" href="login.php" id="navbarDropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="far fa-user"></i>會員登入&emsp;&emsp; </a></li>
                              <?php } // Show if recordset empty ?>
                            
                          <?php if ($totalRows_rs_index > 0) { // Show if recordset not empty ?>
                            <li>
                            <a class="nav-link " href="<?php echo $logoutAction ?>" id="navbarDropdown " role="button " aria-haspopup="true " aria-expanded="false ">
                            <i class="far fa-user "></i> Hi!<?php echo $row_rs_index['name']; ?>，點我登出&emsp;&emsp;
                            </a>
                            </li>
                            <?php } // Show if recordset not empty ?>

                          <?php if ($totalRows_rs_index > 0) { // Show if recordset not empty ?>
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
    <div class="container indexsection">
        <section>
            <div class="row" style="margin-top:2%; margin-bottom:2%;">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="img/round_1.jpg" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="img/round_2.jpg" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="img/round_3.jpg" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="img/round_4.jpg" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="img/round_5.jpg" class="d-block w-100" alt="...">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>

            <!-- 當螢幕為col-sm顯示此div(需至bootstrap更改)) -->
            <div class="row" id="threeadv">
                <img src="img/bakery_1.jpg" class="d-block w-100 mt-2" alt="">
                <img src="img/bakery_2.jpg" class="d-block w-100 mt-2" alt="">
                <img src="img/bakery_3.jpg" class="d-block w-100 mt-2 mb-2" alt="">
            </div>

            <!-- 圖片大小 寬1100 高597 -->
            <div class="card-deck" style=" margin-bottom:2%;">
                <div class="card">

                    <img src="img/adv_img/adv1.jpg" class="card-img-top " alt="... ">
                    <div class="card-body ">
                        <h5 class="card-title "><b>開幕慶活動</b></h5>
                        <p class="card-text ">蓓蒂司蔓網路商店終於來了! 即日起，不論身在台灣何地，都可以透過本賣場訂購草屯超美味的手作麵包囉~　更棒的是滿2000就有宅配免運費的優惠^0^</p>
                        <p class="card-text "><small class="text-muted ">Updated at 2019/9/20</small></p>
                    </div>
                </div>
                <div class="card ">
                    <img src="img/adv_img/adv2.jpg " class="card-img-top " alt="... ">
                    <div class="card-body ">
                        <h5 class="card-title "><b>提供各式麵包</b></h5>
                        <p class="card-text ">我們提供各種大人小孩都喜歡的口味，適合當早餐、午餐、宵夜，補足您一天滿滿需要的活力!</p>
                        <p class="card-text "><small class="text-muted ">Updated at 2019/9/9</small></p>
                    </div>
                </div>
                <div class="card ">
                    <img src="img/adv_img/adv3.jpg " class="card-img-top " alt="... ">
                    <div class="card-body ">
                        <h5 class="card-title "><b>關於我們</b></h5>
                        <p class="card-text ">草屯媽媽的手工溫度，一場與小麥、乾果在舌尖上跳舞的秘密。<br><a href="about.php">點我了解更多我們的故事。</a></p>
                        <p class="card-text "><small class="text-muted ">Updated at 2019/9/20</small></p>
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

            <a href="https://www.instagram.com/"><img style="margin:3% 5% 7% 0%; " class="img-responsive " src="img/iglogo.png " alt="iglogo "></a>
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
mysql_free_result($rs_index);
?>
