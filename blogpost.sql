-- Create database
CREATE DATABASE IF NOT EXISTS `blogpost` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `blogpost`;

-- Table: users
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('admin', 'author', 'subscriber') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: posts
CREATE TABLE IF NOT EXISTS `posts` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `tittle` VARCHAR(255) NOT NULL,
  `content` TEXT NOT NULL,
  `author_id` INT(11) NOT NULL,
  `category_id` INT(11) NOT NULL,
  `image` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `author_id` (`author_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: comments
CREATE TABLE IF NOT EXISTS `comments` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `post_id` INT(11) NOT NULL,
  `user_name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `comment` TEXT NOT NULL,
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- IMPORTANT: After creating the database and tables, you must manually insert an admin user into the 'users' table.
-- Example:
-- INSERT INTO users (name, email, password, role) VALUES ('Admin Name', 'admin@example.com', '<hashed_password>', 'admin');
-- Make sure to hash the password using PHP's password_hash() function or similar before inserting. 