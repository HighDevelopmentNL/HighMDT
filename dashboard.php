<?php
    include("header.php");
?>
					<!-- Row start -->
					<div class="row gutters">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							
							<div class="card primary" style="margin-bottom:0">
								<div class="card-header">
									<ul class="nav nav-tabs primary" id="myTab7" role="tablist">
										<li class="nav-item">
											<a class="nav-link active" id="home-tab7" data-toggle="tab" href="#home7" role="tab" aria-controls="home7" aria-selected="true"><i class="icon-home2 block"></i>Home</a>
										</li>
									</ul>
								</div>
								<div class="card-body pt-0">
									<div class="tab-content" id="myTabContent7">
										<div class="tab-pane fade show active" id="home7" role="tabpanel" aria-labelledby="home-tab7">
											<p>
											
					<div class="row gutters">
						<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
							<div class="notify info">
								<div class="notify-body">
									<span class="type"><?php echo $dash_recentreports; ?></span>
                                    <div id="report_results"></div>          
                                    </div>
							</div>
						</div>
						<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
							<div class="notify danger">
								<div class="notify-body">
									<span class="type"><?php echo $dash_recentvehicles; ?></span>
                                    <div id="vehicle_results"></div>
                				</div>
							</div>
						</div>
						<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
							<div class="notify success">
								<div class="notify-body">
									<span class="type"><?php echo $dash_recentsearched; ?></span>
                                    <div id="search_results"></div>
                                </div>
							</div>
						</div>
					</div>
				<script>
                $(document).ready(function() {
                    refreshData();
                });

                function refreshData() {
                    $('#search_results').load('assets/ajax/data_reqz.php');
                    $('#vehicle_results').load('assets/ajax/data_reqv.php');
				    $('#report_results').load('assets/ajax/data_reqr.php');
                    setTimeout(refreshData, 1700);
                }
				</script>
										</p>
										</div>
										<div class="tab-pane fade" id="profile7" role="tabpanel" aria-labelledby="profile-tab7">
											<p>
											
									</div>
								</div>
							</div>

						</div>
					</div>
					<!-- Row end -->
        <!-- <main role="main" class="container"> -->
					<!-- Row start -->
<?php
include("footer.php");
?>