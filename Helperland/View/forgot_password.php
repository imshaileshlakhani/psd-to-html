<?php
    $email = "";
    if(isset($_GET['parameter'])){
        $email = $_GET['parameter'];
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="assets/css/forgot_password.css">
    <link rel="stylesheet" href="assets/css/modal.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/footer.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://kit.fontawesome.com/4ae0bb5b6f.js" crossorigin="anonymous"></script>

    <title>Forgot Password</title>
</head>

<body>
    <?php
        include('modal/login-model.php');
        include('includes/header.php');
    ?>

    <main>
        <section class="forgot-password-section">
            <div class="text-center title">
                Forgot Password
            </div>
            <div class="d-flex justify-content-center align-items-center">
                <div class="line"></div>
                <img src="assets/images/separator.png" alt="">
                <div class="line"></div>
            </div>
            <div class="forgot-password" id="forgot-password">
                <form action="<?= Config::BASE_URL.'?controller=Authentication&function=forgot_password' ?>" method="post">
                    <input type="hidden" name="email" value="<?php if(isset($_GET['parameter'])){ echo $email;}?>">
                    <div class="pb-4">
                        <label for="newpsw">New Password</label>
                        <input class="form-control" id="newpsw" name="newpsw" placeholder="Password" type="password"
                    />
                    </div>
                    <div class="pb-4">
                        <label for="cpsw">Confirm Password</label>
                        <input class="form-control" id="oldpsw" name="cpsw" placeholder="Confirm Password" type="password"/>
                    </div>
                    <div class="save-btn">
                        <button type="submit" name="save" id="save" class="save">Save</button>
                    </div>
                </form>
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

    <script src="assets/js/nav.js"></script>
    <script src="assets/js/validate.js"></script>
</body>

</html>