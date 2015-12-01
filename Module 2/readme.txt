Packages Required

Before starting to install the packages, update and upgrade the system using the commands "sudo apt-get update" and "sudo apt-get upgrade" respectively from the terminal

1) php5 (sudo apt-get install php5)

2) php5-mysql (sudo apt-get install php5-mysql)

3) php5-snmp ("sudo apt-get install php5-snmp" and restart apache2)

4) php5-rrd ("sudo apt-get install php5-rrd", add an extension "extension=rrdtool.so" in php.ini file present in the folder /etc/php5/apache2 and restart apache2)

5) mysql-server (sudo apt-get install mysql-server)

6) apache server (sudo apt-get install apache2)

7) libapache2-mod-php5 (sudo apt-get install libapache2-mod-php5)

8) DBI (sudo apt-get install libdbi-perl)

9) libmysqlclient-dev (sudo apt-get install libmysqlclient-dev)

10) Install DBD::mysql and Net::SNMP from cpan

11) libperl-dev (sudo apt-get install libperl-dev) 

12) libnet-snmp-perl (sudo apt-get install libnet-snmp-perl)

13) rrdtool (sudo apt-get install rrdtool)

14) librrds-perl (sudo apt-get install librrds-perl)

15) RRD::Simple() (Download the .tar.gz file from cpan website and extract in desired folder. Then run "perl Makefile.PL", "sudo make", "sudo make install" respectively from terminal)

16) cURL (sudo apt-get install curl)
Tool:

This tool is designed to monitor aggregate bitrate of network devices and some performance metrics of servers like CPU Usage, Requests/sec,Bytes/sec and Bytes/requests.

=> The folder needs to have all the apache permissions so as to be executed properly.
=> index.php file is the front end of this tool. Access it from the browser by giving localhost/<path of the folder>/index.php
=> Devices can be added by specifying the details under "Add Network Device" and "Add Server" options in the GUI.
=> Devices can be deleted from the GUI as well.
=> Run "perl backend.pl" script from the terminal. The devices that are added will be probed every 60 seconds as per the requirement.
=> Only the interfaces that are selected while adding the device are probed and will be available for monitoring.
=> To monitor the aggregated bitrate in the form of graphs select the device and the interface you want to monitor and the grpahs will be displayed.
=> To monitor the performance metrics of servers select the server and the respective graphs will be displayed.  
