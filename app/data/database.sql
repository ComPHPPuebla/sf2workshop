-- Create database
DROP DATABASE IF EXISTS bookshare;
CREATE DATABASE bookshare
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

-- Create user
GRANT ALL PRIVILEGES on bookshare.* TO bshare_user@localhost IDENTIFIED BY 'book_share_us3r';

-- Create tables
USE bookshare;

CREATE TABLE IF NOT EXISTS `author` (
  `author_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  PRIMARY KEY (`author_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `book` (
  `book_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `filename` varchar(200) NOT NULL,
  `author_id` int(11) NOT NULL,
  PRIMARY KEY (`book_id`),
  FOREIGN KEY (`author_id`) REFERENCES author(`author_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS book_rates (
    rate_id int(11) NOT NULL AUTO_INCREMENT,
    book_id int(11) NOT NULL,
    rate int(11) NOT NULL,
    PRIMARY KEY (`rate_id`),
    FOREIGN KEY (`book_id`) REFERENCES book(`book_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `user` (
    username varchar(20) NOT NULL,
    password varchar(120) NOT NULL,
    role varchar(20) NOT NULL,
    display_name varchar(80) NOT NULL,
    points int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Perform inserts
INSERT INTO `author` (`author_id`, `name`) VALUES
(1, 'W. Jason Gilmore'),
(2, 'Luke Welling'),
(3, 'Rasmus Lerdorf'),
(4, 'Dagfinn Reiersol'),
(5, 'George Schlossnagle');

INSERT INTO `book` (`book_id`, `title`, filename, `author_id`) VALUES
(1, 'Beginning PHP and MySQL: From Novice to Professional', 'beginning-php-and-mysql.pdf', 1),
(2, 'PHP and MySQL Web Development (4th Edition)', 'php-and-mysql-web-development.pdf', 2),
(3, 'Programming PHP', 'programming-php.pdf', 3),
(4, 'PHP in Action: Objects, Design, Agility', 'php-in-action.pdf', 4),
(5, 'Advanced PHP Programming', 'advanced-php-programming.pdf', 5);

INSERT INTO `user` (username, password, role, display_name) VALUES
('admin', '$2y$10$uN.3pTAkoSBxcQ.KoLTS/.p5wkb1ADkn/vX0DVKyTMlzLp53WQ53a', 'admin', 'Thomas A. Anderson'), -- changeme
('john', '$2y$10$jrt42kNT.d0V/TDAN6QCy.lYvjwvkAue43nNjoXbvNmbIyObG.Vmm', 'reader', 'John Doe'); -- letmein
