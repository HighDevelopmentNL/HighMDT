<?php
    require "header.php";
    if (!$_SESSION['loggedin']) {
        Header("Location: login");
    }
    $result = $con->query("SELECT * FROM laws ORDER BY months ASC");
    $laws_array = [];
    while ($data = $result->fetch_assoc()) {
        $laws_array[] = $data;
    }
    $respone = false;
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if ($_POST['type'] == "create") {
            // print($_POST["profileid"]);
            // $query9 = $con2->query("SELECT * FROM players WHERE citizenid = ".$_POST["profileid"]);
            // $selectedprofile = $query9->fetch_assoc();
            // print('jaja');
        } elseif ($_POST['type'] == "createreal") {
            $description = nl2br($_POST["beschrijving"]);
            $insert = $con->query("INSERT INTO warrants (citizenid,description,title,author) VALUES('".$con2->real_escape_string($_POST['bsn'])."','".$con2->real_escape_string($description)."','".$con2->real_escape_string($_POST['titel'])."','".$con2->real_escape_string($_POST['author'])."')");
            if ($insert) {
                $last_id = $con->insert_id;
                //$_SESSION["reportid"] = $last_id;
                $respone = true;
                //header('Location: reports');
            }
        }
    }
    $name = explode(" ", $_SESSION["name"]);
    $firstname = $name[0];
    $last_word_start = strrpos($_SESSION["name"], ' ') + 1;
    $lastname = substr($_SESSION["name"], $last_word_start);
?>
    <div class="row">
        <main role="main" class="container">
            <div class="content-introduction">
                <h3><?php echo $war_head; ?></h3>
                <p class="lead"><?php echo $war_info; ?></p>
            </div>
            <?php if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['type'] == "create") { ?>
                <form method="POST">
                    <input type="hidden" name="type" value="createreal">
                    <input type="hidden" name="author" class="form-control login-pass" value="<?php echo $_SESSION["name"]; ?>" placeholder="" required>
                    <div class="input-group mb-3">
                        <input type="text" name="titel" class="form-control login-user" value="" placeholder="<?php echo $cc_title; ?>" required>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" name="bsn" class="form-control login-user" value="<?php echo $_POST["profileid"]; ?>" placeholder="BSN" required>
                    </div>
                    <div class="input-group mb-2">
                        <textarea name="beschrijving" class="form-control" value="" placeholder="<?php echo $war_desc; ?>" required></textarea>
                    </div>
                    <div class="form-group">
                        <br>
                        <button type="submit" name="create" class="btn btn-primary btn-police w-100"><?php echo $war_create; ?></button>
                    </div>
                </form>
            <?php } ?>
        </main>
    </div>
<?php
include("footer.php");
?>