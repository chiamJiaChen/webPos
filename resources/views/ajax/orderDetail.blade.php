<div class="row mb-3">
    <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">Reference No</label>
    <div class="col-sm-10">
      {{ $order->reference_no }}
    </div>
  </div>
  <div class="row mb-3">
    <label for="colFormLabel" class="col-sm-2 col-form-label">Tax (%)</label>
    <div class="col-sm-10">
        {{ $order->tax }}
    </div>
  </div>
  <div class="row mb-3">
    <label for="colFormLabel" class="col-sm-2 col-form-label">Service Charge</label>
    <div class="col-sm-10">
        {{ $order->service_charge }}
    </div>
  </div>
  <div class="row mb-3">
    <label for="colFormLabel" class="col-sm-2 col-form-label">Total</label>
    <div class="col-sm-10">
        {{ $order->total }}
    </div>
  </div>
  <div class="row mb-3">
    <label for="colFormLabel" class="col-sm-2 col-form-label">Status</label>
    <div class="col-sm-10">
        {{ $order->status }}
    </div>
  </div>
</div>

<hr>

<label for="colFormLabel" class="col-sm-2 col-form-label">Product</label>


<div class="table-responsive">

    <table class="table table-striped table-bordered">
        <thead>
            <td>Product</td>
            <td>Price (RM)</td>
            <td>Quantity</td>
            <td>Cost (RM)</td>
        </thead>

        @php
            $subTotal = 0 ;
            $noOfItem = 0;
            $tax = 6;
            $serviceCharged = 0;
        @endphp

        @foreach($order->products as $item)
        <tr>
            <td>
                {{ $item->product->name }}
            </td>
            <td>
                {{ $item->product->price }}
            </td>
            <td>
         

                {{ $item->quantity }}

                @php
                    $noOfItem += $item->quantity ; 
                @endphp

            </td>
            <td>
                {{ $item->price * $item->quantity }}
                
                @php
                    $subTotal += ($item->price * $item->quantity)  ;
                @endphp
            </td>
        </tr>
        
        @endforeach
        <tr>
            <td colspan="3">
                Subtotal
            </td>
            <td>
                {{ $subTotal   }}
            </td>
        </tr>
        <tr>
            <td colspan="3">
                No. of Items
            </td>
            <td>
                {{ $noOfItem   }}
            </td>
        </tr>
        <tr>
            <td colspan="3">
               Tax (%)
            </td>
            <td>
                {{ $tax    }}
            </td>
        </tr>

        <tr>
            <td colspan="3">
                Service Charged
            </td>
            <td>
                - 
            </td>
        </tr>
        <tr>
            <td colspan="3">
                Total
            </td>
            <td>
                {{ $order->total }}
            </td>
        </tr>
        
    </table>

</div>

@if($order->status == "paid")

    <a href="{{ route('order.refund', $order->id ) }}" class="btn btn-sm btn-warning">Refund</a>

@endif