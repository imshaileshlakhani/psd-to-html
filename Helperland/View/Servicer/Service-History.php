<div class="sidebar-content">
    <div class="d-flex justify-content-between flex-wrap mb-2 ">
        <div class="title my-2">Payment Status
            <select name="payment-status" id="payment-status">
                <option value="All">All</option>
                <!-- <option value="Pending">Pending</option> -->
                <option value="Completed">Completed</option>
                <option value="Cancelled">Cancelled</option>
                <option value="Refund">Refund</option>
            </select>
        </div>
        <div class="title-btn my-2"><a href="#" id="Export">Export</a></div>
    </div>
    <div class="main " id="ups">
        <table class="table3" id="table">
            <tr class="th text-center">
                <th onclick="sortTable(0)">Service ID <img src="assets/images/sort.png"></th>
                <th onclick="sortTable(1)">Service date <img src="assets/images/sort.png"></th>
                <th onclick="sortTable(2)">Customer details <img src="assets/images/sort.png"></th>
                <th onclick="sortTable(3)">Status <img src="assets/images/sort.png" alt=""></th>
            </tr>
            <tbody class="tbody">
                
            </tbody>
        </table>
    </div>
    <div class="table-footer mt-3">
        <div class="drop-record">
            Show
            <select name="number" id="number">
                <option value="2">2</option>
                <option value="4">4</option>
                <option value="6">6</option>
                <option value="8">8</option>
            </select>
            entries Total Record: <span id="totalrequest">0</span>
        </div>
        <div class="pagination" id="pagination">

        </div>
    </div>
</div>