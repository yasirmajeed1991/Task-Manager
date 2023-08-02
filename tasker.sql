-- phpMyAdmin SQL Dump
-- version 5.3.0-dev+20220918.6792b17e72
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 02, 2023 at 08:23 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tasker`
--

-- --------------------------------------------------------

--
-- Table structure for table `borrower`
--

CREATE TABLE `borrower` (
  `id` int(11) NOT NULL,
  `loan_no_id` varchar(255) NOT NULL,
  `borrower` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `borrower`
--

INSERT INTO `borrower` (`id`, `loan_no_id`, `borrower`, `created_by`, `created_at`, `updated_at`) VALUES
(20, '19', 'Rodriguez', 1, '2023-03-30 08:36:55', '2023-03-30 08:36:55'),
(21, '19', 'Raul', 1, '2023-03-30 08:37:22', '2023-03-30 08:37:22'),
(23, '22', 'John Doe', 24, '2023-04-10 13:15:42', '2023-04-10 13:15:42');

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `id` int(11) NOT NULL,
  `branch` varchar(250) NOT NULL,
  `address` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`id`, `branch`, `address`, `contact`, `created_at`, `updated_at`) VALUES
(9, 'Berger Branch', 'test test', '13212321313', '2023-03-23 12:09:13', '2023-03-23 15:17:09');

-- --------------------------------------------------------

--
-- Table structure for table `email_alert`
--

CREATE TABLE `email_alert` (
  `id` int(11) NOT NULL,
  `order_outs_id` int(11) NOT NULL,
  `date_sent` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `follow_up`
--

CREATE TABLE `follow_up` (
  `id` int(11) NOT NULL,
  `order_out_id` int(11) NOT NULL,
  `follow_up_date` varchar(255) NOT NULL,
  `remarks_notes` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `loan_no`
--

CREATE TABLE `loan_no` (
  `id` int(11) NOT NULL,
  `loan_no` varchar(255) NOT NULL,
  `branch` int(11) NOT NULL,
  `processor` int(11) NOT NULL,
  `coordinator` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `loan_no`
--

INSERT INTO `loan_no` (`id`, `loan_no`, `branch`, `processor`, `coordinator`, `created_by`, `created_at`, `updated_at`) VALUES
(19, '46122301379636', 9, 11, '[\"23\"]', 1, '2023-03-30 08:36:41', '2023-03-30 08:36:41'),
(22, '123456789abc', 9, 8, '[\"12\"]', 24, '2023-04-10 13:15:05', '2023-04-10 13:15:05');

-- --------------------------------------------------------

--
-- Table structure for table `mapping`
--

CREATE TABLE `mapping` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `coordinator` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mapping`
--

INSERT INTO `mapping` (`id`, `user_id`, `coordinator`, `created_at`, `updated_at`) VALUES
(15, 9, 12, '2023-03-30 08:28:49', '2023-03-30 08:28:49'),
(16, 9, 16, '2023-03-30 08:29:09', '2023-03-30 08:29:09'),
(17, 9, 20, '2023-03-30 08:29:23', '2023-03-30 08:29:23'),
(18, 11, 12, '2023-03-30 08:30:10', '2023-03-30 08:30:10'),
(19, 11, 23, '2023-03-30 08:31:13', '2023-03-30 08:31:13'),
(20, 10, 13, '2023-03-30 08:31:47', '2023-03-30 08:31:47'),
(21, 10, 14, '2023-03-30 08:32:00', '2023-03-30 08:32:00'),
(22, 8, 12, '2023-03-30 08:32:37', '2023-03-30 08:32:37'),
(23, 8, 15, '2023-03-30 08:33:26', '2023-03-30 08:33:26'),
(24, 8, 17, '2023-03-30 08:33:38', '2023-03-30 08:33:38'),
(25, 8, 19, '2023-03-30 08:34:08', '2023-03-30 08:34:08'),
(26, 8, 21, '2023-03-30 08:34:46', '2023-03-30 08:34:46');

-- --------------------------------------------------------

--
-- Table structure for table `order_outs`
--

CREATE TABLE `order_outs` (
  `id` int(11) NOT NULL,
  `scrub_id` varchar(255) NOT NULL,
  `type_of_request` varchar(255) NOT NULL,
  `due_date` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `date_time_ordered` varchar(255) NOT NULL,
  `screen_updated` varchar(255) NOT NULL,
  `date_time_completed` varchar(255) NOT NULL,
  `remarks` text NOT NULL,
  `priority` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_outs`
--

INSERT INTO `order_outs` (`id`, `scrub_id`, `type_of_request`, `due_date`, `status`, `date_time_ordered`, `screen_updated`, `date_time_completed`, `remarks`, `priority`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(30, '16', '1', '2023-03-30', 'On Going', '2023-03-30 04:44:50', 'Yes', '', 'Called #8664872643 and as per automated voice gave the email to mortgage@asiservice.com and the ETA is 24-48 hrs<br>', 'high', 1, 1, '2023-03-30 08:44:50', '2023-03-30 08:45:35'),
(31, '16', '28', '2023-03-30', 'On Going', '2023-03-30 04:52:55', 'Yes', '', 'Pending Mtg Statement or Mtg Note/still no update 2/7/send text&nbsp; up to to borr up to borrowet emial and text message and send a text to edwards 980 699-0027 to get copy of mortgage notes2/16 send another text to MR.raul to get another number for Mr edwards the number he gives is not responding.<br>											', 'high', 1, 1, '2023-03-30 08:52:55', '2023-03-30 08:53:07'),
(32, '16', '3', '2023-03-30', 'On Going', '2023-03-30 04:54:13', 'Yes', '', 'Pending Mtg Statement or Mtg Note/still no update 2/7/send text&nbsp; up to to borr up to borrowet emial and text message and send a text to edwards 980 699-0027 to get copy of mortgage notes2/16 send another text to MR.raul to get another number for Mr edwards the number he gives is not responding.<br>											', 'high', 1, 1, '2023-03-30 08:54:13', '2023-03-30 08:54:26'),
(33, '16', '5', '2023-03-27', 'On Going', '2023-03-30 04:55:42', 'Yes', '', 'Emailed&nbsp; JOSHSJM@YAHOO.COM&nbsp; to get new and working number./as per josh the company number is not working and used personal number only.Not reflected in google											', 'high', 1, 1, '2023-03-30 08:55:42', '2023-03-30 08:55:51'),
(34, '16', '7', '2023-03-30', 'On Going', '2023-03-30 05:09:48', 'Yes', '', '						Checking the required Details of the Capactity', 'high', 23, 23, '2023-03-30 09:09:48', '2023-03-30 09:10:16');

-- --------------------------------------------------------

--
-- Table structure for table `over_due`
--

CREATE TABLE `over_due` (
  `id` int(11) NOT NULL,
  `branch` int(11) NOT NULL,
  `days` int(11) NOT NULL,
  `hours` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `over_due`
--

INSERT INTO `over_due` (`id`, `branch`, `days`, `hours`, `created_at`, `updated_at`) VALUES
(1, 9, 1, 0, '2023-03-30 08:58:17', '2023-03-30 08:58:17');

-- --------------------------------------------------------

--
-- Table structure for table `scrub`
--

CREATE TABLE `scrub` (
  `id` int(11) NOT NULL,
  `loan_no_id` varchar(255) NOT NULL,
  `request_date_time` varchar(255) NOT NULL,
  `date_time_started` varchar(255) NOT NULL,
  `date_time_completed` varchar(255) NOT NULL,
  `title_request` varchar(255) NOT NULL,
  `status_of_title_request` varchar(255) NOT NULL,
  `status_of_scrub` varchar(255) NOT NULL,
  `remarks_notes` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `scrub`
--

INSERT INTO `scrub` (`id`, `loan_no_id`, `request_date_time`, `date_time_started`, `date_time_completed`, `title_request`, `status_of_title_request`, `status_of_scrub`, `remarks_notes`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(16, '19', '2023-03-30', '2023-03-30 04:38:01', '2023-03-30 17:37:03', '2023-03-30T13:37', 'Received', 'Completed', 'Requested Commitment, CPL, Wiring Instructions, CD | 2/7 title docs are in - christian<br>										', 1, 1, '2023-03-30 08:38:01', '2023-03-30 21:37:03');

-- --------------------------------------------------------

--
-- Table structure for table `scrub_followup`
--

CREATE TABLE `scrub_followup` (
  `id` int(11) NOT NULL,
  `scrub_id` varchar(255) NOT NULL,
  `followup_date` varchar(255) NOT NULL,
  `remarks` text NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `cover_img` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`id`, `name`, `email`, `contact`, `address`, `cover_img`, `created_at`, `updated_at`) VALUES
(1, 'Task Manager', 'info@sample.comm', '+923146850461', '0', '', '2023-03-07 07:38:31', '2023-03-07 07:38:31');

-- --------------------------------------------------------

--
-- Table structure for table `type_of_request`
--

CREATE TABLE `type_of_request` (
  `id` int(11) NOT NULL,
  `type_of_request` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `type_of_request`
--

INSERT INTO `type_of_request` (`id`, `type_of_request`, `created_at`, `updated_at`) VALUES
(1, 'HOI, RCE & Invoice', '2023-03-07 07:39:07', '2023-03-22 11:42:02'),
(3, 'Mortgage Payoff', '2023-03-07 07:39:07', '2023-03-07 07:39:07'),
(5, 'Phone Verification', '2023-03-07 07:39:07', '2023-03-07 07:39:07'),
(6, '4 Current', '2023-03-07 07:39:07', '2023-03-07 07:39:07'),
(7, 'Credit Supplement', '2023-03-07 07:39:07', '2023-03-07 07:39:07'),
(8, 'Pest Inspection', '2023-03-07 07:39:07', '2023-03-07 07:39:07'),
(9, 'HELOC Payoff', '2023-03-07 07:39:07', '2023-03-07 07:39:07'),
(10, '7 (all 3 mtgs)', '2023-03-07 07:39:07', '2023-03-07 07:39:07'),
(11, '4 (months paid in a yr)', '2023-03-07 07:39:07', '2023-03-07 07:39:07'),
(12, '4 B1', '2023-03-07 07:39:07', '2023-03-07 07:39:07'),
(13, '4 B2', '2023-03-07 07:39:07', '2023-03-07 07:39:07'),
(14, '6 B1', '2023-03-07 07:39:07', '2023-03-07 07:39:07'),
(15, '4 Prior 2 B1', '2023-03-07 07:39:07', '2023-03-07 07:39:07'),
(16, '4 Prior B2', '2023-03-07 07:39:07', '2023-03-07 07:39:07'),
(17, '3 (netted)', '2023-03-07 07:39:07', '2023-03-07 07:39:07'),
(18, 'Tax Transcript (1040)', '2023-03-07 07:39:07', '2023-03-07 07:39:07'),
(19, 'Master Insurance', '2023-03-07 07:39:07', '2023-03-07 07:39:07'),
(20, 'Condo Questionnaire', '2023-03-07 07:39:07', '2023-03-07 07:39:07'),
(21, 'Collection Payoff', '2023-03-07 07:39:07', '2023-03-07 07:39:07'),
(22, '12 (# of months paid in yr)', '2023-03-07 07:39:07', '2023-03-07 07:39:07'),
(23, '7 (Reorder)', '2023-03-07 07:39:07', '2023-03-07 07:39:07'),
(24, '4 Prior', '2023-03-07 07:39:07', '2023-03-07 07:39:07'),
(25, 'Flood Insurance', '2023-03-07 07:39:07', '2023-03-07 07:39:07'),
(26, '4 (rush)', '2023-03-07 07:39:07', '2023-03-07 07:39:07'),
(28, 'VOM', '2023-03-30 08:52:27', '2023-03-30 08:52:27');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(30) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `branch` varchar(255) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 2 COMMENT '1 = admin, \r\n2 = processor,\r\n3 = coordinator\r\n',
  `avatar` text NOT NULL DEFAULT 'no-image-available.png',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `branch`, `type`, `avatar`, `date_created`, `updated_at`) VALUES
(1, 'Aaron', 'Pitterman', 'admin@admin.com', '21232f297a57a5a743894a0e4a801fc3', '0', 1, 'no-image-available.png', '2023-03-23 16:35:43', '2023-08-02 18:13:06'),
(8, 'Tayler', 'King', 'tayler@test.com', '21232f297a57a5a743894a0e4a801fc3', '9', 2, 'no-image-available.png', '2023-03-30 07:58:43', '2023-03-30 07:58:43'),
(9, 'Amanda', 'Miksa', 'amanda@test.com', '21232f297a57a5a743894a0e4a801fc3', '9', 2, 'no-image-available.png', '2023-03-30 07:59:17', '2023-03-30 07:59:17'),
(10, 'Jordan', 'Jonke', 'jordan@test.com', '21232f297a57a5a743894a0e4a801fc3', '9', 2, 'no-image-available.png', '2023-03-30 07:59:55', '2023-03-30 07:59:55'),
(11, 'Danielle', 'Mink', 'danielle@test.com', '21232f297a57a5a743894a0e4a801fc3', '9', 2, 'no-image-available.png', '2023-03-30 08:00:29', '2023-03-30 08:00:29'),
(12, 'Mark', '', 'mark@test.com', '21232f297a57a5a743894a0e4a801fc3', '9', 3, 'no-image-available.png', '2023-03-30 08:02:22', '2023-03-30 08:02:22'),
(13, 'Joed', '', 'joed@test.com', '21232f297a57a5a743894a0e4a801fc3', '9', 3, 'no-image-available.png', '2023-03-30 08:02:50', '2023-03-30 08:02:50'),
(14, 'Emiko', '', 'emiko@test.com', '21232f297a57a5a743894a0e4a801fc3', '9', 3, 'no-image-available.png', '2023-03-30 08:03:17', '2023-03-30 08:03:17'),
(15, 'Karren', '', 'karen@test.com', '21232f297a57a5a743894a0e4a801fc3', '9', 3, 'no-image-available.png', '2023-03-30 08:03:47', '2023-03-30 08:03:47'),
(16, 'Denzel', '', 'denzel@test.com', '21232f297a57a5a743894a0e4a801fc3', '9', 3, 'no-image-available.png', '2023-03-30 08:04:14', '2023-03-30 08:04:14'),
(17, 'Kristel', '', 'kristel@test.com', '21232f297a57a5a743894a0e4a801fc3', '9', 3, 'no-image-available.png', '2023-03-30 08:04:37', '2023-03-30 08:04:37'),
(18, 'Princess', '', 'princess@test.com', '21232f297a57a5a743894a0e4a801fc3', '9', 3, 'no-image-available.png', '2023-03-30 08:05:02', '2023-03-30 08:05:02'),
(19, 'Daisy', '', 'daisy@test.com', '21232f297a57a5a743894a0e4a801fc3', '9', 3, 'no-image-available.png', '2023-03-30 08:05:38', '2023-03-30 08:05:38'),
(20, 'Jocel', '', 'jocel@test.com', '21232f297a57a5a743894a0e4a801fc3', '9', 3, 'no-image-available.png', '2023-03-30 08:06:22', '2023-03-30 08:06:22'),
(21, 'Christian', '', 'christian@test.com', '21232f297a57a5a743894a0e4a801fc3', '9', 3, 'no-image-available.png', '2023-03-30 08:07:05', '2023-03-30 08:07:05'),
(22, 'Karren', '', 'karren@test.com', '21232f297a57a5a743894a0e4a801fc3', '9', 3, 'no-image-available.png', '2023-03-30 08:07:31', '2023-03-30 08:07:31'),
(23, 'Franco', '', 'franco@test.com', '21232f297a57a5a743894a0e4a801fc3', '9', 3, 'no-image-available.png', '2023-03-30 08:30:56', '2023-03-30 08:30:56'),
(24, 'Nathan', 'Cariaga', 'ncariaga@nightowl.consulting', '4bc61fc2ba6e072cdd75fbcf1faa2a1f', '9', 1, 'no-image-available.png', '2023-04-03 19:52:10', '2023-04-03 19:52:10'),
(25, 'Robert Emmanuel', 'Acuyan', 'reacuyan@nightowl.consulting', '55667c3a09009bbf148b1dc7d0e7b9ea', '9', 1, 'no-image-available.png', '2023-04-03 19:57:16', '2023-04-04 10:57:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `borrower`
--
ALTER TABLE `borrower`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `follow_up`
--
ALTER TABLE `follow_up`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loan_no`
--
ALTER TABLE `loan_no`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mapping`
--
ALTER TABLE `mapping`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_outs`
--
ALTER TABLE `order_outs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `over_due`
--
ALTER TABLE `over_due`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scrub`
--
ALTER TABLE `scrub`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scrub_followup`
--
ALTER TABLE `scrub_followup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `type_of_request`
--
ALTER TABLE `type_of_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `borrower`
--
ALTER TABLE `borrower`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `follow_up`
--
ALTER TABLE `follow_up`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loan_no`
--
ALTER TABLE `loan_no`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `mapping`
--
ALTER TABLE `mapping`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `order_outs`
--
ALTER TABLE `order_outs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `over_due`
--
ALTER TABLE `over_due`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `scrub`
--
ALTER TABLE `scrub`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `scrub_followup`
--
ALTER TABLE `scrub_followup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `type_of_request`
--
ALTER TABLE `type_of_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
