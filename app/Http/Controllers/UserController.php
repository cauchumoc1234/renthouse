<?php

namespace App\Http\Controllers;

use App\User;
use App\User_comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PharIo\Manifest\Email;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::all();
//        $data = User::where(['is_active' => 1])->orderBy('created_at', 'ASC')->get(); // lấy toàn bộ dữ liệu
        // gọi đến view
        return view('backend.user.index', [
            'data' => $data // truyền dữ liệu sang view Index
        ]);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('backend.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10000'
        ]);

        $is_active = 0;
        if ($request->has('is_active')) { // kiem tra is_active co ton tai khong?
            $is_active = $request->input('is_active');
        }

        //luu vào csdl
        $user = new User();
        $user->name = $request->input('name'); // họ tên
        $user->birthday = $request->input('birthday');
        $user->phone = $request->input('phone');
        $user->cmnd = $request->input('cmnd');
        $user->email = $request->input('email'); // email
        $user->password = bcrypt($request->input('password')); // mật khẩu
        $user->role_id = $request->input('role_id'); // phần quyền
        $user->address = $request->input('address');
        if ($request->hasFile('avatar')) {
            // get file
            $file = $request->file('avatar');
            // get ten
            $filename = time().'_'.$file->getClientOriginalName();
            // duong dan upload
            $path_upload = 'uploads/user/';
            // upload file
            $request->file('avatar')->move($path_upload,$filename);

            $user->image = $path_upload.$filename;
        }

        $user->is_active = $is_active;
        $user->save();

        // chuyen dieu huong trang
        return redirect()->route('admin.user.index')->with('msg', 'Tạo Tài Khoản Thành Công');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
//        dd("1234");
        $user = User::findorFail($id);
        return view('backend.user.show', [
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $user = User::findorFail($id);


        return view('backend.user.edit', [
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //validate
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10000'
        ]);

        $user = User::findorFail($id);

        $is_active = 0;
        if ($request->has('is_active')) { // kiem tra is_active co ton tai khong?
            $is_active = $request->input('is_active');
        }

        //luu vào csdl
        $user->name = $request->input('name'); // họ tên
        $user->email = $request->input('email'); // email
        $user->role_id = $request->input('role_id'); // phân quyền
        $user->birthday = $request->input('birthday');
        $user->phone = $request->input('phone');
        $user->cmnd = $request->input('cmnd');
        $user->address = $request->input('address');
        if ($request->input('new_password')) {
            $user->password = bcrypt($request->input('new_password')); // mật khẩu mới
        }

        if ($request->hasFile('new_avatar')) {
            // xóa file cũ
            @unlink(public_path($user->image)); // hàm unlink của PHP không phải laravel , chúng ta thêm @ đằng trước tránh bị lỗi
            // get file
            $file = $request->file('new_avatar');
            // get ten
            $filename = time().'_'.$file->getClientOriginalName();
            // duong dan upload
            $path_upload = 'uploads/user/';
            // upload file
            $request->file('new_avatar')->move($path_upload,$filename);

            $user->image = $path_upload.$filename;
        }

        $user->is_active = $is_active;
        $user->save();

        // chuyen dieu huong trang
        return redirect()->route('admin.user.show', ['id' => $user->id])->with('msg', 'Cập nhật tài khoản thành công.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // gọi tới hàm destroy của laravel để xóa 1 object
        User::destroy($id);

        // Trả về dữ liệu json và trạng thái kèm theo thành công là 200
        return response()->json([
            'status' => true
        ], 200);
    }

    public function getListRequestedOwner()
    {
        $data = User::where(['role_id' => 2, 'is_active' => 0, 'approval_id' => null])->orderBy('created_at', 'ASC')->get();
        return view('backend.user.index', [
            'data' => $data // truyền dữ liệu sang view Index
        ]);
    }

    public function checkExistEmail($new_email)
    {
        $stt = true;
        $test = User::where(['email' => $new_email])->first();
        if($test != null)
        {
            $stt = false;
        }
        return json_encode($stt);
    }

    public function checkExistCmnd($new_cmnd)
    {
        $stt = true;
        $test = User::where(['cmnd' => $new_cmnd])->first();
        if($test != null)
        {
            $stt = false;
        }
        return json_encode($stt);
    }

    public function checkOldPassword($password)
    {
        $result = false;
        $user = Auth::user();
        if(Hash::check($password, $user->password)) {
            $result = true;
        }
        return json_encode($result);
    }
    public function changePassword(Request $request)
    {
        $user = Auth::user();
        $user->password = bcrypt($request->input('new_password'));
        $user->save();
        if($user->role_id == 2) {
            return redirect()->route('owner.showProfile')->with('msg', 'Thay đổi mật khẩu thành công.');
        }
        if($user->role_id == 3) {
            return redirect()->back()->with('status', 'success');
        }
    }





//    public function postComment(Request $request) // viet san de day
//    {
//
//    }
}
