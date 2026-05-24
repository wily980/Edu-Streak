[edu_streak (4).sql](https://github.com/user-attachments/files/28191058/edu_streak.4.sql)EduStreak 🎯

> Learn to code, one streak at a time.

EduStreak is a Duolingo-style coding learning platform built for anyone who wants to learn programming. It makes learning to code fun and habit-forming through streaks, quests, leaderboards, and a reward system — so you stay consistent and actually make progress.

---

## ✨ Features

- 🌐 **8 Programming Languages** — C++, C#, CSS, HTML, Java, JavaScript, PHP, Python
- 📚 **Structured Learning Tracks** — lessons are organized into tracks with progressive difficulty
- 🔥 **Streak System** — keep your daily streak to stay motivated
- 🏆 **Monthly Leaderboard** — compete with other learners by XP
- 🎯 **Daily & Extra Quests** — complete quests to earn rewards
- 💰 **Gem & Heart System** — earn gems, spend them in the shop
- 🛒 **Shop** — buy items like Streak Freeze and Heart Refill
- 📜 **Code History** — track all your completed and in-progress lessons
- 👤 **Google OAuth** — sign in with your Google account
- 🌍 **Multi-environment support** — runs on both Laragon and `php -S`

---

## 🛠️ Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | PHP (MVC, no framework) |
| Database | MySQL |
| Frontend | Tailwind CSS v4, Vanilla JS |
| Auth | Google OAuth 2.0 |
| Server | Apache (Laragon) / PHP built-in server |

---

## 🚀 Setup

### Prerequisites
- PHP 8.1+
- MySQL
- Composer
- Node.js & npm
- Laragon (recommended) or any local server

### Installation

1. **Clone the repo**
   ```bash
   git clone https://github.com/wily980/Edu-Streak.git
   cd Edu-Streak
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install JS dependencies**
   ```bash
   npm install
   npm run dev
   ```

4. **Set up config**
   
   Create `app/config/app.php` (this file is gitignored — never commit it):
   ```php
   <?php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASSWORD', '');
   define('DB_NAME', 'edu_streak');

   define('GOOGLE_CLIENT_ID', 'ga bolee');
   define('GOOGLE_CLIENT_SECRET', 'ini juga ya');
   define('GOOGLE_REDIRECT_URI', 'http://localhost/Edu_Streak_Lock_in/public/auth/google/callback');

   if (php_sapi_name() === 'cli-server') {
       define('BASE_URL', '');
   } else {
       define('BASE_URL', '/Edu_Streak_Lock_in/public');
   }
   ```

5. **Import the database**
[Up-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 24, 2026 at 11:02 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `edu_streak`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `advance_language_level` (IN `p_user_id` CHAR(36), IN `p_language_id` CHAR(36), IN `p_xp_gained` INT)   BEGIN
    DECLARE v_exists      INT     DEFAULT 0;
    DECLARE v_level_num   INT     DEFAULT 1;
    DECLARE v_xp          INT     DEFAULT 0;
    DECLARE v_threshold   INT     DEFAULT 0;
    DECLARE v_level_name  VARCHAR(20) DEFAULT 'beginner';

    SELECT COUNT(*) INTO v_exists
    FROM usr_language_levels
    WHERE user_id = p_user_id AND language_id = p_language_id;

    IF v_exists = 0 THEN
        INSERT INTO usr_language_levels
            (id, user_id, language_id, level, level_num, xp_in_level, xp_to_next_level, last_activity_at)
        VALUES
            (UUID(), p_user_id, p_language_id, 'beginner', 1, p_xp_gained, 200, NOW());
    ELSE
        SELECT level_num, xp_in_level INTO v_level_num, v_xp
        FROM usr_language_levels
        WHERE user_id = p_user_id AND language_id = p_language_id;

        SET v_xp = v_xp + p_xp_gained;

        level_loop: LOOP
            IF v_level_num >= 6 THEN LEAVE level_loop; END IF;
            SET v_threshold = CASE v_level_num
                WHEN 1 THEN 200  WHEN 2 THEN 500
                WHEN 3 THEN 1000 WHEN 4 THEN 2000
                WHEN 5 THEN 4000 ELSE 0
            END;
            IF v_xp < v_threshold THEN LEAVE level_loop; END IF;
            SET v_xp       = v_xp - v_threshold;
            SET v_level_num = v_level_num + 1;
        END LOOP;

        SET v_level_name = CASE v_level_num
            WHEN 1 THEN 'beginner'          WHEN 2 THEN 'elementary'
            WHEN 3 THEN 'intermediate'      WHEN 4 THEN 'upper_intermediate'
            WHEN 5 THEN 'advanced'          WHEN 6 THEN 'expert'
        END;

        UPDATE usr_language_levels SET
            level            = v_level_name,
            level_num        = v_level_num,
            xp_in_level      = v_xp,
            xp_to_next_level = CASE v_level_num
                WHEN 1 THEN 200  WHEN 2 THEN 500
                WHEN 3 THEN 1000 WHEN 4 THEN 2000
                WHEN 5 THEN 4000 ELSE 0
            END,
            last_activity_at = NOW()
        WHERE user_id = p_user_id AND language_id = p_language_id;
    END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `chl_challenges`
--

CREATE TABLE `chl_challenges` (
  `id` char(36) NOT NULL DEFAULT (uuid()),
  `lesson_id` char(36) NOT NULL,
  `title` varchar(150) NOT NULL,
  `type` enum('code_output','fix_the_bug','fill_blank','multiple_choice','arrange_blocks') NOT NULL DEFAULT 'code_output',
  `instructions` text NOT NULL,
  `starter_code` text,
  `solution_code` text NOT NULL,
  `test_cases` json DEFAULT NULL,
  `difficulty` tinyint NOT NULL DEFAULT '1',
  `xp_reward` int NOT NULL DEFAULT '15'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chl_submissions`
--

CREATE TABLE `chl_submissions` (
  `id` char(36) NOT NULL DEFAULT (uuid()),
  `user_id` char(36) NOT NULL,
  `challenge_id` char(36) NOT NULL,
  `code` longtext NOT NULL,
  `status` enum('pending','running','passed','failed','error') NOT NULL DEFAULT 'pending',
  `score` int NOT NULL DEFAULT '0',
  `test_results` json DEFAULT NULL,
  `runtime_ms` int DEFAULT NULL,
  `submitted_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cnt_languages`
--

CREATE TABLE `cnt_languages` (
  `id` char(36) NOT NULL DEFAULT (uuid()),
  `name` varchar(50) NOT NULL,
  `slug` varchar(20) NOT NULL,
  `icon_url` text,
  `color_hex` varchar(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cnt_languages`
--

INSERT INTO `cnt_languages` (`id`, `name`, `slug`, `icon_url`, `color_hex`) VALUES
('40948356-481a-11f1-befa-9ad025ab06b0', 'Python', 'python', '/assets/python.png', '#3776AB'),
('40948ade-481a-11f1-befa-9ad025ab06b0', 'CSS', 'css', '/assets/css.png', '#264DE4'),
('40948c45-481a-11f1-befa-9ad025ab06b0', 'HTML', 'html', '/assets/html.png', '#E34F26'),
('40948cea-481a-11f1-befa-9ad025ab06b0', 'JavaScript', 'javascript', '/assets/js.png', '#F7DF1E'),
('40948d7c-481a-11f1-befa-9ad025ab06b0', 'Java', 'java', '/assets/java.png', '#ED8B00'),
('40948e1c-481a-11f1-befa-9ad025ab06b0', 'C#', 'csharp', '/assets/Csharp.png', '#239120'),
('40948eaa-481a-11f1-befa-9ad025ab06b0', 'C++', 'cpp', '/assets/C++.png', '#00599C'),
('40948f83-481a-11f1-befa-9ad025ab06b0', 'PHP', 'php', '/assets/php.png', '#777BB4');

-- --------------------------------------------------------

--
-- Table structure for table `cnt_lessons`
--

CREATE TABLE `cnt_lessons` (
  `id` char(36) NOT NULL DEFAULT (uuid()),
  `track_id` char(36) NOT NULL,
  `title` varchar(150) NOT NULL,
  `type` enum('concept','practice','project','quiz','checkpoint') NOT NULL DEFAULT 'concept',
  `theory_content` longtext,
  `order_index` int NOT NULL DEFAULT '0',
  `xp_reward` int NOT NULL DEFAULT '10',
  `gem_reward` int NOT NULL DEFAULT '2'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cnt_lessons`
--

INSERT INTO `cnt_lessons` (`id`, `track_id`, `title`, `type`, `theory_content`, `order_index`, `xp_reward`, `gem_reward`) VALUES
('lesson-css-001', '4142e0ff-481a-11f1-befa-9ad025ab06b0', 'What is CSS?', 'concept', NULL, 1, 10, 2),
('lesson-css-002', '4142e0ff-481a-11f1-befa-9ad025ab06b0', 'CSS Selectors', 'concept', NULL, 2, 10, 2),
('lesson-css-003', '4142e0ff-481a-11f1-befa-9ad025ab06b0', 'Colors & Backgrounds', 'practice', NULL, 3, 15, 3),
('lesson-html-001', '4142e914-481a-11f1-befa-9ad025ab06b0', 'What is HTML?', 'concept', NULL, 1, 10, 2),
('lesson-html-002', '4142e914-481a-11f1-befa-9ad025ab06b0', 'HTML Tags & Elements', 'concept', NULL, 2, 10, 2),
('lesson-html-003', '4142e914-481a-11f1-befa-9ad025ab06b0', 'HTML Structure', 'practice', NULL, 3, 15, 3);

-- --------------------------------------------------------

--
-- Table structure for table `cnt_questions`
--

CREATE TABLE `cnt_questions` (
  `id` char(36) NOT NULL DEFAULT (uuid()),
  `lesson_id` char(36) NOT NULL,
  `question_text` text NOT NULL,
  `code_snippet` text,
  `order_index` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cnt_questions`
--

INSERT INTO `cnt_questions` (`id`, `lesson_id`, `question_text`, `code_snippet`, `order_index`) VALUES
('q-css-001-1', 'lesson-css-001', 'What does CSS stand for?', NULL, 1),
('q-css-001-2', 'lesson-css-001', 'Which property changes text color in CSS?', NULL, 2),
('q-css-001-3', 'lesson-css-001', 'Which of these is the correct CSS syntax?', NULL, 3),
('q-css-001-4', 'lesson-css-001', 'What does this CSS do?', 'p {\n  color: red;\n}', 4),
('q-html-001-1', 'lesson-html-001', 'What does HTML stand for?', NULL, 1),
('q-html-001-2', 'lesson-html-001', 'Which of these is the correct file extension for an HTML file?', NULL, 2),
('q-html-001-3', 'lesson-html-001', 'What is the purpose of HTML in web development?', NULL, 3),
('q-html-001-4', 'lesson-html-001', 'Which tag defines the document type in HTML?', '<!DOCTYPE html>\n<html>\n  <head>...</head>\n  <body>...</body>\n</html>', 4),
('q-html-002-1', 'lesson-html-002', 'Which tag is used for the largest heading?', NULL, 1),
('q-html-002-2', 'lesson-html-002', 'What does the <a> tag do?', NULL, 2),
('q-html-002-3', 'lesson-html-002', 'Which tag creates a paragraph?', NULL, 3),
('q-html-002-4', 'lesson-html-002', 'What does this code display?', '<h1>Hello World</h1>', 4);

-- --------------------------------------------------------

--
-- Table structure for table `cnt_question_options`
--

CREATE TABLE `cnt_question_options` (
  `id` char(36) NOT NULL DEFAULT (uuid()),
  `question_id` char(36) NOT NULL,
  `option_text` varchar(300) NOT NULL,
  `is_correct` tinyint(1) NOT NULL DEFAULT '0',
  `order_index` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cnt_question_options`
--

INSERT INTO `cnt_question_options` (`id`, `question_id`, `option_text`, `is_correct`, `order_index`) VALUES
('2b132dec-5747-11f1-9081-9ad025ab06b0', 'q-html-001-1', 'HyperText Markup Language', 1, 1),
('2b13370f-5747-11f1-9081-9ad025ab06b0', 'q-html-001-1', 'HighText Machine Language', 0, 2),
('2b1339be-5747-11f1-9081-9ad025ab06b0', 'q-html-001-1', 'HyperText Machine Language', 0, 3),
('2b133dd3-5747-11f1-9081-9ad025ab06b0', 'q-html-001-1', 'HyperLink Text Markup', 0, 4),
('2b15e0e8-5747-11f1-9081-9ad025ab06b0', 'q-html-001-2', '.html', 1, 1),
('2b15e670-5747-11f1-9081-9ad025ab06b0', 'q-html-001-2', '.hml', 0, 2),
('2b15e7a7-5747-11f1-9081-9ad025ab06b0', 'q-html-001-2', '.htm2', 0, 3),
('2b15e887-5747-11f1-9081-9ad025ab06b0', 'q-html-001-2', '.web', 0, 4),
('2b186072-5747-11f1-9081-9ad025ab06b0', 'q-html-001-3', 'To structure web content', 1, 1),
('2b186a97-5747-11f1-9081-9ad025ab06b0', 'q-html-001-3', 'To style web pages', 0, 2),
('2b186c54-5747-11f1-9081-9ad025ab06b0', 'q-html-001-3', 'To add interactivity to pages', 0, 3),
('2b186d46-5747-11f1-9081-9ad025ab06b0', 'q-html-001-3', 'To store data in a database', 0, 4),
('2b1ac626-5747-11f1-9081-9ad025ab06b0', 'q-html-001-4', '<!DOCTYPE html>', 1, 1),
('2b1acbc2-5747-11f1-9081-9ad025ab06b0', 'q-html-001-4', '<html>', 0, 2),
('2b1accc4-5747-11f1-9081-9ad025ab06b0', 'q-html-001-4', '<head>', 0, 3),
('2b1acd8f-5747-11f1-9081-9ad025ab06b0', 'q-html-001-4', '<doctype>', 0, 4),
('3bc54771-5747-11f1-9081-9ad025ab06b0', 'q-html-002-1', '<h1>', 1, 1),
('3bc54b89-5747-11f1-9081-9ad025ab06b0', 'q-html-002-1', '<h6>', 0, 2),
('3bc54c01-5747-11f1-9081-9ad025ab06b0', 'q-html-002-1', '<heading>', 0, 3),
('3bc54c98-5747-11f1-9081-9ad025ab06b0', 'q-html-002-1', '<head>', 0, 4),
('3bc7eeab-5747-11f1-9081-9ad025ab06b0', 'q-html-002-2', 'Creates a hyperlink', 1, 1),
('3bc7f2f6-5747-11f1-9081-9ad025ab06b0', 'q-html-002-2', 'Creates an image', 0, 2),
('3bc7f36d-5747-11f1-9081-9ad025ab06b0', 'q-html-002-2', 'Creates a paragraph', 0, 3),
('3bc7f3c9-5747-11f1-9081-9ad025ab06b0', 'q-html-002-2', 'Creates a list', 0, 4),
('3bcaed22-5747-11f1-9081-9ad025ab06b0', 'q-html-002-3', '<p>', 1, 1),
('3bcafa88-5747-11f1-9081-9ad025ab06b0', 'q-html-002-3', '<par>', 0, 2),
('3bcaffb1-5747-11f1-9081-9ad025ab06b0', 'q-html-002-3', '<pg>', 0, 3),
('3bcb0271-5747-11f1-9081-9ad025ab06b0', 'q-html-002-3', '<text>', 0, 4),
('3bcdbd70-5747-11f1-9081-9ad025ab06b0', 'q-html-002-4', 'A large heading saying Hello World', 1, 1),
('3bcdc3ed-5747-11f1-9081-9ad025ab06b0', 'q-html-002-4', 'A small text saying Hello World', 0, 2),
('3bcdc480-5747-11f1-9081-9ad025ab06b0', 'q-html-002-4', 'A paragraph saying Hello World', 0, 3),
('3bcdc4d2-5747-11f1-9081-9ad025ab06b0', 'q-html-002-4', 'Nothing — it is not valid HTML', 0, 4),
('441f5814-5747-11f1-9081-9ad025ab06b0', 'q-css-001-1', 'Cascading Style Sheets', 1, 1),
('441f5c93-5747-11f1-9081-9ad025ab06b0', 'q-css-001-1', 'Creative Style System', 0, 2),
('441f5d3b-5747-11f1-9081-9ad025ab06b0', 'q-css-001-1', 'Computer Style Sheets', 0, 3),
('441f5dad-5747-11f1-9081-9ad025ab06b0', 'q-css-001-1', 'Colorful Style Sheets', 0, 4),
('4421e2d4-5747-11f1-9081-9ad025ab06b0', 'q-css-001-2', 'color', 1, 1),
('4421e946-5747-11f1-9081-9ad025ab06b0', 'q-css-001-2', 'text-color', 0, 2),
('4421e9d1-5747-11f1-9081-9ad025ab06b0', 'q-css-001-2', 'font-color', 0, 3),
('4421ea24-5747-11f1-9081-9ad025ab06b0', 'q-css-001-2', 'text-style', 0, 4),
('4424d1d5-5747-11f1-9081-9ad025ab06b0', 'q-css-001-3', 'p { color: red; }', 1, 1),
('4424d9f6-5747-11f1-9081-9ad025ab06b0', 'q-css-001-3', 'p: color = red;', 0, 2),
('4424db68-5747-11f1-9081-9ad025ab06b0', 'q-css-001-3', '{p; color: red}', 0, 3),
('4424dc74-5747-11f1-9081-9ad025ab06b0', 'q-css-001-3', 'p color: red;', 0, 4),
('4427c55f-5747-11f1-9081-9ad025ab06b0', 'q-css-001-4', 'Makes all paragraph text red', 1, 1),
('4427d2c6-5747-11f1-9081-9ad025ab06b0', 'q-css-001-4', 'Makes the page background red', 0, 2),
('4427d5c2-5747-11f1-9081-9ad025ab06b0', 'q-css-001-4', 'Makes all text on page red', 0, 3),
('4427d80d-5747-11f1-9081-9ad025ab06b0', 'q-css-001-4', 'Changes the border color to red', 0, 4);

-- --------------------------------------------------------

--
-- Table structure for table `cnt_tracks`
--

CREATE TABLE `cnt_tracks` (
  `id` char(36) NOT NULL DEFAULT (uuid()),
  `language_id` char(36) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text,
  `difficulty` enum('beginner','intermediate','advanced') NOT NULL DEFAULT 'beginner',
  `order_index` int NOT NULL DEFAULT '0',
  `total_lessons` int NOT NULL DEFAULT '0',
  `icon_url` text,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cnt_tracks`
--

INSERT INTO `cnt_tracks` (`id`, `language_id`, `title`, `description`, `difficulty`, `order_index`, `total_lessons`, `icon_url`, `created_at`) VALUES
('4142c32e-481a-11f1-befa-9ad025ab06b0', '40948356-481a-11f1-befa-9ad025ab06b0', 'Python Basics', NULL, 'beginner', 1, 20, NULL, '2026-05-05 07:35:02'),
('4142cdfc-481a-11f1-befa-9ad025ab06b0', '40948356-481a-11f1-befa-9ad025ab06b0', 'Functions & Modules', NULL, 'beginner', 2, 15, NULL, '2026-05-05 07:35:02'),
('4142d5a2-481a-11f1-befa-9ad025ab06b0', '40948356-481a-11f1-befa-9ad025ab06b0', 'Object-Oriented Python', NULL, 'intermediate', 3, 18, NULL, '2026-05-05 07:35:02'),
('4142d9cf-481a-11f1-befa-9ad025ab06b0', '40948356-481a-11f1-befa-9ad025ab06b0', 'File I/O & Error Handling', NULL, 'intermediate', 4, 12, NULL, '2026-05-05 07:35:02'),
('4142dc24-481a-11f1-befa-9ad025ab06b0', '40948356-481a-11f1-befa-9ad025ab06b0', 'Data Structures', NULL, 'advanced', 5, 20, NULL, '2026-05-05 07:35:02'),
('4142de72-481a-11f1-befa-9ad025ab06b0', '40948356-481a-11f1-befa-9ad025ab06b0', 'Algorithms', NULL, 'advanced', 6, 20, NULL, '2026-05-05 07:35:02'),
('4142e0ff-481a-11f1-befa-9ad025ab06b0', '40948ade-481a-11f1-befa-9ad025ab06b0', 'CSS Fundamentals', NULL, 'beginner', 1, 18, NULL, '2026-05-05 07:35:02'),
('4142e2df-481a-11f1-befa-9ad025ab06b0', '40948ade-481a-11f1-befa-9ad025ab06b0', 'Layouts & Flexbox', NULL, 'beginner', 2, 15, NULL, '2026-05-05 07:35:02'),
('4142e4cf-481a-11f1-befa-9ad025ab06b0', '40948ade-481a-11f1-befa-9ad025ab06b0', 'Grid & Responsive Design', NULL, 'intermediate', 3, 15, NULL, '2026-05-05 07:35:02'),
('4142e6b5-481a-11f1-befa-9ad025ab06b0', '40948ade-481a-11f1-befa-9ad025ab06b0', 'Animations & Transitions', NULL, 'advanced', 4, 12, NULL, '2026-05-05 07:35:02'),
('4142e914-481a-11f1-befa-9ad025ab06b0', '40948c45-481a-11f1-befa-9ad025ab06b0', 'HTML Basics', NULL, 'beginner', 1, 16, NULL, '2026-05-05 07:35:02'),
('4142eaf4-481a-11f1-befa-9ad025ab06b0', '40948c45-481a-11f1-befa-9ad025ab06b0', 'Forms & Inputs', NULL, 'beginner', 2, 12, NULL, '2026-05-05 07:35:02'),
('4142eceb-481a-11f1-befa-9ad025ab06b0', '40948c45-481a-11f1-befa-9ad025ab06b0', 'Semantic HTML & Accessibility', NULL, 'intermediate', 3, 14, NULL, '2026-05-05 07:35:02'),
('4142ef2d-481a-11f1-befa-9ad025ab06b0', '40948cea-481a-11f1-befa-9ad025ab06b0', 'JS Basics', NULL, 'beginner', 1, 20, NULL, '2026-05-05 07:35:02'),
('4142f15a-481a-11f1-befa-9ad025ab06b0', '40948cea-481a-11f1-befa-9ad025ab06b0', 'DOM Manipulation', NULL, 'beginner', 2, 15, NULL, '2026-05-05 07:35:02'),
('4142f35a-481a-11f1-befa-9ad025ab06b0', '40948cea-481a-11f1-befa-9ad025ab06b0', 'Async & Promises', NULL, 'intermediate', 3, 14, NULL, '2026-05-05 07:35:02'),
('4142f54a-481a-11f1-befa-9ad025ab06b0', '40948cea-481a-11f1-befa-9ad025ab06b0', 'ES6+ Modern JS', NULL, 'intermediate', 4, 16, NULL, '2026-05-05 07:35:02'),
('4142f744-481a-11f1-befa-9ad025ab06b0', '40948cea-481a-11f1-befa-9ad025ab06b0', 'Node.js & APIs', NULL, 'advanced', 5, 18, NULL, '2026-05-05 07:35:02'),
('4142f975-481a-11f1-befa-9ad025ab06b0', '40948d7c-481a-11f1-befa-9ad025ab06b0', 'Java Basics', NULL, 'beginner', 1, 20, NULL, '2026-05-05 07:35:02'),
('4142fb86-481a-11f1-befa-9ad025ab06b0', '40948d7c-481a-11f1-befa-9ad025ab06b0', 'OOP in Java', NULL, 'intermediate', 2, 18, NULL, '2026-05-05 07:35:02'),
('4142fd96-481a-11f1-befa-9ad025ab06b0', '40948d7c-481a-11f1-befa-9ad025ab06b0', 'Collections & Generics', NULL, 'intermediate', 3, 15, NULL, '2026-05-05 07:35:02'),
('4142ffb6-481a-11f1-befa-9ad025ab06b0', '40948d7c-481a-11f1-befa-9ad025ab06b0', 'Concurrency & Threads', NULL, 'advanced', 4, 14, NULL, '2026-05-05 07:35:02'),
('4143023f-481a-11f1-befa-9ad025ab06b0', '40948e1c-481a-11f1-befa-9ad025ab06b0', 'C# Basics', NULL, 'beginner', 1, 20, NULL, '2026-05-05 07:35:02'),
('4143045d-481a-11f1-befa-9ad025ab06b0', '40948e1c-481a-11f1-befa-9ad025ab06b0', '.NET & OOP', NULL, 'intermediate', 2, 18, NULL, '2026-05-05 07:35:02'),
('4143068c-481a-11f1-befa-9ad025ab06b0', '40948e1c-481a-11f1-befa-9ad025ab06b0', 'LINQ & Collections', NULL, 'intermediate', 3, 14, NULL, '2026-05-05 07:35:02'),
('414308b4-481a-11f1-befa-9ad025ab06b0', '40948e1c-481a-11f1-befa-9ad025ab06b0', 'ASP.NET Core Basics', NULL, 'advanced', 4, 16, NULL, '2026-05-05 07:35:02'),
('41430b2d-481a-11f1-befa-9ad025ab06b0', '40948eaa-481a-11f1-befa-9ad025ab06b0', 'C++ Basics', NULL, 'beginner', 1, 20, NULL, '2026-05-05 07:35:02'),
('41430d4c-481a-11f1-befa-9ad025ab06b0', '40948eaa-481a-11f1-befa-9ad025ab06b0', 'Pointers & Memory', NULL, 'intermediate', 2, 16, NULL, '2026-05-05 07:35:02'),
('41430f74-481a-11f1-befa-9ad025ab06b0', '40948eaa-481a-11f1-befa-9ad025ab06b0', 'STL & Templates', NULL, 'advanced', 3, 15, NULL, '2026-05-05 07:35:02'),
('414311fc-481a-11f1-befa-9ad025ab06b0', '40948f83-481a-11f1-befa-9ad025ab06b0', 'PHP Basics', NULL, 'beginner', 1, 18, NULL, '2026-05-05 07:35:02'),
('4143159d-481a-11f1-befa-9ad025ab06b0', '40948f83-481a-11f1-befa-9ad025ab06b0', 'PHP & Forms', NULL, 'beginner', 2, 12, NULL, '2026-05-05 07:35:02'),
('4143181e-481a-11f1-befa-9ad025ab06b0', '40948f83-481a-11f1-befa-9ad025ab06b0', 'PHP & MySQL', NULL, 'intermediate', 3, 16, NULL, '2026-05-05 07:35:02'),
('41431a39-481a-11f1-befa-9ad025ab06b0', '40948f83-481a-11f1-befa-9ad025ab06b0', 'Laravel Basics', NULL, 'advanced', 4, 18, NULL, '2026-05-05 07:35:02');

-- --------------------------------------------------------

--
-- Table structure for table `prg_lesson_progress`
--

CREATE TABLE `prg_lesson_progress` (
  `id` char(36) NOT NULL DEFAULT (uuid()),
  `user_id` char(36) NOT NULL,
  `lesson_id` char(36) NOT NULL,
  `status` enum('locked','available','in_progress','completed') NOT NULL DEFAULT 'locked',
  `score` int NOT NULL DEFAULT '0',
  `attempts` int NOT NULL DEFAULT '0',
  `completed_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `prg_lesson_progress`
--

INSERT INTO `prg_lesson_progress` (`id`, `user_id`, `lesson_id`, `status`, `score`, `attempts`, `completed_at`) VALUES
('0bc8ad3d-575c-11f1-9081-9ad025ab06b0', '049fd4eb-575c-11f1-9081-9ad025ab06b0', 'lesson-css-001', 'completed', 4, 0, '2026-05-24 17:33:47'),
('2cf67e10-575b-11f1-9081-9ad025ab06b0', '94fa43b4-55d3-11f1-b67a-9ad025ab06b0', 'lesson-css-001', 'completed', 3, 0, '2026-05-24 17:27:33'),
('f8df5297-5747-11f1-9081-9ad025ab06b0', '9aca2d6d-55d3-11f1-b67a-9ad025ab06b0', 'lesson-css-001', 'completed', 3, 0, '2026-05-24 15:10:05');

-- --------------------------------------------------------

--
-- Table structure for table `prg_user_tracks`
--

CREATE TABLE `prg_user_tracks` (
  `id` char(36) NOT NULL DEFAULT (uuid()),
  `user_id` char(36) NOT NULL,
  `track_id` char(36) NOT NULL,
  `xp_earned` int NOT NULL DEFAULT '0',
  `completion_pct` decimal(5,2) NOT NULL DEFAULT '0.00',
  `enrolled_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rwd_badges`
--

CREATE TABLE `rwd_badges` (
  `id` char(36) NOT NULL DEFAULT (uuid()),
  `name` varchar(100) NOT NULL,
  `description` text,
  `icon_url` text,
  `criteria_type` varchar(50) NOT NULL,
  `criteria_value` int NOT NULL DEFAULT '1',
  `language_id` char(36) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `rwd_badges`
--

INSERT INTO `rwd_badges` (`id`, `name`, `description`, `icon_url`, `criteria_type`, `criteria_value`, `language_id`) VALUES
('41480165-481a-11f1-befa-9ad025ab06b0', 'First Run', 'Submit your first solution', '/badges/first_run.svg', 'first_submission', 1, NULL),
('41480738-481a-11f1-befa-9ad025ab06b0', 'Bug Slayer', 'Pass 10 fix-the-bug challenges', '/badges/bug.svg', 'challenges_passed', 10, NULL),
('414808f2-481a-11f1-befa-9ad025ab06b0', 'On Fire', 'Reach a 7-day streak', '/badges/fire.svg', 'streak_days', 7, NULL),
('414809f1-481a-11f1-befa-9ad025ab06b0', 'Unstoppable', 'Reach a 30-day streak', '/badges/unstop.svg', 'streak_days', 30, NULL),
('41480ad6-481a-11f1-befa-9ad025ab06b0', 'XP Hunter', 'Earn 500 total XP', '/badges/xp500.svg', 'xp_total', 500, NULL),
('41480bb5-481a-11f1-befa-9ad025ab06b0', 'XP Legend', 'Earn 5000 total XP', '/badges/xp5000.svg', 'xp_total', 5000, NULL),
('41480c89-481a-11f1-befa-9ad025ab06b0', 'Perfectionist', 'Get a perfect score on a challenge', '/badges/perfect.svg', 'perfect_score', 1, NULL),
('41480f64-481a-11f1-befa-9ad025ab06b0', 'Century Club', 'Complete 100 challenges', '/badges/century.svg', 'challenges_passed', 100, NULL),
('414dc0a5-481a-11f1-befa-9ad025ab06b0', 'C# Expert', 'Reach Expert level in C#', '/badges/expert.svg', 'level_reached', 6, '40948e1c-481a-11f1-befa-9ad025ab06b0'),
('414dc824-481a-11f1-befa-9ad025ab06b0', 'C# Advanced', 'Reach Advanced level in C#', '/badges/advanced.svg', 'level_reached', 5, '40948e1c-481a-11f1-befa-9ad025ab06b0'),
('414dcace-481a-11f1-befa-9ad025ab06b0', 'C# Upper Intermediate', 'Reach Upper Intermediate level in C#', '/badges/upper_intermediate.svg', 'level_reached', 4, '40948e1c-481a-11f1-befa-9ad025ab06b0'),
('414dcd13-481a-11f1-befa-9ad025ab06b0', 'C# Intermediate', 'Reach Intermediate level in C#', '/badges/intermediate.svg', 'level_reached', 3, '40948e1c-481a-11f1-befa-9ad025ab06b0'),
('414dcf1c-481a-11f1-befa-9ad025ab06b0', 'C# Elementary', 'Reach Elementary level in C#', '/badges/elementary.svg', 'level_reached', 2, '40948e1c-481a-11f1-befa-9ad025ab06b0'),
('414dd17d-481a-11f1-befa-9ad025ab06b0', 'C++ Expert', 'Reach Expert level in C++', '/badges/expert.svg', 'level_reached', 6, '40948eaa-481a-11f1-befa-9ad025ab06b0'),
('414dd37c-481a-11f1-befa-9ad025ab06b0', 'C++ Advanced', 'Reach Advanced level in C++', '/badges/advanced.svg', 'level_reached', 5, '40948eaa-481a-11f1-befa-9ad025ab06b0'),
('414dd577-481a-11f1-befa-9ad025ab06b0', 'C++ Upper Intermediate', 'Reach Upper Intermediate level in C++', '/badges/upper_intermediate.svg', 'level_reached', 4, '40948eaa-481a-11f1-befa-9ad025ab06b0'),
('414dd774-481a-11f1-befa-9ad025ab06b0', 'C++ Intermediate', 'Reach Intermediate level in C++', '/badges/intermediate.svg', 'level_reached', 3, '40948eaa-481a-11f1-befa-9ad025ab06b0'),
('414dd96e-481a-11f1-befa-9ad025ab06b0', 'C++ Elementary', 'Reach Elementary level in C++', '/badges/elementary.svg', 'level_reached', 2, '40948eaa-481a-11f1-befa-9ad025ab06b0'),
('414ddb89-481a-11f1-befa-9ad025ab06b0', 'CSS Expert', 'Reach Expert level in CSS', '/badges/expert.svg', 'level_reached', 6, '40948ade-481a-11f1-befa-9ad025ab06b0'),
('414ddd85-481a-11f1-befa-9ad025ab06b0', 'CSS Advanced', 'Reach Advanced level in CSS', '/badges/advanced.svg', 'level_reached', 5, '40948ade-481a-11f1-befa-9ad025ab06b0'),
('414ddf6e-481a-11f1-befa-9ad025ab06b0', 'CSS Upper Intermediate', 'Reach Upper Intermediate level in CSS', '/badges/upper_intermediate.svg', 'level_reached', 4, '40948ade-481a-11f1-befa-9ad025ab06b0'),
('414de17a-481a-11f1-befa-9ad025ab06b0', 'CSS Intermediate', 'Reach Intermediate level in CSS', '/badges/intermediate.svg', 'level_reached', 3, '40948ade-481a-11f1-befa-9ad025ab06b0'),
('414de383-481a-11f1-befa-9ad025ab06b0', 'CSS Elementary', 'Reach Elementary level in CSS', '/badges/elementary.svg', 'level_reached', 2, '40948ade-481a-11f1-befa-9ad025ab06b0'),
('414de5b5-481a-11f1-befa-9ad025ab06b0', 'HTML Expert', 'Reach Expert level in HTML', '/badges/expert.svg', 'level_reached', 6, '40948c45-481a-11f1-befa-9ad025ab06b0'),
('414de79d-481a-11f1-befa-9ad025ab06b0', 'HTML Advanced', 'Reach Advanced level in HTML', '/badges/advanced.svg', 'level_reached', 5, '40948c45-481a-11f1-befa-9ad025ab06b0'),
('414de982-481a-11f1-befa-9ad025ab06b0', 'HTML Upper Intermediate', 'Reach Upper Intermediate level in HTML', '/badges/upper_intermediate.svg', 'level_reached', 4, '40948c45-481a-11f1-befa-9ad025ab06b0'),
('414deb77-481a-11f1-befa-9ad025ab06b0', 'HTML Intermediate', 'Reach Intermediate level in HTML', '/badges/intermediate.svg', 'level_reached', 3, '40948c45-481a-11f1-befa-9ad025ab06b0'),
('414deec9-481a-11f1-befa-9ad025ab06b0', 'HTML Elementary', 'Reach Elementary level in HTML', '/badges/elementary.svg', 'level_reached', 2, '40948c45-481a-11f1-befa-9ad025ab06b0'),
('414df10e-481a-11f1-befa-9ad025ab06b0', 'Java Expert', 'Reach Expert level in Java', '/badges/expert.svg', 'level_reached', 6, '40948d7c-481a-11f1-befa-9ad025ab06b0'),
('414df2f4-481a-11f1-befa-9ad025ab06b0', 'Java Advanced', 'Reach Advanced level in Java', '/badges/advanced.svg', 'level_reached', 5, '40948d7c-481a-11f1-befa-9ad025ab06b0'),
('414df4d4-481a-11f1-befa-9ad025ab06b0', 'Java Upper Intermediate', 'Reach Upper Intermediate level in Java', '/badges/upper_intermediate.svg', 'level_reached', 4, '40948d7c-481a-11f1-befa-9ad025ab06b0'),
('414df6b1-481a-11f1-befa-9ad025ab06b0', 'Java Intermediate', 'Reach Intermediate level in Java', '/badges/intermediate.svg', 'level_reached', 3, '40948d7c-481a-11f1-befa-9ad025ab06b0'),
('414df893-481a-11f1-befa-9ad025ab06b0', 'Java Elementary', 'Reach Elementary level in Java', '/badges/elementary.svg', 'level_reached', 2, '40948d7c-481a-11f1-befa-9ad025ab06b0'),
('414dfabe-481a-11f1-befa-9ad025ab06b0', 'JavaScript Expert', 'Reach Expert level in JavaScript', '/badges/expert.svg', 'level_reached', 6, '40948cea-481a-11f1-befa-9ad025ab06b0'),
('414dfccd-481a-11f1-befa-9ad025ab06b0', 'JavaScript Advanced', 'Reach Advanced level in JavaScript', '/badges/advanced.svg', 'level_reached', 5, '40948cea-481a-11f1-befa-9ad025ab06b0'),
('414dfec9-481a-11f1-befa-9ad025ab06b0', 'JavaScript Upper Intermediate', 'Reach Upper Intermediate level in JavaScript', '/badges/upper_intermediate.svg', 'level_reached', 4, '40948cea-481a-11f1-befa-9ad025ab06b0'),
('414e0124-481a-11f1-befa-9ad025ab06b0', 'JavaScript Intermediate', 'Reach Intermediate level in JavaScript', '/badges/intermediate.svg', 'level_reached', 3, '40948cea-481a-11f1-befa-9ad025ab06b0'),
('414e0373-481a-11f1-befa-9ad025ab06b0', 'JavaScript Elementary', 'Reach Elementary level in JavaScript', '/badges/elementary.svg', 'level_reached', 2, '40948cea-481a-11f1-befa-9ad025ab06b0'),
('414e05c6-481a-11f1-befa-9ad025ab06b0', 'PHP Expert', 'Reach Expert level in PHP', '/badges/expert.svg', 'level_reached', 6, '40948f83-481a-11f1-befa-9ad025ab06b0'),
('414e07c4-481a-11f1-befa-9ad025ab06b0', 'PHP Advanced', 'Reach Advanced level in PHP', '/badges/advanced.svg', 'level_reached', 5, '40948f83-481a-11f1-befa-9ad025ab06b0'),
('414e09bf-481a-11f1-befa-9ad025ab06b0', 'PHP Upper Intermediate', 'Reach Upper Intermediate level in PHP', '/badges/upper_intermediate.svg', 'level_reached', 4, '40948f83-481a-11f1-befa-9ad025ab06b0'),
('414e0bbe-481a-11f1-befa-9ad025ab06b0', 'PHP Intermediate', 'Reach Intermediate level in PHP', '/badges/intermediate.svg', 'level_reached', 3, '40948f83-481a-11f1-befa-9ad025ab06b0'),
('414e0dc3-481a-11f1-befa-9ad025ab06b0', 'PHP Elementary', 'Reach Elementary level in PHP', '/badges/elementary.svg', 'level_reached', 2, '40948f83-481a-11f1-befa-9ad025ab06b0'),
('414e0ffc-481a-11f1-befa-9ad025ab06b0', 'Python Expert', 'Reach Expert level in Python', '/badges/expert.svg', 'level_reached', 6, '40948356-481a-11f1-befa-9ad025ab06b0'),
('414e11da-481a-11f1-befa-9ad025ab06b0', 'Python Advanced', 'Reach Advanced level in Python', '/badges/advanced.svg', 'level_reached', 5, '40948356-481a-11f1-befa-9ad025ab06b0'),
('414e13e2-481a-11f1-befa-9ad025ab06b0', 'Python Upper Intermediate', 'Reach Upper Intermediate level in Python', '/badges/upper_intermediate.svg', 'level_reached', 4, '40948356-481a-11f1-befa-9ad025ab06b0'),
('414e15e1-481a-11f1-befa-9ad025ab06b0', 'Python Intermediate', 'Reach Intermediate level in Python', '/badges/intermediate.svg', 'level_reached', 3, '40948356-481a-11f1-befa-9ad025ab06b0'),
('414e180b-481a-11f1-befa-9ad025ab06b0', 'Python Elementary', 'Reach Elementary level in Python', '/badges/elementary.svg', 'level_reached', 2, '40948356-481a-11f1-befa-9ad025ab06b0');

-- --------------------------------------------------------

--
-- Table structure for table `rwd_user_badges`
--

CREATE TABLE `rwd_user_badges` (
  `id` char(36) NOT NULL DEFAULT (uuid()),
  `user_id` char(36) NOT NULL,
  `badge_id` char(36) NOT NULL,
  `earned_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shp_items`
--

CREATE TABLE `shp_items` (
  `id` char(36) NOT NULL DEFAULT (uuid()),
  `name` varchar(100) NOT NULL,
  `description` text,
  `type` enum('heart','streak_freeze','xp_boost') NOT NULL DEFAULT 'heart',
  `cost` int NOT NULL DEFAULT '100',
  `icon_url` text,
  `max_per_user` int DEFAULT NULL COMMENT 'NULL = unlimited',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `shp_items`
--

INSERT INTO `shp_items` (`id`, `name`, `description`, `type`, `cost`, `icon_url`, `max_per_user`, `is_active`, `created_at`) VALUES
('14414d37-531e-11f1-8e23-00155d3a593c', 'Heart Refill', 'heart bjir sama ini agak ha', 'heart', 350, '/assets/heart1.png', NULL, 1, '2026-05-19 08:00:07'),
('14415907-531e-11f1-8e23-00155d3a593c', 'Streak Freeze', 'skill isu', 'streak_freeze', 200, '/assets/streak-black.png', NULL, 1, '2026-05-19 08:00:07');

-- --------------------------------------------------------

--
-- Table structure for table `shp_purchases`
--

CREATE TABLE `shp_purchases` (
  `id` char(36) NOT NULL DEFAULT (uuid()),
  `user_id` char(36) NOT NULL,
  `item_id` char(36) NOT NULL,
  `gems_spent` int NOT NULL,
  `purchased_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usr_language_levels`
--

CREATE TABLE `usr_language_levels` (
  `id` char(36) NOT NULL DEFAULT (uuid()),
  `user_id` char(36) NOT NULL,
  `language_id` char(36) NOT NULL,
  `level` enum('beginner','elementary','intermediate','upper_intermediate','advanced','expert') NOT NULL DEFAULT 'beginner',
  `level_num` tinyint NOT NULL DEFAULT '1',
  `xp_in_level` int NOT NULL DEFAULT '0',
  `xp_to_next_level` int NOT NULL DEFAULT '200',
  `last_activity_at` datetime DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `knowledge_level` tinyint DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `usr_language_levels`
--

INSERT INTO `usr_language_levels` (`id`, `user_id`, `language_id`, `level`, `level_num`, `xp_in_level`, `xp_to_next_level`, `last_activity_at`, `updated_at`, `knowledge_level`) VALUES
('0155a41e-55d8-11f1-b67a-9ad025ab06b0', '9aca2d6d-55d3-11f1-b67a-9ad025ab06b0', '40948eaa-481a-11f1-befa-9ad025ab06b0', 'beginner', 1, 0, 200, NULL, '2026-05-22 19:27:18', 3),
('0596bb0c-575c-11f1-9081-9ad025ab06b0', '049fd4eb-575c-11f1-9081-9ad025ab06b0', '40948ade-481a-11f1-befa-9ad025ab06b0', 'beginner', 1, 30, 200, NULL, '2026-05-24 17:33:47', 2),
('125ae876-56bc-11f1-b4c2-9ad025ab06b0', '9aca2d6d-55d3-11f1-b67a-9ad025ab06b0', '40948ade-481a-11f1-befa-9ad025ab06b0', 'beginner', 1, 25, 200, NULL, '2026-05-24 17:33:25', 2),
('22878586-574d-11f1-9081-9ad025ab06b0', '94fa43b4-55d3-11f1-b67a-9ad025ab06b0', '40948eaa-481a-11f1-befa-9ad025ab06b0', 'beginner', 1, 0, 200, NULL, '2026-05-24 15:47:02', 1),
('766519e8-56bc-11f1-b4c2-9ad025ab06b0', '94fa43b4-55d3-11f1-b67a-9ad025ab06b0', '40948ade-481a-11f1-befa-9ad025ab06b0', 'beginner', 1, 25, 200, NULL, '2026-05-24 17:52:20', 1);

-- --------------------------------------------------------

--
-- Table structure for table `usr_streaks`
--

CREATE TABLE `usr_streaks` (
  `id` char(36) NOT NULL DEFAULT (uuid()),
  `user_id` char(36) NOT NULL,
  `current_streak` int NOT NULL DEFAULT '0',
  `longest_streak` int NOT NULL DEFAULT '0',
  `last_activity_date` date DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usr_users`
--

CREATE TABLE `usr_users` (
  `id` char(36) NOT NULL DEFAULT (uuid()),
  `username` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` text,
  `avatar_url` text,
  `xp_total` int NOT NULL DEFAULT '0',
  `gems` int NOT NULL DEFAULT '0',
  `hearts` int NOT NULL DEFAULT '5',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login_at` datetime DEFAULT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `bio` text,
  `banner_url` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `usr_users`
--

INSERT INTO `usr_users` (`id`, `username`, `email`, `password_hash`, `avatar_url`, `xp_total`, `gems`, `hearts`, `created_at`, `last_login_at`, `google_id`, `name`, `bio`, `banner_url`) VALUES
('049fd4eb-575c-11f1-9081-9ad025ab06b0', 'gimmme3103@gmail.com', 'gimmme3103@gmail.com', NULL, 'https://lh3.googleusercontent.com/a/ACg8ocKaom9AK7gL3m1v98MP-tbI6dj-pMI_T_qObYOs4h9Gbq5DuQ=s96-c', 0, 0, 5, '2026-05-24 17:33:35', NULL, '114203360894875000458', 'Wily Sepiro', NULL, NULL),
('94fa43b4-55d3-11f1-b67a-9ad025ab06b0', 'Testimonial 1', 'wily.002@ski.sch.id', NULL, '/Edu_Streak_Lock_in/public/uploads/avatar_94fa43b4-55d3-11f1-b67a-9ad025ab06b0.png', 0, 0, 5, '2026-05-22 18:44:25', NULL, '102768672987044061998', 'Wily Sepiro', 'Test test if this show up then its working', '/Edu_Streak_Lock_in/public/uploads/banner_94fa43b4-55d3-11f1-b67a-9ad025ab06b0.jpg'),
('9aca2d6d-55d3-11f1-b67a-9ad025ab06b0', 'ahien3103@gmail.com', 'ahien3103@gmail.com', NULL, 'https://lh3.googleusercontent.com/a/ACg8ocIzoIsP7pMH-G1giGwiLkGW4qmDEtqDZE1S0NduGBiWdWQ_9g=s96-c', 0, 0, 5, '2026-05-22 18:44:34', NULL, '100963396280889217140', 'Ahien 120', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chl_challenges`
--
ALTER TABLE `chl_challenges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_ch_lesson` (`lesson_id`);

--
-- Indexes for table `chl_submissions`
--
ALTER TABLE `chl_submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_sub_user` (`user_id`),
  ADD KEY `idx_sub_challenge` (`challenge_id`),
  ADD KEY `idx_sub_status` (`status`);

--
-- Indexes for table `cnt_languages`
--
ALTER TABLE `cnt_languages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `cnt_lessons`
--
ALTER TABLE `cnt_lessons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_cl_track_order` (`track_id`,`order_index`),
  ADD KEY `idx_cl_track` (`track_id`);

--
-- Indexes for table `cnt_questions`
--
ALTER TABLE `cnt_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_cq_lesson` (`lesson_id`);

--
-- Indexes for table `cnt_question_options`
--
ALTER TABLE `cnt_question_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_cqo_question` (`question_id`);

--
-- Indexes for table `cnt_tracks`
--
ALTER TABLE `cnt_tracks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_ct_lang_order` (`language_id`,`order_index`),
  ADD KEY `idx_ct_language` (`language_id`);

--
-- Indexes for table `prg_lesson_progress`
--
ALTER TABLE `prg_lesson_progress`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_plp_user_lesson` (`user_id`,`lesson_id`),
  ADD KEY `idx_plp_user` (`user_id`),
  ADD KEY `idx_plp_lesson` (`lesson_id`);

--
-- Indexes for table `prg_user_tracks`
--
ALTER TABLE `prg_user_tracks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_put_user_track` (`user_id`,`track_id`),
  ADD KEY `idx_put_user` (`user_id`),
  ADD KEY `idx_put_track` (`track_id`);

--
-- Indexes for table `rwd_badges`
--
ALTER TABLE `rwd_badges`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `idx_rb_language` (`language_id`);

--
-- Indexes for table `rwd_user_badges`
--
ALTER TABLE `rwd_user_badges`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_rub_user_badge` (`user_id`,`badge_id`),
  ADD KEY `fk_rub_badge` (`badge_id`),
  ADD KEY `idx_rub_user` (`user_id`);

--
-- Indexes for table `shp_items`
--
ALTER TABLE `shp_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shp_purchases`
--
ALTER TABLE `shp_purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_shp_user` (`user_id`),
  ADD KEY `idx_shp_item` (`item_id`);

--
-- Indexes for table `usr_language_levels`
--
ALTER TABLE `usr_language_levels`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_ull_user_lang` (`user_id`,`language_id`),
  ADD KEY `idx_ull_user` (`user_id`),
  ADD KEY `idx_ull_language` (`language_id`);

--
-- Indexes for table `usr_streaks`
--
ALTER TABLE `usr_streaks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `usr_users`
--
ALTER TABLE `usr_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chl_challenges`
--
ALTER TABLE `chl_challenges`
  ADD CONSTRAINT `fk_ch_lesson` FOREIGN KEY (`lesson_id`) REFERENCES `cnt_lessons` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `chl_submissions`
--
ALTER TABLE `chl_submissions`
  ADD CONSTRAINT `fk_sub_challenge` FOREIGN KEY (`challenge_id`) REFERENCES `chl_challenges` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_sub_user` FOREIGN KEY (`user_id`) REFERENCES `usr_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cnt_lessons`
--
ALTER TABLE `cnt_lessons`
  ADD CONSTRAINT `fk_cl_track` FOREIGN KEY (`track_id`) REFERENCES `cnt_tracks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cnt_questions`
--
ALTER TABLE `cnt_questions`
  ADD CONSTRAINT `fk_cq_lesson` FOREIGN KEY (`lesson_id`) REFERENCES `cnt_lessons` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cnt_question_options`
--
ALTER TABLE `cnt_question_options`
  ADD CONSTRAINT `fk_cqo_question` FOREIGN KEY (`question_id`) REFERENCES `cnt_questions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cnt_tracks`
--
ALTER TABLE `cnt_tracks`
  ADD CONSTRAINT `fk_ct_language` FOREIGN KEY (`language_id`) REFERENCES `cnt_languages` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `prg_lesson_progress`
--
ALTER TABLE `prg_lesson_progress`
  ADD CONSTRAINT `fk_plp_lesson` FOREIGN KEY (`lesson_id`) REFERENCES `cnt_lessons` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_plp_user` FOREIGN KEY (`user_id`) REFERENCES `usr_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `prg_user_tracks`
--
ALTER TABLE `prg_user_tracks`
  ADD CONSTRAINT `fk_put_track` FOREIGN KEY (`track_id`) REFERENCES `cnt_tracks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_put_user` FOREIGN KEY (`user_id`) REFERENCES `usr_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rwd_badges`
--
ALTER TABLE `rwd_badges`
  ADD CONSTRAINT `fk_rb_language` FOREIGN KEY (`language_id`) REFERENCES `cnt_languages` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `rwd_user_badges`
--
ALTER TABLE `rwd_user_badges`
  ADD CONSTRAINT `fk_rub_badge` FOREIGN KEY (`badge_id`) REFERENCES `rwd_badges` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_rub_user` FOREIGN KEY (`user_id`) REFERENCES `usr_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shp_purchases`
--
ALTER TABLE `shp_purchases`
  ADD CONSTRAINT `fk_shp_item` FOREIGN KEY (`item_id`) REFERENCES `shp_items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_shp_user` FOREIGN KEY (`user_id`) REFERENCES `usr_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `usr_language_levels`
--
ALTER TABLE `usr_language_levels`
  ADD CONSTRAINT `fk_ull_language` FOREIGN KEY (`language_id`) REFERENCES `cnt_languages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_ull_user` FOREIGN KEY (`user_id`) REFERENCES `usr_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `usr_streaks`
--
ALTER TABLE `usr_streaks`
  ADD CONSTRAINT `fk_ustr_user` FOREIGN KEY (`user_id`) REFERENCES `usr_users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
loading edu_streak (4).sql…]()

--
-- Dumping data for table `cnt_tracks`
--

INSERT INTO `cnt_tracks` (`id`, `language_id`, `title`, `description`, `difficulty`, `order_index`, `total_lessons`, `icon_url`, `created_at`) VALUES
('4142c32e-481a-11f1-befa-9ad025ab06b0', '40948356-481a-11f1-befa-9ad025ab06b0', 'Python Basics', NULL, 'beginner', 1, 20, NULL, '2026-05-05 07:35:02'),
('4142cdfc-481a-11f1-befa-9ad025ab06b0', '40948356-481a-11f1-befa-9ad025ab06b0', 'Functions & Modules', NULL, 'beginner', 2, 15, NULL, '2026-05-05 07:35:02'),
('4142d5a2-481a-11f1-befa-9ad025ab06b0', '40948356-481a-11f1-befa-9ad025ab06b0', 'Object-Oriented Python', NULL, 'intermediate', 3, 18, NULL, '2026-05-05 07:35:02'),
('4142d9cf-481a-11f1-befa-9ad025ab06b0', '40948356-481a-11f1-befa-9ad025ab06b0', 'File I/O & Error Handling', NULL, 'intermediate', 4, 12, NULL, '2026-05-05 07:35:02'),
('4142dc24-481a-11f1-befa-9ad025ab06b0', '40948356-481a-11f1-befa-9ad025ab06b0', 'Data Structures', NULL, 'advanced', 5, 20, NULL, '2026-05-05 07:35:02'),
('4142de72-481a-11f1-befa-9ad025ab06b0', '40948356-481a-11f1-befa-9ad025ab06b0', 'Algorithms', NULL, 'advanced', 6, 20, NULL, '2026-05-05 07:35:02'),
('4142e0ff-481a-11f1-befa-9ad025ab06b0', '40948ade-481a-11f1-befa-9ad025ab06b0', 'CSS Fundamentals', NULL, 'beginner', 1, 18, NULL, '2026-05-05 07:35:02'),
('4142e2df-481a-11f1-befa-9ad025ab06b0', '40948ade-481a-11f1-befa-9ad025ab06b0', 'Layouts & Flexbox', NULL, 'beginner', 2, 15, NULL, '2026-05-05 07:35:02'),
('4142e4cf-481a-11f1-befa-9ad025ab06b0', '40948ade-481a-11f1-befa-9ad025ab06b0', 'Grid & Responsive Design', NULL, 'intermediate', 3, 15, NULL, '2026-05-05 07:35:02'),
('4142e6b5-481a-11f1-befa-9ad025ab06b0', '40948ade-481a-11f1-befa-9ad025ab06b0', 'Animations & Transitions', NULL, 'advanced', 4, 12, NULL, '2026-05-05 07:35:02'),
('4142e914-481a-11f1-befa-9ad025ab06b0', '40948c45-481a-11f1-befa-9ad025ab06b0', 'HTML Basics', NULL, 'beginner', 1, 16, NULL, '2026-05-05 07:35:02'),
('4142eaf4-481a-11f1-befa-9ad025ab06b0', '40948c45-481a-11f1-befa-9ad025ab06b0', 'Forms & Inputs', NULL, 'beginner', 2, 12, NULL, '2026-05-05 07:35:02'),
('4142eceb-481a-11f1-befa-9ad025ab06b0', '40948c45-481a-11f1-befa-9ad025ab06b0', 'Semantic HTML & Accessibility', NULL, 'intermediate', 3, 14, NULL, '2026-05-05 07:35:02'),
('4142ef2d-481a-11f1-befa-9ad025ab06b0', '40948cea-481a-11f1-befa-9ad025ab06b0', 'JS Basics', NULL, 'beginner', 1, 20, NULL, '2026-05-05 07:35:02'),
('4142f15a-481a-11f1-befa-9ad025ab06b0', '40948cea-481a-11f1-befa-9ad025ab06b0', 'DOM Manipulation', NULL, 'beginner', 2, 15, NULL, '2026-05-05 07:35:02'),
('4142f35a-481a-11f1-befa-9ad025ab06b0', '40948cea-481a-11f1-befa-9ad025ab06b0', 'Async & Promises', NULL, 'intermediate', 3, 14, NULL, '2026-05-05 07:35:02'),
('4142f54a-481a-11f1-befa-9ad025ab06b0', '40948cea-481a-11f1-befa-9ad025ab06b0', 'ES6+ Modern JS', NULL, 'intermediate', 4, 16, NULL, '2026-05-05 07:35:02'),
('4142f744-481a-11f1-befa-9ad025ab06b0', '40948cea-481a-11f1-befa-9ad025ab06b0', 'Node.js & APIs', NULL, 'advanced', 5, 18, NULL, '2026-05-05 07:35:02'),
('4142f975-481a-11f1-befa-9ad025ab06b0', '40948d7c-481a-11f1-befa-9ad025ab06b0', 'Java Basics', NULL, 'beginner', 1, 20, NULL, '2026-05-05 07:35:02'),
('4142fb86-481a-11f1-befa-9ad025ab06b0', '40948d7c-481a-11f1-befa-9ad025ab06b0', 'OOP in Java', NULL, 'intermediate', 2, 18, NULL, '2026-05-05 07:35:02'),
('4142fd96-481a-11f1-befa-9ad025ab06b0', '40948d7c-481a-11f1-befa-9ad025ab06b0', 'Collections & Generics', NULL, 'intermediate', 3, 15, NULL, '2026-05-05 07:35:02'),
('4142ffb6-481a-11f1-befa-9ad025ab06b0', '40948d7c-481a-11f1-befa-9ad025ab06b0', 'Concurrency & Threads', NULL, 'advanced', 4, 14, NULL, '2026-05-05 07:35:02'),
('4143023f-481a-11f1-befa-9ad025ab06b0', '40948e1c-481a-11f1-befa-9ad025ab06b0', 'C# Basics', NULL, 'beginner', 1, 20, NULL, '2026-05-05 07:35:02'),
('4143045d-481a-11f1-befa-9ad025ab06b0', '40948e1c-481a-11f1-befa-9ad025ab06b0', '.NET & OOP', NULL, 'intermediate', 2, 18, NULL, '2026-05-05 07:35:02'),
('4143068c-481a-11f1-befa-9ad025ab06b0', '40948e1c-481a-11f1-befa-9ad025ab06b0', 'LINQ & Collections', NULL, 'intermediate', 3, 14, NULL, '2026-05-05 07:35:02'),
('414308b4-481a-11f1-befa-9ad025ab06b0', '40948e1c-481a-11f1-befa-9ad025ab06b0', 'ASP.NET Core Basics', NULL, 'advanced', 4, 16, NULL, '2026-05-05 07:35:02'),
('41430b2d-481a-11f1-befa-9ad025ab06b0', '40948eaa-481a-11f1-befa-9ad025ab06b0', 'C++ Basics', NULL, 'beginner', 1, 20, NULL, '2026-05-05 07:35:02'),
('41430d4c-481a-11f1-befa-9ad025ab06b0', '40948eaa-481a-11f1-befa-9ad025ab06b0', 'Pointers & Memory', NULL, 'intermediate', 2, 16, NULL, '2026-05-05 07:35:02'),
('41430f74-481a-11f1-befa-9ad025ab06b0', '40948eaa-481a-11f1-befa-9ad025ab06b0', 'STL & Templates', NULL, 'advanced', 3, 15, NULL, '2026-05-05 07:35:02'),
('414311fc-481a-11f1-befa-9ad025ab06b0', '40948f83-481a-11f1-befa-9ad025ab06b0', 'PHP Basics', NULL, 'beginner', 1, 18, NULL, '2026-05-05 07:35:02'),
('4143159d-481a-11f1-befa-9ad025ab06b0', '40948f83-481a-11f1-befa-9ad025ab06b0', 'PHP & Forms', NULL, 'beginner', 2, 12, NULL, '2026-05-05 07:35:02'),
('4143181e-481a-11f1-befa-9ad025ab06b0', '40948f83-481a-11f1-befa-9ad025ab06b0', 'PHP & MySQL', NULL, 'intermediate', 3, 16, NULL, '2026-05-05 07:35:02'),
('41431a39-481a-11f1-befa-9ad025ab06b0', '40948f83-481a-11f1-befa-9ad025ab06b0', 'Laravel Basics', NULL, 'advanced', 4, 18, NULL, '2026-05-05 07:35:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cnt_tracks`
--
ALTER TABLE `cnt_tracks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_ct_lang_order` (`language_id`,`order_index`),
  ADD KEY `idx_ct_language` (`language_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cnt_tracks`
--
ALTER TABLE `cnt_tracks`
  ADD CONSTRAINT `fk_ct_language` FOREIGN KEY (`language_id`) REFERENCES `cnt_languages` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
ploading cnt_tracks.sql…]()


6. **Run the server**
   
   Via Laragon: just start Laragon and visit `http://localhost/Edu_Streak_Lock_in/public`
   
   Via PHP built-in server:
   ```bash
   php -S localhost:3000 -t public
   ```
   Then visit `http://localhost:3000`

---

## 📁 Project Structure

```
Edu_Streak_Lock_in/
├── app/
│   ├── config/
│   │   └── app.php              # DB, Google OAuth, BASE_URL config (gitignored)
│   ├── controllers/
│   │   ├── AuthController.php
│   │   ├── CodeController.php
│   │   ├── LevelController.php
│   │   ├── LeaderboardController.php
│   │   ├── LessonController.php
│   │   ├── ProfileController.php
│   │   ├── QuestController.php
│   │   ├── ShopController.php
│   │   └── StudentController.php
│   ├── core/
│   │   ├── Database.php         # MySQLi wrapper
│   │   └── Router.php           # URL router
│   └── views/
│       ├── auth/                # Login page
│       ├── History/             # Code history page
│       ├── Leaderboard/         # Leaderboard page
│       ├── level/               # Level map page
│       ├── Profile/             # Profile page
│       ├── Quest/               # Quest page
│       └── Shop/                # Shop page
├── public/
│   ├── assets/                  # Images & icons
│   ├── css/                     # Compiled stylesheets
│   ├── js/                      # JavaScript files
│   └── index.php                # Entry point & router bootstrap
└── vendor/                      # Composer dependencies
```

---

## 🗄️ Database Tables

| Table | Description |
|-------|-------------|
| `usr_users` | User accounts |
| `usr_streaks` | Streak tracking per user |
| `cnt_languages` | Programming languages |
| `cnt_tracks` | Learning tracks per language |
| `cnt_lessons` | Individual lessons per track |
| `cnt_questions` | Questions inside lessons |
| `prg_lesson_progress` | User progress per lesson |
| `prg_user_tracks` | User progress per track |
| `shp_items` | Shop items |
| `shp_purchases` | Purchase history |
| `rwd_badges` | Badges |
| `chl_challenges` | Challenges |

---


## 👤 Author

Made by Wily Sepiro,Kevin,Daniel,Jovan.
🏆 Monthly leaderboard
🔥 Streak system
💰 Gem & heart system with shop
🎯 Daily & extra quests
👤 Google OAuth profile
📜 Code history page
