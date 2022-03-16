<div class="sidebar-content">
    <div class="main" id="usermanagement">
        <div class="d-flex justify-content-between my-2 flex-wrap">
            <div class="title my-2">User Management </div>
            <div class="add-user my-2"><a href="#">
                    <img src="assets/images/Add.png" alt=""> Add New User</a>
            </div>
        </div>

        <div class="form">
            <form action="#">
                <div class="form-container">
                    <div class="input-container">
                        <select class="form-select inputbox1" id="suname" aria-label="User name">
                            <option selected value="0">Select User Name</option>
                        </select>
                    </div>
                    <div class="input-container">
                        <select class="form-select inputbox1" id="sutype" aria-label="User Type">
                            <option selected value="0">Select User Type</option>
                            <option value="1">Customer</option>
                            <option value="2">Service Provider</option>
                            <option value="3">Admin</option>
                        </select>
                    </div>
                    <div class="input-container">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">+49</div>
                            </div>
                            <div>
                                <input type="text" class="inputbox1 form-control" id="usmobile" placeholder="Phone number">
                            </div>
                        </div>
                    </div>
                    <div class="input-container">
                        <input class="inputbox form-control" name="postal" placeholder="Postal code" id="spostal" type="text"/>
                    </div>
                    <div class="input-container">
                        <input class="inputbox form-control" name="email" placeholder="Email" id="semail" type="email" />
                    </div>
                    <div class="input-container">
                        <input class="inputbox form-control" name="FromDate" id="sfdate" title="From date" type="date" />
                    </div>
                    <div class="input-container">
                        <input class="inputbox form-control" name="ToDate" id="stdate" title="To date" type="date" />
                    </div>
                    <div class="submit text-center">
                        <button type="button" class="search" id="service-search">Search</button>
                        <button type="reset" class="clear">Clear</button>
                    </div>
                </div>
            </form>
        </div>

        <div id="ups">
            <table class="table2">
                <tr class="th text-center">
                    <th>User Name <img src="assets/images/C_dashboard/sort.png" alt=""></th>
                    <th>User Type</th>
                    <th>Date of Registration</th>
                    <th>Phone <img src="assets/images/C_dashboard/sort.png" alt=""></th>
                    <th>Postal Code <img src="assets/images/C_dashboard/sort.png" alt=""></th>
                    <th>Status <img src="assets/images/C_dashboard/sort.png" alt=""></th>
                    <th>Actions </th>
                </tr>
                <tbody class="tbody">
                    
                </tbody>
            </table>
        </div>
        <div class="table-footer px-5">
            <div class="drop-record my-3">
                Show
                <select name="number" id="number">
                    <option value="2">2</option>
                    <option value="4">4</option>
                    <option value="6">6</option>
                    <option value="8">8</option>
                </select>
                entries Total Record: <span id="totalrequest">0</span>
            </div>
            <div class="pagination my-3" id="pagination">
                
            </div>
        </div>
        <div class="copyright mt-3">
            ©2018 Helperland. All rights reserved.
        </div>
    </div>
</div>