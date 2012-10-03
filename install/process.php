<?php
session_start();
require_once("settings.inc");

$action = isset($_GET['action']) ? $_GET['action'] : '';
switch($action){
	
	case 'installLeaderboard':
		$installLeaderboard = new Controller_Install();
		$installLeaderboard->install();
	break;
	
    default:
    break;
}

class Controller_Install{

	function install(){
		
		$config_file_default    = "config.default";    
		$config_file_directory  = "";	
		$config_file_name       = "../globalConfiguration.php";    
		$config_file_path       = $config_file_directory.$config_file_name;		
		$application_name       = "JV Leaderboard";
		$application_start_file = "../index.php";
		$license_agreement_page = "";
		$sql_dump				= "leaderboard.sql";
	
		$host 		= $_GET['host'];
		$username 	= $_GET['username'];
		$dbname		= $_GET['dbname'];
		$password 	= $_GET['password'];
		$uusername	= $_GET['uusername'];	
		$uemail		= $_GET['uemail'];
		$upassword 	= $_GET['upassword'];
		
		if($host || $username || $dbname || $password || $uusername || $uemail || $upassword != ''){
			
			$config_file = file_get_contents($config_file_default);
			$config_file = str_replace("_DB_HOST_", $host, $config_file);
			$config_file = str_replace("_DB_NAME_", $dbname, $config_file);
			$config_file = str_replace("_DB_USER_", $username, $config_file);
			$config_file = str_replace("_DB_PASSWORD_", $password, $config_file);
			
			$f = @fopen($config_file_path, "w+");
			@fwrite($f, $config_file);
			@fclose($f);
			
			$con 	= @mysql_connect($host,$username,$password);
			$db		= @mysql_select_db($dbname,$con);
			if(!$con){
				die('Could not connect: ' . mysql_error());
			}elseif(!$db){
				$q = "CREATE DATABASE $dbname";
				@mysql_query($q,$con);
				@mysql_select_db($dbname,$con);
				// create table affiliate
					$q2 = "	CREATE TABLE IF NOT EXISTS `affiliate` (
							`id_affiliate` int(10) NOT NULL auto_increment,
							`affiliate_name` varchar(200) NOT NULL,
							`primary_email` varchar(200) NOT NULL,
							`optional_email` varchar(200) NOT NULL,
							`picture` varchar(100) NOT NULL,
							PRIMARY KEY  (`id_affiliate`),
							UNIQUE KEY `affiliate_name` (`affiliate_name`)
							) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;
					";
					@mysql_query($q2,$con);
					// create table clicks
					$q3 = "	CREATE TABLE IF NOT EXISTS `clicks` (
							  `aff_id` int(100) NOT NULL,
							  `p_id` int(100) NOT NULL,
							  `ip` varchar(200) collate utf8_unicode_ci NOT NULL,
							  `click` int(200) NOT NULL,
							  PRIMARY KEY  (`aff_id`)
							) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
					
					";
					@mysql_query($q3);
					// create table leadeboard
					$q4 = "	CREATE TABLE IF NOT EXISTS `leaderboard` (
							  `id_leaderboard` int(10) NOT NULL auto_increment,
							  `leaderboard_name` varchar(200) NOT NULL,
							  `product_name` varchar(200) NOT NULL,
							  `top` int(100) NOT NULL,
							  `min` int(100) NOT NULL,
							  `start` varchar(100) NOT NULL,
							  `end` varchar(100) NOT NULL,
							  `visual_style` varchar(200) NOT NULL,
							  PRIMARY KEY  (`id_leaderboard`)
							) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;
					
					";
					@mysql_query($q4);
					// create table orders
					$q5 = "	CREATE TABLE IF NOT EXISTS `orders` (
							  `order_id` int(11) NOT NULL auto_increment,
							  `txn_id` varchar(19) character set utf8 collate utf8_unicode_ci NOT NULL,
							  `payer_email` varchar(75) character set utf8 collate utf8_unicode_ci NOT NULL,
							  `mc_gross` float(9,2) NOT NULL,
							  PRIMARY KEY  (`order_id`)
							) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
					";
					@mysql_query($q5);
					// create table product
					$q6 = "	CREATE TABLE IF NOT EXISTS `product` (
							  `id_product` int(10) NOT NULL auto_increment,
							  `product_name` varchar(200) NOT NULL,
							  `launch_date` date NOT NULL,
							  `launch_time` time NOT NULL,
							  `price` int(200) NOT NULL,
							  PRIMARY KEY  (`id_product`),
							  UNIQUE KEY `product_name` (`product_name`)
							) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;
					
					";
					@mysql_query($q6);
					// createt table sales
					$q7 = "	CREATE TABLE IF NOT EXISTS `sales` (
							  `id_sales` varchar(100) NOT NULL,
							  `product_name` varchar(200) NOT NULL,
							  `aff_name` varchar(200) NOT NULL,
							  `buyer` varchar(100) NOT NULL,
							  `source` varchar(100) NOT NULL,
							  `date` datetime NOT NULL,
							  PRIMARY KEY  (`id_sales`)
							) ENGINE=InnoDB DEFAULT CHARSET=latin1;
					
					";
					@mysql_query($q7);
					// create table user
					$q8 = "	CREATE TABLE IF NOT EXISTS `user` (
							  `id` int(10) NOT NULL auto_increment,
							  `username` varchar(50) NOT NULL,
							  `email` varchar(100) NOT NULL,
							  `password` varchar(100) NOT NULL,
							  `name` varchar(100) NOT NULL,
							  `type` varchar(50) NOT NULL,
							  `oauth_uid` varchar(200) NOT NULL,
							  `oauth_provider` varchar(200) NOT NULL,
							  `twitter_oauth_token` varchar(200) NOT NULL,
							  `twitter_oauth_token_secret` varchar(200) NOT NULL,
							  PRIMARY KEY  (`id`)
							) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;
					
					";
					@mysql_query($q8);
					// insert admin user
					$q9 = "INSERT INTO user (username, email, password, name, type) VALUES ('$uusername', '$uemail', md5('$upassword'), '$uusername', 'admin')";
					@mysql_query($q9);
					@mysql_close;
					echo "OK";
			}else{
					// select database
					@mysql_select_db($dbname);
					// create table affiliate
					$q2 = "	CREATE TABLE IF NOT EXISTS `affiliate` (
							`id_affiliate` int(10) NOT NULL auto_increment,
							`affiliate_name` varchar(200) NOT NULL,
							`primary_email` varchar(200) NOT NULL,
							`optional_email` varchar(200) NOT NULL,
							`picture` varchar(100) NOT NULL,
							PRIMARY KEY  (`id_affiliate`),
							UNIQUE KEY `affiliate_name` (`affiliate_name`)
							) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;
					";
					@mysql_query($q2,$con);
					// create table clicks
					$q3 = "	CREATE TABLE IF NOT EXISTS `clicks` (
							  `aff_id` int(100) NOT NULL,
							  `p_id` int(100) NOT NULL,
							  `ip` varchar(200) collate utf8_unicode_ci NOT NULL,
							  `click` int(200) NOT NULL,
							  PRIMARY KEY  (`aff_id`)
							) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
					
					";
					@mysql_query($q3);
					// create table leadeboard
					$q4 = "	CREATE TABLE IF NOT EXISTS `leaderboard` (
							  `id_leaderboard` int(10) NOT NULL auto_increment,
							  `leaderboard_name` varchar(200) NOT NULL,
							  `product_name` varchar(200) NOT NULL,
							  `top` int(100) NOT NULL,
							  `min` int(100) NOT NULL,
							  `start` varchar(100) NOT NULL,
							  `end` varchar(100) NOT NULL,
							  `visual_style` varchar(200) NOT NULL,
							  PRIMARY KEY  (`id_leaderboard`)
							) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;
					
					";
					@mysql_query($q4);
					// create table orders
					$q5 = "	CREATE TABLE IF NOT EXISTS `orders` (
							  `order_id` int(11) NOT NULL auto_increment,
							  `txn_id` varchar(19) character set utf8 collate utf8_unicode_ci NOT NULL,
							  `payer_email` varchar(75) character set utf8 collate utf8_unicode_ci NOT NULL,
							  `mc_gross` float(9,2) NOT NULL,
							  PRIMARY KEY  (`order_id`)
							) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
					";
					@mysql_query($q5);
					// create table product
					$q6 = "	CREATE TABLE IF NOT EXISTS `product` (
							  `id_product` int(10) NOT NULL auto_increment,
							  `product_name` varchar(200) NOT NULL,
							  `launch_date` date NOT NULL,
							  `launch_time` time NOT NULL,
							  `price` int(200) NOT NULL,
							  PRIMARY KEY  (`id_product`),
							  UNIQUE KEY `product_name` (`product_name`)
							) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;
					
					";
					@mysql_query($q6);
					// createt table sales
					$q7 = "	CREATE TABLE IF NOT EXISTS `sales` (
							  `id_sales` varchar(100) NOT NULL,
							  `product_name` varchar(200) NOT NULL,
							  `aff_name` varchar(200) NOT NULL,
							  `buyer` varchar(100) NOT NULL,
							  `source` varchar(100) NOT NULL,
							  `date` datetime NOT NULL,
							  PRIMARY KEY  (`id_sales`)
							) ENGINE=InnoDB DEFAULT CHARSET=latin1;
					
					";
					@mysql_query($q7);
					// create table user
					$q8 = "	CREATE TABLE IF NOT EXISTS `user` (
							  `id` int(10) NOT NULL auto_increment,
							  `username` varchar(50) NOT NULL,
							  `email` varchar(100) NOT NULL,
							  `password` varchar(100) NOT NULL,
							  `name` varchar(100) NOT NULL,
							  `type` varchar(50) NOT NULL,
							  `oauth_uid` varchar(200) NOT NULL,
							  `oauth_provider` varchar(200) NOT NULL,
							  `twitter_oauth_token` varchar(200) NOT NULL,
							  `twitter_oauth_token_secret` varchar(200) NOT NULL,
							  PRIMARY KEY  (`id`)
							) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;
					
					";
					@mysql_query($q8);
					// insert admin user
					$q9 = "INSERT INTO user (username, email, password, name, type) VALUES ('$uusername', '$uemail', md5('$upassword'), '$uusername', 'admin')";
					@mysql_query($q9);
					@mysql_close();
					echo "OK";
			}

			
		}
	}
}
?>