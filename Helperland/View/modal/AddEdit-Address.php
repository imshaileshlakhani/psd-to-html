<!-- add-edit-address model -->
    <div class="modal fade" id="addeditaddress" tabindex="-1" aria-labelledby="addeditaddress" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-bottom-0">
                    <h4 class="modal-title">Add Address</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#" id="add-edit-saddress-form">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Street">Street name</label>
                                    <input type="text" id="sastreet" class="form-control" name="sstreet" placeholder="Koenigstrasse">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="House">House number</label>
                                    <input type="text" id="sahouse" class="form-control" name="shouse" placeholder="122">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Postal">Postal Code</label>
                                    <input type="text" id="sapostal" class="form-control" name="spostal" placeholder="99897">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <span></span>
                                    <label for="City">City</label>
                                    <input type="text" id="sacity" class="form-control" name="scity" placeholder="Tambach-Dietharz">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="mobile">Phone number</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">+49</div>
                                    </div>
                                        <input type="number" id="samobile" name="smobile" class="form-control"
                                        placeholder="9955648797">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <button type="button" onClick="showLoader()" id="add-edit-saddress" class="btn btn-modal form-control">Add</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>