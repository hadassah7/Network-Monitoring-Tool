<?php

$path = dirname(__FILE__);
$name = $_GET['name'];
                    
$graph1 = fopen("$path/$name.png",'rb');
header("Content-Type: image/png\n");
header("Content-Transfer-Encoding: binary");

fpassthru($graph1);
unlink("$path/$name.png");

            
?>                
