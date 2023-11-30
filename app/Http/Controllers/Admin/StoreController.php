<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class StoreController extends Controller
{

    public function index()
    {
        App::setLocale(session('locale'));
        $stores = Store::orderBy('id','DESC')->get();

        return view('admin.stores.index',compact('stores'));
    }
    public function trashed_list(){
        App::setLocale(session('locale'));
        $stores = Store::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.stores.trashed',compact('stores'));
    }
    public function create()
    {
        App::setLocale(session('locale'));
        $users = User::orderBy('id','DESC')->where('status','active')->get();
        return view('admin.stores.create',compact('users'));
    }
    public function store(Request $request)
    {

        App::setLocale(session('locale'));
        $request->validate([
            'user_id' => 'required',
            'business_name' => 'required',
            'business_type' => 'required',
            'mobile_number' => 'required',
            'business_email' => 'required|email',
            'charge' => 'required',
            'status' => 'required',
            'business_logo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'add1' => 'required',
            'add2' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
        ]);
        if ($request->domain_name){
            $request->validate([
                'domain_name' => 'unique:stores',
                'server_ip' => 'required',
            ]);
        }
        if ($request->website_url){
            $request->validate([
                'website_url' => 'unique:stores',
            ]);
        }
        $imagePath = null;
        if($request->file('business_logo')){
            $imagePath = $request->file('business_logo')->store('business-logo');
        }
        $store = Store::create([
            'user_id' =>$request->user_id,
            'business_name' =>$request->business_name,
            'business_type' =>$request->business_type,
            'mobile_number' =>$request->mobile_number,
            'business_email' =>$request->business_email,
            'domain_name' =>$request->domain_name,
            'website_url' =>$request->website_url,
            'server_ip' =>$request->server_ip,
            'charge' =>$request->charge,
            'business_logo' =>$imagePath,
            'add1' =>$request->add1,
            'add2' =>$request->add2,
            'city' =>$request->city,
            'state' =>$request->state,
            'country' =>$request->country,
        ]);

        $store->status = $request->status;
        $store->update();
        toastr()->success($store->name.__('global.created_success'),__('global.admin').__('global.created'));

        return redirect()->route('admin.stores.index');
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $store = Store::find($id);
        return view('admin.stores.show',compact('store'));
    }
    public function edit(string $id)
    {
        App::setLocale(session('locale'));
        $store = Store::find($id);
        $users = User::orderBy('id','DESC')->where('status','active')->get();
        return view('admin.stores.edit',compact(['store','users']));
    }
    public function update(Request $request, string $id)
    {
        App::setLocale(session('locale'));
        $store = Store::find($id);
        $request->validate([
            'user_id' => 'required',
            'business_name' => 'required',
            'business_type' => 'required',
            'mobile_number' => 'required',
            'business_email' => 'required|email',
            'charge' => 'required',
            'business_logo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'add1' => 'required',
            'add2' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
        ]);
        if ($request->domain_name){
            $request->validate([
                'domain_name' => 'required|unique:stores,id,'.$id,
                'server_ip' => 'required',
            ]);
        }
        if ($request->website_url){
            $request->validate([
                'website_url' => 'required|unique:stores,id,'.$id,
            ]);
        }
        $imagePath = $store->business_logo??null;
        if($request->file('business_logo')){
            $imagePath = $request->file('business_logo')->store('business-logo');
            $old_image_path = "uploads/".$request->business_logo_old;
            if (file_exists($old_image_path)) {
                @unlink($old_image_path);
            }
        }
        $store->user_id = $request->user_id;
        $store->balance = $request->balance;
        $store->business_name = $request->business_name;
        $store->business_type = $request->business_type;
        $store->mobile_number = $request->mobile_number;
        $store->business_email = $request->business_email;
        $store->domain_name = $request->domain_name;
        $store->website_url = $request->website_url;
        $store->server_ip = $request->server_ip;
        $store->charge = $request->charge;
        $store->status = $request->status;
        $store->business_logo = $imagePath;
        $store->add1 = $request->add1;
        $store->add2 = $request->add2;
        $store->city = $request->city;
        $store->state = $request->state;
        $store->country = $request->country;
        $store->update();
        toastr()->success($store->name.__('global.updated_success'),__('global.admin').__('global.updated'));
        return redirect()->route('admin.stores.index');
    }

    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $store = Store::find($id);
        $store->delete();
        toastr()->success(__('global.admin').__('global.deleted_success'),__('global.admin').__('global.deleted'));
        return redirect()->route('admin.stores.index');
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $store = Store::withTrashed()->find($id);
        $store->deleted_at = null;
        $store->update();
        toastr()->success($store->name.__('global.restored_success'),__('global.restored'));
        return redirect()->route('admin.stores.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $store = Store::withTrashed()->find($id);
        $old_image_path = "uploads/".$store->photo;
        if (file_exists($old_image_path)) {
            @unlink($old_image_path);
        }
        $store->forceDelete();
        toastr()->success(__('global.admin').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.stores.trashed');
    }

}
