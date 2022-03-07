<?php
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

    <link rel="stylesheet" href="assets/css/Servicer-Dashboard.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/modal.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/4ae0bb5b6f.js" crossorigin="anonymous"></script>

    <title>New Service Request</title>
</head>

<body>    
    <?php
        // modal start
        include("View/modal/Sidebar-Servicer.php");
        include("View/modal/ServiceDetails-Servicer.php");

        // header-section
        include ('View/includes/header.php');
    ?>

    <main>
        <input type="hidden" id="tab-name" value="<?php if(isset($_GET['parameter'])){ echo $_GET['parameter']; }?>">
        <section id="welcome">
            <div class="welcome">
                <div class="text-center">Welcome, <span id="welcome-name"><?= $userdata["FirstName"] ?></span></div>
            </div>
        </section>
        <section id="service-section">
            <div class="service-section">
                <div class="sidebar">
                    <a href="#">Dashboard</a>
                    <a href="<?= Config::BASE_URL.'?controller=Servicer&function=ServicerDashboard&parameter=New'?>" class="<?php if($_GET['parameter'] == "New"){ echo 'active'; }?>" class="active" id="New">New Service Requests</a>

                    <a href="<?= Config::BASE_URL.'?controller=Servicer&function=ServicerDashboard&parameter=Upcoming'?>" class="<?php if($_GET['parameter'] == "Upcoming"){ echo 'active'; }?>" id="Upcoming">Upcoming Services</a>

                    <a href="#">Service Schedule</a>

                    <a href="<?= Config::BASE_URL.'?controller=Servicer&function=ServicerDashboard&parameter=History'?>" class="<?php if($_GET['parameter'] == "History"){ echo 'active'; }?>" id="History">Service History</a>

                    <a href="<?= Config::BASE_URL.'?controller=Servicer&function=ServicerDashboard&parameter=Ratings'?>" class="<?php if($_GET['parameter'] == "Ratings"){ echo 'active'; }?>" id="Ratings">My Ratings</a>

                    <a href="<?= Config::BASE_URL.'?controller=Servicer&function=ServicerDashboard&parameter=Block'?>" class="<?php if($_GET['parameter'] == "Block"){ echo 'active'; }?>" id="Block">Block Customer</a>
                </div>
                    <?php
                        if(isset($_GET['parameter'])){
                            $parameter = $_GET['parameter'];
                            switch ($parameter) {
                                case "New":
                                    include('View/Servicer/New-Service-Request.php');
                                    break;
                                case "Upcoming":
                                    include('View/Servicer/Upcoming-Service.php');
                                    break;
                                case "History":
                                    include('View/Servicer/Service-History.php');
                                    break;
                                case "Ratings":
                                    include('View/Servicer/My-Rating.php');
                                    break;
                                case "Block":
                                    include('View/Servicer/Block-Customer.php');
                                    break;
                                case "setting":
                                    include('View/Servicer/My-Setting.php');
                                    break;
                                default:
                                    include('View/Servicer/New-Service-Request.php');
                            }
                        }else{
                            include('View/Servicer/New-Service-Request.php');
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
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <script src="assets/js/nav.js"></script>
    <script src="assets/js/servicer.js"></script>
</body>

</html>