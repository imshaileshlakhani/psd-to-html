<?php
    $errorMsg = "";
    if(isset($_GET['error'])){
        $errorMsg = $_GET['error'];
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="assets/css/error.css">
    <link rel="stylesheet" href="assets/css/modal.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/footer.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://kit.fontawesome.com/4ae0bb5b6f.js" crossorigin="anonymous"></script>

    <title>Error</title>
</head>

<body>
    <?php
    include('modal/login-model.php');
    include('includes/header.php');
    ?>

    <main>
        <section class="error-section">
            <div class="error-img">
                <img src="assets/images/error.svg" alt="">
            </div>
            <div class="text-center py-4">
                <span>Something went wrong! <?= $errorMsg ?></span>
            </div>
        </section>
    </main>

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