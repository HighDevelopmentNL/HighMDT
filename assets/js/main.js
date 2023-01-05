$(".panel-item").hover(
    function() {
        $(this).css("background", "#ffffff");
    },
    function() {
        $(this).css("background", "#f4f5fb");
    }
);

$(".law-item-container").click(function() {
    $.get("laws.php", { type: "editlaw", lawid: $(this).attr("data-lawid") });
});

$(".report-law-item-tab").click(function() {
    var id = $(this).find(".lawlist-id").val();

    var lawtitle = $(this).find(".lawlist-title").html();

    var fine = $(this).find(".fine-amount").html();

    var months = $(this).find(".months-amount").html();

    var description = $(this).attr("title");

    $(".added-laws").append(
        '<div class="report-law-item" data-toggle="tooltip" data-html="true" title="' +
        description +
        '"><input type="hidden" class="lawlist-id" value="' +
        id +
        '"><h5 class="lawlist-title">' +
        lawtitle +
        '</h5><p class="lawlist-fine">Boete: €<span class="fine-amount">' +
        fine +
        '</span></p><p class="lawlist-months">Cel: <span class="months-amount">' +
        months +
        "</span> maanden</p></div>"
    );

    CalculatePunishment();

    $(".report-law-item").click(function() {
        $(this).remove();

        CalculatePunishment();
    });
});

$(".report-law-item").click(function() {
    $(this).remove();

    CalculatePunishment();
});

$("#togglelaws").click(function() {
    if ($(".laws").css("display") == "none") {
        $(".laws").css("display", "block");
    } else {
        $(".laws").css("display", "none");
    }

    CalculatePunishment();
});

$(function() {
    $('[data-toggle="tooltip"]').tooltip();
});

function CalculatePunishment() {
    var totalFine = 0;

    var totalMonths = 0;

    var punishmentValue = "";

    $(".report-law-item").each(function(index) {
        var fine = $(this).find(".fine-amount").html();

        var months = $(this).find(".months-amount").html();

        var id = $(this).find(".lawlist-id").val();

        totalFine += parseInt(fine);

        totalMonths += parseInt(months);

        punishmentValue = punishmentValue + "," + id;
    });

    $(".total-punishment").html(
        "Totaal: €" + totalFine + " - " + totalMonths + " maanden"
    );

    $(".report-law-punishments").val(punishmentValue);

    $(".fines-law").val(totalFine);
}

$(".lawsearch").keyup(function() {
    // get the category from the attribute

    var filterVal = $(this).val().toLowerCase();

    $(".report-law-item-tab").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(filterVal) > -1);
    });

    $(".law-item-container").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(filterVal) > -1);
        // $(this).toggle();
    });
});