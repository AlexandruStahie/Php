-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 31, 2016 at 02:19 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `alexbook`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `commentid` int(11) NOT NULL,
  `text` varchar(100) NOT NULL,
  `postid` int(11) NOT NULL,
  `userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`commentid`, `text`, `postid`, `userid`) VALUES
(17, '2', 14, 2),
(18, '11111', 14, 2),
(19, '5555', 14, 2),
(20, '333asdasdasdasdasd', 14, 2),
(21, '3333', 14, 2),
(22, 'blah', 14, 2),
(23, 'test123', 14, 2),
(24, 'asdasd', 13, 2),
(25, 'asdsadad', 12, 2),
(26, 'asd', 14, 16),
(27, 'aaaa', 13, 16),
(29, 'asdasdasd', 21, 16),
(30, 'asdasda', 21, 16),
(31, 'asd', 14, 2),
(32, 'asddas', 21, 2),
(33, 'asdasd', 21, 2),
(34, '123123', 21, 2);

-- --------------------------------------------------------

--
-- Table structure for table `liketable`
--

CREATE TABLE `liketable` (
  `liekid` int(11) NOT NULL,
  `postid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `status` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `liketable`
--

INSERT INTO `liketable` (`liekid`, `postid`, `userid`, `status`) VALUES
(11, 10, 2, 'Like'),
(16, 13, 15, 'Like'),
(17, 12, 15, 'Like'),
(18, 11, 12, 'Like'),
(26, 21, 16, 'Like'),
(27, 14, 2, 'Like'),
(33, 21, 2, 'Like'),
(35, 21, 17, 'Like');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `postid` int(11) NOT NULL,
  `image` varchar(200) NOT NULL,
  `title` varchar(25) DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL,
  `postdate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`postid`, `image`, `title`, `description`, `postdate`, `userid`) VALUES
(10, '371448.jpg', 'testi', 'testi', '2016-12-29 21:16:20', 2),
(11, '587022.jpg', 'test', 'asd', '2016-12-29 21:21:04', 12),
(12, '479525.jpg', 't1', 'd1', '2016-12-30 08:02:30', 15),
(13, '218007.jpg', 'd3', 'd3', '2016-12-30 08:05:59', 15),
(14, '954483.jpg', 'd3', 'd3', '2016-12-30 10:00:24', 15),
(21, '896009.jpg', 'aaaaaa', 'aaaaaa', '2016-12-30 16:58:28', 16);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` int(11) NOT NULL,
  `user` varchar(25) NOT NULL,
  `password` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `user`, `password`) VALUES
(1, 'testnou', 'testtest'),
(2, 'test5', 'testtest'),
(3, 'testnou', 'tse'),
(4, 'testnou', 'tse'),
(5, 'asd', 'as'),
(6, '123', '123'),
(7, '1233', '123'),
(8, '321', '321'),
(9, '321', '321'),
(10, '321', '321'),
(11, 'teeeest', 'test'),
(12, 'teest', 'test'),
(13, 'test6', 'testtest'),
(14, 'eeee', 'ee'),
(15, 'newtest', 'testtest'),
(16, 'asd', 'asdasd'),
(17, 'liketest', 'liketest');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`commentid`),
  ADD KEY `FK_Comment_Post` (`postid`),
  ADD KEY `FK_Comment_User` (`userid`);

--
-- Indexes for table `liketable`
--
ALTER TABLE `liketable`
  ADD PRIMARY KEY (`liekid`),
  ADD KEY `FK_LikeTable_Post` (`postid`),
  ADD KEY `FK_LikeTable_User` (`userid`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`postid`),
  ADD KEY `FK_Post_User` (`userid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `commentid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `liketable`
--
ALTER TABLE `liketable`
  MODIFY `liekid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `postid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `FK_Comment_Post` FOREIGN KEY (`postid`) REFERENCES `post` (`postid`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_Comment_User` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`);

--
-- Constraints for table `liketable`
--
ALTER TABLE `liketable`
  ADD CONSTRAINT `FK_LikeTable_Post` FOREIGN KEY (`postid`) REFERENCES `post` (`postid`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_LikeTable_User` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`);

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `FK_Post_User` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
