    <header id="header">
        <div class="header">
            <div class="brand">
                <a class="navbarbrand" href="<?= $base_url.'?controller=Public&function=home'?>">
                    <img src="assets/images/nav-logo.png" alt="">
                </a>
            </div>
            <ul>
                <li class="navitem header2">
                    <a class="navlink navbtn" href="#">Book now</a>
                </li>
                <li class="navitem header2">
                    <a class="navlink" href="<?= $base_url.'?controller=Public&function=price'?>">Prices & services</a>
                </li>
                <li class="navitem header2">
                    <a class="navlink" href="#">Warranty</a>
                </li>
                <li class="navitem">
                    <a class="navlink" href="#">Blog</a>
                </li>

                <li class="navitem header2">
                    <a class="navlink" href="<?= $base_url.'?controller=Public&function=contact'?>">Contact</a>
                </li>

                <?php if (isset($userdata)) { ?>
                    <li class="navitem">
                        <div class="vr"></div>
                        <a class="navlink mx-3" href="#"><img src="assets/images/icon-notification.png" alt=""></a>
                        <div class="vr"></div>
                    </li>
                    <li class="navitem drop">
                        <div class="dropdown">
                            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                                <a class="navlink " href="#"><img src="assets/images/user1.png" alt=""></a>
                            </button>
                            <div class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdownMenuButton">
                                <div class="dropdown-item">
                                    <div>Welcome,</div>
                                    <div><b><?= $userdata["FirstName"] ?></b></div>
                                </div>
                                <hr class="my-1">
                                <a class="dropdown-item" href="
                                    <?php
                                        if ($userdata["UserTypeId"] == Config::USER_TYPE[0]) {
                                            echo "#";
                                        } else if ($userdata["UserTypeId"] == Config::USER_TYPE[1]) {
                                            echo "#";
                                        } else {
                                            echo "#";
                                        }
                                    ?> ">
                                    My Dashboard
                                </a>
                                <a class="dropdown-item" href="
                                    <?php
                                        if ($userdata["UserTypeId"] == Config::USER_TYPE[0]) {
                                            echo "#";
                                        } else if ($userdata["UserTypeId"] == Config::USER_TYPE[1]) {
                                            echo "#";
                                        } else {
                                            echo "#";
                                        }
                                    ?> ">
                                    My Setting
                                </a>
                                <a class="dropdown-item" href="<?= $base_url.'?controller=Authentication&function=logout' ?>">
                                    Logout
                                </a>
                            </div>
                        </div>
                    </li>
                    <?php
                        } else {
                    ?>
                    <li class="navitem">
                        <a class="navlink navbtn" href="#" data-bs-toggle="modal" data-bs-target="#loginModal" data-bs-dismiss="modal">Login</a>
                    </li>
                    <li class="navitem">
                        <a class="navlink navbtn" href="<?= $base_url.'?controller=Public&function=sp_signup' ?>">Become a Helper</a>
                    </li>
                <?php
                } ?>
            </ul>
            <div class="menu-btn">
                <i class="fas fa-bars "></i>
            </div>
        </div>
    </header>