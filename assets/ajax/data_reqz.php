<?php
    require "../../requires/config.php";
    if (!$_SESSION['loggedin']) {
        Header("Location: login");
    }
    $profiles = $con2->query("SELECT citizenid, charinfo, lastsearch FROM $player_db ORDER BY lastsearch DESC LIMIT 5");
    $recentsearch_array = [];
    while ($data = $profiles->fetch_assoc()) {
        $recentsearch_array[] = $data;
    }
    $name = explode(" ", $_SESSION["name"]);
    $firstname = $name[0];
    $last_word_start = strrpos($_SESSION["name"], ' ') + 1;
    $lastname = substr($_SESSION["name"], $last_word_start);
?>
<?php if(!empty($recentsearch_array)) { 
    ?>
                                        <?php foreach($recentsearch_array as $person) {
    $profile_info = json_decode($person['charinfo'], true);?>
                                            <form method="GET" action="profiles">
                                                <input type="hidden" name="type" value="showprofile">
                                                <input type="hidden" name="personid" value="<?php echo $person['citizenid']; ?>">
                                                <button type="submit" class="btn btn-panel panel-item" style="text-align:left!important;">
                                                    <h5 class="panel-title"><?php echo $profile_info['firstname'] ." ". $profile_info['lastname']; ?></h5>
                                                    <p class="panel-author"><?php echo $gen_bsn; ?>: <?php echo $person['citizenid']; ?></p>
                                                </button>
                                            </form>
                                        <?php }?>
                                    <?php } else { ?>
                                            <p>Geen personen opgezocht..</p>
<?php } ?>