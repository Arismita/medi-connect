-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 04, 2022 at 10:26 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `medicalsns`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `commentID` int(11) NOT NULL,
  `comment` varchar(140) NOT NULL,
  `commentOn` int(11) NOT NULL,
  `commentBy` int(11) NOT NULL,
  `commentAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`commentID`, `comment`, `commentOn`, `commentBy`, `commentAt`) VALUES
(1, 'you can take vitamin C tablets', 29, 1, '2022-03-30 12:54:57'),
(9, 'hiya!', 27, 1, '2022-03-31 10:50:36');

-- --------------------------------------------------------

--
-- Table structure for table `follow`
--

CREATE TABLE `follow` (
  `followID` int(11) NOT NULL,
  `sender` int(11) NOT NULL,
  `receiver` int(11) NOT NULL,
  `followOn` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `follow`
--

INSERT INTO `follow` (`followID`, `sender`, `receiver`, `followOn`) VALUES
(6, 13, 14, '0000-00-00 00:00:00'),
(10, 14, 14, '0000-00-00 00:00:00'),
(18, 14, 1, '0000-00-00 00:00:00'),
(22, 1, 14, '0000-00-00 00:00:00'),
(23, 1, 13, '0000-00-00 00:00:00'),
(27, 13, 1, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `likeID` int(11) NOT NULL,
  `likeBy` int(11) NOT NULL,
  `likeOn` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`likeID`, `likeBy`, `likeOn`) VALUES
(5, 1, 29),
(15, 1, 25),
(17, 1, 27),
(18, 1, 93),
(21, 1, 100),
(22, 14, 103),
(23, 14, 105),
(24, 13, 105),
(25, 13, 104),
(30, 1, 106),
(36, 1, 108),
(39, 1, 107),
(40, 13, 103);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `messageID` int(11) NOT NULL,
  `message` text NOT NULL,
  `messageTo` int(11) NOT NULL,
  `messageFrom` int(11) NOT NULL,
  `messageOn` datetime NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`messageID`, `message`, `messageTo`, `messageFrom`, `messageOn`, `status`) VALUES
(1, 'hi', 1, 13, '2022-04-02 09:14:25', 1),
(2, 'hello!', 13, 1, '2022-04-02 13:32:01', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `ID` int(11) NOT NULL,
  `notificationFor` int(11) NOT NULL,
  `notificationFrom` int(11) NOT NULL,
  `target` int(11) NOT NULL,
  `type` enum('follow','repost','like','mention') NOT NULL,
  `time` datetime NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`ID`, `notificationFor`, `notificationFrom`, `target`, `type`, `time`, `status`) VALUES
(1, 1, 13, 29, 'follow', '2022-04-03 10:20:45', 1),
(2, 1, 13, 29, 'like', '2022-04-03 10:20:45', 1),
(3, 1, 13, 96, 'like', '2022-04-03 10:20:45', 1),
(4, 1, 13, 96, 'repost', '2022-04-03 10:20:45', 1),
(5, 1, 13, 96, 'mention', '2022-04-03 10:20:45', 1),
(6, 13, 1, 107, 'like', '2022-04-03 20:53:52', 1),
(7, 14, 13, 103, 'like', '2022-04-03 21:04:12', 0),
(8, 1, 13, 109, 'mention', '2022-04-03 21:04:26', 1),
(9, 1, 13, 99, 'repost', '2022-04-03 21:04:48', 1),
(10, 1, 13, 99, 'repost', '2022-04-03 21:04:48', 1),
(11, 1, 13, 1, 'follow', '2022-04-03 21:05:12', 1);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `postID` int(11) NOT NULL,
  `status` varchar(140) NOT NULL,
  `postBy` int(11) NOT NULL,
  `repostID` int(11) NOT NULL,
  `repostBy` int(11) NOT NULL,
  `postimage` varchar(255) NOT NULL,
  `likesCount` int(11) NOT NULL,
  `repostCount` int(11) NOT NULL,
  `postedOn` datetime NOT NULL,
  `repostMsg` varchar(140) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`postID`, `status`, `postBy`, `repostID`, `repostBy`, `postimage`, `likesCount`, `repostCount`, `postedOn`, `repostMsg`) VALUES
(25, 'this is my 1st post', 0, 0, 0, '', 1, 0, '2022-03-28 12:25:15', ''),
(26, '', 1, 0, 0, 'users/bt21.jpg', 0, 0, '2022-03-28 12:25:38', ''),
(27, 'hello there!', 13, 0, 0, '', 1, 1, '2022-03-28 17:39:14', ''),
(29, 'suggest me some #medicine for cold!', 1, 0, 0, '', 1, 0, '2022-03-28 21:49:01', ''),
(30, '@gracia https://www.youtube.com', 1, 0, 0, '', 0, 0, '2022-03-28 22:03:49', ''),
(31, 'hello there!', 13, 27, 1, '', 1, 1, '2022-03-30 11:16:11', 'reposting'),
(82, '', 1, 28, 13, 'users/book-with-pen-mobile-keyborad-desk_7192-631.jpg', 0, 1, '2022-03-31 18:45:25', 'reposting!'),
(91, 'test', 1, 0, 0, '', 0, 1, '2022-03-31 21:01:56', ''),
(92, 'test', 1, 91, 1, '', 0, 1, '2022-03-31 21:01:56', 'reposting'),
(93, 'hello there, this is tom morrow!', 14, 0, 0, '', 1, 2, '2022-04-01 22:45:13', ''),
(94, '#bloodDonationCamp on monday!', 1, 0, 0, '', 0, 0, '2022-04-02 21:34:21', ''),
(96, '#medicine', 1, 0, 0, 'users/tour_img-1139999-145.jpg', 0, 0, '2022-04-02 23:05:53', ''),
(97, 'hello there, this is tom morrow!', 14, 93, 1, '', 0, 1, '2022-04-01 22:45:13', 'hi! welcometo mediconnect!'),
(98, 'hello there, this is tom morrow!', 14, 93, 1, '', 0, 2, '2022-04-01 22:45:13', 'hi! welcometo mediconnect!'),
(99, '@tommorrow  hello', 1, 0, 0, '', 0, 2, '2022-04-03 18:07:27', ''),
(100, 'hi!', 14, 0, 0, '', 1, 2, '2022-04-03 18:08:58', ''),
(101, 'hi!', 14, 0, 0, '', 0, 2, '2022-04-03 18:09:01', ''),
(102, 'hi!', 14, 101, 1, '', 1, 1, '2022-04-03 18:09:01', 'fwefg'),
(103, 'hi!', 14, 101, 1, '', 3, 2, '2022-04-03 18:09:01', 'fwefg'),
(104, 'hi!', 14, 100, 1, '', 2, 1, '2022-04-03 18:08:58', 'fdsaq'),
(105, 'hi!', 14, 100, 1, '', 3, 2, '2022-04-03 18:08:58', 'fdsaq'),
(106, 'this is gracia', 13, 0, 0, '', 1, 0, '2022-04-03 18:32:11', ''),
(107, 'this is gracia', 13, 0, 0, '', 1, 0, '2022-04-03 18:42:58', ''),
(108, 'this is gracia', 13, 0, 0, '', 1, 0, '2022-04-03 18:45:56', ''),
(109, '@johndoe  hello!', 13, 0, 0, '', 0, 0, '2022-04-03 21:04:26', ''),
(110, '@tommorrow  hello', 1, 99, 13, '', 0, 1, '2022-04-03 18:07:27', 'repost!'),
(111, '@tommorrow  hello', 1, 99, 13, '', 0, 2, '2022-04-03 18:07:27', 'repost!');

-- --------------------------------------------------------

--
-- Table structure for table `trends`
--

CREATE TABLE `trends` (
  `trendID` int(11) NOT NULL,
  `hashtag` varchar(140) NOT NULL,
  `createdOn` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `trends`
--

INSERT INTO `trends` (`trendID`, `hashtag`, `createdOn`) VALUES
(1, 'doctor', '2022-03-28 13:13:58'),
(2, 'medicine', '2022-03-29 01:19:01'),
(3, 'bloodDonationCamp', '2022-04-03 01:04:21');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(40) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(32) NOT NULL,
  `screenName` varchar(40) NOT NULL,
  `profileImage` varchar(255) NOT NULL,
  `profileCover` varchar(255) NOT NULL,
  `following` int(11) NOT NULL,
  `followers` int(11) NOT NULL,
  `bio` varchar(140) NOT NULL,
  `country` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `screenName`, `profileImage`, `profileCover`, `following`, `followers`, `bio`, `country`, `website`) VALUES
(1, 'johndoe', 'john.doe@gmail.com', '6579e96f76baa00787a28653876c6127', 'John.Doe', 'users/download (1).jpg', 'users/book-with-pen-mobile-keyborad-desk_7192-631.jpg', 3, 3, 'I like chocolates.', '', ''),
(13, 'gracia', 'gracia.brown@protonmail.com', '721bdb40001a4fa9a5ef6ed8172e3bbf', 'gracia brown', 'assets/images/defaultprofileimage.jpg', 'assets/images/defaultCoverImage.jpg', 3, 1, 'skin specialist at apollo hospital', '', ''),
(14, 'tommorrow', 'tom.morrow@gmail.com', 'c78bf075601c6e665c77d57b3cc5bb21', 'tom morrow', 'assets/images/defaultprofileimage.jpg', 'assets/images/defaultCoverImage.jpg', 2, 4, 'skin specialist', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`commentID`);

--
-- Indexes for table `follow`
--
ALTER TABLE `follow`
  ADD PRIMARY KEY (`followID`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`likeID`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`messageID`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`postID`);

--
-- Indexes for table `trends`
--
ALTER TABLE `trends`
  ADD PRIMARY KEY (`trendID`),
  ADD UNIQUE KEY `hashtag` (`hashtag`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `commentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `follow`
--
ALTER TABLE `follow`
  MODIFY `followID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `likeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `messageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `postID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `trends`
--
ALTER TABLE `trends`
  MODIFY `trendID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
