<?php
if (isset($_SESSION['userdata'])) {
    $userdata = $_SESSION['userdata'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="assets/css/contact.css">
    <link rel="stylesheet" href="assets/css/modal.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/footer.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://kit.fontawesome.com/4ae0bb5b6f.js" crossorigin="anonymous"></script>

    <title>Contact</title>
</head>

<body>
    <?php
    include('modal/login-model.php');
    include('includes/header.php');
    ?>

    <main>
        <section class="hero-img"></section>

        <section class="contact">
            <div class="text-center">
                <span class="title">Contact us</span>
            </div>
            <div class="d-flex justify-content-center align-items-center">
                <div class="line"></div>
                <img src="assets/images/separator.png" alt="">
                <div class="line"></div>
            </div>
            <div class="detail-section d-flex flex-wrap justify-content-center">
                <div class="detail text-center">
                    <div class="img"><img src="assets/images/location.png" alt=""></div>
                    <div class="content">
                        <p>1111 Lorem ipsum text 100,</p>
                        <p>Lorem ipsum AB</p>
                    </div>
                </div>
                <div class="detail text-center">
                    <div class="img"><img src="assets/images/phone-call.png" alt=""></div>
                    <div class="content">
                        <p>+49 (40) 123 56 7890</p>
                        <p>+49 (40) 987 56 0000</p>
                    </div>
                </div>
                <div class="detail text-center">
                    <div class="img"><img src="assets/images/mail.png" alt=""></div>
                    <div class="content">
                        <p>info@helperland.com</p>
                    </div>
                </div>
            </div>
            <div class="hr"></div>
            <div class="get-in">
                <div class="text-center">
                    <span class="title">Get in touch with us</span>
                </div>
                <div class="success-msg">

                </div>
                <div class="form">
                    <form action="<?= Config::BASE_URL . '?controller=Public&function=contact_us' ?>" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 pb-3">
                                <input class="form-control" id="firstname" name="firstname" placeholder="First name" type="text" />
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 pb-3">
                                <input class="form-control" id="lastname" name="lastname" placeholder="Last name" type="text" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 pb-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">+49</div>
                                    </div>
                                    <input type="number" class="form-control phone" id="inlineFormInputGroup" placeholder="Mobile number" name="phone">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 pb-3">
                                <input class="form-control" name="email" id="email" placeholder="Email address" type="email" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 pb-3">
                                <div class="form-group">
                                    <select id="inputState" class="form-control" name="subject">
                                        <option selected>Subject</option>
                                        <option value="General">General</option>
                                        <option value="Inquiry">Inquiry</option>
                                        <option value="Renewal">Renewal</option>
                                        <option value="Revocation">Revocation</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 pb-3">
                                <textarea style="resize:vertical;" id="msg" class="form-control msg" placeholder="Message" rows="6" name="msg"></textarea>
                            </div>
                        </div>
                        <div class="row file">
                            <div class="col-lg-12 col-md-12 col-sm-12 pb-3">
                                <input class="form-control" type="file" name="attachment">
                            </div>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="contact-check">
                            <label class="form-check-label" for="contact-check">
                                Our current ones apply <a href="#">privacy policy</a>. I hereby agree that my data entered into the contact form will be stored electronically and processed and used for the purpose of establishing contact. The consent can be withdrawn at any time pursuant to Art. 7 (3) GDPR by informal notification (eg by e-mail).
                            </label>
                        </div>
                        <div class="submit text-center">
                            <button type="submit" name="submit" id="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <section class="map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3671.6979157244446!2d72.49824711495718!3d23.034861321648993!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395e8352e403437b%3A0xdc9d4dae36889fb9!2sTatvaSoft!5e0!3m2!1sen!2sin!4v1638425689672!5m2!1sen!2sin" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
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
    include('includes/footer.php');
    ?>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>

    <script src="assets/js/nav.js"></script>
    <script src="assets/js/public.js"></script>
</body>

</html>