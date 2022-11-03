CREATE TABLE `notifications_companies` (
 `id` int(10) NOT NULL AUTO_INCREMENT,
 `company_id` int(10) NOT NULL,
 `sender` int(10) NOT NULL,
 `subject` varchar(50) NOT NULL,
 `message` text DEFAULT NULL,
 `link` text DEFAULT NULL,
 `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
 `status` enum('read','unread') DEFAULT 'unread',
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=latin1