<!-- service-reschedule model -->
    <div class="modal fade" id="servicereschedule" tabindex="-1" aria-labelledby="servicereschedule"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-bottom-0">
                    <div class="modal-title">
                        <h4>Reschedule Service Request</h4>
                    </div>
                    <button type="button" class="btn-close text-end" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#">
                        <div class="content-section">
                            <div class="row">
                                <label for="service-reschedule" class="form-label">Select New Date & Time</label>
                                <input type="date" id="rdate" min="<?= date('Y-m-d')?>" class="col form-control mx-2" >
                                <select name="time" id="rtime" class="col form-control mx-2">
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
                            <div class="row model-button">
                                <button type="button" class="btn update-button">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>