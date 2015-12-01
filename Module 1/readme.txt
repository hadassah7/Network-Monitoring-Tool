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

15)RRD::Simple() (Download the .tar.gz file from cpan website and extract in desired folder. Then run "perl Makefile.PL", "sudo make", "sudo make install" respectively from terminal)

16) MRTG (sudo apt-get install mrtg)





Tool:

This tool is designed to monitor bitrate of network devices using MRTG and SNMP retreival. Crontab is used as scheduler and mysql database for configuration storage.

=> The folder needs to have all the apache permissions so as to be executed properly.
=> index.php file is the front end of this tool. Access it from the browser by giving localhost/<path of the folder>/index.php
=> Add devices to the "DEVICES" table by specifying the IP,PORT and COMMUNITY of the device through the mysql-server.
=> After adding the device details to the "DEVICES" table, run "perl mrtgconf.pl" as root from the terminal.
=> The graphs will be created automatically in mrtg folder.
=> For the backend script to run every 5 min, place it in crontab and add the line "*/5 * * * * <path to file>/php backend.php" at the end.
=> To monitor the bitrate in the form of graphs select the device and the interface you want to monitor from the frontend. The graphs will be displayed. 
