@extends('layouts.master')

@section('content')

<div class="container-fluid">

    <div class="row">
        <div class="col-lg-6 col-12">

            <div class="container">
                <h1 class="text-center mt-5 mb-5">POS Cashier</h1>
                <div class="row">

                    <div class="col-12">

                        <div id="cart"></div>

                        <div class="row mt-5">
                            <div class="col-12 col-lg-6  mx-auto text-center">
                                <a href="#" class="btn btn-danger cartCancel">Cancel</a>
                                <a href="#" class="btn btn-success checkOut">Check Out</a>
                                <a href="{{ route('order.history') }}" class="btn btn-info">Order History</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="modal fade " id="checkOutModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Check Out</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="checkoutContent"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-lg-6 col-12">
            <h1 class="text-center mt-5 mb-5">Products</h1>
            <div class="row">
                @foreach($products as $product)
                <div class="col-lg-6 col-6">
                    <a class="addCart" productId="{{ $product->id }}">
                        <div class="text-center">
                            <img src={{ asset($product->image) }} class="img-fluid mx-auto">
                        </div>
                        <p class="text-center">{{ $product->name }}</p>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection


@section('script')

<script>
    $(document).ready(function() {

        $.ajax({
            url: "{{ route('cart') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}"
            }
        }).done(function (response) {

            if (response.status) {
                $('#cart').html(response.html);            
            }

        }).fail(function () {
            $('#cart').html("Something went Wrong");
        });

       
    });

    $(document).on('click', "a.addCart", function() {

        let product = $(this).attr("productId");   

        $.ajax({
            url: "{{ route('addToCart') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}" ,
                product : product  
            }
        }).done(function (response) {

            if (response.status) {
                $('#cart').html(response.html);            
            }

        }).fail(function () {
            $('#cart').html("Something went Wrong");
        });
    });


    $(document).on('click', "a.productUpdate", function() {

        let updateCartAction = $(this).attr("cartStatus");   
        let updateCartId = $(this).attr("cartId");   

         $.ajax({
            url: "{{ route('cart.update') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}" ,
                updateCartAction : updateCartAction ,
                updateCartId : updateCartId 
            }
        }).done(function (response) {

            if (response.status) {
                $('#cart').html(response.html);            
            }

        }).fail(function () {
            $('#cart').html("Something went Wrong");
        });
    });

    $(document).on('click', "a.checkOut", function() {

        $.ajax({
            url: "{{ route('cart.checkout') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}" 
            }
        }).done(function (response) {

           $('#checkOutModal').modal('show');
           $('#checkoutContent').html(response.html);

        }).fail(function () {
            $('#checkoutContent').html("Something went Wrong");
        });
    });

    $(document).on('change', "input#totalPaidAmount", function() {

        var totalPaidAmount = $(this).val();
        var total = $("input#checkOutTotal").val();

        var remain =  totalPaidAmount -  total ;

        $("input#checkoutRemain").val(remain);

    });

    $(document).on('click', ".checkoutSubmit", function(e) {

        var total = $('#checkOutTotal').val();
        var payment = $('#checkoutpayment').val();

        $.ajax({
            url: "{{ route('checkout') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}" ,
                total :  total ,
                payment : payment
            }
        }).done(function (response) {

            $('#checkOutModal').modal('hide');
            $('#cart').html(response.html);

        }).fail(function () {
            $('#cart').html("Something went wrong");
        });


    });

    $(document).on('click', ".cartCancel", function(e) {

        $.ajax({
            url: "{{ route('cart.cancel') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}" 
            }
        }).done(function (response) {

            $('#cart').html(response.html);

        }).fail(function () {
            $('#cart').html("Something went wrong");
        });


    });





</script>

@endsection