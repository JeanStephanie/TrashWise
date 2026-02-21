-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 21, 2026 at 11:12 AM
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
-- Database: `trashwise`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `email`, `password`) VALUES
(1, 'admin@gmail.com', '$2y$10$sCxT2M1tGOn2CYKaclMVWeskRPfExGNkvyV6cAK7w9zr9xfb3nYx6');

-- --------------------------------------------------------

--
-- Table structure for table `awareness_posts`
--

CREATE TABLE `awareness_posts` (
  `post_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `awareness_posts`
--

INSERT INTO `awareness_posts` (`post_id`, `title`, `content`, `image`, `created_at`) VALUES
(1, 'How to do segregation of wet and dry waste at home?', 'Segregation can be simply done at home, it just needs a little mindfulness. This will help the authorities to make their job a little easier. To get started with it, you just need some awareness and the desire to act towards this.\r\n\r\nYou need to keep these following things in mind before segregating waste at home:\r\n\r\nKeep 2 separate dustbins for dry and wet waste\r\nRemove any covering on the kitchen waste before throwing it in the dustbin\r\nDo not mix wet waste with dry waste\r\nKeep the plastic from the kitchen dry and separate in the dry bin\r\nKeep the dry waste rinsed of any food content before throwing in dry bin\r\nThrow the sanitary waste in a separate paper bag', 'waste.jpg', '2026-02-14 14:28:11'),
(2, '6 Tips To Effectively Segregate Dry And Wet Waste At Home', 'Tips to effectively segregate dry and wet waste\r\n\r\nTip 1: Understand the difference\r\nBefore venturing into the process, it is necessary that you understand the difference between dry waste and wet waste.\r\n\r\nDry waste includes materials like paper, plastic, metal, glass, and textiles. These items are typically recyclable, and if not managed properly, they can end up wasted in landfills, taking decades or even centuries to decompose.\r\n\r\nWet waste, on the other hand, includes organic waste such as food scraps, vegetable peels, coffee grounds, and garden waste. If managed properly, these items can be composted easily and redirected towards further usage. However, if they aren\'t processed correctly and decompose anaerobically in landfills, they release methane, a potent greenhouse gas that negatively impacts climate change.\r\n\r\nKnowing this basic difference between dry and wet waste can help tackle waste properly and implement an effective waste management system.\r\n\r\nTip 2: Separate bins\r\nCultivate the habit of placing two bins in your kitchen or waste disposal area-one for dry waste and one for wet waste.\r\n\r\nTo further help the cause, do the following to ensure that it is easy for the garbage collector to collect your segregated dry and wet waste easily:\r\n\r\nDry waste bin: Use a bin without a liner or with a recyclable paper liner. The collector can easily pour the contents into their bins.\r\n\r\nWet waste bin: Use a bin with a compostable liner to manage odour and moisture, and ensure that the collector can easily collect the waste along with the liner.\r\n\r\nTip 3: Educate your household\r\nIt is necessary that every member of the house is aware of the importance of waste segregation and has been educated about the process of identifying and separating different types of waste.\r\n\r\nClearly label the bins for dry and wet waste to avoid confusion and ensure that everyone can follow.\r\n\r\nEffective management of waste at home can help tackle and recycle waste at the larger level, too.\r\n\r\nwaste managements system in flats in guwahati\r\n\r\nTip 4: Daily sorting\r\nEvery good habit requires daily practice, and just as with any other habit, segregating dry and wet waste at the source should be a daily ritual. Segregate waste at the source of generation, for example, by sorting waste immediately after cooking or eating. This will minimize the effort of sorting later when the waste amount is greater.\r\n\r\nIn addition, try cleaning dry waste materials wherever possible. For instance, rinse items like yogurt cups or sauce bottles before placing them for dry waste management to prevent contamination.\r\n\r\nEnsuring dry waste items are clean and sorted correctly helps them to be recycled effectively.\r\n\r\nTip 5: Reduce and recycle\r\nApart from dry and wet waste segregation, there are many ways to contribute to environmental sustainability. When you start at the purchase or consumption level, you contribute more towards preventing pollution.\r\n\r\nFor example, using reusable bags and avoiding single-use plastics significantly reduces the amount of waste generated.\r\n\r\nWhen you buy products with minimal or eco-friendly packaging, fix broken items instead of discarding them, and find ways to repurpose or recycle household goods, you consciously choose to contribute positively.\r\n\r\nTip 6: Routine monitoring\r\nSegregating bins isn\'t enough; you must regularly monitor that they are being used properly. To ensure proper segregation, regularly check the contents of both bins.\r\n\r\nIf incorrect items are found in the bins, remind your family members about the need to separate dry and wet waste.\r\n\r\nIt may take time for everyone in the household to adapt to the new system, so keep encouraging and supporting each other.\r\n\r\nBonus Tip:\r\nOnce you have mastered the art of dry and wet waste segregation, you can take your next step toward compositing. For wet waste, set up a compost bin in your backyard or use a kitchen composting system.\r\n\r\nComposting organic waste transforms it into nutrient-rich compost, enriching the soil with essential nutrients for growing vegetables at home. It also helps reduce organic waste from landfills, reduce methane emissions, and mitigate climate change.', 'segregation.jpg', '2026-02-16 13:52:49'),
(4, 'What is dry waste?', 'Dry waste refers to materials that are generally non-biodegradable and have a low moisture content. These items do not decompose quickly and can often be recycled if they are kept clean and free from food residue. \r\n\r\nCommon Examples of Dry Waste:\r\n\r\nPlastics: Bottles (water, shampoo), food containers, wrappers, plastic bags, and straws.\r\n\r\nPaper & Cardboard: Newspapers, magazines, office paper, cardboard boxes, and cartons.\r\n\r\nMetals: Aluminum soda cans, tin foil, old utensils, and metal scraps.\r\n\r\nGlass: Jars, bottles, mirrors, and broken glass pieces.\r\n\r\nTextiles: Old clothes, shoes, and fabric scraps.\r\n\r\nRubber & Wood: Old brooms, rubber bands, and wood scraps.\r\n\r\nMiscellaneous Items: Thermocol (Styrofoam), used dry tissues, old toothbrushes, and coconut shells. \r\n\r\nEssential Tips for Managing Dry Waste\r\nKeep it Dry: Ensure that recyclable items like milk packets or yogurt cups are rinsed and dried before placing them in the dry waste bin to prevent contamination.\r\nSegregation: Store dry waste separately from wet waste (food scraps) to ensure it can be processed at a Material Recovery Facility (MRF).\r\nE-Waste Handling: Items like batteries, chargers, and old mobile phones are often categorized under dry waste but should be handled separately as hazardous E-waste. ', 'dry.jpg', '2026-02-16 14:07:18'),
(5, 'Biodegradable Basics: Understanding Your Wet Waste', 'Wet waste refers to biodegradable and organic materials that decompose naturally. It typically consists of items with high moisture content and is primarily generated in kitchens and gardens. \r\n\r\nCommon Examples of Wet Waste:\r\n\r\nKitchen Scraps: Vegetable and fruit peels, leftover cooked or uncooked food, eggshells, and rotten fruits or vegetables.\r\n\r\nBeverage Residue: Used tea leaves, tea bags, and coffee grounds.\r\n\r\nGarden Waste: Fallen leaves, grass clippings, twigs, and flowers (including those used in puja rituals).\r\n\r\nMeat & Dairy: Bones, fish remains, meat scraps, and spoiled dairy products.\r\n\r\nSoiled Items: Used tissues, paper towels, and soiled food wrappers that are contaminated with organic matter.\r\n\r\nNatural Shells: Coconut shells and peanut shells.\r\n\r\nOther Organics: Human hair and nails (though they take longer to decompose). \r\n\r\nWhy Segregate Wet Waste?\r\nSegregating wet waste is crucial for two main reasons: \r\nComposting: It can be converted into nutrient-rich compost or manure for gardening.\r\nPreventing Contamination: Mixing wet waste with dry waste (like paper or plastic) makes the dry waste unrecyclable because it becomes soiled.', 'wet.jpg', '2026-02-16 14:09:27');

-- --------------------------------------------------------

--
-- Table structure for table `collection_schedule`
--

CREATE TABLE `collection_schedule` (
  `schedule_id` int(11) NOT NULL,
  `waste_type` varchar(50) NOT NULL,
  `area` varchar(100) NOT NULL,
  `collection_date` date NOT NULL,
  `collection_time` time NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `collection_schedule`
--

INSERT INTO `collection_schedule` (`schedule_id`, `waste_type`, `area`, `collection_date`, `collection_time`, `created_at`) VALUES
(1, 'Wet Waste', 'Kadri', '2026-02-16', '10:00:00', '2026-02-13 14:31:14'),
(3, 'Wet Waste', 'Vamanjoor', '2026-02-14', '12:00:00', '2026-02-13 17:26:04'),
(5, 'Dry Waste', 'Nanthoor', '2026-02-17', '08:00:00', '2026-02-16 14:16:41'),
(6, 'Dry Waste', 'Falnir', '2026-02-19', '11:00:00', '2026-02-18 04:26:16');

-- --------------------------------------------------------

--
-- Table structure for table `reward_points`
--

CREATE TABLE `reward_points` (
  `rp_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `report_id` int(11) NOT NULL,
  `points` int(11) NOT NULL,
  `reason` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reward_points`
--

INSERT INTO `reward_points` (`rp_id`, `user_id`, `report_id`, `points`, `reason`, `created_at`) VALUES
(1, 1, 1, 10, NULL, '2026-02-21 09:06:01'),
(2, 4, 3, 10, NULL, '2026-02-21 09:21:14'),
(3, 1, 4, 10, NULL, '2026-02-21 09:24:40'),
(4, 2, 2, 10, NULL, '2026-02-21 09:25:58');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `area` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `created_at`, `area`) VALUES
(1, 'Diya', 'diya@gmail.com', '$2y$10$bb51LrMjyJ3jref1y6QzjeTy9RKsZUgHzH3wclCIZfUPN8bdyRNHq', '2026-02-21 09:04:17', 'Kadri'),
(2, 'Asha', 'asha@gmail.com', '$2y$10$F.au3rwrCa92ba1TKvEO3eVB5UCgk2vSAXEDgYIWUZuV3bqKP0DaG', '2026-02-21 09:08:47', 'Falnir'),
(3, 'Ashwini', 'ashwini@gmail.com', '$2y$10$3yEkSpq7TosG97zsbMW4Nut0bSYRL1vtDPeozvGWSMAq2HeMdxYna', '2026-02-21 09:16:10', NULL),
(4, 'Sristi', 'sristi@gmail.com', '$2y$10$zNDLwrFGv0pP.yY.WY46YeuR4gDmxEsdeeR6AlNc0mP.fgTd1igIS', '2026-02-21 09:19:46', 'Nanthoor');

-- --------------------------------------------------------

--
-- Table structure for table `waste_reports`
--

CREATE TABLE `waste_reports` (
  `report_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `issue_type` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `status` enum('Pending','Resolved','Invalid') DEFAULT 'Pending',
  `reported_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `waste_reports`
--

INSERT INTO `waste_reports` (`report_id`, `user_id`, `issue_type`, `description`, `image`, `location`, `status`, `reported_at`) VALUES
(1, 1, 'Overflowing Bin', 'The bins in Kadri area is overflowing.', '1771664744_bin.jpg', 'Kadri', 'Resolved', '2026-02-21 09:05:44'),
(2, 2, 'Illegal Dumping', 'The people are dumping the waste where they are not supposed to dump it which is causing inconvenience to the people.', '1771665052_dumping.jpg', 'Falnir', 'Resolved', '2026-02-21 09:10:52'),
(3, 4, 'Missed Collection', 'Waste collection on 15th in Nanthoor was not done.', '', 'Nanthoor', 'Resolved', '2026-02-21 09:20:49'),
(4, 1, 'Illegal Dumping', 'Illegal dumping in Falnir area.', '1771665781_issue2.jpg', 'Falnir', 'Resolved', '2026-02-21 09:23:01'),
(5, 3, 'Overflowing Bin', 'Overflowing bins.', '1771666027_issue1.jpg', 'Kudroli', 'Pending', '2026-02-21 09:27:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `awareness_posts`
--
ALTER TABLE `awareness_posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `collection_schedule`
--
ALTER TABLE `collection_schedule`
  ADD PRIMARY KEY (`schedule_id`);

--
-- Indexes for table `reward_points`
--
ALTER TABLE `reward_points`
  ADD PRIMARY KEY (`rp_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `waste_reports`
--
ALTER TABLE `waste_reports`
  ADD PRIMARY KEY (`report_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `awareness_posts`
--
ALTER TABLE `awareness_posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `collection_schedule`
--
ALTER TABLE `collection_schedule`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `reward_points`
--
ALTER TABLE `reward_points`
  MODIFY `rp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `waste_reports`
--
ALTER TABLE `waste_reports`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `waste_reports`
--
ALTER TABLE `waste_reports`
  ADD CONSTRAINT `waste_reports_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
