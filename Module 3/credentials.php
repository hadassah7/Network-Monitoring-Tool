<?php

$path = dirname(__FILE__);
$n = explode('/',$path);
array_pop($n);
$conf = implode('/',$n);

$l = "$conf/db.conf";
$line = file($l);
$cred = array();
foreach($line as $z){
$x = explode('"',$z);
array_push($cred,$x[1]);
}

$host = $cred[0];
$port = $cred[1];
$database =$cred[2];
$user = $cred[3];
$pwd = $cred[4];

?>
