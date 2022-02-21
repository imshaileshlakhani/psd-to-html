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
                <form action="">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-7" style="padding-bottom: 15px;">
                            <label for="firstname">First name</label>
                            <input class="form-control" name="firstname" placeholder="First name" type="text" required autofocus />
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-7" style="padding-bottom: 15px;">
                            <label for="lastname">Last name</label>
                            <input class="form-control" name="lastname" placeholder="Last name" type="text" required />
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-7" style="padding-bottom: 15px;">
                            <label for="email">E-mail Address</label>
                            <input class="form-control" name="lastname" placeholder="demo@gmail.com" type="email" required />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-7" style="padding-bottom: 15px;">
                            <label for="mobile">Mobile number</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">+49</div>
                                </div>
                                <input type="number" class="form-control" id="cphone" placeholder="Mobile number">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-7 dateofbirth" style="padding-bottom: 15px;">
                            <label for="dateofbirth">Date of Birth</label>
                            <select name="date" id="date">
                                <option value="01">01</option>
                                <option value="02">02</option>
                            </select>
                            <select name="month" id="month">
                                <option value="March">March</option>
                                <option value="April">April</option>
                            </select>
                            <select name="year" id="year">
                                <option value="2000">2000</option>
                                <option value="2001">2001</option>
                            </select>
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
                        <a href="#" class="save">Save</a>
                    </div>
                </form>
            </div>
            <div class="tab-pane fade p-4" id="address" role="tabpanel" aria-labelledby="address-tab">
                <form action="">
                    <table class="table3">
                        <tr class="th">
                            <th>Addresses</th>
                            <th class="text-end">Action</th>
                        </tr>
                        <tr>
                            <td>
                                <div><b>Address:</b> test 123,37318 Kirchgandern</div>
                                <div><b>Phone number:</b> 8469116765</div>
                            </td>
                            <td class="action text-end">
                                <a href="#" class="Edit" data-bs-toggle="modal" data-bs-target="#addeditaddress" data-bs-dismiss="modal"><i class="far fa-edit"></i></a>
                                <a href="#" class="Delete"><i class="far fa-trash-alt"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div><b>Address:</b> test 123,37318 Kirchgandern</div>
                                <div><b>Phone number:</b> 8469116765</div>
                            </td>
                            <td class="action text-end">
                                <a href="#" class="Edit" data-bs-toggle="modal" data-bs-target="#addeditaddress" data-bs-dismiss="modal"><i class="far fa-edit"></i></a>
                                <a href="#" class="Delete"><i class="far fa-trash-alt"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div><b>Address:</b> test 123,37318 Kirchgandern</div>
                                <div><b>Phone number:</b> 8469116765</div>
                            </td>
                            <td class="action text-end">
                                <a href="#" class="Edit" data-bs-toggle="modal" data-bs-target="#addeditaddress" data-bs-dismiss="modal"><i class="far fa-edit"></i></a>
                                <a href="#" class="Delete"><i class="far fa-trash-alt"></i></a>
                            </td>
                        </tr>
                    </table>
                    <div class="save-btn mt-3">
                        <a href="#" class="save" data-bs-toggle="modal" data-bs-target="#addeditaddress" data-bs-dismiss="modal">Add New Address</a>
                    </div>
                </form>
            </div>
            <div class="tab-pane fade p-4" id="password" role="tabpanel" aria-labelledby="password-tab">
                <form action="">
                    <div class="col-lg-4 col-md-4 col-sm-7" style="padding-bottom: 15px;">
                        <label for="firstname">Old Password</label>
                        <input class="form-control" name="oldpsw" placeholder="Current Password" type="password" required />
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-7" style="padding-bottom: 15px;">
                        <label for="lastname">New Password</label>
                        <input class="form-control" name="newpsw" placeholder="Password" type="password" required />
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-7" style="padding-bottom: 15px;">
                        <label for="email">Confirm Password</label>
                        <input class="form-control" name="cpsw" placeholder="Confirm Password" type="password" required />
                    </div>
                    <div class="save-btn mt-3">
                        <a href="#" class="save">Save</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>