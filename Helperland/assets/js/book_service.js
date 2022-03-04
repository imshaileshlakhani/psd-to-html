function defaultDate() {
  var date = new Date();
  day = date.getDate();
  month = date.getMonth() + 1;
  year = date.getFullYear();
  var fulldate = day + "/" + month + "/" + year;
  document.getElementById("date").defaultValue = year + "-" + ("0" + month).slice(-2) + "-" + ("0" + day).slice(-2);
  $('.book-time .date').html(fulldate);
}
$(document).ready(function () {
  var is_valid = true;
  $('#successModal').modal({
    backdrop: 'static',
    keyboard: false
  });

  // nav-link image change
  changeNavtabImg();
  $('.nav-item').click(function () {
    changeNavtabImg();
  });

  // when click on nav-tabs
  $("._navlink").on("click", function () {
    var navtabs = ["service-setup-tab", "schedule-tab", "details-tab", "payment-tab"];
    for (var i = 0; i < navtabs.length; i++) {
      if ($(this).is($("#" + navtabs[i]))) {
        for (i = i + 1; i < navtabs.length; i++) {
          $("#" + navtabs[i]).removeClass("fill");
          activateNavtabs();
        }
        return;
      }
    }
  });

  // postal code tab
  $('.postal-check').click(function () {
    var zipcode = $('#postal').val();
    if (isPostalValid(zipcode)) {
      var action = $('#setup-service-form').attr('action');
      $.ajax({
        url: action,
        type: "POST",
        data: { postal: zipcode },
        success: function (result) {
          if (result) {
            changeNavtab('service-setup-tab', 'schedule-tab', 'service-setup', 'schedule');
            activateNavtabs();
            changeNavtabImg();
            changeValue();
            const postaldata = JSON.parse(result);
            $('#na-postal').val(postaldata['PostalCode']);
            $('#na-statename').val(postaldata['State']);
            $('#na-city option').text(postaldata['City']).val(postaldata['City']);
            $.LoadingOverlay("hide");
          } else {
            var alertMsg = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Sorry we are not providing service in your area<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>"
            $('.service-setup-content').after(alertMsg);
            setTimeout(function () {
              $('.alert').fadeOut(1000)
            }, 2000);
            setTimeout(function () {
              $.LoadingOverlay("hide");
            }, 1000);
          }
        }
      });
    }
  });
  // postal-code validation
  function isPostalValid(postal) {
    $.LoadingOverlay("hide");
    $('.error').remove();
    if (postal.length < 1) {
      $('#postal').after("<span class='error'>Please enter postal code</span>");
      setTimeout(function () { $('.error').fadeOut(1000) }, 2000);
      return false;
    }
    return true;
  }

  // --------------------------Schedule & Plan tab------------------------

  $('.Schedule-btn').click(function () {
    const postal = $('#na-postal').val();
    const userId = $('#userdata').val();
    var pet = $('#pet-check:checked').val();
    if (pet == undefined) {
      pet = 0;
    }
    $.ajax({
      url: "http://localhost/psd-to-html/Helperland/?controller=Service&function=get_Address_Favsp",
      type: 'POST',
      data: { zipcode: postal, userdata: userId, WorkWithPet: pet },
      success: function (result) {
        $.LoadingOverlay("hide");
        changeNavtab('schedule-tab', 'details-tab', 'schedule', 'details');
        activateNavtabs();
        changeNavtabImg();
        const addressData = JSON.parse(result);
        showAddress(addressData.address);
        showFavSp(addressData.fav);
      }
    });
  });

  // date, time and hr
  $('#date').change(function () {
    var date = new Date($('#date').val());
    var fulldate = date.getDate() + "/" + (date.getMonth() + 1) + "/" + date.getFullYear();
    $('.book-time .date').html(fulldate);
  });
  $('#time').change(function () {
    changeValue();
  });
  $('#hr').change(function () {
    if ($(".extra-service label input[type=checkbox]").is(':checked')) {
      if (parseFloat($('#hr').val()) < parseFloat($(".total-time .total-hr").text().split(" ")[0])) {
        alert("Booking time is less than recommended, we may not be able to finish the job. Please confirm if you wish to proceed with your booking?");
        defaultExtra();
      }
    }
    changeValue();
  });

  // extra-service from book now page
  var index = [];
  var counter = 0;
  var extras = ['Inside cabinets', 'Inside fridge', 'Inside oven', 'Laundry wash & dry', 'Interior windows'];
  $(".extra-service label").change(function () {
    var selectHour = +$('#hr').val();
    $imgVal = $(this).find('input[type=checkbox]').val();
    if ($(this).find('input[type=checkbox]').is(':checked')) {
      $(this).find('div').addClass('active');
      $(this).find('div img').attr("src", "assets/images/" + $imgVal + "-green.png");
      index[$imgVal - 1] = [extras[$imgVal - 1]];
      selectHour += 0.5;
      counter = 0.5;
    }
    else {
      delete index[$imgVal - 1];
      $(this).find('div').removeClass('active');
      $(this).find('div img').attr("src", "assets/images/" + $imgVal + ".png");
      selectHour -= 0.5;
      counter = -0.5;
    }

    var txt = "<div class='extra-service-time d-flex flex-column'><div><b>Extras</b></div>";
    for (var i = 0; i < index.length; i++) {
      if (index[i] != undefined) {
        txt += "<div><div>" + index[i] + "</div><div class='d-flex'><div class='min'>30</div>&nbsp;<div>Min.</div></div></div>";
      }
    }
    txt += "</div>";
    $('.extra-service-time').html(txt);

    totalHours(counter);
  });

  function defaultExtra() {
    var txt = "";
    $('.extra-service-time').html(txt);
    var service = $('.extra-service .service');
    for (var i = 0; i < 5; i++) {
      if (service[i].classList.contains('active')) {
        service[i].parentNode.querySelector('input').checked = false;
        $(service[i]).removeClass('active');
        $(service[i]).find('img').attr("src", "assets/images/" + (i + 1) + ".png");
      }
    }
    index = [];
  }
  // total bill
  function totalBill(totalhr) {
    var payment = totalhr * 18;
    $('.per-service').text(payment);
    $('.total-bill').text(payment);
  }
  // change in time and hr
  function changeValue() {
    var timeval = $('#time').val();
    var time = $('#time option[value="' + timeval + '"]').text();
    $('.book-time .time').text(time);

    // totalHourValidation(hrval);
    totalHours();
  }
  // total hour of work
  function totalHours(counter = 0) {
    var service = $('.extra-service .service');
    var cnt = 0;
    for (var i = 0; i < 5; i++) {
      if (service[i].parentNode.querySelector('input').checked) {
        cnt++;
      }
    }

    var hrval = $('#hr').val();
    var th = counter + +hrval;
    $(".total-time .total-hr").text(th + " Hrs");
    $('#hr').val(th);
    // alert(th+" "+(cnt*0.5));
    var hr = $('#hr option[value="' + (th - (cnt * 0.5)) + '"]').text();
    $('#basic .hr').text(hr);
    totalBill(th);
    totalHourValidation(th);
  }
  // total hour validation
  function totalHourValidation(hrval) {
    var timeval = $('#time').val();
    var totaltime = parseFloat(timeval) + parseFloat(hrval);
    $('.error').remove();
    if (totaltime > 21) {
      $('.service-time').append("<span class='error'>Could not completed the service request, because service booking request is must be completed within 21:00 time</span>");
      $('#Schedule-btn').attr('disabled', true);
    }
    else {
      $('#Schedule-btn').attr('disabled', false);
    }
  }

  // -----------------your-details tab-------------------------
  $('.details-btn').click(function () {
    if (isCheckAddress()) {
      changeNavtab('details-tab', 'payment-tab', 'details', 'payment');
      activateNavtabs();
      changeNavtabImg();
    }
    else {
      var alertMsg = `
          <div class='alert alert-danger alert-dismissible fade show' role='alert'>Please select service address 
          <button type='button' class='btn-close alert-close' aria-label='Close'></button></div>`
      $('.details').before(alertMsg);
      setTimeout(function () { $('.alert').fadeOut(1000) }, 2000);
    }
  });
  function isCheckAddress() {
    var selectAd = $('.details .address ul input[name=address]');
    for (var i = 0; i < selectAd.length; i++) {
      if ($('#address' + i).is(':checked')) {
        return true;
      }
    }
  }

  $('#na-save').click(function () {
    is_valid = true;
    $('.error').remove();
    var Streetname = $('#na-Streetname').val();
    var Housenumber = $('#na-Housenumber').val();
    var postal = $('#na-postal').val();
    var city = $('#na-city').val();
    var Phonenumber = $('#na-Phonenumber').val();
    const userId = $('#userdata').val();
    var state = $('#na-statename').val();
    var email = $('#uemail').val();
    feildValidation(Streetname, '#na-Streetname', "Street Name");
    feildValidation(Housenumber, '#na-Housenumber', "House Number");
    phoneValidation(Phonenumber, '#na-Phonenumber');
    if (is_valid == true) {
      $.ajax({
        url: "http://localhost/psd-to-html/Helperland/?controller=Service&function=addAddress",
        type: 'POST',
        data: { zipcode: postal, userdata: userId, sname: Streetname, statename: state, hnumber: Housenumber, cname: city, mnumber: Phonenumber, email: email },
        success: function (result) {
          $('.error').remove();
          $("#add-new-address").css("display", "none");
          $(".add-address-btn").css("display", "block");
          const newAddressData = JSON.parse(result);
          showAddress(newAddressData.address);
          $.LoadingOverlay("hide");
        }
      });
    }
    else {
      $.LoadingOverlay("hide");
    }
  });

  function feildValidation(fvalue, id, fname) {
    if (fvalue.length < 1) {
      $(id).after("<span class='error'>Enter " + fname + "</span>");
      is_valid = false;
      return;
    }
  }
  function phoneValidation(phone, id) {
    var phoneno = /^[\d]{10}$/;
    if (phone.length < 1) {
      $(id).parent().after("<span class='error'>Enter Phone Number</span>");
      is_valid = false;
      return;
    }
    else if (!phoneno.test(phone)) {
      $(id).parent().after("<span class='error'>Mobile number must 10 digit long</span>");
      is_valid = false;
      return;
    }
  }

  function showAddress(addressData) {
    var addressHtml = "";
    var i = 0;
    addressData.forEach(function (ad) {
      addressHtml += `<li>
                          <div>
                            <input class='form-check-input' id='address${i}' type='radio' name='address' value='${ad.AddressId}'>
                          </div>
                          <div>
                            <label for='address${i}' class='fw-normal'>
                              <p><b>Address:</b> ${ad.AddressLine1}, ${ad.City} ${ad.PostalCode} </p>
                              <p><b>Phone number:</b> ${ad.Mobile}</p>
                            </label>
                          </div>
                        </li>`;
      i++;
    });
    $('.details .address ul').html(addressHtml);
  }
  function showFavSp(favSp) {
    var spHtml = "";
    var i = 0;
    favSp.forEach(function (sp) {
      spHtml += `<div class="fav-sp-l">
                    <label>
                      <input class="form-check-input" type="radio" id='favsp${i}' name="favsp" value="${sp.TargetUserId}">
                      <div class="sp-avtar mb-1">
                        <img src="assets/images/cap.png" alt="">
                      </div>
                      <span class="sp-name">${sp.FullName}</span>
                      <button type="button" class="btn sp-select" id="sp-select${i}" disabled>Select</button>
                    </label>
                  </div>`;
      i++;
    });
    $('.favorite-sp-wraper').html(spHtml);
  }

  // favourite service provider
  $(document).on('click', '.favorite-sp-wraper .fav-sp-l', function () {
    var selectSp = $('.favorite-sp-wraper label input[name=favsp]');
    for (var i = 0; i < selectSp.length; i++) {
      if ($('#favsp' + i).is(':checked')) {
        $('#favsp' + i).parent().find('div').addClass('active');
        $('#sp-select' + i).text("Selected");
      }
      else {
        $('#favsp' + i).parent().find('div').removeClass('active');
        $('#sp-select' + i).text("Select");
      }
    }
  });

  //add address
  $(".add-address-btn button").click(function () {
    $("#add-new-address").css("display", "block");
    $(".add-address-btn").css("display", "none");
  });
  $(".cancel").click(function () {
    $("#add-new-address").css("display", "none");
    $(".add-address-btn").css("display", "block");
  });

  // -----------------make-payment tab-------------------------
  //card number
  $("#cnumber").on("keyup", function (event) {
    var value = $(this).val();
    if (value.length <= 17) {
      if (event.which >= 48 && event.which <= 57) {
        var temp = value.replace(/\s/g, "");
        var len = temp.length;
        if (len % 4 == 0) {
          $(this).val(value + " ");
          flag = 1;
        }
      } else {
        $(this).val(value.substring(0, value.length - 1));
      }
    } else {
      $(this).val(value.substring(0, 18));
      return false;
    }
  });

  //card date
  $("#expiry").on("keyup", function (event) {
    var date = $(this).val();
    if (date.length <= 5) {
      if (event.which >= 48 && event.which <= 57) {
        if (date.length == 2) {
          $(this).val(date + "/");
        }
      } else {
        $(this).val(date.substring(0, date.length - 1));
      }
    } else {
      $(this).val(date.substring(0, 5));
      return false;
    }
  });

  //card cvc
  $("#cvc").on("keyup", function (event) {
    var cvc = $(this).val();
    if (event.which >= 48 && event.which <= 57) {
      if (!cvc.length <= 3) {
        $(this).val(cvc.substring(0, 3));
      }
    } else {
      $(this).val(cvc.substring(0, cvc.length - 1));
    }
  });
});

$('.payment-details-btn').click(function () {
  const userid = $('#userdata').val();
  var postal = $('#na-postal').val();
  if ($('#terms').is(':checked')) {
    $.ajax({
      url: "http://localhost/psd-to-html/Helperland/?controller=Service&function=bookService",
      type: 'POST',
      data: $('#service-schedule-form').serialize() + "&" + $('#details-form').serialize() + "&userId=" + userid + "&postal=" + postal,
      success: function (result) {
        // console.log(result);
        changeNavtabImg();
        const serviceid = JSON.parse(result);
        if (serviceid.sid != 0) {
          $('#successModal #service-id').text(`Service Request Id: ${serviceid.sid}`);
          $.LoadingOverlay("hide");
          $("#successModal").modal('show');
        }
        // console.log(result);
      }
    });
    // console.log($('#service-schedule-form').serialize()+"&"+$('#details-form').serialize()+"&userId="+userid+"&postal="+postal);
  }
  else {
    $.LoadingOverlay("hide");
    alert("Please accept terms and conditions");
  }
});

function showLoader() {
  $.LoadingOverlay("show", {
    background: "rgba(0, 0, 0, 0.7)"
  });
}

function activateNavtabs() {
  var clslist = $('#myTab ._navlink');
  for (var i = 0; i < clslist.length; i++) {
    if (clslist[i].classList.contains("fill")) {
      clslist[i].style.pointerEvents = "auto";
    } else {
      clslist[i].style.pointerEvents = "none";
    }
  }
}

function changeNavtabImg() {
  var whiteImg = ['setup-service', 'schedule', 'details', 'payment'];
  var navitem = document.getElementsByClassName('_navlink');
  for (var i = 0; i < navitem.length; i++) {
    if (navitem[i].classList.contains('fill') || navitem[i].classList.contains('active')) {
      navitem[i].querySelector('img').src = "assets/images/" + whiteImg[i] + "-white.png";
    }
    else {
      navitem[i].querySelector('img').src = "assets/images/" + whiteImg[i] + ".png";
    }
  }
}

function changeNavtab(from1, to1, from2, to2) {
  $("#" + from1).addClass("fill").removeClass("active").attr("aria-selected", "false");
  $("#" + from2).removeClass("show active");

  $("#" + to1).addClass("active").attr("aria-selected", "true");
  $("#" + to2).addClass("show active");
}

// ---------------payment-modal-------------------
$('.payment-modal').click(function () {
  var paymentHtml = $('#payment-div').html();
  $('#paymentModal .modal-body').html(paymentHtml);
});
$(window).resize(function () {
  if ($(window).width() > 767) {
    $("#paymentModal").modal("hide");
  }
});