<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="assets/css/sp-signup.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/modal.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <script src="https://kit.fontawesome.com/4ae0bb5b6f.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>


    <title>Become a Pro</title>
</head>
<body>
    <?php
        include('modal/login-model.php');
        include('includes/header.php');
    ?>

    <main>
        <section id="hero-image">
            <div class="hero-image">
                <div id="form">
                    <div class="form">
                        <div class="text-center">
                            <span >Register Now!</span>
                        </div>
                        <form action="#">
                            <div class="signup-msg mt-2"></div>
                            <input type="hidden" value="2" name="usertypeid" id="usertypeid">
                            <div class="row">
                                <div class="">
                                    <input type="text" class="form-control" name="firstname" id="firstname" placeholder="First name" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="">
                                    <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Last name"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="">
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Email Address" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">+46</div>
                                        </div>
                                        <input type="number" class="form-control phone" name="phone" id="inlineFormInputGroup" placeholder="Phone number">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="">
                                    <input type="password" class="form-control" name="psw" id="psw" placeholder="Password" autocomplete/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="">
                                    <input type="password" class="form-control" name="cpsw" id="cpsw" placeholder="Confirm Password" autocomplete/>
                                </div>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1">
                                <label class="form-check-label" for="flexCheckDefault1">
                                    I accept <span>terms and conditions </span>&<span> privacy policy</span>
                                </label>
                            </div>
                            <div class="get-started text-center row">
                                <button type="button" name="register" id="Register">Get Started <img src="assets/images/shape-3.png" alt=""></button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="btn-down">
                    <div class="circle">
                        <a href="#how_it_works">
                            <img src="assets/images/shape-1.png" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <section id="how_it_works">
            <div class="how_it_works">
                <div class="text-center title">
                    How it works
                </div>
                <div class="cards">
                    <div class="single-card">
                        <div class="card-img">
                            <img src="assets/images/group-16.png" alt="">
                        </div>
                        <div class="card-content">
                            <h2>Register yourself</h2>
                            <p>Provide your basic information to register
                                yourself as a service provider.</p>
                            <p class="arrow">Read more <img src="assets/images/shape-2.png" alt=""></p>
                        </div>
                    </div>
                    <div class="single-card">
                        <div class="card-img">
                            <img src="assets/images/group-17.png" alt="">
                        </div>
                        <div class="card-content">
                            <h2>Get service requests</h2>
                            <p>You will get service requests from
                                customes depend on service area and profile.</p>
                            <p class="arrow">Read more <img src="assets/images/shape-2.png" alt=""></p>
                        </div>
                    </div>
                    <div class="single-card">
                        <div class="card-img">
                            <img src="assets/images/group-189.png" alt="">
                        </div>
                        <div class="card-content">
                            <h2>Complete service</h2>
                            <p>Accept service requests from your customers
                                and complete your work.</p>
                            <p class="arrow">Read more <img src="assets/images/shape-2.png" alt=""></p>
                        </div>
                    </div>
                </div>
                <div class="section-newsseltter">
                    <div class="newstitle">
                        <p>get our newsselter</p>
                    </div>
                    <div class="newsform d-flex justify-content-center flex-wrap">
                        <div class="input-field mb-2"><input type="text" placeholder="Your Email"></div>
                        <button>Submit</button>
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
    </main>
    <?php
        include ('includes/footer.php');
    ?>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script src="assets/js/nav.js"></script>
    <script src="assets/js/public.js"></script>
</body>
</html>