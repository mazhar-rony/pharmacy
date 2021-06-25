/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 10.4.11-MariaDB : Database - pharmacy
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`pharmacy` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `pharmacy`;

/*Table structure for table `bank_account_transactions` */

DROP TABLE IF EXISTS `bank_account_transactions`;

CREATE TABLE `bank_account_transactions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `bank_account_id` bigint(20) unsigned NOT NULL,
  `transaction_date` date NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deposite` decimal(13,4) NOT NULL DEFAULT 0.0000,
  `withdraw` decimal(13,4) NOT NULL DEFAULT 0.0000,
  `interest` decimal(13,4) NOT NULL DEFAULT 0.0000,
  `balance` decimal(13,4) NOT NULL DEFAULT 0.0000,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bank_account_transactions_bank_account_id_foreign` (`bank_account_id`),
  CONSTRAINT `bank_account_transactions_bank_account_id_foreign` FOREIGN KEY (`bank_account_id`) REFERENCES `bank_accounts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `bank_account_transactions` */

insert  into `bank_account_transactions`(`id`,`bank_account_id`,`transaction_date`,`description`,`deposite`,`withdraw`,`interest`,`balance`,`created_at`,`updated_at`) values 
(1,2,'2021-06-03','Sold Product of Invoice No INV-202106030002',15000.0000,0.0000,0.0000,85000.0000,'2021-06-03 11:37:13','2021-06-03 11:37:13'),
(3,2,'2021-06-04','Return Product from Customer',0.0000,25000.0000,0.0000,10000.0000,'2021-06-04 00:58:40','2021-06-04 00:58:40'),
(4,1,'2021-06-04','Return Product of Invoice No INV-202106030001',0.0000,8000.0000,0.0000,92000.0000,'2021-06-04 01:13:15','2021-06-04 01:13:15'),
(5,2,'2021-06-05','Given Payment To Mr. Ashik',0.0000,5000.0000,0.0000,5000.0000,'2021-06-05 08:15:19','2021-06-05 08:15:19'),
(6,2,'2021-06-05','Given Payment To Mr. Ashik of Car Bazar',0.0000,1000.0000,0.0000,4000.0000,'2021-06-05 08:44:19','2021-06-05 08:44:19'),
(7,1,'2021-06-05','Purchased Product of Purchase No P-2021060502',0.0000,1500.0000,0.0000,90500.0000,'2021-06-05 14:47:38','2021-06-05 14:47:38'),
(8,1,'2021-06-05','Given Payment of Purchase No P-2021060501 to Mr. Jamal of Gadget & Gear',0.0000,1000.0000,0.0000,89500.0000,'2021-06-05 15:20:54','2021-06-05 15:20:54'),
(12,3,'2021-06-06','Purchased Product of Purchase No P-2021060601',0.0000,7000.0000,0.0000,43000.0000,'2021-06-05 23:05:57','2021-06-05 23:05:57'),
(13,2,'2021-06-14','Given Advance Salary to Employee: Mark Zukarbarg',0.0000,3000.0000,0.0000,1000.0000,'2021-06-13 20:02:48','2021-06-13 20:02:48'),
(14,3,'2021-06-14','Given Bonus Salary to Employee: Imran Hossain',0.0000,3000.0000,0.0000,40000.0000,'2021-06-13 21:02:22','2021-06-13 21:02:22'),
(15,3,'2021-06-14','Given Bonus Salary for July, 2021 to Employee: Imran Hossain',0.0000,2000.0000,0.0000,38000.0000,'2021-06-13 21:31:00','2021-06-13 21:31:00'),
(16,3,'2021-06-14','Given Salary for June, 2021 to Employee: Imran Hossain',0.0000,2000.0000,0.0000,36000.0000,'2021-06-13 22:31:27','2021-06-13 22:31:27'),
(17,3,'2021-06-14','Given Salary for June, 2021 to Employee: Imran Hossain',0.0000,3000.0000,0.0000,33000.0000,'2021-06-13 22:41:42','2021-06-13 22:41:42'),
(18,1,'2021-06-01','Given Bank Loan EMI To Account No 123456 of Dhaka Bank',0.0000,13000.0000,0.0000,76500.0000,'2021-06-18 03:06:59','2021-06-18 03:06:59'),
(19,1,'2021-06-19','Given Payment To Mr. Hossain of Square',0.0000,2000.0000,0.0000,74500.0000,'2021-06-19 13:11:00','2021-06-19 13:11:00');

/*Table structure for table `bank_accounts` */

DROP TABLE IF EXISTS `bank_accounts`;

CREATE TABLE `bank_accounts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `bank_id` bigint(20) unsigned NOT NULL,
  `branch_id` bigint(20) unsigned NOT NULL,
  `account_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `balance` decimal(13,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bank_accounts_bank_id_foreign` (`bank_id`),
  KEY `bank_accounts_branch_id_foreign` (`branch_id`),
  CONSTRAINT `bank_accounts_bank_id_foreign` FOREIGN KEY (`bank_id`) REFERENCES `banks` (`id`) ON DELETE CASCADE,
  CONSTRAINT `bank_accounts_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `bank_branches` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `bank_accounts` */

insert  into `bank_accounts`(`id`,`user_id`,`bank_id`,`branch_id`,`account_type`,`account_name`,`account_number`,`balance`,`created_at`,`updated_at`) values 
(1,1,1,3,'Current','Imran Hossain','123456',74500.0000,'2021-06-03 11:25:14','2021-06-19 13:11:00'),
(2,1,3,1,'Current','Adib Hossain','123',1000.0000,'2021-06-03 11:25:50','2021-06-13 20:02:48'),
(3,1,2,4,'Savings','Adib Hossain','654321',33000.0000,'2021-06-03 11:26:26','2021-06-13 22:41:42');

/*Table structure for table `bank_branches` */

DROP TABLE IF EXISTS `bank_branches`;

CREATE TABLE `bank_branches` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `bank_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bank_branches_bank_id_foreign` (`bank_id`),
  CONSTRAINT `bank_branches_bank_id_foreign` FOREIGN KEY (`bank_id`) REFERENCES `banks` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `bank_branches` */

insert  into `bank_branches`(`id`,`bank_id`,`name`,`slug`,`phone`,`city`,`location`,`address`,`created_at`,`updated_at`) values 
(1,3,'Dhanmondi Branch','dhanmondi-branch','01711111111','Dhaka','Dhanmondi','9/A, Dhanmondi','2021-06-03 11:20:51','2021-06-03 11:20:51'),
(2,3,'Mohammadpur Branch','mohammadpur-branch','01911111111','Dhaka','Mohammadpur','Asad Gate','2021-06-03 11:21:33','2021-06-03 11:21:33'),
(3,1,'Head Office','head-office','01711111111','Dhaka','Motijhil','Motijhil','2021-06-03 11:22:35','2021-06-03 11:22:35'),
(4,2,'Main Branch','main-branch','01911111111','Dhaka','Uttara','House Building','2021-06-03 11:23:21','2021-06-03 11:23:21');

/*Table structure for table `bank_loan_transactions` */

DROP TABLE IF EXISTS `bank_loan_transactions`;

CREATE TABLE `bank_loan_transactions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `bank_loan_id` bigint(20) unsigned NOT NULL,
  `emi_date` date NOT NULL,
  `payment_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_account_id` bigint(20) unsigned DEFAULT NULL,
  `emi_no` int(11) NOT NULL,
  `emi_amount` decimal(13,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bank_loan_transactions_bank_loan_id_foreign` (`bank_loan_id`),
  CONSTRAINT `bank_loan_transactions_bank_loan_id_foreign` FOREIGN KEY (`bank_loan_id`) REFERENCES `bank_loans` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `bank_loan_transactions` */

insert  into `bank_loan_transactions`(`id`,`bank_loan_id`,`emi_date`,`payment_type`,`bank_account_id`,`emi_no`,`emi_amount`,`created_at`,`updated_at`) values 
(1,1,'2021-06-04','cash',1,1,5000.0000,'2021-06-18 03:01:27','2021-06-18 03:01:27'),
(2,1,'2021-06-06','cash',1,2,5000.0000,'2021-06-18 03:01:55','2021-06-18 03:01:55'),
(3,1,'2021-06-09','cash',1,3,5000.0000,'2021-06-18 03:02:33','2021-06-18 03:02:33'),
(4,2,'2021-05-08','cash',2,1,13000.0000,'2021-06-18 03:05:25','2021-06-18 03:05:25'),
(5,2,'2021-06-01','cheque',1,2,13000.0000,'2021-06-18 03:06:59','2021-06-18 03:06:59');

/*Table structure for table `bank_loans` */

DROP TABLE IF EXISTS `bank_loans`;

CREATE TABLE `bank_loans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `bank_id` bigint(20) unsigned NOT NULL,
  `branch_id` bigint(20) unsigned NOT NULL,
  `account_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `loan_date` date NOT NULL,
  `loan_amount` decimal(13,4) NOT NULL,
  `emi_amount` decimal(13,4) NOT NULL,
  `total_emi` int(11) NOT NULL,
  `emi_given` int(11) NOT NULL DEFAULT 0,
  `total_paid` decimal(13,4) NOT NULL DEFAULT 0.0000,
  `is_paid` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=Pending,1=Paid',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bank_loans_bank_id_foreign` (`bank_id`),
  KEY `bank_loans_branch_id_foreign` (`branch_id`),
  CONSTRAINT `bank_loans_bank_id_foreign` FOREIGN KEY (`bank_id`) REFERENCES `banks` (`id`) ON DELETE CASCADE,
  CONSTRAINT `bank_loans_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `bank_branches` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `bank_loans` */

insert  into `bank_loans`(`id`,`user_id`,`bank_id`,`branch_id`,`account_type`,`account_name`,`account_number`,`loan_date`,`loan_amount`,`emi_amount`,`total_emi`,`emi_given`,`total_paid`,`is_paid`,`created_at`,`updated_at`) values 
(1,1,3,2,'Savings','Imran Hossain','123456','2021-06-03',50000.0000,5000.0000,12,3,15000.0000,0,'2021-06-03 11:24:24','2021-06-18 03:02:33'),
(2,1,1,3,'Current','Adib Hossain','123456','2021-04-01',60000.0000,13000.0000,5,2,26000.0000,0,'2021-06-18 03:05:02','2021-06-18 03:06:59');

/*Table structure for table `banks` */

DROP TABLE IF EXISTS `banks`;

CREATE TABLE `banks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `banks_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `banks` */

insert  into `banks`(`id`,`name`,`slug`,`phone`,`address`,`created_at`,`updated_at`) values 
(1,'Dhaka Bank','dhaka-bank','01711111111','Dhaka','2021-06-03 11:19:01','2021-06-03 11:19:01'),
(2,'Prime Bank','prime-bank','01911111111','Dhaka','2021-06-03 11:19:19','2021-06-03 11:19:19'),
(3,'City Bank','city-bank','01911111111','Dhaka','2021-06-03 11:19:44','2021-06-03 11:19:44');

/*Table structure for table `cashes` */

DROP TABLE IF EXISTS `cashes`;

CREATE TABLE `cashes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `income` decimal(13,4) NOT NULL DEFAULT 0.0000,
  `expense` decimal(13,4) NOT NULL DEFAULT 0.0000,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `cashes` */

insert  into `cashes`(`id`,`date`,`description`,`income`,`expense`,`created_at`,`updated_at`) values 
(2,'2021-06-03','Sold Product of Invoice No INV-202106030001',20000.0000,0.0000,'2021-06-03 11:35:30','2021-06-03 11:35:30'),
(3,'2021-06-03','Taken Due Payment of INV-202106030001 From Mr. Ashik',3000.0000,0.0000,'2021-06-03 13:05:10','2021-06-03 13:05:10'),
(4,'2021-06-03','Taken Due Payment of INV-202106030002 From Mr. John',5500.0000,0.0000,'2021-06-03 13:06:48','2021-06-03 13:06:48'),
(7,'2021-06-04','Return Product from Customer',0.0000,3000.0000,'2021-06-04 00:53:00','2021-06-04 00:53:00'),
(8,'2021-06-04','Return Product of Invoice No INV-202106030002',0.0000,3000.0000,'2021-06-04 00:54:37','2021-06-04 00:54:37'),
(9,'2021-06-04','Return Product from Mr. Ashik of Beximco',0.0000,1000.0000,'2021-06-04 01:11:05','2021-06-04 01:11:05'),
(10,'2021-06-05','Taken Due Payment of INV-202106030001 From Mr. Ashik',1000.0000,0.0000,'2021-06-05 08:12:15','2021-06-05 08:12:15'),
(11,'2021-06-05','Given Payment To Mr. Ashik',0.0000,20000.0000,'2021-06-05 08:14:42','2021-06-05 08:14:42'),
(12,'2021-06-05','Given Payment To Mr. Ashik of Car Bazar',0.0000,1000.0000,'2021-06-05 08:43:32','2021-06-05 08:43:32'),
(13,'2021-06-05','Taken Due Payment of INV-202106030001 From Mr. Ashik of Beximco',30000.0000,0.0000,'2021-06-05 08:47:40','2021-06-05 08:47:40'),
(14,'2021-06-05','Purchased Product of Purchase No P-2021060501',0.0000,7000.0000,'2021-06-05 14:29:39','2021-06-05 14:29:39'),
(15,'2021-06-05','Given Payment of P-2021060502 to Mr. Kamal of Hatil',0.0000,500.0000,'2021-06-05 15:10:15','2021-06-05 15:10:15'),
(16,'2021-06-05','Sold Product of Invoice No INV-202106050001',50000.0000,0.0000,'2021-06-05 15:14:34','2021-06-05 15:14:34'),
(17,'2021-06-05','Given Payment of Purchase No P-2021060501 to Mr. Jamal of Gadget & Gear',0.0000,2000.0000,'2021-06-05 15:18:24','2021-06-05 15:18:24'),
(18,'2021-06-05','Given Payment To Mr. Kamal of Hatil',0.0000,5000.0000,'2021-06-05 15:22:02','2021-06-05 15:22:02'),
(25,'2021-06-06','Sold Product of Invoice No INV-202106060001',30000.0000,0.0000,'2021-06-06 01:14:44','2021-06-06 01:14:44'),
(26,'2021-06-14','Given Advance Salary to Employee Imran Hossain',0.0000,5000.0000,'2021-06-13 20:00:53','2021-06-13 20:00:53'),
(27,'2021-06-14','Given Bonus Salary to Employee: Mark Zukarbarg',0.0000,1000.0000,'2021-06-13 21:00:40','2021-06-13 21:00:40'),
(28,'2021-06-14','Given Bonus Salary for April, 2021 to Employee: Mark Zukarbarg',0.0000,1000.0000,'2021-06-13 21:29:06','2021-06-13 21:29:06'),
(29,'2021-06-14','Given Salary for June, 2021 to Employee: Imran Hossain',0.0000,4000.0000,'2021-06-13 22:28:02','2021-06-13 22:28:02'),
(30,'2021-06-14','Given Salary for June, 2021 to Employee: Imran Hossain',0.0000,3000.0000,'2021-06-13 22:38:47','2021-06-13 22:38:47'),
(31,'2021-06-14','Given Salary for July, 2021 to Employee: Imran Hossain',0.0000,5000.0000,'2021-06-13 22:43:49','2021-06-13 22:43:49'),
(33,'2021-06-14','Given Advance Salary to Employee: Bill Gates',0.0000,5000.0000,'2021-06-14 03:02:30','2021-06-14 03:02:30'),
(34,'2021-06-14','Given Salary for June, 2021 to Employee: Bill Gates',0.0000,6000.0000,'2021-06-14 03:59:40','2021-06-14 03:59:40'),
(35,'2021-06-14','Given Salary for June, 2021 to Employee: Bill Gates',0.0000,4000.0000,'2021-06-14 04:01:09','2021-06-14 04:01:09'),
(36,'2021-06-05','Sold Product of Invoice No INV-202106050002',13000.0000,0.0000,'2021-06-16 02:47:05','2021-06-16 02:47:05'),
(37,'2021-06-17','Return Product RT-8 from Mr. Ashik of Beximco',0.0000,30000.0000,'2021-06-16 20:26:34','2021-06-16 20:26:34'),
(38,'2021-06-05','checking...',0.0000,5000.0000,NULL,NULL),
(39,'2021-06-05','checking 2',5000.0000,0.0000,NULL,NULL),
(40,'2021-06-17','Sold Product of Invoice No INV-202106170001',14000.0000,0.0000,'2021-06-17 17:32:43','2021-06-17 17:32:43'),
(41,'2021-06-10','ProprietorMazhar Deposited to Cash',5000.0000,0.0000,'2021-06-17 22:31:58','2021-06-17 22:31:58'),
(42,'2021-06-02','ProprietorMazhar Withdrawn from Cash for: Car Oil',0.0000,2000.0000,'2021-06-17 22:32:31','2021-06-17 22:32:31'),
(43,'2021-06-09','ProprietorMazhar Withdrawn from Cash for: Shopping',0.0000,3000.0000,'2021-06-17 22:33:38','2021-06-17 22:33:38'),
(44,'2021-06-01','ProprietorMazhar Withdrawn from Cash for: House Rent',0.0000,15000.0000,'2021-06-17 22:34:08','2021-06-17 22:34:08'),
(45,'2021-06-10','ProprietorImran Hossain Withdrawn from Cash for: Birthday Party',0.0000,5000.0000,'2021-06-17 22:35:06','2021-06-17 22:35:06'),
(46,'2021-06-05','ProprietorImran Hossain Withdrawn from Cash for: Launch',0.0000,2000.0000,'2021-06-17 22:35:36','2021-06-17 22:35:36'),
(47,'2021-06-12','ProprietorImran Hossain Withdrawn from Cash for: Paper Bill',0.0000,500.0000,'2021-06-17 22:36:06','2021-06-17 22:36:06'),
(48,'2021-06-14','ProprietorImran Hossain Withdrawn from Cash for: Mobile Recharge',0.0000,1200.0000,'2021-06-17 22:36:42','2021-06-17 22:36:42'),
(49,'2021-06-02','Cost for: Paper Bill',0.0000,200.0000,'2021-06-17 23:32:13','2021-06-17 23:32:13'),
(50,'2021-06-05','Cost for: Internet Bill',0.0000,500.0000,'2021-06-17 23:33:07','2021-06-17 23:33:07'),
(51,'2021-06-09','Cost for: Current Bill',0.0000,1700.0000,'2021-06-17 23:33:59','2021-06-17 23:33:59'),
(52,'2021-06-15','Cost for: Refreshment',0.0000,150.0000,'2021-06-17 23:34:49','2021-06-17 23:34:49'),
(53,'2021-06-01','Cost for: Charity',0.0000,300.0000,'2021-06-17 23:36:44','2021-06-17 23:36:44'),
(54,'2021-06-04','Given Bank Loan EMI To Account No 123456 of City Bank',0.0000,5000.0000,'2021-06-18 03:01:27','2021-06-18 03:01:27'),
(55,'2021-06-06','Given Bank Loan EMI To Account No 123456 of City Bank',0.0000,5000.0000,'2021-06-18 03:01:55','2021-06-18 03:01:55'),
(56,'2021-06-09','Given Bank Loan EMI To Account No 123456 of City Bank',0.0000,5000.0000,'2021-06-18 03:02:33','2021-06-18 03:02:33'),
(57,'2021-05-08','Given Bank Loan EMI To Account No 123456 of Dhaka Bank',0.0000,13000.0000,'2021-06-18 03:05:25','2021-06-18 03:05:25'),
(58,'2021-06-18','Given Advance Salary to Employee: Mark Zukarbarg',0.0000,2000.0000,'2021-06-18 03:46:36','2021-06-18 03:46:36'),
(59,'2021-06-19','Sold Product of Invoice No INV-202106190001',5000.0000,0.0000,'2021-06-19 02:31:23','2021-06-19 02:31:23');

/*Table structure for table `categories` */

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `categories` */

insert  into `categories`(`id`,`name`,`slug`,`created_at`,`updated_at`) values 
(1,'Vehicle','vehicle','2021-06-03 11:00:27','2021-06-03 11:00:27'),
(2,'Furniture','furniture','2021-06-03 11:00:39','2021-06-03 11:00:39'),
(3,'Electronics','electronics','2021-06-03 11:00:48','2021-06-03 11:00:48');

/*Table structure for table `creditor_payments` */

DROP TABLE IF EXISTS `creditor_payments`;

CREATE TABLE `creditor_payments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `creditor_id` bigint(20) unsigned NOT NULL,
  `payment_date` date NOT NULL,
  `payment_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_account_id` bigint(20) unsigned DEFAULT NULL,
  `paid` decimal(13,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `creditor_payments_creditor_id_foreign` (`creditor_id`),
  CONSTRAINT `creditor_payments_creditor_id_foreign` FOREIGN KEY (`creditor_id`) REFERENCES `creditors` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `creditor_payments` */

insert  into `creditor_payments`(`id`,`creditor_id`,`payment_date`,`payment_type`,`bank_account_id`,`paid`,`created_at`,`updated_at`) values 
(1,3,'2021-06-05','cash',NULL,500.0000,'2021-06-05 15:10:15','2021-06-05 15:10:15'),
(2,2,'2021-06-05','cash',NULL,2000.0000,'2021-06-05 15:18:24','2021-06-05 15:18:24'),
(3,2,'2021-06-05','cheque',1,1000.0000,'2021-06-05 15:20:54','2021-06-05 15:20:54'),
(4,4,'2021-06-05','cash',NULL,5000.0000,'2021-06-05 15:22:02','2021-06-05 15:22:02'),
(5,15,'2021-06-19','cheque',1,2000.0000,'2021-06-19 13:11:00','2021-06-19 13:11:00');

/*Table structure for table `creditors` */

DROP TABLE IF EXISTS `creditors`;

CREATE TABLE `creditors` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `supplier_id` bigint(20) unsigned NOT NULL,
  `purchase_id` bigint(20) unsigned DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `credit_date` date NOT NULL,
  `credit_amount` decimal(13,4) NOT NULL,
  `paid` decimal(13,4) NOT NULL DEFAULT 0.0000,
  `consession` decimal(13,4) NOT NULL DEFAULT 0.0000,
  `due` decimal(13,4) NOT NULL,
  `is_paid` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=Pending,1=Paid',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `creditors_purchase_id_foreign` (`purchase_id`),
  CONSTRAINT `creditors_purchase_id_foreign` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `creditors` */

insert  into `creditors`(`id`,`supplier_id`,`purchase_id`,`description`,`credit_date`,`credit_amount`,`paid`,`consession`,`due`,`is_paid`,`created_at`,`updated_at`) values 
(2,2,3,'P-2021060501','2021-06-05',3800.0000,3000.0000,0.0000,800.0000,0,'2021-06-05 14:29:39','2021-06-05 15:20:54'),
(3,1,4,'P-2021060502','2021-06-05',500.0000,500.0000,0.0000,0.0000,1,'2021-06-05 14:47:37','2021-06-05 15:10:15'),
(4,1,NULL,'took loan','2021-06-05',20000.0000,5000.0000,0.0000,15000.0000,0,'2021-06-05 15:17:52','2021-06-05 15:22:02'),
(14,1,14,'P-2021060601','2021-06-06',12000.0000,0.0000,0.0000,12000.0000,0,'2021-06-05 23:05:57','2021-06-05 23:05:57'),
(15,5,NULL,'Bought Medicine','2021-01-16',2000.0000,2000.0000,0.0000,0.0000,1,'2021-06-16 06:01:44','2021-06-19 13:11:00');

/*Table structure for table `customers` */

DROP TABLE IF EXISTS `customers`;

CREATE TABLE `customers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `organization` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customers_organization_unique` (`organization`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `customers` */

insert  into `customers`(`id`,`name`,`organization`,`phone`,`address`,`created_at`,`updated_at`) values 
(1,'Mr. John','Market','01911111111','Motijhil, Dhaka','2021-06-03 11:08:07','2021-06-03 11:08:07'),
(2,'Mr. Ashik','Beximco','01711111111','Dhanmondi, Dhaka','2021-06-03 11:08:52','2021-06-03 11:08:52'),
(3,'Take Away Customer','Unknown','01911111111','Dhaka','2021-06-03 11:09:44','2021-06-03 11:09:44');

/*Table structure for table `debtor_payments` */

DROP TABLE IF EXISTS `debtor_payments`;

CREATE TABLE `debtor_payments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `debtor_id` bigint(20) unsigned NOT NULL,
  `payment_date` date NOT NULL,
  `payment_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_account_id` bigint(20) unsigned DEFAULT NULL,
  `paid` decimal(13,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `debtor_payments_debtor_id_foreign` (`debtor_id`),
  CONSTRAINT `debtor_payments_debtor_id_foreign` FOREIGN KEY (`debtor_id`) REFERENCES `debtors` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `debtor_payments` */

insert  into `debtor_payments`(`id`,`debtor_id`,`payment_date`,`payment_type`,`bank_account_id`,`paid`,`created_at`,`updated_at`) values 
(1,2,'2021-06-05','cash',NULL,1000.0000,'2021-06-05 08:12:15','2021-06-05 08:12:15'),
(2,2,'2021-06-05','cash',NULL,1000.0000,'2021-06-05 08:47:40','2021-06-05 08:47:40');

/*Table structure for table `debtors` */

DROP TABLE IF EXISTS `debtors`;

CREATE TABLE `debtors` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint(20) unsigned NOT NULL,
  `invoice_id` bigint(20) unsigned DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `debit_date` date NOT NULL,
  `debit_amount` decimal(13,4) NOT NULL,
  `paid` decimal(13,4) NOT NULL DEFAULT 0.0000,
  `consession` decimal(13,4) NOT NULL DEFAULT 0.0000,
  `due` decimal(13,4) NOT NULL,
  `is_paid` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=Pending,1=Paid',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `debtors_invoice_id_foreign` (`invoice_id`),
  CONSTRAINT `debtors_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `debtors` */

insert  into `debtors`(`id`,`customer_id`,`invoice_id`,`description`,`debit_date`,`debit_amount`,`paid`,`consession`,`due`,`is_paid`,`created_at`,`updated_at`) values 
(2,2,2,'INV-202106030001','2021-06-03',7000.0000,5000.0000,0.0000,2000.0000,0,'2021-06-03 11:35:30','2021-06-05 08:47:40'),
(3,1,3,'INV-202106030002','2021-06-03',6000.0000,5500.0000,500.0000,0.0000,1,'2021-06-03 11:37:13','2021-06-03 13:06:48'),
(4,1,5,'INV-202106060001','2021-06-06',5000.0000,0.0000,0.0000,5000.0000,0,'2021-06-06 01:14:44','2021-06-06 01:14:44'),
(5,1,NULL,'House Rent','2021-04-01',30000.0000,0.0000,0.0000,30000.0000,0,'2021-06-16 06:04:04','2021-06-16 06:04:04');

/*Table structure for table `employee_payments` */

DROP TABLE IF EXISTS `employee_payments`;

CREATE TABLE `employee_payments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` bigint(20) unsigned NOT NULL,
  `year` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `date` date NOT NULL,
  `payment_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_account_id` bigint(20) unsigned DEFAULT NULL,
  `salary` decimal(13,4) NOT NULL DEFAULT 0.0000,
  `advance_deduct` decimal(13,4) NOT NULL DEFAULT 0.0000,
  `bonus` decimal(13,4) NOT NULL DEFAULT 0.0000,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `employee_payments_employee_id_foreign` (`employee_id`),
  CONSTRAINT `employee_payments_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `employee_payments` */

insert  into `employee_payments`(`id`,`employee_id`,`year`,`month`,`date`,`payment_type`,`bank_account_id`,`salary`,`advance_deduct`,`bonus`,`created_at`,`updated_at`) values 
(1,2,2021,6,'2021-06-14','cash',NULL,0.0000,0.0000,1000.0000,'2021-06-13 21:00:40','2021-06-13 21:00:40'),
(3,2,2021,4,'2021-06-14','cash',NULL,0.0000,0.0000,1000.0000,'2021-06-13 21:29:06','2021-06-13 21:29:06'),
(13,3,2021,6,'2021-06-14','cash',NULL,6000.0000,0.0000,0.0000,'2021-06-14 03:59:40','2021-06-14 03:59:40'),
(14,3,2021,6,'2021-06-14','cash',NULL,4000.0000,2000.0000,0.0000,'2021-06-14 04:01:09','2021-06-14 04:01:09'),
(15,3,2021,6,'2021-06-14','cheque',3,0.0000,3000.0000,0.0000,'2021-06-14 04:01:57','2021-06-14 04:01:57');

/*Table structure for table `employees` */

DROP TABLE IF EXISTS `employees`;

CREATE TABLE `employees` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `designation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default.png',
  `advance` decimal(13,4) NOT NULL DEFAULT 0.0000,
  `advance_date` date DEFAULT NULL,
  `salary` decimal(13,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `employees` */

insert  into `employees`(`id`,`name`,`designation`,`address`,`phone`,`image`,`advance`,`advance_date`,`salary`,`created_at`,`updated_at`) values 
(2,'Mark Zukarbarg','Peon','keranigonj','01911111111','mark-zukarbarg-2021-06-13-60c6547eb77a9.png',5000.0000,'2021-06-18',5000.0000,'2021-06-13 18:54:54','2021-06-18 03:46:36'),
(3,'Bill Gates','Manager','Dhaka','01712222222','bill-gates-2021-06-13-60c67eb015374.jpg',0.0000,'2021-06-14',15000.0000,'2021-06-13 21:54:56','2021-06-14 04:01:57');

/*Table structure for table `invoice_details` */

DROP TABLE IF EXISTS `invoice_details`;

CREATE TABLE `invoice_details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `invoice_id` bigint(20) unsigned NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `cost` decimal(9,4) NOT NULL,
  `selling_price` decimal(9,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invoice_details_invoice_id_foreign` (`invoice_id`),
  CONSTRAINT `invoice_details_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `invoice_details` */

insert  into `invoice_details`(`id`,`invoice_id`,`product_id`,`quantity`,`cost`,`selling_price`,`created_at`,`updated_at`) values 
(4,2,1,2,1000.0000,2000.0000,'2021-06-03 11:35:30','2021-06-03 11:35:30'),
(5,2,2,1,5000.0000,8000.0000,'2021-06-03 11:35:30','2021-06-03 11:35:30'),
(6,2,4,1,10000.0000,15000.0000,'2021-06-03 11:35:30','2021-06-03 11:35:30'),
(7,3,6,3,500.0000,1000.0000,'2021-06-03 11:37:13','2021-06-03 11:37:13'),
(8,3,7,1,1000.0000,2000.0000,'2021-06-03 11:37:13','2021-06-03 11:37:13'),
(9,3,5,2,5000.0000,8000.0000,'2021-06-03 11:37:13','2021-06-03 11:37:13'),
(10,4,1,3,1000.0000,5000.0000,'2021-06-05 15:14:34','2021-06-05 15:14:34'),
(11,5,1,2,1000.0000,2000.0000,'2021-06-06 01:14:44','2021-06-06 01:14:44'),
(12,5,2,1,4493.1556,5000.0000,'2021-06-06 01:14:44','2021-06-06 01:14:44'),
(13,5,3,1,2000.0000,3000.0000,'2021-06-06 01:14:44','2021-06-06 01:14:44'),
(14,5,8,2,1000.0000,1500.0000,'2021-06-06 01:14:44','2021-06-06 01:14:44'),
(15,5,6,2,500.0000,1000.0000,'2021-06-06 01:14:44','2021-06-06 01:14:44'),
(16,5,4,2,10000.0000,7000.0000,'2021-06-06 01:14:44','2021-06-06 01:14:44'),
(17,5,7,1,1000.0000,4000.0000,'2021-06-06 01:14:44','2021-06-06 01:14:44'),
(18,6,1,2,1000.0000,1500.0000,'2021-06-16 02:47:05','2021-06-16 02:47:05'),
(19,6,2,2,4493.1556,5000.0000,'2021-06-16 02:47:05','2021-06-16 02:47:05'),
(20,7,6,3,500.0000,700.0000,'2021-06-17 17:32:43','2021-06-17 17:32:43'),
(21,7,4,1,10000.0000,12000.0000,'2021-06-17 17:32:43','2021-06-17 17:32:43'),
(22,8,3,1,2000.0000,5000.0000,'2021-06-19 02:31:23','2021-06-19 02:31:23');

/*Table structure for table `invoices` */

DROP TABLE IF EXISTS `invoices`;

CREATE TABLE `invoices` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `customer_id` bigint(20) unsigned NOT NULL,
  `invoice_no` bigint(20) unsigned NOT NULL,
  `date` date NOT NULL,
  `payment_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_account_id` bigint(20) unsigned DEFAULT NULL,
  `amount` decimal(9,4) NOT NULL,
  `discount` decimal(9,4) NOT NULL DEFAULT 0.0000,
  `total_amount` decimal(9,4) NOT NULL,
  `paid` decimal(9,4) NOT NULL,
  `due` decimal(9,4) NOT NULL,
  `profit` decimal(9,4) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_paid` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=Pending,1=Paid',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `invoices` */

insert  into `invoices`(`id`,`user_id`,`customer_id`,`invoice_no`,`date`,`payment_type`,`bank_account_id`,`amount`,`discount`,`total_amount`,`paid`,`due`,`profit`,`description`,`is_paid`,`created_at`,`updated_at`) values 
(2,1,2,202106030001,'2021-05-03','cash',NULL,27000.0000,0.0000,27000.0000,25000.0000,2000.0000,10000.0000,'cashh',0,'2021-06-03 11:35:30','2021-06-05 08:47:40'),
(3,1,1,202106030002,'2021-06-03','cheque',2,21000.0000,0.0000,21000.0000,20500.0000,0.0000,8000.0000,'chkkkkk',1,'2021-06-03 11:37:13','2021-06-03 13:06:48'),
(4,1,3,202106050001,'2021-06-05','cash',NULL,15000.0000,0.0000,15000.0000,15000.0000,0.0000,12000.0000,NULL,1,'2021-06-05 15:14:34','2021-06-05 15:14:34'),
(5,1,1,202106060001,'2021-03-06','cash',NULL,35000.0000,0.0000,35000.0000,30000.0000,5000.0000,12506.8444,'big data',0,'2021-06-06 01:14:44','2021-06-06 01:14:44'),
(6,1,3,202106050002,'2021-06-05','cash',NULL,13000.0000,0.0000,13000.0000,13000.0000,0.0000,2013.6888,NULL,1,'2021-06-16 02:47:05','2021-06-16 02:47:05'),
(7,1,2,202106170001,'2021-04-17','cash',NULL,14100.0000,100.0000,14000.0000,14000.0000,0.0000,2500.0000,'test',1,'2021-06-17 17:32:43','2021-06-17 17:32:43'),
(8,1,3,202106190001,'2021-02-19','cash',NULL,5000.0000,0.0000,5000.0000,5000.0000,0.0000,3000.0000,NULL,1,'2021-06-19 02:31:23','2021-06-19 02:31:23');

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(2,'2014_10_12_100000_create_password_resets_table',1),
(3,'2021_02_08_223444_create_roles_table',1),
(4,'2021_02_13_232642_create_categories_table',1),
(5,'2021_02_14_221055_create_suppliers_table',1),
(6,'2021_02_15_213146_create_products_table',1),
(7,'2021_02_23_030013_create_banks_table',1),
(8,'2021_02_23_042652_create_bank_branches_table',1),
(9,'2021_02_24_000739_create_bank_accounts_table',1),
(10,'2021_02_27_230924_create_invoices_table',1),
(11,'2021_02_28_001925_create_invoice_details_table',1),
(12,'2021_04_02_105055_create_customers_table',1),
(13,'2021_04_20_230914_create_bank_account_transactions_table',1),
(14,'2021_04_21_014840_create_cashes_table',1),
(17,'2021_05_04_203537_create_debtors_table',1),
(19,'2021_05_09_202601_create_office_expenses_table',1),
(20,'2021_05_09_232846_create_proprietors_table',1),
(21,'2021_05_10_010611_create_proprietor_transactions_table',1),
(22,'2021_05_10_023123_create_bank_loans_table',1),
(25,'2021_05_04_203752_create_debtor_payments_table',2),
(26,'2021_05_21_024941_create_bank_loan_transactions_table',2),
(30,'2021_06_03_145109_create_return_products_table',3),
(31,'2021_06_03_193114_create_return_product_details_table',3),
(34,'2021_06_05_090353_create_purchases_table',5),
(36,'2021_06_05_090636_create_purchase_details_table',6),
(37,'2021_05_01_200040_create_creditors_table',7),
(38,'2021_05_03_013829_create_creditor_payments_table',7),
(40,'2021_06_09_104235_create_employees_table',8),
(41,'2021_06_13_183640_create_employee_payments_table',8),
(43,'2014_10_12_000000_create_users_table',9);

/*Table structure for table `office_expenses` */

DROP TABLE IF EXISTS `office_expenses`;

CREATE TABLE `office_expenses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expense` decimal(13,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `office_expenses` */

insert  into `office_expenses`(`id`,`date`,`description`,`expense`,`created_at`,`updated_at`) values 
(1,'2021-06-02','Cost for: Paper Bill',200.0000,'2021-06-17 23:32:13','2021-06-17 23:32:13'),
(2,'2021-06-05','Cost for: Internet Bill',500.0000,'2021-06-17 23:33:07','2021-06-17 23:33:07'),
(3,'2021-06-09','Cost for: Current Bill',1700.0000,'2021-06-17 23:33:59','2021-06-17 23:33:59'),
(4,'2021-06-15','Cost for: Refreshment',150.0000,'2021-06-17 23:34:49','2021-06-17 23:34:49'),
(5,'2021-06-01','Cost for: Charity',300.0000,'2021-06-17 23:36:44','2021-06-17 23:36:44');

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_resets` */

/*Table structure for table `products` */

DROP TABLE IF EXISTS `products`;

CREATE TABLE `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint(20) unsigned NOT NULL,
  `supplier_id` bigint(20) unsigned NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `low_quantity_alert` int(11) NOT NULL,
  `price` decimal(13,4) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default.png',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_name_unique` (`name`),
  KEY `products_category_id_foreign` (`category_id`),
  KEY `products_supplier_id_foreign` (`supplier_id`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `products_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `products` */

insert  into `products`(`id`,`name`,`category_id`,`supplier_id`,`slug`,`quantity`,`low_quantity_alert`,`price`,`image`,`created_at`,`updated_at`) values 
(1,'Mobile',3,2,'mobile',17,10,1000.0000,'mobile-2021-06-03-60b8b8b117bea.jpg','2021-06-03 11:10:42','2021-06-16 20:26:34'),
(2,'TV',3,4,'tv',3,10,4493.1556,'tv-2021-06-03-60b8b8ef0205b.png','2021-06-03 11:11:43','2021-06-16 02:47:05'),
(3,'Laptop',3,2,'laptop',19,10,2000.0000,'laptop-2021-06-03-60b8b92d6caac.jpg','2021-06-03 11:12:45','2021-06-19 02:31:23'),
(4,'Car',1,3,'car',16,5,10000.0000,'car-2021-06-03-60b8b95d65e97.jpg','2021-06-03 11:13:33','2021-06-17 17:32:43'),
(5,'Bike',1,3,'bike',20,10,5000.0000,'bike-2021-06-03-60b8b98136039.jpg','2021-06-03 11:14:09','2021-06-04 00:58:40'),
(6,'Chair',2,1,'chair',20,10,500.0000,'chair-2021-06-03-60b8b9b16baeb.jpg','2021-06-03 11:14:57','2021-06-17 17:32:43'),
(7,'Table',2,1,'table',13,5,1000.0000,'table-2021-06-03-60b8ba2f688a6.jpg','2021-06-03 11:17:03','2021-06-06 01:14:44'),
(8,'Speaker',3,2,'speaker',7,5,1000.0000,'speaker-2021-06-05-60bb59de2c5be.jpeg','2021-06-05 11:02:54','2021-06-06 01:14:44');

/*Table structure for table `proprietor_transactions` */

DROP TABLE IF EXISTS `proprietor_transactions`;

CREATE TABLE `proprietor_transactions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `proprietor_id` bigint(20) unsigned NOT NULL,
  `transaction_date` date NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deposite` decimal(13,4) NOT NULL DEFAULT 0.0000,
  `withdraw` decimal(13,4) NOT NULL DEFAULT 0.0000,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `proprietor_transactions_proprietor_id_foreign` (`proprietor_id`),
  CONSTRAINT `proprietor_transactions_proprietor_id_foreign` FOREIGN KEY (`proprietor_id`) REFERENCES `proprietors` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `proprietor_transactions` */

insert  into `proprietor_transactions`(`id`,`proprietor_id`,`transaction_date`,`description`,`deposite`,`withdraw`,`created_at`,`updated_at`) values 
(1,1,'2021-06-10','Proprietor Mazhar Deposited to Cash',5000.0000,0.0000,'2021-06-17 22:31:57','2021-06-17 22:31:57'),
(2,1,'2021-06-02','Proprietor Mazhar Withdrawn from Cash for: Car Oil',0.0000,2000.0000,'2021-06-17 22:32:31','2021-06-17 22:32:31'),
(3,1,'2021-06-09','Proprietor Mazhar Withdrawn from Cash for: Shopping',0.0000,3000.0000,'2021-06-17 22:33:37','2021-06-17 22:33:37'),
(4,1,'2021-06-01','Proprietor Mazhar Withdrawn from Cash for: House Rent',0.0000,15000.0000,'2021-06-17 22:34:08','2021-06-17 22:34:08'),
(5,2,'2021-06-10','Proprietor Imran Hossain Withdrawn from Cash for: Birthday Party',0.0000,5000.0000,'2021-06-17 22:35:06','2021-06-17 22:35:06'),
(6,2,'2021-06-05','Proprietor Imran Hossain Withdrawn from Cash for: Launch',0.0000,2000.0000,'2021-06-17 22:35:36','2021-06-17 22:35:36'),
(7,2,'2021-06-12','Proprietor Imran Hossain Withdrawn from Cash for: Paper Bill',0.0000,500.0000,'2021-06-17 22:36:06','2021-06-17 22:36:06'),
(8,2,'2021-06-14','Proprietor Imran Hossain Withdrawn from Cash for: Mobile Recharge',0.0000,1200.0000,'2021-06-17 22:36:42','2021-06-17 22:36:42');

/*Table structure for table `proprietors` */

DROP TABLE IF EXISTS `proprietors`;

CREATE TABLE `proprietors` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `designation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `proprietors` */

insert  into `proprietors`(`id`,`name`,`designation`,`phone`,`created_at`,`updated_at`) values 
(1,'Mazhar','Managing Director','01711111111','2021-06-03 13:34:55','2021-06-03 13:34:55'),
(2,'Imran Hossain','Operation Director','01911111111','2021-06-17 22:34:33','2021-06-17 22:34:33');

/*Table structure for table `purchase_details` */

DROP TABLE IF EXISTS `purchase_details`;

CREATE TABLE `purchase_details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `purchase_id` bigint(20) unsigned NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `cost` decimal(9,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `purchase_details_purchase_id_foreign` (`purchase_id`),
  CONSTRAINT `purchase_details_purchase_id_foreign` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `purchase_details` */

insert  into `purchase_details`(`id`,`purchase_id`,`product_id`,`quantity`,`cost`,`created_at`,`updated_at`) values 
(2,3,2,1,6000.0000,'2021-06-05 14:29:39','2021-06-05 14:29:39'),
(3,3,8,5,1000.0000,'2021-06-05 14:29:39','2021-06-05 14:29:39'),
(4,4,6,2,500.0000,'2021-06-05 14:47:38','2021-06-05 14:47:38'),
(5,4,8,1,1000.0000,'2021-06-05 14:47:38','2021-06-05 14:47:38'),
(24,14,2,4,4000.0000,'2021-06-05 23:05:57','2021-06-05 23:05:57'),
(25,14,8,3,1000.0000,'2021-06-05 23:05:57','2021-06-05 23:05:57');

/*Table structure for table `purchases` */

DROP TABLE IF EXISTS `purchases`;

CREATE TABLE `purchases` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `supplier_id` bigint(20) unsigned NOT NULL,
  `purchase_no` bigint(20) unsigned NOT NULL,
  `date` date NOT NULL,
  `payment_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_account_id` bigint(20) unsigned DEFAULT NULL,
  `amount` decimal(9,4) NOT NULL,
  `discount` decimal(9,4) NOT NULL DEFAULT 0.0000,
  `total_amount` decimal(9,4) NOT NULL,
  `paid` decimal(9,4) NOT NULL,
  `due` decimal(9,4) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_paid` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=Pending,1=Paid',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `purchases` */

insert  into `purchases`(`id`,`user_id`,`supplier_id`,`purchase_no`,`date`,`payment_type`,`bank_account_id`,`amount`,`discount`,`total_amount`,`paid`,`due`,`description`,`is_paid`,`created_at`,`updated_at`) values 
(3,1,2,2021060501,'2021-06-05','cash',NULL,11000.0000,200.0000,10800.0000,10000.0000,800.0000,'first',0,'2021-06-05 14:29:39','2021-06-05 15:20:54'),
(4,1,1,2021060502,'2021-06-05','cheque',1,2000.0000,0.0000,2000.0000,2000.0000,0.0000,'cheque',1,'2021-06-05 14:47:37','2021-06-05 15:10:15'),
(14,1,1,2021060601,'2021-06-06','cheque',3,19000.0000,0.0000,19000.0000,7000.0000,12000.0000,NULL,0,'2021-06-05 23:05:57','2021-06-05 23:05:57');

/*Table structure for table `return_product_details` */

DROP TABLE IF EXISTS `return_product_details`;

CREATE TABLE `return_product_details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `return_product_id` bigint(20) unsigned NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(9,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `return_product_details_return_product_id_foreign` (`return_product_id`),
  CONSTRAINT `return_product_details_return_product_id_foreign` FOREIGN KEY (`return_product_id`) REFERENCES `return_products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `return_product_details` */

insert  into `return_product_details`(`id`,`return_product_id`,`product_id`,`quantity`,`price`,`created_at`,`updated_at`) values 
(1,1,6,2,500.0000,'2021-06-04 00:53:00','2021-06-04 00:53:00'),
(2,1,7,2,1000.0000,'2021-06-04 00:53:00','2021-06-04 00:53:00'),
(3,2,6,2,500.0000,'2021-06-04 00:54:37','2021-06-04 00:54:37'),
(4,2,7,2,1000.0000,'2021-06-04 00:54:37','2021-06-04 00:54:37'),
(5,3,4,2,10000.0000,'2021-06-04 00:58:40','2021-06-04 00:58:40'),
(6,3,5,1,5000.0000,'2021-06-04 00:58:40','2021-06-04 00:58:40'),
(7,4,1,1,1000.0000,'2021-06-04 01:11:05','2021-06-04 01:11:05'),
(8,5,2,1,5000.0000,'2021-06-04 01:13:15','2021-06-04 01:13:15'),
(9,5,3,1,3000.0000,'2021-06-04 01:13:15','2021-06-04 01:13:15'),
(12,8,1,3,2000.0000,'2021-06-16 20:26:34','2021-06-16 20:26:34'),
(13,8,4,2,12000.0000,'2021-06-16 20:26:34','2021-06-16 20:26:34');

/*Table structure for table `return_products` */

DROP TABLE IF EXISTS `return_products`;

CREATE TABLE `return_products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `customer_id` bigint(20) unsigned NOT NULL,
  `invoice_id` bigint(20) unsigned DEFAULT NULL,
  `date` date NOT NULL,
  `payment_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_account_id` bigint(20) unsigned DEFAULT NULL,
  `amount` decimal(9,4) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `return_products` */

insert  into `return_products`(`id`,`user_id`,`customer_id`,`invoice_id`,`date`,`payment_type`,`bank_account_id`,`amount`,`description`,`created_at`,`updated_at`) values 
(1,1,2,NULL,'2021-06-04','cash',NULL,3000.0000,NULL,'2021-06-04 00:53:00','2021-06-04 00:53:00'),
(2,1,1,3,'2021-06-04','cash',NULL,3000.0000,NULL,'2021-06-04 00:54:37','2021-06-04 00:54:37'),
(3,1,2,NULL,'2021-06-04','cheque',2,25000.0000,NULL,'2021-06-04 00:58:40','2021-06-04 00:58:40'),
(4,1,2,NULL,'2021-06-04','cash',NULL,1000.0000,NULL,'2021-06-04 01:11:05','2021-06-04 01:11:05'),
(5,1,1,2,'2021-06-04','cheque',1,8000.0000,NULL,'2021-06-04 01:13:15','2021-06-04 01:13:15'),
(8,1,2,NULL,'2021-06-17','cash',NULL,30000.0000,NULL,'2021-06-16 20:26:34','2021-06-16 20:26:34');

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `roles` */

insert  into `roles`(`id`,`name`,`slug`,`created_at`,`updated_at`) values 
(1,'Admin','admin',NULL,NULL),
(2,'User','user',NULL,NULL);

/*Table structure for table `suppliers` */

DROP TABLE IF EXISTS `suppliers`;

CREATE TABLE `suppliers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `organization` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `suppliers_organization_unique` (`organization`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `suppliers` */

insert  into `suppliers`(`id`,`name`,`organization`,`slug`,`phone`,`address`,`created_at`,`updated_at`) values 
(1,'Mr. Kamal','Hatil','hatil','01711111111','Dhaka','2021-06-03 11:03:18','2021-06-03 11:03:18'),
(2,'Mr. Jamal','Gadget & Gear','gadget-gear','01911111111','Dhaka','2021-06-03 11:03:48','2021-06-03 11:03:48'),
(3,'Mr. Ashik','Car Bazar','car-bazar','01712222222','Dhaka','2021-06-03 11:05:28','2021-06-03 11:05:28'),
(4,'Mr. Karim','Rangs','rangs','01712222222','Dhaka','2021-06-03 11:06:53','2021-06-03 11:06:53'),
(5,'Mr. Hossain','Square','square','01712222222','Dhaka','2021-06-04 03:22:14','2021-06-04 03:22:14');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default.png',
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`role_id`,`name`,`email`,`email_verified_at`,`password`,`image`,`phone`,`address`,`remember_token`,`created_at`,`updated_at`) values 
(1,1,'Admin','admin@admin.com',NULL,'$2y$10$DefAPWMi9mk24B6zYlzRP.S0wYv./BYSIvIl4Bu7dd7MYOU2l/D4u','default.png','01711111111','Noorjahan road Mohammmaddpur dhaka 1207',NULL,NULL,'2021-06-22 08:14:10'),
(2,2,'User','user@user.com',NULL,'$2y$10$OsA81gFwSYSWI8THR99hwu7EgtGnmGRjw0Ov4QnBjpLxtHphvE14C','default.png',NULL,NULL,NULL,NULL,NULL),
(4,2,'Adib','adib@gmail.com',NULL,'$2y$10$yhubrCaCryv4lHZTA7u9TeDL/wEf2l4Kp1.dRqgDnZlTkOCEoBCcW','default.png',NULL,NULL,NULL,'2021-06-22 08:01:19','2021-06-22 08:01:19');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
