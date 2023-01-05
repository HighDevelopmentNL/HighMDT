<?php
    require "header.php";
    if (!$_SESSION['loggedin']) {
        Header("Location: login");
    }
    if ($_SESSION["role"] != "admin") {
        Header("Location: dashboard");
    }
    $respone = false;
    if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['type'] == "create") {
        $insert = $con->query("INSERT INTO laws (name,description,fine,months) VALUES('".$con2->real_escape_string($_POST['naam'])."','".$con2->real_escape_string($_POST['beschrijving'])."',".$con2->real_escape_string($_POST['boete']).",".$con2->real_escape_string($_POST['celstraf']).")");
        if ($insert) {
            $respone = true;
            $result = $con->query("SELECT * FROM laws ORDER BY celstraf ASC");
            $laws_array = [];
            while ($data = $result->fetch_assoc()) {
                $laws_array[] = $data;
            }
        }
    } elseif ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['type'] == "edit") {
        $update = $con->query("UPDATE laws SET name = '".$con2->real_escape_string($_POST['naam'])."', description = '".$con2->real_escape_string($_POST['beschrijving'])."', fine = ".$con2->real_escape_string($_POST['boete']).", months = ".$con2->real_escape_string($_POST['celstraf'])." WHERE id = ".$_POST['lawid']);
        if ($update) {
            $respone = true;
        } else {
            $response = false;
        }
    } elseif ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['type'] == "delete") {
        $sql = "DELETE FROM laws WHERE id = ".$con2->real_escape_string($_POST['lawid']);
        if ($con->query($sql)) {
            $respone = true;
        } else {
            echo "Error deleting record: " . mysqli_error($conn);
            exit();
        }
    }
    if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['type'] == "editlaw") {
        $query = $con->query("SELECT * FROM laws WHERE id = ".$con2->real_escape_string($_POST['lawid']));
        $selectedlaw = $query->fetch_assoc();
    } elseif  ($_SERVER['REQUEST_METHOD'] != "POST" || $_SERVER['REQUEST_METHOD'] == "POST" && $_POST['type'] != "addlaw" && $_POST['type'] != "editlaw"){
        $result = $con->query("SELECT * FROM laws ORDER BY name ASC");
        $laws_array = [];
        while ($data = $result->fetch_assoc()) {
            $laws_array[] = $data;
        }
    }
    $name = explode(" ", $_SESSION["name"]);
    $firstname = $name[0];
    $last_word_start = strrpos($_SESSION["name"], ' ') + 1;
    $lastname = substr($_SESSION["name"], $last_word_start);
?>
                <?php
                    if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['type'] == "editlaw") {
                ?>
                    <div class="law-add">
                        <h5 class="panel-container-title">Wijzig straf</h5>
                        <form method="post">
                            <input type="hidden" name="type" value="edit">
                            <input type="hidden" name="lawid" value="<?php echo $selectedlaw['id']; ?>">
                            <div class="input-group mb-3">
                                <input type="text" name="naam" class="form-control login-user" value="<?php echo $selectedlaw['name']; ?>" placeholder="naam" required>
                            </div>
                            <?php $beschrijving = str_replace( "<br />", '', $selectedlaw['description']); ?>
                            <div class="input-group mb-2">
                                <textarea name="beschrijving" class="form-control" placeholder="beschrijving" required><?php echo $beschrijving ?></textarea>
                            </div>
                            <div class="input-group mb-3">
                                <input type="number" min="0" name="boete" class="form-control login-user" value="<?php echo $selectedlaw['months']; ?>" placeholder="boete" required>
                            </div>
                            <div class="input-group mb-3">
                                <input type="number" min="0" name="celstraf" class="form-control login-user" value="<?php echo $selectedlaw['fine']; ?>" placeholder="celstraf" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="create" class="btn btn-primary btn-police w-100">WIJZIG</button>
                            </div>
                        </form>
                        <form method="post">
                            <input type="hidden" name="type" value="delete">
                            <input type="hidden" name="lawid" value="<?php echo $selectedlaw['id']; ?>">
                            <div class="form-group">
                                <button type="submit" name="create" style="width:100%!important" class="btn btn-danger">STRAF VERWIJDEREN</button>
                            </div>
                        </form>
                    </div>
                <?php
                    } elseif ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['type'] == "addlaw") {
                ?>
                    <div class="law-add">
                        <h5 class="panel-container-title">Voeg straf toe</h5>
                        <form method="post">
                            <input type="hidden" name="type" value="create">
                            <div class="input-group mb-3">
                                <input type="text" name="naam" class="form-control login-user" value="" placeholder="naam" required>
                            </div>
                            <div class="input-group mb-2">
                                <textarea name="beschrijving" class="form-control" value="" placeholder="beschrijving" required></textarea>
                            </div>
                            <div class="input-group mb-3">
                                <input type="number" min="0" name="boete" class="form-control login-user" value="" placeholder="boete" required>
                            </div>
                            <div class="input-group mb-3">
                                <input type="number" min="0" name="celstraf" class="form-control login-user" value="" placeholder="celstraf" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="create" class="btn btn-primary btn-police w-100">VOEG TOE</button>
                            </div>
                        </form>
                    </div>
                <?php
                    } else {
                ?>
                    <!-- <div class="law-list"> -->
                        

                        
                        <?php if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['type'] == "create" && $respone) {?>
                            <?php echo "<p style='color: #13ba2c;'>Straf toegevoegd!</p>"; ?>
                        <?php } ?>
                        <?php if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['type'] == "edit" && $respone) {?>
                            <?php echo "<p style='color: #13ba2c;'>Straf gewijzigd!</p>"; ?>
                        <?php } ?>
                        <?php if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['type'] == "delete" && $respone) {?>
                            <?php echo "<p style='color: #13ba2c;'>Straf verwijderd!</p>"; ?>
                        <?php } ?>
                        <div class="lawlist-search">
                            <form method="post">
                                <input type="hidden" name="type" value="addlaw">
                                <div class="form-group">
                                    <button type="submit" name="addlaw" class="btn btn-pol btn-md my-0 ml-sm-2">STRAF TOEVOEGEN</button>
                                </div>
                            </form>
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Zoeken</span>
                                </div>
                                <input type="text" class="lawsearch form-control" aria-label="Zoeken" aria-describedby="inputGroup-sizing-sm">
                            </div>
                        </div>
                        <div class="row">
                        <?php foreach($laws_array as $law){?>
                            <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3">
                            <form method="post">
                                <input type="hidden" name="type" value="editlaw">
                                <input type="hidden" name="lawid" value="<?php echo $law['id']; ?>">
                                <button style="width:100%;" type="submit" class="law-item" data-toggle="tooltip" data-html="true" title="<?php echo $law['description']; ?>">
                                    <h5 class="lawlist-title"><?php echo $law['name']; ?></h5>
                                    <p class="lawlist-fine">Boete: €<?php echo $law['fine']; ?></p>
                                    <p class="lawlist-months">Cel: <?php echo $law['months']; ?> maanden</p>
                                </button>
                            </form>
                            </div>
                        <?php }?>
                        </div>
                    <!-- </div> -->
                <?php
                    }
                ?>
            </div>
<?php

include("footer.php");
?>