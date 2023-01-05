<?php
    require "header.php";
    if (!$_SESSION['loggedin']) {
        Header("Location: login");
    }
    $response = false;
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if ($_POST['type'] == "show") {
            $query = $con->query("SELECT * FROM warrants WHERE id = ".$con->real_escape_string($_POST['warrantid'])."");
            $selectedwarrant = $query->fetch_assoc();
            $profile = $con2->query("SELECT * FROM players WHERE citizenid = '".$con->real_escape_string($selectedwarrant["citizenid"])."'");
            $profieldata = $profile->fetch_assoc();

        } elseif ($_POST['type'] == "delete") {
            $sql = "DELETE FROM warrants WHERE id = ".$con->real_escape_string($_POST['warrantid']);
            if ($con->query($sql)) {
                $response = true;
            } else {
                echo "Error deleting record: " . mysqli_error($con);
                exit();
            }
        }
    }
    $result = $con->query("SELECT * FROM warrants ORDER BY created DESC");
    $warrant_array = [];
    while ($data = $result->fetch_assoc()) {
        $profile = $con2->query("SELECT * FROM players WHERE citizenid = '".$con->real_escape_string($data["citizenid"])."'");
        $profiledata = $profile->fetch_assoc();
        $data["naam"] = $profiledata["fullname"];
        $warrant_array[] = $data;
    }
    $name = explode(" ", $_SESSION["name"]);
    $firstname = $name[0];
    $last_word_start = strrpos($_SESSION["name"], ' ') + 1;
    $lastname = substr($_SESSION["name"], $last_word_start);
?>
<div class="row">
    <!-- <div class="warrants-container"> -->
    <div class="col-lg-4 warrants-list">
        <?php if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST["type"] == "delete" && $response) { ?>
            <p style='color: #13ba2c;'><?php echo $war_removed; ?></p>
        <?php } ?>
        <?php if (empty($warrant_array)) { ?>
            <p><?php $war_none;?></p>
        <?php } else { ?>
            <?php foreach($warrant_array as $warrant) {?>
                <form method="post">
                    <input type="hidden" name="type" value="show">
                    <input type="hidden" name="warrantid" value="<?php echo $warrant["id"]; ?>">
                    <button type="submit" class="btn warrant-item">
                        <h5 class="warrant-title"><?php echo $warrant["title"]; ?> - <?php echo $warrant["title"]; ?></h5>
                        <p class="warrant-author"><?php echo $war_by; ?>: <?php echo $warrant["author"]; ?></p>
                        <?php
                            $datetime = new DateTime($warrant["created"]);
                            echo '<p class="warrant-author">'.$war_date.': '.$datetime->format('d/m/y H:i').'</p>';
                        ?>
                    </button>
                </form>
            <?php } ?>
        <?php } ?>
    </div>
    <div class="col-lg-8  warrant-report">
        <?php if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST["type"] == "show") { ?>
        <div class="report-show">
            <h4 class="report-title"><?php echo $selectedwarrant["title"]; ?></h4>
            <p><?php echo $war_person; ?>: <?php echo $profieldata["citizenid"]; ?> (citizenid: <?php echo $profieldata["citizenid"]; ?>)</p>
            <hr>
            <strong><?php echo $war_desc; ?>:</strong>
            <p class="report-description"><?php echo $selectedwarrant["description"]; ?></p>
            <p class="report-author"><i><?php echo $war_writtenby; ?>: <?php echo $selectedwarrant["author"]; ?></i></p>
        </div>
        <form method="post">
            <input type="hidden" name="type" value="delete">
            <input type="hidden" name="warrantid" value="<?php echo $warrant["id"]; ?>">
            <div class="form-group">
                <button type="submit" style="margin-top: 1vh; float: right;" name="create" class="btn btn-danger"><?php $war_remove;?></button>
            </div>
        </form>
    </div>
        <?php } else { ?>
    <div class="content-introduction">
        <h3><?php echo $war_head; ?></h3>
        <p class="lead"><?php echo $war_info; ?></p>
    </div>
        <?php } ?>
</div>
<!-- </div> -->

<?php
include("footer.php");
?>