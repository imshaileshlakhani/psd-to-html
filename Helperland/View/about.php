<?php
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

    <link rel="stylesheet" href="assets/css/about.css">
    <link rel="stylesheet" href="assets/css/modal.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/footer.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://kit.fontawesome.com/4ae0bb5b6f.js" crossorigin="anonymous"></script>

    <title>About</title>
</head>

<body>
    <?php
        include ('modal/login-model.php');
        include ('includes/header.php');
    ?>

    <main>
        <section class="hero-img"></section>

        <section class="about">
            <div class="text-center title">
                A Few words about us
            </div>
            <div class="d-flex justify-content-center align-items-center">
                <div class="line"></div>
                <img src="assets/images/separator.png" alt="">
                <div class="line"></div>
            </div>
            <div class="about-content text-center">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean molestie convallis
                    tempor. Duis
                    vestibulum vel risus condimentum dictum. Orci varius natoque penatibus et magnis dis
                    parturient
                    montes, nascetur ridiculus mus. Vivamus quis enim orci. Fusce risus lacus, sollicitudin
                    eu magna
                    sed, pharetra sodales libero. Proin tincidunt vel erat id porttitor. Donec tristique est
                    arcu, sed
                    dignissim velit vulputate ultricies.
                </p>
                <p>
                    Interdum et malesuada fames ac ante ipsum primis in faucibus. In hac habitasse platea
                    dictumst.
                    Vivamus eget mauris eget nisl euismod volutpat sed sed libero. Quisque sit amet lectus
                    ex. Ut semper
                    ligula et mauris tincidunt hendrerit. Aenean ut rhoncus orci, vel elementum turpis.
                    Donec tempor
                    aliquet magna eu fringilla. Nam lobortis libero ut odio finibus lobortis. In hac
                    habitasse platea
                    dictumst. Mauris a hendrerit felis. Praesent ac vehicula ipsum, at porta tellus. Sed
                    dolor augue,
                    posuere sed neque eget, aliquam ultricies velit. Sed lacus elit, tincidunt et massa ac,
                    vehicula
                    placerat lorem.
                </p>
            </div>

            <div class="text-center title">
                Our Story
            </div>
            <div class="d-flex justify-content-center align-items-center">
                <div class="line"></div>
                <img src="assets/images/separator.png" alt="">
                <div class="line"></div>
            </div>
            <div class="story text-center">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean molestie convallis
                    tempor. Duis
                    vestibulum vel risus condimentum dictum. Orci varius natoque penatibus et magnis dis
                    parturient
                    montes, nascetur ridiculus mus. Vivamus quis enim orci. Fusce risus lacus, sollicitudin
                    eu magna
                    sed, pharetra sodales libero. Proin tincidunt vel erat id porttitor. Donec tristique est
                    arcu, sed
                    dignissim velit vulputate ultricies.
                </p>
                <p>
                    Interdum et malesuada fames ac ante ipsum primis in faucibus. In hac habitasse platea
                    dictumst.
                    Vivamus eget mauris eget nisl euismod volutpat sed sed libero. Quisque sit amet lectus
                    ex. Ut semper
                    ligula et mauris tincidunt hendrerit.
                </p>
                <p>
                    Aenean ut rhoncus orci, vel elementum turpis. Donec tempor aliquet magna eu fringilla.
                    Nam lobortis
                    libero ut odio finibus lobortis. In hac habitasse platea dictumst. Mauris a hendrerit
                    felis.
                    Praesent ac vehicula ipsum, at porta tellus. Sed dolor augue, posuere sed neque eget,
                    aliquam
                    ultricies velit. Sed lacus elit, tincidunt et massa ac, vehicula placerat lorem.
                </p>
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
        include ('includes/footer.php');
    ?>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <script src="assets/js/nav.js"></script>
    <script src="assets/js/validate.js"></script>
</body>

</html>