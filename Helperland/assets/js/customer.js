function defaultDate() {
    var date = new Date();
    day = date.getDate();
    month = date.getMonth() + 1;
    year = date.getFullYear();
    var fulldate = day + "/" + month + "/" + year;
    document.getElementById("rdate").defaultValue = year + "-" + ("0" + month).slice(-2) + "-" + ("0" + day).slice(-2);
}
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
    var is_valid = true;

    const userid = $('#userdata').val();
    customerData();

    $('#Dashboard').click(function () {
        customerData();
    });
    $('#History').click(function () {
        customerData();
    });
    $('#Favourite').click(function () {
        customerData();
    });
    $('#setting').click(function () {
        customerData();
    });

    $('#number').change(function () {
        showLoader();
        var limit = $('#number').val();
        customerData(limit);
    });

    $(document).on('click', '#pagination', function (e) {
        showLoader();
        var page = $(e.target).closest('div').data("page");
        // console.log(page);
        var limit = $('#number').val();
        if (page != undefined) {
            customerData(limit, page);
        }
        $.LoadingOverlay("hide");
    });

    function customerData(limit = 2, page = 1) {
        var onePageData = limit;
        var defaultPage = page;
        // console.log(defaultPage);
        var tabName = $('#tab-name').val();
        var userId = $('#userdata').val();
        $.ajax({
            url: "http://localhost/psd-to-html/Helperland/?controller=Customer&function=customerData",
            type: "POST",
            data: { pageName: tabName, userid: userId, limit: onePageData, page: defaultPage },
            success: function (result) {
                // console.log(result);
                const Data = JSON.parse(result);
                switch (tabName) {
                    case "Dashboard":
                        showServices(Data.service);
                        if(Data.paginationData != 0){
                            $('#totalrequest').text(Data.paginationData.Totalrecord);
                            paginationHtml(Data.paginationData);
                        } 
                        break;
                    case "History":
                        showServiceHistory(Data.service);
                        if(Data.paginationData != 0){
                            $('#totalrequest').text(Data.paginationData.Totalrecord);
                            paginationHtml(Data.paginationData);
                        }
                        break;
                    case "Favourite":
                        showFavBlockSp(Data.favSp);
                        if(Data.paginationData != 0){
                            $('#totalrequest').text(Data.paginationData.Totalrecord);
                            paginationHtml(Data.paginationData);
                        } 
                        break;
                    case "setting":
                        showMyAddress(Data.saddress);
                        // console.log(settingAddress.saddress);
                        break;
                    default:
                        showServices(Data.service);
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

    function showServices(services) {
        var serviceHtml = "";
        services.forEach(function (service) {
            let arr = [];
            var rating = "";
            var fullName = service.FirstName + " " + service.LastName;
            const obj = getTimeAndDate(service.ServiceStartDate, service.ServiceHours);
            var spid = 0;
            if(service.ServiceProviderId != null){
                spid = service.ServiceProviderId;
            }

            arr = json2array(service);
            // console.log(arr);
            serviceHtml += `<tr class="text-center table1-row" data-bs-toggle="modal" data-bs-target="#servicedetails" data-bs-dismiss="modal">
                <input type="hidden" value="${arr}">
                <td>${service.ServiceRequestId}</td>
                <td>
                    <span><img src="assets/images/calendar2.png" alt=""> ${obj.startdate}</span>
                    <span> &nbsp; <img src="assets/images/layer-14.png" alt=""> ${obj.starttime} - ${obj.endtime}</span>
                </td>
                <td class="avg-ratting">`;
                if (service.ServiceProviderId != null) {
                    serviceHtml += `<div class="d-flex justify-content-center">`;
                    rating = spRating(fullName,service.avgRatting.avgrating,service.UserProfilePicture);
                    // console.log(rating);
                    serviceHtml += `${rating}</span>
                                        </div>
                                    </div>`
                }
            serviceHtml += `</td>
                <td class="payment">
                    <a>${service.TotalCost}</a>€
                </td>
                <td class="action">`
                    if(service.RecordVersion == 1){
                        serviceHtml += `<span class="text-success w-50 mx-auto">You can't rescheduled service request.untill Your SP will accept it</span>`;
                    }else{
                        serviceHtml += `<a href="#" class="Reschedule date-update" data-bs-toggle="modal" data-bs-target="#servicereschedule" data-bs-dismiss="modal" id="date-update" data-totalhr="${service.ServiceHours}" data-starttime="${obj.starttime}" data-serviceid="${service.ServiceRequestId}">Reschedule</a>
                        <a href="#" class="Cancle cancle-service" id="cancle-service" data-bs-toggle="modal" data-bs-target="#servicecancle" data-bs-dismiss="modal" data-serviceid="${service.ServiceRequestId}">Cancle</a>`;
                    }
                    
                    serviceHtml += `</td>
            </tr>`;
        });
        $('.table1 .tbody').html(serviceHtml);
    }

    $('.table1').on('click', function (e) {
        const service = $(e.target).closest('tr').find("input").val();
        // console.log(service.split(","));
        // alert(service);
        var arr = service.split(",")
        serviceDetailsModel(arr);
    });

    function json2array(json) {
        var result = [];
        var keys = Object.keys(json);
        keys.forEach(function (key) {
            result.push(json[key]);
        });
        return result;
    }

    // service cancle model
    $(document).on('click', '.cancle-service', function (e) {
        window.serviceIdforCancle = $(e.target).data('serviceid');
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
        var sid = serviceIdforCancle;
        var cancleMsg = $('#service-msg').val();
        // var limit = $('#number').val();
        if(sid != 0){
            $.ajax({
                url: "http://localhost/psd-to-html/Helperland/?controller=Customer&function=serviceCancle",
                type: "POST",
                data: { serviceId: sid, cancleMsg: cancleMsg },
                success: function (result) {
                    const status = JSON.parse(result);
                    // console.log(status);
                    if (status.update[0] == true) {
                        $.LoadingOverlay("hide");
                        $("#successModal #success-msg").text('Your service request cancelled successfully');
                        $('#successModal #service-id').text(`Canceled Request Id : ${sid}`);
                        $("#successModal button").prop('onclick', null);
                        $("#successModal").modal('show');
                        customerData();
                    } else {
                        alert("Somthing went wrong");
                    }
                }
            });
        }
    }

    // service reschedule model
    $(document).on('click', '.date-update', function (e) {
        $('.alert').remove();
        window.sIdforReschedule = $(e.target).data('serviceid');
        var workinghr = +$(e.target).data('totalhr');
        var starttime = $(e.target).data('starttime');
        // alert(sIdforReschedule);
        $('.update-button').click(function () {
            var rdate = $('#rdate').val();
            var rtime = +$('#rtime').val();
            // console.log(sIdforReschedule+" "+starttime+" "+rtime+" "+workinghr);
            if((rtime + workinghr) >= 21.5){
                alertMsg = `<div class='alert alert-danger alert-dismissible fade show mt-3' role='alert'>Could not completed the service request, because service booking request is must be completed within 21:00 time<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>`;
                $('#r-msg').html(alertMsg);
                // console.log(rtime + workinghr);
                $.LoadingOverlay("hide");
            }else{
                rescheduleService(sIdforReschedule, rdate, rtime,starttime,workinghr);
                window.sIdforReschedule = 0;
            }   
        });
    });

    function rescheduleService(sIdforReschedule, rdate, rtime,starttime,workinghr) {
        showLoader();
        var sid = sIdforReschedule;
        var date = rdate;
        var time = rtime;
        var limit = $('#number').val();
        $('.alert').remove();
        if(sid != 0){
            $.ajax({
                url: "http://localhost/psd-to-html/Helperland/?controller=Customer&function=serviceReschedule",
                type: "POST",
                data: { serviceId: sid, date: date, time: time, starttime: starttime,workinghr:workinghr },
                success: function (result) {
                    console.log(result);
                    const status = JSON.parse(result);
                    var alertMsg="";
                    if (status.dateUpdate[0] == true) {
                        alertMsg = `<div class='alert alert-success alert-dismissible fade show mt-3' role='alert'>Reschedule successfully<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>`;
                        $('#r-msg').html(alertMsg);
                    } else {
                        alertMsg = `<div class='alert alert-danger alert-dismissible fade show mt-3' role='alert'>${status.error}<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>`;
                        $('#r-msg').html(alertMsg);
                    }
                },
                complete: function(result){
                    $.LoadingOverlay("hide");
                    customerData(limit);
                    $('.error').remove();
                }
            });
        }
        else{
            $.LoadingOverlay("hide");
        }
    }

    // service-details model for dashboard
    function serviceDetailsModel(service) {
        var petHtml = "";
        var extraHtml = "";
        var extras = ['Inside cabinets', 'Inside fridge', 'Inside oven', 'Laundry wash & dry', 'Interior windows'];
        var selectedExtra = service[16].split("");
        
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
        
        const dateTime = getTimeAndDate(service[2], service[4]);
        $('#servicedetails .model-time').text(dateTime.startdate + " " + dateTime.starttime + " - " + dateTime.endtime);
        $('#servicedetails #duration-model').text(service[4] + " Hrs");
        $('#servicedetails #sid-model').text(service[0] + ".");
        $('#servicedetails #extra-model').text(extraHtml);
        $('#servicedetails .model-price').text(service[3] + " €");
        $('#servicedetails #address-model').text(service[12] + "," + service[13]);
        $('#servicedetails #phone-model').text(service[14]);
        $('#servicedetails #email-model').text(service[15]);
        $('.complete-button.date-update').data('serviceid',service[0]);
        $('.complete-button.date-update').data('starttime',dateTime.starttime);
        $('.complete-button.date-update').data('totalhr',service[4]);
        $('.cancel-button.cancle-service').data('serviceid',service[0]);

        if (service[6] == "1") {
            petHtml += `<i class="fa fa-check-circle-o"></i> <span>I have pets at home</span>`;
        }
        else {
            petHtml += `<i class="fa fa-times-circle-o"></i> <span>I dont't have pets at home</span>`;
        }
        $('#servicedetails #pet-model').html(petHtml);
    }

    // service-history page
    function showServiceHistory(services) {
        var serviceHistoryHtml = ``;
        services.forEach(function (service) {
            var rating = "";
            var fullName = service.FirstName + " " + service.LastName;
            const obj = getTimeAndDate(service.ServiceStartDate, service.ServiceHours);
            serviceHistoryHtml += `<tr class="text-center" data-name="${fullName}">
                                    <td>
                                        <span> <img src="assets/images/shape-12.png" alt=""> ${obj.startdate} &nbsp;</span>
                                        <span>${obj.starttime} - ${obj.endtime}</span>
                                    </td>
                                    <td>`;
            if (service.ServiceProviderId != null) {
                serviceHistoryHtml += `<div class="d-flex justify-content-center">`;
                rating = spRating(fullName,service.avgRatting.avgrating,service.UserProfilePicture);
                // console.log(rating);
                serviceHistoryHtml += `${rating}</span>
                                    </div>
                                </div>`
            }
            serviceHistoryHtml += `</td>
                                    <td class="payment">
                                        <a>${service.TotalCost} €</a>
                                    </td>
                                    <td>`;
            if (service.Status == 3) {
                serviceHistoryHtml += `<a class="Cancelled">Cancelled`;
            }
            else {
                serviceHistoryHtml += `<a>Completed`;
            }
            serviceHistoryHtml += `</a></td>
                                    <td class="ratesp"><a href="#" id="rate-model-btn"`;
            if (service.Status == 3 || service.ratingDone) {
                serviceHistoryHtml += `style="pointer-events: none;"`;
            }
            serviceHistoryHtml += `data-bs-toggle="modal" data-spid="${service.ServiceProviderId}" data-serviceid="${service.ServiceRequestId}" data-avtar="${service.UserProfilePicture}" data-bs-target="#Ratesp" data-bs-dismiss="modal">`;
            if (service.ratingDone) {
                serviceHistoryHtml += `Rating Done`;
            }
            else{
                serviceHistoryHtml += `Rate SP`;
            }
            serviceHistoryHtml += `</a></td>
            </tr>`;
        });
        $('.table2 .tbody').html(serviceHistoryHtml);
    }

    // service provider rating function
    function spRating(Name,avgrating,avtar) {
        var ratingHtml = "";
        ratingHtml += `<div class="cap d-flex align-items-center justify-content-center">
                            <img src="assets/images/${avtar}" alt="">
                    </div>
                    <div>
                            <span class="text-start">${Name}</span>
                            <span id="ratting-text">`;
        var i = 0;
        for (var i = 0; i < Math.floor(avgrating); i++) {
            ratingHtml += `<img class="sp-star" src="assets/images/star-filled.png" alt="">`;
        }
        if ((avgrating - Math.floor(avgrating)) > 0) {
            ratingHtml += `<img class="sp-star" src="assets/images/star-half-empty.png" alt="">`;
            i++;
        }
        for (var j = 0; j < 5 - i; j++) {
            ratingHtml += `<img class="sp-star" src="assets/images/star-empty.png" alt="">`;
        }
        if(avgrating == 0.0){
            ratingHtml += ` &nbsp;${"0.0"}`;
        }
        else{
            ratingHtml += ` &nbsp;${parseFloat(avgrating).toFixed(1)}`;
        }
        return ratingHtml;
    }

    // rating model
    $(document).on('click','#rate-model-btn',function(e){
        var rateNumber = $(e.target).closest('tr').find('span#ratting-text').text();
        var name = $(e.target).closest('tr').data('name');
        window.servicerid = $(e.target).data('spid');
        window.serviceid = $(e.target).data('serviceid');
        var avtar = $(e.target).data('avtar');
        var ratdisplay = spRating(name,rateNumber,avtar);
        $('#rate-wraper').html(ratdisplay);
    });

    $(document).on('click','#rate-submit',function(){
        var Ontime = parseInt($('.stars1 li.selected').last().data('value'), 10);
        var Friendly = parseInt($('.stars2 li.selected').last().data('value'), 10);
        var Quality = parseInt($('.stars3 li.selected').last().data('value'), 10);
        var ratComment = $('.rate-comment').val();
        var spid = window.servicerid;
        var serviceid = window.serviceid;
        // console.log(Ontime+" "+Friendly+" "+Quality+" "+ratComment);
        $.ajax({
            url : "http://localhost/psd-to-html/Helperland/?controller=Customer&function=giveRatting",
            type : "POST",
            data : {Ontime:Ontime,Friendly:Friendly,Quality:Quality,ratComment:ratComment,userId:userid,spid:spid,serviceid:serviceid},
            success : function(result){
                if(JSON.parse(result).status){
                    alert(JSON.parse(result).successmsg);
                    customerData();
                    defaultRatting();
                }
                else{
                    alert(JSON.parse(result).errormsg);
                }
            }
        });
    });

    function defaultRatting(){
        window.servicerid = 0;
        window.serviceid = 0;
        $('.rate-comment').val("");
        $('.stars li.star').removeClass('selected');
    }

    // rating to service provider
    $('.stars li').on('mouseover', function () {
        var onStar = parseInt($(this).data('value'), 10);
        $(this).parent().children('li.star').each(function (e) {
            if (e < onStar) {
                $(this).addClass('hover');
            }
            else {
                $(this).removeClass('hover');
            }
        });
    }).on('mouseout', function () {
        $(this).parent().children('li.star').each(function (e) {
            $(this).removeClass('hover');
        });
    });
    $('.stars li').on('click', function () {
        var onStar = parseInt($(this).data('value'), 10);
        var stars = $(this).parent().children('li.star');
        for (i = 0; i < stars.length; i++) {
            $(stars[i]).removeClass('selected');
        }
        for (i = 0; i < onStar; i++) {
            $(stars[i]).addClass('selected');
        }
    });

    // Favourite pros page
    function showFavBlockSp(servicer){
        var favspHtml = "";
        servicer.forEach(function (sp) {
            favspHtml += `<div class="fav-card py-4" data-spid="${sp.TargetUserId}">
                                <div class="cap d-flex align-items-center justify-content-center">
                                    <img src="assets/images/${sp.UserProfilePicture}" alt="">
                                </div>
                                <div class="rating mt-3 mb-4">
                                    <div class="text-center">${sp.FirstName+" "+sp.LastName}</div>
                                    <div class="text-center">`;
                                    var i = 0;
                                    for (var i = 0; i < Math.floor(sp.avgRatting.avgrating); i++) {
                                        favspHtml += `<img class="sp-star" src="assets/images/star-filled.png" alt="">`;
                                    }
                                    if ((sp.avgRatting.avgrating - Math.floor(sp.avgRatting.avgrating)) > 0) {
                                        favspHtml += `<img class="sp-star" src="assets/images/star-half-empty.png" alt="">`;
                                        i++;
                                    }
                                    for (var j = 0; j < 5 - i; j++) {
                                        favspHtml += `<img class="sp-star" src="assets/images/star-empty.png" alt="">`;
                                    }
                                    if(sp.avgRatting.avgrating == 0.0){
                                        favspHtml += ` ${"0.0"}`;
                                    }
                                    else{
                                        favspHtml += ` ${parseFloat(sp.avgRatting.avgrating).toFixed(1)}`;
                                    }
                                favspHtml += `</div>
                                    <div class="text-center mt-3">${sp.totalService} Cleanings</div>
                                </div>
                                <div class="btns-div">`;
                                    if(sp.IsFavorite == 1){
                                        favspHtml += `<a href="#" id="FavSp" data-action="IsFavorite" data-favs="${sp.IsFavorite}" class="Remove">Remove</a> `;
                                    }else{
                                        favspHtml += `<a href="#" id="FavSp" data-action="IsFavorite" data-favs="${sp.IsFavorite}" class="Remove">Add</a> `;
                                    }
                                    if(sp.IsBlocked == 1){
                                        favspHtml += `<a href="#" id="BlockSp" data-action="IsBlocked" data-blocks="${sp.IsBlocked}" class="Block">UnBlock</a>`;
                                    }else{
                                        favspHtml += `<a href="#" id="BlockSp" data-action="IsBlocked" data-blocks="${sp.IsBlocked}" class="Block">Block</a>`;
                                    }
                                    favspHtml += `</div>
                            </div>`;
        });
        $('#ups').html(favspHtml);
    }

    // fav and block sp
    $(document).on('click','#FavSp',function(e){
        var spid = $(e.target).closest('.fav-card').data('spid');
        var action = $(e.target).data('action');
        var favs = $(e.target).data('favs');
        // alert(spid);
        FavBlockSp(spid,action,favs);
    });
    $(document).on('click','#BlockSp',function(e){
        var spid = $(e.target).closest('.fav-card').data('spid');
        var action = $(e.target).data('action');
        var blocks = $(e.target).data('blocks');
        // alert(spid);
        FavBlockSp(spid,action,blocks);
    });

    function FavBlockSp(spid,action,status){
        var servicerId = spid;
        var fbaction = action;
        var fbstatus = status;
        var limit = $('#number').val();
        var userId = $('#userdata').val();
        $.ajax({
            url : "http://localhost/psd-to-html/Helperland/?controller=Customer&function=favBlockSp",
            type : "POST",
            data : {userId: userId, servicerId: servicerId, fbaction: fbaction, fbstatus: fbstatus},
            success : function(result){
                const favstatus = JSON.parse(result);
                if(favstatus.status){
                    customerData(limit);
                }
                else{
                    alert("somthing went wrong");
                }
            }
        });
    }

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

    // save setting details
    $('#save-sdetails').on('click',function(e){
        is_valid = true;
        e.preventDefault();
        $('.error').remove();
        feildValidation($('#sfname').val(),'#sfname',"First Name");
        feildValidation($('#slname').val(),'#slname',"Last Name");
        phoneValidation($('#cphone').val(),'#cphone');
        if(is_valid == true){
            $.ajax({
                url : "http://localhost/psd-to-html/Helperland/?controller=Customer&function=editSetting",
                type : 'POST',
                data : $('#setting-details-form').serialize()+"&userId="+userid,
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

    // my-setting address tab display
    function showMyAddress(address){
        var addressHtml = `<tr class="th">
                                <th>Addresses</th>
                                <th class="text-end">Action</th>
                            </tr>`;
                address.forEach(function(ad){
                    addressHtml += `<tr data-addressid="${ad.AddressId}" data-state="${ad.State}">
                                <td>
                                    <div><b>Address:</b> ${ad.AddressLine1} ${ad.AddressLine2}, ${ad.PostalCode} ${ad.City}</div>
                                    <div><b>Phone number:</b> ${ad.Mobile}</div>
                                </td>
                                <td class="action text-end">
                                    <a href="#" class="Edit" data-bs-toggle="modal" data-bs-target="#addeditaddress" id="editid" data-bs-dismiss="modal"><i class="far fa-edit"></i></a>
                                    <a href="#" onClick="showLoader()" class="Delete" id="said"><i class="far fa-trash-alt"></i></a>
                                </td>
                            </tr>`;
                });
        $('#address .table3').html(addressHtml);
    }

    $(document).on('click','#editid',function(e){
        $('.error').remove();
        var addresid = $(e.target).closest('tr').data('addressid');
        // alert(addresid);
        $.ajax({
            url : "http://localhost/psd-to-html/Helperland/?controller=Customer&function=getAddress",
            type : 'POST',
            data : {userId:userid,addresid:addresid},
            success : function(result){
                var ad = JSON.parse(result);
                // console.log(ad.details.AddressLine1);
                $('#addeditaddress .modal-title').text("Edit Address");
                $('#add-edit-saddress').text("Edit");
                $('#sastreet').val(ad.details['AddressLine1']);
                $('#sahouse').val(ad.details['AddressLine2']);
                $('#sapostal').val(ad.details['PostalCode']);
                $('#sacity').val(ad.details['City']);
                $('#samobile').val(ad.details['Mobile']);
                window.addressid = addresid;
            }
        });
    });

    $('#add-new-address').click(function(){
        $('.error').remove();
        window.addressid = 0;
        defaultAddress();
    });
    function defaultAddress(){
        $('#addeditaddress .modal-title').text("Add Address");
        $('#add-edit-saddress').text("Add");
        $('#sastreet').val("");
        $('#sahouse').val("");
        $('#sapostal').val("");
        $('#sacity').val("");
        $('#samobile').val("");
    }

    $('#add-edit-saddress').click(function(){
        is_valid = true;
        $('.error').remove();
        const email = $('#semail').val();
        var addressid = 0;
        if(window.addressid != 0){
            addressid = window.addressid
        }
        feildValidation($('#sastreet').val(),'#sastreet',"Street Name");
        feildValidation($('#sahouse').val(),'#sahouse',"House Number");
        feildValidation($('#sapostal').val(),'#sapostal',"Postal Code");
        feildValidation($('#sacity').val(),'#sacity',"City");
        phoneValidation($('#samobile').val(),'#samobile');
        if(is_valid == true){
            $.ajax({
                url : "http://localhost/psd-to-html/Helperland/?controller=Customer&function=addeditAddress",
                type : 'POST',
                data : $('#add-edit-saddress-form').serialize()+"&userId="+userid+"&email="+email+"&addressid="+addressid,
                success : function(result){
                    // console.log(JSON.parse(result).address);
                    if(JSON.parse(result).address){
                        if(addressid == 0){
                            alertMsg = `<div class='alert alert-success alert-dismissible fade show mt-3' role='alert'>Address add successfully<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>`;
                        }
                        else{
                            alertMsg = `<div class='alert alert-success alert-dismissible fade show mt-3' role='alert'>Address edit successfully<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>`;
                        }
                        customerData();
                    }
                    else{
                        alertMsg = `<div class='alert alert-danger alert-dismissible fade show mt-3' role='alert'>${JSON.parse(result).errormsg}<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>`;
                    }
                    $('#address .table3').before(alertMsg);
                    setTimeout(function(){ 
                        $('.alert').fadeOut(1000) 
                    }, 5000);
                    $("#addeditaddress").modal('hide');
                    $.LoadingOverlay("hide");
                }
            });
        }
        else{
            $.LoadingOverlay("hide");
        }
    });

    // delete setting address
    $(document).on('click','#said',function(e){
        var addresid = $(e.target).closest('tr').data('addressid');
        // alert(addresid);
        $.ajax({
            url : "http://localhost/psd-to-html/Helperland/?controller=Customer&function=addressDelete",
            type : "POST",
            data : {addressId:addresid,userId:userid},
            success : function(result){
                if(JSON.parse(result).status){
                    alertMsg = `<div class='alert alert-success alert-dismissible fade show mt-3' role='alert'>${JSON.parse(result).successmsg}<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>`;
                    customerData();
                }
                else{
                    alertMsg = `<div class='alert alert-danger alert-dismissible fade show mt-3' role='alert'>${JSON.parse(result).errormsg}<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>`;
                }
                $('#address .table3').before(alertMsg);
                setTimeout(function(){ 
                    $('.alert').fadeOut(1000) 
                }, 5000);
                $.LoadingOverlay("hide");
            }
        });
    });

    // change password 
    $('#change-psw').click(function(){
        $('.error').remove();
        var oldpsw = $('#soldpsw').val();
        var newpsw = $('#snewpsw').val();
        var cpsw = $('#scpsw').val();
        if(oldpsw.length < 1){
            $('#soldpsw').after("<span class='error'>Password can't be empty</span>");
        }
        var result1 = passwordValidation('#snewpsw',newpsw);
        var result2 = passwordValidation('#scpsw',cpsw);
        if(result1 == true && result2 == true){
            passVerify('#snewpsw',newpsw,cpsw);
        }
        if(is_valid == true){
            $.ajax({
                url : "http://localhost/psd-to-html/Helperland/?controller=Customer&function=changePassword",
                type : 'POST',
                data : {userid : userid,oldpsw : oldpsw,newpsw : newpsw},
                success : function(result){
                    var status = JSON.parse(result);
                    if(!status.success.yes){
                        $('#soldpsw').after("<span class='error'>Please insert valid old password</span>");
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