<div class="sidebar-content">
    <div class="d-flex flex-wrap mb-2 ">
        <div class="title">Service area
            <select name="km" id="km">
                <option value="10">10 km</option>
                <option value="20">20 km</option>
                <option value="30">30 km</option>
                <option value="40">40 km</option>
            </select>
        </div>
        <div class="Check-btn form-check my-2 mx-3">
            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
            <label class="form-check-label" for="flexCheckDefault">
                Include Pet at Home
            </label>
        </div>
    </div>
    <div class="main " id="ups">
        <table class="table1" id="table">
            <tr class="th text-center">
                <th onclick="sortTable(0)">Service ID <img src="assets/images/sort.png"></th>
                <th onclick="sortTable(1)">Service date <img src="assets/images/sort.png"></th>
                <th onclick="sortTable(2)">Customer details <img src="assets/images/sort.png"></th>
                <th onclick="sortTable(3)">Payment <img src="assets/images/sort.png"></th>
                <th>Time conflict</th>
                <th>Actions</th>
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