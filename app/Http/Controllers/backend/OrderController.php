<?php

namespace App\Http\Controllers\backend;
use App\models\order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    function GetOrder()
    {
        $data['orders']=order::where('state',2)->orderby('id','desc')->paginate(3);
        return view("backend.order.order",$data);
    }

    
    function GetDetailOrder($order_id)
    {
        $data['order']=order::find($order_id);
        return view("backend.order.detailorder",$data);
    }


    function GetProcessed()
    {
        $data['orders']=order::where('state',1)->orderby('updated_at','desc')->paginate(3);
        return view("backend.order.processed",$data);
    }

    function paid($order_id)
    {
        $order=order::find($order_id);
        $order->state=1;
        $order->save();

        return redirect('/admin/order/processed');
    }
}
