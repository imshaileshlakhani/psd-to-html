function showLoader() {
    $.LoadingOverlay("show", {
        background: "rgba(0, 0, 0, 0.7)"
    });
}
$(document).ready(function () {
    var parameter = $('#logout-login-para').val();
    var successMsg = $('#contact-success').val();
    var userTypeId = $('#header').data('usertype');
    if (userTypeId == 2) {
        $('#bookservice').closest('li').remove();
    }
    var is_valid = true;
    var is_pass_check = false;

    // contact page validation
    $('#submit').click(function () {
        is_valid = true;
        $('.error').remove();
        var firstname = $('#firstname').val();
        var lastname = $('#lastname').val();
        var phone = $('.phone').val();
        var email = $('#email').val();
        var msg = $('#msg').val();
        var privacy = 0;

        if($('#contact-check').is(':checked')){
            privacy = 1;
        }

        feildValidation('#firstname', firstname, "First Name");
        feildValidation('#lastname', lastname, "Last Name");
        phoneValidation(phone);
        emailValidation('#email', email);
        feildValidation('#msg', msg, "Message");
        if (is_valid != true) {
            return false;
        }
        else{
            if(privacy != 1){
                alert('Please accept privacy policy');
                return false;
            }
        }
    });

    if(successMsg == 'success'){
        var alertMsg = `<div class='alert alert-success alert-dismissible fade show' role='alert'>Your query store successfully, our team will reach you soon</div>`;
        $('.success-msg').html(alertMsg);
    }

    // faq page
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
        for (var i = 0; i < clist.length; i++) {
            clist[i].getElementsByClassName("img")[0].setAttribute('src', "./assets/images/arrow-right.png");
        }
        if (!$(this).hasClass("collapsed")) {
            $(this).find('.img').attr('src', "./assets/images/arrow-right.png");
        } else {
            $(this).find('.img').attr('src', "./assets/images/arrow-down.png");
        }
    });

    //registration page validation
    $('#Register').click(function () {
        is_valid = true;
        $('.error').remove();
        var firstname = $('#firstname').val();
        var lastname = $('#lastname').val();
        var phone = $('.phone').val();
        var email = $('#email').val();
        var psw = $('#psw').val();
        var cpsw = $('#cpsw').val();
        var usertypeid = $('#usertypeid').val();
        var privacy = 0;

        if($('#privacy').is(':checked')){
            privacy = 1;
        }
        // console.log(privacy);

        feildValidation('#firstname', firstname, "First Name");
        feildValidation('#lastname', lastname, "Last Name");
        emailValidation('#email', email);
        phoneValidation(phone);
        var result = passwordValidation('#psw', psw);
        var result1 = passwordValidation('#cpsw', cpsw);
        if (result == true && result1 == true) {
            passVerify('#psw', psw, cpsw);
        }
        if (is_valid == true) {
            if(privacy == 1){
                $.ajax({
                    url: "http://localhost/psd-to-html/Helperland/?controller=Authentication&function=user_signup",
                    type: "POST",
                    data: { email: email, psw: psw, phone: phone, usertypeid: usertypeid, firstname: firstname, lastname: lastname },
                    success: function (result) {
                        var signup = JSON.parse(result);
                        var alertMsg = "";
                        if (signup.status) {
                            window.location = "http://localhost/psd-to-html/Helperland/?controller=Public&function=home&parameter=login";
                        }
                        else {
                            alertMsg = `<div class='alert alert-danger alert-dismissible fade show' role='alert'>${signup.error}</div>`;
                            $('.signup-msg').html(alertMsg);
                        }
                    }
                });
            }
            else{
                alert('Please accept privacy policy');
            }
        }
    });

    if(parameter == "login"){
        var alertMsg = `<div class='alert alert-success alert-dismissible fade show' role='alert'>Account created successfully</div>`;
        $('.signin-msg').html(alertMsg);
        $("#loginModal").modal('show');
    }

    // login validation
    $('#signin').click(function () {
        is_valid = true;
        $('.error').remove();
        var email = $('#username').val();
        var psw = $('#password').val();
        var remember = 0;
        if ($('#remember').is(":checked")) {
            remember = 1;
        }

        emailValidation('#username', email);
        passwordValidation('#password', psw);
        if (is_valid == true) {
            $.ajax({
                url: "http://localhost/psd-to-html/Helperland/?controller=Authentication&function=login",
                type: "POST",
                data: { username: email, password: psw, remember: remember },
                success: function (result) {
                    var loginData = JSON.parse(result);
                    var alertMsg = "";
                    if (loginData.status) {
                        if (loginData.UserTypeId == 1) {
                            window.location = "http://localhost/psd-to-html/Helperland/?controller=Customer&function=customerDashboard&parameter=Dashboard";
                        } else if (loginData.UserTypeId == 2) {
                            window.location = "http://localhost/psd-to-html/Helperland/?controller=Servicer&function=ServicerDashboard&parameter=New";
                        } else {
                            window.location = "http://localhost/psd-to-html/Helperland/?controller=Admin&function=adminDashboard&parameter=srequest";
                        }
                    }
                    else {
                        if(loginData.approved == 1){
                            alertMsg = `<div class='alert alert-danger alert-dismissible fade show' role='alert'>${loginData.error}</div>`;
                        }else{
                            alertMsg = `<div class='alert alert-danger alert-dismissible fade show' role='alert'>${loginData.error}</div>`;
                        }
                        
                        $('.signin-msg').html(alertMsg);
                    }
                }
            });
        }
    });

    // logout
    $('.logout-btn').click(function () {
        $.ajax({
            url: "http://localhost/psd-to-html/Helperland/?controller=Authentication&function=logout",
            type: "POST",
            data: {},
            success: function (result) {
                var logoutData = JSON.parse(result);
                if (logoutData.status) {
                    window.location = "http://localhost/psd-to-html/Helperland/?controller=Public&function=home&parameter=logout";
                }
            }
        });
    });

    if(parameter == "logout"){
        $("#successModal #success-msg").addClass('my-4');
        $("#successModal #success-msg").text('You have successfully logged out');
        $("#successModal .modal-dialog .modal-content").addClass('modal-small');
        $("#successModal button").prop('onclick', null);
        $("#successModal").modal('show');
    }

    //forgot password model
    $('#send').click(function () {
        is_valid = true;
        $('.error').remove();
        var email = $('#forgot-email').val();

        emailValidation('#forgot-email', email);
        if (is_valid == true) {
            $.ajax({
                url: "http://localhost/psd-to-html/Helperland/?controller=Authentication&function=forgot_password_link",
                type: "POST",
                data: { email: email },
                success: function (result) {
                    var forgot = JSON.parse(result);
                    var alertMsg = "";
                    if (forgot.status) {
                        alertMsg = `<div class='alert alert-success alert-dismissible fade show' role='alert'>Check your email</div>`
                        $('.forgot-msg').html(alertMsg);
                        setTimeout(function () { $('.alert').fadeOut(1000) }, 5000);
                    }
                    else {
                        alertMsg = `<div class='alert alert-danger alert-dismissible fade show' role='alert'>${forgot.error}</div>`
                        $('.forgot-msg').html(alertMsg);
                        setTimeout(function () { $('.alert').fadeOut(1000) }, 5000);
                    }
                }
            });
        }
    });

    //change password
    $('#save').click(function () {
        is_valid = true;
        $('.error').remove();
        var psw = $('#newpsw').val();
        var cpsw = $('#oldpsw').val();
        var email = $(this).data('email');
        // console.log(psw+" "+cpsw+" "+email);

        var result = passwordValidation('#newpsw', psw);
        var result1 = passwordValidation('#oldpsw', cpsw);
        if (result == true && result1 == true) {
            passVerify('#newpsw', psw, cpsw);
        }
        if (is_valid == true) {
            $.ajax({
                url: "http://localhost/psd-to-html/Helperland/?controller=Authentication&function=forgot_password",
                type: "POST",
                data: { email: email, psw: psw, cpsw: cpsw},
                success: function (result) {
                    var changePsw = JSON.parse(result);
                    var alertMsg = "";
                    if (changePsw.status == true) {
                        alertMsg = `<div class='alert alert-success alert-dismissible fade show' role='alert'>${changePsw.msg}</div>`;
                        $('.signin-msg').html(alertMsg);
                        $("#loginModal").modal('show');
                    }
                    else {
                        alertMsg = `<div class='alert alert-danger alert-dismissible fade show' role='alert'>${changePsw.msg}</div>`;
                        $('#forgot-psw-msg').html(alertMsg);
                    }
                }
            });
        }
    });

    // validation function
    function feildValidation(id, value, feildname) {
        if (value.length < 1) {
            $(id).after(`<span class='error'>Enter ${feildname}</span>`);
            is_valid = false;
            return;
        }
    }
    function phoneValidation(phone) {
        var phoneno = /^[\d]{10}$/;
        if (phone.length < 1) {
            $('.phone').parent().after("<span class='error'>Enter Phone Number</span>");
            is_valid = false;
            return;
        }
        else if (!phoneno.test(phone)) {
            $('.phone').parent().after("<span class='error'>Mobile number must 10 digit long</span>");
            is_valid = false;
            return;
        }
    }
    function emailValidation(id, email) {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        if (email.length < 1 || !emailReg.test(email)) {
            $(id).after("<span class='error'>Enter Valid Email</span>");
            is_valid = false;
            return;
        }
    }
    function passwordValidation(id, password) {
        is_pass_check = false;
        var passReg = /^.*(?=.{6,14})(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%&]).*$/;
        if (password.length < 1) {
            $(id).after("<span class='error'>Password can't be empty</span>");
            is_valid = false;
            return;
        }
        else if (!passReg.test(password)) {
            $(id).after("<span class='error'>Password must be 6 to 14 character long including At least one uppercase, lowercase, special char and numbers</span>");
            is_valid = false;
            return;
        }
        else {
            is_pass_check = true;
            return is_pass_check;
        }
    }
    function passVerify(id, psw, cpsw) {
        if (psw != cpsw) {
            $(id).after("<span class='error'>Password and confirm password must be same</span>");
            is_valid = false;
            return;
        }
    }
});