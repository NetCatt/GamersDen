-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 03, 2025 at 07:12 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `game_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `cartitems`
--

CREATE TABLE `cartitems` (
  `cart_item_id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cartitems`
--

INSERT INTO `cartitems` (`cart_item_id`, `cart_id`, `game_id`, `quantity`) VALUES
(10, 2, 28, 1),
(11, 2, 31, 1),
(12, 2, 26, 1),
(13, 2, 24, 1),
(14, 1, 25, 1),
(16, 1, 12, 1),
(17, 1, 17, 1),
(18, 1, 30, 1),
(19, 1, 31, 1);

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_price` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`cart_id`, `user_id`, `total_price`) VALUES
(1, 18, 269.95),
(2, 19, 144.96);

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `game_id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) DEFAULT 0,
  `description` text DEFAULT NULL,
  `platform` varchar(50) NOT NULL,
  `genre` varchar(50) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `added_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`game_id`, `title`, `price`, `stock`, `description`, `platform`, `genre`, `image_path`, `added_time`) VALUES
(10, 'Red Dead Redemption 2', 59.99, 10, 'An epic tale of life in America at the dawn of the modern age.', 'PC', 'Action-Adventure', 'image/Red Dead Redemption 2.jpg', '2024-12-30 13:08:53'),
(11, 'Grand Theft Auto V', 29.99, 20, 'Experience Rockstar Games critically acclaimed open world game.', 'PC', 'Action-Adventure', 'image/Grand Theft Auto V.jpg', '2024-12-30 13:08:53'),
(12, 'Marvels Spider-Man Remastered', 39.99, 12, 'Play as an experienced Peter Parker in this open-world adventure.', 'PC', 'Action-Adventure', 'image/Marvels Spider-Man Remastered.jpg', '2024-12-30 13:09:53'),
(13, 'Resident Evil 4 Remake', 49.99, 15, 'Reimagine the survival horror classic with updated gameplay.', 'PC', 'Survival Horror', 'image/Resident Evil 4 Remake.jpg', '2024-12-30 13:10:43'),
(14, 'Halo Infinite', 59.99, 20, 'Master Chief returns in a new chapter of the Halo series.', 'Xbox', 'First-Person Shooter', 'image/Halo Infinite.jpg', '2024-12-30 13:40:02'),
(15, 'Forza Horizon 5', 49.99, 25, 'Open-world racing across Mexico with stunning visuals.', 'Xbox', 'Racing', 'image/Forza Horizon 5.jpg', '2024-12-30 13:40:02'),
(16, 'Gears 5', 39.99, 15, 'The next chapter in the Gears of War saga.', 'Xbox', 'Third-Person Shooter', 'image/Gears 5.jpg', '2024-12-30 13:40:02'),
(17, 'Fable', 59.99, 12, 'A reboot of the classic RPG series with a modern twist.', 'Xbox', 'RPG', 'image/Fable.jpg', '2024-12-30 13:40:02'),
(18, 'Sea of Thieves', 29.99, 18, 'A shared-world pirate adventure.', 'Xbox', 'Adventure', 'image/Sea of Thieves.jpg', '2024-12-30 13:40:02'),
(19, 'God of War Ragnarok', 69.99, 20, 'The epic conclusion to Kratos\' Norse saga.', 'PS5', 'Action-Adventure', 'image/God of War Ragnarok.jpg', '2024-12-30 13:46:58'),
(20, 'Horizon Forbidden West', 69.99, 18, 'Explore distant lands and face new threats in this sequel.', 'PS5', 'Action-Adventure', 'image/Horizon Forbidden West.jpg', '2024-12-30 13:46:58'),
(21, 'The Last of Us Part I', 59.99, 15, 'A faithful remake of the critically acclaimed original.', 'PS5', 'Action-Adventure', 'image/The Last of Us Part I.jpg', '2024-12-30 13:46:58'),
(22, 'Ratchet & Clank Rift Apart', 59.99, 10, 'A visually stunning platformer with dimension-hopping gameplay.', 'PS5', 'Platformer', 'image/Ratchet & Clank Rift Apart.jpg', '2024-12-30 13:46:58'),
(23, 'Gran Turismo 7', 69.99, 20, 'A realistic driving simulator with a vast selection of cars.', 'PS5', 'Racing', 'image/Gran Turismo 7.jpg', '2024-12-30 13:46:58'),
(24, 'Cyberpunk 2077', 49.99, 25, 'A sprawling open-world RPG set in Night City.', 'PC', 'RPG', 'image/Cyberpunk 2077.jpg', '2024-12-30 13:47:31'),
(25, 'Doom Eternal', 39.99, 18, 'An adrenaline-filled FPS with fast-paced combat.', 'PC', 'First-Person Shooter', 'image/Doom Eternal.jpg', '2024-12-30 13:47:31'),
(26, 'Stardew Valley', 14.99, 30, 'A farming simulator with RPG elements.', 'PC', 'Simulation', 'image/Stardew Valley.jpg', '2024-12-30 13:47:31'),
(27, 'Age of Empires IV', 59.99, 20, 'A real-time strategy game spanning historical civilizations.', 'PC', 'Strategy', 'image/Age of Empires IV.png\"', '2024-12-30 13:47:31'),
(28, 'Valheim', 19.99, 25, 'A Viking survival game set in a procedurally generated world.', 'PC', 'Survival', 'image/Valheim.jpg', '2024-12-30 13:47:31'),
(29, 'Minecraft', 26.99, 50, 'A block-building sandbox game.', 'Cross-Platform', 'Sandbox', 'image/Minecraft.jpg', '2024-12-30 13:47:48'),
(30, 'Call of Duty Modern Warfare II', 69.99, 30, 'The latest entry in the Call of Duty series.', 'Cross-Platform', 'First-Person Shooter', 'image/Call of Duty Modern Warfare II.jpg', '2024-12-30 13:47:48'),
(31, 'FIFA 24', 59.99, 40, 'The latest FIFA game with updated rosters and modes.', 'Cross-Platform', 'Sports', 'image/FIFA 24.jpg', '2024-12-30 13:47:48'),
(32, 'Elden Ring', 59.99, 20, 'A dark fantasy RPG from the creators of Dark Souls.', 'Cross-Platform', 'RPG', 'image/Elden Ring.jpg', '2024-12-30 13:47:48'),
(33, 'Apex Legends', 0.00, 50, 'A free-to-play battle royale with unique characters.', 'Cross-Platform', 'Battle Royale', 'image/Apex Legends.jpg', '2024-12-30 13:47:48');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `comment` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `user_id`, `game_id`, `rating`, `comment`) VALUES
(1, 17, 11, 5, 'nice'),
(2, 1, 10, 5, 'Red Dead Redemption 2 is a masterpiece of storytelling and gameplay.'),
(3, 6, 11, 4, 'Grand Theft Auto V is fun but feels dated in some areas.'),
(4, 8, 20, 4, 'Horizon Forbidden West has stunning visuals but a predictable plot.'),
(5, 9, 21, 5, 'The Last of Us Part I is an emotional and beautifully crafted game.'),
(6, 16, 22, 4, 'Ratchet & Clank Rift Apart is visually stunning and enjoyable.'),
(7, 17, 23, 5, 'Gran Turismo 7 is the best driving simulator out there.'),
(8, 1, 24, 4, 'Cyberpunk 2077 is much better after recent updates.'),
(9, 6, 25, 5, 'Doom Eternal delivers relentless and satisfying combat.'),
(10, 7, 26, 4, 'Stardew Valley is relaxing and highly addictive.'),
(11, 8, 27, 3, 'Age of Empires IV is good but needs better AI balancing.'),
(12, 9, 28, 4, 'Valheim is a unique survival game with an engaging Viking theme.'),
(13, 16, 29, 5, 'Minecraft is timeless and endlessly creative.'),
(14, 17, 30, 4, 'Call of Duty Modern Warfare II offers solid gameplay but lacks originality.'),
(15, 1, 31, 5, 'FIFA 24 is a must-play for any football enthusiast.'),
(16, 6, 32, 5, 'Elden Ring is an exceptional blend of difficulty and exploration.'),
(36, 18, 27, 3, 'dg uif'),
(37, 18, 31, 3, 'adsd'),
(38, 18, 25, 3, 'sdg'),
(39, 18, 33, 3, 'asda'),
(40, 18, 23, 2, 'weqwe');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`) VALUES
(1, 'TanvirRahman2', '', '$2y$10$aLTfDPXa086GrcGLhscqn.PzKNVCAUHk9pf16G2N6tacDdUq5lCuW'),
(6, 'nurul', 'nuru20@gmai.com', '$2y$10$9YA0SCH4jvGrYRePdjEacOznet0.MNwvkWLuLDFbQPA2kvzJNkpCm'),
(7, 'tanvir1', 'abcd123@gmail.com', '$2y$10$kX.DqJm398q4GcfvH0ED8.n.n6lUwau03Cek9nsMPi8XG0lHeyDtG'),
(8, 'cse370', 'cse370@gamil.com', '$2y$10$RCs7F5iGG8yS3x5PWaYnuuRyxxNWnCayFKftiViPyDqZjgKwuBV7u'),
(9, 'TanvirRahman2', 'tanvir454516@gmail.com', '$2y$10$9/GvGWozTWtYyZ8G3Jj9F.PRV2zNWUS1Obdvww5pwJvA6AYl4OudW'),
(16, 'tithi', 'tasnim2002@gmail.com', '$2y$10$RHlhXEej0rjaWgLgZSPTqu.PEaHsUPGlkjMoTBf6OYLThHGtOz4wi'),
(17, 'qwerty', 'tanvir2@gamil.com', '$2y$10$uhX6F2WXZbvZOS5zmR/J1uuWNmgGQyFpe6lAQfBQ1rIz3PYCVl3lW'),
(18, 'hello', 'hello12@gmail.com', '$2y$10$pjRU6Uf9gCVoCutYZP.UYOzji0TXBuDliahfKeaAcy4ALkqxf5iUa'),
(19, 'qqqq', 'qqqq@gamil.com', '$2y$10$g07.tcgMikEiJeWWwujD6erJ81yy5uVum/fNxAEdAIoq.omtM/tLK');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cartitems`
--
ALTER TABLE `cartitems`
  ADD PRIMARY KEY (`cart_item_id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `game_id` (`game_id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`game_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `game_id` (`game_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cartitems`
--
ALTER TABLE `cartitems`
  MODIFY `cart_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `game_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cartitems`
--
ALTER TABLE `cartitems`
  ADD CONSTRAINT `cartitems_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`cart_id`),
  ADD CONSTRAINT `cartitems_ibfk_2` FOREIGN KEY (`game_id`) REFERENCES `games` (`game_id`);

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`game_id`) REFERENCES `games` (`game_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
