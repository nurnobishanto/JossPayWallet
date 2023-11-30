<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WithdrawAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;


class WithdrawAccountController extends Controller
{

    public function index()
    {
        App::setLocale(session('locale'));
        $withdraw_accounts = WithdrawAccount::orderBy('id','DESC')->get();

        return view('admin.withdraw_accounts.index',compact('withdraw_accounts'));
    }
    public function trashed_list(){
        App::setLocale(session('locale'));
        $withdraw_accounts = WithdrawAccount::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.withdraw_accounts.trashed',compact('withdraw_accounts'));
    }
    public function create()
    {
        App::setLocale(session('locale'));
        $users = User::orderBy('id','DESC')->where('status','active')->get();
        return view('admin.withdraw_accounts.create',compact('users'));
    }


    public function store(Request $account)
    {
        App::setLocale(session('locale'));
        $account->validate([
            'user_id' => 'required',
            'bank_name' => 'required',
            'account_name' => 'required',
            'account_no' => 'required',
            'account_type' => 'required',
            'branch_name' => 'required',
            'routing_no' => 'required',
            'status' => 'required',
        ]);

        $withdraw_account = WithdrawAccount::create([
            'user_id' =>$account->user_id,
            'bank_name' =>$account->bank_name,
            'account_name' =>$account->account_name,
            'account_no' =>$account->account_no,
            'account_type' =>$account->account_type,
            'branch_name' =>$account->branch_name,
            'routing_no' =>$account->routing_no,
            'status' =>$account->status,
        ]);
        toastr()->success($withdraw_account->name.__('global.created_success'),__('global.admin').__('global.created'));

        return redirect()->route('admin.withdraw-accounts.index');
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $withdraw_account = WithdrawAccount::find($id);
        return view('admin.withdraw_accounts.show',compact('withdraw_account'));
    }
    public function edit(string $id)
    {
        App::setLocale(session('locale'));
        $withdraw_account = WithdrawAccount::find($id);
        $users = User::orderBy('id','DESC')->where('status','active')->get();
        return view('admin.withdraw_accounts.edit',compact(['withdraw_account','users']));
    }
    public function update(Request $account, string $id)
    {
        App::setLocale(session('locale'));
        $withdraw_accounts = WithdrawAccount::find($id);
        $account->validate([
            'user_id' => 'required',
            'bank_name' => 'required',
            'account_name' => 'required',
            'account_no' => 'required',
            'account_type' => 'required',
            'status' => 'required',
        ]);
        $withdraw_accounts->user_id = $account->user_id;
        $withdraw_accounts->bank_name = $account->bank_name;
        $withdraw_accounts->account_name = $account->account_name;
        $withdraw_accounts->account_no = $account->account_no;
        $withdraw_accounts->account_type = $account->account_type;
        $withdraw_accounts->routing_no = $account->routing_no;
        $withdraw_accounts->branch_name = $account->branch_name;
        $withdraw_accounts->status = $account->status;
        $withdraw_accounts->update();
        toastr()->success($withdraw_accounts->name.__('global.updated_success'),__('global.admin').__('global.updated'));
        return redirect()->route('admin.withdraw-accounts.index');
    }

    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $withdraw_accounts = WithdrawAccount::find($id);
        $withdraw_accounts->delete();
        toastr()->success(__('global.admin').__('global.deleted_success'),__('global.admin').__('global.deleted'));
        return redirect()->route('admin.withdraw-accounts.index');
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $withdraw_accounts = WithdrawAccount::withTrashed()->find($id);
        $withdraw_accounts->deleted_at = null;
        $withdraw_accounts->update();
        toastr()->success($withdraw_accounts->name.__('global.rewithdraw_accountsd_success'),__('global.rewithdraw_accountsd'));
        return redirect()->route('admin.withdraw-accounts.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $withdraw_accounts = WithdrawAccount::withTrashed()->find($id);
        $old_image_path = "uploads/".$withdraw_accounts->photo;
        if (file_exists($old_image_path)) {
            @unlink($old_image_path);
        }
        $withdraw_accounts->forceDelete();
        toastr()->success(__('global.admin').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.withdraw-accounts.trashed');
    }

}
