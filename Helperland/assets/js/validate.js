$(document).ready(function(){
    var is_valid = true;
    var is_pass_check = false;

    // contact page validation
    $('#submit').click(function(){
        is_valid = true;
        $('.error').remove();
        var firstname = $('#firstname').val();
        var lastname = $('#lastname').val();
        var phone = $('.phone').val();
        var email = $('#email').val();
        var msg = $('#msg').val();

        firstNameValidation(firstname);
        lastNameValidation(lastname);
        phoneValidation(phone);
        emailValidation('#email',email);
        msgValidation(msg);
        if(is_valid != true){
            return false;
        }
    });

    //registration page validation
    $('#Register').click(function(){
        is_valid = true;
        $('.error').remove();
        var firstname = $('#firstname').val();
        var lastname = $('#lastname').val();
        var phone = $('.phone').val();
        var email = $('#email').val();
        var psw = $('#psw').val();
        var cpsw = $('#cpsw').val();

        firstNameValidation(firstname);
        lastNameValidation(lastname);
        emailValidation('#email',email);
        phoneValidation(phone);
        var result = passwordValidation('#psw',psw);
        var result1 = passwordValidation('#cpsw',cpsw);
        if(result == true && result1 == true){
            passVerify('#psw',psw,cpsw);
        }
        if(is_valid != true){
            return false;
        }
    });

    // login validation
    $('#signin').click(function(){
        is_valid = true;
        $('.error').remove();
        var email = $('#username').val();
        var psw = $('#password').val();

        emailValidation('#username',email);
        passwordValidation('#password',psw);
        if(is_valid != true){
            return false;
        }
    });

    //forgot password model
    $('#send').click(function(){
        is_valid = true;
        $('.error').remove();
        var email = $('#forgot-email').val();

        emailValidation('#forgot-email',email);
        if(is_valid != true){
            return false;
        }
    });

    //change password
    $('#save').click(function(){
        is_valid = true;
        $('.error').remove();
        var psw = $('#newpsw').val();
        var cpsw = $('#oldpsw').val();

        var result = passwordValidation('#newpsw',psw);
        var result1 = passwordValidation('#oldpsw',cpsw);
        if(result == true && result1 == true){
            passVerify('#newpsw',psw,cpsw);
        }
        if(is_valid != true){
            return false;
        }
    });

    function firstNameValidation(firstname){
        if(firstname.length < 1){
            $('#firstname').after("<span class='error'>Enter First Name</span>");
            is_valid = false;
            return;
        }
    }
    function lastNameValidation(lastname){
        if(lastname.length < 1){
            $('#lastname').after("<span class='error'>Enter Last Name</span>");
            is_valid = false;
            return;
        }
    }
    function phoneValidation(phone){
        var phoneno = /^[\d]{10}$/;
        if(phone.length < 1){
            $('.phone').parent().after("<span class='error'>Enter Phone Number</span>");
            var is_valid = false;
            return;
        }
        else if(!phoneno.test(phone)){
            $('.phone').parent().after("<span class='error'>Mobile number must 10 digit long</span>");
            is_valid = false;
            return;
        }
    }
    function emailValidation(id,email){
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        if(email.length < 1 || !emailReg.test(email)){
            $(id).after("<span class='error'>Enter Valid Email</span>");
            is_valid = false;
            return;
        }
    }
    function msgValidation(msg){
        if(msg.length < 1){
            $('#msg').after("<span class='error'>Enter Message</span>");
            is_valid = false;
            return;
        }
    }
    function passwordValidation(id,password){
        is_pass_check = false;
        var passReg = /^.*(?=.{6,14})(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%&]).*$/;
        if(password.length < 1){
            $(id).after("<span class='error'>Password can't be empty</span>");
            is_valid = false;
            return;
        }
        else if(!passReg.test(password)){
            $(id).after("<span class='error'>Password must be 6 to 14 character long including At least one uppercase, lowercase, special char and numbers</span>");
            is_valid = false;
            return;
        }
        else{
            is_pass_check = true;
            return is_pass_check;
        }
    }
    function passVerify(id,psw,cpsw){
        if(psw != cpsw){
            $(id).after("<span class='error'>Password and confirm password must be same</span>");
            is_valid = false;
            return;
        }
    }
});