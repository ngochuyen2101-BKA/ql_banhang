<?php

namespace App\Http\Controllers\backend;
use App\Http\Requests\{AddUserRequest,EditUserRequest};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\user;

class UserController extends Controller
{
    function GetAddUser()
    {
        return view("backend.user.adduser");
    }

    function PostAddUser(AddUserRequest $r)
    {
        $user =  new user;
        $user->email=$r->email;
        $user->password=bcrypt($r->password);
        $user->full=$r->full;
        $user->address=$r->address;
        $user->phone=$r->phone;
        $user->level=$r->level;
        $user->save();

        return redirect('admin/user')->with('thongbao','Đã thêm thành công');
        
    }

  
    function GetEditUser($id_user)
    {
        $data['user']=user::find($id_user);
        return view("backend.user.edituser",$data);
    }

    function PostEditUser(EditUserRequest $r,$id_user)
    {
        $user=user::find($id_user);
        $user->email=$r->email;
        if ($user->password!="") {
            $user->password=bcrypt($r->password);
        }
        $user->full=$r->full;
        $user->address=$r->address;
        $user->phone=$r->phone;
        $user->level=$r->level;
        $user->save();

        return redirect()->back()->with('thongbao','Bạn đã sửa thành công!');

    }

    function GetListUser()
    {
        $data['users'] = user::paginate(3);
        return view("backend.user.listuser",$data);
    }

    function DelUser($id_user)
    {
        user::destroy($id_user);
        return redirect()->back()->with('thongbao','Bạn đã xóa thành công');
    }
}
