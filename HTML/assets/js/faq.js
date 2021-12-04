$(document).ready(function () {
    $(".Rectangle-21-copy-3").click(function () {
        $(".service-provider").css("display", "none");
        $(".customer").css("display", "block");
        $(".Rectangle-21-copy-3").addClass("active");
        $(".Rectangle-21").removeClass("active");
    });
    $(".Rectangle-21").click(function () {
        $(".customer").css("display", "none");
        $(".service-provider").css("display", "block");
        $(".Rectangle-21").addClass("active");
        $(".Rectangle-21-copy-3").removeClass("active");
    });

    $('.qe').on('click', function () {
        if ($(this).hasClass("collapsed")) {
            $(this).children('img').attr('src', "./assets/images/faq/arrow-right.png");
        } else {
            $(this).children('img').attr('src', "./assets/images/faq/arrow-down.png");
        }
    });
});