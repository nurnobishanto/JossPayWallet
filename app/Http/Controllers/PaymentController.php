<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function request(Request $request){
        $title = "Redirecting..";
        $spinner = true;
        $h3 = "Don't refresh or reload this page.";
        $h3Class = "text-danger";
        $p = '<i class="fas fa-info-circle"> </i> Redirecting soon. Please wait...';
        $pClass = "text-info";
        $html =  view('payment.loading',compact(['title','spinner','h3','h3Class','p','pClass']));
        echo $html;

        $request->validate([
            'store_id' => 'required',
            'api_key' => 'required',
            'tran_id' => 'required',
            'success_url' => 'required',
            'fail_url' => 'required',
            'cancel_url' => 'required',
            'amount' => 'required',
            'currency' => 'required',
            'desc' => 'required',
            'cus_name' => 'required',
            'cus_email' => 'required',
            'cus_add1' => 'required',
            'cus_add2' => 'required',
            'cus_city' => 'required',
            'cus_state' => 'required',
            'cus_country' => 'required',
            'cus_phone' => 'required',

        ]);


        $url = env('AMAR_PAY_REQUEST_URL');
        $store_id = $request->store_id;
        $api_key = $request->api_key;
        $store = Store::where('store_id',$store_id)->where('api_key',$api_key)->first();

        if($store->status == 'active'){
            $user = $store->user;
            $transaction = Transaction::where('tran_id',$request->tran_id)->first();
            if(!$transaction){
                $transaction = DB::table('transactions')->insert([
                    'user_id' => $user->id,
                    'store_id' => $store->id,
                    'tran_id' => $request->tran_id,
                    'success_url' => $request->success_url,
                    'fail_url' => $request->fail_url,
                    'cancel_url' => $request->cancel_url,
                    'amount' => $request->amount,
                    'currency' => $request->currency,
                    'desc' => $request->desc,
                    'cus_name' => $request->cus_name,
                    'cus_email' => $request->cus_email,
                    'cus_add1' => $request->cus_add1,
                    'cus_add2' => $request->cus_add2,
                    'cus_city' => $request->cus_city,
                    'cus_state' => $request->cus_state,
                    'cus_country' => $request->cus_country,
                    'cus_phone' => $request->cus_phone,
                    'cus_postcode' => $request->cus_postcode,
                    'opt_a' => $request->opt_a,
                    'opt_b' => $request->opt_b,
                    'opt_c' => $request->opt_c,
                    'opt_d' => $request->opt_d,
                    'type' => $request->type,
                    'status' => 'pending',
                    'ship_country' => $request->ship_country,
                    'ship_postcode' => $request->ship_postcode,
                    'ship_state' => $request->ship_state,
                    'ship_city' => $request->ship_city,
                    'ship_add2' => $request->ship_add2,
                    'ship_add1' => $request->ship_add1,
                    'ship_name' => $request->ship_name,
                    'cus_fax' => $request->cus_fax,
                ]);
            }
            $transaction = Transaction::where('tran_id',$request->tran_id)->first();
            if($transaction->status != 'success'){
                $fields = array(
                    'store_id' => env('AMAR_PAY_STORE_ID'), //store id will be aamarpay,  contact integration@aamarpay.com for test/live id
                    'amount' => $transaction->amount , //transaction amount
                    'payment_type' => 'VISA', //no need to change
                    'currency' => 'BDT',  //currenct will be USD/BDT
                    'tran_id' => $transaction->tran_id, //transaction id must be unique from your end
                    'cus_name' => $transaction->cus_name,  //customer name
                    'cus_email' => $transaction->cus_email, //customer email address
                    'cus_add1' => $transaction->cus_add1,  //customer address
                    'cus_add2' => $transaction->cus_add2, //customer address
                    'cus_city' => $transaction->cus_city,  //customer city
                    'cus_state' => $transaction->cus_state,  //state
                    'cus_postcode' => $transaction->cus_postcode, //postcode or zipcode
                    'cus_country' => $transaction->cus_country,  //country
                    'cus_phone' => $transaction->cus_phone, //customer phone number
                    'cus_fax' => $transaction->cus_fax,  //fax
                    'ship_name' => $transaction->ship_name, //ship name
                    'ship_add1' => $transaction->ship_add1,  //ship address
                    'ship_add2' => $transaction->ship_add2,
                    'ship_city' => $transaction->ship_city,
                    'ship_state' => $transaction->ship_state,
                    'ship_postcode' => $transaction->ship_postcode,
                    'ship_country' => $transaction->ship_country,
                    'desc' => $transaction->desc,
                    'success_url' => route('success'), //your success route
                    'fail_url' => route('fail'), //your fail route
                    'cancel_url' => route('cancel'), //your cancel url
                    'opt_a' => $transaction->opt_a,  //optional paramter
                    'opt_b' => $transaction->opt_b,
                    'opt_c' => $transaction->opt_c,
                    'opt_d' => $transaction->opt_d,
                    'signature_key' => env('AMAR_PAY_SIGNATURE_KEY')); //signature key will provided aamarpay, contact integration@aamarpay.com for test/live signature key


                $fields_string = http_build_query($fields);

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_VERBOSE, true);
                curl_setopt($ch, CURLOPT_URL, $url);

                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $url_forward = str_replace('"', '', stripslashes(curl_exec($ch)));
                curl_close($ch);
                $this->redirect_to_merchant($url_forward);
            }
            else{

                $title = "Already success";
                $spinner = false;
                $h3 = "Your payment already success";
                $h3Class = "text-success";
                $p = '';
                $pClass = "text-info";
                $html =  view('payment.loading',compact(['title','spinner','h3','h3Class','p','pClass']));
                return $html;

            }
        }
        else{
            $title = "Invalid Store and API KEY Or Store Status is pending";
            $spinner = false;
            $h3 = "Invalid !";
            $h3Class = "text-danger";
            $p = 'Invalid Store and API KEY Or Store Status is pending';
            $pClass = "text-danger";
            $html =  view('payment.loading',compact(['title','spinner','h3','h3Class','p','pClass']));
            return $html;

        }

    }
    public function request_wp(Request $request){
        $title = "Redirecting..";
        $spinner = true;
        $h3 = "Don't refresh or reload this page.";
        $h3Class = "text-danger";
        $p = '<i class="fas fa-info-circle"> </i> Redirecting soon. Please wait...';
        $pClass = "text-info";
        $html =  view('payment.loading',compact(['title','spinner','h3','h3Class','p','pClass']));
        echo $html;
         $validate = $request->validate([
            'store_id' => 'required',
            'api_key' => 'required',
            'tran_id' => 'required',
            'success_url' => 'required',
            'fail_url' => 'required',
            'cancel_url' => 'required',
            'amount' => 'required',
            'currency' => 'required',
            'desc' => 'required',
            'cus_name' => 'required',
            'cus_email' => 'required',
            'cus_add1' => 'required',
            'cus_add2' => 'required',
            'cus_city' => 'required',
            'cus_state' => 'required',
            'cus_country' => 'required',
            'cus_phone' => 'required',

        ]);
         if ($validate){
             $store_id = $request->store_id;
             $api_key = $request->api_key;
             $store = Store::where('store_id',$store_id)->where('api_key',$api_key)->first();
             if( $store && $store->status =='active'){
                 $user = $store->user;
                 $transaction = Transaction::where('tran_id',$request->tran_id)->first();
                 if(!$transaction){

                     $transaction = DB::table('transactions')->insert([
                         'user_id' => $user->id,
                         'store_id' => $store->id,
                         'tran_id' => $request->tran_id,
                         'success_url' => $request->success_url.'&order_id='.$request->order_id.'&tran_id='.$request->tran_id,
                         'fail_url' => $request->fail_url.'&order_id='.$request->order_id.'&tran_id='.$request->tran_id,
                         'cancel_url' => $request->cancel_url.'&order_id='.$request->order_id.'&tran_id='.$request->tran_id,
                         'amount' => $request->amount,
                         'currency' => $request->currency,
                         'desc' => $request->desc,
                         'cus_name' => $request->cus_name,
                         'cus_email' => $request->cus_email,
                         'cus_add1' => $request->cus_add1,
                         'cus_add2' => $request->cus_add2,
                         'cus_city' => $request->cus_city,
                         'cus_state' => $request->cus_state,
                         'cus_country' => $request->cus_country,
                         'cus_phone' => $request->cus_phone,
                         'cus_postcode' => $request->cus_postcode,
                         'opt_a' => $request->opt_a,
                         'opt_b' => $request->opt_b,
                         'opt_c' => $request->opt_c,
                         'opt_d' => $request->opt_d,
                         'type' => $request->type,
                         'ship_country' => $request->ship_country,
                         'ship_postcode' => $request->ship_postcode,
                         'ship_state' => $request->ship_state,
                         'ship_city' => $request->ship_city,
                         'ship_add2' => $request->ship_add2,
                         'ship_add1' => $request->ship_add1,
                         'ship_name' => $request->ship_name,
                         'cus_fax' => $request->cus_fax,
                     ]);

                 }
                 return redirect(env('app_url').'/payment/'.$request->tran_id);
             }
             else{
                 $title = "Invalid Store and API KEY Or Store Status is pending";
                 $spinner = false;
                 $h3 = "Invalid !";
                 $h3Class = "text-danger";
                 $p = 'Invalid Store and API KEY Or Store Status is pending';
                 $pClass = "text-danger";
                 $html =  view('payment.loading',compact(['title','spinner','h3','h3Class','p','pClass']));
                 return $html;
             }

         }else{
             echo 'Something went wrong!';
             $title = "Something went wrong!";
             $spinner = false;
             $h3 = "Something went wrong! !";
             $h3Class = "text-danger";
             $p = '';
             $pClass = "text-danger";
             $html =  view('payment.loading',compact(['title','spinner','h3','h3Class','p','pClass']));
             return $html;
         }

    }
    public function transaction_pay($id){
        $title = "Redirecting..";
        $spinner = true;
        $h3 = "Don't refresh or reload this page.";
        $h3Class = "text-danger";
        $p = '<i class="fas fa-info-circle"> </i> Redirecting soon. Please wait...';
        $pClass = "text-info";
        $html =  view('payment.loading',compact(['title','spinner','h3','h3Class','p','pClass']));
        echo $html;
        $transaction = Transaction::where('tran_id',$id)->first();
        $url = env('AMAR_PAY_REQUEST_URL');
        if($transaction->status == 'pending'){
            $originalAmount = $transaction->amount;
            $extraAmount = $originalAmount * 0.03;
            $fields = array(
                'store_id' => env('AMAR_PAY_STORE_ID'), //store id will be aamarpay,  contact integration@aamarpay.com for test/live id
                'amount' => $transaction->amount + $extraAmount, //transaction amount
                'payment_type' => 'VISA', //no need to change
                'currency' => 'BDT',  //currenct will be USD/BDT
                'tran_id' => $transaction->tran_id, //transaction id must be unique from your end
                'cus_name' => $transaction->cus_name,  //customer name
                'cus_email' => $transaction->cus_email, //customer email address
                'cus_add1' => $transaction->cus_add1,  //customer address
                'cus_add2' => $transaction->cus_add2, //customer address
                'cus_city' => $transaction->cus_city,  //customer city
                'cus_state' => $transaction->cus_state,  //state
                'cus_postcode' => $transaction->cus_postcode, //postcode or zipcode
                'cus_country' => $transaction->cus_country,  //country
                'cus_phone' => $transaction->cus_phone, //customer phone number
                'cus_fax' => $transaction->cus_fax,  //fax
                'ship_name' => $transaction->ship_name, //ship name
                'ship_add1' => $transaction->ship_add1,  //ship address
                'ship_add2' => $transaction->ship_add2,
                'ship_city' => $transaction->ship_city,
                'ship_state' => $transaction->ship_state,
                'ship_postcode' => $transaction->ship_postcode,
                'ship_country' => $transaction->ship_country,
                'desc' => $transaction->desc,
                'success_url' => route('success'), //your success route
                'fail_url' => route('fail'), //your fail route
                'cancel_url' => route('cancel'), //your cancel url
                'opt_a' => $transaction->opt_a,  //optional paramter
                'opt_b' => $transaction->opt_b,
                'opt_c' => $transaction->opt_c,
                'opt_d' => $transaction->opt_d,
                'signature_key' => env('AMAR_PAY_SIGNATURE_KEY')); //signature key will provided aamarpay, contact integration@aamarpay.com for test/live signature key


            $fields_string = http_build_query($fields);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_VERBOSE, true);
            curl_setopt($ch, CURLOPT_URL, $url);

            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $url_forward = str_replace('"', '', stripslashes(curl_exec($ch)));
            curl_close($ch);
            $this->redirect_to_merchant($url_forward);
        }
        else{
            $title = "Already success";
            $spinner = false;
            $h3 = "Your payment already success";
            $h3Class = "text-success";
            $p = '';
            $pClass = "text-info";
            $html =  view('payment.loading',compact(['title','spinner','h3','h3Class','p','pClass']));
            return $html;
        }
    }
    function redirect_to_merchant($url) {
        ?>
        <html xmlns="http://www.w3.org/1999/xhtml">
        <head><script type="text/javascript">
                function closethisasap() { document.forms["redirectpost"].submit(); }
            </script></head>
        <body onLoad="closethisasap();">

        <form name="redirectpost" method="post" action="<?php echo env('AMAR_PAY_URL').$url; ?>">

        </form>
        <!-- for live url https://secure.aamarpay.com -->
        </body>
        </html>
        <?php
        exit;
    }
    public function success(Request $request){
        $title = "Payment is successful";
        $spinner = true;
        $h3 = "Payment is successful";
        $h3Class = "text-success";
        $p = 'Please wait for the order to complete. Do not close/refresh your browser. Redirecting...';
        $pClass = "text-info";
        $html =  view('payment.loading',compact(['title','spinner','h3','h3Class','p','pClass']));
        echo $html;
        $transaction  = Transaction::where('tran_id',$request->mer_txnid)->first();
        if($transaction){
            $amountOriginal = $request->amount_original;
            //$chargePercentage = $transaction->store->charge;
            $chargePercentage = 3;
            $paymentCharge = ($amountOriginal * $chargePercentage) / 100;

            $transaction->pg_service_charge_bdt = $request->pg_service_charge_bdt;
            $transaction->amount_original = $request->amount_original;
            $transaction->gateway_fee = $request->gateway_fee;
            $transaction->payment_charge = $paymentCharge - $request->gateway_fee;
            $transaction->pg_card_bank_name = $request->pg_card_bank_name;
            $transaction->card_number = $request->card_number;
            $transaction->card_holder = $request->card_holder;
            $transaction->pay_status = $request->pay_status;
            $transaction->card_type = $request->card_type;
            $transaction->store_amount = $request->store_amount;
            $transaction->customer_store_amount = $request->store_amount - $paymentCharge;
            $transaction->bank_txn = $request->bank_txn;
            $transaction->method = $request->card_type;
            $transaction->status = 'success';
            $transaction->update();

            $store = $transaction->store;
            $store->balance = $store->balance + $transaction->customer_store_amount;
            $store->update();
        }



    $postData = [
        'tran_id' => $transaction->tran_id,
        'amount' => $transaction->amount,
        'pay_status' => $transaction->pay_status,
        'card_type' => $transaction->card_type,
        'store_amount' => $transaction->store_amount,
        'bank_txn' => $transaction->bank_txn,
        'desc' => $transaction->desc,
        'status' => $transaction->status,
        'method' => $transaction->method,
        'status_code' => $transaction->status_code,
        'user_id' => $transaction->user_id,
        'store_id' => $transaction->store_id,
        'success_url' => $transaction->success_url,
        'fail_url' => $transaction->fail_url,
        'cancel_url' => $transaction->cancel_url,
        'currency' => $transaction->currency,
        'cus_name' => $transaction->cus_name,
        'cus_email' => $transaction->cus_email,
        'cus_add1' => $transaction->cus_add1,
        'cus_add2' => $transaction->cus_add2,
        'cus_city' => $transaction->cus_city,
        'cus_state' => $transaction->cus_state,
        'cus_country' => $transaction->cus_country,
        'cus_phone' => $transaction->cus_phone,
        'cus_postcode' => $transaction->cus_postcode,
        'opt_a' => $transaction->opt_a,
        'opt_b' => $transaction->opt_b,
        'opt_c' => $transaction->opt_c,
        'opt_d' => $transaction->opt_d,
        'type' => $transaction->type,
        'ship_country' => $transaction->ship_country,
        'ship_postcode' => $transaction->ship_postcode,
        'ship_state' => $transaction->ship_state,
        'ship_city' => $transaction->ship_city,
        'ship_add2' => $transaction->ship_add2,
        'ship_add1' => $transaction->ship_add1,
        'ship_name' => $transaction->ship_name,
        'cus_fax' => $transaction->cus_fax,

    ];

    // Generate the HTML form with hidden fields
    $formHtml = '<form id="redirectForm" method="POST" action="'.$transaction->success_url.'">';
    $formHtml .= '<input type="hidden" name="_token" value="'.csrf_token().'">';
    foreach ($postData as $key => $value) {
        $formHtml .= '<input type="hidden" name="'.$key.'" value="'.$value.'">';
    }

    $formHtml .= '</form>';

    return view('payment.redirect')->with('formHtml', $formHtml);

    }
    public function fail(Request $request){
        $title = "Payment is failed";
        $spinner = true;
        $h3 = "Payment is successful";
        $h3Class = "text-danger";
        $p = 'Please wait for the order to failed. Do not close/refresh your browser. Redirecting...';
        $pClass = "text-danger";
        $html =  view('payment.loading',compact(['title','spinner','h3','h3Class','p','pClass']));
        echo $html;
        $transaction  = Transaction::where('tran_id',$request->mer_txnid)->first();
        $transaction->status = 'failed';
        $transaction->update();
        $postData = [
            'tran_id' => $transaction->tran_id,
            'amount' => $transaction->amount,
            'pay_status' => $transaction->pay_status,
            'card_type' => $transaction->card_type,
            'store_amount' => $transaction->store_amount,
            'bank_txn' => $transaction->bank_txn,
            'desc' => $transaction->desc,
            'status' => $transaction->status,
            'method' => $transaction->method,
            'status_code' => $transaction->status_code,
            'user_id' => $transaction->user_id,
            'store_id' => $transaction->store_id,
            'success_url' => $transaction->success_url,
            'fail_url' => $transaction->fail_url,
            'cancel_url' => $transaction->cancel_url,
            'currency' => $transaction->currency,
            'cus_name' => $transaction->cus_name,
            'cus_email' => $transaction->cus_email,
            'cus_add1' => $transaction->cus_add1,
            'cus_add2' => $transaction->cus_add2,
            'cus_city' => $transaction->cus_city,
            'cus_state' => $transaction->cus_state,
            'cus_country' => $transaction->cus_country,
            'cus_phone' => $transaction->cus_phone,
            'cus_postcode' => $transaction->cus_postcode,
            'opt_a' => $transaction->opt_a,
            'opt_b' => $transaction->opt_b,
            'opt_c' => $transaction->opt_c,
            'opt_d' => $transaction->opt_d,
            'type' => $transaction->type,
            'ship_country' => $transaction->ship_country,
            'ship_postcode' => $transaction->ship_postcode,
            'ship_state' => $transaction->ship_state,
            'ship_city' => $transaction->ship_city,
            'ship_add2' => $transaction->ship_add2,
            'ship_add1' => $transaction->ship_add1,
            'ship_name' => $transaction->ship_name,
            'cus_fax' => $transaction->cus_fax,

        ];
        // Generate the HTML form with hidden fields
        $formHtml = '<form id="redirectForm" method="POST" action="'.$transaction->fail_url.'">';
        $formHtml .= '<input type="hidden" name="_token" value="'.csrf_token().'">';
        foreach ($postData as $key => $value) {
            $formHtml .= '<input type="hidden" name="'.$key.'" value="'.$value.'">';
        }

        $formHtml .= '</form>';

        return view('payment.redirect')->with('formHtml', $formHtml);
    }
    public function cancel(Request $request){
        echo 'Payment is canceled, please wait for the order to complete. Do not close/refresh your browser. Redirecting to...';
        $title = "Payment is canceled";
        $spinner = false;
        $h3 = "Payment is successful";
        $h3Class = "text-danger";
        $p = 'Please wait for the order to canceled.';
        $pClass = "text-danger";
        $html =  view('payment.loading',compact(['title','spinner','h3','h3Class','p','pClass']));
        return $html;
        $transaction  = Transaction::where('tran_id',$request->mer_txnid)->first();
        $transaction->status = 'canceled';
        $transaction->update();
        $postData = [
            'tran_id' => $transaction->tran_id,
            'amount' => $transaction->amount,
            'pay_status' => $transaction->pay_status,
            'card_type' => $transaction->card_type,
            'store_amount' => $transaction->store_amount,
            'bank_txn' => $transaction->bank_txn,
            'desc' => $transaction->desc,
            'status' => $transaction->status,
            'method' => $transaction->method,
            'status_code' => $transaction->status_code,
            'user_id' => $transaction->user_id,
            'store_id' => $transaction->store_id,
            'success_url' => $transaction->success_url,
            'fail_url' => $transaction->fail_url,
            'cancel_url' => $transaction->cancel_url,
            'currency' => $transaction->currency,
            'cus_name' => $transaction->cus_name,
            'cus_email' => $transaction->cus_email,
            'cus_add1' => $transaction->cus_add1,
            'cus_add2' => $transaction->cus_add2,
            'cus_city' => $transaction->cus_city,
            'cus_state' => $transaction->cus_state,
            'cus_country' => $transaction->cus_country,
            'cus_phone' => $transaction->cus_phone,
            'cus_postcode' => $transaction->cus_postcode,
            'opt_a' => $transaction->opt_a,
            'opt_b' => $transaction->opt_b,
            'opt_c' => $transaction->opt_c,
            'opt_d' => $transaction->opt_d,
            'type' => $transaction->type,
            'ship_country' => $transaction->ship_country,
            'ship_postcode' => $transaction->ship_postcode,
            'ship_state' => $transaction->ship_state,
            'ship_city' => $transaction->ship_city,
            'ship_add2' => $transaction->ship_add2,
            'ship_add1' => $transaction->ship_add1,
            'ship_name' => $transaction->ship_name,
            'cus_fax' => $transaction->cus_fax,

        ];
        // Generate the HTML form with hidden fields
        $formHtml = '<form id="redirectForm" method="POST" action="'.$transaction->cancel_url.'">';
        $formHtml .= '<input type="hidden" name="_token" value="'.csrf_token().'">';
        foreach ($postData as $key => $value) {
            $formHtml .= '<input type="hidden" name="'.$key.'" value="'.$value.'">';
        }

        $formHtml .= '</form>';

        return view('payment.redirect')->with('formHtml', $formHtml);
    }
}
