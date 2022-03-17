<!-- Model For Edit and Reschedule Service -->
<div class="modal fade" id="EditAndReschedule" tabindex="-1" aria-labelledby="EditAndReschedule" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Service Request</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="r-msg"></div>
                <form action="#" id="admin-edit-reschedule">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <span>Date</span>
                                <input type="date" id="admin-edit-date" min="<?= date('Y-m-d')?>" name="date" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <span>Time</span>
                                <select name="time" id="admin-edit-time" class="col form-control">
                                    <option selected value="8">8:00</option>
                                    <option value="8.5">8:30</option>
                                    <option value="9">9:00</option>
                                    <option value="9.5">9:30</option>
                                    <option value="10">10:00</option>
                                    <option value="10.5">10:30</option>
                                    <option value="11">11:00</option>
                                    <option value="11.5">11:30</option>
                                    <option value="12">12:00</option>
                                    <option value="12.5">12:30</option>
                                    <option value="13">13:00</option>
                                    <option value="13.5">13:30</option>
                                    <option value="14">14:00</option>
                                    <option value="14.5">14:30</option>
                                    <option value="15">15:00</option>
                                    <option value="15.5">15:30</option>
                                    <option value="16">16:00</option>
                                    <option value="16.5">16:30</option>
                                    <option value="17">17:00</option>
                                    <option value="17.5">17:30</option>
                                    <option value="18">18:00</option>
                                    <option value="18.5">18:30</option>
                                    <option value="19">19:00</option>
                                    <option value="19.5">19:30</option>
                                    <option value="20">20:00</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="lable_title">Service Address</div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <span>Street name</span>
                                <input type="text" id="admin-edit-Street" name="street" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <span>House number</span>
                                <input type="text" id="admin-edit-House" name="house" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <span>Postal Code</span>
                                <input type="text" id="admin-edit-Postal" name="postal" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <span>City</span>
                                <input type="text" id="admin-edit-City" name="city" class="form-control">
                                <!-- <select class="form-control" id="admin-edit-City">
                                        <option value="rajkot">Rajkot</option>
                                    </select> -->
                            </div>
                        </div>
                    </div>

                    <br>
                    <div class="lable_title">Invoice Address</div>
                    <div>Same as cleaning Address</div>
                    <!-- <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <span>Street name</span>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <span>House number</span>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <span>Postal Code</span>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <span>City</span>
                                    <select class="form-control">
                                        <option value="rajkot">Rajkot</option>
                                    </select>
                                </div>
                            </div>
                        </div> -->

                    <br>
                    <div class="lable_title">Why do you want to reschedule service request?</div>
                    <div class="row">
                        <div class="col">
                            <textarea rows="3" class="form-control" id="admin-edit-coment" name="comment" placeholder="Why do you want to reschedule service requests?"></textarea>
                        </div>
                    </div>

                    <br>
                    <div class="lable_title">Call Center EMP Notes</div>
                    <div class="row">
                        <div class="col">
                            <textarea rows="3" class="form-control" placeholder="Enter Notes"></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <button type="button" id="admin-edit-btn" class="btn btn-modal form-control">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>