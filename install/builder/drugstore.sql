--
--

SET SQL_MODE = "";

--
-- Database: `pharmacy`
--

-- --------------------------------------------------------

--
-- Table structure for table `kk_accounts`
--

DROP TABLE IF EXISTS `kk_accounts`;
CREATE TABLE IF NOT EXISTS `kk_accounts` (
  `id` int(11) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `account_name` varchar(255) NOT NULL,
  `account_no` varchar(255) NOT NULL,
  `initial_balance` decimal(10,2) NOT NULL,
  `contact_person` varchar(255) NOT NULL,
  `contact_person_phone` varchar(50) NOT NULL,
  `bank_url` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_of_joining` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `kk_account_transaction`
--

DROP TABLE IF EXISTS `kk_account_transaction`;
CREATE TABLE IF NOT EXISTS `kk_account_transaction` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `debit` decimal(10,2) NOT NULL,
  `credit` decimal(10,2) NOT NULL,
  `code` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `transaction_type` int(1) NOT NULL,
  `method` int(11) DEFAULT NULL,
  `account_id` int(11) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `user_id` int(11) NOT NULL,
  `date_of_joining` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `kk_attached_files`
--

DROP TABLE IF EXISTS `kk_attached_files`;
CREATE TABLE IF NOT EXISTS `kk_attached_files` (
  `id` int(11) NOT NULL,
  `file` varchar(255) NOT NULL,
  `ext` varchar(10) NOT NULL,
  `type` varchar(255) NOT NULL,
  `type_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_of_joining` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kk_customers`
--

DROP TABLE IF EXISTS `kk_customers`;
CREATE TABLE IF NOT EXISTS `kk_customers` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(32) NOT NULL,
  `address` text NOT NULL,
  `bloodgroup` varchar(5) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `dob` varchar(10) NOT NULL,
  `history` text NOT NULL,
  `other` text NOT NULL,
  `password` varchar(255) NOT NULL,
  `temp_hash` varchar(255) NOT NULL,
  `emailconfirmed` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_of_joining` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kk_doctors`
--

DROP TABLE IF EXISTS `kk_doctors`;
CREATE TABLE IF NOT EXISTS `kk_doctors` (
  `id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `date_of_joining` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kk_email_logs`
--

DROP TABLE IF EXISTS `kk_email_logs`;
CREATE TABLE IF NOT EXISTS `kk_email_logs` (
  `id` int(11) NOT NULL,
  `email_to` varchar(100) NOT NULL,
  `email_bcc` varchar(100) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` varchar(50) NOT NULL,
  `type_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_of_joining` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kk_email_template`
--

DROP TABLE IF EXISTS `kk_email_template`;
CREATE TABLE IF NOT EXISTS `kk_email_template` (
  `id` int(11) NOT NULL,
  `template` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kk_email_template`
--

INSERT INTO `kk_email_template` (`id`, `template`, `name`, `subject`, `message`, `status`, `last_updated`) VALUES
(1, 'newinvoice', 'New Invoice', 'Drug Store: New Invoice Generated', '<div data-mce-style=\"font-size: 11pt; font-weight: bold;\"><div data-mce-style=\"padding: 5px; font-size: 11pt; font-weight: bold;\" style=\"padding: 5px;\"><font color=\"#222222\" face=\"verdana, droid sans, lucida sans, sans-serif\"><span style=\"font-size: 13.3333px; font-family: Verdana;\">Hello {name},</span></font></div><div data-mce-style=\"padding: 5px; font-size: 11pt; font-weight: bold;\" style=\"padding: 5px;\"><font color=\"#222222\" face=\"verdana, droid sans, lucida sans, sans-serif\"><span style=\"font-size: 13.3333px; font-family: Verdana;\"><br></span></font></div></div><div data-mce-style=\"padding: 5px; font-size: 11pt; font-weight: bold;\" style=\"color: rgb(34, 34, 34); font-family: verdana, \" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" padding:=\"\" 5px;=\"\" font-size:=\"\" 11pt;=\"\" font-weight:=\"\" bold;\"=\"\"><span style=\"font-size: 13.3333px; font-weight: 400; font-family: Verdana;\">This email serves as your official invoice from {business_name}</span></div><div data-mce-style=\"padding: 5px; font-size: 11pt; font-weight: bold;\" style=\"color: rgb(34, 34, 34); font-family: verdana, \" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" padding:=\"\" 5px;=\"\" font-size:=\"\" 11pt;=\"\" font-weight:=\"\" bold;\"=\"\"><strong style=\"font-size: 13.3333px;\"><span style=\"font-family: Verdana;\"><br></span></strong></div><div data-mce-style=\"padding: 10px 5px;\" style=\"color: rgb(34, 34, 34); font-family: verdana, \" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 10px=\"\" 5px;\"=\"\"><span style=\"font-family: Verdana;\">Invoice ID: {inv_id}</span><br><span style=\"font-family: Verdana;\">Invoice Amount: {amount}</span><br><span style=\"font-family: Verdana;\">Paid Amount: {paid}</span><br><span style=\"font-family: Verdana;\">Due Amount: {due}</span><br><span style=\"font-family: Verdana;\">Due Date: {due_date}</span></div><div data-mce-style=\"padding: 10px 5px;\" style=\"color: rgb(34, 34, 34); font-family: verdana, \" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 10px=\"\" 5px;\"=\"\"><br></div><div data-mce-style=\"padding: 5px;\" style=\"color: rgb(34, 34, 34); font-family: verdana, \" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 5px;\"=\"\"><span data-mce-style=\"font-size: 13.3333330154419px; line-height: 21.3333320617676px;\" style=\"font-size: 13.3333px; line-height: 21.3333px; font-family: Verdana;\">Invoice PDF has been attached to this mail. If you have any questions or need assistance, please don\'t hesitate to contact us.</span></div><div data-mce-style=\"padding: 5px;\" style=\"color: rgb(34, 34, 34); font-family: verdana, \" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 5px;\"=\"\"><br></div><div data-mce-style=\"padding: 0px 5px;\" style=\"color: rgb(34, 34, 34); font-family: verdana, \" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 0px=\"\" 5px;\"=\"\"><span style=\"font-family: Verdana;\">Best Regards,&nbsp;</span><br><span style=\"font-family: Verdana; font-size: 13.3333px;\">{business_name}</span><br></div><div data-mce-style=\"padding: 0px 5px;\" style=\"color: rgb(34, 34, 34); font-family: verdana, \" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 0px=\"\" 5px;\"=\"\"><br></div><div data-mce-style=\"padding: 0px 5px;\" style=\"color: rgb(34, 34, 34); font-family: verdana, \" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 0px=\"\" 5px;\"=\"\"><span style=\"font-family: Poppins, Poppins, sans-serif; font-size: 14px; color: red;\"><span style=\"font-weight: bolder; font-family: Verdana;\">*DO NOT REPLY TO THIS E-MAIL*</span></span><br style=\"color: rgb(0, 0, 0); font-family: Poppins, Poppins, sans-serif; font-size: 14px;\"><span style=\"color: rgb(0, 0, 0); font-family: Verdana; font-size: 14px;\">This is an automated e-mail message sent from our support system. Do not reply to this e-mail as we will not receive your reply!</span><br></div>', 1, '2020-01-21 11:32:52'),
(2, 'newuser', 'New Admin User', 'Drug Store: your account has been created.', '<p style=\"\">Hello {name},</p><p style=\"\">Welcome to {business_name}.</p><p style=\"\">Your admin credentials has been created. Now you can login to admin portal. See below for credentials...&nbsp;</p><p style=\"\">---------------------------------------------------------------------------------------<br></p><p style=\"\">Login URL: {login_url}&nbsp;<br>Username: {username}<br>Email Address: {email}<br></p><p style=\"\">----------------------------------------------------------------------------------------</p><p style=\"\">We very much appreciate you for choosing us.</p><p style=\"\">{business_name}&nbsp;Team</p><p style=\"\">*DO NOT REPLY TO THIS E-MAIL*<br style=\"\">This is an automated e-mail message sent from our support system. Do not reply to this e-mail as we will not receive your reply!<br></p>', 1, '2020-01-20 10:26:03'),
(3, 'forgotpassword', 'Forgot password', 'Drug Store: forgot Password', '<div data-mce-style=\"padding: 5px; font-size: 11pt; font-weight: bold;\" style=\"\" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" padding:=\"\" 5px;=\"\" font-size:=\"\" 11pt;=\"\" font-weight:=\"\" bold;\"=\"\">Hello {firstname}</div><div data-mce-style=\"padding: 5px; font-size: 11pt; font-weight: bold;\" style=\"\" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" padding:=\"\" 5px;=\"\" font-size:=\"\" 11pt;=\"\" font-weight:=\"\" bold;\"=\"\"><br></div><div data-mce-style=\"padding: 5px; font-size: 11pt; font-weight: bold;\" style=\"\" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" padding:=\"\" 5px;=\"\" font-size:=\"\" 11pt;=\"\" font-weight:=\"\" bold;\"=\"\">This is to confirm that we have received a Forgot Password request for your Account Username - {email}<br></div><div data-mce-style=\"padding: 5px;\" style=\"\" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 5px;\"=\"\">Click this link to reset your password-&nbsp;<br><span style=\"padding: 3px;\">{reset_link}</span></div><div data-mce-style=\"padding: 5px;\" style=\"\" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 5px;\"=\"\"><span style=\"padding: 3px;\"><br></span></div><div data-mce-style=\"padding: 5px;\" style=\"\" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 5px;\"=\"\">Please note: until your password has been changed, your current password will remain valid. If you have not generated this request. Please contact us as soon as possible.</div><div data-mce-style=\"padding: 5px;\" style=\"\" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 5px;\"=\"\"><br></div><div data-mce-style=\"padding: 0px 5px;\" style=\"\" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 0px=\"\" 5px;\"=\"\">Regards,<br>{business_name}&nbsp;Team</div><div data-mce-style=\"padding: 0px 5px;\" style=\"\" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 0px=\"\" 5px;\"=\"\"><br></div><div data-mce-style=\"padding: 0px 5px;\" style=\"\" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 0px=\"\" 5px;\"=\"\">*DO NOT REPLY TO THIS E-MAIL*<br style=\"\">This is an automated e-mail message sent from our support system. Do not reply to this e-mail as we will not receive your reply!<br></div>', 1, '2020-01-20 10:26:25'),
(4, 'resetpassword', 'Reset password', 'Drug Store:  Password change confirmation', '<div data-mce-style=\"padding: 5px; font-size: 11pt; font-weight: bold;\" style=\"\" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" padding:=\"\" 5px;=\"\" font-size:=\"\" 11pt;=\"\" font-weight:=\"\" bold;\"=\"\">Hello {firstname}</div><div data-mce-style=\"padding: 5px; font-size: 11pt; font-weight: bold;\" style=\"\" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" padding:=\"\" 5px;=\"\" font-size:=\"\" 11pt;=\"\" font-weight:=\"\" bold;\"=\"\"><br></div><div data-mce-style=\"padding: 5px; font-size: 11pt; font-weight: bold;\" style=\"\" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" padding:=\"\" 5px;=\"\" font-size:=\"\" 11pt;=\"\" font-weight:=\"\" bold;\"=\"\">This is to inform you that you password has been changed successfully for your Account - {email}<br></div><div data-mce-style=\"padding: 5px;\" style=\"\" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 5px;\"=\"\"><span style=\"padding: 3px;\"><br></span></div><div data-mce-style=\"padding: 5px;\" style=\"\" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 5px;\"=\"\">Please note: If you have not changed your password. Please contact us as soon as possible on our mail.</div><div data-mce-style=\"padding: 5px;\" style=\"\" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 5px;\"=\"\"><br></div><div data-mce-style=\"padding: 0px 5px;\" style=\"\" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 0px=\"\" 5px;\"=\"\">Regards,<br>{business_name}&nbsp;Team</div><div data-mce-style=\"padding: 0px 5px;\" style=\"\" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 0px=\"\" 5px;\"=\"\"><br></div><div data-mce-style=\"padding: 0px 5px;\" style=\"\" droid=\"\" sans\",=\"\" \"lucida=\"\" sans-serif;=\"\" font-size:=\"\" 13.3333px;=\"\" padding:=\"\" 0px=\"\" 5px;\"=\"\">*DO NOT REPLY TO THIS E-MAIL*<br style=\"\">This is an automated e-mail message sent from our support system. Do not reply to this e-mail as we will not receive your reply!<br></div>', 1, '2020-01-21 11:31:25');

-- --------------------------------------------------------

--
-- Table structure for table `kk_expenses`
--

DROP TABLE IF EXISTS `kk_expenses`;
CREATE TABLE IF NOT EXISTS `kk_expenses` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `expense_type` int(11) NOT NULL,
  `amount` int(100) NOT NULL,
  `method` int(11) NOT NULL,
  `date` date NOT NULL,
  `description` text NOT NULL,
  `other` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_of_joining` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `kk_expense_type`
--

DROP TABLE IF EXISTS `kk_expense_type`;
CREATE TABLE IF NOT EXISTS `kk_expense_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `other` text NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `kk_invoice`
--

DROP TABLE IF EXISTS `kk_invoice`;
CREATE TABLE IF NOT EXISTS `kk_invoice` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(64) NOT NULL,
  `duedate` date NOT NULL,
  `invoicedate` date NOT NULL,
  `method` int(5) NOT NULL,
  `status` varchar(50) NOT NULL,
  `inv_status` tinyint(1) NOT NULL,
  `items` text NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL,
  `discounttype` int(11) NOT NULL,
  `discount` varchar(255) DEFAULT NULL,
  `discount_value` decimal(10,2) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `paid` decimal(10,2) NOT NULL DEFAULT 0,
  `due` decimal(10,2) NOT NULL DEFAULT 0,
  `note` text NOT NULL,
  `tc` text NOT NULL,
  `customer_id` int(11) NOT NULL,
  `mail_sent` tinyint(1) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL,
  `date_of_joining` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `kk_items`
--

DROP TABLE IF EXISTS `kk_items`;
CREATE TABLE IF NOT EXISTS `kk_items` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `currency` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `other` varchar(255) NOT NULL,
  `date_of_joining` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `kk_login_attempts`
--

DROP TABLE IF EXISTS `kk_login_attempts`;
CREATE TABLE IF NOT EXISTS `kk_login_attempts` (
  `user_id` int(11) NOT NULL,
  `email` varchar(96) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `count` int(4) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kk_media`
--

DROP TABLE IF EXISTS `kk_media`;
CREATE TABLE IF NOT EXISTS `kk_media` (
  `id` int(11) NOT NULL,
  `media` varchar(255) NOT NULL,
  `ext` varchar(5) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `user_id` int(11) NOT NULL,
  `date_of_joining` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kk_media`
--

INSERT INTO `kk_media` (`id`, `media`, `ext`, `status`, `user_id`, `date_of_joining`) VALUES
(1, 'media-14217467725e26756243d43.png', 'png', 1, 1, '2020-01-21 16:22:02'),
(2, 'media-4336229525e267658c4f5e.png', 'png', 1, 1, '2020-01-21 16:26:08'),
(3, 'media-16618051305e26765d6e55b.png', 'png', 1, 1, '2020-01-21 16:26:13'),
(4, 'media-17187596575e26769ee467a.png', 'png', 1, 1, '2020-01-21 16:27:18'),
(5, 'media-20838902005e2676ba7cda2.jpg', 'jpg', 1, 1, '2020-01-21 16:27:46');

-- --------------------------------------------------------

--
-- Table structure for table `kk_medicines`
--

DROP TABLE IF EXISTS `kk_medicines`;
CREATE TABLE IF NOT EXISTS `kk_medicines` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `generic` text NOT NULL,
  `medicine_group` varchar(255) NOT NULL,
  `category` int(11) NOT NULL,
  `storebox` varchar(255) NOT NULL,
  `minlevel` varchar(100) NOT NULL,
  `reorderlevel` varchar(100) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `unitpacking` varchar(255) NOT NULL,
  `tax` text NOT NULL,
  `note` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_of_joining` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `kk_medicine_batch`
--

DROP TABLE IF EXISTS `kk_medicine_batch`;
CREATE TABLE IF NOT EXISTS `kk_medicine_batch` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `batch` varchar(255) NOT NULL,
  `expiry` varchar(10) NOT NULL,
  `pqty` varchar(10) NOT NULL,
  `qty` decimal(10,2) NOT NULL,
  `saleprice` decimal(10,2) NOT NULL,
  `purchaseprice` decimal(10,2) NOT NULL,
  `discounttype` int(1) NOT NULL,
  `discount` decimal(10,2) NOT NULL,
  `discountvalue` decimal(10,2) NOT NULL,
  `tax` text NOT NULL,
  `taxprice` decimal(10,2) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `sold` decimal(10,2) NOT NULL DEFAULT '0.00',
  `medicine_id` int(11) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `user_id` int(11) NOT NULL,
  `date_of_joining` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `kk_medicine_bill`
--

DROP TABLE IF EXISTS `kk_medicine_bill`;
CREATE TABLE IF NOT EXISTS `kk_medicine_bill` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` int(100) NOT NULL,
  `doctor` varchar(255) NOT NULL,
  `method` int(11) NOT NULL,
  `bill_date` date NOT NULL,
  `items` text NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL,
  `discounttype` int(1) NOT NULL,
  `discount` varchar(10) NOT NULL,
  `discount_value` decimal(10,2) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `note` text NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_of_joining` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `kk_medicine_category`
--

DROP TABLE IF EXISTS `kk_medicine_category`;
CREATE TABLE IF NOT EXISTS `kk_medicine_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `date_of_joining` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `kk_medicine_purchase`
--

DROP TABLE IF EXISTS `kk_medicine_purchase`;
CREATE TABLE IF NOT EXISTS `kk_medicine_purchase` (
  `id` int(11) NOT NULL,
  `supplier` int(11) NOT NULL,
  `date` date NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL,
  `discounttype` int(1) NOT NULL,
  `discount` varchar(20) NOT NULL,
  `discount_value` decimal(10,2) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `note` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_of_joining` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `kk_menu`
--

DROP TABLE IF EXISTS `kk_menu`;
CREATE TABLE IF NOT EXISTS `kk_menu` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `parent` int(11) NOT NULL DEFAULT '0',
  `active` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `priority` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kk_menu`
--

INSERT INTO `kk_menu` (`id`, `name`, `link`, `icon`, `parent`, `active`, `status`, `priority`) VALUES
(1, 'Dashboard', 'dashboard', 'las la-chalkboard', 0, 'dashboard', 1, 2000),
(2, 'Customers', 'customers', 'las la-user-md', 0, 'customers', 1, 1970),
(4, 'Invoices', 'invoices', 'las la-file-invoice', 0, 'invoices', 1, 1790),
(5, 'Invoice items', 'items', '', 17, 'invoices', 1, 911),
(6, 'Doctors', 'doctors', 'ti-id-badge', 17, 'doctors', 1, 968),
(8, 'Expenses', 'expenses', 'las la-receipt', 0, 'expenses', 1, 1580),
(9, 'Expense Type', 'expensetype', '', 17, 'expenses', 1, 910),
(10, 'Subscribers', 'subscribers', 'las la-user-circle', 0, 'subscribers', 0, 1240),
(11, 'Admin User', '#', 'las la-users', 0, 'users', 1, 1160),
(12, 'Users', 'users', '', 11, 'users', 1, 1140),
(13, 'User Role', 'role', '', 11, 'users', 1, 1120),
(14, 'Email', '#', 'las la-envelope', 0, 'email', 1, 1100),
(15, 'Send Email', 'send/email', '', 14, 'email', 1, 1080),
(16, 'Send Bulk Email', 'sendbulk/email', '', 14, 'email', 1, 1060),
(17, 'Setting', '#', 'las la-cog', 0, 'settings', 1, 1020),
(18, 'System Info', 'info', '', 17, 'settings', 1, 1000),
(19, 'Finance Setting', 'tax', '', 17, 'settings', 0, 980),
(20, 'Email Setting', 'emailsetting', '', 14, 'email', 1, 900),
(21, 'Email Template', 'emailtemplate&for=newuser', '', 14, 'email', 1, 840),
(22, 'Noticeboard', 'noticeboard', 'las la-bullhorn', 0, 'noticeboard', 1, 1270),
(23, 'Email Log', 'emaillogs', '', 14, 'email', 1, 1040),
(24, 'Taxes', 'tax', '', 17, 'settings', 1, 960),
(25, 'Payment Methods', 'paymentmethod', '', 17, 'settings', 1, 940),
(28, 'Admin Customization', 'customization', 'las la-fill-drip', 0, 'customization', 1, 140),
(29, 'Attendance', 'staffattendance', 'las la-pen-fancy', 0, 'staffattendance', 1, 1380),
(30, 'Payroll', '#', 'las la-hand-holding-usd', 0, 'payroll', 1, 1480),
(31, 'Make Payment', 'makepayment', '', 30, 'makepayment', 1, 1400),
(32, 'Manage Salary', 'managesalary', '', 30, 'managesalary', 1, 1430),
(33, 'Salary Template', 'salarytemplate', '', 30, 'payroll', 1, 1460),
(34, 'Pharmacy', '#', 'las la-cart-plus', 0, 'pharmacy', 0, 1720),
(35, 'Inventory/Medicines', 'medicines', 'las la-pills', 0, 'pharmacy', 1, 1705),
(36, 'POS/Bill', 'medicine/billing', 'las la-cart-plus', 0, 'billing', 1, 1715),
(37, 'Purchase', 'medicine/purchase', 'las la-file-invoice-dollar', 0, 'purchase', 1, 1710),
(38, 'Suppliers', 'suppliers', '', 17, 'settings', 1, 909),
(39, 'Stock adjustment', 'medicine/stock', 'las la-balance-scale', 0, 'stockadjustment', 1, 1709),
(40, 'Medicine Category', 'medicine/category', '', 17, 'Setting', 1, 970),
(41, 'Accounting', '#', 'las la-book', 0, 'accounts', 1, 1690),
(42, 'Accounts', 'accounts', '', 41, 'accounts', 1, 1650),
(43, 'View Transaction', 'account/transactions', '', 41, 'accounts', 1, 1655),
(44, 'Report', 'reports', 'las la-chalkboard-teacher', 0, 'reports', 1, 1350);

-- --------------------------------------------------------

--
-- Table structure for table `kk_noticeboard`
--

DROP TABLE IF EXISTS `kk_noticeboard`;
CREATE TABLE IF NOT EXISTS `kk_noticeboard` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` tinyint(1) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_of_joining` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `kk_payments`
--

DROP TABLE IF EXISTS `kk_payments`;
CREATE TABLE IF NOT EXISTS `kk_payments` (
  `id` int(11) NOT NULL,
  `payer_id` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `txn_id` varchar(100) DEFAULT NULL,
  `currency` varchar(3) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `payment_date` datetime DEFAULT NULL,
  `payment_method` varchar(100) DEFAULT NULL,
  `is_online` int(3) DEFAULT NULL,
  `gateway` varchar(255) DEFAULT NULL,
  `invoice` int(11) DEFAULT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `date_of_joining` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `kk_payment_method`
--

DROP TABLE IF EXISTS `kk_payment_method`;
CREATE TABLE IF NOT EXISTS `kk_payment_method` (
  `id` int(5) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `other` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_of_joining` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `kk_salarytemplate`
--

DROP TABLE IF EXISTS `kk_salarytemplate`;
CREATE TABLE IF NOT EXISTS `kk_salarytemplate` (
  `id` int(11) NOT NULL,
  `grade` varchar(128) NOT NULL,
  `basic_salary` varchar(20) NOT NULL,
  `allowance` text NOT NULL,
  `deduction` text NOT NULL,
  `gross_salary` varchar(20) NOT NULL,
  `total_allowance` varchar(20) NOT NULL,
  `total_deduction` varchar(20) NOT NULL,
  `net_salary` varchar(20) NOT NULL,
  `date_of_joining` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `kk_setting`
--

DROP TABLE IF EXISTS `kk_setting`;
CREATE TABLE IF NOT EXISTS `kk_setting` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `data` text,
  `status` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kk_setting`
--

INSERT INTO `kk_setting` (`id`, `name`, `data`, `status`) VALUES
(1, 'siteinfo', '{\"logo\":\"media-4336229525e267658c4f5e.png\",\"favicon\":\"media-17187596575e26769ee467a.png\",\"name\":\"Drug Store\",\"legal_name\":\"Drug Store\",\"mail\":\"your_email@example.com\",\"phone\":\"1234567890\",\"language\":\"en\",\"timezone\":\"Asia\\/Calcutta\",\"date_format\":\"d\\/m\\/Y\",\"date_my_format\":\"m-Y\",\"currency\":\"USD\",\"currency_abbr\":\"$\",\"invoice_prefix\":\"INV-\",\"invoice_cnote\":\"It\'s great to work with you. \",\"invoice_tc\":\"Please pay us your amount in 15 days. Otherwise 12% interest will be applied.  \",\"invoice_template\":\"1\",\"address\":{\"address1\":\"Address Line 11\",\"address2\":\"Address Line 2\",\"city\":\"City\",\"country\":\"Country\",\"postal\":\"012345\"},\"doctor_access\":0}', 1),
(2, 'admintheme', '{\"layout\":\"\",\"layout_fixed\":\"\",\"layout_menu\":\"page-menu-small\",\"side_menu\":\"light\",\"header_color\":\"bg-white\",\"logo\":\"media-4336229525e267658c4f5e.png\",\"logo_icon\":\"media-14217467725e26756243d43.png\",\"favicon\":\"media-17187596575e26769ee467a.png\",\"lg_background\":\"media-20838902005e2676ba7cda2.jpg\"}', 1),
(3, 'emailsetting', '{\"status\":\"1\",\"fromemail\":\"\",\"fromname\":\"\",\"reply\":\"\",\"host\":\"\",\"port\":\"\",\"username\":\"\",\"password\":\"\",\"encryption\":\"tls\",\"authentication\":\"1\"}', 1);

-- --------------------------------------------------------

--
-- Table structure for table `kk_staff_attendance`
--

DROP TABLE IF EXISTS `kk_staff_attendance`;
CREATE TABLE IF NOT EXISTS `kk_staff_attendance` (
  `id` int(200) UNSIGNED NOT NULL,
  `staff_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `monthyear` varchar(10) NOT NULL,
  `a1` varchar(3) DEFAULT NULL,
  `a2` varchar(3) DEFAULT NULL,
  `a3` varchar(3) DEFAULT NULL,
  `a4` varchar(3) DEFAULT NULL,
  `a5` varchar(3) DEFAULT NULL,
  `a6` varchar(3) DEFAULT NULL,
  `a7` varchar(3) DEFAULT NULL,
  `a8` varchar(3) DEFAULT NULL,
  `a9` varchar(3) DEFAULT NULL,
  `a10` varchar(3) DEFAULT NULL,
  `a11` varchar(3) DEFAULT NULL,
  `a12` varchar(3) DEFAULT NULL,
  `a13` varchar(3) DEFAULT NULL,
  `a14` varchar(3) DEFAULT NULL,
  `a15` varchar(3) DEFAULT NULL,
  `a16` varchar(3) DEFAULT NULL,
  `a17` varchar(3) DEFAULT NULL,
  `a18` varchar(3) DEFAULT NULL,
  `a19` varchar(3) DEFAULT NULL,
  `a20` varchar(3) DEFAULT NULL,
  `a21` varchar(3) DEFAULT NULL,
  `a22` varchar(3) DEFAULT NULL,
  `a23` varchar(3) DEFAULT NULL,
  `a24` varchar(3) DEFAULT NULL,
  `a25` varchar(3) DEFAULT NULL,
  `a26` varchar(3) DEFAULT NULL,
  `a27` varchar(3) DEFAULT NULL,
  `a28` varchar(3) DEFAULT NULL,
  `a29` varchar(3) DEFAULT NULL,
  `a30` varchar(3) DEFAULT NULL,
  `a31` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kk_staff_payment`
--

DROP TABLE IF EXISTS `kk_staff_payment`;
CREATE TABLE IF NOT EXISTS `kk_staff_payment` (
  `id` int(11) NOT NULL,
  `month_year` varchar(20) NOT NULL,
  `month` int(2) NOT NULL,
  `gross_salary` varchar(20) NOT NULL,
  `total_deduction` varchar(20) NOT NULL,
  `net_salary` varchar(20) NOT NULL,
  `method` int(11) NOT NULL,
  `advance` varchar(20) NOT NULL,
  `deduction` varchar(20) NOT NULL,
  `amount` varchar(20) NOT NULL,
  `comments` text,
  `salarytemplate` text NOT NULL,
  `salarytemplate_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_of_joining` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `kk_subscribe`
--

DROP TABLE IF EXISTS `kk_subscribe`;
CREATE TABLE IF NOT EXISTS `kk_subscribe` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_of_joining` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `kk_suppliers`
--

DROP TABLE IF EXISTS `kk_suppliers`;
CREATE TABLE IF NOT EXISTS `kk_suppliers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_of_joining` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `kk_taxes`
--

DROP TABLE IF EXISTS `kk_taxes`;
CREATE TABLE IF NOT EXISTS `kk_taxes` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `rate` float NOT NULL,
  `description` varchar(255) NOT NULL,
  `other` text NOT NULL,
  `date_of_joining` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `kk_users`
--

DROP TABLE IF EXISTS `kk_users`;
CREATE TABLE IF NOT EXISTS `kk_users` (
  `user_id` int(5) NOT NULL,
  `user_role` int(4) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `address` text,
  `country` varchar(255) DEFAULT NULL,
  `bloodgroup` varchar(5) DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `dob` varchar(10) DEFAULT NULL,
  `salarytemplate_id` int(11) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `temp_hash` varchar(225) NOT NULL,
  `emailconfirmed` bit(1) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `date_of_joining` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kk_users`
--

INSERT INTO `kk_users` (`user_id`, `user_role`, `user_name`, `firstname`, `lastname`, `email`, `mobile`, `picture`, `address`, `country`, `bloodgroup`, `gender`, `dob`, `salarytemplate_id`, `password`, `temp_hash`, `emailconfirmed`, `status`, `date_of_joining`) VALUES
(1, 1, 'admin', 'John', 'Doe', 'your_email@example.com', '111111111', 'media-5505453175dbaeecba016c.jpg', '{\"address1\":\"Address Line 1\",\"address2\":\"Address Line 2\",\"city\":\"City\",\"country\":\"Country\",\"postal\":\"411048\"}', NULL, NULL, '', NULL, NULL, '$2y$10$MqjH5l.tlTdWgBudmx0thOGmoLiFdowhJ3BPsrXjSj64yEy09OXIK', '', b'1', 1, '2017-04-15 14:24:06');

-- --------------------------------------------------------

--
-- Table structure for table `kk_user_role`
--

DROP TABLE IF EXISTS `kk_user_role`;
CREATE TABLE IF NOT EXISTS `kk_user_role` (
  `id` int(5) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `permission` text NOT NULL,
  `date_of_joining` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kk_user_role`
--

INSERT INTO `kk_user_role` (`id`, `name`, `description`, `permission`, `date_of_joining`) VALUES
(1, 'Admin', 'You can not change Admin role setting', '[\"dashboard\",\"login\",\"patients\",\"patient\\/add\",\"patient\\/edit\",\"patient\\/delete\",\"patient\\/view\",\"appointments\",\"appointment\\/add\",\"appointment\\/edit\",\"appointment\\/delete\",\"invoices\",\"invoice\\/add\",\"invoice\\/edit\",\"invoice\\/delete\",\"invoice\\/view\",\"request\",\"request\\/add\",\"request\\/edit\",\"request\\/delete\",\"doctors\",\"doctor\\/add\",\"doctor\\/edit\",\"doctor\\/delete\",\"departments\",\"department\\/add\",\"subscriber\\/add\",\"subscriber\\/edit\",\"subscriber\\/delete\",\"users\",\"user\\/add\",\"user\\/edit\",\"user\\/delete\",\"items\",\"item\\/add\",\"item\\/edit\",\"item\\/delete\",\"notes\",\"note\\/add\",\"note\\/edit\",\"note\\/delete\",\"pharmacy\",\"pharmacy\\/add\",\"pharmacy\\/edit\",\"pharmacy\\/delete\",\"pages\",\"page\\/add\",\"page\\/edit\",\"page\\/delete\",\"facility\",\"facility\\/add\",\"facility\\/edit\",\"facility\\/delete\",\"services\",\"service\\/add\",\"service\\/edit\",\"service\\/delete\",\"testimonials\",\"testimonial\\/add\",\"testimonial\\/edit\",\"testimonial\\/delete\",\"blogs\",\"blog\\/add\",\"blog\\/edit\",\"blog\\/delete\",\"category\",\"category\\/add\",\"category\\/edit\",\"category\\/delete\",\"comment\",\"comment\\/edit\",\"comment\\/delete\",\"reviews\",\"review\\/edit\",\"review\\/delete\",\"expenses\",\"expense\\/add\",\"expense\\/edit\",\"expense\\/delete\"]', '2018-01-10 23:15:47'),
(2, 'Store Manager', 'Store Manager', '[\"dashboard\",\"customers\",\"customer\\/add\",\"customer\\/edit\",\"customer\\/delete\",\"customer\\/view\",\"customer\\/sendmail\",\"invoices\",\"invoice\\/add\",\"invoice\\/edit\",\"invoice\\/delete\",\"invoice\\/view\",\"invoice\\/pdf\",\"invoice\\/sentmail\",\"addpayment\",\"medicine\\/billing\",\"medicine\\/billing\\/add\",\"medicine\\/billing\\/edit\",\"medicine\\/billing\\/delete\",\"medicine\\/billing\\/view\",\"medicine\\/billing\\/pdf\",\"medicine\\/purchase\",\"medicine\\/purchase\\/add\",\"medicine\\/purchase\\/edit\",\"medicine\\/purchase\\/delete\",\"medicine\\/purchase\\/view\",\"medicine\\/purchase\\/pdf\",\"medicine\\/stock\",\"medicine\\/stock\\/delete\",\"medicines\",\"medicine\\/add\",\"medicine\\/edit\",\"medicine\\/delete\",\"medicine\\/view\",\"medicine\\/upload\",\"medicine\\/category\",\"medicine\\/category\\/add\",\"medicine\\/category\\/edit\",\"medicine\\/category\\/delete\",\"accounts\",\"account\\/add\",\"account\\/edit\",\"account\\/delete\",\"account\\/transactions\",\"account\\/transaction\\/add\",\"account\\/transaction\\/edit\",\"account\\/transaction\\/delete\",\"reports\",\"expenses\",\"expense\\/add\",\"expense\\/edit\",\"expense\\/delete\",\"expensetype\",\"expensetype\\/add\",\"expensetype\\/edit\",\"expensetype\\/delete\",\"staffattendance\",\"staffattendance\\/add\",\"staffattendance\\/view\",\"salarytemplate\",\"salarytemplate\\/add\",\"salarytemplate\\/edit\",\"salarytemplate\\/delete\",\"managesalary\",\"managesalary\\/add\",\"managesalary\\/edit\",\"managesalary\\/view\",\"payment\",\"payment\\/view\",\"payment\\/pdf\",\"makepayment\",\"makepayment\\/add\",\"noticeboard\",\"noticeboard\\/add\",\"noticeboard\\/edit\",\"noticeboard\\/delete\",\"noticeboard\\/view\",\"users\",\"user\\/add\",\"user\\/edit\",\"user\\/delete\",\"tax\",\"tax\\/add\",\"tax\\/edit\",\"tax\\/delete\",\"paymentmethod\",\"paymentmethod\\/add\",\"paymentmethod\\/edit\",\"paymentmethod\\/delete\",\"paymentgateway\",\"items\",\"item\\/add\",\"item\\/edit\",\"item\\/delete\",\"send\\/email\",\"sendbulk\\/email\",\"emaillogs\",\"get\\/media\",\"media\\/upload\",\"media\\/delete\"]', '2018-01-10 23:37:46'),
(3, 'HR Manager', 'HR Manager', '[\"dashboard\",\"customers\",\"customer\\/add\",\"customer\\/edit\",\"customer\\/view\",\"customer\\/sendmail\",\"medicine\\/billing\",\"medicines\",\"medicine\\/view\",\"expenses\",\"expense\\/add\",\"expense\\/edit\",\"expense\\/delete\",\"noticeboard\",\"noticeboard\\/view\",\"send\\/email\",\"get\\/media\"]', '2019-08-06 01:35:59'),
(4, 'Drug Manager', 'Drug Manager', '[\"dashboard\",\"patients\",\"patient\\/add\",\"patient\\/edit\",\"patient\\/delete\",\"patient\\/view\",\"patient\\/sendmail\",\"appointments\",\"appointment\\/add\",\"appointment\\/edit\",\"appointment\\/delete\",\"appointment\\/view\",\"appointment\\/sendmail\",\"report\\/reportUpload\",\"report\\/removeReport\",\"prescriptions\",\"prescription\\/add\",\"prescription\\/edit\",\"prescription\\/delete\",\"prescription\\/view\",\"prescription\\/pdf\",\"request\",\"request\\/edit\",\"request\\/delete\",\"doctors\",\"birthrecords\",\"deathrecords\",\"noticeboard\",\"noticeboard\\/view\",\"notes\",\"note\\/add\",\"note\\/edit\",\"send\\/email\"]', '2019-08-06 01:35:59'),
(5, 'Accountant', 'clinic\'s doctors', '[\"dashboard\",\"invoices\",\"invoice\\/add\",\"invoice\\/edit\",\"invoice\\/delete\",\"invoice\\/view\",\"invoice\\/pdf\",\"invoice\\/sentmail\",\"addpayment\",\"medicine\\/purchase\",\"medicine\\/purchase\\/add\",\"medicine\\/purchase\\/edit\",\"medicine\\/purchase\\/delete\",\"medicine\\/purchase\\/view\",\"medicine\\/purchase\\/pdf\",\"accounts\",\"account\\/add\",\"account\\/edit\",\"account\\/delete\",\"account\\/transactions\",\"account\\/transaction\\/add\",\"account\\/transaction\\/edit\",\"account\\/transaction\\/delete\",\"reports\",\"expenses\",\"expense\\/add\",\"expense\\/edit\",\"expense\\/delete\",\"expensetype\",\"expensetype\\/add\",\"expensetype\\/edit\",\"expensetype\\/delete\",\"salarytemplate\",\"salarytemplate\\/add\",\"salarytemplate\\/edit\",\"salarytemplate\\/delete\",\"managesalary\",\"managesalary\\/add\",\"managesalary\\/edit\",\"managesalary\\/view\",\"payment\",\"payment\\/view\",\"payment\\/pdf\",\"makepayment\",\"makepayment\\/add\",\"tax\",\"tax\\/add\",\"tax\\/edit\",\"tax\\/delete\",\"paymentmethod\",\"paymentmethod\\/add\",\"paymentmethod\\/edit\",\"paymentmethod\\/delete\",\"items\",\"item\\/add\",\"item\\/edit\",\"item\\/delete\"]', '2019-08-06 01:35:59'),
(6, 'Employee', 'Employee', '[\"customers\",\"invoices\",\"medicines\",\"expenses\",\"salarytemplate\\/edit\",\"noticeboard\",\"noticeboard\\/add\"]', '2019-10-24 05:31:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kk_accounts`
--
ALTER TABLE `kk_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_account_transaction`
--
ALTER TABLE `kk_account_transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_attached_files`
--
ALTER TABLE `kk_attached_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_customers`
--
ALTER TABLE `kk_customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `kk_doctors`
--
ALTER TABLE `kk_doctors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_email_logs`
--
ALTER TABLE `kk_email_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_email_template`
--
ALTER TABLE `kk_email_template`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_expenses`
--
ALTER TABLE `kk_expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_expense_type`
--
ALTER TABLE `kk_expense_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_invoice`
--
ALTER TABLE `kk_invoice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_items`
--
ALTER TABLE `kk_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_login_attempts`
--
ALTER TABLE `kk_login_attempts`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `kk_media`
--
ALTER TABLE `kk_media`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_medicines`
--
ALTER TABLE `kk_medicines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_medicine_batch`
--
ALTER TABLE `kk_medicine_batch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_medicine_bill`
--
ALTER TABLE `kk_medicine_bill`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_medicine_category`
--
ALTER TABLE `kk_medicine_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_medicine_purchase`
--
ALTER TABLE `kk_medicine_purchase`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_menu`
--
ALTER TABLE `kk_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_noticeboard`
--
ALTER TABLE `kk_noticeboard`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_payments`
--
ALTER TABLE `kk_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_payment_method`
--
ALTER TABLE `kk_payment_method`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_salarytemplate`
--
ALTER TABLE `kk_salarytemplate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_setting`
--
ALTER TABLE `kk_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_staff_attendance`
--
ALTER TABLE `kk_staff_attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_staff_payment`
--
ALTER TABLE `kk_staff_payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_subscribe`
--
ALTER TABLE `kk_subscribe`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `kk_suppliers`
--
ALTER TABLE `kk_suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_taxes`
--
ALTER TABLE `kk_taxes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kk_users`
--
ALTER TABLE `kk_users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `user_name` (`user_name`);

--
-- Indexes for table `kk_user_role`
--
ALTER TABLE `kk_user_role`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kk_accounts`
--
ALTER TABLE `kk_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `kk_account_transaction`
--
ALTER TABLE `kk_account_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `kk_attached_files`
--
ALTER TABLE `kk_attached_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kk_customers`
--
ALTER TABLE `kk_customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `kk_doctors`
--
ALTER TABLE `kk_doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `kk_email_logs`
--
ALTER TABLE `kk_email_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kk_email_template`
--
ALTER TABLE `kk_email_template`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `kk_expenses`
--
ALTER TABLE `kk_expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `kk_expense_type`
--
ALTER TABLE `kk_expense_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `kk_invoice`
--
ALTER TABLE `kk_invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `kk_items`
--
ALTER TABLE `kk_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `kk_login_attempts`
--
ALTER TABLE `kk_login_attempts`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kk_media`
--
ALTER TABLE `kk_media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `kk_medicines`
--
ALTER TABLE `kk_medicines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `kk_medicine_batch`
--
ALTER TABLE `kk_medicine_batch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `kk_medicine_bill`
--
ALTER TABLE `kk_medicine_bill`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `kk_medicine_category`
--
ALTER TABLE `kk_medicine_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `kk_medicine_purchase`
--
ALTER TABLE `kk_medicine_purchase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `kk_menu`
--
ALTER TABLE `kk_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `kk_noticeboard`
--
ALTER TABLE `kk_noticeboard`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `kk_payments`
--
ALTER TABLE `kk_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `kk_payment_method`
--
ALTER TABLE `kk_payment_method`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `kk_salarytemplate`
--
ALTER TABLE `kk_salarytemplate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `kk_setting`
--
ALTER TABLE `kk_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kk_staff_attendance`
--
ALTER TABLE `kk_staff_attendance`
  MODIFY `id` int(200) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kk_staff_payment`
--
ALTER TABLE `kk_staff_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `kk_subscribe`
--
ALTER TABLE `kk_subscribe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kk_suppliers`
--
ALTER TABLE `kk_suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `kk_taxes`
--
ALTER TABLE `kk_taxes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `kk_users`
--
ALTER TABLE `kk_users`
  MODIFY `user_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `kk_user_role`
--
ALTER TABLE `kk_user_role`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

