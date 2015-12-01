<html>
        <head>
            
            <title> ANM </title>                                
         
        </head>
        
        <body>
        <div class ="main">
        <table style = "width:1300px;" cell spacing = "0" cell padding = "0">
        <tr><td colspan ="5" style="background-color:#CEF6D8;">        
        <h1><center> Adding Server </center></h1>
        <h3><center> Step-1 Enter Server Details</center></h3>
        </td></tr>      
         
        <tr>
        <td colspan = "1">
        <a href='index.php'>HOME</td> 
            	    
            	    
            	   
            	    	
        <td style="height:600px;width:2000px;vertical-align:top;">
        <center><br>   
       <form action = "a3s2.php" method = "POST">
       <?php
                 
              
        echo "<table border = '2' width =1000 align=center cell padding= 10>
       <tr><td> IP of the Device </td><td><input type='tinytext' name='IP' aria-describedby='number-format' required aria-required='true'</td></tr>
       <tr><td> HTTP PORT </td><td><input type='text' name='HTTPPORT' aria-describedby='number-format' required aria-required='true'</td></tr>
       <input type='hidden' name = 'method' value = 'HTTP'>
       <tr><td Colspan = '2' align='center'><input type ='submit' name ='formsubmit' value=Add Server></td></tr></tr>";
         
                  
       ?>
      
       
             </center>
        
        </table>
        </div>
        </body>
</html>        
