<?php 

$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
$values = json_decode(json_encode(simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA)), true);


$res=file_get_contents("http://payway.babidou.net/class/wx/queryorder.php?orderid=".$values['out_trade_no']);

if($res=="success"){
    
    
    
    $sql="select Vyuid v from VpayTemp where Vynumber='".$values['out_trade_no']."'";
    if (! ($result = $db->sql_query($sql))) {
        message_die('Could not query user');
    }
    
    $num = $db->sql_numrows($result);
    
    if ($num > 0) {
    
        $row = $db->sql_fetchrow($result);
        
        $userpkid=$row['v'];
        
        $sql="select * from VpayTemp where Vynumber='".$values['out_trade_no']."' and IFNULL(VpayIsok,0)=0";
        if (! ($result = $db->sql_query($sql))) {
            message_die('Could not query user');
        }
        $num = $db->sql_numrows($result);
        $row = $db->sql_fetchrow($result);
        
        $sql="select * from VpaySuccess where `Vynumber`='".$values['out_trade_no']."'";
        if (! ($result = $db->sql_query($sql))) {
            message_die('Could not query user');
        }
        $num1 = $db->sql_numrows($result);
        
        if($num>0&&$num1>0){
            
            $value=$row['VpaySid'];
            $text2=$row['Vyuid'];
            $paymoney=$row['VpayMoney'];
            
            $sql="SELECT VName v FROM Vuser where Vid=".$text2."";
            if (! ($result = $db->sql_query($sql))) {
                message_die('Could not query user');
            }
            $row = $db->sql_fetchrow($result);
            $username=$row['v'];
            $sql="SELECT VPassWork v FROM Vuser where Vid=".$text2."";
            if (! ($result = $db->sql_query($sql))) {
                message_die('Could not query user');
            }
            $row = $db->sql_fetchrow($result);
            $userpwd=$row['v'];
            $sql="select Vvtime v from VuserVip where Vvuid=".$text2."";
            if (! ($result = $db->sql_query($sql))) {
                message_die('Could not query user');
            }
            $row = $db->sql_fetchrow($result);
            $text3=$row['v'];
            $sql="select * from VpaySetting where Vpsid=".$value;
            if (! ($result = $db->sql_query($sql))) {
                message_die('Could not query user');
            }
            $row2 = $db->sql_fetchrow($result);
            $paymonth=$row2['Vpstimes'];
            if($text3<date("Y-m-d H:i:s")){
                
                if($row2['Vpstimestype']=="0"){
                    
                    $userEndTime=date("Y-m-d",strtotime('+'.$row2['Vpstimes'].' days',strtotime(date("Y-m-d"))));
                    
                }else{
                    
                    $shu=$row2['Vpstimes']*30;
                    
                    $userEndTime=date("Y-m-d",strtotime('+'.$shu.' days',strtotime(date("Y-m-d"))));
                    
                }
                
                file_put_contents(date("Y-m-d")."huidiao.txt", date("Y-m-d H:i:s").$values['out_trade_no'].$res.$userEndTime);
            }
            
            
        }
        
    
    }
    
    
}





?>