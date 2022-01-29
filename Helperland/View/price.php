<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="assets/css/price.css">
    <link rel="stylesheet" href="assets/css/modal.css">
    <link rel="stylesheet" href="assets/css/header2.css">
    <link rel="stylesheet" href="assets/css/footer.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/4ae0bb5b6f.js" crossorigin="anonymous"></script>

    <title>Price</title>
</head>

<body>
    <?php
        include ('modal/login-model.php');
        include ('includes/header.php');
    ?>

    <main>
        <section class="hero-img"></section>

        <section class="price-section">
            <div class="title text-center">Prices</div>
            <div class="d-flex justify-content-center align-items-center">
                <div class="line"></div>
                <img src="assets/images/separator.png" alt="">
                <div class="line"></div>
            </div>
            <div class="onetime">
                <div class="price">
                    <div class="one">One Time</div>
                    <div class="uro d-flex justify-content-center align-items-center">
                        <div class="uro-img"><img src="assets/images/euro-currency-symbol.svg" alt=""></div>
                        <div>
                            <p>20<span>/hr<span></p>
                        </div>
                    </div>
                    <div class="d-flex flex-column">
                        <div class="d-flex ">
                            <img src="assets/images/forma-1_5.png" alt="">
                            <p>Lower prices</p>
                        </div>
                        <div class="d-flex ">
                            <img src="assets/images/forma-1_5.png" alt="">
                            <p>Easy online & secure payment</p>
                        </div>
                        <div class="d-flex ">
                            <img src="assets/images/forma-1_5.png" alt="">
                            <p>Easy amendment</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hr"></div>

            <div class="Extra-services">
                <div class="title text-center">Extra services</div>
                <div class="d-flex justify-content-center align-items-center">
                    <div class="line"></div>
                    <img src="assets/images/separator.png" alt="">
                    <div class="line"></div>
                </div>
                <div class="services-section d-flex flex-wrap">
                    <div>
                        <div class="service">
                            <img src="assets/images/3.png" alt="">
                        </div>
                        <span class="service-name">Inside cabinets</span>
                        <span class="time">30 minutes</span>
                    </div>
                    <div>
                        <div class="service">
                            <img src="assets/images/5.png" alt="">
                        </div>
                        <span class="service-name">Inside fridge</span>
                        <span class="time">30 minutes</span>
                    </div>
                    <div>
                        <div class="service">
                            <img src="assets/images/4.png" alt="">
                        </div>
                        <span class="service-name">Inside oven</span>
                        <span class="time">30 minutes</span>
                    </div>
                    <div>
                        <div class="service">
                            <img src="assets/images/2.png" alt="">
                        </div>
                        <span class="service-name">Laundry wash & dry</span>
                        <span class="time">30 minutes</span>
                    </div>
                    <div>
                        <div class="service">
                            <img src="assets/images/1.png" alt="">
                        </div>
                        <span class="service-name">Interior windows</span>
                        <span class="time">30 minutes</span>
                    </div>
                </div>
            </div>
        </section>

        <section class="include">
            <div class="title text-center">What we include in cleaning</div>
            <div class="d-flex justify-content-center align-items-center">
                <div class="line"></div>
                <img src="assets/images/separator.png" alt="">
                <div class="line"></div>
            </div>

            <div class="include-card d-flex flex-wrap justify-content-center">
                <div class="card1">
                    <div class="img">
                        <img src="assets/images/group-18_4.png" alt="">
                    </div>
                    <div class="content">
                        <div class="card-title">Bedroom and Living Room</div>
                        <div class="content-list">
                            <ul>
                                <li><img src="assets/images/right-arrow-grey.png" alt=""> Dust all accessible
                                    surfaces</li>
                                <li><img src="assets/images/right-arrow-grey.png" alt=""> Wipe down all mirrors
                                    and glass fixtures</li>
                                <li><img src="assets/images/right-arrow-grey.png" alt=""> Clean all floor
                                    surfaces</li>
                                <li><img src="assets/images/right-arrow-grey.png" alt=""> Take out garbage and
                                    recycling</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card1">
                    <div class="img">
                        <img src="assets/images/group-18_2.png" alt="">
                    </div>
                    <div class="content">
                        <div class="card-title">Bathrooms</div>
                        <div class="content-list">
                            <ul>
                                <li><img src="assets/images/right-arrow-grey.png" alt=""> Wash and sanitize the
                                    toilet, shower, tub, sink</li>
                                <li><img src="assets/images/right-arrow-grey.png" alt=""> Dust all accessible
                                    surfaces </li>
                                <li><img src="assets/images/right-arrow-grey.png" alt=""> Wipe down all mirrors
                                    and glass fixtures</li>
                                <li><img src="assets/images/right-arrow-grey.png" alt=""> Clean all floor
                                    surfaces </li>
                                <li><img src="assets/images/right-arrow-grey.png" alt=""> Take out garbage and
                                    recycling </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card1">
                    <div class="img">
                        <img src="assets/images/group-18_3.png" alt="">
                    </div>
                    <div class="content">
                        <div class="card-title">Kitchen</div>
                        <div class="content-list">
                            <ul>
                                <li><img src="assets/images/right-arrow-grey.png" alt=""> Dust all accessible
                                    surfaces</li>
                                <li><img src="assets/images/right-arrow-grey.png" alt=""> Empty sink and load up
                                    dishwasher</li>
                                <li><img src="assets/images/right-arrow-grey.png" alt=""> Wipe down all mirrors
                                    and glass fixtures</li>
                                <li><img src="assets/images/right-arrow-grey.png" alt=""> Clean all floor
                                    surfaces </li>
                                <li><img src="assets/images/right-arrow-grey.png" alt=""> Take out garbage and
                                    recycling </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="why">
            <div class="title text-center">Why Helperland</div>
            <div class="d-flex justify-content-center align-items-center">
                <div class="line"></div>
                <img src="assets/images/separator.png" alt="">
                <div class="line"></div>
            </div>

            <div class="why-card d-flex flex-wrap justify-content-center">
                <div class="card2">
                    <div class="content1">
                        <div class="card-title1">Experienced and vetted professionals</div>
                        <div class="card-content1">dominate the industry in scale and scope with an adaptable, extensive
                            network that consistently delivers exceptional results.</div><br><br>
                        <div class="card-title1">Dedicated customer service</div>
                        <div class="card-content1">to our customers and are guided in all we do by their needs. The team
                            is always happy to support you and offer all the information. you need.</div>
                    </div>
                </div>
                <div class="card2">
                    <div class="img">
                        <img src="assets/images/the-best-img-1.png" alt="">
                    </div>
                </div>
                <div class="card2">
                    <div class="content1">
                        <div class="card-title2">Every cleaning is insured</div>
                        <div class="card-content2">and seek to provide exceptional service and engage in proactive
                            behavior.
                            We‘d be happy to clean your homes.</div><br><br>
                        <div class="card-title2">Secure online payment</div>
                        <div class="card-content2">Payment is processed securely online. Customers pay safely online and
                            manage
                            the booking.</div>
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

    <script src="assets/js/nav.js"></script>
</body>

</html>