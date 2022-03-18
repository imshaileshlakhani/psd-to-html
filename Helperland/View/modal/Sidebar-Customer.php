 <!-- sidebar model -->
    <div class="modal fade sidebar-model" id="navbartoggle" tabindex="-1" aria-labelledby="navbartoggle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-center">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title" id="welcomeuser">Welcome, <br><b><?= $userdata["FirstName"] ?></b> </p>
                </div>
                <div class="modal-body">
                    <a href="<?= Config::BASE_URL.'?controller=Customer&function=customerDashboard&parameter=Dashboard'?>">Dashboard</a>
                    <a href="<?= Config::BASE_URL.'?controller=Customer&function=customerDashboard&parameter=History'?>">Service History</a>
                    <a href="#serviceschedule">Service Schedule</a>
                    <a href="<?= Config::BASE_URL.'?controller=Customer&function=customerDashboard&parameter=Favourite'?>">Favourite Pros</a>
                    <a href="#invoice">Invoices</a>
                    <a href="<?= Config::BASE_URL.'?controller=Customer&function=customerDashboard&parameter=setting' ?>">My Setting</a>
                    <a href="#" class="logout-btn">Logout</a>
                </div>
                <div class="modal-footer">
                    <a href="<?= Config::BASE_URL . '?controller=Service&function=service' ?>">Book now</a>
                    <a href="<?= Config::BASE_URL.'?controller=Public&function=price'?>">Prices & Services</a>
                    <a href="#">Warranty</a>
                    <a href="#">Blog</a>
                    <a href="<?= Config::BASE_URL.'?controller=Public&function=contact'?>">Contact</a>
                </div>
            </div>
        </div>
    </div>