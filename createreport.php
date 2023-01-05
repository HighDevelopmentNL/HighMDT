<?php
require "header.php";

if (!$_SESSION['loggedin']) {
    Header("Location: login");
}
$result = $con->query("SELECT * FROM laws ORDER BY name ASC");
$laws_array = [];
while ($data = $result->fetch_assoc()) {
    $laws_array[] = $data;
}
$respone = false;

// if ($_SERVER['REQUEST_METHOD'] == "GET" || $_SERVER['REQUEST_METHOD'] == "GET") {
    if ($_POST['type'] == "createnew") {
        $query = $con2->query("SELECT * FROM $player_db WHERE citizenid = '".$con2->real_escape_string($_POST["profileid"])."'");
        $selectedprofile = $query->fetch_assoc();
    } elseif ($_POST['type'] == "create") {
        $profileid = NULL;
        $lawids = array_map('intval', explode(',', $_POST["laws"]));
        array_shift($lawids);
        if (isset($_POST["citizenid"]) && $_POST["citizenid"] != "") {
            $query = $con2->query("SELECT * FROM $player_db WHERE citizenid = '" . $con->real_escape_string($_POST["citizenid"]) . "'");
            $profile = $query->fetch_assoc();
            if ($profile != NULL) {
                $profileid = $profile["citizenid"];
            }
        }
        $reportnote = nl2br($_POST["rapport"]);
        $total_fines = ($_POST["total-fine"]);
        $citizenid = $_POST["citizenid"];
        $insert = $con->query("INSERT INTO reports (title,author,profileid,report,laws,created) VALUES('" . $con->real_escape_string($_POST['titel']) . "','" . $con->real_escape_string($_POST['author']) . "','" . $con->real_escape_string($profileid) . "','" . $con->real_escape_string($reportnote) . "', '" . json_encode($lawids) . "'," . time() . ")");
        if ($insert) {
            $last_id = $con->insert_id;
            $_SESSION["reportid"] = $last_id;
            // echo "JAWEL ";
            $respone = true;
            // if ($total_fines != 0) {
            //     $invoiceid2 = rand(1, 999999);
            //     // $con2->query("INSERT INTO characters_bills (citizenid,sender,type,invoiceid,amount) VALUES('" . $citizenid . "', 'Justitie', 'police'," . $invoiceid2 . "," . $total_fines . ")");
            // }

            // redirect('reports');
        }
    } elseif ($_GET["type"] == "editreport") {
        $query = $con->query("SELECT * FROM reports WHERE id = '".$con->real_escape_string($_GET["reportid"])."'");
        $selectedreport = $query->fetch_assoc();
        $laws = json_decode($selectedreport["laws"], true);
        $lawsedit_array = [];
        $totalprice = 0;
        $totalmonths = 0;
        if (!empty($laws)) {
            foreach ($laws as $lawid) {
                $law = $con2->query("SELECT * FROM laws WHERE id = " . $con->real_escape_string($lawid));
                $selectedlaw = $law->fetch_assoc();
                $totalmonths = $totalmonths + $selectedlaw["months"];
                $totalprice = $totalprice + $selectedlaw["fine"];
                $lawsedit_array[] = $selectedlaw;
            }
        }
        $profile = $con2->query("SELECT * FROM $player_db WHERE citizenid = '" . $con2->real_escape_string($selectedreport['profileid']) . "'");
        $profiledata = $profile->fetch_assoc();
    } elseif ($_POST["type"] == "realedit") {
        $report = nl2br($_POST["report"]);
        $profile = $con2->query("SELECT * FROM $player_db WHERE citizenid = '" . $con2->real_escape_string($_POST['citizenid']) . "'");
        $profileid = 0;
        if ($profile->num_rows > 0) {
            $profiledata = $profile->fetch_assoc();
            $profileid = $profiledata['citizenid'];
        }
        $reportnote = nl2br($_POST["rapport"]);
        $update = $con->query("UPDATE reports SET title = '" . $con->real_escape_string($_POST['titel']) . "', author = '" . $con->real_escape_string($_POST['author']) . "', profileid = " . $con->real_escape_string($profileid) . ", report = '" . $con->real_escape_string($reportnote) . "', created = " . time() . " WHERE id = " . $_POST['reportid']);
        if ($update) {
            $_SESSION["reportid"] = $_POST['reportid'];
            $respone = true;
            redirect('reports');
        } else {
            $response = false;
        }
    }
// }
$name = explode(" ", $_SESSION["name"]);
$firstname = $name[0];
$last_word_start = strrpos($_SESSION["name"], ' ') + 1;
$lastname = substr($_SESSION["name"], $last_word_start);
?>

<body>
    <!-- Froala text-editor scripts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js"></script>
    <script src=" https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/3.1.0/js/froala_editor.pkgd.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/3.1.0/css/froala_editor.pkgd.min.css"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/3.1.0/css/froala_editor.min.css" rel="stylesheet">
    <script src="./assets/js/nl.js"></script>
    <style>
    .fr-box.fr-basic .fr-element.fr-view,
    .fr-wrapper.show-placeholder .fr-element.fr-view {
        font-family: 'Roboto Mono', monospace !important;
    }

    .fr-toolbar {
        border-radius: .25rem .25rem 0vh 0vh !important;
        border: 1px solid #ced4da;
    }

    .second-toolbar {
        border-radius: 0vh 0vh .25rem .25rem !important;
        border: 1px solid #ced4da;
    }

    .fr-active {
        fill: #004682 !important;
    }

    .fr-floating-btn {
        border-radius: .25em !important;
    }

    .fr-wrapper::before {
        font-family: 'Roboto Mono', monospace !important;
        text-align: left;
        position: absolute;
        width: 100%;
        z-index: 10000;
        height: fit-content;
        padding: 12.5px 25px;
        color: #FFF;
        text-decoration: none;
        background-color: transparent;
        /* background:rgba(58, 122, 176); */
        display: block;
        font-size: 14px;
        font-family: sans-serif;
    }

    .none {
        display: none;
    }

    .fr-quick-insert {
        display: none !important;
    }
    </style>
</body>
<!-- <main role="main" class="container"> -->
<div class="row">


    <div class="col-md-8 col-sm-12">
        <?php if ($_SERVER['REQUEST_METHOD'] == "GET" && $_GET['type'] == "editreport" && !empty($selectedreport)) { ?>
        <form method="POST">
            <input type="hidden" name="type" value="realedit">
            <input type="hidden" name="author" class="form-control login-pass" value="<?php echo $_SESSION["name"]; ?>"
                placeholder="" required>
            <input type="hidden" name="reportid" class="form-control login-pass"
                value="<?php echo $selectedreport["id"]; ?>" placeholder="" required>
            <div class="input-group mb-3">
                <input type="text" name="titel" class="form-control login-user"
                    value="<?php echo $selectedreport["title"]; ?>" placeholder="<?php echo $cc_title; ?>" required>
            </div>
            <?php if (!empty($profiledata)) { ?>
            <div class="input-group mb-3">
                <input type="text" name="citizenid" class="form-control login-user"
                    value="<?php echo $profiledata["citizenid"]; ?>" placeholder="<?php echo $gen_bsn; ?>" required>
            </div>
            <?php } else { ?>
            <div class="input-group mb-3">
                <input type="text" name="citizenid" class="form-control login-user" value=""
                    placeholder="<?php echo $gen_bsn; ?>">
            </div>
            <?php } ?>
            <?php $report = str_replace("<br />", '', $selectedreport["report"]); ?>
            <div class="input-group mb-2">
                <textarea id="froala-editor" name="rapport" class="form-control" value=""
                    placeholder="<?php echo $cc_report; ?>" required><?php echo $report; ?></textarea>
            </div>
            <div class="form-group">
                <button type="submit" name="create"
                    class="btn btn-primary btn-police w-100"><?php echo $reports_save; ?></button>
            </div>
        </form>
        <?php } else { ?>
        <form method="POST">
            <input type="hidden" name="type" value="create">
            <input type="hidden" name="laws" class="report-law-punishments" value="">
            <input type="hidden" name="total-fine" class="fines-law" value="">
            <input type="hidden" name="author" class="form-control login-pass" value="<?php echo $_SESSION["name"]; ?>"
                placeholder="" required>
            <div class="input-group mb-3">
                <input type="text" name="titel" class="form-control login-user" value=""
                    placeholder="<?php echo $cc_title; ?>" required>
            </div>
            <?php if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['type'] == "createnew") { ?>
            <div class="input-group mb-3">
                <input type="text" name="citizenid" class="form-control login-user"
                    value="<?php echo $selectedprofile["citizenid"]; ?>" placeholder="Koppel citizenid (mag leeg)">
            </div>
            <?php } else { ?>
            <div class="input-group mb-3">
                <input type="text" name="citizenid" class="form-control login-user" value=""
                    placeholder="<?php echo $gen_bsn; ?>">
            </div>
            <?php } ?>
            <div class="input-group mb-2">
                <textarea id="froala-editor" name="rapport" class="form-control" value="" placeholder="Rapport.."
                    required></textarea>
            </div>
            <div class="form-group">
                <button type="submit" name="create"
                    class="btn btn-primary btn-police"><?php echo $reports_save; ?></button>
            </div>
        </form>
        <?php } ?>
    </div>
    <?php if ($_SERVER['REQUEST_METHOD'] == "POST" && $_GET['type'] == "editreport" && !empty($selectedreport)) { ?>
    <div class="col-md-4 col-sm-12">
        <h5><?php echo $cc_laws; ?></h5>
        <p class="total-punishment"><?php echo $reports_total; ?>: €<?php echo $totalprice; ?> -
            <?php echo $totalmonths; ?> <?php echo $reports_months; ?></p>
        <div class="added-laws">
            <?php if (!empty($lawsedit_array)) { ?>
            <?php foreach ($lawsedit_array as $issalaw) { ?>
            <div class="report-law-item" data-toggle="tooltip" data-html="true"
                title="<?php echo $issalaw["description"]; ?>">
                <h5 class="lawlist-title"><?php echo $issalaw["name"]; ?></h5>
                <p class="lawlist-fine"><?php echo $reports_boete; ?>: €<span
                        class="fine-amount"><?php echo $issalaw["fine"]; ?></span></p>
                <p class="lawlist-months"><?php echo $reports_celstraf; ?>: <span
                        class="months-amount"><?php echo $issalaw["months"]; ?></span> <?php echo $reports_months; ?>
                </p>
            </div>
            <?php } ?>
            <?php } ?>
        </div>
    </div>
    <?php } else { ?>
    <div class="col-md-4 col-sm-12">
        <h5><?php echo $cc_laws; ?></h5>
        <p class="total-punishment"><?php echo $reports_total; ?>: €0 - 0 <?php echo $reports_months; ?></p>
        <div class="added-laws">
        </div>
    </div>
    <?php } ?>
    <!-- </div> -->

    <?php if ($_SERVER['REQUEST_METHOD'] != "POST" || $_SERVER['REQUEST_METHOD'] == "POST" && $_GET['type'] != "editreport") { ?>
    <div class="col-12">
        <button type="button" class="btn btn-primary btn-police" id="togglelaws"
            style="margin-bottom:2vh!important;">TOGGLE laws</button>
        <div class="laws">
            <div class="lawlist-search">
                <div class="input-group input-group-sm mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-sm"><?php $cc_search; ?></span>
                    </div>
                    <input type="text" class="lawsearch form-control" aria-label="Zoeken"
                        aria-describedby="inputGroup-sizing-sm">
                </div>
            </div>
            <div class="row">
                <?php foreach ($laws_array as $law) { ?>

                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3">
                    <div class="report-law-item-tab" style="width:100%;" data-toggle="tooltip" data-html="true"
                        title="<?php echo $law['description']; ?>">
                        <input type="hidden" class="lawlist-id" value="<?php echo $law['id']; ?>">
                        <h5 class="lawlist-title"><?php echo $law['name']; ?></h5>
                        <p class="lawlist-fine"><?php echo $reports_boete; ?>: €<span
                                class="fine-amount"><?php echo $law['fine']; ?></span></p>
                        <p class="lawlist-months"><?php echo $reports_celstraf; ?>: <span
                                class="months-amount"><?php echo $law['months']; ?></span>
                            <?php echo $reports_months; ?></p>
                    </div>
                </div>

                <?php } ?>
            </div>
        </div>
    </div>
</div>


<?php } ?>
</div>
<!-- <script src="assets/js/jquery-3.3.1.slim.min.js"></script>
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/main.js"></script> -->

<!-- Froala Text-Editor (THIS CODE IS NOT IN SEPERATE FILE BECAUSE OF TESTING) -->
<script>
let name = "<?php echo $firstname ?>";
let rank = "<?php echo $_SESSION["rank"] ?>";
let date = curday('-');
let templates = [
    `<p dir="ltr" style="line-height: 1.38; text-align: center; margin-top: 0pt; margin-bottom: 0pt;"><img src="./assets/images/pv_logo.png" style="width: 205px;" class="fr-fic fr-dii"></p>
                <p dir="ltr" style="line-height: 1.38; text-align: left; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 14px;"><strong>EENHEID LOS SANTOS</strong></span></p>
                <p dir="ltr" style="line-height: 1.38; text-align: left; margin-top: 0pt; margin-bottom: 0pt;"><strong><span style="font-size: 14px; ">DISTRICT LS-Zuid</span></strong></p>
                <p dir="ltr" style="line-height: 1.38; text-align: left; margin-top: 0pt; margin-bottom: 0pt;"><strong><span style="font-size: 14px; ">BASISTEAM MISSION ROW</span></strong></p>
                <p dir="ltr" style="line-height: 1.38; text-align: left; margin-top: 0pt; margin-bottom: 0pt;"><strong><br></strong></p>
                <p dir="ltr" style="line-height: 1.38; text-align: left; margin-top: 0pt; margin-bottom: 0pt;"><br></p>
                <p dir="ltr" style="line-height: 1.38; text-align: center; margin-top: 0pt; margin-bottom: 0pt;"><span style="vertical-align: baseline;"><strong>M I N I  -  P R O C E S  -  V E R B A A L</strong></span></p>
                <p dir="ltr" style="line-height: 1.38; text-align: center; margin-top: 0pt; margin-bottom: 0pt;"><span style="background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;"><strong>beschikking</strong></span></p>
                <p>
                    <br>Ik, verbalisant, ${name}, ${rank} van Politie Eenheid Los Santos, verklaar het volgende.</p>
                <p>Op ${date}, rond <span style="color: rgb(235, 107, 86);">TIME</span>, bevond ik mij in uniform gekleed en met algemene politietaak belast op de openbare weg.&nbsp;</p>
                <p style="line-height: 1.2;">BEVINDINGEN</p>
                    <p>Locatie:
                    <br>Overtreding:
                    <br>finebedrag:
                    <br>Verklaring:&nbsp;</p>
                <p>
                    <br>
                    <br>
                </p>
                <p><em><span style="font-size: 10px;">In geval van snelheid</span></em>
                    <br>Gemeten snelheid:
                    <br>Toegestane snelheid:
                    <br>Correctie: - 10%
                    <br>Uiteindelijke snelheid:&nbsp;</p>`,
    `<p dir="ltr" style="line-height: 1.38; text-align: center; margin-top: 0pt; margin-bottom: 0pt;"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/43/Logo_politie.svg/1200px-Logo_politie.svg.png" style="width: 205px;" class="fr-fic fr-dii"></p>
                <p dir="ltr" style="line-height: 1.38; text-align: left; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 14px;"><strong>EENHEID LOS SANTOS</strong></span></p>
                <p dir="ltr" style="line-height: 1.38; text-align: left; margin-top: 0pt; margin-bottom: 0pt;"><strong><span style="font-size: 14px; ">DISTRICT LS-Zuid</span></strong></p>
                <p dir="ltr" style="line-height: 1.38; text-align: left; margin-top: 0pt; margin-bottom: 0pt;"><strong><span style="font-size: 14px; ">BASISTEAM MISSION ROW</span></strong></p>
                <p dir="ltr" style="line-height: 1.38; text-align: left; margin-top: 0pt; margin-bottom: 0pt;">
                    <br>
                </p>
                <p dir="ltr" style="line-height: 1.38; text-align: left; margin-top: 0pt; margin-bottom: 0pt;">
                    <br>
                </p>
                <p dir="ltr" style="line-height: 1.38; text-align: center; margin-top: 0pt; margin-bottom: 0pt;"><span style=" vertical-align: baseline;"><strong>I N B E S L A G N A M E</strong></span></p>
                <p dir="ltr" style="line-height: 1.38; text-align: center; margin-top: 0pt; margin-bottom: 0pt;"><span style=" background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;"><strong>voertuig</strong></span></p>
                <p>
                    <br>
                </p>
                <p>
                    <br>
                </p>
                <p >Ik, verbalisant, ${name}, ${rank} van Politie Eenheid Los Santos, verklaar het volgende. Op ${date}, rond <span style="color: rgb(235, 107, 86);">TIME</span>,heb ik een of meerdere goederen van de heer/mevrouw <span style="color: rgb(235, 107, 86);">NAAM</span> in beslag genomen.</p>
                <p >
                    <br>
                </p>
                <p style=" line-height: 1.2;">BEVINDINGEN</p>
                <p>
                    <br style="box-sizing: border-box; color: rgb(65, 65, 65); font-family: ;">Voertuig type:&nbsp;Car/Bike/Scooter
                    <br style="box-sizing: border-box; color: rgb(65, 65, 65); font-family: ;">Model/Type:&nbsp;
                    <br style="box-sizing: border-box; color: rgb(65, 65, 65); font-family: ;">Kleur:&nbsp;
                    <br style="box-sizing: border-box; color: rgb(65, 65, 65); font-family: ;">Kenteken:&nbsp;
                    <br style="box-sizing: border-box; color: rgb(65, 65, 65); font-family: ;">Reden:&nbsp;
                    <br style="box-sizing: border-box; color: rgb(65, 65, 65); font-family: ;">Op te halen vanaf:&nbsp;</p>
                <p>
                    <br>
                </p>`
    /* `<p dir="ltr" style="line-height: 1.38; text-align: center; margin-top: 0pt; margin-bottom: 0pt;"><img src="./assets/images/pv_logo.png" style="width: 205px;" class="fr-fic fr-dii"></p>
     <p dir="ltr" style="line-height: 1.38; text-align: left; margin-top: 0pt; margin-bottom: 0pt;"><span><strong>EENHEID LOS SANTOS</strong></span></p>
     <p dir="ltr" style="line-height: 1.38; text-align: left; margin-top: 0pt; margin-bottom: 0pt;"><strong><span>DISTRICT LS-ZUID</span></strong></p>
     <p dir="ltr" style="line-height: 1.38; text-align: left; margin-top: 0pt; margin-bottom: 0pt;"><strong><span>BASISTEAM MISSION ROW</span></strong></p>
     <p dir="ltr" style="line-height: 1.38; text-align: left; margin-top: 0pt; margin-bottom: 0pt;">
         <br>
     </p>
     <p dir="ltr" style="line-height: 1.38; text-align: left; margin-top: 0pt; margin-bottom: 0pt;"><span>Proces-verbaalnummer: (pv nummer)</span></p>
     <p dir="ltr" style="line-height: 1.38; text-align: left; margin-top: 0pt; margin-bottom: 0pt;">
         <br>
     </p>
     <p dir="ltr" style="line-height: 1.38; text-align: center; margin-top: 0pt; margin-bottom: 0pt;"><span style="vertical-align: baseline;"><strong>P R O C E S - V E R B A A L</strong></span></p>
     <p dir="ltr" style="line-height: 1.38; text-align: center; margin-top: 0pt; margin-bottom: 0pt;"><span style="background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;"><strong>bewijsmateriaal</strong></span></p>
     <p>
         <br>
     </p>
     <p>
         <br>
     </p>
     <p>Ik, verbalisant, ${name}, ${rank} van Politie Eenheid Los Santos, verklaar het volgende.</p>
     <p>
         <br>
     </p>
     <p style="line-height: 1.2;">BEVINDINGEN</p>
     <p >
         <br style="box-sizing: border-box; color: rgb(65, 65, 65);">Adres Bedrijf/Winkel:&nbsp;
         <br style="box-sizing: border-box; color: rgb(65, 65, 65);">Datum/tijd:&nbsp;
         <br style="box-sizing: border-box; color: rgb(65, 65, 65);">Bewijs:&nbsp;</p>

     <p>
         <br>
     </p> */
    ,
    `<p dir="ltr" style="line-height: 1.38; text-align: center; margin-top: 0pt; margin-bottom: 0pt;"><img src="./assets/images/pv_logo.png" style="width: 205px;" class="fr-fic fr-dii"></p>
                <p dir="ltr" style="line-height: 1.38; text-align: left; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 14px;"><strong>EENHEID LOS SANTOS</strong></span></p>
                <p dir="ltr" style="line-height: 1.38; text-align: left; margin-top: 0pt; margin-bottom: 0pt;"><strong><span style="font-size: 14px; ">DISTRICT LS-Zuid</span></strong></p>
                <p dir="ltr" style="line-height: 1.38; text-align: left; margin-top: 0pt; margin-bottom: 0pt;"><strong><span style="font-size: 14px; ">BASISTEAM MISSION ROW</span></strong></p>
                <p dir="ltr" style="line-height: 1.38; text-align: left; margin-top: 0pt; margin-bottom: 0pt;"><strong><br></strong></p>
                <p dir="ltr" style="line-height: 1.38; text-align: left; margin-top: 0pt; margin-bottom: 0pt;">
                    <br>
                </p>
                <p dir="ltr" style="line-height: 1.38; text-align: center; margin-top: 0pt; margin-bottom: 0pt;"><span style=" vertical-align: baseline;"><strong>P R O C E S  -  V E R B A A L</strong></span></p>
                <p dir="ltr" style="line-height: 1.38; text-align: center; margin-top: 0pt; margin-bottom: 0pt;"><span style="background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;"><strong>aangifte</strong></span></p>
                <p >Feit:
                    <br>Plaatsdelict:
                    <br>Pleegdatum/tijd:&nbsp;</p>
                <p >
                    <br>
                </p>
                <p >Ik, verbalisant, ${name}, ${rank} van Politie Eenheid Los Santos, verklaar het volgende.</p>
                <p >Op ${date}, rond <span style="color: rgb(235, 107, 86);">TIME</span>, verscheen voor mij, in het politiebureau, Mission Row, Sinner Street, Los Santos, een persoon, de aangever die mij opgaf te zijn:&nbsp;</p>
                <p >Achternaam:&nbsp;
                    <br style="box-sizing: border-box; color: rgb(65, 65, 65);">Volledige naam:&nbsp;
                    <br style="box-sizing: border-box; color: rgb(65, 65, 65);">Geboren:&nbsp;
                    <br style="box-sizing: border-box; color: rgb(65, 65, 65);">Geslacht:&nbsp;
                    <br style="box-sizing: border-box; color: rgb(65, 65, 65);">Nationaliteit:&nbsp;
                    <br style="box-sizing: border-box; color: rgb(65, 65, 65);">Adres:&nbsp;</p>

                <p>Hij/Zij deed aangifte en verklaarde het volgende over het in de aanhef vermelde incident, dat plaatsvond op de locatie genoemd bij plaats delict, op de genoemde pleegdatum/tijd.</p>
                <p style=" line-height: 1.2;">
                    <br>
                </p>
                <p style=" line-height: 1.2;">BEVINDINGEN</p>
                <p>
                    <br>
                </p>
                <p>Aan niemand werd het recht of de toestemming geven tot het plegen van dit feit.</p>
                <p>De verbalisant,</p>
                <p>${name}</p>
                <p><br></p>
                <p>Ik, <span style="color: rgb(235, 107, 86);">NAAM AANGEVER</span>, verklaar dat ik dit proces-verbaal heb gelezen. Ik verklaar dat ik de waarheid heb verteld. Ik verklaar dat mijn verhaal goed is weergegeven in het proces-verbaal. Ik weet dat het doen van een valse aangifte strafbaar is.</p>
                <p>De aangever,</p>
                <p style=" line-height: 1.2; color: rgb(235, 107, 86);">NAAM AANGEVER</p>
                <p style=" line-height: 1.2; color: rgb(235, 107, 86);"><br></p>
                <p style=" line-height: 1.2; color: rgb(235, 107, 86);"><br></p>
                <p style=" line-height: 1.2;"><strong>Eventuele opmerkingen verbalisant</strong></p>
                <p style=" line-height: 1.2;"><br></p>
                <p>Waarvan door mij is opgemaakt dit proces-verbaal, dat ik sloot en ondertekende te Los Santos op ${date}/<span style="color: rgb(235, 107, 86);">TIME</span>&nbsp;</p>
                <p><b>${name}</b></p>`,
    `<p dir="ltr" style="line-height: 1.38; text-align: center; margin-top: 0pt; margin-bottom: 0pt;"><img src="./assets/images/pv_logo.png" style="width: 205px;" class="fr-fic fr-dii"></p>
                <p dir="ltr" style="line-height: 1.38; text-align: left; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 14px;"><strong>EENHEID LOS SANTOS</strong></span></p>
                <p dir="ltr" style="line-height: 1.38; text-align: left; margin-top: 0pt; margin-bottom: 0pt;"><strong><span style="font-size: 14px; ">DISTRICT LS-Zuid</span></strong></p>
                <p dir="ltr" style="line-height: 1.38; text-align: left; margin-top: 0pt; margin-bottom: 0pt;"><strong><span style="font-size: 14px; ">BASISTEAM MISSION ROW</span></strong></p>
                <p dir="ltr" style="line-height: 1.38; text-align: left; margin-top: 0pt; margin-bottom: 0pt;"><strong><br></strong></p>
                <p dir="ltr" style="line-height: 1.38; text-align: left; margin-top: 0pt; margin-bottom: 0pt;">
                    <br>
                </p>
                <p dir="ltr" style="line-height: 1.38; text-align: center; margin-top: 0pt; margin-bottom: 0pt;"><span style=" vertical-align: baseline;"><strong>P R O C E S - V E R B A A L</strong></span></p>
                <p dir="ltr" style="line-height: 1.38; text-align: center; margin-top: 0pt; margin-bottom: 0pt;"><span style=" background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;"><strong>aanhouding</strong></span></p>
                <p >
                    <br>Ik, verbalisant, ${name}, ${rank} van Politie Eenheid Los Santos, verklaar het volgende.</p>
                <p >Op ${date}, omstreeks <span style="color: rgb(235, 107, 86);">TIJD</span> uur, bevond ik mij in uniform gekleed en met algemene politietaak belast op de openbare weg,</p>
                <p >Daar heb ik aangehouden:
                    <br>Een verdachte die op basis van nader identiteitsonderzoek, bleek te zijn:&nbsp;</p>
                <p >Achternaam:&nbsp;
                    <br style="box-sizing: border-box; color: rgb(65, 65, 65);">Volledige naam:&nbsp;
                    <br style="box-sizing: border-box; color: rgb(65, 65, 65);">Geboren:&nbsp;
                    <br style="box-sizing: border-box; color: rgb(65, 65, 65);">Geslacht:&nbsp;
                    <br style="box-sizing: border-box; color: rgb(65, 65, 65);">Nationaliteit:&nbsp;
                    <br style="box-sizing: border-box; color: rgb(65, 65, 65);">Adres:&nbsp;</p>

                <p >
                    <br>
                </p>
                <p >Identiteitsfouillering:
                    <br>Ja/Nee</p>
                <p >Veiligheidsfouillering:
                    <br>Ja/Nee</p>
                <p >Inbeslagneming:
                    <br>Ja/Nee, zo ja wat?</p>
                <p >Gebruik transportboeien:
                    <br>Ja/Nee</p>
                <p >Gebruik geweld:
                    <br>Ja/Nee</p>
                <p >Rechtsbijstand:
                    <br>Ja/Nee</p>
                <p >
                    <br>
                </p>

                <p>Reden van aanhouding:
                    <br>De verdachte werd aangehouden als verdachte van overtreding van artikel(en).</p>
                <p >
                    <br>
                </p>
                <p style=" line-height: 1.2;">BEVINDINGEN</p>
                <p style=" line-height: 1.2;">
                    <br>
                </p>
                <p >Ik heb de verdachte tijdens de aanhouding verteld dat hij/zij zich mag beroepen op zijn zwijgrecht.</p>
                <p >
                    <br>
                </p>
                <p >Voorgeleiding:
                    <br>Op genoemd bureau werd de verdachte ten spoedigste voorgeleid voor de hulpofficier van justitie. Deze gaf op te <span style="color: rgb(235, 107, 86);">TIJD</span> uur het bevel de verdachte op te houden voor onderzoek.</p>
                <p >
                    <br>
                </p>
                <p >Waarvan door mij, ${name}, op ambtseed is opgemaakt, dit proces-verbaal te Los Santos op ${date}/<span style="color: rgb(235, 107, 86);">TIJD</span>.</p>
                <p >
                    <br>
                </p>
                <p >Strafeis:
                    <br>Gekregen straf:</p>`,
    `<p dir="ltr" style="line-height: 1.38; text-align: center; margin-top: 0pt; margin-bottom: 0pt;"><img src="./assets/images/pv_logo.png" style="width: 205px;" class="fr-fic fr-dii"></p>
                <p dir="ltr" style="line-height: 1.38; text-align: left; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 14px;"><strong>EENHEID LOS SANTOS</strong></span></p>
                <p dir="ltr" style="line-height: 1.38; text-align: left; margin-top: 0pt; margin-bottom: 0pt;"><strong><span style="font-size: 14px; ">DISTRICT LS-Zuid</span></strong></p>
                <p dir="ltr" style="line-height: 1.38; text-align: left; margin-top: 0pt; margin-bottom: 0pt;"><strong><span style="font-size: 14px; ">BASISTEAM MISSION ROW</span></strong></p>
                <p dir="ltr" style="line-height: 1.38; text-align: left; margin-top: 0pt; margin-bottom: 0pt;">
                    <br>
                </p>
                <p dir="ltr" style="line-height: 1.38; text-align: left; margin-top: 0pt; margin-bottom: 0pt;">
                    <br>
                </p>
                <p dir="ltr" style="line-height: 1.38; text-align: center; margin-top: 0pt; margin-bottom: 0pt;"><span style=" vertical-align: baseline;"><strong>P R O C E S - V E R B A A L</strong></span></p>
                <p dir="ltr" style="line-height: 1.38; text-align: center; margin-top: 0pt; margin-bottom: 0pt;"><span style=" background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;"><strong>bewijsmateriaal</strong></span></p>
                    <br>
                </p>
                <p >Ik, verbalisant, ${name}, ${rank} van Politie Eenheid Los Santos, verklaar het volgende.</p>
                <p >
                    <br>
                </p>
                <p style=" line-height: 1.2;">BEVINDINGEN</p>
                <p style=" line-height: 1.2;">
                    <br>
                </p>
                <p ><span style='color: rgb(65, 65, 65); font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;'>Adres Bedrijf/Winkel:&nbsp;</span>
                    <br style="box-sizing: border-box; color: rgb(65, 65, 65); font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-style: initial; text-decoration-color: initial;"><span style='color: rgb(65, 65, 65); font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;'>Datum/tijd:&nbsp;</span>
                    <br style="box-sizing: border-box; color: rgb(65, 65, 65); font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-style: initial; text-decoration-color: initial;"><span style='color: rgb(65, 65, 65); font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;'>Bewijs</span>:&nbsp;</p>
                <p >
                    <br>
                </p>`
];

FroalaEditor.DefineIcon('sjablonen', {
    NAME: 'cog',
    SVG_KEY: 'add'
});
FroalaEditor.RegisterCommand('sjablonen', {
    title: 'Sjablonen',
    type: 'dropdown',
    focus: false,
    undo: true,
    refreshAfterCallback: true,
    options: {
        '0': 'Mini Proces Verbaal',
        '1': 'Voertuig Inbeslagname',
        '2': 'Proces Verbaal Aangifte',
        '3': 'Proces Verbaal Aanhouding',
        '4': 'Proces Verbaal Bewijsmateriaal'
    },
    callback: function(cmd, val) {
        this.html.insert(templates[val]);
    },
    // Callback on refresh.
    refresh: function($btn) {},
    // Callback on dropdown show.
    refreshOnShow: function($btn, $dropdown) {},
});
new FroalaEditor('textarea#froala-editor', {
    key: "1C%kZV[IX)_SL}UJHAEFZMUJOYGYQE[\\ZJ]RAe(+%$==",
    width: '1000',
    attribution: false,
    imageUpload: false,
    useClasses: false,
    spellcheck: false,
    language: 'nl',
    placeholderText: "Rapportage opstellen...",
    toolbarButtons: {
        'moreText': {
            'buttons': ['bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'fontSize',
                'textColor', 'backgroundColor', 'clearFormatting'
            ]
        },
        'moreParagraph': {
            'buttons': ['alignLeft', 'alignCenter', 'formatOLSimple', 'alignRight', 'alignJustify', 'formatOL',
                'formatUL', 'paragraphFormat', 'lineHeight', 'outdent', 'indent'
            ],
            'buttonsVisible': 3
        },
        'moreRich': {
            'buttons': ['sjablonen', 'insertLink', 'insertImage', 'insertTable', 'fontAwesome',
                'specialCharacters', 'insertHR'
            ],
            'buttonsVisible': 3
        },
        'moreMisc': {
            'buttons': ['undo', 'redo', 'fullscreen', 'spellChecker', 'selectAll', 'help'],
            'align': 'right',
            'buttonsVisible': 2
        }
    },
    imageDefaultDisplay: 'block',
    imageInsertButtons: ['imageByURL'],
    imageEditButtons: ['imageReplace', 'imageAlign', 'imageSize', 'linkOpen', 'linkEdit', 'linkRemove',
        'imageDisplay', 'imageAlt', 'imageRemove'
    ]
});

function curday(sp) {
    today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1; //As January is 0.
    var yyyy = today.getFullYear();

    if (dd < 10) dd = '0' + dd;
    if (mm < 10) mm = '0' + mm;
    return (dd + sp + mm + sp + yyyy);
};
setTimeout(() => {
    $("#logo").html("");
}, 100);
</script>
<!-- </body>
</html> -->
<?php
include("footer.php");
?>