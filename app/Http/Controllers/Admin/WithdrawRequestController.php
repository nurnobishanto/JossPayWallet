<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WithdrawRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;


class WithdrawRequestController extends Controller
{

    public function index()
    {
        App::setLocale(session('locale'));
        $withdraw_requests = WithdrawRequest::orderBy('id','DESC')->get();

        return view('admin.withdraw_requests.index',compact('withdraw_requests'));
    }
    public function trashed_list(){
        App::setLocale(session('locale'));
        $withdraw_requests = WithdrawRequest::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.withdraw_requests.trashed',compact('withdraw_requests'));
    }
    public function create()
    {
        App::setLocale(session('locale'));
        $users = User::orderBy('id','DESC')->where('status','active')->get();
        return view('admin.withdraw_requests.create',compact('users'));
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
            'domain_name' => 'required|unique:withdraw_requests',
            'website_url' => 'required|unique:withdraw_requests',
            'server_ip' => 'required',
            'charge' => 'required',
            'business_logo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $imagePath = null;
        if($request->file('business_logo')){
            $imagePath = $request->file('business_logo')->withdraw_requests('business-logo');
        }
        $withdraw_request = WithdrawRequest::create([
            'user_id' =>$request->user_id,
            'business_name' =>$request->business_name,
            'business_type' =>$request->business_type,
            'mobile_number' =>$request->mobile_number,
            'business_email' =>$request->business_email,
            'domain_name' =>$request->domain_name,
            'website_url' =>$request->website_url,
            'server_ip' =>$request->server_ip,
            'charge' =>$request->charge,
            'status' =>$request->status,
            'business_logo' =>$imagePath,
        ]);
        toastr()->success($withdraw_request->name.__('global.created_success'),__('global.admin').__('global.created'));

        return redirect()->route('admin.withdraw-requests.index');
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $withdraw_requests = WithdrawRequest::find($id);
        return view('admin.withdraw_requests.show',compact('withdraw_requests'));
    }
    public function edit(string $id)
    {
        App::setLocale(session('locale'));
        $withdraw_requests = WithdrawRequest::find($id);
        $users = User::orderBy('id','DESC')->where('status','active')->get();
        return view('admin.withdraw_requests.edit',compact(['withdraw_requests','users']));
    }
    public function update(Request $request, string $id)
    {
        App::setLocale(session('locale'));
        $withdraw_requests = WithdrawRequest::find($id);
        $request->validate([
            'user_id' => 'required',
            'business_name' => 'required',
            'business_type' => 'required',
            'mobile_number' => 'required',
            'business_email' => 'required|email',
            'domain_name' => 'required|unique:withdraw_requests,id,'.$id,
            'website_url' => 'required|unique:withdraw_requests,id,'.$id,
            'server_ip' => 'required',
            'charge' => 'required',
            'business_logo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $withdraw_requests->photo??null;
        if($request->file('business_logo')){
            $imagePath = $request->file('business_logo')->withdraw_requests('business-logo');
            $old_image_path = "uploads/".$request->business_logo_old;
            if (file_exists($old_image_path)) {
                @unlink($old_image_path);
            }
        }
        $withdraw_requests->user_id = $request->user_id;
        $withdraw_requests->balance = $request->balance;
        $withdraw_requests->business_name = $request->business_name;
        $withdraw_requests->business_type = $request->business_type;
        $withdraw_requests->mobile_number = $request->mobile_number;
        $withdraw_requests->business_email = $request->business_email;
        $withdraw_requests->domain_name = $request->domain_name;
        $withdraw_requests->website_url = $request->website_url;
        $withdraw_requests->server_ip = $request->server_ip;
        $withdraw_requests->charge = $request->charge;
        $withdraw_requests->status = $request->status;
        $withdraw_requests->business_logo = $imagePath;
        $withdraw_requests->update();
        toastr()->success($withdraw_requests->name.__('global.updated_success'),__('global.admin').__('global.updated'));
        return redirect()->route('admin.withdraw-requests.index');
    }

    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $withdraw_requests = WithdrawRequest::find($id);
        $withdraw_requests->delete();
        toastr()->success(__('global.admin').__('global.deleted_success'),__('global.admin').__('global.deleted'));
        return redirect()->route('admin.withdraw-requests.index');
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $withdraw_requests = WithdrawRequest::withTrashed()->find($id);
        $withdraw_requests->deleted_at = null;
        $withdraw_requests->update();
        toastr()->success($withdraw_requests->name.__('global.rewithdraw_requestsd_success'),__('global.rewithdraw_requestsd'));
        return redirect()->route('admin.withdraw-requests.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $withdraw_requests = WithdrawRequest::withTrashed()->find($id);
        $old_image_path = "uploads/".$withdraw_requests->photo;
        if (file_exists($old_image_path)) {
            @unlink($old_image_path);
        }
        $withdraw_requests->forceDelete();
        toastr()->success(__('global.admin').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.withdraw-requests.trashed');
    }

}
