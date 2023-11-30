<?php


use App\Models\GlobalSetting;

if (!function_exists('myCustomFunction')) {

    function myCustomFunction($param)
    {
        // Your custom logic here
    }
}
if (!function_exists('userWithdrawAmount')) {

    function userWithdrawAmount($id,$status)
    {
        return \App\Models\WithdrawRequest::where('user_id',$id)->where('status',$status)->sum('amount');
    }
}
if (!function_exists('userTransactionsAmount')) {

    function userTransactionsAmount($id,$status)
    {
        return \App\Models\Transaction::where('user_id',$id)->where('status',$status)->sum('customer_store_amount');
    }
}
if (!function_exists('userTotalBalance')) {

    function userTotalBalance($id)
    {
        return \App\Models\Store::where('user_id',$id)->sum('balance');
    }
}
if (!function_exists('setSetting')) {

    function setSetting($key, $value)
    {
         GlobalSetting::updateOrInsert(
            ['key' => $key],
            ['value' => $value]
        );
    }
}
if (!function_exists('getSetting')) {
    function getSetting($key)
    {
        $setting = GlobalSetting::where('key', $key)->first();
        if ($setting) {
            return $setting->value;
        }
        return null;
    }
}
if (!function_exists('checkRolePermissions')) {

    function checkRolePermissions($role,$permissions){
        $status = true;
        foreach ($permissions as $permission){
            if(!$role->hasPermissionTo($permission)){
                $status = false;
            }
        }

        return $status;
    }
}
if (!function_exists('checkAdminRole')) {

    function checkAdminRole($admin,$role){
        $status = false;
       if($admin->hasAnyRole([$role])){
           $status = true;
       }

        return $status;
    }
}



