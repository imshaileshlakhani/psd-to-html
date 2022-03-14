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

  function adminData(limit = 2, page = 1) {
    var tabName = $('#tab-name').val();
    var onePageData = limit;
    var defaultPage = page;
    $.ajax({
      url: "http://localhost/psd-to-html/Helperland/?controller=Admin&function=adminData",
      type: "POST",
      data: { pageName: tabName, userid: userid, limit: onePageData, page: defaultPage },
      success: function (result) {
        const Data = JSON.parse(result);
        console.log(result);
        switch (tabName) {
          case "srequest":
            showServices(Data.record);
            if(Data.paginationData != 0){
              paginationHtml(Data.paginationData);
            }
            break;
          case "umanagement":
            showUserData(Data.record);
            if(Data.paginationData != 0){
              paginationHtml(Data.paginationData);
            }
            break;
          default:
            showServices(Data.record);
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

  // show service data
  function showServices(services) {
    var serviceHtml = "";
    var rating = "";
    services.forEach(function (service) {
      var address = service.AddressLine1 +","+service.PostalCode+" "+service.City;
      const obj = getTimeAndDate(service.ServiceStartDate, service.SubTotal);
      serviceHtml += `<tr class="text-center">
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
                        else {
                          serviceHtml += `<a>Completed`;
                        }
                        serviceHtml += `</a></td>
                        <td class="action">
                            <div class="dropdown">
                                <button class="dropdown-toggle" type="button" id="ActionMenu1" data-bs-toggle="dropdown" aria-expanded="false">
                                  <img src="assets/images/group-38.png">
                                </button>
                              <ul class="dropdown-menu" aria-labelledby="ActionMenu1">
                                <li class="dropdown-item"><a href="#" data-bs-toggle="modal" data-bs-target="#EditAndReschedule" data-bs-dismiss="modal">Edit & Reschedule</a></li>
                                <li class="dropdown-item"><a href="#" data-bs-toggle="modal" data-bs-target="#Refundmodal" data-bs-dismiss="modal">Refund</a></li>
                                <li class="dropdown-item"><a href="#">Cancel</a></li>
                              </ul>
                          </div>
                        </td>
                      </tr>`;
    });
    $('.table1 .tbody').html(serviceHtml);
  }

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
                      if(user.IsActive == 1){
                        userHtml += `</span></td>
                          <td><a>Active</a>`;
                      }
                      else if(user.IsActive == 0){
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
                            <li class="dropdown-item"><a href="#">Deactivate</a></li>
                          </ul>
                        </div>
                      </td>
                    </tr>`;
    });
    $('.table2 .tbody').html(userHtml);
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