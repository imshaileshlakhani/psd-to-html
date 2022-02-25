<div class="sidebar-content">
    <div class="d-flex justify-content-between flex-wrap mb-2">
        <div class="title">Current Service Requests</div>
        <div class="title-btn my-2"><a href="<?= Config::BASE_URL.'?controller=Service&function=service'?>">Add New Service Request</a></div>
    </div>
    <div class="" id="ups">
        <table class="table1">
            
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