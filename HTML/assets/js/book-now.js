$(document).ready(function () {
    // extra-service from book now page
    $(".extra-service label").click(function(){
        $imgVal = $(this).find('input[type=checkbox]').val();
        if ($(this).find('input[type=checkbox]').is(':checked')) {
            $(this).find('div').addClass('active');
            $(this).find('div img').attr("src","assets/images/book-now/"+$imgVal+"-green.png");
        } else {
            $(this).find('div').removeClass('active');
            $(this).find('div img').attr("src","assets/images/book-now/"+$imgVal+".png");
        }
    });

    //add address
    $(".add-address-btn button").click(function(){
      $("#add-new-address").css("display","block");
      $(".add-address-btn").css("display","none");
    });
    $(".save").click(function(){
      $("#add-new-address").css("display","none");
      $(".add-address-btn").css("display","block");
    });
    $(".cancel").click(function(){
      $("#add-new-address").css("display","none");
      $(".add-address-btn").css("display","block");
    });
  
    //card number
    $("#cnumber").on("keyup", function (event) {
      var value = $(this).val();
      if (value.length <= 17) {
        if (event.which >= 48 && event.which <= 57) {
          var temp = value.replace(/\s/g, "");
          var len = temp.length;
          if (len % 4 == 0) {
            $(this).val(value + " ");
            flag = 1;
          }
        } else {
          $(this).val(value.substring(0, value.length - 1));
        }
      } else {
        $(this).val(value.substring(0, 18));
        return false;
      }
    });
  
    //card date
    $("#expiry").on("keyup", function (event) {
      var date = $(this).val();
      if (date.length <= 5) {
        if (event.which >= 48 && event.which <= 57) {
          if (date.length == 2) {
            $(this).val(date + "/");
          }
        } else {
          $(this).val(date.substring(0, date.length - 1));
        }
      } else {
        $(this).val(date.substring(0, 5));
        return false;
      }
    });
  
    //card cvc
    $("#cvc").on("keyup", function(event){
      var cvc = $(this).val();
      if (event.which >= 48 && event.which <= 57) {
          if (!cvc.length <= 3) {
              $(this).val(cvc.substring(0, 3));    
          }
        } else {
          $(this).val(cvc.substring(0, cvc.length - 1));
        }
    });
  });
  