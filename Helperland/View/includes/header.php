<?php
    $base_url = "http://localhost/psd-to-html/Helperland/";
?>
    <header id="header">
        <div class="header">
            <div class="brand">
                <a class="navbarbrand" href="<?= $base_url.'?controller=Public&function=home'?>">
                    <img src="assets/images/nav-logo.png" alt="">
                </a>
            </div>
            <ul>
                <li class="navitem">
                    <a class="navlink navbtn" href="#">Book now</a>
                </li>
                <li class="navitem">
                    <a class="navlink" href="<?= $base_url.'?controller=Public&function=price'?>">Prices & services</a>
                </li>
                <li class="navitem">
                    <a class="navlink" href="#">Warranty</a>
                </li>
                <li class="navitem">
                    <a class="navlink" href="#">Blog</a>
                </li>
                <li class="navitem">
                    <a class="navlink" href="<?= $base_url.'?controller=Public&function=contact'?>">Contact</a>
                </li>
                <li class="navitem">
                    <a class="navlink navbtn" id="login" href="#" data-bs-toggle="modal" data-bs-target="#loginModal" data-bs-dismiss="modal">Login</a>
                </li>
                <li class="navitem">
                    <a class="navlink navbtn" href="#">Become a Helper</a>
                </li>
            </ul>
            <div class="menu-btn">
                <i class="fas fa-bars "></i>
            </div>
        </div>
    </header>