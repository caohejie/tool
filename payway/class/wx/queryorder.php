<?php
require_once "./lib/WxPay.Api.php";
$out_trade_no = $_REQUEST['orderid'];
$input = new WxPayOrderQuery();
$input->SetOut_trade_no($out_trade_no);
$res=WxPayApi::orderQuery($input);
if($res['return_code']=="SUCCESS"&&$res['result_code']=="SUCCESS"){
    
    echo "success";
    
}else{
    
    echo "false";
    
}