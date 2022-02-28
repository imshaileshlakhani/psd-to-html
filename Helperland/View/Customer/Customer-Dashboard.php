<?php
    // include("config.php");
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

    <link rel="stylesheet" href="assets/css/Customer-Dashboard.css">
    <link rel="stylesheet" href="assets/css/modal.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/4ae0bb5b6f.js" crossorigin="anonymous"></script>
    
    
    <title>Customer Dashboard</title>
</head>

<body onload="defaultDate()">
    
    <?php
        //  model start 
        include("View/modal/Service-Reschedule.php");
        include("View/modal/Service-Cancle.php");
        include("View/modal/ServiceDetails-Customer.php");
        include("View/modal/Sidebar-Customer.php");
        include("View/modal/success-model.php");
        include("View/modal/Rate-Servicer.php");
        include("View/modal/AddEdit-Address.php");

        // header-section
        include ('View/includes/header.php');
    ?>

    <main>
        <input type="hidden" name="" id="tab-name" value="<?php if(isset($_GET['parameter'])){ echo $_GET['parameter']; }?>">
        <section id="welcome">
            <div class="welcome">
                <div class="text-center">Welcome, <span id="welcome-name"><?= $userdata["FirstName"] ?></span></div>
            </div>
        </section>
        <section id="service-section">
            <div class="service-section">
                <div class="sidebar">
                    <a href="<?= Config::BASE_URL.'?controller=Customer&function=customerDashboard&parameter=Dashboard'?>" class="<?php if($_GET['parameter'] == "Dashboard"){ echo 'active'; }?>" id="Dashboard">Dashboard</a>
                    <a href="<?= Config::BASE_URL.'?controller=Customer&function=customerDashboard&parameter=History'?>" class="<?php if($_GET['parameter'] == "History"){ echo 'active'; }?>" id="History">Service History</a>
                    <a href="#">Service Schedule</a>
                    <a href="<?= Config::BASE_URL.'?controller=Customer&function=customerDashboard&parameter=Favourite'?>" class="<?php if($_GET['parameter'] == "Favourite"){ echo 'active'; }?>" id="Favourite">Favourite Pros</a>
                    <a href="#">Invoices</a>
                    <a href="#">Notifications</a>
                </div>
                
                <?php
                    if(isset($_GET['parameter'])){
                        $parameter = $_GET['parameter'];
                        switch ($parameter) {
                            case "History":
                                include('View/Customer/Service-history.php');
                                break;
                            case "Favourite":
                                include('View/Customer/Favourite-pros.php');
                                break;
                            case "setting":
                                include('View/Customer/My-Setting.php');
                                break;
                            default:
                                include('View/Customer/Dashboard.php');
                          }
                    }else{
                        include('View/Customer/Dashboard.php');
                    }
                ?>
            </div>
        </section>
    </main>
    <?php
        include ('View/includes/footer.php');
    ?>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="assets/js/nav.js"></script>
    <script src="assets/js/validate.js"></script>
    <script src="assets/js/customer.js"></script>
</body>

</html>