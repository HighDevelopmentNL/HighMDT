<?php
    require "header.php";
    
    if (!$_SESSION['loggedin']) {
        Header("Location: login");
    }
    $respone = false;
    $name = explode(" ", $_SESSION["name"]);
    $firstname = $name[0];
    $last_word_start = strrpos($_SESSION["name"], ' ') + 1;
    $lastname = substr($_SESSION["name"], $last_word_start);
?>
                <?php if ($_SERVER['REQUEST_METHOD'] == "GET" && $_GET['type'] == "showhouse" && !empty($selectedHouse)) {

                                $citizenid = $selectedHouse['citizenid'];
                                $profile_data = $con2->query("SELECT charinfo FROM $player_db WHERE citizenid = '$citizenid'");
                                while ($players = $profile_data->fetch_object()){
                                  $name_owner = json_decode($players->charinfo, true);
                                  $firstname_owner = isset($name_owner['firstname']) ? $name_owner['firstname'] : ' ';
                                  $lastname_owner = isset($name_owner['lastname']) ? $name_owner['lastname'] : ' ';
                                }
                            ?>

					<div class="row gutters">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							
							<!-- BEGIN .Custom-header -->
							<header class="custom-banner">
								<div class="row gutters">
									<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
										<div class="welcome-msg">
											<div class="welcome-user-thumb">
                                                <img src="https://icons.iconarchive.com/icons/google/noto-emoji-travel-places/1024/42486-house-icon.png" alt="profile-pic" width="150" height="150" />>
											</div>
											<div class="welcome-title">
                                            <?php echo $selectedHouseInformation["label"]; ?>
											</div>
											<div class="welcome-email">
                                            <?php echo $houses_owner; ?>: <?php echo $firstname_owner . " " . $lastname_owner ?> (<?php echo $selectedHouse["citizenid"]; ?>)
											</div>
										</div>
									</div>
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-6">
										<div class="row gutters user-plans justify-content-center">
                                        <font color="white"><h2><?php echo $houses_keyholders; ?></h2><br>
                                        <?php if ($_SESSION["role"] == "admin") { ?>
                                <?php
                                    $fase1 = str_replace('"', "", $selectedHouse['keyholders']);
                                    $fase2 = substr($fase1, 1, -1);
                                    $citizenid_array = explode(',',$fase2);
                                    $columns = [];
                                    foreach ( $citizenid_array as $citizenid )   {
                                        $columns[] = "citizenid = '$citizenid'";
                                    }
                                    $keyholders_data = $con2->query("SELECT * FROM $player_db WHERE ".implode(" OR ", $columns));
                                    $keyholders_array = [];
                                    while ($data = $keyholders_data->fetch_assoc()) {
                                        $keyholders_array[] = $data;
                                    }
                                    foreach($keyholders_array as $keyholder) {
                                        $keyholders = json_decode($keyholder['charinfo'], true);
                                        echo $keyholder['citizenid'] . " | " . $keyholders['firstname'] . " " . $keyholders['lastname'] . "<br>";
                                    }
                                ?>
                    <?php } else echo $houses_onlyadmin; ?>
                                </font>
										</div>
									</div>
                                    
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-6">
										<div class="row gutters user-plans justify-content-center">
                                        <font color="white">
                                        <p><strong><?php echo $houses_location; ?>:</strong><br><?php echo 'x: ' . $enter_coords['X'] . '<br>y: ' . $enter_coords['Y'] . '<br>z: ' . $enter_coords['Z']?></p>
                                            <p>
                                <strong><?php echo $houses_garage; ?>:</strong><br>
                                <?php if(trim($selectedHouseInformation['garage']) == '[]') echo '<span class="text-danger">Nee</span>' ?>
                                <?php if(trim($selectedHouseInformation['garage']) != '[]') echo '<span class="text-success">Ja</span>' ?>
                                    </p></font>
										</div>
									</div>
								</div>
							</header>
                <?php } else { ?>

					<div class="row gutters">
						<div class="col-12">
							<div class="notify info">
								<div class="notify-body">
									<span class="type"><?php echo $houses_houses; ?></span>
                                    <main role="main" class="container"> 
                                    <?php echo $houses_info; ?>
                                    <div class="profile-container">
                                        <div class="profile-search mb-2">
                                        <br>
                                            <form method="GET" class="form-inline ml-auto">
                                                <input type="hidden" name="type" value="searchhouse">
                                                <div class="input-group w-100">
                                                    <input class="form-control" name="search" type="text" placeholder="Zoek een huis.." aria-label="Search">     
                                                    <div>
                                                        <button type="submit" class="btn btn-primary btn-police ml-2"><?php echo $gen_search; ?></button>
                                                    </div>
                                                </div>
                                            </form>
                                            </div>
                                    </main>
                                    <br>
                                    </div>
                                </div>
                </div>
                <?php } ?>
                <?php if ($_SERVER['REQUEST_METHOD'] == "GET" && $_GET['type'] == "searchhouse") { ?>

<div class="notify danger">
    <div class="notify-body">
        <span class="type"><?php echo $houses_foundhouses; ?></span>
        <?php if (empty($search_arrayhouse)) { ?>
            <p><?php echo $houses_nohouses; ?></p>
     <?php } else { ?>
        <div class="row">
        <?php foreach($search_arrayhouse as $house) {?>
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3">
        <form method="GET">
            <input type="hidden" name="type" value="showhouse">
            <input type="hidden" name="houseid" value="<?php echo $house['id']; ?>">
            <button type="submit" class="btn btn-panel panel-item">
                <h5 class="panel-title"><?php echo $house['label']; ?></h5>
                <?php
                    $citizenid = $house["citizenid"];
                    $profile_data = $con2->query("SELECT charinfo FROM $player_db WHERE citizenid = '$citizenid'");
                    while ($players = $profile_data->fetch_object()){
                      $name_owner = json_decode($players->charinfo, true);
                      $firstname_owner = isset($name_owner['firstname']) ? $name_owner['firstname'] : ' ';
                      $lastname_owner = isset($name_owner['lastname']) ? $name_owner['lastname'] : ' ';
                    }
                ?>
                <p class="panel-author"><?php echo $houses_owner; ?>: <?php echo $firstname_owner . " " . $lastname_owner ?></p>
            </button>
        </form>
        </div>
        
    <?php }?>
    </div>
<?php } ?>

</div>
</div>
<?php } ?>
            </div>
<?php
include("footer.php");
?>