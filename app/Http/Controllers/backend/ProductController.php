<?php

namespace App\Http\Controllers\backend;
use App\Http\Requests\{AddProductRequest,EditProductRequest};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\{product,category};
use Illuminate\Support\Str;

class ProductController extends Controller
{
    function GetAddProduct()
    {
        $data['categorys'] = category::all()->toArray();
        return view("backend.product.addproduct",$data);
    }

    function PostAddProduct(AddProductRequest $r)
    {
        //$slug = Str::slug('Laravel 5 Framework', '-');

        $prd = new product;
        $prd->code=$r->code;
        $prd->name=$r->name;
        $prd->slug=Str::slug($r->name, '-');
        $prd->price=$r->price;
        $prd->featured=$r->featured;
        $prd->state=$r->state;
        $prd->info=$r->info;
        $prd->describe=$r->describe;
        if ($r->hasFile('img')) {
            $file=$r->img;
            // tên đặt vào database dùng slug
            $file_name=Str::slug($r->name, '-').'.'.$file->getClientOriginalExtension();
            $file->move('backend/img',$file_name);
            $prd->img=$file_name;
        }
        else
        {
            $prd->img='no-img.jpg';
        }
        
        $prd->category_id=$r->category;
        $prd->save();

        return redirect('admin/product')->with('thongbao','Đã thêm sản phẩm thành công');

    }

    function GetEditProduct($prd_id)
    {
        $data['prd']=product::find($prd_id);
        $data['categorys']=category::all()->toArray();
        return view("backend.product.editproduct",$data);
    }

    function PostEditProduct(EditProductRequest $r,$prd_id)
    {
        $prd = product::find($prd_id);
        $prd->code=$r->code;
        $prd->name=$r->name;
        $prd->slug=Str::slug($r->name, '-');
        $prd->price=$r->price;
        $prd->featured=$r->featured;
        $prd->state=$r->state;
        $prd->info=$r->info;
        $prd->describe=$r->describe;
        if ($r->hasFile('img')) 
        {
            if($prd->img!='no-img.jpg')
            {
                unlink('backend/img/'.$prd->img);
            }
            
            $file=$r->img;
            // tên đặt vào database dùng slug
            $file_name=Str::slug($r->name, '-').'.'.$file->getClientOriginalExtension();
            $file->move('backend/img',$file_name);
            $prd->img=$file_name;
        }
        
        $prd->category_id=$r->category;
        $prd->save();

        return redirect()->back()->with('thongbao','Đã sửa thành công');

    }


   function GetListProduct()
    {
        $data['products'] = product::paginate(4);
        return view("backend.product.listproduct",$data);
    }

    function DelProduct($prd_id)
    {
        product::destroy($prd_id);
        return redirect('admin/product')->with('thongbao','Bạn đã xóa thành công');
    }
}
