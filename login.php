<?php
    require "requires/config.php";
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (trim($_POST['username']) == NULL) {
            Header("Location:login?error");
        }
        if (trim($_POST['password']) == NULL) {
            Header("Location:login?error");
        }        
        $query = $con2->query("SELECT * FROM characters_metadata WHERE username = '".$_POST['username']."' AND web_pass = '".$_POST['password']."'");
        if ($query->num_rows == 1) {
            $row = $query->fetch_assoc();
			$jobdata = json_decode($row['job'], true);
			echo $jobdata['label'];
			$user_data = json_decode($row['charinfo'], true);
			$passwordd = $con2->real_escape_string($POST['password']);
			if ($jobdata['label'] == 'Politie'){
					$_SESSION['id'] = $row['citizenid'];
					$_SESSION['name'] = $user_data['lastname'];
					$_SESSION['rank'] = $jobdata['gradelabel'];
					if ($jobdata['isboss'] == true){
						$_SESSION["role"] = 'admin';
					} else {
						$_SESSION["role"] = 'agent';
					}
					$_SESSION['loggedin'] = true;
					$_SESSION["personid"] = NULL;
					$_SESSION["reportid"] = NULL;
					$con2->query("UPDATE characters_metadata SET last_login = '".date('Y-m-d')."' WHERE citizenid = '".$row['citizenid']."'");
					if ($_SERVER['HTTP_REFFER'] != "") {
						header('Location: ' . $_SERVER['HTTP_REFERER']);
					} else {
						Header("Location: dashboard");
					}
            } else {
                Header("Location: login?error");
            }
        } else {
            Header("Location: login?error");
        }
    }
?>

<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Meta -->
		<meta name="description" content="">
		<meta name="author" content="HighDevelopment. Theme by ParkerThemes official licensed">
		<link rel="shortcut icon" href="img/fav.png" />

		<!-- Title -->
		<title>Meos</title>
		
		<!-- *************
			************ Common Css Files *************
			************ -->
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="css/bootstrap.min.css" />

		<!-- Master CSS -->
		<link rel="stylesheet" href="css/main.css" />

	</head>

	<body class="authentication">

		<!-- Container start -->
		<div class="container">
			
        <form method="post">
				<div class="row justify-content-md-center">
					<div class="col-xl-4 col-lg-5 col-md-6 col-sm-12">
						<div class="login-screen">
							<div class="login-box">
								<a href="#" class="login-logo">
									<span class="text-danger">Q</span><span class="text-warning">u</span><span class="text-success">a</span><span class="text-info">c</span><span class="text-royal-orange">k</span> <span class="text-jungle-green">M</span><span class="text-jungle-warning">e</span><span class="text-jungle-error">o</span><span class="text-jungle-info">s</span>
								</a>
                                
                                <?php if (isset($_GET['error'])) { ?>
                                <p style="color:#9f1010;">Verkeerde inlog gegevens!</p>
                                <?php } ?>
								<div class="form-group">
									<input type="text" name="username" class="form-control" placeholder="Gebruikersnaam" />
								</div>
								<div class="form-group">
									<input type="password"  name="password" class="form-control" placeholder="Wachtwoord" />
								</div>
								<div class="actions">
									<!-- <a href="forgot-pwd.html">Recover password</a> -->
									<button type="submit" class="btn btn-info">Inloggen</button>
								</div>
								<div class="m-0">
									<!-- <span class="additional-link">No account? <a href="signup.html">Signup Now</a></span> -->
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>

		</div>
		<!-- Container end -->

	</body>
</html>