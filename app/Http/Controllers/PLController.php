<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\Transaction;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
class PLController extends Controller
{
    public function default_payment_link_qr_code($store){
        $myStore = Store::find($store);
        $link = route('store.default_payment_link',['store' => $myStore->store_id]);
        $qrCodes = [];
        $qrCodes['title'] = 'Default Payment Link';
        $qrCodes['qrCodeImage'] = null;
        $qrCodes['qrCode'] = null;
        $qrCodes['link'] = $link;
        $qrCodes['store'] = $myStore;

        if ($myStore->business_logo){
            $image = '/public/uploads/'.$myStore->business_logo;
            $qrCodes['qrCodeImage'] = QrCode::size(350)->format('png')->merge($image, .2)->generate($link);

        }else{
            $qrCodes['qrCode'] = QrCode::size(350)->generate($link);
        }
        return view('qr', $qrCodes);
    }
    public function default_payment_link($store){
        $myStore = Store::where('store_id',$store)->first();
        $data = array();
        $data['store'] = $myStore;
        $data['tran_id'] = "DPL".strtoupper(substr(uniqid(),-7));
        return view('payment.default_payment',$data);

    }
    public function payment_status (Request $request){
        //return $request;
        $data =  array();
        $data['amount'] = $request->amount;
        $data['store_amount'] = $request->store_amount;
        $data['currency'] = $request->currency;
        $data['tran_id'] = $request->tran_id;
        $data['bank_txn'] = $request->bank_txn;
        $data['status'] = $request->status;
        $data['pay_status'] = $request->pay_status;
        $data['card_type'] = $request->card_type;
        $data['desc'] = $request->desc;
        $data['user_id'] = $request->user_id;
        $data['store_id'] = $request->store_id;
        $data['cus_name'] = $request->cus_name;
        $data['cus_phone'] = $request->cus_phone;
        $data['title'] = 'Payment status is '.$request->pay_status;
        $data['store'] = Store::find($request->store_id);
        $data['transaction'] = Transaction::where('tran_id',$request->tran_id)->first();
        return view('payment.default_payment_status',$data);
    }
}
