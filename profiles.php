<?php
include("header.php");
if ($_SERVER['REQUEST_METHOD'] == "GET" && $_GET['type'] == "showprofile" && !empty($selectedprofile)) { 
?>
        <!-- Row start -->
					<div class="row gutters">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							
							<!-- BEGIN .Custom-header -->
							<header class="custom-banner">
								<div class="row gutters">
									<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
										<div class="welcome-msg">
											<div class="welcome-user-thumb">
											</div>
											<div class="welcome-title">
                                            <?php echo $profile_info["firstname"]; ?> <?php echo $profile_info["lastname"]; ?>
											</div>
											<div class="welcome-title">
                                                <?php echo $gen_bsn; ?>: <?php echo $selectedprofile["citizenid"]; ?>
											</div>
										</div>
									</div>
                                    <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
										<div class="row gutters user-plans justify-content-center">
                                            <p style="color:#fff; font-size:19px;">
                                            <?php echo $gen_finger; ?>: <?php echo $meta_info["fingerprint"]; ?><br />
                                            Slijm DNA: <?php echo $meta_info["slimecode"]; ?><br />
                                            Haircode: <?php echo $meta_info["haircode"]; ?><br />
										</div>
									</div>
								</div>
							</header>
							<!-- END: .Custom-header -->

						</div>
					</div>
					<!-- Row end -->

                    <div class="profile-reports-panel">
                        <div class="profile-lastincidents">
                            <div class="row">
                                <div class="col-md-6 col-sm-12 mb-2">
                                    <form method="POST" action="createreport">
                                        <input type="hidden" name="type" value="createnew">
                                        <input type="hidden" name="profileid" value="<?php echo $selectedprofile['citizenid']; ?>">
                                        <button type="submit" style="margin-left:0!important;" class="btn btn-success btn-md my-0 ml-sm-2 w-100"><?php echo $gen_newport; ?></button>
                                    </form>
                                </div>
                                
                                <div class="col-md-6 col-sm-12 mb-2">
                                    <form method="POST" action="createwarrant">
                                        <input type="hidden" name="type" value="create">
                                        <input type="hidden" name="profileid" value="<?php echo $selectedprofile['citizenid']; ?>">
                                        <button type="submit" style="margin-left:0!important;" class="btn btn-danger btn-md my-0 ml-sm-2 w-100"><?php echo $gen_newwarrant; ?></button>
                                    </form>
                                </div>
                            
                            </div>

                            
					<div class="row gutters">
						<div class="col-md-6 col-sm-12">
							<div class="notify info">
								<div class="notify-body">
									<span class="type"><?php echo $gen_latestreports; ?> <?php if (!empty($reports_array)) { echo '('.count($reports_array).')'; }?></span>
                                    <?php if (empty($reports_array)) { ?>
                                    <p><?php echo $gen_noreports; ?></p>
                                <?php } else { ?>
                                    <?php foreach($reports_array as $report) {?>
                                        <form method="GET" action="reports">
                                            <input type="hidden" name="type" value="showreport">
                                            <input type="hidden" name="reportid" value="<?php echo $report['id']; ?>">
                                            <button type="submit" class="btn btn-panel panel-item">
                                                <h5 class="panel-title">#<?php echo $report['id']; ?> <?php echo $report['title']; ?></h5>
                                                <p class="panel-author"><?php echo $gen_by; ?>: <?php echo $report['author']; ?></p>
                                            </button>
                                        </form>
                                    <?php }?>
                                <?php } ?>
                                    </div>
							</div>
						</div>
                        
						<div class="col-md-6 col-sm-12">
							<div class="notify danger">
								<div class="notify-body">
									<span class="type"><?php echo $profiles_vehicleshead; if (!empty($vehicle_array)) { echo '('.count($vehicle_array).')'; }?></span>
                                    <?php if (empty($vehicle_array)) { ?>
                                    <p><?php echo $gen_novehicles; ?></p>
                                <?php } else { ?>
                                    <?php foreach($vehicle_array as $vehicle) {?>
                                        <form method="GET" action="vehicles">
                                            <input type="hidden" name="type" value="showvehicle">
                                            <input type="hidden" name="vehicleid" value="<?php echo $vehicle['id']; ?>">
                                            <button type="submit" class="btn btn-panel panel-item">
                                                <h5 class="panel-title"><?php echo replaceCars($vehicle['vehicle']); ?></h5>
                                                <p class="panel-author"><?php echo $gen_plate; ?>: <?php echo $vehicle['plate']; ?></p>
                                            </button>
                                        </form>
                                    <?php }?>
                                <?php } ?>
                				</div>
							</div>
						</div>
                    </div>
                <?php } else { ?>
                    
					<div class="row gutters">
						<div class="col-12">
							<div class="notify info">
								<div class="notify-body">
									<span class="type"><?php echo $profiles_head; ?></span>
                                        <main role="main" class="container"><?php echo $profiles_info; ?>
                                            
                                            <div class="profile-container">
                                                <div class="profile-search mb-2">
                                                <br>
                                                    <form method="GET" class="form-inline ml-auto">
                                                        <input type="hidden" name="type" value="searchprofile">
                                                        <div class="input-group w-100">
                                                            <input class="form-control" name="search" type="text" placeholder="Zoek een persoon.." aria-label="Search">     
                                                            <div>
                                                                <button type="submit" class="btn btn-primary btn-police ml-2"><?php echo $gen_search; ?></button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                    <?php if ($_SERVER['REQUEST_METHOD'] != "GET" || $_SERVER['REQUEST_METHOD'] == "GET" && $_GET['type'] != "showprofile") { ?>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                     </div>
                <?php if ($_SERVER['REQUEST_METHOD'] == "GET" && $_GET['type'] == "searchprofile") { ?>
                    <div class="notify danger">
                    <div class="notify-body">
                    <span class="type"><?php echo $gen_foundperson; ?></span>
                        <div class="panel-list">
                            <?php if (empty($search_array)) { ?>
                                <p><?php echo $gen_nopersonsfound; ?></p>
                            <?php } else { ?>
                                <div class="row">
                                <?php foreach($search_array as $person) {
                                    
                                    $charinfo = json_decode($person['charinfo'], true);
                                    ?>
                                    <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3">
                                    <form method="GET">
                                        <input type="hidden" name="type" value="showprofile">
                                        <input type="hidden" name="personid" value="<?php echo $person['citizenid']; ?>">
                                        <button type="submit" class="btn btn-panel panel-item">
                                            <h5 class="panel-title"><?php echo "" . $charinfo['firstname'] . " " . $charinfo['lastname'] . ""; ?></h5>
                                            <p class="panel-author"><?php echo $gen_bsn; ?>: <?php echo $person['citizenid']; ?></p>
                                        </button>
                                    </form>
                                    </div>
                                <?php }?>
                                </div>
                            <?php } ?>
                        </div>
                        </div>
                    </div>
                <?php } ?>
                <?php } ?>
            </div>
        </main>
        <!-- <script src="assets/js/jquery-3.3.1.slim.min.js"></script>
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/main.js"></script>
        <script src="assets/js/car-replace-names.js"></script>
    </body>
</html> -->
<?php
include("footer.php");
?>