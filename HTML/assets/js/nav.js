$(document).ready(function(){
    $(window).scroll(function(){
        if(this.scrollY > 20){
            $('#header').addClass("sticky");
        }else{
            $('#header').removeClass("sticky");
        }
    });

    $('.menu-btn').click(function(){
        $('.header ul').toggleClass('show');
        $('.menu-btn i').toggleClass('active');
    });

    jQuery('.dropdown-menu li a').click(function(){
        var _this_img = jQuery(this).attr('data-img');
        jQuery(this).closest('.btn-group').find(' .dropdown-toggle img').attr('src',_this_img);
      })
});