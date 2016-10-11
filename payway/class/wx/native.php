<?php
ini_set('date.timezone','Asia/Shanghai');
//error_reporting(E_ERROR);

require_once "./lib/WxPay.Api.php";
require_once "WxPay.NativePay.php";
include '../../public/DES.php';

$data=$_REQUEST['data'];

$data=base64_decode($data);

$des = new DES("QW3MnlQ1");

$res=$des->decrypt($data);



$arr=json_decode($res,TRUE);



$notify = new NativePay();
$input = new WxPayUnifiedOrder();
$input->SetBody($arr['body']);
$input->SetAttach($arr['attach']);
$input->SetOut_trade_no($arr['out_trade_no']);
$input->SetTotal_fee($arr['total_fee']);
$input->SetTime_start(date("YmdHis"));
$input->SetTime_expire(date("YmdHis", time() + 600));
$input->SetGoods_tag($arr['goods_tag']);
$input->SetNotify_url($arr['huidiao']);
$input->SetTrade_type("NATIVE");
$input->SetProduct_id($arr['product_id']);
$result = $notify->GetPayUrl($input);
$url2 = $result["code_url"];


?>

<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1" /> 
    <title>扫码</title>
</head>
<body>
	
	<div style="margin-left: 10px;color:#556B2F;font-size:30px;font-weight: bolder;">扫描支付模式二</div><br/>
	<img alt="模式二扫码支付" src="http://paysdk.weixin.qq.com/example/qrcode.php?data=<?php echo urlencode($url2);?>" style="width:150px;height:150px;"/>
	
</body>
</html>