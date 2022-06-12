<?php

namespace App\Http\Controllers;

use App\Events\Order\OrderToUserMakeOrderEvent;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{

    public  function  getOrder(){

        $order=Order::get();
        return response($order,'200');
    }

    public  function  store(Request $request){
       $data=$request->all();
       $order=new Order();
        $save=[
            'user_id'=>$data['user_id'],
             'product_id' => $data['productId'],
            'amount' => $data['amount'],
            'order_status' =>0
        ];
       $order->fill($save);
       $order->save();
       event(new OrderToUserMakeOrderEvent($request->all()));
       return response($data,'200');
    }

    /**
     * @param int $id
     * @return bool|void
     * @throws \Throwable
     */

    public function delete(int $id){
        $order=Order::find($id);
        throw_if(!$order->delete($id),'RuntimeException', 'Order has not been deleted.', 500);
           return true;
    }
}
