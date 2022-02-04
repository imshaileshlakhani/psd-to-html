<?php
    session_start();
    if(isset($_SESSION['userdata'])){
        $userdata = $_SESSION['userdata'];
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/faq.css">
    <link rel="stylesheet" href="assets/css/modal.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/footer.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://kit.fontawesome.com/4ae0bb5b6f.js" crossorigin="anonymous"></script>

    <title>FAQ Page</title>
</head>

<body>
    <?php
        include ('modal/login-model.php');
        include ('includes/header.php');
    ?>

    <main class="container-fluid">
        <section class="hero-img row">
        </section>

        <section class="faq row">
            <div class="title text-center">
                FAQs
            </div>
            <div class="d-flex justify-content-center align-items-center">
                <div class="line"></div>
                <img src="assets/images/separator.png" alt="">
                <div class="line"></div>
            </div>
            <div class="Whether-you">
                Whether you are Customer or Service provider,<br>
                We have tried our best to solve all your queries and questions.
            </div>
            <div>
                <div class="d-flex flex-row justify-content-center">
                    <div class="customer-tab active1">
                        <div class="For-Customer">
                            For Customer
                        </div>
                    </div>
                    <div class="servicer-tab">
                        <div class="For-Service-Provider">
                            For Service Provider
                        </div>
                    </div>
                </div>

                <div class="bs-example customer">
                    <div class="accordion" id="accordion">
                        <div class="card1" id="headingOne">
                            <p data-toggle="collapse" data-target="#collapseOne" class="qe">
                                <img class="img" src="assets/images/arrow-down.png" alt="">
                                What's included in a cleaning?
                            </p>
                        </div>
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                            data-parent="#accordion">
                            <p class="ans">Bedroom, Living Room & Common Areas, Bathrooms, Kitchen, Extras </p>
                        </div>

                        <div class="card1" id="headingTwo">
                            <p class="collapsed qe" data-toggle="collapse" data-target="#collapseTwo"><img class="img"
                                    src="assets/images/arrow-right.png" alt="">
                                Which Helperland professional will come to my place?
                            </p>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                            <p class="ans">Helperland has a vast network of experienced, top-rated cleaners. Based on the time and date of your request, we work to assign the best professional available. Like working with a specific pro? Add them to your Pro Team from the mobile app and they'll be
                            requested first for all future bookings. You will receive an email with details about your professional prior to your appointment.
                            </p>
                        </div>

                        <div class="card1" id="headingThree">
                            <p class="collapsed qe" data-toggle="collapse" data-target="#collapseThree" class="qe"><img
                                    class="img" src="assets/images/arrow-right.png" alt="">
                                Can I skip or reschedule bookings?
                            </p>
                        </div>
                        <div id="collapseThree" class="collapse " aria-labelledby="headingThree"
                            data-parent="#accordion">
                            <p class="ans">You can reschedule any booking for free at least 24 hours in advance of the scheduled start time. If you need to skip a booking within the minimum commitment, we’ll credit he value of the booking to your account. You can use this credit on future cleanings
                            and other Helperland services. </p>
                        </div>

                        <div class="card1" id="headingFour">
                            <p class="collapsed qe" data-toggle="collapse" data-target="#collapseFour" class="qe"><img
                                    class="img" src="assets/images/arrow-right.png" alt="">
                                Do I need to be home for the booking?
                            </p>
                        </div>
                        <div id="collapseFour" class="collapse " aria-labelledby="headingFour" data-parent="#accordion">
                            <p class="ans">We strongly recommend that you are home for the first clean of your booking to show your cleaner around. Some customers choose to give a spare key to their cleaner, but this decision is based on individual preferences.. </p>
                        </div>
                    </div>
                </div>
                <div class="bs-example service-provider" style="display: none;">
                    <div class="accordion" id="accordion1">
                        <div class="card1" id="heading-One">
                            <p data-toggle="collapse" data-target="#collapse-One" class="qe">
                                <img class="img" src="assets/images/arrow-down.png" alt="">
                                How much do service providers earn?
                            </p>
                        </div>
                        <div id="collapse-One" class="collapse show" aria-labelledby="heading-One"
                            data-parent="#accordion1">
                            <p class="ans">The self-employed service providers working with Helperland set their own payouts, this
                                means that they decide how much they earn per hour.</p>
                        </div>

                        <div class="card1" id="heading-Two">
                            <p class="collapsed qe" data-toggle="collapse" data-target="#collapse-Two" class="qe">
                                <img class="img" src="assets/images/arrow-right.png" alt="">
                                What support do you provide to the service providers?
                            </p>
                        </div>
                        <div id="collapse-Two" class="collapse" aria-labelledby="heading-Two" data-parent="#accordion1">
                            <p class="ans">Our call-centre is available to assist the service providers with all queries or issues
                                in regards to their bookings during office hours. Before a service provider starts
                                receiving jobs, every individual partner receives an orientation session to familiarise
                                with the online platform and their profile. </p>
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
    <?php
        include ('includes/footer.php');
    ?>
    
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <script src="assets/js/faq.js"></script>
    <script src="assets/js/nav.js"></script>
    <script src="assets/js/validate.js"></script>

</body>

</html>