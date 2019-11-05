<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\{product,category};

class IndexController extends Controller
{
    function GetIndex()
    {
        $data['prd_new']=product::orderBy('id','desc')->take(8)->get();
        $data['prd_nb']=product::where('featured',1)->take(4)->get();
        return view('frontend.index',$data);
    }

   function Getabout()
    {
        return view('frontend.about');
    }
    
    function GetContact()
    {
        return view("frontend.contact");
    }

    function GetPrdCate($slug_cate)
    {
        $data['products']=category::where('slug',$slug_cate)->first()->prd()->paginate(6);
        $data['categorys']=category::all();
        return view('frontend.product.shop',$data);
    }

    function GetFilter(Request $r)
    {
        $data['products']=product::whereBetween('price',[$r->start,$r->end])->paginate(6);
        $data['categorys']=category::all();
        return view('frontend.product.shop',$data);
    }
}
