function sortTable(n){
    var table;
    table = document.getElementById('table2');
    var rows,i,x,y,count = 0;
    var switching = true;
    var direction = "asc";

    while(switching){
        switching = false;
        rows = table.rows;

        for(i=1;i<(rows.length - 1);i++){
            var Switch = false;
            x = rows[i].getElementsByTagName("TD")[n];
            y = rows[i + 1].getElementsByTagName("TD")[n];

            if(direction == "asc"){
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()){
                    Switch = true;
                    break;
                }
            }
            else if(direction == "desc"){
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()){
                    Switch = true;
                        break;
                }
            }
        }
        if (Switch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            count++;
        }else{
            if(count == 0 && direction == "asc"){
                direction = "desc";
                switching = true;
            }
        }
    }
}
function showLoader(){
    $.LoadingOverlay("show",{
      background  : "rgba(0, 0, 0, 0.7)"
    });
}
$(document).ready(function () {
    const userid = $('#userdata').val();
    ServicerData();
    $('#New').click(function () {
        ServicerData();
    });
    $('#Upcoming').click(function () {
        ServicerData();
    });
    $('#History').click(function () {
        ServicerData();
    });
    $('#Ratings').click(function () {
        ServicerData();
    });
    $('#Block').click(function () {
        ServicerData();
    });
    $('#setting').click(function () {
        ServicerData();
    });

    function ServicerData() {
        var tabName = $('#tab-name').val();
        $.ajax({
            url: "http://localhost/psd-to-html/Helperland/?controller=Servicer&function=servicerData",
            type: "POST",
            data: { pageName: tabName, userid: userid},
            success: function (result) {
                // console.log(result);
                switch (tabName) {
                    case "New":
                        console.log("New");
                        break;
                    case "Upcoming":
                        console.log("Upcoming");
                        break;
                    case "History":
                        console.log("History");
                        break;
                    case "Ratings":
                        console.log("Ratings");
                        break;
                    case "Block":
                        console.log("Block");
                        break;
                    case "setting":
                        const saddress = JSON.parse(result);
                        if(saddress.address.length != 0){
                            showaddress(saddress.address);
                        }
                        break;
                    default:
                        console.log("New");
                }
            }
        });
    }

    // save setting details
    $('#save-details').on('click',function(e){
        is_valid = true;
        var email = $('#semail').val();
        e.preventDefault();
        $('.error').remove();
        // details validation
        feildValidation($('#sfname').val(),'#sfname',"First Name");
        feildValidation($('#slname').val(),'#slname',"Last Name");
        phoneValidation($('#cphone').val(),'#cphone');
        // address validation
        feildValidation($('#Streetname').val(),'#Streetname',"Street Name");
        feildValidation($('#Housenumber').val(),'#Housenumber',"House Number");
        feildValidation($('#Postalcode').val(),'#Postalcode',"Postal Code");
        feildValidation($('#city').val(),'#city',"City");
        if(is_valid == true){
            $.ajax({
                url : "http://localhost/psd-to-html/Helperland/?controller=Servicer&function=editSetting",
                type : 'POST',
                data : $('#servicer-form').serialize()+"&userId="+userid+"&email="+email,
                success : function(result){
                    var user = JSON.parse(result);
                    // console.log(JSON.parse(result));
                    $('#welcome-name').text(user.save['FirstName']);
                    $('#wname').text(user.save['FirstName']+" "+user.save['LastName']);
                },
                complete : function(result){
                    $.LoadingOverlay("hide");
                }
            });
        }
        else{
            $.LoadingOverlay("hide");
        }
    });

    // show address
    function showaddress(address){
        // show avtar
        var avtar = `<img src='assets/images/${address.UserProfilePicture}'>`;
        $('.cap1').html(avtar);
        var selectAv = $('.avatar label input[name=avtar]');
        for (var i = 0; i < selectAv.length; i++) {
            if ($('#avtar' + i).val() == address.UserProfilePicture.split(".")[0]) {
                $('#avtar' + i).prop('checked',true);
                $('#avtar' + i).parent().find('div').addClass('selectAv');
            }
            else {
                $('#avtar' + i).parent().find('div').removeClass('selectAv');
            }
        }
        // show gender
        var selectGd = $('.gender input[name=Gender]');
        for (var i = 0; i < selectGd.length; i++) {
            if ($('#Gender' + i).val() == address.Gender) {
                $('#Gender' + i).prop('checked',true);
            }
        }
        // show address
        $('#Streetname').val(address.AddressLine1.split(" ")[0]);
        $('#Housenumber').val(address.AddressLine1.split(" ")[1]);
        $('#Postalcode').val(address.PostalCode);
        $('#city').val(address.City);
    }

    // service provider avtar
    $(document).on('click', '.avatar .avtar-img', function () {
        var selectAv = $('.avatar label input[name=avtar]');
        for (var i = 0; i < selectAv.length; i++) {
            if ($('#avtar' + i).is(':checked')) {
                $('#avtar' + i).parent().find('div').addClass('selectAv');
            }
            else {
                $('#avtar' + i).parent().find('div').removeClass('selectAv');
            }
        }
    });

    $("input[name='avtar']").click(function(){
        var avtar = $(this).val();
        $.ajax({
            url : "http://localhost/psd-to-html/Helperland/?controller=Servicer&function=avtar",
            type : "POST",
            data : {avtar:avtar,userid:userid},
            success : function(result){
                if(JSON.parse(result).status){
                    // console.log("avtar set");
                    var img = `<img src='assets/images/${avtar}.png'>`;
                    $('.cap1').html(img);
                }else{
                    console.log("avtar not set");
                }
            }
        });
    });

    // change password 
    $('#change-psw').click(function(){
        is_valid = true;
        $('.error').remove();
        var oldpsw = $('#oldpsw').val();
        var newpsw = $('#newpsw').val();
        var cpsw = $('#cpsw').val();
        if(oldpsw.length < 1){
            $('#oldpsw').after("<span class='error'>Password can't be empty</span>");
        }
        var result1 = passwordValidation('#newpsw',newpsw);
        var result2 = passwordValidation('#cpsw',cpsw);
        if(result1 == true && result2 == true){
            passVerify('#newpsw',newpsw,cpsw);
        }
        if(is_valid == true){
            $.ajax({
                url : "http://localhost/psd-to-html/Helperland/?controller=Servicer&function=changePassword",
                type : 'POST',
                data : {userid : userid,oldpsw : oldpsw,newpsw : newpsw},
                success : function(result){
                    var status = JSON.parse(result);
                    if(!status.success.yes){
                        $('#oldpsw').after("<span class='error'>Please insert valid old password</span>");
                        $.LoadingOverlay("hide");
                        // console.log(status);
                    }
                    else{
                        var alertMsg = "";
                        if(status.success.yes){
                            alertMsg = `<div class='alert alert-success alert-dismissible fade show mt-3' role='alert'>${status.success.smsg}<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>`;
                        }
                        else{
                            alertMsg = `<div class='alert alert-danger alert-dismissible fade show mt-3' role='alert'>${status.success.smsg}<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>`;
                        }
                        $('#password form').before(alertMsg);
                        setTimeout(function(){ 
                            $('.alert').fadeOut(1000) 
                        }, 5000);
                        $.LoadingOverlay("hide");
                    }
                }
            });
        }
        else{
            $.LoadingOverlay("hide");
        }
    });

    // validation 
    function feildValidation(fvalue,id,fname){
        if(fvalue.length < 1){
            $(id).after("<span class='error'>Enter "+ fname +"</span>");
            is_valid = false;
            return;
        }
    }
    function phoneValidation(phone,id){
        var phoneno = /^[\d]{10}$/;
        if(phone.length < 1){
            $(id).parent().after("<span class='error'>Enter Phone Number</span>");
            is_valid = false;
            return;
        }
        else if(!phoneno.test(phone)){
            $(id).parent().after("<span class='error'>Mobile number must 10 digit long</span>");
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
            return is_valid;
        }
        else if(!passReg.test(password)){
            $(id).after("<span class='error'>Password must be 6 to 14 character long including At least one uppercase, lowercase, special char and numbers</span>");
            is_valid = false;
            return is_valid;
        }
        else{
            is_pass_check = true;
            is_valid = true;
            return is_pass_check;
        }
    }
    function passVerify(id,psw,cpsw){
        if(psw != cpsw){
            $(id).after("<span class='error'>Password and confirm password must be same</span>");
            is_valid = false;
            return is_valid;
        }
    }

    // export to excel
    $('#Export').click(function(){
        let data = document.getElementById('table2');
	    var fp = XLSX.utils.table_to_book(data,{sheet:'History'});
	    XLSX.write(fp,{
		    bookType:'xlsx',
		    type:'base64'
	    });
	    XLSX.writeFile(fp, 'service-history.xlsx');
    });
});