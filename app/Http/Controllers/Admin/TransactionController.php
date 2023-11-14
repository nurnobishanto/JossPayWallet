<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class TransactionController extends Controller
{

    public function index()
    {
        App::setLocale(session('locale'));
        $transactions = Transaction::orderBy('id','DESC')->get();

        return view('admin.transactions.index',compact('transactions'));
    }
    public function trashed_list(){
        App::setLocale(session('locale'));
        $transactions = Transaction::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.transactions.trashed',compact('transactions'));
    }
    public function create()
    {
        App::setLocale(session('locale'));
        $users = User::orderBy('id','DESC')->where('status','active')->get();
        return view('admin.transactions.create',compact('users'));
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
            'domain_name' => 'required|unique:transactions',
            'website_url' => 'required|unique:transactions',
            'server_ip' => 'required',
            'charge' => 'required',
            'business_logo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $imagePath = null;
        if($request->file('business_logo')){
            $imagePath = $request->file('business_logo')->transactions('business-logo');
        }
        $transactions = Transaction::create([
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
        toastr()->success($transactions->name.__('global.created_success'),__('global.admin').__('global.created'));

        return redirect()->route('admin.transactions.index');
    }
    public function show(string $id)
    {
        App::setLocale(session('locale'));
        $transactions = Transaction::find($id);
        return view('admin.transactions.show',compact('transactions'));
    }
    public function edit(string $id)
    {
        App::setLocale(session('locale'));
        $transactions = Transaction::find($id);
        $users = User::orderBy('id','DESC')->where('status','active')->get();
        return view('admin.transactions.edit',compact(['transactions','users']));
    }
    public function update(Request $request, string $id)
    {
        App::setLocale(session('locale'));
        $transactions = Transaction::find($id);
        $request->validate([
            'user_id' => 'required',
            'business_name' => 'required',
            'business_type' => 'required',
            'mobile_number' => 'required',
            'business_email' => 'required|email',
            'domain_name' => 'required|unique:transactions,id,'.$id,
            'website_url' => 'required|unique:transactions,id,'.$id,
            'server_ip' => 'required',
            'charge' => 'required',
            'business_logo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $transactions->photo??null;
        if($request->file('business_logo')){
            $imagePath = $request->file('business_logo')->transactions('business-logo');
            $old_image_path = "uploads/".$request->business_logo_old;
            if (file_exists($old_image_path)) {
                @unlink($old_image_path);
            }
        }
        $transactions->user_id = $request->user_id;
        $transactions->balance = $request->balance;
        $transactions->business_name = $request->business_name;
        $transactions->business_type = $request->business_type;
        $transactions->mobile_number = $request->mobile_number;
        $transactions->business_email = $request->business_email;
        $transactions->domain_name = $request->domain_name;
        $transactions->website_url = $request->website_url;
        $transactions->server_ip = $request->server_ip;
        $transactions->charge = $request->charge;
        $transactions->status = $request->status;
        $transactions->business_logo = $imagePath;
        $transactions->update();
        toastr()->success($transactions->name.__('global.updated_success'),__('global.admin').__('global.updated'));
        return redirect()->route('admin.transactions.index');
    }

    public function destroy(string $id)
    {
        App::setLocale(session('locale'));
        $transactions = Transaction::find($id);
        $transactions->delete();
        toastr()->success(__('global.admin').__('global.deleted_success'),__('global.admin').__('global.deleted'));
        return redirect()->route('admin.transactions.index');
    }
    public function restore($id){
        App::setLocale(session('locale'));
        $transactions = Transaction::withTrashed()->find($id);
        $transactions->deleted_at = null;
        $transactions->update();
        toastr()->success($transactions->name.__('global.retransactionsd_success'),__('global.retransactionsd'));
        return redirect()->route('admin.transactions.index');
    }
    public function force_delete($id){
        App::setLocale(session('locale'));
        $transactions = Transaction::withTrashed()->find($id);
        $old_image_path = "uploads/".$transactions->photo;
        if (file_exists($old_image_path)) {
            @unlink($old_image_path);
        }
        $transactions->forceDelete();
        toastr()->success(__('global.admin').__('global.deleted_success'),__('global.deleted'));
        return redirect()->route('admin.transactions.trashed');
    }

}
