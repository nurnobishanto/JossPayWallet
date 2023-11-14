<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Store;
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
            $qrCodes['qrCodeImage'] = QrCode::size(350)->format('png')->merge($image, .4)->generate($link);

        }else{
            $qrCodes['qrCode'] = QrCode::size(350)->generate($link);
        }
        return view('qr', $qrCodes);
    }
    public function default_payment_link($store){
        $myStore = Store::where('store_id',$store)->first();
        return $myStore;
    }
}
