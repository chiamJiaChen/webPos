@extends('layouts.master')


@section('css')

<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap5.min.css" rel="stylesheet">

@endsection

@section('content')

<div class="container">
    <div class="text-center">
    <h1 class="mb-5 mt-5 ">Order History </h1>
    <a href="{{ route('index') }}" class="btn btn-sm btn-info">Product </a>
    </div>
    <table id="example" class="table table-striped table-responsive" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Reference No</th>
                <th>Transaction</th>
                <th>Total</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as  $order)
                <tr>
                    <td>{{ $loop->iteration  }}</td>
                    <td>{{ $order->reference_no}}</td>
                    <td>{{ $order->transaction->payment_method }}</td>
                    <td>{{ $order->total }}</td>
                    <td>{{ $order->status  }}</td>
                    <td><a id="{{ $order->id }}" class="btn btn-primary orderDetail btn-sm">View</a></td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>No</th>
                <th>Reference No</th>
                <th>Transaction</th>
                <th>Total</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </tfoot>
    </table>

</div>


<div class="modal fade " id="orderModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Order Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="orderContent"></div>
            </div>
        </div>
    </div>
</div>



@endsection


@section('script')


<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script>


<script>

    $(document).ready(function() {
        $('#example').DataTable();
    });

    $(document).on('click', "a.orderDetail", function() {

        var orderId = $(this).attr('id');

        $.ajax({
            url: "{{ route('order.detail') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}" ,
                orderId : orderId
            }
        }).done(function (response) {

        $('#orderModal').modal('show');
        $('#orderContent').html(response.html);

        }).fail(function () {
            $('#orderContent').html("Something went Wrong");
        });
    });


</script>

@endsection