<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
    require "requires/config.php";
	
    if (!$_SESSION['loggedin']) {
        Header("Location: login");
    }
    $profiles = $con2->query("SELECT * FROM $player_db ORDER BY lastsearch DESC LIMIT 5");
    $recentsearch_array = [];
    while ($data = $profiles->fetch_assoc()) {
        $recentsearch_array[] = $data;
    }
    $reports = $con->query("SELECT * FROM reports ORDER BY created DESC LIMIT 5");
    $recentreports_array = [];
    while ($data = $reports->fetch_assoc()) {
        $recentreports_array[] = $data;
    }
    $vehicles = $con->query("SELECT * FROM vehicles ORDER BY lastsearch DESC LIMIT 5");
    $recentvehicles_array = [];
    while ($data = $reports->fetch_assoc()) {
        $recentvehicles_array[] = $data;
    }
    $name = explode(" ", $_SESSION["name"]);
    $firstname = $name[0];
    $last_word_start = strrpos($_SESSION["name"], ' ') + 1;
    $lastname = substr($_SESSION["name"], $last_word_start);
	require "assets/php/vnames.php";

    $pg = basename(substr($_SERVER['PHP_SELF'],0,strrpos($_SERVER['PHP_SELF'],'.')));
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Meta -->
		<meta name="description" content="">
		<meta name="author" content="HighDevelopment. Theme by ParkerThemes official licensed">
		<link rel="shortcut icon" href="img/fav.png" />

		<!-- Title -->
		<title>Meos</title>
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="fonts/style.css">
		<link rel="stylesheet" href="css/main.css">
		<link rel="stylesheet" href="vendor/daterange/daterange.css" />

        <style>
        .material-icons {
            font-size: 1.8rem !important;
        }
        </style>

        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="./assets/js/car-replace-names.js"></script>
	</head>
	<body>
		<div class="container">
			<header class="header">
				<div class="row gutters">
					<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-6">
                        <a href="./dashboard" class="logo">
							<?php echo $webname; ?>
						</a>
					</div>
					<div class="col-xl-8 col-lg-8 col-md-6 col-sm-6 col-6">
						<ul class="header-actions">
							<li class="dropdown">
								<a href="#" id="userSettings" class="user-settings" data-toggle="dropdown" aria-haspopup="true">
									<span class="user-name"><?php echo $firstname; ?></span>
									<span class="avatar">DF<span class="status online"></span></span>
								</a>
								<div class="dropdown-menu dropdown-menu-right" aria-labelledby="userSettings">
									<div class="header-profile-actions">
										<a href="logout.php"><i class="icon-log-out1"></i> Uitloggen</a>
									</div>
								</div>
							</li>
						</ul>						
					</div>
				</div>
			</header>
			<nav class="navbar navbar-expand-lg custom-navbar">
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#retailAdminNavbar" aria-controls="retailAdminNavbar" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon">
						<i></i>
						<i></i>
						<i></i>
					</span>
				</button>
				<div class="collapse navbar-collapse" id="retailAdminNavbar">
					<ul class="navbar-nav m-auto">
                        <li class="nav-item">
							<a class="nav-link <?php if($pg == 'dashboard'){?>active-page<?php }?>" href="dashboard">
                            <i class="nav-icon"><span class="material-icons">home</span></i>
							<?php echo $menu_dashboard; ?>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link <?php if($pg == 'profiles' || $pg == 'createprofile'){?>active-page<?php }?>" href="profiles">
                            <i class="nav-icon"><span class="material-icons">person</span></i>
							<?php echo $menu_citizens; ?>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link <?php if($pg == 'reports' || $pg == 'createreport'){?>active-page<?php }?>" href="reports">
                            <i class="nav-icon"><span class="material-icons">summarize</span></i>
							<?php echo $menu_reports; ?>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link <?php if($pg == 'vehicles' || $pg == 'createvehicle'){?>active-page<?php }?>" href="vehicles">
                            <i class="nav-icon"><span class="material-icons">directions_car</span></i>
							<?php echo $menu_vehicles; ?>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link <?php if($pg == 'houses'){?>active-page<?php }?>" href="houses">
                            <i class="nav-icon"><span class="material-icons">maps_home_work</span></i>
							<?php echo $menu_houses; ?>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link <?php if($pg == 'warrants' || $pg == 'createwarrant'){?>active-page<?php }?>" href="warrants">
                            <i class="nav-icon"><span class="material-icons">travel_explore</span></i>
							<?php echo $menu_warrents; ?>
							</a>
						</li>
						<?php if ($_SESSION["role"] == "admin") { ?>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle <?php if($pg == 'laws' || $pg == 'users'){?>active-page<?php }?>" href="#" id="appsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="nav-icon"><span class="material-icons">settings</span></i>
							<?php echo $menu_admin; ?>
							</a>
							<ul class="dropdown-menu dropdown-menu-right" aria-labelledby="appsDropdown">
								<li>
									<a class="dropdown-item" href="laws"><?php echo $menu_laws; ?></a>
								</li>
							</ul>
						</li>
						<?php } else {  } ?>
					</ul>
				</div>
			</nav>
			<div class="main-container">
				<div class="page-title">
					<div class="row gutters">
						<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
							<h5 class="title"><?php echo $dash_welcome . $_SESSION["rank"] . " " . $firstname; ?></h5>
						</div>
					</div>
				</div>
				<div class="content-wrapper" style="min-height: 300px;">

