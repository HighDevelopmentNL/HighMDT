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
                <?php if ($_SERVER['REQUEST_METHOD'] == "GET" && $_GET['type'] == "showreport" && !empty($selectedreport)) { ?>
                    
                    <div class="row">
                        <?php if ($lawdata != NULL) {?>
                            <!-- <h5 class="report-laws-title">Opgelegde straffen:</h5> -->
                            <?php foreach($lawdata as $law){?>
                                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3">
                                    <div class="law-item" data-toggle="tooltip" data-html="true" title="<?php echo $law['description']; ?>">
                                        <h5 class="lawlist-title"><?php echo $law['name']; ?></h5>
                                        <p class="lawlist-fine"><?php echo $reports_boete; ?>: €<?php echo $law['fine']; ?> <?php echo $reports_celstraf; ?>: <?php echo $law['months']; ?> <?php echo $reports_months; ?></p>
                                    </div>
                                </div>
                            <?php }?>
                        <?php } ?>
                    <div class="col-12 mb-3">
                        <form method="GET" action="createreport" class="d-inline" style="float:right; margin-left: 1vw;">
                            <input type="hidden" name="type" value="editreport">
                            <input type="hidden" name="reportid" value="<?php echo $selectedreport['id']; ?>">
                            <button type="submit" class="btn btn-success btn-md my-0 ml-sm-2"><?php echo $reports_aanpassen; ?></button>
                        </form>
                            <?php if ($_SESSION["role"] == "admin") { ?>
                        <form method="GET" action="reports" class="d-inline" style="float:right;">
                            <input type="hidden" name="type" value="deletereport">
                            <input type="hidden" name="reportid" value="<?php echo $selectedreport['id']; ?>">
                            <button type="submit" class="btn btn-danger btn-md my-0 ml-sm-2"><?php echo $reports_verwijder; ?></button>
                        </form>
                        <?php } ?>
                    </div>
                    <div class="col-12">
                        <div class="report-show">
                            <h4 class="report-title"><?php echo $selectedreport["title"]; ?></h4>
                            <?php if ($profiledata != NULL) { $profile_info = json_decode($profiledata['charinfo'], true); ?>
                                <p><?php echo $reports_prsn; ?>: <strong><a href="./profiles?type=showprofile&personid=<?php echo $profiledata["citizenid"]; ?>"><?php echo $profile_info["firstname"]; ?> <?php echo $profile_info["lastname"]; ?></a></strong> (<?php echo $gen_by; ?>: <?php echo $profiledata["citizenid"]; ?>)
                            <?php } ?>
                            <hr>
                            <p class="report-description"><?php echo $selectedreport["report"]; ?></p>
                            <p class="report-author"><i><?php echo $reports_writtenby; ?>: <?php echo $selectedreport["author"]; ?></i></p>
                        </div>
                    </div>
                <?php } else {
                ?>
                <div class="row gutters">
                    <div class="col-12">
                        <div class="notify info">
                            <div class="notify-body">
                                <span class="type"><?php echo $reports_reports; ?></span>
                                <main role="main" class="container"><?php echo $reports_info; ?>
                                    <div class="profile-container">
                                        <div class="profile-search">
                                            <br>
                                            <form method="GET" class="form-inline ml-auto">
                                                <input type="hidden" name="type" value="search">
                                                <div class="input-group w-100">
                                                    <input class="form-control" name="search" type="text" placeholder="Zoek een report.." aria-label="Search">     
                                                    <div>
                                                        <button type="submit" class="btn btn-primary btn-police ml-2"><?php echo $gen_search; ?></button>
                                                    </div>
                                                </div>
                                            </form>
                                            <?php if ($_SERVER['REQUEST_METHOD'] != "GET" || $_SERVER['REQUEST_METHOD'] == "GET" && $_GET['type'] != "showreport") { ?>
                                            <?php }?>
                                        </div>
                                    </div>
                                </main>
                            </div>
		                </div>
                        <? } ?>
                    <?php if ($_SERVER['REQUEST_METHOD'] == "GET" && $_GET['type'] == "searchreport") { ?>
                    <div class="notify danger">
                        <div class="notify-body">
                        <span class="type"><?php echo $gen_foundperson; ?></span>
                            <div class="panel-list">
                            <?php if (empty($search_array)) { ?>
                                <p><?php echo $gen_noreports; ?></p>
                            <?php } else { ?>
                                <div class="row">
                                <?php foreach($search_array as $report) {?>
                                    <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3">
                                    <form method="GET">
                                        <input type="hidden" name="type" value="showreport">
                                        <input type="hidden" name="reportid" value="<?php echo $report['id']; ?>">
                                        <button type="submit" class="btn btn-panel panel-item">
                                            <h5 class="panel-title">#<?php echo $report['id']; ?> <?php echo $report['title']; ?></h5>
                                            <p class="panel-author"><?php echo $gen_by; ?>: <?php echo $report['author']; ?></p>
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
            <!-- </div> -->
<?php
    include("footer.php");
?>