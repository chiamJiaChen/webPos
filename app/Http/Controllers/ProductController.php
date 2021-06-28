<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();

        return view('index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }


    public function addToCart(Request $request)
    {

        $orderItem = OrderItem::where([['product_id', $request->product], ['status', '1']])->first();

        $addProduct = $this->addProductToCart($orderItem, $request->product);

        if (!$addProduct->original['status']) {

            return response()->json([
                'status' => true,
                'message' => 'order Updated',
                'html' => "Something went wrong"
            ]);
        }


        $orderItems = OrderItem::where('status', 1)->get();

        $orderView = view('ajax.orderItem', compact('orderItems'));

        return response()->json([
            'status' => true,
            'message' => 'order Updated',
            'html' => "$orderView"
        ]);
    }

    public function cart(Request $request)
    {
        $orderItems = OrderItem::where('status', 1)->get();

        $orderView = view('ajax.orderItem', compact('orderItems'));

        return response()->json([
            'status' => true,
            'html' => "$orderView"
        ]);
    
    }

    public function addProductToCart($orderItem, $productId)
    {

        if (empty($orderItem)) {

            $product = Product::find($productId);

            $orderItem = OrderItem::create([
                'product_id' => $product->id,
                'price' => $product->price,
                'quantity' =>  '1',
                'status' => '1',
            ]);
        } else {

            $product = Product::find($orderItem->product_id);

            $newQuantity =  $orderItem->quantity + 1;

            $orderItem->quantity =   $newQuantity;

            $orderItem->save();
        }

        return response()->json([
            'status' => true,
            'message' => 'Product Added'
        ]);
    }

    public function updateCart(Request $request)
    {

        if ($request->get('updateCartAction') == "plus") {

            $order = OrderItem::find($request->get('updateCartId'));

            $newQuantity =  $order->quantity  + 1;
            $order->quantity = $newQuantity;
            $order->save();

        } else if ($request->get('updateCartAction') ==  "minus") {

            $order = OrderItem::find($request->get('updateCartId'));

            if ($order->quantity > 1) {

                $newQuantity =  $order->quantity  - 1;
                $order->quantity = $newQuantity;
                $order->save();
            } else {

                $order->status = 0;
                $order->save();
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'action no allow'
            ]);
        }

        $orderItems = OrderItem::where('status', 1)->get();

        $orderView = view('ajax.orderItem', compact('orderItems'));

        return response()->json([
            'status' => true,
            'message' => 'order Updated',
            'html' => "$orderView"
        ]);
    }

    public function cancelCart() {

        $order = OrderItem::where('status', 1) ->update(['status' => 0 ]);

        $orderItems = OrderItem::where('status', 1)->get();

        $orderView = view('ajax.orderItem', compact('orderItems'));

        return response()->json([
            'status' => true,
            'message' => 'Order Completed',
            'html' => "$orderView"
        ]);
        // session::flash('success', 'Product Removed');
        
        // return redirect()->route('index');

    }

    public function checkOut() {

        $orderItems = OrderItem::where('status', 1)->count();

        $total = 0 ;

        if($orderItems == 0){

            return response()->json([
                'status' => true,
                'total' => $total ,
                'html' => 'No Product'
            ]);
        }
        else 
        {
            $subtotal  = 
            DB::table('order_items')->select( DB::raw('SUM(quantity * price) as total'))->where('status', 1)
            ->groupBy('status')
            ->first();
            
            
            $total = $subtotal->total + ( $subtotal->total * (6 / 100)) ;

            $checkout = view('ajax.checkOut', compact('total'));
            return response()->json([
                'status' => true,
                'total' => $total ,
                'html' => "$checkout"
            ]);
        }
    }

    public function checkoutSubmit(Request $request) {

        $reference = Order::latest()->pluck('reference_no')->first();

        $referenceNo = empty($reference) == true ? 100000 : $reference + 1  ;

        $order = Order::create([
            'reference_no' => $referenceNo,
            'tax' => 6,
            'service_charge' => 0 ,
            'total' => $request->get('total') ,
            'status' => 'paid'  
        ]);


        $transaction = Transaction:: create([
            'order_id' =>  $order->id ,
            'payment_method' => $request->payment,
            'paid_amount' => $request->get('total')  ,
            'status' => 'paid' 
        ]);
        
        $updateOrder = OrderItem::where('status', 1) ->update(['status' => 2, 'order_id' => $order->id  ]);
        
        $orderItems = OrderItem::where('status', 1)->get();

        $orderView = view('ajax.orderItem', compact('orderItems'));

        return response()->json([
            'status' => true,
            'message' => 'Order Completed',
            'html' => "$orderView"
        ]);

    }

}
