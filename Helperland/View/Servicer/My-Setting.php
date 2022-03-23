<div class="sidebar-content">
    <div class="" id="ups">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active px-5" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab" aria-controls="details" aria-selected="true">My Details</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link px-5" id="password-tab" data-bs-toggle="tab" data-bs-target="#password" type="button" role="tab" aria-controls="password" aria-selected="false">Change Password</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active p-4" id="details" role="tabpanel" aria-labelledby="details-tab">
                <div class="acount-status">Account Status: <span>Active</span></div>
                <div class="section-title mt-3">Basic details</div>
                <hr class="hr-line">
                <div class="cap1 mx-1 my-1 d-flex align-items-center justify-content-center">
                    <img src='assets/images/avatar-hat.png'>
                </div>
                <form action="#" id="servicer-form">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-7 pb-3">
                            <label for="firstname">First name</label>
                            <input class="form-control" name="firstname" id="sfname" value="<?= $userdata["FirstName"]?>" placeholder="First name" type="text"/>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-7 pb-3">
                            <label for="lastname">Last name</label>
                            <input class="form-control" name="lastname" id="slname" value="<?= $userdata["LastName"]?>" placeholder="Last name" type="text"  />
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-7 pb-3">
                            <label for="email">E-mail Address</label>
                            <input class="form-control" name="email" id="semail" value="<?= $userdata["Email"]?>" placeholder="demo@gmail.com" type="email" disabled />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-7 pb-3">
                            <label for="mobile">Mobile number</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">+49</div>
                                </div>
                                <input type="number" name="mobile" class="form-control" value="<?= $userdata["Mobile"]?>" id="cphone" placeholder="Mobile number">
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
                        <div class="col-lg-4 col-md-4 col-sm-7 pb-3">
                            <label for="nationality">Nationality</label>
                            <select class="form-select" aria-label="Nationality">
                                <option selected value="German">German</option>
                                <option value="Indian">Indian</option>
                                <option value="American">American</option>
                            </select>
                        </div>
                    </div>
                    <div class="gender">
                        <label for="Gender">Gender</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="Gender" id="Gender0" value="1">
                            <label class="form-check-label" for="Male">Male</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="Gender" id="Gender1" value="2">
                            <label class="form-check-label" for="Female">Female</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="Gender" id="Gender2" value="0" checked>
                            <label class="form-check-label" for="Rather">Rather not to say </label>
                        </div>
                    </div>
                    <div class="mt-4">
                        <label>Select Avatar</label>
                        <div class="avatar d-flex flex-wrap">
                            <div class="avtar-img">
                                <label>
                                    <input class="form-check-input" type="radio" name="avtar" id='avtar0' value="avatar-car">
                                    <div class="cap mx-1 mb-1 d-flex align-items-center justify-content-center">
                                        <img src="assets/images/avatar-car.png" alt="">
                                    </div>
                                </label>
                            </div>
                            <div class="avtar-img">
                                <label>
                                    <input class="form-check-input" type="radio" name="avtar" id='avtar1' value="avatar-female">
                                    <div class="cap mx-1 mb-1 d-flex align-items-center justify-content-center">
                                        <img src="assets/images/avatar-female.png" alt="">
                                    </div>
                                </label>
                            </div>
                            <div class="avtar-img">
                                <label>
                                    <input class="form-check-input" type="radio" name="avtar" id='avtar2' value="avatar-hat">
                                    <div class="cap mx-1 mb-1 d-flex align-items-center justify-content-center">
                                        <img src="assets/images/avatar-hat.png" alt="">
                                    </div>
                                </label>
                            </div>
                            <div class="avtar-img">
                                <label>
                                    <input class="form-check-input" type="radio" name="avtar" id='avtar3' value="avatar-iron">
                                    <div class="cap mx-1 mb-1 d-flex align-items-center justify-content-center">
                                        <img src="assets/images/avatar-iron.png" alt="">
                                    </div>
                                </label>
                            </div>
                            <div class="avtar-img">
                                <label>
                                    <input class="form-check-input" type="radio" name="avtar" id='avtar4' value="avatar-male">
                                    <div class="cap mx-1 mb-1 d-flex align-items-center justify-content-center">
                                        <img src="assets/images/avatar-male.png" alt="">
                                    </div>
                                </label>
                            </div>
                            <div class="avtar-img">
                                <label>
                                    <input class="form-check-input" type="radio" name="avtar" id='avtar5' value="avatar-ship">
                                    <div class="cap mx-1 mb-1 d-flex align-items-center justify-content-center">
                                        <img src="assets/images/avatar-ship.png" alt="">
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="section-title mt-4">My address</div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-7 pb-3">
                            <label for="Streetname">Street name</label>
                            <input class="form-control" name="Streetname" id="Streetname" placeholder="Koenigstrasse" type="text"  />
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-7 pb-3">
                            <label for="Housenumber">House number</label>
                            <input class="form-control" name="Housenumber" id="Housenumber" placeholder="22" type="text"  />
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-7 pb-3">
                            <label for="Postalcode">Postal code</label>
                            <input class="form-control" name="Postalcode" id="Postalcode" placeholder="99897" type="number"  />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-7 pb-3">
                            <label for="city">City</label>
                            <input class="form-control" name="city" id="city" placeholder="Ahemdabad" type="text"  />
                        </div>
                        <hr>
                    </div>
                    <div class="save-btn mt-3">
                        <a href="#" class="save" onClick="showLoader()" id="save-details">Save</a>
                    </div>
                </form>
            </div>
            <div class="tab-pane fade p-4" id="password" role="tabpanel" aria-labelledby="password-tab">
                <form action="">
                    <div class="col-lg-4 col-md-4 col-sm-7 pb-3">
                        <label for="oldpsw">Old Password</label>
                        <input class="form-control" name="oldpsw" id="oldpsw" placeholder="Current Password" type="password" autocomplete />
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-7 pb-3">
                        <label for="newpsw">New Password</label>
                        <input class="form-control" name="newpsw" id="newpsw" placeholder="Password" type="password" autocomplete />
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-7 pb-3">
                        <label for="cpsw">Confirm Password</label>
                        <input class="form-control" name="cpsw" id="cpsw" placeholder="Confirm Password" type="password" autocomplete />
                    </div>
                    <div class="save-btn mt-3">
                        <a href="#" class="save" onClick="showLoader()" id="change-psw">Save</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>