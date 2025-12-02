-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 11, 2025 at 12:17 PM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `realestate_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

DROP TABLE IF EXISTS `contact_messages`;
CREATE TABLE IF NOT EXISTS `contact_messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(1, 'Ismail Gheewala', 'patelkaif483@gmail.com', 'This is demo message from Ismail Gheewala, Thanks', '2025-09-04 13:06:27'),
(2, 'Kaif Patel', 'ismailgheewala01@gmail.com', 'This is also demo message to check SweetAlert Demo', '2025-09-04 13:14:18');

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

DROP TABLE IF EXISTS `properties`;
CREATE TABLE IF NOT EXISTS `properties` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `price` decimal(12,2) NOT NULL,
  `sqrft` int DEFAULT NULL,
  `type` enum('Buy','Rent') DEFAULT NULL,
  `location` varchar(255) NOT NULL,
  `address` text,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `category` varchar(50) NOT NULL DEFAULT 'House',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`id`, `title`, `description`, `price`, `sqrft`, `type`, `location`, `address`, `image_path`, `created_at`, `category`) VALUES
(34, 'Hillside Land', 'A beautiful elevated plot of land with stunning hill views, well-connected to the main city road, ideal for residential or small commercial projects.', 4000000.00, 1200, 'Buy', 'Narmada, Gujarat', 'Plot No. 12, Hillside Area, Narmada, Gujarat, 392001', '../PHP Project/uploads/land_1.jpg', '2025-09-26 04:10:57', 'Land'),
(35, 'Sunset Villa', 'Luxury villa featuring 4 bedrooms, 3 bathrooms, a private pool, and panoramic sea views. Designed with modern architecture and premium interiors.', 12000000.00, 3500, 'Buy', 'Baga Beach, Goa', 'Sunset Villa, Beach Road, Baga Beach, Bardez, Goa, 403001', 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c', '2025-09-26 04:10:57', 'Villa'),
(36, 'Lakeview Apartment', 'Spacious 3-bedroom apartment overlooking a serene lake, with a balcony, modern kitchen, and parking facilities. Close to shopping centers and public transport.', 8000000.00, 1500, 'Buy', 'Pune, Maharashtra', 'Flat No. 302, Lakeview Apartments, Koregaon Park, Pune, Maharashtra, 411001', 'https://images.unsplash.com/photo-1572120360610-d971b9b22f06', '2025-09-26 04:10:57', 'Apartment'),
(37, 'Maple House', 'Elegant house with 3 bedrooms, 2 bathrooms, and a landscaped garden. Located in a peaceful residential neighborhood with easy access to schools and markets.', 6000000.00, 2000, 'Buy', 'Bangalore, Karnataka', 'Maple House, 45 Green Street, Whitefield, Bangalore, Karnataka, 560001', 'https://images.unsplash.com/photo-1568605114967-8130f3a36994', '2025-09-26 04:10:57', 'House'),
(38, 'City Center Land', 'Prime commercial land suitable for constructing offices or retail spaces. Centrally located with excellent city connectivity.', 15000000.00, 5000, 'Buy', 'Mumbai, Maharashtra', 'Plot No. 101, City Center, Fort Area, Mumbai, Maharashtra, 400001', 'https://images.unsplash.com/photo-1599423300746-b62533397364', '2025-09-26 04:10:57', 'Land'),
(39, 'Green Villa', 'Eco-friendly villa with 4 bedrooms, private garden, and solar panels. Sustainable design with ample natural lighting and ventilation.', 10000000.00, 3200, 'Buy', 'Chandigarh', 'Green Villa, Sector 12, Chandigarh, Punjab, 160012', 'https://images.unsplash.com/photo-1598300057195-5a8d899ad73b', '2025-09-26 04:10:57', 'Villa'),
(40, 'Riverside Apartment', 'Modern apartment with riverfront view, 2 bedrooms, and high-quality interiors. Amenities include gym, parking, and 24/7 security.', 9000000.00, 1400, 'Buy', 'Kolkata, West Bengal', 'Flat No. 21, Riverside Apartments, Strand Road, Kolkata, West Bengal, 700001', 'https://images.unsplash.com/photo-1572120360610-d971b9b22f06', '2025-09-26 04:10:57', 'Apartment'),
(41, 'Oak House', 'Stylish house with 3 bedrooms, garage, private backyard, and contemporary interiors. Located in a calm neighborhood with easy city access.', 7000000.00, 2200, 'Buy', 'Chennai, Tamil Nadu', 'Oak House, 56 Palm Street, Adyar, Chennai, Tamil Nadu, 600001', 'https://images.unsplash.com/photo-1568605114967-8130f3a36994', '2025-09-26 04:10:57', 'House'),
(42, 'Sunny Land', 'Open plot with excellent sunlight, suitable for residential building. Easy road access and nearby amenities make it a perfect investment.', 3500000.00, 1000, 'Buy', 'Jaipur, Rajasthan', 'Plot No. 55, Sunny Land, Vaishali Nagar, Jaipur, Rajasthan, 302001', 'https://images.unsplash.com/photo-1580584122230-8b9f67147c8f', '2025-09-26 04:10:57', 'Land'),
(43, 'Blue Lagoon Villa', 'Sea-facing villa with 4 bedrooms, private beach, and swimming pool. Designed with modern architecture for luxury living.', 15000000.00, 4000, 'Buy', 'Kerala', 'Blue Lagoon Villa, Coastal Road, Kovalam, Kerala, 695001', 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c', '2025-09-26 04:10:57', 'Villa'),
(44, 'Skyline Apartment', 'High-rise apartment with 3 bedrooms and stunning city skyline views. Fully furnished with modern facilities including gym and security.', 8500000.00, 1600, 'Buy', 'Hyderabad, Telangana', 'Flat No. 101, Skyline Apartments, Banjara Hills, Hyderabad, Telangana, 500001', 'https://images.unsplash.com/photo-1572120360610-d971b9b22f06', '2025-09-26 04:10:57', 'Apartment'),
(45, 'Pine House', 'Cozy house with 3 bedrooms, backyard garden, and contemporary interiors. Located in a friendly community with good schools nearby.', 6500000.00, 2100, 'Buy', 'Lucknow, Uttar Pradesh', 'Pine House, 12 Rose Street, Gomti Nagar, Lucknow, Uttar Pradesh, 226001', 'https://images.unsplash.com/photo-1568605114967-8130f3a36994', '2025-09-26 04:10:57', 'House'),
(46, 'Forest Land', 'Scenic plot surrounded by lush forest, perfect for building a private villa or retreat. Peaceful environment with fresh air and privacy.', 4500000.00, 1800, 'Buy', 'Dehradun, Uttarakhand', 'Plot No. 23, Forest Land, Rajpur Road, Dehradun, Uttarakhand, 248001', 'uploads/1760184895_test.jpg', '2025-09-26 04:10:57', 'Land'),
(47, 'Oceanview Villa', 'Luxury villa with 4 bedrooms, infinity pool, and panoramic ocean views. Modern design with spacious interiors.', 14000000.00, 3600, 'Buy', 'Goa', 'Oceanview Villa, Beachside Road, Candolim, Goa, 403001', 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c', '2025-09-26 04:10:57', 'Villa'),
(48, 'Riverfront Apartment', 'Contemporary apartment with 2 bedrooms and private balcony overlooking the river. Well-connected to city amenities and transport.', 9200000.00, 1550, 'Buy', 'Kolkata, West Bengal', 'Flat No. 33, Riverfront Apartments, Strand Road, Kolkata, West Bengal, 700001', 'https://images.unsplash.com/photo-1572120360610-d971b9b22f06', '2025-09-26 04:10:57', 'Apartment'),
(49, 'Maple Leaf House', 'Elegant house with 3 bedrooms, maple leaf garden, and modern interiors. Ideal for families looking for a peaceful neighborhood.', 7200000.00, 2250, 'Buy', 'Bangalore, Karnataka', 'Maple Leaf House, 67 Green Street, Whitefield, Bangalore, Karnataka, 560001', 'https://images.unsplash.com/photo-1568605114967-8130f3a36994', '2025-09-26 04:10:57', 'House'),
(51, 'Vinland', 'Far west, across the sea, there is a land called Vinland. It’s warm. And fertile. A faraway land, where neither slave traders nor the flames of war reach.', 1000.00, 1000, 'Rent', 'Far west, across the sea.', 'Far west, across the sea, there is a land called Vinland.', '../PHP Project/uploads/prop_68ea497e2f306.jpg', '2025-10-11 12:13:10', 'Land');

-- --------------------------------------------------------

--
-- Table structure for table `property_orders`
--

DROP TABLE IF EXISTS `property_orders`;
CREATE TABLE IF NOT EXISTS `property_orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `property_id` int DEFAULT NULL,
  `order_type` enum('Buy','Rent') NOT NULL DEFAULT 'Buy',
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `message` text,
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `property_orders`
--

INSERT INTO `property_orders` (`id`, `property_id`, `order_type`, `name`, `email`, `phone`, `message`, `status`, `created_at`) VALUES
(1, 5, 'Buy', 'Ismail Gheewala', 'patelkaif483@gmail.com', '9876543214', 'I am interested in buying this property.', 'Pending', '2025-09-05 17:09:26');

-- --------------------------------------------------------

--
-- Table structure for table `property_requests`
--

DROP TABLE IF EXISTS `property_requests`;
CREATE TABLE IF NOT EXISTS `property_requests` (
  `id` int NOT NULL AUTO_INCREMENT,
  `property_id` int DEFAULT NULL,
  `user_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `request_type` enum('Buy','Add') NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `location` varchar(255) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `type` enum('Buy','Rent') NOT NULL,
  `sqrft` int DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `property_requests`
--

INSERT INTO `property_requests` (`id`, `property_id`, `user_id`, `name`, `email`, `phone`, `message`, `request_type`, `created_at`, `status`, `title`, `description`, `price`, `location`, `image_path`, `category`, `type`, `sqrft`, `address`) VALUES
(1, 48, 1, '', '', '', 'I am interested in buying this property.', 'Buy', '2025-09-26 05:26:40', 'rejected', '', '', 0.00, '', '', '', 'Buy', NULL, NULL),
(2, 38, 1, '', '', '', 'I am interested in buying this property.', 'Buy', '2025-09-26 05:34:39', 'pending', '', '', 0.00, '', '', '', 'Buy', NULL, NULL),
(3, NULL, 1, '', '', '', '', 'Add', '2025-09-26 05:56:12', 'approved', 'NB Palace', 'asdfghjklqwertyuiopzxcvbnm,okijuygtfrdeswdefrgthyjukilo;p', 1200000.00, 'Pariej Guu, Bhruch', 'https://images.unsplash.com/photo-1570129477492-45c003edd2be?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 'House', 'Buy', NULL, NULL),
(4, NULL, 1, '', '', '', '', 'Add', '2025-09-26 06:17:20', 'pending', 'Milat', 'qwertyuiopasdfghjklzxcvbnm,qwertyuiopasdfghjklzxcvbnm,mnbvcxzasdfghjkl;poiuytrewq', 1230000.00, 'Millat Nagr, Bhruch', 'https://images.unsplash.com/photo-1570129477492-45c003edd2be?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 'Land', 'Rent', 4500, 'asdfghjkl asdfghjk,asdfghjk asdfghjkl qwertyui'),
(5, NULL, 4, '', '', '', '', 'Add', '2025-10-11 12:11:42', 'approved', 'Vinland', 'Far west, across the sea, there is a land called Vinland. It’s warm. And fertile. A faraway land, where neither slave traders nor the flames of war reach.', 1000.00, 'Far west, across the sea.', '../PHP Project/uploads/prop_68ea497e2f306.jpg', 'Land', 'Rent', 1000, 'Far west, across the sea, there is a land called Vinland.');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `phone_number` (`phone_number`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `phone_number`, `password`, `created_at`) VALUES
(1, 'Ismail Gheewala', 'patelkaif483@gmail.com', '9876543214', '$2y$10$3KKShlGJJ5HMok1/2Smysu2EE5AZcp9/nU7YS/Mb49nscJbuvCoXC', '2025-09-02 16:40:02'),
(2, 'Kaif Patel', 'ismailgheewala001@gmail.com', '7777852465', '$2y$10$XNvWbyr4t1OpyL4Ks85ZzuYHwlhPLIt5tC5qiTaPC6MosTJEwhQH.', '2025-09-06 09:45:11'),
(3, 'Faiz Hira', 'faiz12@gmail.com', '9876543245', '$2y$10$64XWRrCJPzA6iWYiKebvvuithy2sZNndjgznibfY90/.W3LsU/ij6', '2025-09-14 09:49:20'),
(4, 'Affan', 'affan@gmail.com', '1234567890', '$2y$10$wFdMDNbAtj/7Uc2bV4G1rOroew7PsGB1Lbq8FQJb7Q5rov3pRHB0q', '2025-10-11 12:04:02');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
