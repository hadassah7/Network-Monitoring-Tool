<?php

include "credentials.php";

 //connection to the database
           
           $db = mysql_connect("$host:$port",$user,$pwd)
           or die ("Database could not be connected");
           
           $sql = "CREATE DATABASE IF NOT EXISTS $database";
           
           if(!mysql_query($sql))
           {
             echo "ERROR creating database";
           }

    mysql_query("USE $database");
    
    $sql = "CREATE TABLE IF NOT EXISTS `DEVICES`(
                 `id` int(11) NOT NULL AUTO_INCREMENT,
                 `IP` tinytext NOT NULL,
                 `PORT` int(11) NOT NULL,
                 `COMMUNITY` tinytext NOT NULL,
                  PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ";
      
      if(!mysql_query($sql)){
        echo "Error creating table";
      }   
      
      $sql = "CREATE TABLE IF NOT EXISTS `Interfaces`(
                 `ID` int(11) NOT NULL AUTO_INCREMENT,
                 `IP` tinytext NOT NULL,
                 `PORT` int(11) NOT NULL,
                 `COMMUNITY` varchar(150) NOT NULL,
                 `Interfaces` tinytext NOT NULL,
                 PRIMARY KEY (ID)) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ";
      
      if(!mysql_query($sql)){
        echo "Error creating table";
      }   
      
      $sql = "CREATE TABLE IF NOT EXISTS `HTTP`(
                 `ID` int(11) NOT NULL AUTO_INCREMENT,
                 `IP` tinytext NOT NULL,
                 `HTTPPORT` int(11) NOT NULL,
                  PRIMARY KEY (ID)) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ";
      
      if(!mysql_query($sql)){
        echo "Error creating table";
      }           

         $sql = "CREATE TABLE IF NOT EXISTS `Network`(
                 `ID` int(11) NOT NULL AUTO_INCREMENT,
                 `IP` tinytext NOT NULL,
                 `PORT` int(11) NOT NULL,
                 `COMMUNITY` varchar(150) NOT NULL,
                 `Interfaces` tinytext NOT NULL,
                 PRIMARY KEY (ID)) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ";
      
      if(!mysql_query($sql)){
        echo "Error creating table";
      }   
      
      
      $sql = "CREATE TABLE IF NOT EXISTS `Sysuptime`(
                 `ID` int(11) NOT NULL AUTO_INCREMENT,
                 `HOST` tinytext NOT NULL,
                 `PORT` int(11) NOT NULL,
                 `COMMUNITY` varchar(150) NOT NULL,
                 `Sysuptime` tinytext NOT NULL,
                 `Time` text NOT NULL,
                 `SentRequests` int NOT NULL,
                 `MissedRequests` int NOT NULL,
                 `COLOR` int NOT NULL,
                 PRIMARY KEY (ID)) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ";
      
      if(!mysql_query($sql)){
        echo "Error creating table";
      } 
      
      $sql = "CREATE TABLE IF NOT EXISTS `TRAPS`(
                 `ID` int(11) NOT NULL AUTO_INCREMENT,
                 `Message` text NOT NULL,
                 `PREVIOUS_S` int(11) NOT NULL,
                 `PRESENT_S` int(11) NOT NULL,
                 `PREVIOUS_T` int(11) NOT NULL,
                 `PRESENT_T` int(11) NOT NULL,
                  PRIMARY KEY (ID)) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ";
      
      if(!mysql_query($sql)){
        echo "Error creating table";
      }             
      
       $sql = "CREATE TABLE IF NOT EXISTS `Fail`(
                 `ID` int(11) NOT NULL AUTO_INCREMENT,
                 `IP` tinytext NOT NULL,
                 `PORT` int(11) NOT NULL,
                 `COMMUNITY` varchar(150) NOT NULL,
                  PRIMARY KEY (ID)) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ";
      
      
      
      if(!mysql_query($sql)){
        echo "Error creating table";
      }             
?>
