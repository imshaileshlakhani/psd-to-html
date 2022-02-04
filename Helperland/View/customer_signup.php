<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="assets/css/customer_signup.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/modal.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <script src="https://kit.fontawesome.com/4ae0bb5b6f.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>


    <title>Customer Signup</title>
</head>
<body>
    <?php
        include ('modal/login-model.php');
        include ('includes/header.php');
    ?>

    <main>
        <section id="create-account">
            <div class="text-center title">
                Create an account
            </div>
            <div class="d-flex justify-content-center align-items-center">
                <div class="line"></div>
                <img src="assets/images/separator.png" alt="">
                <div class="line"></div>
            </div>
            <div class="form">
                <form action="<?= $base_url.'?controller=Authentication&function=user_signup'?>" method="post">
                    <input type="hidden" value="1" name="usertypeid">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 pb-3">
                            <input type="text" class="form-control" name="firstname" id="firstname" placeholder="First name" required autofocus />
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 pb-3">
                            <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Last name" required autofocus/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 pb-3">
                            <input type="email" class="form-control" name="email" id="email" placeholder="Email address" required />
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 pb-3">
                            <div class="input-group ">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">+49</div>
                                </div>
                                <input type="number" class="form-control phone" name="phone" id="inlineFormInputGroup" placeholder="Mobile number">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 pb-3">
                            <input type="text" class="form-control" name="psw" id="psw" placeholder="Password" 
                                required autofocus />
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 pb-3">
                            <input type="text" class="form-control" name="cpsw" id="cpsw" placeholder="Confirm Password" required autofocus/>
                        </div>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            Yes, I would like to subscribe to the newsletter of Helperland GmbH with vouchers, trends, promotions and individualized offers. I can unsubscribe from the newsletter at any time in the newsletter and in the customer account itself.
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1">
                        <label class="form-check-label" for="flexCheckDefault1">
                            I agree with the <span>terms and conditions</span> of Helperland GmbH.
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault2">
                        <label class="form-check-label" for="flexCheckDefault2">
                            I have read the <span>privacy policy </span>
                        </label>
                    </div>
                    <div class="submit text-center">
                        <button type="submit" name="register" id="Register">Register</button>
                        <p>Already registered? <span>Login now</span></p>
                    </div>
                </form>
            </div>
        </section>
    </main>
    <?php
        include('includes/footer.php');
    ?>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="assets/js/nav.js"></script>
    <script src="assets/js/validate.js"></script>
</body>
</html>