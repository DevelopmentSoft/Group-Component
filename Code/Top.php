<?php require_once "Session.php"?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <!-- site metas -->
    <title>jackpiro</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- bootstrap css -->
    <link rel="stylesheet" href="../EWSDcoursework/Layout/mainpage/css/bootstrap.min.css">
    <!-- style css -->
    <link rel="stylesheet" href="../EWSDcoursework/Layout/mainpage/css/style.css">
    <!-- Responsive-->
    <link rel="stylesheet" href="../EWSDcoursework/Layout/mainpage/css/responsive.css">
    <!-- fevicon -->
    <link rel="icon" href="../EWSDcoursework/Layout/mainpage/images/fevicon.png" type="image/gif" />
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="../EWSDcoursework/Layout/mainpage/css/jquery.mCustomScrollbar.min.css">
    <!-- Tweaks for older IEs-->
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
</head>
<!-- body -->

<body class="main-layout">

    <!-- end loader -->
    <!-- header -->
    <header>
        <!-- header inner -->
        <div class="header-top">
            <div class="header" style="background-color:#050318;">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col logo_section">
                            <div class="full">
                                <div class="center-desk">
                                    <div class="logo">
                                        <a href="index.html"><label style="font-size:35px;color:#fff;">EWSD</label></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9">

                                        <ul class="top_icon">
                                        <?php
	if(!empty($login_name)){
                                            echo "<li class='username'><label style='font-size:30px;color:#fff;'>$login_name<label></li>";
                                        }
                                        else{
                                            echo "<li class='username'><label style='font-size:30px;color:#fff;'><label></li>";
                                        }
                                        ?>
                                        </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end header inner -->

            <!-- end header -->
            <section class="slider_section">
                <div class="banner_main">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-2 padding_left0">
                                <div class="menu-area">
                                <div class="limit-box">
                                    <nav class="main-menu">
                                        <ul class="menu-area-main">
                                        <!-- Here need make change for two page-->
										<?php
                    if(!empty($login_session)){
                      $sql = "SELECT ID FROM contribution_tb WHERE SubBy = '$login_session' LIMIT 1";
                                                          $result = mysqli_query($conn, $sql);
                                                          $row = mysqli_fetch_assoc($result);
                    }

										if(!empty($login_name)){
                                            if($login_type == "student"){
                                                echo "<li class='active'><a href='index.php#txtarea'>Student Form</a></li>";
                                                 echo"<li class='active'><a href='Faculty.php#txtarea'>Faculty</a></li>";
                                                echo"<li class='active'><a href='#Profile_Form'>Profile</a></li>";
                                                if (!empty($row["ID"])) {
                                echo "<li class='active'><a href='Contribution.php?Cid=" . $row["ID"] . "'>My Contribution</a></li>";
                                }
                                            }
                                            // Admin/Coordinator/Manager
                                            else if ($login_type == "coordinator" || $login_type == "admin" || $login_type == "Manager"){
                                                if($login_type == "Manager"){
                                                    echo"<li class='active'><a href='Manager.php#txtarea'>Faculties</a></li>";
                                                }
                                                else if($login_type == "admin")
                                                {
                                                    echo"<li class='active'><a href='Admin.php#txtarea'>Admin</a></li>";
                                                }
                                                else{
                                                    echo"<li class='active'><a href='Faculty.php#txtarea'>My Faculty</a></li>";
                                                    echo"<li class='active'><a href='Register.php#txtarea'>Student Management</a></li>";
                                                }
                                            }
                                            echo"<li class='active'> <a href='Logout.php'>Logout</a></li>";
                                        }
										else{
											echo"<li class='active'> <a href='Login.php'>Login</a></li>";
										}
                                           ?>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 " style="background-color:#050318;">

                            </div>
                             <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 ">
                                <div class="text-img">
                                   <figure><img  src="../EWSDcoursework/Layout/mainpage/images/book.jpg" alt="#"/></figure>
                                   <div class="text-bg" style="position: absolute;top: 50%;left: 50%;
                                   transform: translate(-50%, -50%);">

                                   <!-- Here need make change for two page-->
                                   <?php
                                   if(!empty($login_name)){
                                        if($login_type == "student"){
//                                            echo "<h1>Welcome,<br>$login_name</h1>";
                                            echo "<h1>Welcome,<br>Student</h1>";
                                        }
                                        else{
                                            echo "<h1>Welcome,<br>$login_type</h1>";
                                        }
                                   }
                                   else{
                                       echo "<h1>Welcome,<br>User</h1>";
                                   }
                                   ?>
                                    <span>Please key in the detail or information that showed below<br> Thank You!!!</span>
<!--                                    <a href="#txtarea">Form</a>-->
                                </div>

                                </div>
                            </div>


                        </div>
                    </div>
                </div>

           </section>
        </div>
    </header>





</body>

</html>
