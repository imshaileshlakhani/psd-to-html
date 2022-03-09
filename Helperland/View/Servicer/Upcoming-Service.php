<div class="sidebar-content">
    <div class="main " id="ups">
        <table class="table2" id="table">
            <tr class="th text-center">
                <th onclick="sortTable(0)">Service ID <img src="assets/images/sort.png"></th>
                <th onclick="sortTable(1)">Service date <img src="assets/images/sort.png"></th>
                <th onclick="sortTable(2)">Customer details <img src="assets/images/sort.png"></th>
                <th onclick="sortTable(3)">Payment <img src="assets/images/sort.png"></th>
                <th>Distance</th>
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