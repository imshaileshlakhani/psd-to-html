var dropdown = document.getElementsByClassName("dropdown-btn");
var i;

for (i = 0; i < dropdown.length; i++) {
  dropdown[i].addEventListener("click", function () {
    this.childNodes[1].classList.toggle("active");
    var dropdownContent = this.nextElementSibling;
    if (dropdownContent.style.display === "block") {
      dropdownContent.style.display = "none";
    } else {
      dropdownContent.style.display = "block";
    }
  });
}
function showLoader(){
  $.LoadingOverlay("show",{
    background  : "rgba(0, 0, 0, 0.7)"
  });
}
$(document).ready(function () {
  var is_valid = true;
  const userid = $('#userdata').val();
  adminData();

  $('#srequest').click(function () {
    adminData();
  });
  $('#umanagement').click(function () {
    adminData();
  });

  $('#number').change(function () {
    showLoader();
    var limit = $('#number').val();
    adminData(limit);
  });

  $(document).on('click', '#pagination', function (e) {
    showLoader();
    var page = $(e.target).closest('div').data("page");
    // console.log(page);
    var limit = $('#number').val();
    if (page != undefined) {
      adminData(limit, page);
    }
    $.LoadingOverlay("hide");
  });

  $('#service-search').click(function(){
    showLoader();
    var limit = $('#number').val();
    adminData(limit, page = 1)
  });

  function adminData(limit = 2, page = 1) {
    var tabName = $('#tab-name').val();
    var customer = $('#customer').val();
    var servicer = $('#servicer').val();
    var user = $('#suname').val();
    var sid = $('#sid').val();
    var postal = $('#spostal').val();
    var status = $('#status').val();
    var email = $('#semail').val();
    var utype = $('#sutype').val();
    var mobile = $('#usmobile').val();
    var fdate = $('#sfdate').val();
    var tdate = $('#stdate').val();
    // console.log(fdate);
    $.ajax({
      url: "http://localhost/psd-to-html/Helperland/?controller=Admin&function=adminData",
      type: "POST",
      data: { pageName: tabName, userid: userid, limit: limit, page: page, customer: customer, servicer: servicer, sid: sid, postal: postal, status: status, email: email, utype: utype, mobile: mobile, user: user, fdate: fdate, tdate: tdate},
      success: function (result) {
        const Data = JSON.parse(result);
        // console.log(result);
        switch (tabName) {
          case "srequest":
            showServices(Data.record);
            showCustomer(Data.customer);
            showServicer(Data.servicer);
            if(Data.paginationData != 0){
              $('#totalrequest').text(Data.paginationData.Totalrecord);
              paginationHtml(Data.paginationData);
            }
            break;
          case "umanagement":
            showUserData(Data.record);
            showUser(Data.user);
            if(Data.paginationData != 0){
              $('#totalrequest').text(Data.paginationData.Totalrecord);
              paginationHtml(Data.paginationData);
            }
            break;
          default:
            showServices(Data.record);
            showCustomer(Data.customer);
            showServicer(Data.servicer);
            if(Data.paginationData != 0){
              $('#totalrequest').text(Data.paginationData.Totalrecord);
              paginationHtml(Data.paginationData);
            }
        }
      },
      complete : function(result){
        $.LoadingOverlay("hide");
        if(page >= 5){
          $('#page5').text(page);
          $('#page5').addClass('active');
          $('#page5').data('page',page);
        }
      }
    });
  }

  // show type of username in search dropdown
  function showCustomer(customers){
    var custhtml = `<option selected value="0">Select Customer</option>`;
    customers.forEach(function (customer) {
      custhtml += `<option value="${customer.UserId}">${customer.FullName}</option>`;
    });
    $('#customer').html(custhtml);
  }
  function showServicer(servicers){
    var sphtml = `<option selected value="0">Select Service Provider</option>`;
    servicers.forEach(function (servicer) {
      sphtml += `<option value="${servicer.UserId}">${servicer.FullName}</option>`;
    });
    $('#servicer').html(sphtml);
  }
  function showUser(users){
    var userhtml = `<option selected value="0">Select User Name</option>`;
    users.forEach(function (user) {
      userhtml += `<option value="${user.UserId}">${user.FullName}</option>`;
    });
    $('#suname').html(userhtml);
  }

  // show service data
  function showServices(services) {
    var serviceHtml = "";
    var rating = "";
    services.forEach(function (service) {
      var address = service.AddressLine1 +","+service.PostalCode+" "+service.City;
      const obj = getTimeAndDate(service.ServiceStartDate, service.ServiceHours);
      serviceHtml += `<tr class="text-center" data-serviceid="${service.ServiceRequestId}" data-payment="${service.TotalCost}" data-refund="${service.RefundedAmount}">
                        <td>
                            <div>${service.ServiceRequestId}</div>
                        </td>
                        <td>
                            <span><img src="assets/images/calendar2.png"> ${obj.startdate}</span>
                            <span> &nbsp; <img src="assets/images/layer-14.png"> ${obj.starttime} - ${obj.endtime}
                            </span>
                        </td>
                        <td>
                            <span>${service.CFullName}</span>
                            <span> <img src="assets/images/layer-15.png"> ${address}</span>
                        </td>
                        <td>`;
                        if (service.ServiceProviderId != null) {
                          serviceHtml += `<div class="d-flex justify-content-center">`;
                            rating = spRating(service.SpFullName,service.avgRatting.avgrating,service.UserProfilePicture);
                            // console.log(rating);
                            serviceHtml += `${rating}</span>
                                                </div>
                                            </div>`
                        }
                        serviceHtml += `</td>
                        <td class="payment">
                            <a>${service.TotalCost}</a>€
                        </td>
                        <td>`;
                        if (service.Status == 0) {
                          serviceHtml += `<a class="New">New`;
                        }else if(service.Status == 1 || service.Status == 2){
                          serviceHtml += `<a class="Pending">Pending`;
                        }
                        else if(service.Status == 3){
                          serviceHtml += `<a class="Cancelled">Cancelled`;
                        }
                        else if(service.Status == 4){
                          serviceHtml += `<a>Completed`;
                        }
                        else if(service.Status == 5){
                          serviceHtml += `<a class="Refunded">Refunded`;
                        }
                        serviceHtml += `</a></td>
                        <td class="action">
                            <div class="dropdown">
                                <button class="dropdown-toggle" type="button" id="ActionMenu1" data-bs-toggle="dropdown" aria-expanded="false">
                                  <img src="assets/images/group-38.png">
                                </button>
                              <ul class="dropdown-menu" aria-labelledby="ActionMenu1">`;
                              if (service.Status == 0 || service.Status == 1 || service.Status == 2 || service.Status == 3) {
                                serviceHtml += `<li class="dropdown-item"><a href="#" data-bs-toggle="modal" data-bs-target="#EditAndReschedule" data-bs-dismiss="modal" id="edit-reschedule">Edit & Reschedule</a></li>`;
                              }
                              if (service.Status == 3 || service.Status == 4 || service.Status == 5) {
                                serviceHtml += `<li class="dropdown-item"><a href="#" data-bs-toggle="modal" data-bs-target="#Refundmodal" data-bs-dismiss="modal" id="refund-btn">Refund</a></li>`;
                              }
                              if (service.Status == 0 || service.Status == 1 || service.Status == 2) {
                                serviceHtml += `<li class="dropdown-item"><a href="#" id="cancleByAdmin">Cancel</a></li>`;
                              }
                              serviceHtml += `</ul>
                          </div>
                        </td>
                      </tr>`;
    });
    $('.table1 .tbody').html(serviceHtml);
  }

  // reschedule service by admin
  $(document).on('click','#edit-reschedule',function(){
    var serviceId = $(this).closest('tr').data('serviceid');
    $('#admin-edit-btn').data('serviceid',serviceId);
    $('.error').remove();
  });
  $('#admin-edit-btn').click(function(){
    showLoader();
    is_valid = true;
    $('.error').remove();
    var limit = $('#number').val();
    var serviceId = $(this).data('serviceid');
    var date = $('#admin-edit-date').val();
    var time = $('#admin-edit-time').val();
    var street = $('#admin-edit-Street').val();
    var house = $('#admin-edit-House').val();
    var postal = $('#admin-edit-Postal').val();
    var city = $('#admin-edit-City').val();
    var comment = $('#admin-edit-coment').val();
    // console.log(serviceId+" "+date+" "+time);
    feildValidation('#admin-edit-Street',street,'Street Name');
    feildValidation('#admin-edit-House',house,'House Name');
    feildValidation('#admin-edit-Postal',postal,'Postal Name');
    feildValidation('#admin-edit-City',city,'City Name');
    if(is_valid == true){
      $.ajax({
        url : "http://localhost/psd-to-html/Helperland/?controller=Admin&function=serviceReschedule",
        type : "POST",
        data : {serviceId: serviceId, date: date, time: time, street: street, house: house, postal: postal, city: city, comment: comment},
        success : function(result){
          const data = JSON.parse(result);
          var alertMsg="";
          if (data.dateUpdate[0] == true) {
            $("#EditAndReschedule").modal('hide');
            $("#successModal #success-msg").text('Service has been Reschedule successfully');
            $('#successModal #service-id').text(`Reschedule Service Id : ${serviceId}`);
            $("#successModal button").prop('onclick', null);
            $("#successModal").modal('show');
          } else {
            alertMsg = `<div class='alert alert-danger alert-dismissible fade show mt-3' role='alert'>${data.error}<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>`;
            $('#r-msg').html(alertMsg);
          }
        },
        complete : function(result){
          $.LoadingOverlay("hide");
          adminData(limit);
          $('.error').remove();
        }
      });
    }
    else{
      $.LoadingOverlay("hide");
    }
  });

  // refund service by admin
  $(document).on('click','#refund-btn',function(){
    var serviceId = $(this).closest('tr').data('serviceid');
    window.payment = +$(this).closest('tr').data('payment');
    window.refund = +$(this).closest('tr').data('refund');
    $('#refund').data('serviceid',serviceId);
    $('#paidAmount').text(window.payment+"€");
    $('#refundedAmount').text(refund+"€");
    $('#balanceAmount').text((window.payment-refund).toFixed(2)+"€");
    $('.error').remove();
    $('#rpayment').val("");
    $('#calculate').val("");
  });
  $('#rpayment').keyup(function(){
    var action = $('#r-action').val();
    var refund = +$('#rpayment').val();
    var refundAmount = refund;
    if(action == 1){
      refundAmount = (refund * window.payment)/100;
    }
    $('#calculate').val(refundAmount);
  });
  $('#r-action').change(function(){
    var action = $('#r-action').val();
    var refund = +$('#rpayment').val();
    var refundAmount = refund;
    if(action == 1){
      refundAmount = (refund * window.payment)/100;
    }
    $('#calculate').val(refundAmount);
  });
  $(document).on('click','#refund',function(){
    showLoader();
    is_valid = true;
    $('.error').remove();
    var limit = $('#number').val();
    var serviceId = $(this).data('serviceid');
    var msg = $('#refund-msg').val();
    var payment = +$('#calculate').val() + window.refund;
    if(payment > window.payment || +$('#calculate').val() == 0){
      $('#calculate').after(`<span class='error'>Cann't refund more then paid or 0</span>`);
      is_valid = false;
    }
    feildValidation('#r-error',$('#rpayment').val(),"refund amount");
    // alert(serviceId+" "+payment);
    if(is_valid == true){
      $.ajax({
        url : "http://localhost/psd-to-html/Helperland/?controller=Admin&function=refund",
        type : "POST",
        data : {serviceId: serviceId, payment: payment, msg: msg},
        success : function(result){
          const data = JSON.parse(result);
          if(data.status){
            $("#Refundmodal").modal('hide');
            $("#successModal #success-msg").text('Refund has been completed successfully');
            $('#successModal #service-id').text(`Refunded Service Id : ${serviceId}`);
            $("#successModal button").prop('onclick', null);
            $("#successModal").modal('show');
          }
          else{
            alert("somthing went wrong");
          }
        },
        complete : function(result){
          $.LoadingOverlay("hide");
          $('#rpayment').val("");
          $('.error').remove();
          adminData(limit);
        }
      });
    }
    else{
      $.LoadingOverlay("hide");
    }
  });

  // cancle service by admin
  $(document).on('click','#cancleByAdmin',function(){
    showLoader();
    var limit = $('#number').val();
    var serviceId = $(this).closest('tr').data('serviceid');
    // alert(serviceId);
    $.ajax({
      url : "http://localhost/psd-to-html/Helperland/?controller=Admin&function=cancleService",
      type : "POST",
      data : {serviceId: serviceId},
      success : function(result){
        const data = JSON.parse(result);
        if(data.status){
          $("#successModal #success-msg").text('Service request has been Cancelled successfully');
          $('#successModal #service-id').text(`Cancelled Service Id : ${serviceId}`);
          $("#successModal button").prop('onclick', null);
          $("#successModal").modal('show');
          adminData(limit);
        }
        else{
          alert("somthing went wrong");
        }
      },
      complete : function(result){
        $.LoadingOverlay("hide");
      }
    });
  });

  // show user data
  function showUserData(users) {
    var userHtml = "";
    users.forEach(function (user) {
      const obj = getTimeAndDate(user.CreatedDate, 1.0);
      userHtml += `<tr class="text-center">
                      <td><span>${user.FullName}</span></td>
                      <td><span>`;
                      if(user.UserTypeId == 1){
                        userHtml += `Customer`;
                      }
                      else if(user.UserTypeId == 2){
                        userHtml += `Servicer`;
                      }
                      else if(user.UserTypeId == 3){
                        userHtml += `Admin`;
                      }
                      userHtml += `</span></td>
                      <td><span><img src="assets/images/calendar2.png" alt=""> ${obj.startdate}</span></td>
                      <td><span>${user.Mobile}</span></td>
                      <td><span>`;
                      if(user.PostalCode != null){
                        userHtml += `${user.PostalCode}`;
                      }
                      if(user.IsApproved == 1){
                        userHtml += `</span></td>
                          <td><a>Active</a>`;
                      }
                      else if(user.IsApproved == 0){
                        userHtml += `</span></td>
                        <td><a class="Inactive">InActive</a>`;
                      }
                      userHtml += `</td>
                      <td class="action">
                        <div class="dropdown">
                          <button class="dropdown-toggle" type="button" id="ActionMenu" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="assets/images/group-38.png" alt="">
                          </button>
                          <ul class="dropdown-menu" aria-labelledby="ActionMenu">
                            <li class="dropdown-item">`;
                            if(user.IsApproved == 1){
                              userHtml += `<a href="#" data-userid="${user.UserId}" data-approved="${user.IsApproved}" class="Is-Approved">Deactivate</a>`;
                            }
                            else if(user.IsApproved == 0){
                              userHtml += `<a href="#" data-userid="${user.UserId}" data-approved="${user.IsApproved}" class="Is-Approved">Activate</a>`;
                            }
                            userHtml += `</li>
                          </ul>
                        </div>
                      </td>
                    </tr>`;
    });
    $('.table2 .tbody').html(userHtml);
  }

  $(document).on('click','.Is-Approved',function(){
    showLoader();
    var IsApproved = $(this).data('approved');
    var userid = $(this).data('userid');
    // console.log(IsApproved+" "+userid);
    $.ajax({
      url : "http://localhost/psd-to-html/Helperland/?controller=Admin&function=userApproved",
      type : "POST",
      data : {IsApproved: IsApproved, userid: userid},
      success : function(result){
        const data = JSON.parse(result);
        if(data.status){
          var limit = $('#number').val();
          adminData(limit);
        }
      },
      complete : function(result){
        $.LoadingOverlay("hide");
      }
    });
  });

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
    var paginationHtml = `<div id='prev' data-page='${prev}'>
                              <img src="assets/images/polygon-1-copy-5.png" alt="">
                        </div>`;
    for (var i = 1; i <= totalPage; i++) {
      if(i <= 5){
        if (i == currentPage) {
          paginationHtml += `<div class='active' data-page='${i}' id='page${i}'>${i}</div>`;
        }
        else {
          paginationHtml += `<div data-page='${i}' id='page${i}'>${i}</div>`;
        }
      } 
    }
    paginationHtml += `<div id='next-tab' data-page='${next}'>
                            <img src="assets/images/polygon-1-copy-5.png" alt="">
                      </div>`;
    $('.table-footer #pagination').html(paginationHtml);
  }

  function feildValidation(id,value,feildname){
    if(value.length < 1){
        $(id).after(`<span class='error'>Enter ${feildname}</span>`);
        is_valid = false;
        return;
    }
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
});