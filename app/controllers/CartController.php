<?php

namespace App\Controllers;


use App\classes\Cart;
use App\classes\CSRFToken;
use App\classes\Mail;
use App\classes\Request;
use App\classes\Session;
use App\models\Order;
use App\models\Payment;
use App\models\Product;
use Stripe\Charge;
use Stripe\Customer;

class CartController extends BaseController
{

    /**
     * Show cart
     */
    public function show()
    {
        return view('cart');
    }

    /**
     * Add item to cart
     * @throws \Exception
     */
    public function addItem()
    {
        if(Request::has('post')){
            $request = Request::get('post');
            if(CSRFToken::verifyCRFToken($request->token, false)){
                if(!$request->product_id){
                    throw new \Exception('Malicious activity detected');
                }

                Cart::add($request);

                echo json_encode(['success' => 'Product added to cart successfully.']);

                exit;
            }
        }

    }


    /**
     * Check items in cart
     */
    public function getCartItems()
    {
        try{
            $result = array();
            $cartTotal = 0;

            if(!Session::has('user_cart') || count(Session::get('user_cart')) < 1){
                echo json_encode(['fail' => "Cart is empty"]);
                exit;
            }

            $index = 0;

           // Session::remove('user_cart');

            foreach ($_SESSION['user_cart'] as $cart_items){
                $productId = $cart_items['product_id'];
                $quantity = $cart_items['quantity'];
                $item = Product::where('id', $productId)->first();

                if(!$item){continue;}

                $totalPrice = $item->price * $quantity;
                $cartTotal = $totalPrice + $cartTotal;

                $totalPrice = number_format($totalPrice, 2);

                array_push($result, [
                    'id' => $item->id,
                    'name' => $item->name,
                    'image' => $item->image_path,
                    'description' => $item->description,
                    'price' => number_format($item->price, 2),
                    'total' => $totalPrice,
                    'quantity' => $quantity,
                    'stock' => $item->quantity,
                    'index' => $index
                ]);

                $index++;

            }

            $cartTotal = number_format($cartTotal, 2);

            Session::add('cartTotal', $cartTotal);

            echo json_encode([
                'items' => $result,
                'cartTotal' => $cartTotal,
                'authenticated' =>isAuthenticated(),
                'amountInCents' => convertMoneyToCents($cartTotal)
            ]);
            exit;
        }catch (\Exception $ex){

            echo $ex->getMessage().' '.$ex->getLine();
            // Log this in database or email admin
        }
    }


    public function updateQuantity()
    {
        if(Request::has('post')){
            $request = Request::get('post');
            if(!$request->product_id){
                throw new \Exception('Malicious activity detected');
            }
            $index = 0;
            $quantity = "";

            foreach($_SESSION['user_cart'] as $cart_items){
                $index++;
                foreach($cart_items as $key => $value){
                    if($key == 'product_id' && $value == $request->product_id){
                        switch($request->operator){
                            case '+':
                                $quantity = $cart_items['quantity'] + 1;
                                break;
                            case '-':
                                $quantity = $cart_items['quantity'] - 1;
                                if($quantity < 1){
                                    $quantity = 1;
                                }
                                break;
                        }

                        array_splice($_SESSION['user_cart'], $index - 1, 1, array(
                            [
                                'product_id' => $request->product_id,
                                'quantity' => $quantity
                            ]
                        ));
                    }
                }
            }
        }
    }

    public function removeItem()
    {
        if(Request::has('post')){
            $request = Request::get('post');
            if($request->item_index === ''){
                throw new \Exception('Malicious activity');
            }

            //Remove item
            Cart::removeItem($request->item_index);
            echo json_encode(['success' => 'Product removed from cart!']);
            exit;

        }
    }

    public function checkout()
    {
        if(Request::has('post')){

            $result['product'] = array();
            $result['order_no'] = array();
            $result['total'] = array();
            $request = Request::get('post');
            $token = $request->stripeToken;
            $email = $request->stripeEmail;

            try{

                $customer = Customer::create([
                    'email' => $email,
                    'source' => $token
                ]);


                $amount = convertMoneyToCents(Session::get('cartTotal'));
                $charge = Charge::create([
                    'customer' => $customer->id,
                    'amount' => $amount,
                    'description' => user()->fullname. ' - cart purchase',
                    'currency' => 'usd'
                ]);

                $order_id = strtoupper(uniqid());


                foreach ($_SESSION['user_cart'] as $cart_items){
                    $productId = $cart_items['product_id'];
                    $quantity = $cart_items['quantity'];
                    $item = Product::where('id', $productId)->first();

                    if(!$item){continue;}

                    $totalPrice = $item->price * $quantity;
                    $totalPrice = number_format($totalPrice, 2);

                    //Store info
                    Order::create([
                        'user_id' => user()->id,
                        'product_id' => $productId,
                        'unit_price' => $item->price,
                        'status' => 'Pending',
                        'quantity' => $quantity,
                        'total' => $totalPrice,
                        'order_no' => $order_id
                    ]);

                    $item->quantity -= $quantity;
                    $item->save();

                    array_push($result['product'], [

                        'name' => $item->name,
                        'price' => number_format($item->price, 2),
                        'total' => $totalPrice,
                        'quantity' => $quantity

                    ]);

                }

                Payment::create([
                    'user_id' => user()->id,
                    'amount' => $charge->amount,
                    'status' => $charge->status,
                    'order_no' => $order_id
                ]);

                $result['order_no'] = $order_id;
                $result['total'] = Session::get('cartTotal');

                $data = [
                    'to' => user()->email,
                    'subject' => 'Order confirmation',
                    'view' => 'purchase',
                    'name' => user()->fullname,
                    'body' => $result
                ];

                (new Mail())->send($data);



            }catch (\Exception $ex){
                echo $ex->getMessage();
            }

            Cart::clear();
            echo json_encode([
                'success' => 'Thank you for your payment. We are now processing your order.'
            ]);
        }

    }
}