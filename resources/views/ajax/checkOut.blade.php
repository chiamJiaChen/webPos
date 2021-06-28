@if ( $total > 0 )


<form id="checkoutForm">
    <div class="row mb-3">
        <label for="inputEmail3" class="col-sm-2 col-form-label">Total Paid amount</label>
        <div class="col-sm-10">
            <input type="number" min="{{ $total }}" class="form-control" id="totalPaidAmount">
        </div>
    </div>
    <div class="row mb-3">
        <label for="inputEmail3" class="col-sm-2 col-form-label">Total </label>
        <div class="col-sm-10">
            <input type="number" class="form-control" id="checkOutTotal" disabled value="{{ $total }}">
        </div>
    </div>
    <div class="row mb-3">
        <label for="inputEmail3" class="col-sm-2 col-form-label">Payment </label>
        <div class="col-sm-10">
            <select class="form-select" id="checkoutpayment">
                <option value="cash">Cash</option>
                <option value="credit_card">Credit Card</option>
            </select>
        </div>
    </div>

    <div class="row mb-3">
        <label for="inputEmail3" class="col-sm-2 col-form-label">Change </label>
        <div class="col-sm-10">
            <input type="number" class="form-control" id="checkoutRemain" disabled value="0">
        </div>
    </div>
    <div class="text-center">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary checkoutSubmit">Submit</button>
    </div>
</form>


@else

<div class="text-center">
    <h6>No Porduct</h6>
</div>

@endif