<?php
require "../../requires/config.php";
require "../../assets/php/vnames.php";
if (!$_SESSION['loggedin']) {
    Header("Location: login");
}
$vehicles = $con2->query("SELECT * FROM $vehicles_db WHERE info LIKE '%warrant\": \"1%'");
$recentvehicles_array = [];
while ($data = $vehicles->fetch_assoc()) {
    $recentvehicles_array[] = $data;
}
if (!empty($recentvehicles_array)) {
    foreach ($recentvehicles_array as $vehicle) {
        // echo var_dump($vehicle); 
?>
<form method="GET" action="vehicles">
    <input type="hidden" name="type" value="show">
    <input type="hidden" name="vehicleid" value="<?php echo $vehicle['id']; ?>">
    <button type="submit" class="btn btn-panel panel-item" style="text-align:left!important;">
        <?php if (!empty(json_decode($vehicle['info'])->note)) { ?>
        <h5 class="panel-title"><?php echo $vehicle['plate']; ?> -
            <?php echo '<small>' . json_decode($vehicle['info'])->note . '</small>'; ?>
        </h5>
        <?php } else { ?>
        <h5 class="panel-title"><?php echo $vehicle['plate']; ?></h5>
        <?php } ?>
        <p class="panel-author"><?php echo replaceCars($vehicle['vehicle']); ?></p>
    </button>
</form>
<?php } ?>
<?php } else { ?>
<p>Geen Gesignaleerde voertuigen..</p>
<?php } ?>