 <!-- sidebar model -->
    <div class="modal fade sidebar-model" id="navbartoggle" tabindex="-1" aria-labelledby="navbartoggle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-center">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title" id="welcomeuser">Welcome, <br><b><?= $userdata["FirstName"] ?></b> </p>
                </div>
                <div class="modal-body">
                    <a href="<?= Config::BASE_URL.'?controller=Customer&function=customerDashboard'?>">Dashboard</a>
                    <a href="<?= Config::BASE_URL.'?controller=Customer&function=serviceHistory'?>">Service History</a>
                    <a href="#serviceschedule">Service Schedule</a>
                    <a href="<?= Config::BASE_URL.'?controller=Customer&function=favouriteSp'?>">Favourite Pros</a>
                    <a href="#invoice">Invoices</a>
                    <a href="<?= Config::BASE_URL.'?controller=Customer&function=setting' ?>">My Setting</a>
                    <a href="<?= Config::BASE_URL.'?controller=Authentication&function=logout' ?>">Logout</a>
                </div>
                <div class="modal-footer">
                    <a href="#">Book now</a>
                    <a href="#">Prices & Services</a>
                    <a href="#">Warranty</a>
                    <a href="#">Blog</a>
                    <a href="#">Contact</a>
                </div>
            </div>
        </div>
    </div>