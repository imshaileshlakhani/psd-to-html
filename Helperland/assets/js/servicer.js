function sortTable(n){
    var table;
    table = document.getElementById('table');
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
    var date = new Date();
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

    $('#number').change(function () {
        showLoader();
        var limit = $('#number').val();
        var pstatus = $('#payment-status').val();
        var rstatus = $('#rating-status').val();
        ServicerData(limit, page = 1, pstatus, rstatus);
    });

    $(document).on('click', '#pagination', function (e) {
        showLoader();
        var page = $(e.target).closest('div').data("page");
        var pstatus = $('#payment-status').val();
        var rstatus = $('#rating-status').val();
        var limit = $('#number').val();
        if (page != undefined) {
            ServicerData(limit, page, pstatus, rstatus);
        }
        $.LoadingOverlay("hide");
    });

    // service schedule prev month
    $(document).on('click','#left-date',function(){
        date.setMonth(date.getMonth()-1);
        ServicerData(limit = 2, page = 1, pstatus = "All", rstatus = "All");
    });
    // service schedule next month
    $(document).on('click','#right-date',function(){
        date.setMonth(date.getMonth()+1);
        ServicerData(limit = 2, page = 1, pstatus = "All", rstatus = "All");
    });

    function ServicerData(limit = 2, page = 1, pstatus = "All", rstatus = "All") {
        var tabName = $('#tab-name').val();
        var onePageData = limit;
        var defaultPage = page;
        var withpet = 0;
        var today = date.getFullYear() + "-" + ("0" + (date.getMonth() + 1)).slice(-2) + "-" + ("0" + date.getDate()).slice(-2)
        // console.log(date);
        if ( $('#withpet').is(":checked") ){
            withpet = 1;
        }
        $.ajax({
            url: "http://localhost/psd-to-html/Helperland/?controller=Servicer&function=servicerData",
            type: "POST",
            data: { pageName: tabName, userid: userid, limit: onePageData, page: defaultPage, pstatus: pstatus, rstatus: rstatus, withpet: withpet, date: today},
            success: function (result) {
                // console.log(result);
                const Data = JSON.parse(result);
                switch (tabName) {
                    case "New":
                        showNewService(Data.service);
                        if(Data.paginationData != 0){
                            $('#totalrequest').text(Data.paginationData.Totalrecord);
                            paginationHtml(Data.paginationData);
                        } 
                        break;
                    case "Upcoming":
                        showUpcomingService(Data.service);
                        if(Data.paginationData != 0){
                            $('#totalrequest').text(Data.paginationData.Totalrecord);
                            paginationHtml(Data.paginationData);
                        } 
                        break;
                    case "History":
                        showHistory(Data.service);
                        if(Data.paginationData != 0){
                            $('#totalrequest').text(Data.paginationData.Totalrecord);
                            paginationHtml(Data.paginationData);
                        } 
                        break;
                    case "Schedule":
                        $('#ups').html(Data.html);
                        window.services = Data.service;
                        break;
                    case "Ratings":
                        showRating(Data.service);
                        if(Data.paginationData != 0){
                            $('#totalrequest').text(Data.paginationData.Totalrecord);
                            paginationHtml(Data.paginationData);
                        } 
                        break;
                    case "Block":
                        showFavBlockSp(Data.service);
                        if(Data.paginationData != 0){
                            $('#totalrequest').text(Data.paginationData.Totalrecord);
                            paginationHtml(Data.paginationData);
                        } 
                        break;
                    case "setting":
                        if(Data.address.length != 0){
                            showaddress(Data.address);
                        }
                        break;
                    default:
                        showNewService(Data.service);
                        if(Data.paginationData != 0){
                            $('#totalrequest').text(Data.paginationData.Totalrecord);
                            paginationHtml(Data.paginationData);
                        }
                }
            },
            complete : function(result){
                $.LoadingOverlay("hide");
                if(page >= 3){
                    $('#page3').text(page);
                    $('#page3').addClass('active');
                    $('#page3').data('page',page);
                }
            }
        });
    }

    // show new service
    function showNewService(newServices){
        var newServiceHtml = "";
        newServices.forEach(function(service){
            var fullName = service.FirstName + " " + service.LastName;
            var address = service.AddressLine1+" "+service.AddressLine2 +","+service.PostalCode+" "+service.City;
            const obj = getTimeAndDate(service.ServiceStartDate, service.ServiceHours);
            newServiceHtml += `<tr class="text-center" data-serviceid="${service.ServiceRequestId}" data-bs-toggle="modal" data-bs-target="#servicedetails1" data-bs-dismiss="modal" data-totalhr="${service.ServiceHours}" data-starttime="${obj.starttime}" data-startdate="${obj.startdate}">
                                    <td>
                                        <div>${service.ServiceRequestId}</div>
                                    </td>
                                    <td>
                                        <div> <img src="assets/images/calendar2.png" alt=""> ${obj.startdate}</div>
                                        <div> <img src="assets/images/layer-14.png" alt=""> ${obj.starttime} - ${obj.endtime}</div>
                                    </td>
                                    <td>
                                        <div>${fullName}</div>
                                        <div> <img src="assets/images/layer-15.png" alt=""> ${address}</div>
                                    </td>
                                    <td>${service.TotalCost} €</td>
                                    <td></td>
                                    <td class="Accept"><a href="#" data-serviceid="${service.ServiceRequestId}">Accept</a></td>
                                </tr>`;
        });
        $('.table1 .tbody').html(newServiceHtml);
    }

    // with pet service
    $('#withpet').change(function(){
        showLoader();
        var limit = $('#number').val();
        ServicerData(limit, page = 1);
    });

    // accept request
    $('#Accept-button').click(function(e){
        var limit = $('#number').val();
        var serviceId = $(this).data('serviceid');
        var workinghr = +$(this).data('totalhr');
        var starttime = $(this).data('starttime');
        var startdate = $(this).data('startdate');
        // alert(starttime+" "+workinghr);
        $.ajax({
            url: "http://localhost/psd-to-html/Helperland/?controller=Servicer&function=serviceAccept",
            type: "POST",
            data: { serviceId: serviceId,userid: userid,workinghr: workinghr,starttime: starttime,startdate: startdate},
            success: function (result) {
                const status = JSON.parse(result);
                // console.log(result);
                if (status.error == "") {
                    $("#servicedetails1").modal('hide');
                    $("#successModal #success-msg").text("Service request has been accepted successfully");
                    $('#successModal #service-id').text(`Accepted service id : ${serviceId}`);
                    
                } else {
                    $("#servicedetails1").modal('hide');
                    $("#successModal #success-msg").text(status.error);
                    $('#successModal #service-id').text("");
                    // alert(status.error);
                }
                $("#successModal button").prop('onclick', null);
                $("#successModal").modal('show');
            },
            complete : function(result){
                $.LoadingOverlay("hide");
                ServicerData(limit);
            }
        });
    });
    
    // show upcoming service
    function showUpcomingService(upcomingServices){
        var upcomingServiceHtml = "";
        upcomingServices.forEach(function(service){
            var fullName = service.FirstName + " " + service.LastName;
            var address = service.AddressLine1+" "+service.AddressLine2 +","+service.PostalCode+" "+service.City;
            const obj1 = getTimeAndDate(service.ServiceStartDate, service.ServiceHours);
            upcomingServiceHtml += `<tr class="text-center" data-bs-toggle="modal" data-serviceid="${service.ServiceRequestId}" data-bs-target="#servicedetails" data-bs-dismiss="modal">
                                    <td>
                                        <div>${service.ServiceRequestId}</div>
                                    </td>
                                    <td>
                                        <div> <img src="assets/images/calendar2.png" alt=""> ${obj1.startdate}</div>
                                        <div> <img src="assets/images/layer-14.png" alt=""> ${obj1.starttime} - ${obj1.endtime}</div>
                                    </td>
                                    <td>
                                        <div>${fullName}</div>
                                        <div> <img src="assets/images/layer-15.png" alt=""> ${address}</div>
                                    </td>
                                    <td>${service.TotalCost} €</td>
                                    <td> - </td>
                                    <td class="cancle"><a href="#" class="cancle-service" data-bs-toggle="modal" data-bs-target="#servicecancle" data-bs-dismiss="modal" data-serviceid="${service.ServiceRequestId}">Cancle</a></td>
                                </tr>`;
        });
        $('.table2 .tbody').html(upcomingServiceHtml);
    }

    // service cancle model
    $(document).on('click', '.cancle-service', function (e) {
        window.serviceIdforCancle = $(this).data('serviceid');
        // alert(serviceIdforCancle);
        $('#service-msg').on('keyup', function () {
            var msg = $('#service-msg').val();
            if (msg.length < 1) {
                $('.complete-button').attr('disabled', true);
            } else {
                $('.complete-button').attr('disabled', false);
            }
        });
        $('.complete-button').click(function () {
            cancleService(serviceIdforCancle);
            window.serviceIdforCancle = 0;
            $('#service-msg').val("");
        });
    });
    function cancleService(serviceIdforCancle) {
        var limit = $('#number').val();
        var cancleMsg = $('#service-msg').val();
        var sid = serviceIdforCancle;
        if(sid != 0){
            $.ajax({
                url: "http://localhost/psd-to-html/Helperland/?controller=Servicer&function=serviceCancle",
                type: "POST",
                data: { serviceId: sid, cancleMsg: cancleMsg },
                success: function (result) {
                    const status = JSON.parse(result);
                    // console.log(status);
                    if (status.update == true) {
                        $("#successModal #success-msg").text('Service request has been cancelled successfully');
                        $('#successModal #service-id').text(`Cancelled Request Id : ${sid}`);
                        $("#successModal button").prop('onclick', null);
                        $("#successModal").modal('show');
                    } else {
                        alert("Somthing went wrong");
                    }
                },
                complete : function(result){
                    $.LoadingOverlay("hide");
                    ServicerData(limit);
                    $('#service-msg').val("");
                }
            });
        }
    }

    $('#table .tbody').on('click', function (e) {
        var serviceId = $(e.target).closest('tr').data('serviceid');
        // alert(tabName);
        $.ajax({
            url : "http://localhost/psd-to-html/Helperland/?controller=Servicer&function=serviceDetails",
            type : "POST",
            data : {userid: userid, serviceId: serviceId},
            success : function(result){
                const details = JSON.parse(result);
                // console.log(details);
                if(details.service){
                    serviceDetailsModel(details.service);
                }
                else{
                    alert("somthing went wrong");
                }
            }
        });
    });

    // service schedule open model
    $(document).on('click','.event',function(e){
        var clickId = $(e.target).attr('id');
        var recordId = clickId.split("_")[1];
        // alert(recordId);
        serviceDetailsModel(window.services[recordId]);
    });

    // service-details model
    function serviceDetailsModel(service) {
        var petHtml = "";
        var extraHtml = "";
        var extras = ['Inside cabinets', 'Inside fridge', 'Inside oven', 'Laundry wash & dry', 'Interior windows'];
        var selectedExtra = service['ServiceExtraId'].split("");
        
        if(selectedExtra[0] != 0){
            for (var i = 0; i < selectedExtra.length; i++) {
                if (i != (selectedExtra.length - 1)) {
                    extraHtml += extras[selectedExtra[i] - 1] + ", ";
                }
                else {
                    extraHtml += extras[selectedExtra[i] - 1] + ".";
                }
            }
        }
        
        const dateTime = getTimeAndDate(service['ServiceStartDate'], service['ServiceHours']);
        $('.model-time').text(dateTime.startdate + " " + dateTime.starttime + " - " + dateTime.endtime);
        $('.duration-model').text(service['ServiceHours'] + " Hrs");
        $('.sid-model').text(service['ServiceRequestId'] + ".");
        $('.extra-model').text(extraHtml);
        $('.model-price').text(service['TotalCost'] + " €");
        $('.cname').text(service['FirstName'] + " " + service['LastName']);
        $('.address-model').text(service['AddressLine1']+" "+service['AddressLine2'] +","+ service['PostalCode'] +" "+service['City']);
        $('#complete-button').data('serviceid',service['ServiceRequestId']);
        $('#complete-button').data('customerId',service['UserId']);
        $('.cancle-service').data('serviceid',service['ServiceRequestId']);
        $('.Accept-button').data('serviceid',service['ServiceRequestId']);
        $('.Accept-button').data('totalhr',service['ServiceHours']);
        $('.Accept-button').data('starttime',dateTime.starttime);
        $('.Accept-button').data('startdate',service['ServiceStartDate'].split(" ")[0]);

        var serviceDate = service['ServiceStartDate'].split(" ")[0];
        var currentDate = new Date().toISOString().split("T")[0];
        var currentTime = Date().slice(16,21);
        // console.log(currentTime+" "+dateTime.endtime);
        if(currentDate >= serviceDate){
            if(currentTime >= dateTime.endtime){
                $('.service-complete-button').removeClass('d-none');
            }else{
                $('.service-complete-button').addClass('d-none');
            }
        }else{
            $('.service-complete-button').addClass('d-none');
        }

        if (service['HasPets'] == "1") {
            petHtml += `<i class="fa fa-check-circle-o"></i> <span>I have pets at home</span>`;
        }
        else {
            petHtml += `<i class="fa fa-times-circle-o"></i> <span>I dont't have pets at home</span>`;
        }
        $('.pet-model').html(petHtml);
    }

    // complete service
    $('#complete-button').click(function(){
        var limit = $('#number').val();
        var serviceId = $(this).data('serviceid');
        var customerId = $(this).data('customerId');
        // alert(customerId);
        $.ajax({
            url : "http://localhost/psd-to-html/Helperland/?controller=Servicer&function=serviceComplete",
            type : "POST",
            data : {userid: userid, serviceId: serviceId, customerId: customerId},
            success : function(result){
                const scomplete = JSON.parse(result);
                // console.log(scomplete);
                if(scomplete.save){
                    $("#servicedetails").modal('hide');
                    $("#successModal #success-msg").text('Service request has been completed successfully');
                    $('#successModal #service-id').text(`Completed Request Id : ${serviceId}`);
                    $("#successModal button").prop('onclick', null);
                    $("#successModal").modal('show');
                }
                else{
                    alert("somthing went wrong");
                }
            },
            complete : function(result){
                $.LoadingOverlay("hide");
                ServicerData(limit);
            }
        });
    });

    // show service history
    function showHistory(history){
        var historyHtml = "";
        history.forEach(function(service){
            var fullName = service.FirstName + " " + service.LastName;
            var address = service.AddressLine1+" "+service.AddressLine2 +","+service.PostalCode+" "+service.City;
            const obj2 = getTimeAndDate(service.ServiceStartDate, service.ServiceHours);
            historyHtml += `<tr class="text-center">
                                    <td>
                                        <div>${service.ServiceRequestId}</div>
                                    </td>
                                    <td>
                                        <div> <img src="assets/images/calendar2.png" alt=""> ${obj2.startdate}</div>
                                        <div> &nbsp; <img src="assets/images/layer-14.png" alt=""> ${obj2.starttime} - ${obj2.endtime}</div>
                                    </td>
                                    <td>
                                        <div>${fullName}</div>
                                        <div> &nbsp; <img src="assets/images/layer-15.png" alt=""> ${address}</div>
                                    </td>
                                    <td>`;
                                    if (service.Status == 3) {
                                        historyHtml += `<a class="Cancelled">Cancelled`;
                                    }
                                    else {
                                        historyHtml += `<a>Completed`;
                                    }
                            historyHtml += `</a></td>
                                </tr>`;
        });
        $('.table3 .tbody').html(historyHtml);
    }

    // short by service status
    $('#payment-status').change(function(){
        showLoader();
        var pstatus = $(this).val();
        var limit = $('#number').val();
        ServicerData(limit, page = 1,pstatus);
    });

    // show service rating
    function showRating(rating){
        var ratingHtml = "";
        rating.forEach(function(service){
            const obj4 = getTimeAndDate(service.ServiceStartDate, service.ServiceHours);
            ratingHtml += `<div class="service-rating p-3 mb-3">
                                <div class="d-flex justify-content-between flex-wrap">
                                    <div class="d-flex flex-wrap mb-2">
                                        <div class="">
                                            <div>${service.ServiceRequestId}</div>
                                            <div><b>${service.FirstName} ${service.LastName}</b></div>
                                        </div>
                                        <div class="mx-5">
                                            <div> <img src="assets/images/calendar2.png" alt=""><b> ${obj4.startdate}</b></div>
                                            <div> <img src="assets/images/layer-14.png" alt=""> ${obj4.starttime} - ${obj4.endtime}</div>
                                        </div>
                                    </div>
                                    <div>
                                        <div><b>ratings</b></div>
                                        <div>`;
                                            rating = spRating(service.Ratings);
                                            ratingHtml += `${rating}
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="c-comment-title"><b>Customer Comment</b></div>
                                <div class="c-comment">${service.Comments}</div>
                            </div>`;
        });
        $('#ups').html(ratingHtml);
    }

    // service provider rating function
    function spRating(avgrating) {
        const arr = ['Bad','Fair','Average','Good','Excellent'];
        var ratingHtml = "";
        var i = 0;
        for (var i = 0; i < Math.floor(avgrating); i++) {
            ratingHtml += `<img src="assets/images/star-filled.png" alt="">`;
        }
        if ((avgrating - Math.floor(avgrating)) > 0) {
            ratingHtml += `<img src="assets/images/star-half-empty.png" alt="">`;
            i++;
        }
        for (var j = 0; j < 5 - i; j++) {
            ratingHtml += `<img src="assets/images/star-empty.png" alt="">`;
        }
        
            ratingHtml += ` &nbsp;${arr[Math.floor(avgrating)]}`;
        return ratingHtml;
    }

    // short by rating
    $('#rating-status').change(function(){
        showLoader();
        var rstatus = $(this).val();
        var limit = $('#number').val();
        ServicerData(limit, page = 1,pstatus = "All",rstatus);
    });

    // Favourite pros page
    function showFavBlockSp(block){
        var favspHtml = "";
        block.forEach(function (sp) {
            favspHtml += `<div class="fav-card py-4" data-cid="${sp.TargetUserId}">
                                <div class="cap d-flex align-items-center justify-content-center">
                                    <img src="assets/images/${sp.UserProfilePicture}" alt="">
                                </div>
                                <div class="name mt-3 mb-4">
                                    <div class="text-center">${sp.FirstName+" "+sp.LastName}</div>
                                </div>
                                <div class="btns-div">`;
                                    if(sp.IsBlocked == 1){
                                        favspHtml += `<a href="#" id="BlockSp" data-action="IsBlocked" data-blocks="${sp.IsBlocked}" class="Block">UnBlock</a>`;
                                    }else{
                                        favspHtml += `<a href="#" id="BlockSp" data-blocks="${sp.IsBlocked}" class="Block">Block</a>`;
                                    }
                                favspHtml += `</div>
                        </div>`;
        });
        $('#ups').html(favspHtml);
    }

    $(document).on('click','#BlockSp',function(e){
        var cid = $(e.target).closest('.fav-card').data('cid');
        var blocks = $(e.target).data('blocks');
        // alert(cid);
        blockCustomer(cid,blocks);
    });

    function blockCustomer(cid,status){
        var customerId = cid;
        var fbstatus = status;
        var limit = $('#number').val();
        $.ajax({
            url : "http://localhost/psd-to-html/Helperland/?controller=Servicer&function=blockCustomer",
            type : "POST",
            data : {userId: userid, customerId: customerId, fbstatus: fbstatus},
            success : function(result){
                const blockStatus = JSON.parse(result);
                if(blockStatus.status){
                    ServicerData(limit);
                }
                else{
                    alert("somthing went wrong");
                }
            }
        });
    }

    $(document).on('keyup','#Postalcode',function(){
        var postal = $('#Postalcode').val();
        $.ajax({
          url : "http://localhost/psd-to-html/Helperland/?controller=Servicer&function=getCity",
          type : "POST",
          data : {postal: postal},
          success : function(result){
            const data = JSON.parse(result);
            var cityHtml = `<option value="0" selected>Select city</option>`;
            console.log(data.status);
            if(data.status){
              data.record.forEach(function(city){
                cityHtml += `<option value="${city.CityName}">${city.CityName}</option>`;
              });
            }
            $("#city").html(cityHtml);
          }
        });
    });

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
        postalValidation('#Postalcode',$('#Postalcode').val());
        cityValidation('#city',$('#city').val());
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
        $('#Streetname').val(address.AddressLine1);
        $('#Housenumber').val(address.AddressLine2);
        $('#Postalcode').val(address.PostalCode);
        var city = `<option value="${address.City}">${address.City}</option>`;
        $('#city').html(city);
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

    // pagination for dashboard and service-history pages
    function paginationHtml(paginationData) {
        var limit = paginationData.limit;
        var totalRecord = paginationData.Totalrecord;
        var totalPage = (Math.ceil(totalRecord / limit) == 0) ? 1: Math.ceil(totalRecord / limit);
        var currentPage = +paginationData.page;
        var next = currentPage + 1;
        var prev = currentPage - 1;
        if(prev < 1){
            prev = 1;
        }
        if(next >= totalPage){
            next = totalPage;
        }
        var paginationHtml = `<div data-page='1'>
                                <img src='assets/images/group-363.png'>
                            </div>
                            <div data-page='${prev}'>
                                <img src='assets/images/keyboard-right-arrow-button-copy.png'>
                            </div>`;
        for (var i = 1; i <= totalPage; i++) {
            if(i <= 3){
                if (i == currentPage) {
                    paginationHtml += `<div class='active' data-page='${i}' id='page${i}'>${i}</div>`;
                }
                else {
                    paginationHtml += `<div data-page='${i}' id='page${i}'>${i}</div>`;
                }
            }
        }
        paginationHtml += `<div id='next-tab' data-page='${next}'>
                                <img src='assets/images/keyboard-right-arrow-button-copy.png'>
                            </div>
                            <div id='next-last-tab' data-page='${totalPage}'>
                                <img src='assets/images/group-363.png'>
                            </div>`;
        $('.table-footer #pagination').html(paginationHtml);
    }

    // get time and date in required format
    function getTimeAndDate(sdate, stime) {
        var dateobj = new Date(sdate);
        var startdate = dateobj.toLocaleDateString("en-AU");
        // console.log(startdate);
        var starttime = ("0" + dateobj.getHours()).slice(-2) + ":" + ("0" + dateobj.getMinutes()).slice(-2);
        var totalhour = stime;

        var endhour = dateobj.getHours() + Math.floor(totalhour);
        var endmin = (totalhour - Math.floor(totalhour)) * 60 + dateobj.getMinutes();
        if (endmin >= 60) {
            endhour = endhour + Math.floor(endmin / 60);
            endmin = (endmin / 60 - Math.floor(endmin / 60)) * 60;
        }
        var endtime = ("0" + endhour).slice(-2) + ":" + ("0" + endmin).slice(-2);
        return { startdate: startdate, starttime: starttime, endtime: endtime };
    }

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
    function postalValidation(id,value){
        if(value.length < 6){
            $(id).after(`<span class='error'>Enter valid zipcode</span>`);
            is_valid = false;
            return;
        }
    }
    function cityValidation(id,value){
      if(value == 0){
          $(id).after(`<span class='error'>Select valid city</span>`);
          is_valid = false;
          return;
      }
    }

    // export to excel
    $('#Export').click(function(){
        let data = document.getElementById('table');
	    var fp = XLSX.utils.table_to_book(data,{sheet:'History'});
	    XLSX.write(fp,{
		    bookType:'xlsx',
		    type:'base64'
	    });
	    XLSX.writeFile(fp, 'service-history.xlsx');
    });
});