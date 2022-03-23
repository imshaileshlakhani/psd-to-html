<div class="sidebar-content">
    <div class="main1" id="servicerequests">
        <div class="my-2">
            <div class="title my-2">Service Requests</div>
        </div>

        <div class="form">
            <form action="#" id="service-request-search">
                <div class="form-container">
                    <div class="input-container">
                        <input class="inputbox form-control" name="serviceid" placeholder="Service ID" id="sid" type="text" />
                    </div>
                    <div class="input-container">
                        <input class="inputbox form-control" name="postal" placeholder="Postal code" id="spostal" type="text"/>
                    </div>
                    <div class="input-container">
                        <input class="inputbox form-control" name="email" placeholder="Email" id="semail" type="email" />
                    </div>
                    <div class="input-container">
                        <select class="form-select inputbox" name="customer" id="customer" aria-label="Customer">
                            <option selected value="0">Select Customer</option>
                        </select>
                    </div>
                    <div class="input-container">
                        <select class="form-select inputbox" name="sp" id="servicer" aria-label="Service-Provider">
                            <option selected value="0">Select Service Provider</option>
                        </select>
                    </div>
                    <div class="input-container">
                        <select class="form-select inputbox" name="status" id="status" aria-label="Status">
                            <option selected value="0">Select Status</option>
                            <option value="-1">New</option>
                            <option value="1">Assign</option>
                            <option value="2">Pending</option>
                            <option value="3">Cancelled</option>
                            <option value="4">Completed</option>
                            <option value="5">Refunded</option>
                        </select>
                    </div>
                    <div class="input-container">
                        <input class="inputbox form-control" name="FromDate" id="sfdate" title="From date" type="date" />
                    </div>
                    <div class="input-container">
                        <input class="inputbox form-control" name="ToDate" id="stdate" title="To date" type="date"/>
                    </div>
                    <div class="submit text-center">
                        <button type="button" class="search" id="service-search">Search</button>
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