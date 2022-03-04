<?php
    if(isset($_SESSION['userdata'])){
        $userdata = $_SESSION['userdata'];
    }
    else{
        header('location: '.Config::BASE_URL.'?controller=Public&function=home');
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="assets/css/book_service.css">
    <link rel="stylesheet" href="assets/css/modal.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/footer.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://kit.fontawesome.com/4ae0bb5b6f.js" crossorigin="anonymous"></script>

    <title>Book Service</title>
</head>

<body onload="defaultDate()">
    <?php
        include('modal/login-model.php');
        include('modal/payment-card.php');
        include('modal/success-model.php');

        include('includes/header.php');
    ?>
    <main>
        <section class="hero-img"></section>

        <section class="book-service-section">
            <div class="text-center title">
                Set up your cleaning service
            </div>
            <div class="d-flex justify-content-center align-items-center">
                <div class="line"></div>
                <img src="assets/images/separator.png" alt="">
                <div class="line"></div>
            </div>
            <div class="book-service">
                <div class="service-tab">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link _navlink active fill" id="service-setup-tab" data-bs-toggle="tab" data-bs-target="#service-setup" type="button" role="tab" aria-controls="service-setup" aria-selected="true">
                                <img src="assets/images/setup-service.png" alt="">
                                <span>Setup Service</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link _navlink" id="schedule-tab" data-bs-toggle="tab" data-bs-target="#schedule" type="button" role="tab" aria-controls="schedule" aria-selected="false">
                                <img src="assets/images/schedule.png" alt="">
                                <span>Schedule & Plan</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link _navlink" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab" aria-controls="details" aria-selected="false">
                                <img src="assets/images/details.png" alt="">
                                <span>Your Details</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link _navlink" id="payment-tab" data-bs-toggle="tab" data-bs-target="#payment" type="button" role="tab" aria-controls="payment" aria-selected="false">
                                <img src="assets/images/payment.png" alt="">
                                <span>Make Payment</span>
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="service-setup" role="tabpanel" aria-labelledby="service-setup-tab">
                            <div class="show-title">
                                Setup Service
                            </div>
                            <div class="service-setup-content">
                                <form action="<?= Config::BASE_URL.'?controller=Service&function=postal'?>" id="setup-service-form" onsubmit="event.preventDefault();">
                                    <span>Enter your Postal Code</span>
                                    <div class="postal-code">
                                        <div class="form-group mb-2">
                                            <input type="text" id="postal" class="form-control" placeholder="Postal code">
                                        </div>
                                        <div class="mx-2">
                                            <button type="submit" class="btn form-control postal-check" onClick="showLoader()">Check Availability</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="tab-pane fade " id="schedule" role="tabpanel" aria-labelledby="schedule-tab">
                            <div class="show-title">
                                Schedule & Plan
                            </div>
                            <div class="service-schedule">
                                <form action="" onsubmit="event.preventDefault();" id="service-schedule-form">
                                    <div class="service-time d-flex align-items-center flex-wrap bb">
                                        <div class="d-flex align-items-end flex-wrap">
                                            <div class="form-group">
                                                <label for="date">When do you need the cleaner?</label>
                                                <input type="date" name="date" id="date" min="<?= date('Y-m-d')?>" class="form-control w-75">
                                            </div>
                                            <div class="form-group">
                                                <select class="form-select" name="time" id="time" aria-label="service-time">
                                                    <option selected value="8">8:00</option>
                                                    <option value="8.5">8:30</option>
                                                    <option value="9">9:00</option>
                                                    <option value="9.5">9:30</option>
                                                    <option value="10">10:00</option>
                                                    <option value="10.5">10:30</option>
                                                    <option value="11">11:00</option>
                                                    <option value="11.5">11:30</option>
                                                    <option value="12">12:00</option>
                                                    <option value="12.5">12:30</option>
                                                    <option value="13">13:00</option>
                                                    <option value="13.5">13:30</option>
                                                    <option value="14">14:00</option>
                                                    <option value="14.5">14:30</option>
                                                    <option value="15">15:00</option>
                                                    <option value="15.5">15:30</option>
                                                    <option value="16">16:00</option>
                                                    <option value="16.5">16:30</option>
                                                    <option value="17">17:00</option>
                                                    <option value="17.5">17:30</option>
                                                    <option value="18">18:00</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="hr">How long do you need your cleaner to stay?</label>
                                            <select class="form-select w-50" name="totalhr" id="hr" aria-label="hrs">
                                                <option selected value="3">3.0 Hrs</option>
                                                <option value="3.5">3.5 Hrs</option>
                                                <option value="4">4.0 Hrs</option>
                                                <option value="4.5">4.5 Hrs</option>
                                                <option value="5">5.0 Hrs</option>
                                                <option value="5.5">5.5 Hrs</option>
                                                <option value="6">6.0 Hrs</option>
                                                <option value="6.5">6.5 Hrs</option>
                                                <option value="7">7.0 Hrs</option>
                                                <option value="7.5">7.5 Hrs</option>
                                                <option value="8">8.0 Hrs</option>
                                                <option value="8.5">8.5 Hrs</option>
                                                <option value="9">9.0 Hrs</option>
                                                <option value="9.5">9.5 Hrs</option>
                                                <option value="10">10.0 Hrs</option>
                                                <option value="10.5">10.5 Hrs</option>
                                                <option value="11">11.0 Hrs</option>
                                                <option value="11.5">11.5 Hrs</option>
                                                <option value="12">12.0 Hrs</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="extra-service-section bb">
                                        <span>Extra Services</span>
                                        <div class="extra-service d-flex flex-wrap" id="extra-service">
                                            <label>
                                                <input class="form-check-input" name="extra[]" type="checkbox" value="1">
                                                <div class="service">
                                                    <img src="assets/images/1.png" alt="">
                                                </div>
                                                <span class="service-name">Inside cabinets</span>
                                            </label>
                                            <label>
                                                <input class="form-check-input" type="checkbox" name="extra[]" value="2">
                                                <div class="service">
                                                    <img src="assets/images/2.png" alt="">
                                                </div>
                                                <span class="service-name">Inside fridge</span>
                                            </label>
                                            <label>
                                                <input class="form-check-input" type="checkbox" name="extra[]" value="3">
                                                <div class="service">
                                                    <img src="assets/images/3.png" alt="">
                                                </div>
                                                <span class="service-name">Inside oven</span>
                                            </label>
                                            <label>
                                                <input class="form-check-input" type="checkbox" name="extra[]" value="4">
                                                <div class="service">
                                                    <img src="assets/images/4.png" alt="">
                                                </div>
                                                <span class="service-name">Laundry wash & dry</span>
                                            </label>
                                            <label>
                                                <input class="form-check-input" type="checkbox" name="extra[]" value="5">
                                                <div class="service">
                                                    <img src="assets/images/5.png" alt="">
                                                </div>
                                                <span class="service-name">Interior windows</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="comment bb">
                                        <span>Comments</span>
                                        <div class="">
                                            <textarea name="comment" class="form-control" id="" rows="3"></textarea>
                                        </div>
                                        <div class="form-check my-3">
                                            <input class="form-check-input" name="pet" type="checkbox" id="pet-check" value="1">
                                            I have pets at home
                                        </div>
                                    </div>
                                    <div class="continue-btn pt-4">
                                        <button type="button" class="btn form-control w-auto px-4 float-end Schedule-btn" id="Schedule-btn" onClick="showLoader()">Continue</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="details" role="tabpanel" aria-labelledby="details-tab">
                            <div class="show-title">
                                Your Details
                            </div>
                            <div class="details pt-3">
                                <form action="" onsubmit="event.preventDefault();" id="details-form">
                                    <span>Enter your contact details, so we can serve you in better way!</span>
                                    <div class="address bb">
                                        <ul>
                                            
                                        </ul>
                                        <div class="add-address-btn">
                                            <button type="button" class="btn form-control w-auto px-4">+ Add New Address</button>
                                        </div>
                                        <div id="add-new-address">
                                            <div class="card card-body">
                                                <input type="hidden" id="na-statename">
                                                <input type="hidden" id="uemail" value="<?= $userdata['Email']?>">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="Streetname">Street name</label>
                                                            <input type="text" class="form-control" id="na-Streetname" placeholder="Street name">
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="Housename">House number</label>
                                                            <input type="text" class="form-control" id="na-Housenumber" placeholder="House name">
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="Postalname">Postal code</label>
                                                            <input type="text" class="form-control" id="na-postal" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="City">City</label>
                                                            <select class="form-select mb-3" id="na-city">
                                                                <option selected value=""></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="Phonenumber">Phone number</label>
                                                            <div class="input-group">
                                                                <div class="input-group-text">+49</div>
                                                                <input type="text" class="form-control" id="na-Phonenumber" placeholder="9988556644">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="btn-wraper">
                                                    <button type="submit" class="save" id="na-save" onClick="showLoader()">Save</button>
                                                    <button type="button" class="cancel">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="favorite-sp-section">
                                            <span class="bb">Your Favorite Service Provider</span>
                                            <div>You can choose your favorite service provider from the below list</div>
                                            <div class="favorite-sp-wraper d-flex">
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="continue-btn pt-4">
                                        <button type="button" class="btn form-control w-auto px-4 float-end details-btn">Continue</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="payment" role="tabpanel" aria-labelledby="payment-tab">
                            <div class="show-title">
                                Make Payment
                            </div>
                            <div class="payment-details">
                                <form action="" onsubmit="event.preventDefault();">
                                    <span>Pay securely with Helperland payment gateway!</span>
                                    <div class="promocode bb">
                                        <div class="form-group">
                                            <label for="">Promo code (optional)</label>
                                            <input type="text" class="form-control" placeholder="Promo code (optional)">
                                        </div>
                                        <div class="promo-apply px-2 pt-2">
                                            <button type="submit" class="btn w-auto px-4 form-control">Apply</button>
                                        </div>
                                    </div>
                                    <div class="card-details">
                                        <div class="card-number">
                                            <i class="fa fa-credit-card"></i>
                                            <input type="text" id="cnumber" placeholder="Card number">
                                        </div>
                                        <div class="card-expiry">
                                            <div>
                                                <input type="text" placeholder="MM/YY" id="expiry">
                                            </div>
                                            <div>
                                                <input type="text" placeholder="CVC" id="cvc">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="Accpeted-cards">
                                        <span>Accpeted Cards:</span>
                                        <div class="d-flex">
                                            <img src="assets/images/credit-card-1.png" alt="">
                                            <img src="assets/images/credit-card-2.png" alt="">
                                            <img src="assets/images/credit-card-3.png" alt="">
                                        </div>
                                    </div>
                                    <div class="form-check my-4 bb">
                                        <input class="form-check-input" type="checkbox" value="" id="terms">
                                        I accepted <a href="#">terms and conditions</a>, the <a href="#">cancellation
                                            policy</a> and the <a href="#">privacy policy</a>. I confirm that Helperland
                                        starts to execute the contract before the expiry of the withdrawal period and I
                                        lose my right of withdrawal as a consumer with full performance of the contract.
                                    </div>
                                    <div class="continue-btn pt-4">
                                        <button type="submit" class="btn form-control w-auto px-4 float-end payment-details-btn" onClick="showLoader()">Complete
                                            Booking</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="arrow">
                    <a class="navlink navbtn payment-modal" href="#" data-bs-toggle="modal" data-bs-target="#paymentModal" data-bs-dismiss="modal">Payment</a>
                </div>
                <div id="payment-div">
                    <div class="payment-tab">
                        <div class="payment-card">
                            <div class="payment-Summary">
                                <div>Payment Summary</div>
                            </div>

                            <div class="book-time">
                                <div class="d-flex">
                                    <div class="d-flex">
                                        <div class="date">01/01/2018</div>&nbsp;
                                        <div>@</div>&nbsp;
                                    </div>
                                    <div class="">
                                        <div class="time">8:00</div>
                                    </div>
                                </div>
                            </div>

                            <div class="duration bb">
                                <span>Duration</span>
                                <div>
                                    <div class="basic-service-time d-flex flex-column">
                                        <div class="basic" id="basic">
                                            <div>Basic</div>
                                            <div class="">
                                                <div class="hr">0 Hrs</div>
                                            </div>
                                        </div>
                                        <div class="extra-service-time d-flex flex-column">
                                            
                                        </div>
                                    </div>
                                    
                                    <div class="total-time">
                                        <div><b>Total Service Time</b></div>
                                        <div class="">
                                            <div class="total-hr fw-bold">3 Hrs</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="per-cleaning">
                                <div class="">
                                    <div>Per cleaning</div>
                                    <div class="d-flex">
                                        <div class="per-service"><b>0</b></div>
                                        <div><b>,00 €</b></div>
                                    </div>
                                </div>
                                <div class="discount">
                                    <div>Discount</div>
                                    <div><b>0,00 €</b></div>
                                </div>
                            </div>

                            <div class="total-payment">
                                <div class="price">
                                    <div>Total Payment</div>
                                    <div class="d-flex">
                                        <div class="total-bill"><b>0</b></div>
                                        <div><b>,00 €</b></div>
                                    </div>
                                </div>
                                <div class="effective-price mt-2">
                                    <div>Effective Price</div>
                                    <div><b>0,00 €</b></div>
                                </div>
                                <div class="save mt-2"><a href=""><span>*</span>You will save 20% according to §35a
                                    EStG.</a></div>
                            </div>

                            <div class="smily">
                                <img src="assets/images/smiley.png" alt=""> See what is always included
                            </div>
                        </div>
                        <div class="faq">
                            <div class="text-center">Questions?</div>
                            <div class="accordion" id="accordion">
                                <div class="card1" id="heading-One">
                                    <p data-toggle="collapse" data-target="#collapse-One" class="qe">
                                        <img class="img" src="assets/images/drop-arrow.png" alt="">
                                        What's included in a cleaning?
                                    </p>
                                </div>
                                <div id="collapse-One" class="collapse show" aria-labelledby="heading-One" data-parent="#accordion">
                                    <p class="ans">Bedroom, Living Room & Common Areas, Bathrooms, Kitchen, Extras</p>
                                </div>

                                <div class="card1" id="heading-Two">
                                    <p class="collapsed qe" data-toggle="collapse" data-target="#collapse-Two" class="qe">
                                        <img class="img" src="assets/images/drop-arrow.png" alt="">
                                        Can I skip or reschedule bookings?
                                    </p>
                                </div>
                                <div id="collapse-Two" class="collapse" aria-labelledby="heading-Two" data-parent="#accordion">
                                    <p class="ans">You can reschedule any booking for free at least 24 hours in advance of the scheduled start time. If you need to skip a booking within the minimum commitment, we’ll credit the value of the booking to your account. You can use this credit on future cleanings and other Helperland services.</p>
                                </div>
                            </div>
                            <div class="link"><a href="<?= Config::BASE_URL.'?controller=Public&function=faq' ?>">For more help</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section-newsseltter">
            <div class="newstitle">
                <p>get our newsselter</p>
            </div>
            <div class="newsform d-flex justify-content-center flex-wrap">
                <div class="input-field mb-2"><input type="text" placeholder="Your Email"></div>
                <button>Submit</button>
            </div>
        </section>

    </main>
    <!-- footer-section -->
    <?php
    include('includes/footer.php');
    ?>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>

    <script src="assets/js/nav.js"></script>
    <script src="assets/js/validate.js"></script>
    <script src="assets/js/book_service.js"></script>
</body>

</html>