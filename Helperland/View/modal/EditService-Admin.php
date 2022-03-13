<!-- Model For Edit and Reschedule Service -->
    <div class="modal fade" id="EditAndReschedule" tabindex="-1" aria-labelledby="EditAndReschedule" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Service Request</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <span>Date</span>
                                    <input type="date" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <span>Time</span>
                                    <input type="time" class="form-control">
                                </div>
                            </div>
                        </div>
                        <br><div class="lable_title">Service Address</div>
                        <div class="row">
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
                        </div>

                        <br><div class="lable_title">Invoice Address</div>
                        <div class="row">
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
                        </div>

                        <br><div class="lable_title">Why do you want to reschedule service request?</div>
                        <div class="row">
                            <div class="col">
                                <textarea rows="3" class="form-control" placeholder="Why do you want to reschedule service requests?"></textarea>
                            </div>
                        </div>

                        <br><div class="lable_title">Call Center EMP Notes</div>
                        <div class="row">
                            <div class="col">
                                <textarea rows="3" class="form-control" placeholder="Enter Notes"></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <button type="button" class="btn btn-modal form-control">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>