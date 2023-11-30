<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
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
            'store_id' => 'required',
            'withdraw_account_id' => 'required',
            'tran_id' => 'required',
            'amount' => 'required',
        ]);

        $withdraw_request = WithdrawRequest::create([
            'user_id' =>$request->user_id,
            'store_id' =>$request->store_id,
            'withdraw_account_id' =>$request->withdraw_account_id,
            'tran_id' =>$request->tran_id,
            'amount' =>$request->amount,
        ]);
        toastr()->success($withdraw_request->name.__('global.created_success'),__('global.admin').__('global.created'));
        return redirect()->route('admin.withdraw-requests.index');
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $withdraw_request = WithdrawRequest::find($id);
        return view('admin.withdraw_requests.show',compact('withdraw_request'));
    }
    public function edit(string $id)
    {
        App::setLocale(session('locale'));
        $withdraw_request = WithdrawRequest::find($id);
        $users = User::orderBy('id','DESC')->where('status','active')->get();
        return view('admin.withdraw_requests.edit',compact(['withdraw_request','users']));
    }
    public function update(Request $request, string $id)
    {
        App::setLocale(session('locale'));
        $withdraw_requests = WithdrawRequest::find($id);

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
