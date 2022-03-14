<div class="sidebar-content">
    <div class="main1" id="servicerequests">
        <div class="my-2">
            <div class="title my-2">Service Requests</div>
        </div>

        <div class="form">
            <form action="#">
                <div class="form-container">
                    <div class="input-container">
                        <input class="inputbox" name="serviceid" placeholder="Service ID" type="text" required autofocus />
                    </div>
                    <div class="input-container">
                        <select class="form-select inputbox" aria-label="Customer">
                            <option selected>Customer</option>
                            <option value="david bought">David Bough</option>
                        </select>
                    </div>
                    <div class="input-container">
                        <select class="form-select inputbox" aria-label="Service Provider">
                            <option selected>Service Provider</option>
                            <option value="lyum watson">Lyum Watson</option>
                        </select>
                    </div>
                    <div class="input-container">
                        <select class="form-select inputbox" aria-label="Status">
                            <option selected>Status</option>
                            <option value="1">New</option>
                            <option value="2">Pending</option>
                            <option value="3">Cancelled</option>
                            <option value="4">Completed</option>
                        </select>
                    </div>
                    <div class="input-container">
                        <input class="inputbox" name="FromDate" type="date" required autofocus />
                    </div>
                    <div class="input-container">
                        <input class="inputbox" name="ToDate" type="date" required autofocus />
                    </div>
                    <div class="submit text-center">
                        <button type="button" class="search">Search</button>
                        <button type="reset" class="clear">Clear</button>
                    </div>
                </div>
            </form>
        </div>

        <div id="ups">
            <table class="table1" id="table">
                <tr class="th text-center">
                    <th>Service ID</th>
                    <th>Service date</th>
                    <th>Customer details</th>
                    <th>Service Provider</th>
                    <th>Payment</th>
                    <th>Status</th>
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
                entries
            </div>
            <div class="pagination my-3" id="pagination">
                
            </div>
        </div>
        <div class="copyright mt-3">
            ©2018 Helperland. All rights reserved.
        </div>
    </div>
</div>