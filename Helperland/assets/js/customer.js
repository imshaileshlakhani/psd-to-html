function defaultDate() {
    var date = new Date();
    day = date.getDate();
    month = date.getMonth() + 1;
    year = date.getFullYear();
    var fulldate = day + "/" + month + "/" + year;
    document.getElementById("rdate").defaultValue = year + "-" + ("0" + month).slice(-2) + "-" + ("0" + day).slice(-2);
}
$(document).ready(function () {
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
        var limit = $('#number').val();
        customerData(limit);
    });

    $(document).on('click', '#pagination', function (e) {
        var page = $(e.target).closest('div').data("page");
        var limit = $('#number').val();
        if (page != undefined) {
            customerData(limit, page);
        }
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
                switch (tabName) {
                    case "Dashboard":
                        const serviceData = JSON.parse(result);
                        showServices(serviceData.service);
                        paginationHtml(serviceData.paginationData);
                        break;
                    case "History":
                        const serviceHistory = JSON.parse(result);
                        showServiceHistory(serviceHistory.service);
                        paginationHtml(serviceHistory.paginationData);
                        break;
                    case "Favourite":
                        const favBlockSp = JSON.parse(result);
                        showFavBlockSp(favBlockSp.favSp);
                        paginationHtml(favBlockSp.paginationData);
                        break;
                    case "setting":
                        const settingAddress = JSON.parse(result);
                        showMyAddress(settingAddress.saddress);
                        // console.log(settingAddress.saddress);
                        break;
                    default:
                        showServices(serviceData.service);
                }
            }
        });
    }

    function showServices(services) {
        var serviceHtml = `<tr class="th text-center">
                                <th>Service Id <img src="assets/images/sort.png" alt=""></th>
                                <th>Service Date <img src="assets/images/sort.png" alt=""></th>
                                <th>Service Provider <img src="assets/images/sort.png" alt=""></th>
                                <th>Payment <img src="assets/images/sort.png" alt=""></th>
                                <th>Actions </th>
                            </tr>`;
        services.forEach(function (service) {
            let arr = [];
            var fullName = service.FirstName + " " + service.LastName;
            const obj = getTimeAndDate(service.ServiceStartDate, service.SubTotal);
            arr = json2array(service);
            // console.log(arr);
            serviceHtml += `<tr class="text-center table1-row" data-bs-toggle="modal" data-bs-target="#servicedetails" data-bs-dismiss="modal" data-spid="${service.ServiceRequestId}">
                <input type="hidden" value="${arr}">
                <td>${service.ServiceRequestId}</td>
                <td>
                    <span><img src="assets/images/calendar2.png" alt=""> ${obj.startdate}</span>
                    <span> &nbsp; <img src="assets/images/layer-14.png" alt=""> ${obj.starttime} - ${obj.endtime}</span>
                </td>
                <td class="avg-ratting">`;
                if (service.ServiceProviderId != null) {
                    serviceHtml += `<div class="d-flex justify-content-center">`;
                    rating = spRating(fullName,service.avgRatting.avgrating);
                    // console.log(rating);
                    serviceHtml += `${rating}</span>
                                        </div>
                                    </div>`
                }
            serviceHtml += `</td>
                <td class="payment">
                    <a>${service.TotalCost}</a>€
                </td>
                <td class="action">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#servicereschedule" class="Reschedule" data-bs-dismiss="modal" id="date-update">Reschedule</a>
                    <a href="#" class="Cancle" id="cancle-service" data-bs-toggle="modal" data-bs-target="#servicecancle" data-bs-dismiss="modal">Cancle</a>
                </td>
            </tr>`;
        });
        $('#ups .table1').html(serviceHtml);
        $('#totalrequest').text(services[0].Totalrecord);
    }

    $('.table1').on('click', function (e) {
        const service = $(e.target).closest('tr').find("input").val();
        // console.log(service.split(","));
        // alert(service);
        serviceDetailsModel(service.split(","));
    })

    function json2array(json) {
        var result = [];
        var keys = Object.keys(json);
        keys.forEach(function (key) {
            result.push(json[key]);
        });
        return result;
    }

    // service cancle model
    $(document).on('click', '#cancle-service', function (e) {
        var serviceIdforCancle = $(e.target).closest('tr').data('spid');
        var closestRow = $(e.target).closest('tr');
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
            cancleService(serviceIdforCancle, closestRow);
            serviceIdforCancle = 0;
        });
    });

    function cancleService(serviceIdforCancle, closestRow) {
        var sid = serviceIdforCancle;
        var dataRow = closestRow;
        var limit = $('#number').val();
        $.ajax({
            url: "http://localhost/psd-to-html/Helperland/?controller=Customer&function=serviceCancle",
            type: "POST",
            data: { serviceId: sid },
            success: function (result) {
                const status = JSON.parse(result);
                if (status.update == true) {
                    $("#successModal #success-msg").text('Your service request canceled successfully');
                    $('#successModal #service-id').text(`Cancelled Request Id : ${sid}`);
                    $("#successModal button").prop('onclick', null);
                    $("#successModal").modal('show');
                    // $(dataRow).closest('tr').fadeOut(1000);
                    customerData(limit);
                } else {
                    alert("Somthing went wrong");
                }
            }
        });
    }

    // service reschedule model
    $(document).on('click', '#date-update', function (e) {
        var sIdforReschedule = $(e.target).closest('tr').data('spid');
        // alert(sIdforReschedule);
        $('.update-button').click(function () {
            var rdate = $('#rdate').val();
            var rtime = $('#rtime').val();
            rescheduleService(sIdforReschedule, rdate, rtime);
            sIdforReschedule = 0;
        });
    });

    function rescheduleService(serviceIdforCancle, rdate, rtime) {
        var sid = serviceIdforCancle;
        var date = rdate;
        var time = rtime;
        var limit = $('#number').val();
        $.ajax({
            url: "http://localhost/psd-to-html/Helperland/?controller=Customer&function=serviceReschedule",
            type: "POST",
            data: { serviceId: sid, date: date, time: time },
            success: function (result) {
                const status = JSON.parse(result);
                if (status.dateUpdate == true) {
                    console.log("Service reschedule successfully");
                    $("#servicereschedule").modal('hide');
                    customerData(limit);
                } else {
                    console.log("Somthing went wrong");
                }
            }
        });
    }

    // service-details model for dashboard
    function serviceDetailsModel(service) {
        var petHtml = "";
        var extraHtml = "";
        var extras = ['Inside cabinets', 'Inside fridge', 'Inside oven', 'Laundry wash & dry', 'Interior windows'];
        var selectedExtra = service[13].split("");
        for (var i = 0; i < selectedExtra.length; i++) {
            if (i != (selectedExtra.length - 1)) {
                extraHtml += extras[selectedExtra[i] - 1] + ", ";
            }
            else {
                extraHtml += extras[selectedExtra[i] - 1] + ".";
            }
        }
        const dateTime = getTimeAndDate(service[1], service[3]);
        $('#servicedetails .model-time').text(dateTime.startdate + " " + dateTime.starttime + " - " + dateTime.endtime);
        $('#servicedetails #duration-model').text(service[3] + " Hrs");
        $('#servicedetails #sid-model').text(service[0] + ".");
        $('#servicedetails #extra-model').text(extraHtml);
        $('#servicedetails .model-price').text(service[2] + " €");
        $('#servicedetails #address-model').text(service[9] + "," + service[10]);
        $('#servicedetails #phone-model').text(service[11]);
        $('#servicedetails #email-model').text(service[12]);

        if (service[5] == "1") {
            petHtml += `<i class="fa fa-check-circle-o"></i> <span>I have pets at home</span>`;
        }
        else {
            petHtml += `<i class="fa fa-times-circle-o"></i> <span>I dont't have pets at home</span>`;
        }
        $('#servicedetails #pet-model').html(petHtml);
    }

    // service-history page
    function showServiceHistory(services) {
        var serviceHistoryHtml = `<tr class="th text-center">
                                    <th>Service Details <img src="assets/images/sort.png" alt=""></th>
                                    <th>Service Provider <img src="assets/images/sort.png" alt=""></th>
                                    <th>Payment <img src="assets/images/sort.png" alt=""></th>
                                    <th>Status <img src="assets/images/sort.png" alt=""></th>
                                    <th>Rate SP </th>
                                </tr>`;
        services.forEach(function (service) {
            var rating = "";
            var fullName = service.FirstName + " " + service.LastName;
            const obj = getTimeAndDate(service.ServiceStartDate, service.SubTotal);
            serviceHistoryHtml += `<tr class="text-center" data-name="${fullName}">
                                    <td>
                                        <span> <img src="assets/images/shape-12.png" alt=""> ${obj.startdate}</span>
                                        <span>${obj.starttime} - ${obj.endtime}</span>
                                    </td>
                                    <td>`;
            if (service.ServiceProviderId != null) {
                serviceHistoryHtml += `<div class="d-flex justify-content-center">`;
                rating = spRating(fullName,service.avgRatting.avgrating);
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
            if (service.Status == 3) {
                serviceHistoryHtml += `style="pointer-events: none;"`;
            }
            serviceHistoryHtml += `data-bs-toggle="modal" data-bs-target="#Ratesp" data-bs-dismiss="modal">Rate SP</a></td>
            </tr>`;
        });
        $('#ups .table2').html(serviceHistoryHtml);
        $('#totalrequest').text(services[0].Totalrecord);
    }

    // rating model
    $(document).on('click','#rate-model-btn',function(e){
        var rateNumber = $(e.target).closest('tr').find('span#ratting-text').text();
        var name = $(e.target).closest('tr').data('name');
        
        var ratdisplay = spRating(name,rateNumber);
        $('#rate-wraper').html(ratdisplay);
    });

    // service provider rating function
    function spRating(Name,avgrating) {
        var ratingHtml = "";
        ratingHtml += `<div class="cap d-flex align-items-center justify-content-center">
                            <img src="assets/images/cap.png" alt="">
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
            ratingHtml += ` ${"0.0"}`;
        }
        else{
            ratingHtml += ` ${parseFloat(avgrating)}`;
        }
        return ratingHtml;
    }

    // Favourite pros page
    function showFavBlockSp(servicer){
        var favspHtml = "";
        servicer.forEach(function (sp) {
            favspHtml += `<div class="fav-card py-4" data-spid="${sp.ServiceProviderId}">
                                <div class="cap d-flex align-items-center justify-content-center">
                                    <img src="assets/images/cap.png" alt="">
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
                                        favspHtml += ` ${parseFloat(sp.avgRatting.avgrating)}`;
                                    }
                                favspHtml += `</div>
                                    <div class="text-center mt-3">1 Cleanings</div>
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
        $('#ups').html(favspHtml)
        $('#totalrequest').text(servicer[0].Totalrecord)
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
        var totalPage = 0;
        var currentPage = +paginationData.page;
        var paginationHtml = `<div data-page='1'>
                                <img src='assets/images/group-363.png'>
                            </div>
                            <div data-page='${currentPage - 1}'>
                                <img src='assets/images/keyboard-right-arrow-button-copy.png'>
                            </div>`;
        totalPage = Math.ceil(totalRecord / limit);
        // console.log(limit+" "+totalRecord+" "+currentPage+" "+totalPage);
        for (var i = 1; i <= totalPage; i++) {
            if (i == currentPage) {
                paginationHtml += `<div class='active' data-page='${i}' id='page${i}'>${i}</div>`;
            }
            else {
                paginationHtml += `<div data-page='${i}' id='page${i}'>${i}</div>`;
            }
        }
        paginationHtml += `<div id='next-tab' data-page='${currentPage + 1}'>
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

    // rating to service provider
    $('#stars li').on('mouseover', function () {
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
    $('#stars li').on('click', function () {
        var onStar = parseInt($(this).data('value'), 10);
        var stars = $(this).parent().children('li.star');
        for (i = 0; i < stars.length; i++) {
            $(stars[i]).removeClass('selected');
        }
        for (i = 0; i < onStar; i++) {
            $(stars[i]).addClass('selected');
        }
        var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
    });

    // save setting details
    $('#save-sdetails').on('click',function(e){
        e.preventDefault();
        $.ajax({
          url : "http://localhost/psd-to-html/Helperland/?controller=Customer&function=editSetting",
          type : 'POST',
          data : $('#setting-details-form').serialize()+"&userId="+userid,
          success : function(result){
            // console.log(JSON.parse(result));
            $('#welcome-name').text(JSON.parse(result).save['FirstName']);
            $('#wname').text(JSON.parse(result).save['FirstName']);
          }
        });
    });

    // my-setting address tab display
    function showMyAddress(address){
        var addressHtml = `<tr class="th">
                                <th>Addresses</th>
                                <th class="text-end">Action</th>
                            </tr>`;
                address.forEach(function(ad){
                    addressHtml += `<tr data-AddressId="${ad.AddressId}" data-State="${ad.State}">
                                <td>
                                    <div><b>Address:</b> ${ad.AddressLine1}, ${ad.PostalCode} ${ad.City}</div>
                                    <div><b>Phone number:</b> ${ad.Mobile}</div>
                                </td>
                                <td class="action text-end">
                                    <a href="#" class="Edit" data-bs-toggle="modal" data-bs-target="#addeditaddress" data-bs-dismiss="modal"><i class="far fa-edit"></i></a>
                                    <a href="#" class="Delete"><i class="far fa-trash-alt"></i></a>
                                </td>
                            </tr>`;
                });
        $('#address .table3').html(addressHtml);
    }

    $('#add-edit-saddress').click(function(){
        const email = $('#semail').val();
        $.ajax({
          url : "http://localhost/psd-to-html/Helperland/?controller=Customer&function=addAddress",
          type : 'POST',
          data : $('#add-edit-saddress-form').serialize()+"&userId="+userid+"&email="+email,
          success : function(result){
            console.log(JSON.parse(result).address);
            if(JSON.parse(result).address){
                customerData();
                // alert("success");
            }
            else{
                // alert("not");
            }
          }
        });
    });

    // change password 
    $('#change-psw').click(function(){
        var oldpsw = $('#oldpsw').val();
        var newpsw = $('#newpsw').val();
        var cpsw = $('#cpsw').val();
        if(newpsw == cpsw){
            $.ajax({
                url : "http://localhost/psd-to-html/Helperland/?controller=Customer&function=changePassword",
                type : 'POST',
                data : {userid : userid,oldpsw : oldpsw,newpsw : newpsw},
                success : function(result){
                  console.log(JSON.parse(result).success);
                }
            });
        }
        else{
            alert("new password and confirm password must be same");
        }
        
    });
});