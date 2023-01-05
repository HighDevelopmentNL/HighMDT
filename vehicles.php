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

<?php if ($_SERVER['REQUEST_METHOD'] == "GET" && $_GET['type'] == "showvehicle" && !empty($selectedvehicle)) { 
?>
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <!-- BEGIN .Custom-header -->
            <header class="custom-banner">
                <div class="row gutters">
                    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                        <div class="welcome-msg">
                            <div class="welcome-user-thumb">
                                <img src="./img/car.svg" alt="car" width="150" height="150"/>
                            </div>
                            <div class="welcome-title">
                            <?php echo replaceCars($selectedvehicle["vehicle"]); ?> (<?php echo $selectedvehicle["plate"]; ?>)
                            </div>
                            <div class="welcome-email">
                            <p><strong><?php echo $veh_owner;?>:</strong><br /><?php echo $firstname_owner . " " . $lastname_owner; ?></p>
                            <p><strong><?php echo $veh_bsno;?>:</strong><br /><?php echo $selectedvehicle["citizenid"]; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-8 col-md-16 col-sm-16 col-16">
                        <div class="row gutters user-plans justify-content-center">

                        <div class="profile-reports-panel">
        <div class="profile-lastincidents">
            <form style="float:right; margin-left: 1vw;">
                <a style="margin-left:0!important;" class="btn <?php if(trim($apk) == '1') echo 'btn-success' ?><?php if(trim($apk) == '0') echo 'btn-danger' ?> btn-md my-0 ml-sm-2 text-white">
                <?php echo $veh_apk;?>: <?php if(trim($apk) == '1') echo $veh_yes; ?><?php if(trim($apk) == '0') echo $veh_no; ?>
                </a>
                <a style="margin-left:0!important;" class="btn <?php if(trim($wok) == '1') echo 'btn-success' ?><?php if(trim($wok) == '0') echo 'btn-danger' ?> btn-md my-0 ml-sm-2 text-white">
                <?php echo $veh_wok;?>: <?php if(trim($wok) == '1') echo $veh_yes; ?><?php if(trim($wok) == '0') echo $veh_no; ?>
                </a>
                <a style="margin-left:0!important;" class="btn <?php if(trim($warrant) == '1') echo 'btn-success' ?><?php if(trim($warrant) == '0') echo 'btn-danger' ?> btn-md my-0 ml-sm-2 text-white">
                <?php echo $veh_wanted;?>: <?php if(trim($warrant) == '1') echo $veh_yes; ?><?php if(trim($warrant) == '0') echo $veh_no; ?>
                </a>
            </form><br /><br />
            <form method="GET" action="createvehicle" class="mb-4">
        <input type="hidden" name="type" value="editvehicle">
        <input type="hidden" name="vehicleid" value="<?php echo $selectedvehicle['id']; ?>">
        <br>
        <button type="submit" class="btn-info btn"><?php echo $veh_edit; ?></button>
    </form>
        </div>
    </div>
                        </div>
                    </div>
                    
            </header>
<?php } else { ?>
    <div class="row gutters">
        <div class="col-12">
            <div class="notify info">
                <div class="notify-body">
                    <span class="type"><?php echo $veh_head;?></span>
                        <main role="main" class="container"><?php echo $veh_info;?>
                            <div class="profile-container">
                                <div class="profile-search">
                                <?php if ($_SERVER['REQUEST_METHOD'] == "GET" && $_GET['type'] == "showvehicle") { ?>
                                    <form method="GET" action="createvehicle" class="mb-4">
                                        <input type="hidden" name="type" value="edit">
                                        <input type="hidden" name="vehicleid" value="<?php echo $selectedvehicle['id']; ?>">
                                        <button type="submit" class="btn btn-pol btn-md my-0 ml-sm-2"><?php echo $veh_edit;?></button>
                                    </form>
                                <?php } ?>
                                    <br>
                                    <form method="GET" class="form-inline ml-auto">
                                        <input type="hidden" name="type" value="searchvehicle">
                                        <div class="input-group w-100">
                                            <input class="form-control" name="search" type="text" placeholder="Zoek een voertuig.." aria-label="Search">     
                                            <div>
                                                <button type="submit" class="btn btn-primary btn-police ml-2"><?php echo $gen_search;?></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </main>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    
    <?php } ?>
    <?php if ($_SERVER['REQUEST_METHOD'] == "GET" && $_GET['type'] == "searchvehicle") { ?>
        <div class="notify danger">
            <div class="notify-body">
            <span class="type"><?php echo $veh_foundvehicles; ?></span>
            <div class="panel-list">
                <?php if (empty($search_array)) { ?>
                    <p><?php echo $veh_none; ?></p>
                <?php } else { ?>
                    <div class="row">
                    <?php foreach($search_array as $vehicle) {?>
                        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3">
                        <form method="GET">
                            <input type="hidden" name="type" value="showvehicle">
                            <input type="hidden" name="vehicleid" value="<?php echo $vehicle['id']; ?>">
                            <button type="submit" class="btn btn-panel panel-item">
                                <h5 class="panel-title"><?php echo $vehicle['vehicle'] . " - " . $vehicle['plate']; ?></h5>
                                <p>
                                <?php
                                    $citizenid = $vehicle["citizenid"];
                                    $profile_data = $con2->query("SELECT charinfo FROM players WHERE citizenid = '$citizenid'");
                                    while ($players = $profile_data->fetch_object()){
                                        $name = json_decode($players->charinfo, true);
                                        $firstname_owner = isset($name['firstname']) ? $name['firstname'] : ' ';
                                        $lastname_owner = isset($name['lastname']) ? $name['lastname'] : ' ';
                                    }
                                ?></p>
                                <p class="panel-author"><?php echo $veh_owner; ?>: <?php echo $firstname_owner . " " .$lastname_owner; ?></p>
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