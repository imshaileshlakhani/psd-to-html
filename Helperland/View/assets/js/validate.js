$(document).ready(function(){
    $('#submit').click(function(){
        var firstname = $('#firstname').val();
        var lastname = $('#lastname').val();
        var phone = $('.phone').val();
        var email = $('#email').val();
        var msg = $('#msg').val();

        function validateEmail(email) {
            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            return emailReg.test(email);
        }
        function isNext(selector){
            if($(selector).next().is('span')){
                return true;
            }
            else{
                return false;
            }
        }
        function validatePhoneNumber(phone){
            var phoneno = /^[\d]{10}$/;
            return phoneno.test(phone);
        }

        // $('.error').hide();

        if(firstname.length < 1){
            // if(!isNext('#firstname')){
            //     $('#firstname').after("<span class='error'>Enter First Name</span>");
            // }
            $('#firstname').after("<span class='error'>Enter First Name</span>");
            return false;
        }else{
            $('#firstname').next().hide();
        }

        if(lastname.length < 1){
            // if(!isNext('#lastname')){
            //     $('#lastname').after("<span class='error'>Enter Last Name</span>");
            // }
            $('#lastname').after("<span class='error'>Enter Last Name</span>");
            return false;
        }else{
            $('#lastname').next().hide();
        }

        if(!validatePhoneNumber(phone)){
            // if(!isNext('.phone')){
            //     $('.phone').parent().after("<span class='error'>Enter Phone Number</span>");
            // }
            $('.phone').parent().after("<span class='error'>Enter Phone Number</span>");
            return false;
        }else{
            $('.phone').parent().next().hide();
        }

        if(email.length < 1 || !validateEmail(email)){
            // if(!isNext('#email')){
            //     $('#email').after("<span class='error'>Enter Valid Email</span>");
            // }
            $('#email').after("<span class='error'>Enter Valid Email</span>");
            return false;
        }else{
            $('#email').next().hide();
        }

        if(msg.length < 1){
            // if(!isNext('#msg')){
            //     $('#msg').after("<span class='error'>Enter Message</span>");
            // }
            $('#msg').after("<span class='error'>Enter Message</span>");
            return false;
        }else{
            $('#msg').next().hide();
        }
       
    });
});