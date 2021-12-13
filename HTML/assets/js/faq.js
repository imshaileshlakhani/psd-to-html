$(document).ready(function () {
    $(".customer-tab").click(function () {
        $(".service-provider").css("display", "none");
        $(".customer").css("display", "block");
        $(".customer-tab").addClass("active1");
        $(".servicer-tab").removeClass("active1");
    });
    $(".servicer-tab").click(function () {
        $(".customer").css("display", "none");
        $(".service-provider").css("display", "block");
        $(".servicer-tab").addClass("active1");
        $(".customer-tab").removeClass("active1");
    });

    $('.card1 .qe').on('click', function () {
        var clist = document.getElementsByClassName("card1");
        for(var i=0;i<clist.length;i++){
           clist[i].getElementsByClassName("img")[0].setAttribute('src', "./assets/images/faq/arrow-right.png");
        }
        if (!$(this).hasClass("collapsed")) {
            $(this).find('.img').attr('src', "./assets/images/faq/arrow-right.png");
        } else {
            $(this).find('.img').attr('src', "./assets/images/faq/arrow-down.png");
        }
    });
});