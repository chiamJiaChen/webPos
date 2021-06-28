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

        @forelse ($orderItems as $item)
        <tr>
            <td>
                {{ $item->product->name }}
            </td>
            <td>
                {{ $item->price }}
            </td>
            <td>
                <a href="#" class="btn btn-danger btn-sm mr-1 productUpdate" cartId="{{ $item->id }}"
                    cartStatus="minus">
                    -
                </a>

                {{ $item->quantity }}

                @php
                    $noOfItem += $item->quantity ; 
                @endphp

                <a href="#" class="btn btn-primary btn-sm ml-1 productUpdate" cartId="{{ $item->id }}"
                    cartStatus="plus">
                    +
                </a>
            </td>
            <td>
                {{ $item->price * $item->quantity }}
                
                @php
                    $subTotal += ($item->price * $item->quantity)  ;
                @endphp
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="4" class="text-center">
                No Item
            </td>
        </tr>
        @endforelse
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
                Service Charge
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
                {{ $subTotal +( $subTotal  * ( $tax / 100 ) )  }}
            </td>
        </tr>
        
    </table>

</div>