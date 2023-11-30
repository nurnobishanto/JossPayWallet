<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\WithdrawAccount;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function getStoresByUserId(Request $request)
    {
        $stores = Store::where('user_id', $request->user_id)->get();
        return response()->json($stores);
    }

    public function getWithdrawAccountsByUserId(Request $request)
    {
        $withdrawAccounts = WithdrawAccount::where('user_id', $request->user_id)->get();
        return response()->json($withdrawAccounts);
    }
    public function getStoreBalanceByStoreId(Request $request){
        $store = Store::find($request->store_id);
        return response()->json($store);
    }

}
