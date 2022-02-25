function defaultDate() {
    var date = new Date();
    day = date.getDate();
    month = date.getMonth() + 1;
    year = date.getFullYear();
    var fulldate = day+"/"+month+"/"+year;
    document.getElementById("rdate").defaultValue = year +"-"+("0"+ month).slice(-2) +"-"+("0" + day).slice(-2); 
  }
$(document).ready(function () {
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

    $('#number').change(function(){
        var limit = $('#number').val();
        customerData(limit);
    });

    $(document).on('click','#pagination',function(e){
        var page = $(e.target).closest('div').data("page");
        var limit = $('#number').val();
        if(page != undefined){
            customerData(limit,page);
        }
    });

    function customerData(limit = 2,page = 1) {
        var onePageData = limit;
        var defaultPage = page; 
        // console.log(defaultPage);
        var tabName = $('#tab-name').val();
        var userId = $('#userdata').val();
        $.ajax({
            url: "http://localhost/psd-to-html/Helperland/?controller=Customer&function=customerData",
            type: "POST",
            data: { pageName: tabName, userid: userId,limit:onePageData, page:defaultPage},
            success: function (result) {
                // console.log(result);
                switch(tabName) {
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
                        console.log(result);
                        break;
                    case "setting":
                        console.log(result);
                        break;
                    default:
                        showServices(serviceData.service);
                        $.LoadingOverlay("hide");
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
            const obj = getTimeAndDate(service.ServiceStartDate,service.SubTotal);
            arr = json2array(service);
            // console.log(arr);
            serviceHtml += `<tr class="text-center table1-row" data-bs-toggle="modal" data-bs-target="#servicedetails" data-bs-dismiss="modal" data-spid="${service.ServiceRequestId}">
                <input type="hidden" value="${arr}">
                <td>${service.ServiceRequestId}</td>
                <td>
                    <span><img src="assets/images/calendar2.png" alt=""> ${obj.startdate}</span>
                    <span> &nbsp;&nbsp; <img src="assets/images/layer-14.png" alt=""> ${obj.starttime} - ${obj.endtime}</span>
                </td>
                <td class="avg-ratting">`;
                    if(service.ServiceProviderId != null){  
                        serviceHtml += `<div class="d-flex justify-content-center">
                                            <div class="cap d-flex align-items-center justify-content-center">
                                                <img src="assets/images/cap.png" alt="">
                                            </div>
                                            <div>
                                                <span class="text-start">${service.FirstName+" "+service.LastName}</span>
                                                <span>`;
                                                var i = 0;
                                                for(var i=0; i<Math.floor(service.avgRatting); i++){
                                                    serviceHtml += `<img class="" src="assets/images/star-filled.png" alt="">`;
                                                }
                                                if((service.avgRatting-Math.floor(service.avgRatting)) > 0){
                                                    serviceHtml += `<img class="" src="assets/images/star-half-empty.png" alt="">`;
                                                    i++;
                                                }
                                                for(var j=0; j<5-i; j++){
                                                    serviceHtml += `<img class="" src="assets/images/star-empty.png" alt="">`;
                                                }
                                                if(service.avgRatting == 0){
                                                    serviceHtml += ` ${"0."+service.avgRatting}`;
                                                }
                                                else{
                                                    serviceHtml += ` ${service.avgRatting}`;
                                                }
                                                serviceHtml += `</span>
                                            </div>
                                        </div>`;
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

    $('.table1').on('click', function(e){
        const service = $(e.target).closest('tr').find("input").val();
        // console.log(service.split(","));
        serviceDetailsModel(service.split(","));
    })

    function json2array(json){
        var result = [];
        var keys = Object.keys(json);
        keys.forEach(function(key){
            result.push(json[key]);
        });
        return result;
    }

    // service cancle model
    $(document).on('click','#cancle-service',function(e){
        var serviceIdforCancle = $(e.target).closest('tr').data('spid');
        var closestRow = $(e.target).closest('tr');
        // alert(serviceIdforCancle);
        $('#service-msg').on('keyup',function(){
            var msg = $('#service-msg').val();
            if(msg.length < 1){
                $('.complete-button').attr('disabled',true);
            }else{
                $('.complete-button').attr('disabled',false);
            }
        });
        $('.complete-button').click(function(){
            cancleService(serviceIdforCancle,closestRow);
            serviceIdforCancle = 0;
        });
    });

    function cancleService(serviceIdforCancle,closestRow){
        var sid = serviceIdforCancle;
        var dataRow = closestRow;
        $.ajax({
            url : "http://localhost/psd-to-html/Helperland/?controller=Customer&function=serviceCancle",
            type : "POST",
            data : {serviceId : sid},
            success : function(result){
                const status = JSON.parse(result);
                if(status.update == true){
                    $("#successModal #success-msg").text('Your service request canceled successfully');
                    $('#successModal #service-id').text(`Cancelled Request Id : ${sid}`);
                    $("#successModal button").prop('onclick', null);
                    $("#successModal").modal('show');
                    $(dataRow).closest('tr').fadeOut(1000);
                }else{
                    alert("Somthing went wrong");
                }
            }
        });
    }

    // service reschedule model
    $(document).on('click','#date-update',function(e){
        var sIdforReschedule = $(e.target).closest('tr').data('spid');
        // alert(sIdforReschedule);
        $('.update-button').click(function(){
            var rdate = $('#rdate').val();
            var rtime = $('#rtime').val();
            rescheduleService(sIdforReschedule,rdate,rtime);
            sIdforReschedule = 0;
        });
    });

    function rescheduleService(serviceIdforCancle,rdate,rtime){
        var sid = serviceIdforCancle;
        var date = rdate;
        var time = rtime;
        $.ajax({
            url : "http://localhost/psd-to-html/Helperland/?controller=Customer&function=serviceReschedule",
            type : "POST",
            data : {serviceId : sid,date : date,time : time},
            success : function(result){
                const status = JSON.parse(result);
                if(status.dateUpdate == true){
                    console.log("Service reschedule successfully");
                    $("#servicereschedule").modal('hide');
                    customerData();
                }else{
                    console.log("Somthing went wrong");
                }
            }
        });
    }

    // service-details model for dashboard
    function serviceDetailsModel(service){
        var petHtml = "";
        var extraHtml = "";
        var extras = ['Inside cabinets','Inside fridge','Inside oven','Laundry wash & dry','Interior windows'];
        var selectedExtra = service[13].split("");
        for(var i=0; i<selectedExtra.length; i++){
            if(i != (selectedExtra.length-1)){
                extraHtml += extras[selectedExtra[i]-1]+", ";
            }
            else{
                extraHtml += extras[selectedExtra[i]-1]+".";
            }
        }
        const dateTime = getTimeAndDate(service[1],service[3]);
        $('#servicedetails .model-time').text(dateTime.startdate+" "+dateTime.starttime+" - "+dateTime.endtime);
        $('#servicedetails #duration-model').text(service[3]+" Hrs");
        $('#servicedetails #sid-model').text(service[0]+".");
        $('#servicedetails #extra-model').text(extraHtml);
        $('#servicedetails .model-price').text(service[2]+" €");
        $('#servicedetails #address-model').text(service[9]+","+service[10]);
        $('#servicedetails #phone-model').text(service[11]);
        $('#servicedetails #email-model').text(service[12]);
        
        if(service[5] == "1"){
            petHtml += `<i class="fa-light fa-circle-check"></i> <span>I have pets at home</span>`;
        }
        else{
            petHtml += `<i class="fa fa-times-circle-o"></i> <span>I dont't have pets at home</span>`;
        }
        $('#servicedetails #pet-model').html(petHtml);
    }

    // service-history page
    function showServiceHistory(services){
        var serviceHistoryHtml = `<tr class="th text-center">
                                    <th>Service Details <img src="assets/images/sort.png" alt=""></th>
                                    <th>Service Provider <img src="assets/images/sort.png" alt=""></th>
                                    <th>Payment <img src="assets/images/sort.png" alt=""></th>
                                    <th>Status <img src="assets/images/sort.png" alt=""></th>
                                    <th>Rate SP </th>
                                </tr>`;
        services.forEach(function (service) { 
            const obj = getTimeAndDate(service.ServiceStartDate,service.SubTotal);
            serviceHistoryHtml += `<tr class="text-center">
                                    <td>
                                        <span> <img src="assets/images/shape-12.png" alt=""> ${obj.startdate}</span>
                                        <span>${obj.starttime} - ${obj.endtime}</span>
                                    </td>
                                    <td>`;
                                    if(service.ServiceProviderId != null){ 
                                        serviceHistoryHtml += `<div class="d-flex justify-content-center">
                                            <div class="cap d-flex align-items-center justify-content-center">
                                                <img src="assets/images/cap.png" alt="">
                                            </div>
                                            <div>
                                                <span class="text-start">${service.FirstName+" "+service.LastName}</span>
                                                <span>`;
                                                var i = 0;
                                                for(var i=0; i<Math.floor(service.avgRatting); i++){
                                                    serviceHistoryHtml += `<img class="" src="assets/images/star-filled.png" alt="">`;
                                                }
                                                if((service.avgRatting-Math.floor(service.avgRatting)) > 0){
                                                    serviceHistoryHtml += `<img class="" src="assets/images/star-half-empty.png" alt="">`;
                                                    i++;
                                                }
                                                for(var j=0; j<5-i; j++){
                                                    serviceHistoryHtml += `<img class="" src="assets/images/star-empty.png" alt="">`;
                                                }
                                                if(service.avgRatting == 0){
                                                    serviceHistoryHtml += ` ${"0."+service.avgRatting}`;
                                                }
                                                else{
                                                    serviceHistoryHtml += ` ${service.avgRatting}`;
                                                }
                                                serviceHistoryHtml += `</span>
                                            </div>
                                        </div>`;
                                            }
                                            serviceHistoryHtml += `</td>
                                    <td class="payment">
                                        <a>${service.TotalCost} €</a>
                                    </td>
                                    <td>`;
                                    if(service.Status == 3){
                                        serviceHistoryHtml += `<a class="Cancelled">Cancelled`;
                                    }
                                    else{
                                        serviceHistoryHtml += `<a>Completed`;
                                    }
                                    serviceHistoryHtml += `</a></td>
                                    <td class="ratesp"><a href="#" data-bs-toggle="modal" data-bs-target="#Ratesp" data-bs-dismiss="modal">Rate SP</a></td>
                                </tr>`
        });
        $('#ups .table2').html(serviceHistoryHtml);
        $('#totalrequest').text(services[0].Totalrecord);
    }

    // pagination for dashboard and service-history pages
    function paginationHtml(paginationData){
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
                                totalPage = Math.ceil(totalRecord/limit);
                                // console.log(limit+" "+totalRecord+" "+currentPage+" "+totalPage);
                                for(var i = 1; i <= totalPage; i++){
                                    if(i == currentPage){
                                        paginationHtml += `<div class='active' data-page='${i}' id='page${i}'>${i}</div>`;
                                    }
                                    else{
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
        var startdate = dateobj.toLocaleDateString("en-IN");
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

});