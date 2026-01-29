-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 25, 2026 at 08:18 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cow_kino`
--

-- --------------------------------------------------------

--
-- Table structure for table `buyer`
--

CREATE TABLE `buyer` (
  `id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `selected_questions` text DEFAULT NULL,
  `extra_details` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buyer`
--

INSERT INTO `buyer` (`id`, `email`, `selected_questions`, `extra_details`) VALUES
(1, 'rafsan4576@gmail.com', 'How to report a bad seller?', 'do u have vets ?'),
(2, 'rafsan4576@gmail.com', 'Are the breeds authentic?', 'is there any meds for bulss?'),
(3, 'rafsan4576@gmail.com', 'Do we have personal contact with the seller?', 'response fast'),
(4, 'rafsan4576@gmail.com', 'Do we have personal contact with the seller?', ''),
(5, 'rafsan4576@gmail.com', 'Are the breeds authentic?', 'oo'),
(6, 'rafsan4576@gmail.com', 'How to report a bad seller?', 'please contact  asap'),
(7, 'rafsan4576@gmail.com', 'Do we have personal contact with the seller?', 'if yes then how its assure to be a good business ethics'),
(8, 'rafsan1229@gmail.com', 'Are the breeds authentic?', 'if yess then how these are verified?'),
(9, 'rafsan4576@gmail.com', 'Are the breeds authentic?, Do we have personal contact with the seller?', 'please response'),
(10, 'rafsan4576@gmail.com', 'Do we have personal contact with the seller?, How to report a bad seller?', 'rh'),
(11, 'rafsan6969@gmail.com', 'Do we have personal contact with the seller?', 'do u sell drugs?'),
(12, 'rafsan4dgd@gmail.com', 'Do we have personal contact with the seller?, How to report a bad seller?', 'fszfasfa');

-- --------------------------------------------------------

--
-- Table structure for table `cows`
--

CREATE TABLE `cows` (
  `name` varchar(20) NOT NULL,
  `id` int(11) NOT NULL,
  `price` int(20) NOT NULL,
  `breed` varchar(20) NOT NULL,
  `age` float NOT NULL,
  `weight` int(5) NOT NULL,
  `photo_url` varchar(150) NOT NULL,
  `description` varchar(500) NOT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cows`
--

INSERT INTO `cows` (`name`, `id`, `price`, `breed`, `age`, `weight`, `photo_url`, `description`, `is_approved`) VALUES
('Bella', 3, 1250, 'Holstein', 3.5, 450, 'beef-cow_0.webp', 'High-yielding dairy cow, very gentle and accustomed to machine milking.', 1),
('Big Red', 4, 2800, 'Brahman', 4, 850, 'cow.webp', 'Premium Brahman bull, excellent muscle mass and disease resistance. Great for breeding.', 1),
('Daisy', 5, 950, 'Jersey', 2.5, 320, 'cow_demo_1.avif', 'Young Jersey cow produces milk with high butterfat content. Very friendly temperament.', 1),
('Rani', 6, 1100, 'Sahiwal', 3, 400, 'cow-9817881_1280.webp', 'Heat-tolerant Sahiwal, perfect for tropical climates. consistent milk producer.', 1),
('Lalu', 7, 850, 'Red Chittagong', 2, 280, 'cow-eating-grass-stockcake.webp', 'Local Red Chittagong variety. Low maintenance and disease resistant. Good for small farms.', 1),
('Maximus', 8, 3200, 'Angus', 5, 920, 'dairy-cow-royalty-free-image-1710959416.avif', 'Heavyweight Angus bull. Prime condition for meat production. Vet checked.', 1),
('Goldie', 9, 1400, 'Guernsey', 3.2, 410, 'istockphoto-139697605-612x612.jpg', 'Produces famous golden milk. Healthy, vaccinated, and ready for a new home.', 1),
('Spot', 10, 1300, 'Ayrshire', 3.8, 480, 'istockphoto-496397741-612x612.jpg', 'Hardy forager, does well in pasture-based systems. Reliable milk production.', 1),
('Rocky', 11, 2100, 'Charolais', 4.5, 880, 'istockphoto-1382389891-612x612.jpg', 'Large Charolais, excellent growth rate. Calm temperament and easy to handle.', 1),
('Gauri', 12, 1050, 'Gir', 2.8, 390, 'photo-1570042225831-d98fa7577f1e.jpg', 'Beautiful Gir cow with distinctive hump. highly adaptable and good milker.', 0),
('Pagla Goru', 14, 1400, 'RedChittagong', 1.5, 850, 'COW_695eb3141973b0.73742884.jpg', 'Pagla goru khabo, yeah ki moja', 0),
('desi goru', 15, 230, 'RedChittagong', 6, 450, 'COW_696098be9f7949.80538060.jpg', 'valo goru', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cow_delivery`
--

CREATE TABLE `cow_delivery` (
  `id` int(11) NOT NULL,
  `client_id` varchar(64) NOT NULL,
  `name` varchar(120) NOT NULL,
  `email` varchar(190) NOT NULL,
  `contact` varchar(30) NOT NULL,
  `pickup_location` varchar(255) NOT NULL,
  `dropoff_location` varchar(255) NOT NULL,
  `distance_km` decimal(6,2) NOT NULL,
  `cow_count` int(11) NOT NULL,
  `delivery_charge` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cow_delivery`
--

INSERT INTO `cow_delivery` (`id`, `client_id`, `name`, `email`, `contact`, `pickup_location`, `dropoff_location`, `distance_km`, `cow_count`, `delivery_charge`, `created_at`) VALUES
(1, '4af2383ff51479c44a8997637ee24c69', 'Rafsan', 'rafsan4576@gmail.com', '01552325481', 'khilkhet', 'gazipur', 25.00, 1, 4500.00, '2026-01-18 09:08:07'),
(2, '4af2383ff51479c44a8997637ee24c69', 'Ali Hashemi Rafsanjani', 'rafsan4576@gmail.com', '01552325481', 'khilkhet', 'uttara', 9.00, 2, 3240.00, '2026-01-18 09:08:42'),
(3, '4af2383ff51479c44a8997637ee24c69', 'Ali Hashemi Rafsanjani', 'rafsan4576@gmail.com', '01552325481', 'khilkhet', 'uttara', 10.00, 2, 3600.00, '2026-01-18 10:29:12'),
(4, '4af2383ff51479c44a8997637ee24c69', 'Ali Hashemi Rafsanjani', 'rafsan4576@gmail.com', '01552325481', 'khilkhet', 'uttara', 10.00, 1, 750.00, '2026-01-19 18:59:17'),
(5, '4af2383ff51479c44a8997637ee24c69', 'Ali Hashemi Rafsanjani', 'rafsan4576@gmail.com', '01552325481', 'khilkhet', 'uttara', 1.00, 1, 75.00, '2026-01-19 18:59:51'),
(6, '4af2383ff51479c44a8997637ee24c69', 'Rafsan', 'rafsan4576@gmail.com', '01552325481', 'khilkhet', 'uttara', 10.00, 1, 1150.00, '2026-01-19 19:15:46'),
(7, '4af2383ff51479c44a8997637ee24c69', 'Ali Hashemi Rafsanjani', 'rafsan4576@gmail.com', '01552325481', 'khilkhet', 'uttara', 10.00, 2, 1200.00, '2026-01-20 08:30:19');

-- --------------------------------------------------------

--
-- Table structure for table `cow_foods`
--

CREATE TABLE `cow_foods` (
  `id` int(11) NOT NULL,
  `name` varchar(120) NOT NULL,
  `description` text NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cow_foods`
--

INSERT INTO `cow_foods` (`id`, `name`, `description`, `price`, `quantity`, `image`, `seller_id`, `created_at`) VALUES
(1, 'Vushi Mix', 'Akij Deshi Home Made Vushi', 300, 3, '14.png', 9, '2026-01-25 19:07:04'),
(2, 'Beef Cattle', 'Akij Food : Home made', 680, 5, '15.png', 69, '2026-01-25 19:12:04'),
(3, 'Milk Booster', 'Akij Milk Booster', 215, 11, '16.png', 69, '2026-01-25 19:12:47'),
(4, 'Beef Builder', 'Organic Food with Natural Meds', 580, 3, '17.png', 69, '2026-01-25 19:13:29');

-- --------------------------------------------------------

--
-- Table structure for table `seller`
--

CREATE TABLE `seller` (
  `id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `selected_questions` text DEFAULT NULL,
  `extra_details` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seller`
--

INSERT INTO `seller` (`id`, `email`, `selected_questions`, `extra_details`) VALUES
(1, 'rafsan4576@gmail.com', 'Do we infiltrate fake buyers?, Do we assure their cow to be sold?', 'do u sell cow foods?'),
(2, 'rafsan4576@gmail.com', 'Are we cutting commissions?, Do we infiltrate fake buyers?', 'please response asap.'),
(3, 'rafsan4576@gmail.com', 'Do we infiltrate fake buyers?', 'rr'),
(4, 'rafsan4576@gmail.com', 'Are we cutting commissions?', 'pp'),
(5, 'rafsan4576@gmail.com', 'Do we assure their cow to be sold?', 'if no then will i be able to withdraw the cow'),
(6, 'rafsan4576@gmail.com', 'Are we cutting commissions?, Do we infiltrate fake buyers?', 'response please'),
(7, 'rafsan4576@gmail.com', 'Do we infiltrate fake buyers?', 'please ans this asap'),
(8, 'rafsan4576@gmail.com', 'Do we infiltrate fake buyers?', 'cnrh'),
(9, 'rafsan76@gmail.com', 'Do we infiltrate fake buyers?', 'dada'),
(10, 'rafsan4242@gmail.com', 'Do we infiltrate fake buyers?, Do we assure their cow to be sold?', 'fafafa');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `name` varchar(120) NOT NULL,
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `user_type` varchar(20) NOT NULL,
  `is_banned` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`name`, `id`, `email`, `password`, `phone`, `user_type`, `is_banned`) VALUES
('Faisal', 5, 'admin@gmail.com', '$2y$10$ECt2uJ3M8IFIm4zXrHW62u3l9nOW4aZyfwQxI/v0SgI7rIBNxHZm6', '1799246459', 'admin', 0),
('Raid', 6, 'buyer@gmail.com', '$2y$10$ECt2uJ3M8IFIm4zXrHW62u3l9nOW4aZyfwQxI/v0SgI7rIBNxHZm6', '1010101010', 'buyer', 0),
('Rafsan', 9, 'seller@gmail.com', '$2y$10$ECt2uJ3M8IFIm4zXrHW62u3l9nOW4aZyfwQxI/v0SgI7rIBNxHZm6', '2147483647', 'seller', 0),
('Rafi', 10, 'rafi@gmail.com', '$2y$10$wH4xkQ5yQKxQpL0xY8e1eO9F6D2w0Z5zM8rR3h9m1R9Rk1H6', '01710000001', 'buyer', 0),
('Nabil', 11, 'nabil@gmail.com', '$2y$10$Z5X0W8H0z6Q4rF1J5K0W1xJp2Yx5bK5nR0r1C4HkY0M6Z2C', '01710000002', 'buyer', 0),
('Sami', 12, 'sami@gmail.com', '$2y$10$gQy7p1yR0cYF1rKxF8C5JzD3pM0R9Q9Qm7E6YpN6MZ2K1K6', '01710000003', 'buyer', 0),
('Arif', 13, 'arif@gmail.com', '$2y$10$2Y6Q8DkK7P1Y8M1FZp3H2K0K1C7Y9E9F5Rk4Z9T2RZ6J9C', '01710000004', 'buyer', 0),
('Tanim', 14, 'tanim@gmail.com', '$2y$10$0H5K1E8F3P6M8Z1F6D7p1Z0F9Q4E8N5YQ2Z6M1C4K0F9Z', '01710000005', 'buyer', 0),
('Sifat', 15, 'sifat@gmail.com', '$2y$10$7F6Y0K9P1Z8ZC2R3K5Y8JZ1N6R6F8F7Z3K8H9KZ2P0Q5', '01710000006', 'buyer', 0),
('Rony', 16, 'rony@gmail.com', '$2y$10$8C5R0Q9M2Z8K1H3Y0FZ9R7C6Y5Z3K9E1M6Z2H0P8Q', '01710000007', 'buyer', 0),
('Shuvo', 17, 'shuvo@gmail.com', '$2y$10$1Z7M6ZP3K8H9QY2E0R0F6Y1Z8C9QK5R4M7P8K3Y', '01710000008', 'buyer', 0),
('Joy', 18, 'joy@gmail.com', '$2y$10$9K2R3Y8H6Z5P1Q8M6ZC7F0R0P5QK9Y4E', '01710000009', 'buyer', 0),
('Sajid', 19, 'sajid@gmail.com', '$2y$10$6Y0K3R8P1Z9Z5M6E2FQ9R7H0P8C4Y', '01710000010', 'buyer', 0),
('Fahim', 20, 'fahim@gmail.com', '$2y$10$8M7Z6F9P5H3Z1Y2Q4R0P9E8Y6ZC1K', '01710000011', 'buyer', 0),
('Hasib', 21, 'hasib@gmail.com', '$2y$10$1QZ8H0Y9P6Z7M3R4F8K6C5E9Y2Z0', '01710000012', 'buyer', 0),
('Nayeem', 22, 'nayeem@gmail.com', '$2y$10$Z6Q8M9K2Y7P1Z0F5R8H3E6C4Y9', '01710000013', 'buyer', 0),
('Bappy', 23, 'bappy@gmail.com', '$2y$10$P1Z9Q6H8R0Z3Y4M7F5E2K6C9Y', '01710000014', 'buyer', 0),
('Imran', 24, 'imran@gmail.com', '$2y$10$8Y6P0QZ9H1MZ3K7R4F5C2E9Y', '01710000015', 'buyer', 0),
('Rasel', 25, 'rasel@gmail.com', '$2y$10$3K9ZP8YH1Q0M6R7F4E5C2', '01710000016', 'buyer', 0),
('Sumon', 26, 'sumon@gmail.com', '$2y$10$Q9Z1K0P3Y8H6M7R4F5C2', '01710000017', 'buyer', 0),
('Masum', 27, 'masum@gmail.com', '$2y$10$Z9Y1P3Q8K0H6M7R4F5', '01710000018', 'buyer', 0),
('Nahid', 28, 'nahid@gmail.com', '$2y$10$Q9Z8Y1P3K0H6M7R4', '01710000019', 'buyer', 0),
('Riad', 29, 'riad@gmail.com', '$2y$10$Z9Y1P3K0H6M7R', '01710000020', 'buyer', 0),
('Sohan', 30, 'sohan@gmail.com', '$2y$10$Z1P3K0H6M7R', '01710000021', 'buyer', 0),
('Mithu', 31, 'mithu@gmail.com', '$2y$10$Y1P3K0H6M7', '01710000022', 'buyer', 0),
('Tanvir', 32, 'tanvir@gmail.com', '$2y$10$P3K0H6M7', '01710000023', 'buyer', 0),
('Rimon', 33, 'rimon@gmail.com', '$2y$10$K0H6M7', '01710000024', 'buyer', 0),
('Alif', 34, 'alif@gmail.com', '$2y$10$H6M7', '01710000025', 'buyer', 0),
('Tareq', 35, 'tareq@gmail.com', '$2y$10$M7', '01710000026', 'buyer', 0),
('Sakib', 36, 'sakib@gmail.com', '$2y$10$K6', '01710000027', 'buyer', 0),
('Asif', 37, 'asif@gmail.com', '$2y$10$Y8', '01710000028', 'buyer', 0),
('Raju', 38, 'raju@gmail.com', '$2y$10$ZK', '01710000029', 'buyer', 0),
('Naim', 39, 'naim@gmail.com', '$2y$10$FQ', '01710000030', 'buyer', 0),
('Pavel', 40, 'pavel@gmail.com', '$2y$10$KZ', '01710000031', 'buyer', 0),
('Hridoy', 41, 'hridoy@gmail.com', '$2y$10$QZ', '01710000032', 'buyer', 0),
('Munna', 42, 'munna@gmail.com', '$2y$10$YQ', '01710000033', 'buyer', 0),
('Shakil', 43, 'shakil@gmail.com', '$2y$10$MZ', '01710000034', 'buyer', 0),
('Sabbir', 44, 'sabbir@gmail.com', '$2y$10$KQ', '01710000035', 'buyer', 0),
('Anik', 45, 'anik@gmail.com', '$2y$10$ZQ', '01710000036', 'buyer', 0),
('Rifat', 46, 'rifat@gmail.com', '$2y$10$Y9', '01710000037', 'buyer', 0),
('Kamal', 47, 'kamal@gmail.com', '$2y$10$H7Z9M8Y1K0QF6R3P4C5E2', '01810000001', 'seller', 0),
('Jamal', 48, 'jamal@gmail.com', '$2y$10$Z6H1M9K0Y8P7R4F3C5E', '01810000002', 'seller', 0),
('Babul', 49, 'babul@gmail.com', '$2y$10$Y9M8Z6H1K0Q7P4F3C5', '01810000003', 'seller', 0),
('Sohel', 50, 'sohel@gmail.com', '$2y$10$M9Z6H1K0Q8Y7P4F3', '01810000004', 'seller', 0),
('Salam', 51, 'salam@gmail.com', '$2y$10$Z6H1K0Q8Y7P4F', '01810000005', 'seller', 0),
('Kader', 52, 'kader@gmail.com', '$2y$10$H1K0Q8Y7P4F', '01810000006', 'seller', 0),
('Mizan', 53, 'mizan@gmail.com', '$2y$10$K0Q8Y7P4F', '01810000007', 'seller', 0),
('Habib', 54, 'habib@gmail.com', '$2y$10$Q8Y7P4F', '01810000008', 'seller', 0),
('Selim', 55, 'selim@gmail.com', '$2y$10$Y7P4F', '01810000009', 'seller', 0),
('Rashid', 56, 'rashid@gmail.com', '$2y$10$P4F', '01810000010', 'seller', 0),
('Nazrul', 57, 'nazrul@gmail.com', '$2y$10$ZQ', '01810000011', 'seller', 0),
('Faruk', 58, 'faruk@gmail.com', '$2y$10$YQ', '01810000012', 'seller', 0),
('Anwar', 59, 'anwar@gmail.com', '$2y$10$MQ', '01810000013', 'seller', 0),
('Jibon', 60, 'jibon@gmail.com', '$2y$10$KQ', '01810000014', 'seller', 0),
('Rokon', 61, 'rokon@gmail.com', '$2y$10$FQ', '01810000015', 'seller', 0),
('Kabir', 62, 'kabir@gmail.com', '$2y$10$Z9', '01810000016', 'seller', 0),
('Badal', 63, 'badal@gmail.com', '$2y$10$Y9', '01810000017', 'seller', 0),
('Iqbal', 64, 'iqbal@gmail.com', '$2y$10$M9', '01810000018', 'seller', 0),
('Sujon', 65, 'sujon@gmail.com', '$2y$10$K9', '01810000019', 'seller', 0),
('Manik', 66, 'manik@gmail.com', '$2y$10$F9', '01810000020', 'seller', 0),
('Delwar', 67, 'delwar@gmail.com', '$2y$10$Z8', '01810000021', 'seller', 0),
('A R Faisal', 68, 'faisal@gmail.com', '$2y$10$febb0JwdrpEniMjBlRkD3OP7uvtA5lmjbyV.DALGAfcHWvJGpUj6S', '01711101445', 'buyer', 0),
('Jack', 69, 'jack@yahoo.com', '$2y$10$5xoIUfunDWqwBGsWPk92POKXCyAZfhS.CTRj6TR2K2yxnDBLee47e', '01553274595', 'seller', 0),
('Ifti', 70, 'ifti@gmail.com', '$2y$10$sW0NO3Aae/n9OavP.Rp79e3cGdnIRVru7loothVYrOnYEsBfux5Iq', '01819868569', 'buyer', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buyer`
--
ALTER TABLE `buyer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cows`
--
ALTER TABLE `cows`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cow_delivery`
--
ALTER TABLE `cow_delivery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `cow_foods`
--
ALTER TABLE `cow_foods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_seller_id` (`seller_id`);

--
-- Indexes for table `seller`
--
ALTER TABLE `seller`
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
-- AUTO_INCREMENT for table `buyer`
--
ALTER TABLE `buyer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `cows`
--
ALTER TABLE `cows`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `cow_delivery`
--
ALTER TABLE `cow_delivery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cow_foods`
--
ALTER TABLE `cow_foods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `seller`
--
ALTER TABLE `seller`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
