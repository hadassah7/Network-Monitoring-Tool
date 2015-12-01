<html>
        <head>
           <title> ANM </title>                                
         
        </head>
        
        <body>
        <div class ="main">
        <table style = "width:1300px;" cell spacing = "0" cell padding = "0">
        <tr><td colspan ="5" style="background-color:#CEF6D8;">        
        <h1><center> Assignment 1 </center></h1>
        </td></tr>      
         
        <tr>
        <td colspan = "1" style ="width:250px;vertical-align:top;">
           	
                    
            	    <a href="index.php">HOME</a> 
               	    
            	       	    </td>
            	    	
        <td style="height:600px;width:2000px;vertical-align:top;">
        <center><br>  
         
         <?php
         $n = $_POST['interface'];
         $name = explode(',',$n);
         $in = $name[0];
         $COMMUNITY = $name[1];
         $IP = $name[2];
         $PORT = $name[3];
         $now = time();$path = dirname(__FILE__);            
               
         $device = "$COMMUNITY" . "_" . "$IP" . "_" . "$PORT";
         echo "<br>Graphs for the device with IP $IP, COMMUNITY $COMMUNITY and PORT $PORT<br>";
         $a = array("-1d:Daily","-1w:Weekly","-1m:Monthly","-1y:Yearly");
         foreach ($a as $x)
         {
           $b = explode(':',$x);
           $span = $b[0];
           $name = $b[1];    
           $rrdgraph = array("--slope-mode",
                     "--start","$span",
                     "--end",$now,"--vertical-label","Bytes per second");

           $color = str_pad( dechex ( mt_rand(0,0xFFFFFF) ),6,'0',STR_PAD_LEFT);

           array_push($rrdgraph,"DEF:input$in=$device.rrd:input$in:AVERAGE",
                                "LINE:input$in#$color:Input$in",
				"GPRINT:input$in:LAST:Current Input = %6.2lf %SBps");
                      
           $color = str_pad( dechex ( mt_rand(0,0xFFFFFF) ),6,'0',STR_PAD_LEFT);
           array_push($rrdgraph,"DEF:output$in=$device.rrd:output$in:AVERAGE",
                                "LINE:output$in#$color:Output$in",
                                "GPRINT:output$in:LAST:Current Output = %6.2lf %SBps");

           $ret= rrd_graph("$path/$device$span.png",$rrdgraph);
           echo rrd_error();
           echo "<br> $name Graph";
           echo"<br><img src='view.php?name=$device$span'/><br>"; 
         }
        ?>
        </center>
        
        </table>
        </div>
        </body>
</html>        
