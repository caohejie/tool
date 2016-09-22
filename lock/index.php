<?php
/**
 * 测试例子
 * @link http://code.google.com/p/phplock/
 * @author sunli
 * @blog http://sunli.cnblogs.com
 * @svnversion  $Id: testlock.php 6 2010-06-28 03:13:02Z sunli1223 $
 * @version v1.0 beta1
 * @license Apache License Version 2.0
 * @copyright  sunli1223@gmail.com
 */
require 'class.phplock.php';
$lock = new PHPLock ( 'lock/', '123' );
$lock->startLock ();
$status = $lock->Lock ();

//var_dump($status);

if (! $status) { 
	exit ( "lock error" );
}



if($_REQUEST['a']==1){
    
    for($i=0;$i<20000;$i++){
    
        increment1 ();
    
    }
    
    
}elseif($_REQUEST['a']==2){
    
    
    for($i=0;$i<20000;$i++){
    
        increment ();
    
    }
    
    
}




$lock->unlock ();
$lock->endLock ();

function increment() {
	if (! file_exists ( 'testlockfile' )) {
		file_put_contents ( 'testlockfile', 0 );
	}
	$num = file_get_contents ( 'testlockfile' );
	$num = $num + 1;
	file_put_contents ( 'testlockfile', $num );
	return file_get_contents ( 'testlockfile' );
}
function increment1() {
    if (! file_exists ( 'testlockfile1' )) {
        file_put_contents ( 'testlockfile1', 0 );
    }
    $num = file_get_contents ( 'testlockfile1' );
    $num = $num + 1;
    file_put_contents ( 'testlockfile1', $num );
    return file_get_contents ( 'testlockfile1' );
}
?>