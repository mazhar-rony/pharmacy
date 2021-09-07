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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `bank_account_transactions` */

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `bank_accounts` */

insert  into `bank_accounts`(`id`,`user_id`,`bank_id`,`branch_id`,`account_type`,`account_name`,`account_number`,`balance`,`created_at`,`updated_at`) values 
(1,2,1,1,'Current','Imran Hossain','123456',200000.0000,'2021-09-07 23:27:18','2021-09-07 23:27:18'),
(2,2,2,2,'Current','Adib Hossain','654321',100000.0000,'2021-09-07 23:27:51','2021-09-07 23:27:51');

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
(1,1,'Gulshan Branch','gulshan-branch','01911111111','Dhaka','Gulshan','Gulshan 2','2021-09-07 23:24:04','2021-09-07 23:24:04'),
(2,2,'Uttara Branch','uttara-branch','01911111111','Dhaka','Uttara','House Building','2021-09-07 23:24:46','2021-09-07 23:24:46'),
(3,3,'Main Branch','main-branch','01911111111','Dhaka','Motijhil','Motijhil','2021-09-07 23:25:37','2021-09-07 23:25:37'),
(4,1,'Dhanmondi Branch','dhanmondi-branch','01712222222','Dhaka','Dhanmondi','dhanmondi','2021-09-07 23:26:26','2021-09-07 23:26:26');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `bank_loan_transactions` */

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `bank_loans` */

insert  into `bank_loans`(`id`,`user_id`,`bank_id`,`branch_id`,`account_type`,`account_name`,`account_number`,`loan_date`,`loan_amount`,`emi_amount`,`total_emi`,`emi_given`,`total_paid`,`is_paid`,`created_at`,`updated_at`) values 
(1,2,3,3,'Current','Imran Hossain','123','2021-01-07',50000.0000,4000.0000,15,0,0.0000,0,'2021-09-07 23:29:26','2021-09-07 23:29:26');

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
(1,'Dhaka Bank','dhaka-bank','01711111111','Dhaka','2021-09-07 23:22:38','2021-09-07 23:22:38'),
(2,'Prime Bank','prime-bank','01711111111','Dhaka','2021-09-07 23:22:52','2021-09-07 23:22:52'),
(3,'Sonali Bank','sonali-bank','01711111111','Dhaka','2021-09-07 23:23:13','2021-09-07 23:23:13');

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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `cashes` */

insert  into `cashes`(`id`,`date`,`description`,`income`,`expense`,`created_at`,`updated_at`) values 
(1,'2021-01-02','Proprietor Imran Hossain Deposited to Cash',200000.0000,0.0000,'2021-09-07 23:05:27','2021-09-07 23:05:27'),
(2,'2021-01-03','Proprietor Adib Hossain Deposited to Cash',100000.0000,0.0000,'2021-09-07 23:05:52','2021-09-07 23:05:52'),
(3,'2021-02-01','Purchased Product of Purchase No P-2021020101',0.0000,52500.0000,'2021-09-08 00:26:41','2021-09-08 00:26:41'),
(4,'2021-02-17','Purchased Product of Purchase No P-2021021701',0.0000,100000.0000,'2021-09-08 00:32:12','2021-09-08 00:32:12'),
(5,'2021-04-08','Purchased Product of Purchase No P-2021040801',0.0000,30000.0000,'2021-09-08 00:33:40','2021-09-08 00:33:40'),
(6,'2021-09-08','Given Payment of Purchase No P-2021040801 to Mr. Ahmed of Hatil',0.0000,4000.0000,'2021-09-08 00:34:52','2021-09-08 00:34:52'),
(7,'2021-01-17','Sold Product of Invoice No INV-202101170001',5000.0000,0.0000,'2021-09-08 00:39:35','2021-09-08 00:39:35'),
(8,'2021-03-09','Sold Product of Invoice No INV-202103090001',5500.0000,0.0000,'2021-09-08 00:40:59','2021-09-08 00:40:59'),
(9,'2021-03-10','Sold Product of Invoice No INV-202103100001',8000.0000,0.0000,'2021-09-08 00:42:09','2021-09-08 00:42:09'),
(10,'2021-02-14','Sold Product of Invoice No INV-202102140001',4000.0000,0.0000,'2021-09-08 00:43:45','2021-09-08 00:43:45'),
(11,'2021-04-14','Sold Product of Invoice No INV-202104140001',10000.0000,0.0000,'2021-09-08 00:44:57','2021-09-08 00:44:57'),
(12,'2021-05-08','Sold Product of Invoice No INV-202105080001',5000.0000,0.0000,'2021-09-08 00:46:50','2021-09-08 00:46:50'),
(13,'2021-06-15','Sold Product of Invoice No INV-202106150001',13000.0000,0.0000,'2021-09-08 00:48:17','2021-09-08 00:48:17'),
(14,'2021-07-15','Sold Product of Invoice No INV-202107150001',8000.0000,0.0000,'2021-09-08 00:50:31','2021-09-08 00:50:31'),
(15,'2021-08-10','Sold Product of Invoice No INV-202108100001',10000.0000,0.0000,'2021-09-08 00:52:16','2021-09-08 00:52:16'),
(16,'2021-09-08','Taken Due Payment of Invoice No INV-202108100001 From Mr. Ashik of Market',3000.0000,0.0000,'2021-09-08 00:54:06','2021-09-08 00:54:06'),
(17,'2021-02-10','Purchased Product of Purchase No P-2021021001',0.0000,54000.0000,'2021-09-08 00:55:58','2021-09-08 00:55:58'),
(18,'2021-01-08','Given Advance Salary to Employee: Tanvir',0.0000,10000.0000,'2021-09-08 00:57:08','2021-09-08 00:57:08'),
(19,'2021-03-01','Given Salary for February, 2021 to Employee: Tanvir',0.0000,15000.0000,'2021-09-08 00:58:24','2021-09-08 00:58:24'),
(20,'2021-03-01','Given Salary for February, 2021 to Employee: Tomal',0.0000,10000.0000,'2021-09-08 01:02:54','2021-09-08 01:02:54');

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
(1,'Electronics','electronics','2021-09-07 23:00:28','2021-09-07 23:00:28'),
(2,'Vehicle','vehicle','2021-09-07 23:00:39','2021-09-07 23:00:39'),
(3,'Furniture','furniture','2021-09-07 23:00:51','2021-09-07 23:00:51');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `creditor_payments` */

insert  into `creditor_payments`(`id`,`creditor_id`,`payment_date`,`payment_type`,`bank_account_id`,`paid`,`created_at`,`updated_at`) values 
(1,1,'2021-09-08','cash',NULL,4000.0000,'2021-09-08 00:34:52','2021-09-08 00:34:52');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `creditors` */

insert  into `creditors`(`id`,`supplier_id`,`purchase_id`,`description`,`credit_date`,`credit_amount`,`paid`,`consession`,`due`,`is_paid`,`created_at`,`updated_at`) values 
(1,4,3,'P-2021040801','2021-04-08',7500.0000,4000.0000,0.0000,3500.0000,0,'2021-09-08 00:33:40','2021-09-08 00:34:52');

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
(1,'Mr. Ashik','Market','01711111111','Dhaka','2021-09-07 23:14:03','2021-09-07 23:14:03'),
(2,'Mr. John','Save the Children','01711111111','Dhaka','2021-09-07 23:14:47','2021-09-07 23:14:47'),
(3,'Mr. Hossain','Unknown','01711111111','Dhaka','2021-09-07 23:15:30','2021-09-07 23:15:30');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `debtor_payments` */

insert  into `debtor_payments`(`id`,`debtor_id`,`payment_date`,`payment_type`,`bank_account_id`,`paid`,`created_at`,`updated_at`) values 
(1,1,'2021-09-08','cash',NULL,3000.0000,'2021-09-08 00:54:06','2021-09-08 00:54:06');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `debtors` */

insert  into `debtors`(`id`,`customer_id`,`invoice_id`,`description`,`debit_date`,`debit_amount`,`paid`,`consession`,`due`,`is_paid`,`created_at`,`updated_at`) values 
(1,1,9,'INV-202108100001','2021-08-10',5000.0000,3000.0000,0.0000,2000.0000,0,'2021-09-08 00:52:16','2021-09-08 00:54:06');

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `employee_payments` */

insert  into `employee_payments`(`id`,`employee_id`,`year`,`month`,`date`,`payment_type`,`bank_account_id`,`salary`,`advance_deduct`,`bonus`,`created_at`,`updated_at`) values 
(1,1,2021,2,'2021-03-01','cash',NULL,15000.0000,5000.0000,0.0000,'2021-09-08 00:58:24','2021-09-08 00:58:24'),
(2,2,2021,2,'2021-03-01','cash',NULL,10000.0000,0.0000,0.0000,'2021-09-08 01:02:54','2021-09-08 01:02:54');

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `employees` */

insert  into `employees`(`id`,`name`,`designation`,`address`,`phone`,`image`,`advance`,`advance_date`,`salary`,`created_at`,`updated_at`) values 
(1,'Tanvir','Manager','Dhaka','01711111111','tanvir-2021-09-07-61379fb62789a.jpg',5000.0000,'2021-01-08',20000.0000,'2021-09-07 23:17:33','2021-09-08 00:58:24'),
(2,'Tomal','Executive','Dhaka','01711111111','tomal-2021-09-07-61379fa56ef74.jpg',0.0000,NULL,12000.0000,'2021-09-07 23:18:46','2021-09-07 23:21:41');

/*Table structure for table `invoice_details` */

DROP TABLE IF EXISTS `invoice_details`;

CREATE TABLE `invoice_details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `invoice_id` bigint(20) unsigned NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `cost` decimal(13,4) NOT NULL,
  `selling_price` decimal(13,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invoice_details_invoice_id_foreign` (`invoice_id`),
  CONSTRAINT `invoice_details_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `invoice_details` */

insert  into `invoice_details`(`id`,`invoice_id`,`product_id`,`quantity`,`cost`,`selling_price`,`created_at`,`updated_at`) values 
(1,1,1,1,2000.0000,3000.0000,'2021-09-08 00:39:35','2021-09-08 00:39:35'),
(2,1,2,2,500.0000,1000.0000,'2021-09-08 00:39:35','2021-09-08 00:39:35'),
(3,2,7,1,1000.0000,2500.0000,'2021-09-08 00:40:59','2021-09-08 00:40:59'),
(4,2,8,3,500.0000,1000.0000,'2021-09-08 00:40:59','2021-09-08 00:40:59'),
(5,3,5,1,5000.0000,8000.0000,'2021-09-08 00:42:09','2021-09-08 00:42:09'),
(6,4,9,1,1000.0000,2000.0000,'2021-09-08 00:43:45','2021-09-08 00:43:45'),
(7,4,8,2,500.0000,1000.0000,'2021-09-08 00:43:45','2021-09-08 00:43:45'),
(8,5,5,1,5000.0000,10000.0000,'2021-09-08 00:44:57','2021-09-08 00:44:57'),
(9,6,6,1,2000.0000,5000.0000,'2021-09-08 00:46:50','2021-09-08 00:46:50'),
(10,7,5,1,5000.0000,10000.0000,'2021-09-08 00:48:17','2021-09-08 00:48:17'),
(11,7,6,1,2000.0000,3000.0000,'2021-09-08 00:48:17','2021-09-08 00:48:17'),
(12,8,1,2,2000.0000,3000.0000,'2021-09-08 00:50:31','2021-09-08 00:50:31'),
(13,8,2,2,500.0000,1000.0000,'2021-09-08 00:50:31','2021-09-08 00:50:31'),
(14,9,6,3,2000.0000,5000.0000,'2021-09-08 00:52:16','2021-09-08 00:52:16');

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
  `amount` decimal(13,4) NOT NULL,
  `discount` decimal(13,4) NOT NULL DEFAULT 0.0000,
  `total_amount` decimal(13,4) NOT NULL,
  `paid` decimal(13,4) NOT NULL,
  `due` decimal(13,4) NOT NULL,
  `profit` decimal(13,4) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_paid` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=Pending,1=Paid',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `invoices` */

insert  into `invoices`(`id`,`user_id`,`customer_id`,`invoice_no`,`date`,`payment_type`,`bank_account_id`,`amount`,`discount`,`total_amount`,`paid`,`due`,`profit`,`description`,`is_paid`,`created_at`,`updated_at`) values 
(1,2,3,202101170001,'2021-01-17','cash',NULL,5000.0000,0.0000,5000.0000,5000.0000,0.0000,2000.0000,NULL,1,'2021-09-08 00:39:35','2021-09-08 00:39:35'),
(2,2,3,202103090001,'2021-03-09','cash',NULL,5500.0000,0.0000,5500.0000,5500.0000,0.0000,3000.0000,NULL,1,'2021-09-08 00:40:59','2021-09-08 00:40:59'),
(3,2,2,202103100001,'2021-03-10','cash',NULL,8000.0000,0.0000,8000.0000,8000.0000,0.0000,3000.0000,NULL,1,'2021-09-08 00:42:09','2021-09-08 00:42:09'),
(4,2,3,202102140001,'2021-02-14','cash',NULL,4000.0000,0.0000,4000.0000,4000.0000,0.0000,2000.0000,NULL,1,'2021-09-08 00:43:45','2021-09-08 00:43:45'),
(5,2,1,202104140001,'2021-04-14','cash',NULL,10000.0000,0.0000,10000.0000,10000.0000,0.0000,5000.0000,NULL,1,'2021-09-08 00:44:57','2021-09-08 00:44:57'),
(6,2,1,202105080001,'2021-05-08','cash',NULL,5000.0000,0.0000,5000.0000,5000.0000,0.0000,3000.0000,NULL,1,'2021-09-08 00:46:50','2021-09-08 00:46:50'),
(7,2,2,202106150001,'2021-06-15','cash',NULL,13000.0000,0.0000,13000.0000,13000.0000,0.0000,6000.0000,NULL,1,'2021-09-08 00:48:17','2021-09-08 00:48:17'),
(8,2,3,202107150001,'2021-07-15','cash',NULL,8000.0000,0.0000,8000.0000,8000.0000,0.0000,3000.0000,NULL,1,'2021-09-08 00:50:31','2021-09-08 00:50:31'),
(9,2,1,202108100001,'2021-08-10','cash',NULL,15000.0000,0.0000,15000.0000,13000.0000,2000.0000,9000.0000,NULL,0,'2021-09-08 00:52:16','2021-09-08 00:54:06');

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(1,'2014_10_12_000000_create_users_table',1),
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
(15,'2021_05_09_202601_create_office_expenses_table',1),
(16,'2021_05_09_232846_create_proprietors_table',1),
(17,'2021_05_10_010611_create_proprietor_transactions_table',1),
(18,'2021_05_10_023123_create_bank_loans_table',1),
(19,'2021_05_21_024941_create_bank_loan_transactions_table',1),
(20,'2021_06_03_145109_create_return_products_table',1),
(21,'2021_06_03_193114_create_return_product_details_table',1),
(22,'2021_06_05_090353_create_purchases_table',1),
(23,'2021_06_05_090636_create_purchase_details_table',1),
(24,'2021_06_09_104235_create_employees_table',1),
(25,'2021_06_13_183640_create_employee_payments_table',1),
(26,'2021_05_01_200040_create_creditors_table',2),
(27,'2021_05_03_013829_create_creditor_payments_table',2),
(28,'2021_05_04_203537_create_debtors_table',2),
(29,'2021_05_04_203752_create_debtor_payments_table',2);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `office_expenses` */

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
(1,'Mobile',1,1,'mobile',17,10,2000.0000,'mobile-2021-09-07-61379c7ad87c5.jpg','2021-09-07 23:08:11','2021-09-08 00:50:31'),
(2,'Speaker',1,1,'speaker',21,10,500.0000,'speaker-2021-09-07-61379cb459f95.jpeg','2021-09-07 23:09:08','2021-09-08 00:50:31'),
(3,'TV',1,2,'tv',10,5,3000.0000,'tv-2021-09-07-61379ceb3b9e8.png','2021-09-07 23:10:03','2021-09-08 00:55:58'),
(4,'Laptop',1,2,'laptop',12,5,2000.0000,'laptop-2021-09-07-61379d0c6cb24.jpg','2021-09-07 23:10:36','2021-09-08 00:55:58'),
(5,'Car',2,3,'car',9,5,5000.0000,'car-2021-09-07-61379d363d752.jpg','2021-09-07 23:11:18','2021-09-08 00:48:17'),
(6,'Bike',2,3,'bike',15,10,2000.0000,'bike-2021-09-07-61379d5543dda.jpg','2021-09-07 23:11:49','2021-09-08 00:52:16'),
(7,'Table',3,4,'table',14,10,1000.0000,'table-2021-09-07-61379d7a282dd.jpg','2021-09-07 23:12:26','2021-09-08 00:40:59'),
(8,'Chair',3,4,'chair',20,15,500.0000,'chair-2021-09-07-61379d983c95a.jpg','2021-09-07 23:12:56','2021-09-08 00:43:45'),
(9,'Showcase',3,4,'showcase',9,10,1000.0000,'showcase-2021-09-07-61379db8d760a.jpg','2021-09-07 23:13:29','2021-09-08 00:43:45');

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `proprietor_transactions` */

insert  into `proprietor_transactions`(`id`,`proprietor_id`,`transaction_date`,`description`,`deposite`,`withdraw`,`created_at`,`updated_at`) values 
(1,1,'2021-01-02','Proprietor Imran Hossain Deposited to Cash',200000.0000,0.0000,'2021-09-07 23:05:27','2021-09-07 23:05:27'),
(2,2,'2021-01-03','Proprietor Adib Hossain Deposited to Cash',100000.0000,0.0000,'2021-09-07 23:05:52','2021-09-07 23:05:52');

/*Table structure for table `proprietors` */

DROP TABLE IF EXISTS `proprietors`;

CREATE TABLE `proprietors` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `designation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default.png',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `proprietors` */

insert  into `proprietors`(`id`,`name`,`designation`,`phone`,`image`,`created_at`,`updated_at`) values 
(1,'Imran Hossain','Chairman','01711111111','imran-hossain-2021-09-07-61379ba682464.jpg','2021-09-07 23:04:39','2021-09-07 23:04:39'),
(2,'Adib Hossain','Managing Director','01711111111','adib-hossain-2021-09-07-61379bbc6f3f2.jpg','2021-09-07 23:05:00','2021-09-07 23:05:00');

/*Table structure for table `purchase_details` */

DROP TABLE IF EXISTS `purchase_details`;

CREATE TABLE `purchase_details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `purchase_id` bigint(20) unsigned NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `cost` decimal(13,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `purchase_details_purchase_id_foreign` (`purchase_id`),
  CONSTRAINT `purchase_details_purchase_id_foreign` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `purchase_details` */

insert  into `purchase_details`(`id`,`purchase_id`,`product_id`,`quantity`,`cost`,`created_at`,`updated_at`) values 
(1,1,1,20,2000.0000,'2021-09-08 00:26:41','2021-09-08 00:26:41'),
(2,1,2,25,500.0000,'2021-09-08 00:26:41','2021-09-08 00:26:41'),
(3,2,5,12,5000.0000,'2021-09-08 00:32:12','2021-09-08 00:32:12'),
(4,2,6,20,2000.0000,'2021-09-08 00:32:12','2021-09-08 00:32:12'),
(5,3,7,15,1000.0000,'2021-09-08 00:33:40','2021-09-08 00:33:40'),
(6,3,8,25,500.0000,'2021-09-08 00:33:40','2021-09-08 00:33:40'),
(7,3,9,10,1000.0000,'2021-09-08 00:33:40','2021-09-08 00:33:40'),
(8,4,3,10,3000.0000,'2021-09-08 00:55:58','2021-09-08 00:55:58'),
(9,4,4,12,2000.0000,'2021-09-08 00:55:58','2021-09-08 00:55:58');

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
  `amount` decimal(13,4) NOT NULL,
  `discount` decimal(13,4) NOT NULL DEFAULT 0.0000,
  `total_amount` decimal(13,4) NOT NULL,
  `paid` decimal(13,4) NOT NULL,
  `due` decimal(13,4) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_paid` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=Pending,1=Paid',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `purchases` */

insert  into `purchases`(`id`,`user_id`,`supplier_id`,`purchase_no`,`date`,`payment_type`,`bank_account_id`,`amount`,`discount`,`total_amount`,`paid`,`due`,`description`,`is_paid`,`created_at`,`updated_at`) values 
(1,2,1,2021020101,'2021-02-01','cash',NULL,52500.0000,0.0000,52500.0000,52500.0000,0.0000,NULL,1,'2021-09-08 00:26:41','2021-09-08 00:26:41'),
(2,2,3,2021021701,'2021-02-17','cash',NULL,100000.0000,0.0000,100000.0000,100000.0000,0.0000,NULL,1,'2021-09-08 00:32:12','2021-09-08 00:32:12'),
(3,2,4,2021040801,'2021-04-08','cash',NULL,37500.0000,0.0000,37500.0000,34000.0000,3500.0000,NULL,0,'2021-09-08 00:33:40','2021-09-08 00:34:52'),
(4,2,2,2021021001,'2021-02-10','cash',NULL,54000.0000,0.0000,54000.0000,54000.0000,0.0000,NULL,1,'2021-09-08 00:55:58','2021-09-08 00:55:58');

/*Table structure for table `return_product_details` */

DROP TABLE IF EXISTS `return_product_details`;

CREATE TABLE `return_product_details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `return_product_id` bigint(20) unsigned NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(13,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `return_product_details_return_product_id_foreign` (`return_product_id`),
  CONSTRAINT `return_product_details_return_product_id_foreign` FOREIGN KEY (`return_product_id`) REFERENCES `return_products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `return_product_details` */

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
  `amount` decimal(13,4) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `return_products` */

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `suppliers` */

insert  into `suppliers`(`id`,`name`,`organization`,`slug`,`phone`,`address`,`created_at`,`updated_at`) values 
(1,'Mr. Kamal','Gadget & Gear','gadget-gear','01711111111','Dhaka','2021-09-07 23:02:06','2021-09-07 23:02:06'),
(2,'Mr. Jamal','Rangs','rangs','01711111111','Dhaka','2021-09-07 23:02:37','2021-09-07 23:02:37'),
(3,'Mr. Karim','Car Bazar','car-bazar','01711111111','Dhaka','2021-09-07 23:03:02','2021-09-07 23:03:02'),
(4,'Mr. Ahmed','Hatil','hatil','01711111111','Dhaka','2021-09-07 23:03:30','2021-09-07 23:03:30');

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
  `is_super_admin` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=No,1=Yes',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`role_id`,`name`,`email`,`email_verified_at`,`password`,`image`,`phone`,`address`,`is_super_admin`,`remember_token`,`created_at`,`updated_at`) values 
(1,1,'Super Admin','mazhar.rony@gmail.com',NULL,'$2y$10$F8y/W/I0Xo9aHtJUszUyJegdSH6TcgdjW1ICkIg1NO34nNodtY/y2','default.png',NULL,NULL,1,NULL,NULL,NULL),
(2,1,'Admin','admin@mail.com',NULL,'$2y$10$RHonhttSWmcTDw3.CDd86.SDnEhMLifN0aoTfxCEuUH/AKuoBYwoO','default.png',NULL,NULL,0,NULL,NULL,NULL),
(3,2,'User','user@mail.com',NULL,'$2y$10$dvPSU4SUjBznT0APY/I/zuOT47jCxmY.e725xkuFWZqBouYZ2.hgW','default.png',NULL,NULL,0,NULL,NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
