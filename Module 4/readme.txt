Packages Required

Before starting to install the packages, update and upgrade the system using the commands "sudo apt-get update" and "sudo apt-get upgrade" respectively from the terminal

1) php5 (sudo apt-get install php5)

2) php5-mysql (sudo apt-get install php5-mysql)

3) php5-snmp ("sudo apt-get install php5-snmp" and restart apache2)

4) mysql-server (sudo apt-get install mysql-server)

5) apache server (sudo apt-get install apache2)

6) libapache2-mod-php5 (sudo apt-get install libapache2-mod-php5)

7) DBI (sudo apt-get install libdbi-perl)

8) libmysqlclient-dev (sudo apt-get install libmysqlclient-dev)

9) Install DBD::mysql and Net::SNMP from cpan

10) libperl-dev (sudo apt-get install libperl-dev) 

11) libnet-snmp-perl (sudo apt-get install libnet-snmp-perl)

Tool:

This tool is designed to monitor the Sysuptime and  Status of the device if its responding to requests or not.  

=> The folder needs to have all the apache permissions so as to be executed properly.
=> The device details are taken directly from the "DEVICES" table.
=> Run backend.pl script from the terminal giving "perl backend.pl". The script is made to run every 10 sec and the database gets updated automatically.
=> index.php file is the front end of this tool. Access it from the browser by giving localhost/<path of the folder>/index.php
=> The front end displays all the devices list present and the status is represented with colors. If the device misses any request the color is made more red. If the color in the status remains "white" it means the device is responding to the requests sent.
=> The device is made clickable and onclick it displays the details of the total number of requests sent, missed requests if any, the sysuptime of the device and the last updated time.
