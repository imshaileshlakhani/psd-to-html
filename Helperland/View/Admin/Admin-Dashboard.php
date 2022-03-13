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

    <link rel="stylesheet" href="assets/css/admin-header.css">
    <link rel="stylesheet" href="assets/css/modal.css">
    <link rel="stylesheet" href="assets/css/Admin-Dashboard.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">

    <script src="https://kit.fontawesome.com/4ae0bb5b6f.js" crossorigin="anonymous"></script>

    <title>Admin Dashboard</title>
</head>

<body>
    <?php
        // modal start
        include("View/modal/EditService-Admin.php");
    ?>

    <input type="hidden" id="userdata" value="<?php if(isset($userdata)){ echo $userdata['UserId']; } ?>">
    <header id="header">
        <div class="header">
            <div class="brand d-flex align-items-center">
                <div>
                    <a class="navbarbrand" href="index.php">
                        <img src="assets/images/admin-logo.png" alt="">
                    </a>
                </div>
            </div>
            <ul>
                <li class="navitem">
                    <a class="navlink " href="#"><img src="assets/images/user1.png" alt=""></a>
                </li>
                <li class="navitem">
                    <a class="navlink" href="#"><?= $userdata["FirstName"] ?></a>
                </li>
                <li class="navitem">
                    <a class="navlink" href="<?= Config::BASE_URL.'?controller=Authentication&function=logout' ?>"><img src="assets/images/logout.png" alt=""></a>
                </li>
            </ul>
            <div class="menu-btn" data-bs-toggle="modal" data-bs-target="#navbartoggle" data-bs-dismiss="modal">
                <i class="fas fa-bars "></i>
            </div>
        </div>
    </header>
    <main>
        <input type="hidden" id="tab-name" value="<?php if(isset($_GET['parameter'])){ echo $_GET['parameter']; }?>">
        <section id="service-section">
            <div class="service-section">
                <div class="sidebar">
                    <div class="sidebar-admin">
                        <p class="welcomeadmin" id="welcomeadmin">Welcome, <br><b><?= $userdata["FirstName"].' '.$userdata['LastName'] ?></b> </p>
                        <a href="<?= Config::BASE_URL.'?controller=Authentication&function=logout' ?>">Logout</a>
                    </div>
                    <a href="#">Service Management</a>
                    <a href="#">Rple Management</a>
                    <a href="#" class="dropdown-btn ">Coupon Code Management<img class="drop-arrow"
                            src="assets/images/drop-arrow.png" alt=""></a>
                    <div class="dropdown-container">
                        <a href="#">Coupon Codes</a>
                        <a href="#">Usage History</a>
                    </div>
                    <a href="#">Escalation Management</a>

                    <a id="srequest" href="<?= Config::BASE_URL.'?controller=Admin&function=adminDashboard&parameter=srequest'?>" class="<?php if($_GET['parameter'] == "srequest"){ echo 'active1'; }?>">Service Requests</a>

                    <a href="#">Service Providers</a>

                    <a id="umanagement" href="<?= Config::BASE_URL.'?controller=Admin&function=adminDashboard&parameter=umanagement'?>" class="<?php if($_GET['parameter'] == "umanagement"){ echo 'active1'; }?>">User Management</a>

                    <a href="#" class="dropdown-btn">Finance Module<img class="drop-arrow"
                            src="assets/images/drop-arrow.png" alt=""></a>
                    <div class="dropdown-container">
                        <a href="#">All Transactions </a>
                        <a href="#">Generate Payment</a>
                        <a href="#">Customer Invoices</a>
                    </div>
                    <a href="#">Zip Code Management</a>
                    <a href="#">Rating Management</a>
                    <a href="#">Inquiry Management</a>
                    <a href="#">Newsletter Management</a>
                    <a href="#" class="dropdown-btn">Content Management<img class="drop-arrow"
                            src="assets/images/drop-arrow.png" alt=""></a>
                    <div class="dropdown-container">
                        <a href="#">Blog</a>
                        <a href="#">FAQs</a>
                    </div>
                </div>
                
                <?php
                    if(isset($_GET['parameter'])){
                        $parameter = $_GET['parameter'];
                        switch ($parameter) {
                            case "srequest":
                                include('View/Admin/Service-Requests.php');
                                break;
                            case "umanagement":
                                include('View/Admin/User-Management.php');
                                break;
                            default:
                                include('View/Admin/Service-Requests.php');
                          }
                    }else{
                        include('View/Admin/Service-Requests.php');
                    }
                ?>
                
            </div>
        </section>
    </main>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="assets/js/nav.js"></script>
    <script src="assets/js/admin_user.js"></script>
</body>

</html>