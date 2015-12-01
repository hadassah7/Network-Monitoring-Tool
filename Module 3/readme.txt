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

12) librrds-perl (sudo apt-get install librrds-perl)

13) Some changes in the configuration files need to be made
        In /etc/snmp/snmptrapd.conf
          add lines: disableAuthorization yes
                     snmpTrapAddr UDP:50162
                     traphandle 1.3.6.1.4.1.41717.10.* /usr/bin/perl <path to file>/trapdeamon.pl 
        In /etc/default/snmp
          add line:  TRAPDRUN=yes
          
          Restart the snmpd service

Tool:

This tool is designed to view the status when the traps are sent to UDP port 50162 from a specific trap 1.3.6.1.4.1.41717.10.*

=> The folder needs to have all the apache permissions so as to be executed properly.
=> index.php file is the front end of this tool. Access it from the browser by giving localhost/<path of the folder>/index.php
=> Open the trapdeamon.pl script and change the location of the log file that is to be created if necessary else it would be created in the assignment folder itself.
=> When a trap is received from 1.3.6.1.4.1.41717.10.* to the port 50162 then the trapdeamon.pl script is triggered automatically and log file is created.
=> From the GUI add the details of IP, PORT and COMMUNITY to which the trap is to be sent when a "FAIL" or "DANGER" trap is reported.
=> The table in the index page of this assignment displays the FQDN, Status and Last Reported Time of the trap that is reported.
