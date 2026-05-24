EduStreak 🎯

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
   [U-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 24, 2026 at 10:58 AM
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
