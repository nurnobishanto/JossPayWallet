<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function index()
    {
        App::setLocale(session('locale'));
        $users = User::orderBy('id','DESC')->get();
        return view('admin.users.index',compact('users'));
    }
    public function trashed_list(){
        App::setLocale(session('locale'));
        $users = User::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.users.trashed',compact('users'));
    }
    public function create()
    {
        App::setLocale(session('locale'));
        return view('admin.users.create');
    }


    public function store(Request $request)
    {
        App::setLocale(session('locale'));
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed', // Use 'confirmed' for password confirmation
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $imagePath = null;
        if($request->file('photo')){
            $imagePath = $request->file('photo')->store('admin-photo');
        }
        $user = User::create([
            'name' =>$request->name,
            'email' =>$request->email,
            'status' =>$request->status,
            'photo' =>$imagePath,
            'password' => Hash::make($request->password) ,
        ]);
        toastr()->success($user->name.__('global.created_success'),__('global.admin').__('global.created'));

        return redirect()->route('admin.users.index');
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $user = User::find($id);
        return view('admin.users.show',compact('user'));
    }
    public function edit(string $id)
    {
        App::setLocale(session('locale'));
        $user = User::find($id);
        return view('admin.users.edit',compact(['user',]));
    }
    public function update(Request $request, string $id)
    {
        App::setLocale(session('locale'));
        $user = User::find($id);
        $request->validate([
            'name' => 'required',
            'status' => 'required',
            'email' => 'required|email|unique:users,id,'.$id,
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if($request->password){
            $request->validate([
                'password' => 'confirmed',
            ]);
            $user->password = Hash::make($request->password);
        }
        $imagePath = $user->photo??null;
        if($request->file('photo')){
            $imagePath = $request->file('photo')->store('admin-photo');
            $old_image_path = "uploads/".$request->old_photo;
            if (file_exists($old_image_path)) {
                @unlink($old_image_path);
            }
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->status = $request->status;
        $user->photo = $imagePath;
        $user->update();
        toastr()->success($user->name.__('global.updated_success'),__('global.admin').__('global.updated'));
        return redirect()->route('admin.users.index');
    }

    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $user = User::find($id);
        $user->delete();
        toastr()->success(__('global.admin').__('global.deleted_success'),__('global.admin').__('global.deleted'));
        return redirect()->route('admin.users.index');
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $user = User::withTrashed()->find($id);
        $user->deleted_at = null;
        $user->update();
        toastr()->success($user->name.__('global.restored_success'),__('global.restored'));
        return redirect()->route('admin.users.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $user = User::withTrashed()->find($id);
        $old_image_path = "uploads/".$user->photo;
        if (file_exists($old_image_path)) {
            @unlink($old_image_path);
        }
        $user->forceDelete();
        toastr()->success(__('global.admin').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.users.trashed');
    }

}
