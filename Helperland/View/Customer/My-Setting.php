<div class="sidebar-content">
    <div class="" id="ups">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active px-5" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab" aria-controls="details" aria-selected="true">My Details</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link px-5" id="address-tab" data-bs-toggle="tab" data-bs-target="#address" type="button" role="tab" aria-controls="address" aria-selected="false">My Addresses</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link px-5" id="password-tab" data-bs-toggle="tab" data-bs-target="#password" type="button" role="tab" aria-controls="password" aria-selected="false">Change Password</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active p-4" id="details" role="tabpanel" aria-labelledby="details-tab">
                <form action="#" id="setting-details-form">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-7 pb-3">
                            <label for="firstname">First name</label>
                            <input class="form-control" id="sfname" name="firstname" value="<?= $userdata["FirstName"]?>" placeholder="First name" type="text" required autofocus />
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-7 pb-3">
                            <label for="lastname">Last name</label>
                            <input class="form-control" id="slname" name="lastname" value="<?= $userdata["LastName"]?>" placeholder="Last name" type="text" required />
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-7 pb-3">
                            <label for="email">E-mail Address</label>
                            <input class="form-control" id="semail" name="email" value="<?= $userdata["Email"]?>" placeholder="demo@gmail.com" type="email" disabled />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-7 pb-3">
                            <label for="mobile">Mobile number</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">+49</div>
                                </div>
                                <input type="number" name="mobile" value="<?= $userdata["Mobile"]?>" class="form-control" id="cphone" placeholder="Mobile number">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-7 dateofbirth pb-3">
                            <label for="dateofbirth">Date of Birth</label>
                            <input class="form-control" type="date" name="dob" id="dob" value="<?php 
                                    if(!is_null($userdata["DateOfBirth"])){
                                        echo date('Y-m-d',strtotime($userdata["DateOfBirth"]));
                                    }
                                ?>" />
                        </div>
                    </div>
                    <hr>
                    <div class="language">
                        <label for="language" class="mb-1">My Preferred Language</label>
                        <select name="language" id="language">
                            <option value="english">English</option>
                            <option value="hindi">Hindi</option>
                        </select>
                    </div>
                    <div class="save-btn mt-3">
                        <a href="#" class="save" onClick="showLoader()" id="save-sdetails">Save</a>
                    </div>
                </form>
            </div>
            <div class="tab-pane fade p-4" id="address" role="tabpanel" aria-labelledby="address-tab">
                <table class="table3">
                    
                </table>
                <div class="save-btn mt-3">
                    <a href="#" class="save" id="add-new-address" data-bs-toggle="modal" data-bs-target="#addeditaddress" data-bs-dismiss="modal">Add New Address</a>
                </div>
            </div>
            <div class="tab-pane fade p-4" id="password" role="tabpanel" aria-labelledby="password-tab">
                <form action="#">
                    <div class="col-lg-4 col-md-4 col-sm-7 pb-3">
                        <label for="oldpsw">Old Password</label>
                        <input class="form-control" name="oldpsw" id="soldpsw" placeholder="Current Password" type="password" required autocomplete/>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-7 pb-3">
                        <label for="newpsw">New Password</label>
                        <input class="form-control" name="newpsw" id="snewpsw" placeholder="Password" type="password" required autocomplete/>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-7 pb-3">
                        <label for="cpsw">Confirm Password</label>
                        <input class="form-control" name="cpsw" id="scpsw" placeholder="Confirm Password" type="password" required autocomplete/>
                    </div>
                    <div class="save-btn my-3">
                        <a href="#" class="save" onClick="showLoader()" id="change-psw">Save</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>