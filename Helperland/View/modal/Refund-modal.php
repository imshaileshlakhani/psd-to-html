<!-- Model For Refund Amount -->
<div class="modal fade" id="Refundmodal" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="staticBackdropLabel">Refund Amount</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="#">
                    <div class="row">
                        <div class="col-6">
                            <div class="row">
                                <div class="col-6">
                                    Paid Amount<br>
                                    <span id="paidAmount">0.00€</span>
                                </div>
                                <div class="col-6">
                                    Refunded Amount<br>
                                    <span id="refundedAmount">0.00€</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            In Balance Amount<br>
                            <span id="balanceAmount">0.00€</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Amount</label>
                                <div class="input-group" id="r-error">
                                    <input type="text" class="form-control" id="rpayment" aria-label="Text input with dropdown button" required>
                                    <select class="btn btn-outline-secondary" id="r-action">
                                        <option value="1">Percentage</option>
                                        <option value="2">Euro</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Calculate</label>
                                <input type="text" class="form-control" id="calculate" disabled>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="divtitle">Why you want to refund amount?</div>
                    <div class="row">
                        <div class="col">
                            <textarea name="" rows="3" id="refund-msg" class="form-control" placeholder="Why you want to refund amount?"></textarea>
                        </div>
                    </div>

                    <br>
                    <div class="divtitle">Call Center EMP notes</div>
                    <div class="row">
                        <div class="col">
                            <textarea name="" id="" rows="3" class="form-control" placeholder="Enter Notes"></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <button type="button" class="btn btn-modal form-control" id="refund">Refund</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Model -->