<!--service-details model -->
    <div class="modal fade" id="servicedetails" tabindex="-1" aria-labelledby="servicedetails"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#">
                        <div class="row">
                            <div class="col content-section">
                                <div class="row">
                                    <p class="model-title">Service Details</p>
                                    <p class="model-time"></p>
                                    <p>Duration: <span id="duration-model"></span></p>
                                </div>
                                <hr>
                                <div class="row">
                                    <p>Service Id: <span id="sid-model"></span></p>
                                    <p>Extras: <span id="extra-model"><span></p> 
                                    <p>Total Payment: <span class="model-price"></span></p>
                                </div>
                                <hr>
                                <div class="row">
                                    <p>Service Address: <span id="address-model"></span></p>
                                    <p>Billing Address: <span>Same as cleaning Address</span></p>
                                    <p>Phone: <span id="phone-model"></span></p>
                                    <p>Email: <span id="email-model"></span></p>
                                </div>
                                <hr>
                                <div class="row">
                                    <p>Comments</p>
                                    <p id="pet-model"></p>
                                </div>
                                <hr>
                                <div class="row model-button">
                                    <div class="col">
                                        <button class="cancel-button"><i class="fa fa-times"></i> Cancel</button>
                                        <button class="complete-button"><i class="fa fa-check"></i>
                                            Complete</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>