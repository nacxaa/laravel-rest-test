<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Order;
use App\Product;
use GuzzleHttp\Client;
use DB;

class OrderController extends Controller
{
    private $minOrderSum = 10;
    private $maxOrdersPerMinute = 3;

    public function getGeoIP($ip = '') {
        // http://ip-api.com/docs/api:json
        $client = new Client();
        if(!$ip) $ip = $_SERVER['REMOTE_ADDR'];
        $res = $client->request('GET', 'http://ip-api.com/json/'.$ip, [
            'form_params' => [
                'client_id' => 'test_id',
                'secret' => 'test_secret',
            ]
        ]);
        if($res->getStatusCode() == 200) {
            $result = json_decode( $res->getBody());
            //print_r($result);
            if($result->status=='success') {
                return $result->countryCode;
            }        
        }
        return 'US';
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sent' => 'required'
        ]);


        $validator->after(function($validator) use ($request) {
            $totalPrice = 0;
            if(!isset($request->all()['items']) || !is_array($request->all()['items']) || count($request->all()['items']) < 1) {
                $validator->errors()->add('items', 'Order cannot be empty');
            } else {
                foreach($request->all()['items'] AS $pr) {
                    $product = Product::where('id', $pr['productId'])->get()->toArray();
                    if(count($product) != 1) {
                        $validator->errors()->add('productId', 'Product with ID '.$pr['productId'].' does not exist');
                        break;
                    }
                    $totalPrice += $pr['quantity'] * (0+$product[0]['price']);
                }
    //            print_r($totalPrice);
                if ($totalPrice < $this->minOrderSum) {
                    $validator->errors()->add('totalPrice', 'Ordered products total price cannot be less then '.$this->minOrderSum);
                }

                $orders_count = Order::whereRaw('created_at >= DATE_ADD("'.now().'", INTERVAL -1 MINUTE)')->count();
                if($orders_count >= $this->maxOrdersPerMinute) {
                    $validator->errors()->add('order', 'You submit orders too fast');
                }

            }
        });

        $validator->validate();
//print_r($request->all());

        $ip = '';
        if(isset($request->all()['ip'])) $ip = $request->all()['ip'];
//        echo $this->getGeoIP($ip);

        $order = Order::create([
            'status' => 'new',
            'country' => $this->getGeoIP($ip),
        ]);
        foreach($request->all()['items'] AS $pr) {
            $order->products()->attach($pr['productId'], ['quantity'=>$pr['quantity']]);
        }

//        Order::create($request->all());

        return ''; //$order;
    }
}
