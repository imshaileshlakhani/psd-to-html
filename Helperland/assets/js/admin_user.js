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
function sortTable(n) {
  var table;
  table = document.getElementById('table');
  var rows, i, x, y, count = 0;
  var switching = true;
  var direction = "asc";

  while (switching) {
    switching = false;
    rows = table.rows;

    for (i = 1; i < (rows.length - 1); i++) {
      var Switch = false;
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];

      if (direction == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          Switch = true;
          break;
        }
      }
      else if (direction == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          Switch = true;
          break;
        }
      }
    }
    if (Switch) {
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      count++;
    } else {
      if (count == 0 && direction == "asc") {
        direction = "desc";
        switching = true;
      }
    }
  }
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

  function adminData() {
    var tabName = $('#tab-name').val();
    $.ajax({
      url: "http://localhost/psd-to-html/Helperland/?controller=Admin&function=adminData",
      type: "POST",
      data: { pageName: tabName, userid: userid },
      success: function (result) {
        console.log(result);
        switch (tabName) {
          case "srequest":
            const serviceData = JSON.parse(result);
            showServices(serviceData.service);
            break;
          case "umanagement":
            console.log(result);
            break;
          default:
            console.log(result);
            showServices(serviceData.service);
        }
      }
      // complete : function(result){
      //   $.LoadingOverlay("hide");
      // }
    });
  }

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
                                <li class="dropdown-item"><a href="" data-bs-toggle="modal" data-bs-target="#EditAndReschedule" data-bs-dismiss="modal">Edit & Reschedule</a></li>
                                <li class="dropdown-item"><a href="">Refund</a></li>
                                <li class="dropdown-item"><a href="">Cancel</a></li>
                              </ul>
                          </div>
                        </td>
                      </tr>`;
    });
    $('.table1 .tbody').html(serviceHtml);
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