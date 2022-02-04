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

    <link rel="stylesheet" href="assets/css/index.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/modal.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://kit.fontawesome.com/4ae0bb5b6f.js"></script>

    <title>Homepage</title>
</head>

<body>
    <?php
        include('modal/login-model.php');
        include ('includes/header.php');
    ?>
    
    <main>
        <section id="hero-image">
            <div class="hero-image">
                <div class="home-content">
                    <div class="home-heading">
                        <h1><span>Do not feel like</span><span>housework?</span></h1>
                    </div>
                    <ul class="list">
                        <li><i class="fa fa-check"></i> open time-management</li>
                        <li><i class="fa fa-check"></i> only accept suitable requests</li>
                        <li><i class="fa fa-check"></i> fair and fixed hourly wage</li>
                    </ul>
                </div>
                <div class="btn-lets">
                    <a href="">Let’s Book a Cleaner</a>
                </div>
                <div class="steps">
                    <div class="all-steps">
                        <div class="step">
                            <div class="step-img">
                                <img src="assets/images/step1.png" alt="">
                                <div class="step-text">
                                    Enter Your Postcode
                                </div>
                            </div>
                            <div class="step-arrow">
                                <img src="assets/images/step-down-arrow.png" alt="">
                            </div>
                        </div>
                        <div class="step">
                            <div class="step-img">
                                <img src="assets/images/step2.png" alt="">
                                <div class="step-text">
                                    Select your plan
                                </div>
                            </div>
                            <div class="step-arrow">
                                <img src="assets/images/step-up-arrow.png" alt="">
                            </div>
                        </div>
                        <div class="step">
                            <div class="step-img">
                                <img src="assets/images/step3.png" alt="">
                                <div class="step-text">
                                    Pay securely online
                                </div>
                            </div>
                            <div class="step-arrow">
                                <img src="assets/images/step-down-arrow.png" alt="">
                            </div>
                        </div>
                        <div class="step">
                            <div class="step-img">
                                <img src="assets/images/step4.png" alt="">
                                <div class="step-text">
                                    Enjoy Amazing Service
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="btn-down">
                    <a href="#Helperland">
                        <div class="circle">
                            <img src="assets/images/shape-1.png" alt="">
                        </div>
                    </a>
                </div>
            </div>
        </section>

        <section id="Helperland">
            <div class="title text-center">
                Why Helperland
            </div>

            <div class="card-deck">
                <div class="card1">
                    <div class="img">
                        <img class="card-img-top" src="assets/images/group-21.png" alt="Card image cap">
                    </div>
                    <div class="card-body">
                        <div class="card-heading">
                            Experience & Vetted
                            Professionals
                        </div>
                        <div class="card-content">
                            dominate the industry in scale and scope with an adaptable, extensive network that
                            consistently delivers exceptional results.
                        </div>
                    </div>
                </div>
                <div class="card1">
                    <div class="img">
                        <img class="card-img-top" src="assets/images/group-23.jpg" alt="Card image cap">
                    </div>
                    <div class="card-body">
                        <div class="card-heading card-heading1">
                            Secure Online Payment
                        </div>
                        <div class="card-content">
                            Payment is processed securely online. Customers pay safely online and
                            manage the booking.
                        </div>
                    </div>
                </div>
                <div class="card1">
                    <div class="img">
                        <img class="card-img-top" src="assets/images/group-24.png" alt="Card image cap">
                    </div>
                    <div class="card-body">
                        <div class="card-heading">
                            Dedicated Customer
                            Service
                        </div>
                        <div class="card-content">
                            to our customers and are guided in all we do by their needs. The team is always happy to
                            support you and offer all the information.
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="Blog">
            <div class="lorem-container">
                <div class="lorem">
                    <p>Lorem ipsum dolor sit amet,<br> consectetur</p>
                    <div class="p">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec nisi sapien, suscipit ut
                            accumsan vitae, pulvinar ac libero.</p>
                        <p>
                        </p> Aliquam erat volutpat. Nullam quis ex odio. Nam bibendum cursus purus, vel efficitur
                        urna finibus vitae. Nullam finibus aliquet pharetra. Morbi in sem dolor. Integer pretium
                        hendrerit ante quis vehicula.</p>
                        <p> Mauris consequat ornare enim, sed lobortis quam ultrices sed.</p>
                    </div>
                </div>
                <div class="lorem-img">
                    <img src="assets/images/group-36.png" alt="">
                </div>
            </div>
            <div class="title text-center" id="Blog1">
                Our Blog
            </div>

            <div class="blog-container">
                <div class="blog card">
                    <img class="card-img-top" src="assets/images/blog1.png" alt="Card image cap">
                    <div class="card-body">
                        <p class="card-title">Lorem ipsum dolor sit amet<br><span class="card-date">January 28,
                                2019</span></p>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed fermentum
                            metus pulvinar aliquet.</p>
                        <p class="read-more">
                            Read the Post <img src="assets/images/shape-2.png" alt="">
                        </p>
                    </div>
                </div>
                <div class="blog card">
                    <img class="card-img-top" src="assets/images/blog2.png" alt="Card image cap">
                    <div class="card-body">
                        <p class="card-title">Lorem ipsum dolor sit amet<br><span class="card-date">January 28,
                                2019</span></p>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed fermentum
                            metus pulvinar aliquet.</p>
                        <p class="read-more">
                            Read the Post <img src="assets/images/shape-2.png" alt="">
                        </p>
                    </div>
                </div>
                <div class="blog card">
                    <img class="card-img-top" src="assets/images/blog3.png" alt="Card image cap">
                    <div class="card-body">
                        <p class="card-title">Lorem ipsum dolor sit amet<br><span class="card-date">January 28,
                                2019</span></p>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed fermentum
                            metus pulvinar aliquet.</p>
                        <p class="read-more">
                            Read the Post <img src="assets/images/shape-2.png" alt="">
                        </p>
                    </div>
                </div>
            </div>
            <div class="left-img">
                <img src="assets/images/blog-left-bg.png" alt="">
            </div>
            <div class="right-img">
                <img src="assets/images/blog-right-bg.png" alt="">
            </div>
        </section>

        <section id="Customers-Say">
            <div class="title text-center">
                What Our Customers Say
            </div>
            <div class="customers-container">
                <div class="customers">
                    <div class="about-customer">
                        <div class="customer-profile">
                            <img src="assets/images/profile1.png" alt="">
                        </div>
                        <div class="customer-name">
                            <div>
                                <h3 class="name">Lary Waston</h3>
                            </div>
                            <div>
                                <p class="city">Manchester</p>
                            </div>
                        </div>
                        <div class="customer-msg">
                            <img src="assets/images/message.png" alt="">
                        </div>
                    </div>
                    <div class="customer-content">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed fermentum metus pulvinar
                            aliquet consequat. Praesent nec malesuada nibh.<br><br>

                            Nullam et metus congue, auctor augue sit amet, consectetur tortor. </p>
                    </div>
                    <div class="read-more">
                        Read More <img src="assets/images/shape-2.png" alt="">
                    </div>
                </div>
                <div class="customers">
                    <div class="about-customer">
                        <div class="customer-profile">
                            <img src="assets/images/profile2.png" alt="">
                        </div>
                        <div class="customer-name">
                            <div>
                                <h3 class="name">John Smith</h3>
                            </div>
                            <div>
                                <p class="city">Manchester</p>
                            </div>
                        </div>
                        <div class="customer-msg">
                            <img src="assets/images/message.png" alt="">
                        </div>
                    </div>
                    <div class="customer-content">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed fermentum metus pulvinar
                            aliquet consequat. Praesent nec malesuada nibh.<br><br>

                            Nullam et metus congue, auctor augue sit amet, consectetur tortor. </p>
                    </div>
                    <div class="read-more">
                        Read More <img src="assets/images/shape-2.png" alt="">
                    </div>
                </div>
                <div class="customers">
                    <div class="about-customer">
                        <div class="customer-profile">
                            <img src="assets/images/profile3.png" alt="">
                        </div>
                        <div class="customer-name">
                            <div>
                                <h3 class="name">Lars Johnson</h3>
                            </div>
                            <div>
                                <p class="city">Manchester</p>
                            </div>
                        </div>
                        <div class="customer-msg">
                            <img src="assets/images/message.png" alt="">
                        </div>
                    </div>
                    <div class="customer-content">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed fermentum metus pulvinar
                            aliquet consequat. Praesent nec malesuada nibh.<br><br>

                            Nullam et metus congue, auctor augue sit amet, consectetur tortor. </p>
                    </div>
                    <div class="read-more">
                        Read More <img src="assets/images/shape-2.png" alt="">
                    </div>
                </div>
            </div>

            <div class="newsletter">
                <div class="up">
                    <a href="#hero-image"><img src="assets/images/forma-1.png" alt=""></a>
                </div>
                <div class="msg-box">
                    <div class="GET-OUR-NEWSLETTER text-center">
                        GET OUR NEWSLETTER
                    </div>
                    <div class="msg-foam">
                        <input type="text" class="inputbox" placeholder="YOUR EMAIL">
                        <button class="submit-btn">Submit</button>
                    </div>
                </div>
                <div class="layer">
                    <img src="assets/images/layer.png" alt="">
                </div>
            </div>
        </section>
    </main>
    <footer id="footer">
        <div class="footer">
            <div class="footer-img">
                <img src="assets/images/white-logo-transparent-background.png" class="footer1-logo ">
            </div>
            <div class="footer-nav">
                <ul>
                    <li><a href="#hero-image">HOME</a></li>
                    <li><a href="<?= $base_url.'?controller=Public&function=about' ?>">ABOUT</a></li>
                    <li><a href="#Customers-Say">TESTIMONIALS</a></li>
                    <li><a href="<?= $base_url.'?controller=Public&function=faq' ?>">FAQS</a></li>
                    <li><a href="#">INSURANCE POLICY</a></li>
                    <li><a href="#">IMPRESSUM</a></li>
                </ul>
            </div>
            <div class="social">
                <img src="assets/images/facebook.png" alt="">
                <img src="assets/images/insta.png" alt="">
            </div>
        </div>
        <div class="footer2">
            <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut feugiat nunc libero, ac malesuada ligula
                aliquam ac. <span>Privacy Policy</span></div>
            <button class="footer2-btn">OK!</button>
        </div>
    </footer>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="assets/js/nav.js"></script>
    <script src="assets/js/validate.js"></script>
</body>

</html>