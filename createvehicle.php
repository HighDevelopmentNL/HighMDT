<?php
    require "header.php";
    if (!$_SESSION['loggedin']) {
        Header("Location: login");
    }

    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        if ($_GET["type"] == "editvehicle") {
            $vehicleid = $_GET['vehicleid'];
            $get_vehicle = $con2->query("SELECT plate, info FROM $vehicles_db WHERE id = '$vehicleid'");
            while ($vehicles = $get_vehicle->fetch_object()){
            
                $info = json_decode($vehicles->info, true);
                $note = isset($info['note']) ? $info['note'] : ' ';
                $apk = isset($info['apk']) ? $info['apk'] : ' ';
                $wok = isset($info['wok']) ? $info['wok'] : ' ';
                $warrant = isset($info['warrant']) ? $info['warrant'] : ' ';
            }
        }
    }
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if ($_POST["type"] == "realedit") {
            $vehicleid = $_POST['vehicleid'];

            $updated_note = $_POST['note'];
            $updated_apk = $_POST['apk'];
            $updated_wok = $_POST['wok'];
            $updated_warrant = $_POST['warrant'];

            $updated = array("note"=>$updated_note, "apk"=>$updated_apk, "wok"=>$updated_wok, "warrant"=>$updated_warrant);
            $updated_data = json_encode($updated);
            $update = $con2->query("UPDATE $vehicles_db SET info = '$updated_data' WHERE id = '$vehicleid'");
            // die(var_dump($update));
             // doorvoeren in dashboard
            $query = $con2->query("SELECT * FROM $vehicles_db WHERE id = '$vehicleid'");
            $selectedvehicle = $query->fetch_assoc();    
                
            $citizenid = $selectedvehicle["citizenid"];
            $profile_data = $con2->query("SELECT charinfo FROM $player_db WHERE citizenid = '$citizenid'");
            while ($players = $profile_data->fetch_object()){
                $name = json_decode($players->charinfo, true);
                $firstname_owner = isset($name['firstname']) ? $name['firstname'] : ' ';
                $lastname_owner = isset($name['lastname']) ? $name['lastname'] : ' ';
            }

            // $con->query("INSERT INTO vehicles (citizenid, fullname, plate, note) VALUES ('".$citizenid."', '".$lastname_owner."', '".$platenr."', '".$updated_note."')");
            if ($update) {
                $_SESSION["vehicleid"] = $_POST['vehicleid'];
                redirect("vehicles?type=showvehicle&vehicleid=".$vehicleid);
                // echo '<meta http-equiv="refresh" content="0;url=vehicles?type=show&vehicleid=62">';
                // exit();
            }
        }
    }
    $name = explode(" ", $_SESSION["name"]);
    $firstname = $name[0];
    $last_word_start = strrpos($_SESSION["name"], ' ') + 1;
    $lastname = substr($_SESSION["name"], $last_word_start);

    if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['type'] == "realedit") {
        Header("Location: vehicles");
    }
?>

        <main role="main" class="container">
            <div class="content-introduction">
                <h3>Voertuig Bewerken</h3>
                <p class="lead">Hier kun je een voertuig bewerken.<br />Je kunt hier een notitie toevoegen aan <?=$platenr;?>. Tevens kun je een voertuig signaleren.</p>
            </div>
            <div class="createprofile-container">
                <div class="createprofile-left">
                <?php if ($_SERVER['REQUEST_METHOD'] == "GET" && $_GET['type'] == "editvehicle") { ?>
                    <form method="POST">
                        <input type="hidden" name="type" value="realedit">
                        <input type="hidden" name="vehicleid" value="<?php echo $vehicleid; ?>">
                        <div class="input-group mb-3">
                            <input type="text" name="note" class="form-control login-user" value="<?php echo $note; ?>" placeholder="notitie...">
                        </div>
                        <div class="form-check">
                            <input type="hidden" name="apk" value="0">
                            <input class="form-check-input" type="checkbox" value="1" name="apk" <?php if(trim($apk) == '1') echo 'checked = "checked"' ?>>
                            <label class="form-check-label">
                                APK
                            </label>
                        </div>
                        <div class="form-check">
                            <input type="hidden" name="wok" value="0">
                            <input class="form-check-input" type="checkbox" value="1" name="wok" <?php if(trim($wok) == '1') echo 'checked = "checked"' ?>>
                            <label class="form-check-label">
                                WOK
                            </label>
                        </div>
                        <div class="form-check mb-4">
                            <input type="hidden" name="warrant" value="0">
                            <input class="form-check-input" type="checkbox" value="1" name="warrant" <?php if(trim($warrant) == '1') echo 'checked = "checked"' ?>>
                            <label class="form-check-label">
                                GESIGNALEERD
                            </label>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-police">Bewerk voertuig</button>
                        </div>
                    </form>
                <?php } ?>
                </div>
            </div>
        </main>
        <?php include("footer.php"); ?>