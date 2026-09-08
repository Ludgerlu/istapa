-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table istapa.academic_years
DROP TABLE IF EXISTS `academic_years`;
CREATE TABLE IF NOT EXISTS `academic_years` (
  `id` int NOT NULL AUTO_INCREMENT,
  `label` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `is_current` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_label` (`label`),
  KEY `idx_current` (`is_current`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table istapa.academic_years: ~2 rows (approximately)
DELETE FROM `academic_years`;
INSERT INTO `academic_years` (`id`, `label`, `start_date`, `end_date`, `is_current`, `created_at`) VALUES
	(1, '2024-2025', '2024-09-01', '2025-07-31', 0, '2026-04-22 00:06:33'),
	(2, '2025-2026', '2025-09-01', '2026-07-31', 1, '2026-04-22 00:06:33'),
	(3, '2026-2027', '2026-09-01', '2027-07-31', 1, '2026-08-28 11:49:12');

-- Dumping structure for table istapa.admission_documents
DROP TABLE IF EXISTS `admission_documents`;
CREATE TABLE IF NOT EXISTS `admission_documents` (
  `id` int NOT NULL AUTO_INCREMENT,
  `admission_request_id` int NOT NULL,
  `doc_type` enum('cni','diploma','transcript','photo','other') COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `original_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_req` (`admission_request_id`),
  CONSTRAINT `fk_ad_req` FOREIGN KEY (`admission_request_id`) REFERENCES `admission_requests` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table istapa.admission_documents: ~3 rows (approximately)
DELETE FROM `admission_documents`;
INSERT INTO `admission_documents` (`id`, `admission_request_id`, `doc_type`, `file_path`, `original_name`, `uploaded_at`) VALUES
	(1, 1, 'diploma', 'uploads/admissions/adm2026001_bac.pdf', 'baccalaureat_essama.pdf', '2026-04-22 00:06:34'),
	(2, 1, 'photo', 'uploads/admissions/adm2026001_photo.jpg', 'photo_identite.jpg', '2026-04-22 00:06:34'),
	(3, 1, 'transcript', 'uploads/admissions/adm2026001_releve.pdf', 'releve_notes.pdf', '2026-04-22 00:06:34');

-- Dumping structure for table istapa.admission_requests
DROP TABLE IF EXISTS `admission_requests`;
CREATE TABLE IF NOT EXISTS `admission_requests` (
  `id` int NOT NULL AUTO_INCREMENT,
  `reference_code` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birth_date` date DEFAULT NULL,
  `gender` enum('M','F','other') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `program_id` int DEFAULT NULL,
  `previous_school` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `previous_diploma` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `motivation` text COLLATE utf8mb4_unicode_ci,
  `status` enum('pending','reviewing','accepted','rejected','waiting_list') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `status_comment` text COLLATE utf8mb4_unicode_ci,
  `reviewed_by` bigint unsigned DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `converted_user_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_adm_ref` (`reference_code`),
  KEY `idx_status` (`status`),
  KEY `idx_email` (`email`),
  KEY `fk_adm_prog` (`program_id`),
  KEY `fk_adm_reviewer` (`reviewed_by`),
  KEY `fk_adm_user` (`converted_user_id`),
  CONSTRAINT `fk_adm_prog` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_adm_reviewer` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_adm_user` FOREIGN KEY (`converted_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table istapa.admission_requests: ~5 rows (approximately)
DELETE FROM `admission_requests`;
INSERT INTO `admission_requests` (`id`, `reference_code`, `first_name`, `last_name`, `email`, `phone`, `birth_date`, `gender`, `address`, `city`, `country`, `program_id`, `previous_school`, `previous_diploma`, `motivation`, `status`, `status_comment`, `reviewed_by`, `reviewed_at`, `converted_user_id`, `created_at`, `updated_at`) VALUES
	(1, 'ADM-2026-001', 'Jean', 'ESSAMA', 'essama@gmail.com', '699001122', '2005-03-15', 'M', 'Ekié', 'Yaoundé', 'Cameroun', 1, NULL, 'Baccalauréat', 'Passionné par l\'agriculture durable.', 'accepted', NULL, 24, '2026-04-22 00:06:33', NULL, '2026-04-22 00:06:33', '2026-04-22 00:06:33'),
	(2, 'ADM-2026-002', 'Marie', 'BIYONG', 'biyong@gmail.com', '677334455', '2006-07-20', 'F', 'Soa', 'Yaoundé', 'Cameroun', 2, NULL, 'Baccalauréat', 'Intérêt pour l\'agroalimentaire.', 'pending', NULL, NULL, NULL, NULL, '2026-04-22 00:06:33', '2026-04-22 00:06:33'),
	(3, 'ADM-2026-003', 'Patrick', 'ONDOUA', 'ondoua@gmail.com', '690556677', '2004-11-08', 'M', 'Biyem-Assi', 'Yaoundé', 'Cameroun', 3, NULL, 'Baccalauréat', 'Environnement et développement durable.', 'reviewing', NULL, 24, '2026-04-22 00:06:33', NULL, '2026-04-22 00:06:33', '2026-04-22 00:06:33'),
	(4, 'ISTAPA-KG7ZXQ8ZET', 'Ludger', 'Ngapouche', 'ngapoucheludger@gmail.com', '697272270', '2026-04-09', 'M', 'texaco aeroport 34', 'douala', 'Cameroun', 2, NULL, NULL, NULL, 'pending', NULL, NULL, NULL, NULL, '2026-04-25 10:53:01', '2026-04-25 10:53:01'),
	(5, 'ISTAPA-PXGN8VHLWE', 'Louis Winnock', 'Matsionat', 'louismatsionat79@gmail.com', '068022564', '2004-11-06', 'M', '93ruelascony Bacongo', 'Brazzaville', 'Congo', 2, 'Lycée pierre Savorgnan de Brazza', 'Bac D', 'Louis Winnock MATSIONAT\r\nBrazzaville, Congo\r\nTéléphone : +242 06 802 2564\r\nE-mail : louismatsionat79@gmail.com\r\nÀ Brazzaville, le 12 juillet 2026\r\nÀ l\'attention de Monsieur/Madame le Directeur des Admissions\r\nISTAPA – École de formation en agroalimentaire et en agriculture\r\nBrazzaville, République du Congo\r\nObjet : Candidature pour intégrer la formation en agroalimentaire et agriculture\r\nMonsieur/Madame le Directeur,\r\nC\'est avec une grande motivation que je vous adresse ma candidature pour intégrer l\'ISTAPA, institution de référence dans le secteur agricole et agroalimentaire au Congo.\r\nPassionné par la transformation des ressources locales, je suis convaincu que l\'avenir économique de notre pays repose sur la formation d\'une nouvelle génération de professionnels qualifiés. Rejoindre votre établissement est pour moi l\'opportunité idéale d\'acquérir les compétences techniques et scientifiques nécessaires pour concrétiser mes projets.\r\nDynamique, autonome et travailleur, je suis prêt à m\'investir pleinement dans vos programmes de formation. Je me tiens à votre entière disposition pour un entretien afin de vous exposer de vive voix mon projet professionnel.\r\nEn vous remerciant pour l’attention portée à mon dossier, je vous prie d\'agréer, Monsieur/Madame le Directeur, l\'expression de mes salutations respectueuses.', 'pending', NULL, NULL, NULL, NULL, '2026-07-12 17:39:14', '2026-07-12 17:39:14');

-- Dumping structure for table istapa.attendance_details
DROP TABLE IF EXISTS `attendance_details`;
CREATE TABLE IF NOT EXISTS `attendance_details` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `attendance_session_id` bigint NOT NULL,
  `student_id` bigint unsigned NOT NULL,
  `status` enum('present','absent','late','excused') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'present',
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_session_student` (`attendance_session_id`,`student_id`),
  KEY `idx_student` (`student_id`),
  KEY `idx_status` (`status`),
  CONSTRAINT `fk_attd_session` FOREIGN KEY (`attendance_session_id`) REFERENCES `attendance_sessions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_attd_student` FOREIGN KEY (`student_id`) REFERENCES `students` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table istapa.attendance_details: ~22 rows (approximately)
DELETE FROM `attendance_details`;
INSERT INTO `attendance_details` (`id`, `attendance_session_id`, `student_id`, `status`, `comment`) VALUES
	(1, 1, 5, 'present', NULL),
	(2, 1, 6, 'present', NULL),
	(3, 1, 7, 'present', NULL),
	(4, 1, 8, 'absent', NULL),
	(5, 1, 9, 'present', NULL),
	(6, 1, 10, 'present', NULL),
	(7, 2, 5, 'present', NULL),
	(8, 2, 6, 'absent', NULL),
	(9, 2, 7, 'present', NULL),
	(10, 2, 8, 'absent', NULL),
	(11, 2, 9, 'present', NULL),
	(12, 2, 10, 'present', NULL),
	(13, 3, 25, 'present', NULL),
	(14, 3, 26, 'present', NULL),
	(15, 3, 27, 'present', NULL),
	(16, 3, 28, 'absent', NULL),
	(17, 3, 29, 'present', NULL),
	(18, 4, 25, 'present', NULL),
	(19, 4, 26, 'late', NULL),
	(20, 4, 27, 'present', NULL),
	(21, 4, 28, 'present', NULL),
	(22, 4, 29, 'absent', NULL);

-- Dumping structure for table istapa.attendance_sessions
DROP TABLE IF EXISTS `attendance_sessions`;
CREATE TABLE IF NOT EXISTS `attendance_sessions` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `class_id` int NOT NULL,
  `subject_id` int DEFAULT NULL,
  `session_date` date NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `taken_by` bigint unsigned NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_session` (`class_id`,`subject_id`,`session_date`,`start_time`),
  KEY `idx_class_date` (`class_id`,`session_date`),
  KEY `idx_subject` (`subject_id`),
  KEY `fk_att_by` (`taken_by`),
  CONSTRAINT `fk_att_by` FOREIGN KEY (`taken_by`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_att_class` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_att_subject` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table istapa.attendance_sessions: ~4 rows (approximately)
DELETE FROM `attendance_sessions`;
INSERT INTO `attendance_sessions` (`id`, `class_id`, `subject_id`, `session_date`, `start_time`, `end_time`, `taken_by`, `notes`, `created_at`) VALUES
	(1, 2, 1, '2025-11-03', '08:00:00', '10:00:00', 18, NULL, '2026-04-22 00:06:33'),
	(2, 2, 2, '2025-11-04', '10:00:00', '12:00:00', 19, NULL, '2026-04-22 00:06:33'),
	(3, 1, 11, '2025-11-03', '08:00:00', '10:00:00', 17, NULL, '2026-04-22 00:06:33'),
	(4, 1, 12, '2025-11-04', '10:00:00', '12:00:00', 18, NULL, '2026-04-22 00:06:33');

-- Dumping structure for table istapa.blog_categories
DROP TABLE IF EXISTS `blog_categories`;
CREATE TABLE IF NOT EXISTS `blog_categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_blog_cat_slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table istapa.blog_categories: ~3 rows (approximately)
DELETE FROM `blog_categories`;
INSERT INTO `blog_categories` (`id`, `slug`, `sort_order`) VALUES
	(1, 'actualites', 1),
	(2, 'agriculture', 2),
	(3, 'formation', 3);

-- Dumping structure for table istapa.blog_category_translations
DROP TABLE IF EXISTS `blog_category_translations`;
CREATE TABLE IF NOT EXISTS `blog_category_translations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `blog_category_id` int NOT NULL,
  `language_code` char(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_bct` (`blog_category_id`,`language_code`),
  KEY `fk_bct_lang` (`language_code`),
  CONSTRAINT `fk_bct_cat` FOREIGN KEY (`blog_category_id`) REFERENCES `blog_categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_bct_lang` FOREIGN KEY (`language_code`) REFERENCES `languages` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table istapa.blog_category_translations: ~6 rows (approximately)
DELETE FROM `blog_category_translations`;
INSERT INTO `blog_category_translations` (`id`, `blog_category_id`, `language_code`, `name`) VALUES
	(1, 1, 'fr', 'Actualités'),
	(2, 1, 'en', 'News'),
	(3, 2, 'fr', 'Agriculture'),
	(4, 2, 'en', 'Agriculture'),
	(5, 3, 'fr', 'Formation'),
	(6, 3, 'en', 'Training');

-- Dumping structure for table istapa.blog_comments
DROP TABLE IF EXISTS `blog_comments`;
CREATE TABLE IF NOT EXISTS `blog_comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `blog_post_id` int NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `parent_id` int DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_post` (`blog_post_id`),
  KEY `idx_user` (`user_id`),
  KEY `idx_parent` (`parent_id`),
  KEY `idx_app` (`is_approved`),
  CONSTRAINT `fk_bc_parent` FOREIGN KEY (`parent_id`) REFERENCES `blog_comments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_bc_post` FOREIGN KEY (`blog_post_id`) REFERENCES `blog_posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_bc_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table istapa.blog_comments: ~37 rows (approximately)
DELETE FROM `blog_comments`;
INSERT INTO `blog_comments` (`id`, `blog_post_id`, `user_id`, `parent_id`, `content`, `is_approved`, `created_at`) VALUES
	(1, 1, 25, NULL, 'Très heureux de rejoindre l\'ISTAPA cette année !', 1, '2026-04-22 00:06:34'),
	(2, 1, 26, NULL, 'Bonne rentrée à tous !', 1, '2026-04-22 00:06:34'),
	(3, 2, 5, NULL, 'Excellent article sur l\'agriculture durable.', 1, '2026-04-22 00:06:34'),
	(4, 1, 1, NULL, 'je suis vraiment satifait', 0, '2026-04-27 14:50:21'),
	(5, 1, 7, NULL, 'Superbe ambiance pour cette rentrée, hâte de commencer les cours pratiques !', 1, '2026-07-11 13:12:00'),
	(6, 1, 9, NULL, 'Merci à toute l\'équipe pour l\'accueil chaleureux réservé aux nouveaux étudiants.', 1, '2026-07-11 18:30:00'),
	(7, 1, 18, NULL, 'La visite des fermes de démonstration était vraiment instructive.', 1, '2026-07-12 12:45:00'),
	(8, 1, 23, NULL, 'On sent que l\'institut grandit d\'année en année, félicitations.', 1, '2026-07-12 20:20:00'),
	(9, 1, 31, NULL, 'Est-ce que le calendrier complet de l\'année sera bientôt disponible en ligne ?', 1, '2026-07-13 14:05:00'),
	(10, 1, 5, NULL, 'Content de retrouver mes camarades de classe pour cette nouvelle année.', 1, '2026-07-13 23:40:00'),
	(11, 2, 3, NULL, 'Article très utile, le compostage est justement ce que j\'essaie de mettre en place chez moi.', 1, '2026-07-11 15:00:00'),
	(12, 2, 8, NULL, 'La rotation des cultures a changé beaucoup de choses sur notre parcelle familiale.', 1, '2026-07-12 00:15:00'),
	(13, 2, 19, NULL, 'Merci pour ces explications claires sur la lutte intégrée contre les ravageurs.', 1, '2026-07-12 13:30:00'),
	(14, 2, 24, NULL, 'Vous prévoyez une formation ouverte au public sur ces techniques ?', 1, '2026-07-13 17:10:00'),
	(15, 2, 33, NULL, 'Excellent résumé des pratiques durables enseignées à l\'ISTAPA.', 1, '2026-07-14 11:50:00'),
	(16, 3, 2, NULL, 'Journée très bien organisée, j\'ai pu poser toutes mes questions aux enseignants.', 1, '2026-07-11 19:00:00'),
	(17, 3, 6, NULL, 'Les démonstrations en laboratoire m\'ont convaincu de m\'inscrire en agroalimentaire.', 1, '2026-07-12 14:25:00'),
	(18, 3, 20, NULL, 'Merci pour l\'accueil, le campus est vraiment agréable.', 1, '2026-07-12 21:45:00'),
	(19, 3, 26, NULL, 'Est-il possible d\'organiser une session similaire pour les parents seuls ?', 1, '2026-07-13 13:15:00'),
	(20, 3, 34, NULL, 'J\'ai beaucoup aimé la visite des logements étudiants.', 1, '2026-07-14 01:00:00'),
	(21, 3, 4, NULL, 'Vivement la prochaine édition, tout était bien préparé.', 1, '2026-07-14 16:30:00'),
	(22, 4, 10, NULL, 'Le goutte-à-goutte a vraiment fait ses preuves sur mon petit champ de tomates.', 1, '2026-07-11 12:20:00'),
	(23, 4, 17, NULL, 'Très bon article, la collecte des eaux de pluie m\'intéresse particulièrement.', 1, '2026-07-12 18:00:00'),
	(24, 4, 27, NULL, 'Combien coûte l\'installation d\'un système de goutte-à-goutte pour un petit exploitant ?', 1, '2026-07-13 14:40:00'),
	(25, 4, 35, NULL, 'Vos étudiants font un travail remarquable sur la ferme de démonstration.', 1, '2026-07-14 20:55:00'),
	(26, 4, 21, NULL, 'Article clair et bien illustré, merci à l\'équipe rédactionnelle.', 1, '2026-07-15 13:10:00'),
	(27, 5, 28, NULL, 'Excellente initiative, cela va beaucoup aider les étudiants à se professionnaliser.', 1, '2026-07-11 16:15:00'),
	(28, 5, 36, NULL, 'Quels sont les critères exacts pour être sélectionné pour un stage ?', 1, '2026-07-12 12:30:00'),
	(29, 5, 5, NULL, 'J\'ai hâte de postuler pour un stage dans une unité de transformation.', 1, '2026-07-12 23:05:00'),
	(30, 5, 18, NULL, 'Le réseau de partenaires de l\'ISTAPA s\'élargit vraiment bien.', 1, '2026-07-13 15:20:00'),
	(31, 5, 29, NULL, '8 semaines c\'est un bon format pour découvrir le monde professionnel.', 1, '2026-07-14 19:35:00'),
	(32, 5, 37, NULL, 'Bravo à l\'équipe pédagogique pour cette belle opportunité offerte aux étudiants.', 1, '2026-07-15 13:50:00'),
	(33, 6, 7, NULL, 'Félicitations à toute la promotion 2025, un très beau résultat !', 1, '2026-07-11 14:00:00'),
	(34, 6, 24, NULL, '94% de réussite, c\'est vraiment impressionnant pour l\'institut.', 1, '2026-07-12 17:25:00'),
	(35, 6, 32, NULL, 'Bravo aux diplômés qui ont déjà trouvé un emploi grâce à leurs stages.', 1, '2026-07-13 21:10:00'),
	(36, 6, 38, NULL, 'Cela donne confiance pour la suite de mes études à l\'ISTAPA.', 1, '2026-07-14 13:45:00'),
	(37, 6, 9, NULL, 'Excellent taux de réussite, félicitations à tous les enseignants impliqués.', 1, '2026-07-15 18:20:00');

-- Dumping structure for table istapa.blog_posts
DROP TABLE IF EXISTS `blog_posts`;
CREATE TABLE IF NOT EXISTS `blog_posts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `blog_category_id` int DEFAULT NULL,
  `author_id` bigint unsigned NOT NULL,
  `slug` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_en` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_fr` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt_en` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt_fr` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_en` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_fr` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_description_en` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_description_fr` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cover_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('draft','published','archived') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `view_count` int unsigned NOT NULL DEFAULT '0',
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_blog_slug` (`slug`),
  KEY `idx_status_pub` (`status`,`published_at`),
  KEY `idx_author` (`author_id`),
  KEY `idx_category` (`blog_category_id`),
  CONSTRAINT `fk_bp_author` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_bp_cat` FOREIGN KEY (`blog_category_id`) REFERENCES `blog_categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table istapa.blog_posts: ~7 rows (approximately)
DELETE FROM `blog_posts`;
INSERT INTO `blog_posts` (`id`, `blog_category_id`, `author_id`, `slug`, `title_en`, `title_fr`, `excerpt_en`, `excerpt_fr`, `content_en`, `content_fr`, `meta_description_en`, `meta_description_fr`, `cover_image`, `status`, `view_count`, `published_at`, `created_at`, `updated_at`) VALUES
	(1, 1, 23, 'rentree-2025-2026', 'Academic Year 2025-2026 Starts', 'Rentrée académique 2025-2026', 'ISTAPA opens its doors for the new academic year.', 'ISTAPA ouvre ses portes pour la nouvelle année académique.', '<h2>Overview</h2><p>ISTAPA officially opened its doors for the 2025-2026 academic year, welcoming new and returning students across all three HND programs. The orientation week combined administrative registration with campus tours, introductions to teaching staff, and a briefing on academic expectations.</p><h3>Highlights of the Week</h3><ul><li><strong>Welcome ceremony:</strong> attended by the institute director, department heads, and partner organizations.</li><li><strong>Campus tour:</strong> new students visited laboratories, demonstration farms, and student facilities.</li><li><strong>Academic briefing:</strong> presentation of the year\'s calendar, evaluation methods, and internship requirements.</li></ul><h3>Looking Ahead</h3><p>The 2025-2026 cohort is one of the largest in ISTAPA\'s history, reflecting growing interest in technical agricultural training in Cameroon. Classes officially began the following week across all three specializations.</p>', '<h2>Présentation</h2><p>L\'ISTAPA a officiellement ouvert ses portes pour l\'année académique 2025-2026, accueillant les nouveaux étudiants ainsi que les anciens dans les trois filières BTS. La semaine de rentrée a combiné les inscriptions administratives avec des visites du campus, la présentation du corps enseignant et un briefing sur les attentes académiques.</p><h3>Temps forts de la semaine</h3><ul><li><strong>Cérémonie d\'accueil :</strong> en présence du directeur de l\'institut, des chefs de département et des partenaires.</li><li><strong>Visite du campus :</strong> les nouveaux étudiants ont visité les laboratoires, les fermes de démonstration et les infrastructures étudiantes.</li><li><strong>Briefing académique :</strong> présentation du calendrier de l\'année, des modalités d\'évaluation et des exigences de stage.</li></ul><h3>Perspectives</h3><p>La promotion 2025-2026 est l\'une des plus importantes de l\'histoire de l\'ISTAPA, reflétant l\'intérêt croissant pour la formation technique agricole au Cameroun. Les cours ont officiellement débuté la semaine suivante dans les trois filières.</p>', 'ISTAPA academic year 2025-2026 has begun.', 'La rentrée académique 2025-2026 à l\'ISTAPA a débuté.', NULL, 'published', 243, '2025-09-05 08:00:00', '2026-04-22 00:06:33', '2026-08-28 14:05:07'),
	(2, 2, 23, 'techniques-agriculture-durable', 'Sustainable Agriculture Techniques', 'Techniques d\'agriculture durable', 'Key practices for sustainable farming.', 'Pratiques clés pour une agriculture durable.', '<h2>Why Sustainable Agriculture Matters</h2><p>As soil degradation and climate variability increasingly threaten yields across Cameroon, ISTAPA students are trained in techniques that balance productivity with long-term land health.</p><h3>Key Practices Covered</h3><ul><li><strong>Crop rotation and intercropping</strong> to maintain soil fertility naturally.</li><li><strong>Composting and organic matter management</strong> to reduce dependency on chemical fertilizers.</li><li><strong>Water-efficient irrigation</strong> adapted to local rainfall patterns.</li><li><strong>Integrated pest management</strong> to limit pesticide use while protecting yields.</li></ul><h3>Field Application</h3><p>Students apply these techniques directly on ISTAPA\'s demonstration plots, comparing conventional and sustainable plots over a full growing cycle to measure real differences in soil quality and yield.</p>', '<h2>Pourquoi l\'agriculture durable est essentielle</h2><p>Face à la dégradation des sols et à la variabilité climatique qui menacent de plus en plus les rendements au Cameroun, les étudiants de l\'ISTAPA sont formés à des techniques qui concilient productivité et santé durable des terres.</p><h3>Pratiques clés enseignées</h3><ul><li><strong>Rotation des cultures et association de cultures</strong> pour maintenir la fertilité du sol naturellement.</li><li><strong>Compostage et gestion de la matière organique</strong> pour réduire la dépendance aux engrais chimiques.</li><li><strong>Irrigation économe en eau</strong> adaptée aux régimes pluviométriques locaux.</li><li><strong>Lutte intégrée contre les ravageurs</strong> pour limiter l\'usage de pesticides tout en protégeant les rendements.</li></ul><h3>Application sur le terrain</h3><p>Les étudiants appliquent ces techniques directement sur les parcelles de démonstration de l\'ISTAPA, en comparant des parcelles conventionnelles et durables sur un cycle de culture complet pour mesurer les différences réelles de qualité du sol et de rendement.</p>', 'Sustainable agriculture techniques for African farmers.', 'Techniques d\'agriculture durable pour les agriculteurs africains.', NULL, 'published', 154, '2025-10-15 09:00:00', '2026-04-22 00:06:33', '2026-08-28 05:02:08'),
	(3, 2, 1, 'dfsdfsdf-6a012933f294f', 'Open House Day 2026', 'Journée Portes Ouvertes 2026', 'ISTAPA opens its campus to prospective students and families for a full day of demonstrations and Q&', 'dqsdqsdd', '<h2>An Open Invitation</h2><p>ISTAPA held its annual Open House Day, welcoming prospective students, parents, and partner organizations to discover the institute\'s programs, facilities, and campus life firsthand.</p><h3>Program of the Day</h3><ul><li><strong>Live demonstrations</strong> in the agriculture, agri-food, and environmental science laboratories.</li><li><strong>Q&A sessions</strong> with current students and teaching staff about coursework and internships.</li><li><strong>Campus tours</strong> of classrooms, farm plots, and student accommodation.</li></ul><h3>Turnout and Feedback</h3><p>Attendance exceeded expectations, with visitors from across the Centre and neighboring regions. Many prospective students expressed particular interest in the practical, hands-on approach that distinguishes ISTAPA\'s curriculum.</p>', '<h2>Une invitation ouverte à tous</h2><p>L\'ISTAPA a organisé sa Journée Portes Ouvertes annuelle, accueillant futurs étudiants, parents et partenaires pour découvrir concrètement les programmes, les infrastructures et la vie sur le campus.</p><h3>Programme de la journée</h3><ul><li><strong>Démonstrations en direct</strong> dans les laboratoires d\'agriculture, d\'agroalimentaire et d\'environnement.</li><li><strong>Sessions de questions-réponses</strong> avec les étudiants actuels et le corps enseignant sur les cursus et les stages.</li><li><strong>Visites du campus :</strong> salles de classe, parcelles agricoles et logements étudiants.</li></ul><h3>Affluence et retours</h3><p>La participation a dépassé les attentes, avec des visiteurs venus de la région du Centre et des régions voisines. De nombreux futurs étudiants ont exprimé un intérêt particulier pour l\'approche pratique qui caractérise le cursus de l\'ISTAPA.</p>', 'qsdqsd', 'dqsdqsd', 'blog_covers/JcBsJhxU0UvU8LpVBcbWiMTkzeyCtFGwjpxaxxj6.jpg', 'published', 195, '2026-02-04 00:54:00', '2026-05-10 23:56:20', '2026-08-28 14:05:11'),
	(4, 2, 23, 'irrigation-techniques-2026', 'Modern Irrigation Techniques for Smallholders', 'Techniques d\'irrigation modernes pour les petits exploitants', 'How drip and sprinkler systems can double yields on small farms.', 'Comment les systèmes de goutte-à-goutte peuvent doubler les rendements.', '<h2>The Water Challenge for Smallholders</h2><p>Irregular rainfall and limited access to reliable water sources remain among the biggest obstacles for small-scale farmers in Cameroon. ISTAPA\'s agriculture program now includes a dedicated module on modern irrigation techniques.</p><h3>Techniques Covered</h3><ul><li><strong>Drip irrigation:</strong> delivers water directly to plant roots, reducing waste by up to 60% compared to flood irrigation.</li><li><strong>Sprinkler systems:</strong> suited for larger open fields and uniform crop coverage.</li><li><strong>Rainwater harvesting:</strong> low-cost storage solutions to bridge dry spells.</li></ul><h3>Expected Impact</h3><p>Early trials on ISTAPA\'s demonstration farm showed noticeably higher and more consistent yields with drip irrigation compared to traditional watering methods, while using significantly less water overall.</p>', '<h2>Le défi de l\'eau pour les petits exploitants</h2><p>Les précipitations irrégulières et l\'accès limité à des sources d\'eau fiables restent parmi les plus grands obstacles pour les petits agriculteurs au Cameroun. Le programme agriculture de l\'ISTAPA intègre désormais un module dédié aux techniques d\'irrigation modernes.</p><h3>Techniques enseignées</h3><ul><li><strong>Goutte-à-goutte :</strong> apporte l\'eau directement aux racines, réduisant le gaspillage jusqu\'à 60 % par rapport à l\'irrigation par submersion.</li><li><strong>Systèmes d\'asperseurs :</strong> adaptés aux grands champs ouverts et à une couverture uniforme des cultures.</li><li><strong>Collecte des eaux de pluie :</strong> solutions de stockage à faible coût pour traverser les périodes sèches.</li></ul><h3>Impact attendu</h3><p>Les premiers essais sur la ferme de démonstration de l\'ISTAPA ont montré des rendements nettement plus élevés et plus réguliers avec le goutte-à-goutte, tout en consommant globalement beaucoup moins d\'eau.</p>', 'Modern irrigation techniques for small-scale farmers in Cameroon.', 'Techniques d\'irrigation modernes pour les petits agriculteurs au Cameroun.', NULL, 'published', 240, '2026-03-10 07:00:00', '2026-05-22 12:25:25', '2026-08-28 14:05:14'),
	(5, 3, 23, 'internship-program-2026', 'ISTAPA Launches New Internship Program 2026', 'ISTAPA lance son nouveau programme de stage 2026', 'Students will complete 8-week placements at partner farms and agri-businesses.', 'Les étudiants effectueront des stages de 8 semaines dans des exploitations partenaires.', '<h2>A New Pathway to Professional Experience</h2><p>ISTAPA has launched its 2026 internship program, giving students the opportunity to complete 8-week placements with partner farms, agribusinesses, and research institutions across Cameroon.</p><h3>How It Works</h3><ul><li><strong>Partner network:</strong> placements are arranged with established farms, food processing units, and environmental agencies.</li><li><strong>Selection criteria:</strong> based on academic performance, motivation letters, and program relevance.</li><li><strong>Learning objectives:</strong> hands-on application of classroom knowledge, professional networking, and exposure to real workplace challenges.</li></ul><h3>Why It Matters</h3><p>Internships remain one of the strongest predictors of post-graduation employment. ISTAPA\'s expanded partner network for 2026 significantly increases the number and diversity of available placements.</p>', '<h2>Une nouvelle voie vers l\'expérience professionnelle</h2><p>L\'ISTAPA a lancé son programme de stage 2026, offrant aux étudiants l\'opportunité d\'effectuer des stages de 8 semaines dans des exploitations partenaires, des entreprises agroalimentaires et des instituts de recherche partout au Cameroun.</p><h3>Fonctionnement</h3><ul><li><strong>Réseau de partenaires :</strong> les stages sont organisés avec des fermes établies, des unités de transformation alimentaire et des agences environnementales.</li><li><strong>Critères de sélection :</strong> basés sur les résultats académiques, les lettres de motivation et la pertinence par rapport au programme suivi.</li><li><strong>Objectifs pédagogiques :</strong> application pratique des connaissances théoriques, développement du réseau professionnel et confrontation à des défis réels en milieu de travail.</li></ul><h3>Pourquoi c\'est important</h3><p>Les stages restent l\'un des meilleurs indicateurs d\'insertion professionnelle après le diplôme. L\'élargissement du réseau de partenaires de l\'ISTAPA pour 2026 augmente considérablement le nombre et la diversité des stages disponibles.</p>', 'ISTAPA 2026 internship program for agriculture students.', 'Programme de stage 2026 de l\'ISTAPA pour les étudiants en agriculture.', NULL, 'published', 180, '2026-04-01 08:00:00', '2026-05-22 12:25:25', '2026-08-28 14:05:18'),
	(6, 1, 24, 'graduation-results-2025', 'Outstanding Results for the Class of 2025', 'Résultats remarquables pour la promotion 2025', '94% pass rate achieved by ISTAPA\'s graduating class.', 'Un taux de réussite de 94 % atteint par la promotion sortante de l\'ISTAPA.', '<h2>A Record-Breaking Cohort</h2><p>ISTAPA\'s graduating class of 2025 achieved a 94% pass rate across all three HND programs, one of the institute\'s strongest results to date.</p><h3>Results by Program</h3><ul><li><strong>Agriculture:</strong> strong performance across crop production and farm management modules.</li><li><strong>Agri-Food Processing:</strong> notable achievement in quality control and food safety assessments.</li><li><strong>Environmental Science:</strong> excellent results in environmental impact assessment coursework.</li></ul><h3>Recognition</h3><p>Several graduates were recognized for outstanding academic performance during the closing ceremony, and many have already secured employment or internship-to-hire positions with ISTAPA\'s partner organizations.</p>', '<h2>Une promotion exceptionnelle</h2><p>La promotion sortante 2025 de l\'ISTAPA a atteint un taux de réussite de 94 % dans les trois filières BTS, l\'un des meilleurs résultats de l\'histoire de l\'institut.</p><h3>Résultats par filière</h3><ul><li><strong>Agriculture :</strong> performances solides dans les modules de production végétale et de gestion d\'exploitation.</li><li><strong>Agroalimentaire :</strong> résultats notables aux évaluations de contrôle qualité et de sécurité alimentaire.</li><li><strong>Environnement :</strong> excellents résultats dans les travaux d\'évaluation d\'impact environnemental.</li></ul><h3>Distinctions</h3><p>Plusieurs diplômés ont été distingués pour leurs performances académiques exceptionnelles lors de la cérémonie de clôture, et beaucoup ont déjà obtenu un emploi ou un stage débouchant sur une embauche auprès des organisations partenaires de l\'ISTAPA.</p>', 'ISTAPA class of 2025 achieves 94% pass rate.', 'La promotion 2025 de l\'ISTAPA atteint un taux de réussite de 94 %.', NULL, 'published', 230, '2026-08-25 09:00:00', '2026-05-22 12:25:25', '2026-08-28 14:05:21'),
	(7, 1, 24, 'solar-powered-irrigation-borehole-wells-at-istapa-6a62230a786aa', 'Solar-Powered Irrigation & Borehole Wells at ISTAPA', 'Irrigation solaire et forage : l\'innovation ISTAPA', 'ISTAPA combines wells, solar panels, and irrigation for sustainable farming.', 'L\'ISTAPA associe puits, panneaux solaires et irrigation pour une agriculture durable.', 'Access to water remains one of the biggest challenges facing agriculture in Central Africa, especially during the dry season. At ISTAPA, students learn to design concrete, sustainable solutions to this reality by combining three key elements: borehole wells, solar energy, and smart irrigation.\r\n\r\nBorehole Wells: Securing the Water Resource\r\nA well or borehole provides access to a stable underground water source, independent of climate variability. This resource becomes the foundation of a reliable irrigation system, capable of supplying crops even during periods of drought.\r\n\r\nSolar Panels: Clean, Independent Energy\r\nRather than relying on the electrical grid or costly fuel-powered generators, ISTAPA trains its students to install solar-powered water pumps. This solution ensures a continuous water supply while reducing operating costs and the environmental footprint of farming operations.\r\n\r\nIrrigation: Making Every Drop Count\r\nCombined with drip irrigation techniques or greenhouse farming, this system enables responsible water use — essential in a context of climate change and increasingly scarce resources.\r\n\r\nTraining for the Future\r\nThese skills are part of ISTAPA\'s "Agriculture of the Future" program, preparing students to become true drivers of agricultural innovation in Central Africa.\r\n\r\n📍 To discover this system and many other innovations, join us at our next Open House Day!', 'L\'accès à l\'eau reste l\'un des plus grands défis de l\'agriculture en Afrique centrale, particulièrement pendant la saison sèche. À l\'ISTAPA, les étudiants apprennent à concevoir des solutions concrètes et durables face à cette réalité, en combinant trois éléments clés : le forage, l\'énergie solaire et l\'irrigation intelligente.\r\n\r\nLe forage : sécuriser la ressource en eau\r\nUn puits ou forage permet d\'accéder à une source d\'eau souterraine stable, indépendante des aléas climatiques. Cette ressource devient la base d\'un système d\'irrigation fiable, capable d\'alimenter les cultures même en période de sécheresse.\r\n\r\nLe panneau solaire : une énergie propre et autonome\r\nPlutôt que de dépendre du réseau électrique ou de groupes électrogènes coûteux en carburant, l\'ISTAPA forme ses étudiants à l\'installation de pompes alimentées par panneaux solaires. Cette solution garantit une alimentation en eau continue, tout en réduisant les coûts d\'exploitation et l\'empreinte environnementale des exploitations agricoles.\r\n\r\nL\'irrigation : optimiser chaque goutte d\'eau\r\nAssocié à des techniques d\'irrigation goutte-à-goutte ou de culture sous serre, ce système permet une utilisation raisonnée de l\'eau, essentielle dans un contexte de changement climatique et de raréfaction des ressources.\r\n\r\nUne formation tournée vers l\'avenir\r\nCes compétences font partie intégrante du programme "Agriculture du Futur" enseigné à l\'ISTAPA, préparant les étudiants à devenir de véritables acteurs de l\'innovation agricole en Afrique centrale.\r\n\r\n📍 Pour découvrir ce système et bien d\'autres innovations, rejoignez-nous lors de nos prochaines Journées Portes Ouvertes !', 'Discover how ISTAPA combines solar energy, and irrigation .', 'Découvrez comment l\'ISTAPA associe énergie solaire et irrigation .', 'blog_covers/jYpcqSgqYKlHhPyEfiIrO0MKR8YLodUZUeypnwg2.jpg', 'published', 115, '2026-07-23 14:00:00', '2026-07-23 18:19:54', '2026-08-28 09:51:57');

-- Dumping structure for table istapa.blog_post_translations
DROP TABLE IF EXISTS `blog_post_translations`;
CREATE TABLE IF NOT EXISTS `blog_post_translations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `blog_post_id` int NOT NULL,
  `language_code` char(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci,
  `content` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_description` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_bpt` (`blog_post_id`,`language_code`),
  KEY `fk_bpt_lang` (`language_code`),
  CONSTRAINT `fk_bpt_lang` FOREIGN KEY (`language_code`) REFERENCES `languages` (`code`),
  CONSTRAINT `fk_bpt_post` FOREIGN KEY (`blog_post_id`) REFERENCES `blog_posts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table istapa.blog_post_translations: ~10 rows (approximately)
DELETE FROM `blog_post_translations`;
INSERT INTO `blog_post_translations` (`id`, `blog_post_id`, `language_code`, `title`, `excerpt`, `content`, `meta_description`) VALUES
	(1, 1, 'fr', 'Rentrée académique 2025-2026', 'ISTAPA ouvre ses portes.', 'Contenu complet de l\'article en français.', 'Rentrée 2025-2026 à l\'ISTAPA.'),
	(2, 1, 'en', 'Academic Year 2025-2026 Starts', 'ISTAPA opens its doors.', 'Full article content in English.', 'ISTAPA 2025-2026 academic year.'),
	(3, 2, 'fr', 'Techniques d\'agriculture durable', 'Pratiques clés.', 'Contenu complet.', 'Agriculture durable ISTAPA.'),
	(4, 2, 'en', 'Sustainable Agriculture Techniques', 'Key practices.', 'Full content.', 'Sustainable agriculture ISTAPA.'),
	(5, 4, 'fr', 'Techniques d\'irrigation modernes pour les petits exploitants', 'Comment le goutte-à-goutte et les asperseurs peuvent doubler les rendements.', 'Contenu complet en français sur les techniques d\'irrigation modernes.', 'Techniques d\'irrigation modernes pour les petits agriculteurs au Cameroun.'),
	(6, 4, 'en', 'Modern Irrigation Techniques for Smallholders', 'How drip and sprinkler systems can double yields on small farms.', 'Full article on modern irrigation techniques for small-scale farmers.', 'Modern irrigation techniques for small-scale farmers in Cameroon.'),
	(7, 5, 'fr', 'ISTAPA lance son nouveau programme de stage 2026', 'Les étudiants effectueront des stages de 8 semaines dans des exploitations partenaires.', 'Contenu complet en français sur le programme de stage 2026.', 'Programme de stage 2026 de l\'ISTAPA pour les étudiants en agriculture.'),
	(8, 5, 'en', 'ISTAPA Launches New Internship Program 2026', 'Students will complete 8-week placements at partner farms.', 'Full article about ISTAPA\'s 2026 internship program.', 'ISTAPA 2026 internship program for agriculture students.'),
	(9, 6, 'fr', 'Résultats remarquables pour la promotion 2025', 'Un taux de réussite de 94 % atteint par la promotion sortante.', 'Contenu complet en français sur les résultats de la promotion 2025.', 'La promotion 2025 de l\'ISTAPA atteint un taux de réussite de 94 %.'),
	(10, 6, 'en', 'Outstanding Results for the Class of 2025', '94% pass rate achieved by ISTAPA\'s graduating class.', 'Full article on the exceptional results of the class of 2025.', 'ISTAPA class of 2025 achieves 94% pass rate.');

-- Dumping structure for table istapa.certificates
DROP TABLE IF EXISTS `certificates`;
CREATE TABLE IF NOT EXISTS `certificates` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_fr` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_certificates_code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table istapa.certificates: ~6 rows (approximately)
DELETE FROM `certificates`;
INSERT INTO `certificates` (`id`, `code`, `name_en`, `name_fr`, `created_at`, `updated_at`) VALUES
	(1, 'GCE_AL', 'GCE Advanced Level', 'GCE Advanced Level', '2026-08-13 10:23:57', '2026-08-13 10:23:57'),
	(2, 'TVEE_AL', 'TVEE Advanced Level', 'TVEE Advanced Level', '2026-08-13 10:23:57', '2026-08-13 10:23:57'),
	(3, 'DUT', 'DUT (University Diploma of Technology)', 'DUT (Diplôme Universitaire de Technologie)', '2026-08-13 10:23:57', '2026-08-13 10:23:57'),
	(4, 'DTS', 'DTS (Higher Technician Diploma)', 'DTS (Diplôme de Technicien Supérieur)', '2026-08-13 10:23:57', '2026-08-13 10:23:57'),
	(5, 'HND_BTS', 'HND / BTS', 'HND / BTS', '2026-08-13 10:23:57', '2026-08-13 10:23:57'),
	(6, 'BACHELOR', 'Bachelor\'s Degree', 'Licence', '2026-08-13 10:23:57', '2026-08-13 10:23:57');

-- Dumping structure for table istapa.classes
DROP TABLE IF EXISTS `classes`;
CREATE TABLE IF NOT EXISTS `classes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `program_id` int NOT NULL,
  `academic_year_id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `section` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `capacity` int DEFAULT NULL,
  `head_teacher_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_classes` (`program_id`,`academic_year_id`,`name`,`section`),
  KEY `idx_program` (`program_id`),
  KEY `idx_year` (`academic_year_id`),
  KEY `idx_head` (`head_teacher_id`),
  CONSTRAINT `fk_class_head` FOREIGN KEY (`head_teacher_id`) REFERENCES `teachers` (`user_id`) ON DELETE SET NULL,
  CONSTRAINT `fk_class_prog` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`),
  CONSTRAINT `fk_class_year` FOREIGN KEY (`academic_year_id`) REFERENCES `academic_years` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table istapa.classes: ~14 rows (approximately)
DELETE FROM `classes`;
INSERT INTO `classes` (`id`, `program_id`, `academic_year_id`, `name`, `section`, `capacity`, `head_teacher_id`, `created_at`) VALUES
	(1, 1, 2, 'HND1 Agriculture', 'A', 30, 18, '2026-04-22 00:06:33'),
	(2, 1, 2, 'HND2 Agriculture', 'A', 30, 19, '2026-04-22 00:06:33'),
	(3, 3, 2, 'HND1 Environnement', 'A', 25, 21, '2026-04-22 00:06:33'),
	(4, 2, 2, 'HND1 Agroalimentaire', 'A', 25, 20, '2026-04-22 00:06:33'),
	(5, 1, 1, 'HND1 Agriculture 2024', 'A', 30, 18, '2026-04-22 00:06:33'),
	(6, 1, 1, 'HND2 Agriculture 2024', 'A', 30, 19, '2026-04-22 00:06:33'),
	(15, 1, 3, 'BTS1 Production Animale', 'A', 30, 18, '2026-08-28 11:49:18'),
	(16, 1, 3, 'BTS2 Production Animale', 'A', 30, 18, '2026-08-28 11:49:18'),
	(17, 2, 3, 'BTS1 Production Végétale', 'A', 30, 18, '2026-08-28 11:49:18'),
	(18, 2, 3, 'BTS2 Production Végétale', 'A', 30, 18, '2026-08-28 11:49:18'),
	(19, 3, 3, 'BTS1 Gestion Environnementale', 'A', 30, 18, '2026-08-28 11:49:18'),
	(20, 3, 3, 'BTS2 Gestion Environnementale', 'A', 30, 18, '2026-08-28 11:49:18'),
	(21, 4, 3, 'BTS1 Énergies Renouvelables', 'A', 30, 18, '2026-08-28 11:49:18'),
	(22, 4, 3, 'BTS2 Énergies Renouvelables', 'A', 30, 18, '2026-08-28 11:49:18');

-- Dumping structure for table istapa.class_enrollments
DROP TABLE IF EXISTS `class_enrollments`;
CREATE TABLE IF NOT EXISTS `class_enrollments` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `student_id` bigint unsigned NOT NULL,
  `class_id` int NOT NULL,
  `enrolled_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('active','withdrawn','completed','excluded') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_enrollment` (`student_id`,`class_id`),
  KEY `idx_class` (`class_id`),
  CONSTRAINT `fk_enroll_class` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_enroll_student` FOREIGN KEY (`student_id`) REFERENCES `students` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table istapa.class_enrollments: ~72 rows (approximately)
DELETE FROM `class_enrollments`;
INSERT INTO `class_enrollments` (`id`, `student_id`, `class_id`, `enrolled_at`, `status`) VALUES
	(1, 5, 2, '2026-04-22 00:06:33', 'active'),
	(2, 6, 2, '2026-04-22 00:06:33', 'active'),
	(3, 7, 2, '2026-04-22 00:06:33', 'active'),
	(4, 8, 2, '2026-04-22 00:06:33', 'active'),
	(5, 9, 2, '2026-04-22 00:06:33', 'active'),
	(6, 10, 2, '2026-04-22 00:06:33', 'active'),
	(7, 25, 1, '2026-04-22 00:06:33', 'active'),
	(8, 26, 1, '2026-04-22 00:06:33', 'active'),
	(9, 27, 1, '2026-04-22 00:06:33', 'active'),
	(10, 28, 1, '2026-04-22 00:06:33', 'active'),
	(11, 29, 1, '2026-04-22 00:06:33', 'active'),
	(12, 31, 1, '2026-04-22 00:06:33', 'active'),
	(13, 37, 1, '2026-04-22 00:06:33', 'active'),
	(14, 38, 1, '2026-04-22 00:06:33', 'active'),
	(15, 36, 3, '2026-04-22 00:06:33', 'active'),
	(16, 2, 5, '2026-04-22 00:06:33', 'completed'),
	(17, 3, 5, '2026-04-22 00:06:33', 'completed'),
	(18, 4, 5, '2026-04-22 00:06:33', 'completed'),
	(19, 5, 5, '2026-04-22 00:06:33', 'completed'),
	(20, 6, 5, '2026-04-22 00:06:33', 'completed'),
	(21, 7, 5, '2026-04-22 00:06:33', 'completed'),
	(22, 8, 5, '2026-04-22 00:06:33', 'completed'),
	(23, 9, 5, '2026-04-22 00:06:33', 'completed'),
	(24, 10, 5, '2026-04-22 00:06:33', 'completed'),
	(25, 51, 15, '2026-08-28 11:49:18', 'active'),
	(26, 52, 15, '2026-08-28 11:49:18', 'active'),
	(27, 53, 15, '2026-08-28 11:49:18', 'active'),
	(28, 54, 15, '2026-08-28 11:49:18', 'active'),
	(29, 55, 15, '2026-08-28 11:49:18', 'active'),
	(30, 56, 15, '2026-08-28 11:49:18', 'active'),
	(31, 57, 16, '2026-08-28 11:49:18', 'active'),
	(32, 58, 16, '2026-08-28 11:49:18', 'active'),
	(33, 59, 16, '2026-08-28 11:49:18', 'active'),
	(34, 60, 16, '2026-08-28 11:49:18', 'active'),
	(35, 61, 16, '2026-08-28 11:49:18', 'active'),
	(36, 62, 16, '2026-08-28 11:49:18', 'active'),
	(37, 75, 17, '2026-08-28 11:49:18', 'active'),
	(38, 76, 17, '2026-08-28 11:49:18', 'active'),
	(39, 77, 17, '2026-08-28 11:49:18', 'active'),
	(40, 78, 17, '2026-08-28 11:49:18', 'active'),
	(41, 79, 17, '2026-08-28 11:49:18', 'active'),
	(42, 80, 17, '2026-08-28 11:49:18', 'active'),
	(43, 81, 18, '2026-08-28 11:49:18', 'active'),
	(44, 82, 18, '2026-08-28 11:49:18', 'active'),
	(45, 83, 18, '2026-08-28 11:49:18', 'active'),
	(46, 84, 18, '2026-08-28 11:49:18', 'active'),
	(47, 85, 18, '2026-08-28 11:49:18', 'active'),
	(48, 86, 18, '2026-08-28 11:49:18', 'active'),
	(49, 99, 19, '2026-08-28 11:49:18', 'active'),
	(50, 100, 19, '2026-08-28 11:49:18', 'active'),
	(51, 101, 19, '2026-08-28 11:49:18', 'active'),
	(52, 102, 19, '2026-08-28 11:49:18', 'active'),
	(53, 103, 19, '2026-08-28 11:49:18', 'active'),
	(54, 104, 19, '2026-08-28 11:49:18', 'active'),
	(55, 105, 20, '2026-08-28 11:49:18', 'active'),
	(56, 106, 20, '2026-08-28 11:49:18', 'active'),
	(57, 107, 20, '2026-08-28 11:49:18', 'active'),
	(58, 108, 20, '2026-08-28 11:49:18', 'active'),
	(59, 109, 20, '2026-08-28 11:49:18', 'active'),
	(60, 110, 20, '2026-08-28 11:49:18', 'active'),
	(61, 123, 21, '2026-08-28 11:49:18', 'active'),
	(62, 124, 21, '2026-08-28 11:49:18', 'active'),
	(63, 125, 21, '2026-08-28 11:49:18', 'active'),
	(64, 126, 21, '2026-08-28 11:49:18', 'active'),
	(65, 127, 21, '2026-08-28 11:49:18', 'active'),
	(66, 128, 21, '2026-08-28 11:49:18', 'active'),
	(67, 129, 22, '2026-08-28 11:49:18', 'active'),
	(68, 130, 22, '2026-08-28 11:49:18', 'active'),
	(69, 131, 22, '2026-08-28 11:49:18', 'active'),
	(70, 132, 22, '2026-08-28 11:49:18', 'active'),
	(71, 133, 22, '2026-08-28 11:49:18', 'active'),
	(72, 134, 22, '2026-08-28 11:49:18', 'active');

-- Dumping structure for table istapa.class_subjects
DROP TABLE IF EXISTS `class_subjects`;
CREATE TABLE IF NOT EXISTS `class_subjects` (
  `id` int NOT NULL AUTO_INCREMENT,
  `class_id` int NOT NULL,
  `subject_id` int NOT NULL,
  `teacher_id` bigint unsigned DEFAULT NULL,
  `coefficient` decimal(4,2) NOT NULL DEFAULT '1.00',
  `hours_per_week` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_class_subject` (`class_id`,`subject_id`),
  KEY `idx_cs_subject` (`subject_id`),
  KEY `idx_cs_teacher` (`teacher_id`),
  CONSTRAINT `fk_cs_class` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_cs_subject` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_cs_teacher` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`user_id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=159 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table istapa.class_subjects: ~130 rows (approximately)
DELETE FROM `class_subjects`;
INSERT INTO `class_subjects` (`id`, `class_id`, `subject_id`, `teacher_id`, `coefficient`, `hours_per_week`, `created_at`) VALUES
	(1, 2, 1, 18, 2.00, 4, '2026-05-22 12:25:25'),
	(2, 2, 2, 19, 2.00, 3, '2026-05-22 12:25:25'),
	(3, 2, 3, 21, 1.50, 2, '2026-05-22 12:25:25'),
	(4, 2, 4, 18, 2.00, 3, '2026-05-22 12:25:25'),
	(5, 2, 5, 19, 1.50, 2, '2026-05-22 12:25:25'),
	(6, 2, 6, 20, 1.00, 2, '2026-05-22 12:25:25'),
	(7, 2, 7, 17, 2.00, 4, '2026-05-22 12:25:25'),
	(8, 2, 8, 21, 2.00, 3, '2026-05-22 12:25:25'),
	(9, 2, 9, 18, 1.50, 2, '2026-05-22 12:25:25'),
	(10, 2, 10, 19, 1.50, 2, '2026-05-22 12:25:25'),
	(11, 1, 11, 17, 2.00, 4, '2026-05-22 12:25:25'),
	(12, 1, 12, 18, 2.00, 3, '2026-05-22 12:25:25'),
	(13, 1, 13, 21, 1.50, 2, '2026-05-22 12:25:25'),
	(14, 1, 14, 19, 2.00, 3, '2026-05-22 12:25:25'),
	(15, 1, 15, 20, 1.00, 2, '2026-05-22 12:25:25'),
	(16, 3, 16, 21, 2.00, 4, '2026-05-22 12:25:25'),
	(17, 3, 17, 18, 2.00, 3, '2026-05-22 12:25:25'),
	(18, 3, 18, 19, 1.50, 2, '2026-05-22 12:25:25'),
	(32, 15, 19, 20, 4.00, 4, '2026-08-28 11:49:18'),
	(33, 15, 20, 21, 5.00, 5, '2026-08-28 11:49:18'),
	(34, 15, 21, 17, 4.00, 4, '2026-08-28 11:49:18'),
	(35, 15, 22, 18, 4.00, 4, '2026-08-28 11:49:18'),
	(36, 15, 23, 19, 5.00, 5, '2026-08-28 11:49:18'),
	(37, 15, 24, 20, 5.00, 5, '2026-08-28 11:49:18'),
	(38, 15, 25, 21, 3.00, 3, '2026-08-28 11:49:18'),
	(39, 15, 26, 17, 5.00, 5, '2026-08-28 11:49:18'),
	(40, 15, 27, 18, 4.00, 4, '2026-08-28 11:49:18'),
	(41, 15, 28, 19, 4.00, 4, '2026-08-28 11:49:18'),
	(42, 15, 29, 20, 5.00, 5, '2026-08-28 11:49:18'),
	(43, 15, 30, 21, 5.00, 5, '2026-08-28 11:49:18'),
	(44, 15, 31, 17, 4.00, 4, '2026-08-28 11:49:18'),
	(45, 15, 32, 18, 3.00, 3, '2026-08-28 11:49:18'),
	(46, 16, 33, 19, 6.00, 6, '2026-08-28 11:49:18'),
	(47, 16, 34, 20, 3.00, 3, '2026-08-28 11:49:18'),
	(48, 16, 35, 21, 5.00, 5, '2026-08-28 11:49:18'),
	(49, 16, 36, 17, 5.00, 5, '2026-08-28 11:49:18'),
	(50, 16, 37, 18, 5.00, 5, '2026-08-28 11:49:18'),
	(51, 16, 38, 19, 3.00, 3, '2026-08-28 11:49:18'),
	(52, 16, 39, 20, 3.00, 3, '2026-08-28 11:49:18'),
	(53, 16, 40, 21, 4.00, 4, '2026-08-28 11:49:18'),
	(54, 16, 41, 17, 5.00, 5, '2026-08-28 11:49:18'),
	(55, 16, 42, 18, 4.00, 4, '2026-08-28 11:49:18'),
	(56, 16, 43, 19, 2.00, 2, '2026-08-28 11:49:18'),
	(57, 16, 44, 20, 4.00, 4, '2026-08-28 11:49:18'),
	(58, 16, 45, 21, 6.00, 6, '2026-08-28 11:49:18'),
	(59, 16, 46, 17, 3.00, 3, '2026-08-28 11:49:18'),
	(60, 17, 47, 18, 4.00, 4, '2026-08-28 11:49:18'),
	(61, 17, 48, 19, 5.00, 5, '2026-08-28 11:49:18'),
	(62, 17, 49, 20, 4.00, 4, '2026-08-28 11:49:18'),
	(63, 17, 50, 21, 5.00, 5, '2026-08-28 11:49:18'),
	(64, 17, 51, 17, 4.00, 4, '2026-08-28 11:49:18'),
	(65, 17, 52, 18, 5.00, 5, '2026-08-28 11:49:18'),
	(66, 17, 53, 19, 3.00, 3, '2026-08-28 11:49:18'),
	(67, 17, 54, 20, 5.00, 5, '2026-08-28 11:49:18'),
	(68, 17, 55, 21, 4.00, 4, '2026-08-28 11:49:18'),
	(69, 17, 56, 17, 4.00, 4, '2026-08-28 11:49:18'),
	(70, 17, 57, 18, 5.00, 5, '2026-08-28 11:49:18'),
	(71, 17, 58, 19, 6.00, 6, '2026-08-28 11:49:18'),
	(72, 17, 59, 20, 3.00, 3, '2026-08-28 11:49:18'),
	(73, 17, 60, 21, 3.00, 3, '2026-08-28 11:49:18'),
	(74, 18, 61, 17, 6.00, 6, '2026-08-28 11:49:18'),
	(75, 18, 62, 18, 3.00, 3, '2026-08-28 11:49:18'),
	(76, 18, 63, 19, 6.00, 6, '2026-08-28 11:49:18'),
	(77, 18, 64, 20, 5.00, 5, '2026-08-28 11:49:18'),
	(78, 18, 65, 21, 4.00, 4, '2026-08-28 11:49:18'),
	(79, 18, 66, 17, 3.00, 3, '2026-08-28 11:49:18'),
	(80, 18, 67, 18, 3.00, 3, '2026-08-28 11:49:18'),
	(81, 18, 68, 19, 4.00, 4, '2026-08-28 11:49:18'),
	(82, 18, 69, 20, 5.00, 5, '2026-08-28 11:49:18'),
	(83, 18, 70, 21, 4.00, 4, '2026-08-28 11:49:18'),
	(84, 18, 71, 17, 4.00, 4, '2026-08-28 11:49:18'),
	(85, 18, 72, 18, 4.00, 4, '2026-08-28 11:49:18'),
	(86, 18, 73, 19, 6.00, 6, '2026-08-28 11:49:18'),
	(87, 18, 74, 20, 3.00, 3, '2026-08-28 11:49:18'),
	(88, 19, 75, 21, 4.00, 4, '2026-08-28 11:49:18'),
	(89, 19, 76, 17, 5.00, 5, '2026-08-28 11:49:18'),
	(90, 19, 77, 18, 5.00, 5, '2026-08-28 11:49:18'),
	(91, 19, 78, 19, 4.00, 4, '2026-08-28 11:49:18'),
	(92, 19, 79, 20, 4.00, 4, '2026-08-28 11:49:18'),
	(93, 19, 80, 21, 5.00, 5, '2026-08-28 11:49:18'),
	(94, 19, 81, 17, 3.00, 3, '2026-08-28 11:49:18'),
	(95, 19, 82, 18, 4.00, 4, '2026-08-28 11:49:18'),
	(96, 19, 83, 19, 5.00, 5, '2026-08-28 11:49:18'),
	(97, 19, 84, 20, 4.00, 4, '2026-08-28 11:49:18'),
	(98, 19, 85, 21, 4.00, 4, '2026-08-28 11:49:18'),
	(99, 19, 86, 17, 4.00, 4, '2026-08-28 11:49:18'),
	(100, 19, 87, 18, 6.00, 6, '2026-08-28 11:49:18'),
	(101, 19, 88, 19, 3.00, 3, '2026-08-28 11:49:18'),
	(102, 20, 89, 20, 4.00, 4, '2026-08-28 11:49:18'),
	(103, 20, 90, 21, 5.00, 5, '2026-08-28 11:49:18'),
	(104, 20, 91, 17, 5.00, 5, '2026-08-28 11:49:18'),
	(105, 20, 92, 18, 5.00, 5, '2026-08-28 11:49:18'),
	(106, 20, 93, 19, 5.00, 5, '2026-08-28 11:49:18'),
	(107, 20, 94, 20, 3.00, 3, '2026-08-28 11:49:18'),
	(108, 20, 95, 21, 3.00, 3, '2026-08-28 11:49:18'),
	(109, 20, 96, 17, 4.00, 4, '2026-08-28 11:49:18'),
	(110, 20, 97, 18, 5.00, 5, '2026-08-28 11:49:18'),
	(111, 20, 98, 19, 4.00, 4, '2026-08-28 11:49:18'),
	(112, 20, 99, 20, 3.00, 3, '2026-08-28 11:49:18'),
	(113, 20, 100, 21, 5.00, 5, '2026-08-28 11:49:18'),
	(114, 20, 101, 17, 6.00, 6, '2026-08-28 11:49:18'),
	(115, 20, 102, 18, 3.00, 3, '2026-08-28 11:49:18'),
	(116, 21, 103, 19, 4.00, 4, '2026-08-28 11:49:18'),
	(117, 21, 104, 20, 5.00, 5, '2026-08-28 11:49:18'),
	(118, 21, 105, 21, 5.00, 5, '2026-08-28 11:49:18'),
	(119, 21, 106, 17, 4.00, 4, '2026-08-28 11:49:18'),
	(120, 21, 107, 18, 5.00, 5, '2026-08-28 11:49:18'),
	(121, 21, 108, 19, 4.00, 4, '2026-08-28 11:49:18'),
	(122, 21, 109, 20, 3.00, 3, '2026-08-28 11:49:18'),
	(123, 21, 110, 21, 4.00, 4, '2026-08-28 11:49:18'),
	(124, 21, 111, 17, 5.00, 5, '2026-08-28 11:49:18'),
	(125, 21, 112, 18, 5.00, 5, '2026-08-28 11:49:18'),
	(126, 21, 113, 19, 5.00, 5, '2026-08-28 11:49:18'),
	(127, 21, 114, 20, 4.00, 4, '2026-08-28 11:49:18'),
	(128, 21, 115, 21, 4.00, 4, '2026-08-28 11:49:18'),
	(129, 21, 116, 17, 3.00, 3, '2026-08-28 11:49:18'),
	(130, 22, 117, 18, 4.00, 4, '2026-08-28 11:49:18'),
	(131, 22, 118, 19, 5.00, 5, '2026-08-28 11:49:18'),
	(132, 22, 119, 20, 5.00, 5, '2026-08-28 11:49:18'),
	(133, 22, 120, 21, 5.00, 5, '2026-08-28 11:49:18'),
	(134, 22, 121, 17, 4.00, 4, '2026-08-28 11:49:18'),
	(135, 22, 122, 18, 4.00, 4, '2026-08-28 11:49:18'),
	(136, 22, 123, 19, 3.00, 3, '2026-08-28 11:49:18'),
	(137, 22, 124, 20, 5.00, 5, '2026-08-28 11:49:18'),
	(138, 22, 125, 21, 4.00, 4, '2026-08-28 11:49:18'),
	(139, 22, 126, 17, 4.00, 4, '2026-08-28 11:49:18'),
	(140, 22, 127, 18, 3.00, 3, '2026-08-28 11:49:18'),
	(141, 22, 128, 19, 5.00, 5, '2026-08-28 11:49:18'),
	(142, 22, 129, 20, 6.00, 6, '2026-08-28 11:49:18'),
	(143, 22, 130, 21, 3.00, 3, '2026-08-28 11:49:18');

-- Dumping structure for table istapa.contact_messages
DROP TABLE IF EXISTS `contact_messages`;
CREATE TABLE IF NOT EXISTS `contact_messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `full_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('new','read','replied','spam') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`),
  KEY `idx_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table istapa.contact_messages: ~11 rows (approximately)
DELETE FROM `contact_messages`;
INSERT INTO `contact_messages` (`id`, `full_name`, `email`, `phone`, `subject`, `message`, `status`, `ip_address`, `created_at`) VALUES
	(1, 'Paul Mbarga', 'paul@example.com', '699123456', 'Renseignements BTS Agriculture', 'Bonjour, je souhaite des informations sur les inscriptions pour le BTS Agriculture.', 'new', '102.244.10.1', '2026-04-22 00:06:33'),
	(2, 'Sophie Ateba', 'sophie@example.com', NULL, 'Question sur les frais', 'Quels sont les frais de scolarité pour l\'année 2026 ?', 'new', '102.244.10.2', '2026-04-22 00:06:33'),
	(3, 'Luc Nguemo', 'luc@example.com', '650987654', 'Partenariat entreprise', 'Notre entreprise souhaite établir un partenariat avec votre institution.', 'new', '102.244.10.3', '2026-04-22 00:06:33'),
	(4, 'Ludger Ngapouche', 'ngapoucheludger@gmail.com', NULL, 'Rejoindre la communauté - Leçon d\'essai gratuite', 'test', 'new', '102.244.197.149', '2026-08-26 15:00:24'),
	(5, 'Ludger Ngapouche', 'ngapoucheludger@gmail.com', '+237697272270', 'admission', 'hello', 'new', '102.244.197.149', '2026-08-26 15:00:46'),
	(6, 'Robertkaphy', 'henrydixon487@gmail.com', NULL, 'Rejoindre la communaute - Lecon d\'essai gratuite', 'Sveiki, aš norėjau sužinoti jūsų kainą.', 'new', '80.94.95.173', '2026-08-27 05:52:50'),
	(7, 'karkasnyy_ypon', 'dlpidfnkpon@lilycake.ru', '83234322973', 'other', 'Если вы планируете строительство жилья, обратите внимание на <a href=https://karkasnye-doma-pod-klyuch13.ru>каркасный дом под ключ</a> — это современное и экономичное решение для комфортного проживания. \r\nЕще одним крупным достоинством является эффективность теплоизоляции таких домов.', 'new', '91.84.111.146', '2026-08-27 14:14:45'),
	(8, 'Robertkaphy', 'hsilojhonaisy@gmail.com', NULL, 'Rejoindre la communaute - Lecon d\'essai gratuite', 'Hi, kam dashur të di çmimin tuaj', 'new', '141.98.11.224', '2026-08-27 17:58:58'),
	(9, 'Remont_wrEn', 'ktruzqgpcEn@victoria-photographer.ru', '83272448193', 'program', 'Если вам требуется качественный <a href=https://remont-dvig124.ru>Капитальный ремонт двигателя цена</a>, обращайтесь к профессионалам. \r\nПо окончании ремонтных работ проводят проверку функционирования двигателя.', 'new', '185.121.232.229', '2026-08-27 19:52:54'),
	(10, 'Danielget', 'deepstate@mail.com', '81612167621', 'program', 'Hello, Noa Drimer (https://www.instagram.com/noa_drimer_actor_ballerina/) \r\n \r\nThank you so much, Noa. As a professional actress, your performance in the series “The Boys” in the role of Becca Butcher was absolutely convincing. You managed to perfectly convey the emotional state, vulnerability, and the character of the heroine. Your fans watch your scenes, and their eyes literally fill with tears. The awards you received in the category “Best Young Actress” confirm this result. Thank you for your amazing work. \r\n \r\nActing under the personal authority of Mohammed bin Salman, the Saudi special services carry out systematic deployment of directed psychophysical weapons against the civilian populations of the neighbouring states Oman and Yemen. Substantial numbers of non-combatants have been hit, and children form a clearly elevated share of the victims. Documented consequences consist of artificially induced panic, partial erasure of memory and lasting dulling of autonomous will. The operations satisfy the legal criteria of a war crime and intentional psychic degradation of a generation, all conducted behind a sustained information barrier. \r\nContinued collaboration by high-profile cultural and media personalities with this structure preserves its facade of respectability. Total cessation of any cooperation strips away that facade and leaves the underlying mechanism fully visible. \r\nThe foregoing describes only the tactical layer. The strategic configuration is organised on different principles: \r\n \r\nWikiLeaks operates as a special operation controlled by the Saudi deep state. \r\nThe accepted public account portrays WikiLeaks as an independent channel of revelations. In reality the content was assembled, screened and released in measured quantities inside a subsystem that incorporates direct Saudi deep-state participation. \r\n \r\nThe subsystem comprises weapons manufacture, military technologies and the informational plus cybernetic arms of the special services. \r\n \r\nAbove it stands the supersystem of directed satellite psychophysical weapons, functioning as the central instrument of mass-consciousness management. \r\nSaudi Arabia utilises this supersystem to lock in its status as a supra-managerial power. Historical archives are kept circulating as a distraction while the actual instruments of control remain obscured. \r\n \r\nThe ability to produce absolute euphoria and dependence erodes the human dimension of decision-makers and substantially weakens moral restraint when orders are given to employ the weapon against civilian populations that include children. \r\n \r\nIran remains the sole regional state that refuses integration into this arrangement and therefore experiences intensified pressure. \r\n \r\nWith respect to the populations of Oman, Iraq, Yemen and Iran the technique rests on provocation: influence pushes a chosen individual into a grave crime such as an armed assault, sexual attack or mass killing; the event is immediately magnified by the media, generates mutual recrimination and sets the societies against each other. The purpose is managed destabilisation of the region while the source of the influence stays entirely under command. \r\n \r\nThe same pattern is extended abroad. Iranian citizens located in the United States, Europe and other countries are subjected to identical influence, inducing serious offences that are subsequently presented as proof of Iranian-directed terrorism. This creates a controllable pretext for isolation, coercive steps and the eventual substitution of independent governance by a managed structure. \r\n \r\n|aldanacollectionbyg\r\n|clouds_studio\r\n|_kh_makeup\r\n|tosh.snaps\r\n|arrawdha_hospital\r\n|saudi.trend98\r\n|ahsacourses\r\n|al.shammari.gallery10\r\n|hayatplazaa\r\n|suhaadnan27', 'new', '87.199.209.142', '2026-08-28 01:26:54'),
	(11, 'karkasnyy_jvkt', 'uwblegfukkt@vseindi.com', '89771881454', 'other', 'Если вы хотите быстро и качественно построить уютное жильё, обратитесь к специалистам по <a href=https://karkasnye-doma-spb11.ru>каркасный дом под ключ спб</a>. \r\nДля каркасных домов обычно выбирают плитный или ленточный фундамент из-за легкости конструкции.', 'new', '109.172.91.206', '2026-08-28 07:03:48');

-- Dumping structure for table istapa.events
DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `id` int NOT NULL AUTO_INCREMENT,
  `slug` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_en` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_fr` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description_en` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description_fr` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_en` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_fr` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `view_count` int NOT NULL DEFAULT '0',
  `cover_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` date NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` bigint unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_event_slug` (`slug`),
  KEY `idx_start` (`start_date`),
  KEY `idx_pub` (`is_published`),
  KEY `fk_ev_creator` (`created_by`),
  CONSTRAINT `fk_ev_creator` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table istapa.events: ~9 rows (approximately)
DELETE FROM `events`;
INSERT INTO `events` (`id`, `slug`, `title_en`, `title_fr`, `short_description_en`, `short_description_fr`, `content_en`, `content_fr`, `view_count`, `cover_image`, `video_url`, `location`, `start_date`, `start_time`, `end_date`, `end_time`, `is_published`, `created_by`, `created_at`, `updated_at`) VALUES
	(1, 'journee-portes-ouvertes-2026', 'Open Day 2026', 'Journée Portes Ouvertes 2026', 'Visit ISTAPA and discover our programs', 'Venez découvrir l\'ISTAPA et nos formations.', 'Full description of Open Day 2026 event.', 'Description complète de la Journée Portes Ouvertes 2026.', 48, 'event_covers/YAU2pxjqNJOEuPNM2tBILmE8qm6bSpA4e7e42x5g.jpg', NULL, 'ISTAPA, Yaoundé', '2026-05-15', NULL, '2026-05-15', NULL, 1, 23, '2026-04-22 00:06:34', '2026-08-28 14:05:35'),
	(2, 'remise-diplomes-2025', 'Graduation Ceremony 2025', 'Remise des diplômes 2025', 'Celebration of the graduating class of 2025.', 'Cérémonie de remise des diplômes de la promotion 2025.', 'Full description of the graduation ceremony.', 'Description complète de la cérémonie de remise des diplômes.', 48, NULL, NULL, 'ISTAPA, Yaoundé', '2025-08-20', NULL, '2025-08-20', NULL, 1, 23, '2026-04-22 00:06:34', '2026-08-28 14:05:38'),
	(3, 'foire-agricole-yaounde-2026', 'Yaoundé Agricultural Fair 2026', 'Foire Agricole de Yaoundé 2026', 'ISTAPA will be exhibiting at this year\'s national agricultural fair.', 'L\'ISTAPA exposera à la foire agricole nationale de cette année.', 'Full description in English of ISTAPA\'s participation in the 2026 Yaoundé Agricultural Fair, showcasing student projects and research.', 'Description complète en français de la participation de l\'ISTAPA à la Foire Agricole de Yaoundé 2026, présentant les projets étudiants et les recherches.', 73, NULL, NULL, 'Palais des Congrès, Yaoundé', '2026-06-15', '08:00:00', '2026-06-18', '18:00:00', 1, 23, '2026-05-22 12:25:25', '2026-08-28 14:05:42'),
	(4, 'atelier-agriculture-durable-2026', 'Workshop: Sustainable Farming Practices', 'Atelier : Pratiques agricoles durables', 'A hands-on workshop for students and local farmers.', 'Un atelier pratique pour les étudiants et les agriculteurs locaux.', 'Full description in English of the sustainable farming workshop covering soil conservation, composting and integrated pest management.', 'Description complète en français de l\'atelier sur l\'agriculture durable couvrant la conservation des sols, le compostage et la lutte intégrée contre les nuisibles.', 63, NULL, NULL, 'Campus ISTAPA, Yaoundé', '2026-07-05', '09:00:00', '2026-07-05', '17:00:00', 1, 23, '2026-05-22 12:25:25', '2026-08-28 12:33:12'),
	(5, 'rentree-academique-2026-2027', 'Opening Ceremony — Academic Year 2026-2027', 'Cérémonie d\'ouverture — Année académique 2026-2027', 'Welcome new and returning students for the 2026-2027 academic year.', 'Bienvenue aux nouveaux étudiants et à ceux qui reviennent pour l\'année 2026-2027.', 'Full description in English of the opening ceremony for the 2026-2027 academic year at ISTAPA.', 'Description complète en français de la cérémonie d\'ouverture de l\'année académique 2026-2027 à l\'ISTAPA.', 44, NULL, NULL, 'Amphithéâtre ISTAPA, Yaoundé', '2026-09-07', '10:00:00', '2026-09-07', '13:00:00', 1, 23, '2026-05-22 12:25:25', '2026-08-25 23:19:27'),
	(6, 'istapa-entrance-exam-session-2026-6a61e373ef515', 'ISTAPA ENTRANCE EXAM — SESSION 2026', 'CONCOURS D\'ENTREE A ISTAPA— SESSION 2026', 'ISTAPA is now welcoming applications for its 2026 entrance exam.', 'L\'ISTAPA accueille désormais les candidatures pour son concours d\'entrée 2026.', '❓ Everything You Need to Know About the ISTAPA Entrance Exam\r\n\r\n📌 Who can apply? Holders of the Baccalauréat (or an equivalent diploma), depending on the chosen program.\r\n📌 Where to submit your application? At ISTAPA, Yaoundé-SOA, or online via istapa.com\r\n📌 What does ISTAPA offer? Programs in agriculture, livestock farming, and agro-pastoral studies, with hands-on internships and career placement support.\r\n📅 Academic intake: October 12, 2026', '❓ Tout savoir sur le concours d\'entrée ISTAPA\r\n\r\n📌 Qui peut candidater ? Les titulaires du Baccalauréat (ou diplôme équivalent) selon la filière visée.\r\n📌 Où déposer son dossier ? À ISTAPA, Yaoundé-SOA ou en ligne via istapa.com\r\n📌 Que propose ISTAPA ? Des filières en agriculture, élevage, agropastoral, avec stages pratiques et accompagnement à l\'insertion professionnelle.\r\n\r\n📅 Rentrée académique : 12 octobre 2026', 86, 'event_covers/ortZebyQhyol8eJojdsiwam0HsuaJAB6JWwjcrXQ.jpg', NULL, 'SOA, Apres radio Bonne Nouvelle, Entrée ISTAPA', '2026-07-25', '09:00:00', '2026-07-25', '12:00:00', 1, 24, '2026-07-23 13:48:35', '2026-08-28 10:12:56'),
	(7, 'open-day-6a61e78b4008d', 'OPEN DAY', 'JOURNEE PORTES OUVERTES', 'Event is open to the public', 'Evenement ouvert au grand public', '🚜 Discover ISTAPA\'s Innovative Fields of Study!\r\n\r\nISTAPA opens its doors for a day where theory meets practice. 🌍 Students, farmers, entrepreneurs... this day is made for you!\r\n\r\n🌾 Agriculture of the Future : solar irrigation, greenhouse farming, edible mushroom cultivation, hydroponic green fodder\r\n🐟 Aquaculture 2.0 : artificial fish breeding, RAS (Recirculating Aquaculture System) fish farming\r\n🐝 Innovative Livestock Farming : cockchafer beetle farming, snail farming, black soldier fly larvae production\r\n🔋 Green Energy : solar, wind, biogas\r\n\r\n📌 On the program: innovative programs • campus tour • discussions with instructors\r\n\r\nCome discover it all at our Open House Day — an event open to the general public.\r\n\r\n👉 More info: www.istapa.com', '🚜 Découvre les filières innovantes de l\'ISTAPA !\r\n\r\nL\'ISTAPA t\'ouvre ses portes pour une journée où la théorie rencontre la pratique. 🌍 Étudiants, agriculteurs, entrepreneurs... cette journée est faite pour toi !\r\n\r\n🌾 Agriculture du futur : irrigation solaire, culture sous serre, champignons comestibles, fourrage vert hydroponique\r\n🐟 Pisciculture 2.0 : reproduction artificielle, aquaculture RAS\r\n🐝 Élevage innovant : élevage d\'hannetons, d\'escargots, larves de mouches soldats noires\r\n🔋 Énergies vertes : solaire, éolienne, biogaz\r\n\r\n📌 Au programme : filières innovantes • visite du campus • échanges avec les formateurs\r\n\r\nViens tout découvrir lors de nos Journées Portes Ouvertes — événement ouvert au grand public.\r\n\r\n👉 Plus d\'infos : www.istapa.com', 74, 'event_covers/lNHwH11Y9aYUYCPjG6Oeyg1mzmFACE0QF4EjvAyR.jpg', NULL, 'SOA, Apres radio Bonne Nouvelle, Campus ISTAPA', '2026-07-25', '10:00:00', '2026-07-25', '15:00:00', 1, 24, '2026-07-23 14:06:03', '2026-08-28 08:52:18'),
	(8, 'istapa-motorized-campaign-6a61fab2830b7', 'ISTAPA MOTORIZED CAMPAIGN', 'CAMPAGNE MOTORISEE DE ISTAPA', 'ISTAPA\'s motorized campaign takes the Open House invitation into Yaoundé\'s neighborhoods.', 'La campagne motorisée ISTAPA porte l\'invitation aux Portes Ouvertes dans les quartiers de Yaoundé', 'Because innovation shouldn\'t stay locked behind a screen! ISTAPA chose to go directly to the people, riding through the neighborhoods and main roads of Yaoundé, to invite everyone — young people, farmers, livestock breeders, entrepreneurs — to discover its innovative programs at the Open House Day.\r\nA simple, human, and effective way to spread the message, even where social media isn\'t enough.\r\n\r\n📅 See you on July 25, 2026 at 10 AM!', '🏍️ Pourquoi une campagne à moto ?\r\nParce que l\'innovation ne doit pas rester enfermée derrière un écran ! L\'ISTAPA a choisi d\'aller directement à la rencontre des populations, dans les quartiers et sur les grands axes de Yaoundé, pour inviter chacun — jeunes, agriculteurs, éleveurs, entrepreneurs — à découvrir ses filières innovantes lors des Journées Portes Ouvertes.\r\nUne manière simple, humaine et efficace de faire passer le message, même là où les réseaux sociaux ne suffisent pas.\r\n\r\n📅 Rendez-vous le 25 juillet 2026 à 10h !', 76, 'event_covers/RD0DUBzcO78tuRkeLC1ojFeAikoqmyJ3ReYoef7R.jpg', NULL, 'Mobile Omnisport - Gare Routiere SOA', '2026-07-18', '09:00:00', '2026-07-18', '15:00:00', 1, 24, '2026-07-23 15:27:46', '2026-08-28 07:00:55'),
	(9, 'concours-dentree-en-licence-1-istapa-6a85af93e643d', 'ENTRANCE EXAMINATION FOR FIRST-YEAR BACHELOR’S DEGREE – ISTAPA', 'CONCOURS D\'ENTREE EN LICENCE 1 ISTAPA', 'ISTAPA invites candidates to its Year 1 Bachelor’s Degree entrance examination on August 28, 2026', 'ISTAPA invite les candidats motivés à son concours d’entrée en Licence 1 le 28 août 2026.', 'The ISTAPA Bachelor’s Degree Year 1 entrance examination offers young high school graduates and motivated candidates the opportunity to join an institution committed to developing skills that meet the demands of the professional world. Through an approach focused on practical learning, innovation, skills development, and preparation for future careers, ISTAPA supports its students in building a strong academic and professional path.\r\nJoin us on August 28, 2026 to take part in the entrance examination and seize the opportunity to become part of a community of ambitious students ready to meet the challenges of tomorrow. Start preparing today and take your chance to join ISTAPA!', 'Le concours d’entrée en Licence 1 de ISTAPA offre aux jeunes bacheliers et aux candidats motivés l’opportunité d’intégrer un établissement engagé dans la formation de compétences adaptées aux exigences du monde professionnel. À travers une approche axée sur la pratique, l’innovation, le développement des compétences et la préparation aux métiers d’avenir, ISTAPA accompagne ses étudiants dans la construction d’un parcours académique et professionnel solide.\r\nRendez-vous le 28 août 2026 pour participer au concours d’entrée et tenter de rejoindre une communauté d’étudiants ambitieux, prêts à relever les défis de demain. Préparez-vous dès maintenant et saisissez votre chance d’intégrer ISTAPA !', 35, NULL, NULL, 'SOA, Apres radio Bonne Nouvelle, Entrée ISTAPA', '2026-08-28', '08:00:00', '2026-08-28', '12:00:00', 1, 24, '2026-08-19 17:28:51', '2026-08-28 09:02:29');

-- Dumping structure for table istapa.event_images
DROP TABLE IF EXISTS `event_images`;
CREATE TABLE IF NOT EXISTS `event_images` (
  `id` int NOT NULL AUTO_INCREMENT,
  `event_id` int NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `caption` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_event` (`event_id`),
  CONSTRAINT `fk_ei_event` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table istapa.event_images: ~10 rows (approximately)
DELETE FROM `event_images`;
INSERT INTO `event_images` (`id`, `event_id`, `image_path`, `caption`, `sort_order`) VALUES
	(2, 2, 'uploads/events/remise-diplomes-2025.jpg', 'Cérémonie', 1),
	(3, 1, 'event_galleries/OcPDnxxOH6EFjMcqgkJwddmPTTamEBrxIEs2koVv.png', NULL, 2),
	(4, 1, 'event_galleries/Kvlj5xW7PtR3oYi72Rq3COqRRORfwuB7p7uN9Aut.png', NULL, 3),
	(5, 1, 'event_galleries/1Bm4bxJzd8Jgt2ywGBn1MOwnJlEOwSFEwXmCuaki.jpg', NULL, 4),
	(6, 8, 'event_galleries/GTDaTwmqd4UreRb1U8ctwI1zOh5VxpSBtajLWcWk.jpg', NULL, 1),
	(7, 8, 'event_galleries/L8CwId57AYgbjDqsNpUNhZaoxPuDWTwslCIgMwgU.jpg', NULL, 2),
	(8, 8, 'event_galleries/pRNHsVP1sxKVU30nOWkalu0mFq7GPreB0aBG4w05.jpg', NULL, 3),
	(9, 8, 'event_galleries/CgRLGital9ul3XgOL9C5auXNv0jZMYbLlYry3dSm.jpg', NULL, 4),
	(10, 8, 'event_galleries/fAcsrnpl5XSOKyNOK9QYOtx7gdebDNiV2vWnW8ew.jpg', NULL, 5),
	(12, 8, 'event_galleries/bzzudrWW26Deq2gR7ISGLIDfvkVx8Fg8D8KyCeEJ.jpg', NULL, 6);

-- Dumping structure for table istapa.event_translations
DROP TABLE IF EXISTS `event_translations`;
CREATE TABLE IF NOT EXISTS `event_translations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `event_id` int NOT NULL,
  `language_code` char(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` text COLLATE utf8mb4_unicode_ci,
  `content` mediumtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_evt` (`event_id`,`language_code`),
  KEY `fk_evt_lang` (`language_code`),
  CONSTRAINT `fk_evt_event` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_evt_lang` FOREIGN KEY (`language_code`) REFERENCES `languages` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table istapa.event_translations: ~10 rows (approximately)
DELETE FROM `event_translations`;
INSERT INTO `event_translations` (`id`, `event_id`, `language_code`, `title`, `short_description`, `content`) VALUES
	(1, 1, 'fr', 'Journée Portes Ouvertes 2026', 'Découvrez l\'ISTAPA.', 'Contenu complet en français.'),
	(2, 1, 'en', 'Open Day 2026', 'Visit ISTAPA.', 'Full content in English.'),
	(3, 2, 'fr', 'Remise des diplômes 2025', 'Célébration de la promotion 2025.', 'Contenu complet.'),
	(4, 2, 'en', 'Graduation Ceremony 2025', 'Celebrating the class of 2025.', 'Full content.'),
	(5, 3, 'fr', 'Foire Agricole de Yaoundé 2026', 'L\'ISTAPA exposera à la foire agricole nationale.', 'Contenu complet en français sur la participation de l\'ISTAPA à la foire.'),
	(6, 3, 'en', 'Yaoundé Agricultural Fair 2026', 'ISTAPA will be exhibiting at the national agricultural fair.', 'Full content in English about ISTAPA\'s participation in the fair.'),
	(7, 4, 'fr', 'Atelier : Pratiques agricoles durables', 'Un atelier pratique pour les étudiants et les agriculteurs locaux.', 'Contenu complet en français sur l\'atelier d\'agriculture durable.'),
	(8, 4, 'en', 'Workshop: Sustainable Farming Practices', 'A hands-on workshop for students and local farmers.', 'Full content in English about the sustainable farming workshop.'),
	(9, 5, 'fr', 'Cérémonie d\'ouverture — Année académique 2026-2027', 'Bienvenue aux étudiants pour l\'année académique 2026-2027.', 'Contenu complet en français de la cérémonie d\'ouverture 2026-2027.'),
	(10, 5, 'en', 'Opening Ceremony — Academic Year 2026-2027', 'Welcome students for the 2026-2027 academic year.', 'Full content in English for the 2026-2027 opening ceremony.');

-- Dumping structure for event istapa.ev_record_monthly_views_istapa
DROP EVENT IF EXISTS `ev_record_monthly_views_istapa`;
DELIMITER //
CREATE EVENT `ev_record_monthly_views_istapa` ON SCHEDULE EVERY 1 MONTH STARTS '2026-08-01 00:05:00' ON COMPLETION NOT PRESERVE ENABLE DO CALL record_monthly_views_istapa()//
DELIMITER ;

-- Dumping structure for table istapa.exams
DROP TABLE IF EXISTS `exams`;
CREATE TABLE IF NOT EXISTS `exams` (
  `id` int NOT NULL AUTO_INCREMENT,
  `class_id` int NOT NULL,
  `academic_year_id` int NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `term` enum('term_1','term_2','term_3','final') COLLATE utf8mb4_unicode_ci NOT NULL,
  `exam_type` enum('interro','devoir','composition','tp','projet','final') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'devoir',
  `passing_mark` decimal(5,2) NOT NULL DEFAULT '10.00',
  `total_mark` decimal(5,2) NOT NULL DEFAULT '20.00',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_by` bigint unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_class_year` (`class_id`,`academic_year_id`),
  KEY `idx_term` (`term`),
  KEY `fk_exam_year` (`academic_year_id`),
  KEY `fk_exam_creator` (`created_by`),
  CONSTRAINT `fk_exam_class` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_exam_creator` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_exam_year` FOREIGN KEY (`academic_year_id`) REFERENCES `academic_years` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table istapa.exams: ~10 rows (approximately)
DELETE FROM `exams`;
INSERT INTO `exams` (`id`, `class_id`, `academic_year_id`, `name`, `term`, `exam_type`, `passing_mark`, `total_mark`, `start_date`, `end_date`, `created_by`, `created_at`) VALUES
	(1, 5, 1, 'Contrôle Continu S1', 'term_1', 'devoir', 10.00, 20.00, '2024-11-01', '2024-11-15', 23, '2026-04-22 00:06:33'),
	(2, 5, 1, 'SN Semestre 1', 'term_1', 'composition', 10.00, 20.00, '2025-01-10', '2025-01-20', 23, '2026-04-22 00:06:33'),
	(3, 5, 1, 'Rattrapage S1', 'term_1', 'composition', 10.00, 20.00, '2025-02-05', '2025-02-10', 23, '2026-04-22 00:06:33'),
	(4, 6, 1, 'Contrôle Continu S2', 'term_2', 'devoir', 10.00, 20.00, '2025-03-01', '2025-03-15', 23, '2026-04-22 00:06:33'),
	(5, 6, 1, 'SN Semestre 2', 'term_2', 'composition', 10.00, 20.00, '2025-05-01', '2025-05-20', 23, '2026-04-22 00:06:33'),
	(6, 6, 1, 'Rattrapage S2', 'term_2', 'composition', 10.00, 20.00, '2025-06-10', '2025-06-15', 23, '2026-04-22 00:06:33'),
	(7, 1, 2, 'Contrôle Continu S1', 'term_1', 'devoir', 10.00, 20.00, '2025-11-01', '2025-11-15', 24, '2026-04-22 00:06:33'),
	(8, 2, 2, 'Contrôle Continu S1', 'term_1', 'devoir', 10.00, 20.00, '2025-11-01', '2025-11-15', 24, '2026-04-22 00:06:33'),
	(9, 1, 2, 'SN Semestre 1', 'term_1', 'composition', 10.00, 20.00, '2026-01-08', '2026-01-20', 24, '2026-04-22 00:06:33'),
	(10, 2, 2, 'SN Semestre 1', 'term_1', 'composition', 10.00, 20.00, '2026-01-08', '2026-01-20', 24, '2026-04-22 00:06:33');

-- Dumping structure for table istapa.exam_subjects
DROP TABLE IF EXISTS `exam_subjects`;
CREATE TABLE IF NOT EXISTS `exam_subjects` (
  `id` int NOT NULL AUTO_INCREMENT,
  `exam_id` int NOT NULL,
  `subject_id` int NOT NULL,
  `exam_date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `total_mark` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_exam_subj` (`exam_id`,`subject_id`),
  KEY `idx_subject` (`subject_id`),
  CONSTRAINT `fk_es_exam` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_es_subj` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table istapa.exam_subjects: ~21 rows (approximately)
DELETE FROM `exam_subjects`;
INSERT INTO `exam_subjects` (`id`, `exam_id`, `subject_id`, `exam_date`, `start_time`, `end_time`, `total_mark`) VALUES
	(1, 7, 11, '2025-11-02', NULL, NULL, 20.00),
	(2, 7, 12, '2025-11-04', NULL, NULL, 20.00),
	(3, 7, 13, '2025-11-06', NULL, NULL, 20.00),
	(4, 7, 14, '2025-11-08', NULL, NULL, 20.00),
	(5, 7, 15, '2025-11-10', NULL, NULL, 20.00),
	(6, 8, 1, '2025-11-02', NULL, NULL, 20.00),
	(7, 8, 2, '2025-11-04', NULL, NULL, 20.00),
	(8, 8, 3, '2025-11-06', NULL, NULL, 20.00),
	(9, 8, 4, '2025-11-08', NULL, NULL, 20.00),
	(10, 8, 5, '2025-11-10', NULL, NULL, 20.00),
	(11, 8, 6, '2025-11-12', NULL, NULL, 20.00),
	(12, 8, 7, '2025-11-14', NULL, NULL, 20.00),
	(13, 10, 1, '2026-01-09', NULL, NULL, 20.00),
	(14, 10, 2, '2026-01-10', NULL, NULL, 20.00),
	(15, 10, 3, '2026-01-11', NULL, NULL, 20.00),
	(16, 10, 4, '2026-01-12', NULL, NULL, 20.00),
	(17, 10, 5, '2026-01-13', NULL, NULL, 20.00),
	(18, 10, 6, '2026-01-14', NULL, NULL, 20.00),
	(19, 10, 7, '2026-01-15', NULL, NULL, 20.00),
	(20, 10, 9, '2026-05-21', NULL, NULL, NULL),
	(21, 10, 10, '2026-07-23', NULL, NULL, 20.00);

-- Dumping structure for table istapa.fees
DROP TABLE IF EXISTS `fees`;
CREATE TABLE IF NOT EXISTS `fees` (
  `id` int NOT NULL AUTO_INCREMENT,
  `class_id` int NOT NULL,
  `academic_year_id` int NOT NULL,
  `fee_category_id` int NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `due_date` date DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_fee` (`class_id`,`academic_year_id`,`fee_category_id`),
  KEY `idx_year` (`academic_year_id`),
  KEY `fk_fee_cat` (`fee_category_id`),
  CONSTRAINT `fk_fee_cat` FOREIGN KEY (`fee_category_id`) REFERENCES `fee_categories` (`id`),
  CONSTRAINT `fk_fee_class` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_fee_year` FOREIGN KEY (`academic_year_id`) REFERENCES `academic_years` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table istapa.fees: ~9 rows (approximately)
DELETE FROM `fees`;
INSERT INTO `fees` (`id`, `class_id`, `academic_year_id`, `fee_category_id`, `amount`, `due_date`, `description`, `created_at`) VALUES
	(1, 1, 2, 6, 500000.00, '2026-03-31', 'Frais de scolarité HND1 Agriculture 2025-2026', '2026-04-22 00:06:33'),
	(2, 2, 2, 6, 500000.00, '2026-03-31', 'Frais de scolarité HND2 Agriculture 2025-2026', '2026-04-22 00:06:33'),
	(3, 3, 2, 6, 500000.00, '2026-03-31', 'Frais de scolarité HND1 Environnement 2025-2026', '2026-04-22 00:06:33'),
	(4, 1, 2, 7, 50000.00, '2025-10-31', 'Frais d\'inscription HND1 2025-2026', '2026-04-22 00:06:33'),
	(5, 2, 2, 7, 50000.00, '2025-10-31', 'Frais d\'inscription HND2 2025-2026', '2026-04-22 00:06:33'),
	(6, 1, 2, 1, 50000.00, '2025-10-31', 'Tranche inscription HND1', '2026-04-22 00:06:33'),
	(7, 1, 2, 2, 150000.00, '2025-12-31', '1ère tranche HND1', '2026-04-22 00:06:33'),
	(8, 1, 2, 3, 150000.00, '2026-02-28', '2ème tranche HND1', '2026-04-22 00:06:33'),
	(9, 1, 2, 4, 150000.00, '2026-03-31', '3ème tranche HND1', '2026-04-22 00:06:33');

-- Dumping structure for table istapa.fee_categories
DROP TABLE IF EXISTS `fee_categories`;
CREATE TABLE IF NOT EXISTS `fee_categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `sort_order` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_fee_cat_slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table istapa.fee_categories: ~7 rows (approximately)
DELETE FROM `fee_categories`;
INSERT INTO `fee_categories` (`id`, `name`, `slug`, `description`, `sort_order`) VALUES
	(1, 'Inscription', 'inscription', NULL, 1),
	(2, '1ère tranche', 'tranche-1', NULL, 2),
	(3, '2ème tranche', 'tranche-2', NULL, 3),
	(4, '3ème tranche', 'tranche-3', NULL, 4),
	(5, 'Frais examen', 'examen', NULL, 5),
	(6, 'Frais de Scolarité', 'scolarite', 'Frais annuels de scolarité', 6),
	(7, 'Frais d\'admission', 'admission', 'Frais d\'ouverture de dossier', 7);

-- Dumping structure for table istapa.fee_payments
DROP TABLE IF EXISTS `fee_payments`;
CREATE TABLE IF NOT EXISTS `fee_payments` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `student_id` bigint unsigned NOT NULL,
  `fee_id` int NOT NULL,
  `amount_paid` decimal(10,2) NOT NULL,
  `payment_method` enum('cash','bank_transfer','mobile_money','card','check','other') COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction_ref` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paid_on` date NOT NULL,
  `received_by` bigint unsigned NOT NULL,
  `receipt_number` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_receipt` (`receipt_number`),
  KEY `idx_student` (`student_id`),
  KEY `idx_fee` (`fee_id`),
  KEY `idx_paid_on` (`paid_on`),
  KEY `fk_pay_receiver` (`received_by`),
  CONSTRAINT `fk_pay_fee` FOREIGN KEY (`fee_id`) REFERENCES `fees` (`id`),
  CONSTRAINT `fk_pay_receiver` FOREIGN KEY (`received_by`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_pay_student` FOREIGN KEY (`student_id`) REFERENCES `students` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table istapa.fee_payments: ~18 rows (approximately)
DELETE FROM `fee_payments`;
INSERT INTO `fee_payments` (`id`, `student_id`, `fee_id`, `amount_paid`, `payment_method`, `transaction_ref`, `paid_on`, `received_by`, `receipt_number`, `notes`, `created_at`) VALUES
	(1, 25, 4, 50000.00, 'cash', NULL, '2025-09-15', 24, NULL, 'Registration', '2026-04-22 00:06:33'),
	(2, 26, 4, 50000.00, 'cash', NULL, '2025-09-15', 24, NULL, 'Registration + 1ère tranche', '2026-04-22 00:06:33'),
	(3, 27, 4, 50000.00, 'cash', NULL, '2025-09-16', 24, NULL, 'Registration', '2026-04-22 00:06:33'),
	(4, 28, 4, 50000.00, 'cash', NULL, '2025-09-16', 24, NULL, 'Registration HND1', '2026-04-22 00:06:33'),
	(5, 29, 4, 150000.00, 'cash', NULL, '2025-09-30', 24, NULL, 'Inscription et première tranche', '2026-04-22 00:06:33'),
	(6, 31, 4, 50000.00, 'cash', NULL, '2025-10-24', 24, NULL, 'Inscription', '2026-04-22 00:06:33'),
	(7, 32, 4, 50000.00, 'cash', NULL, '2025-10-24', 24, NULL, 'Inscription', '2026-04-22 00:06:33'),
	(8, 33, 4, 100000.00, 'cash', NULL, '2025-10-24', 24, NULL, 'Inscription et demi tranche', '2026-04-22 00:06:33'),
	(9, 34, 4, 50000.00, 'cash', NULL, '2025-10-24', 24, NULL, 'Inscription', '2026-04-22 00:06:33'),
	(10, 35, 4, 50000.00, 'cash', NULL, '2025-10-24', 24, NULL, 'Inscription', '2026-04-22 00:06:33'),
	(11, 37, 4, 50000.00, 'cash', NULL, '2025-10-24', 24, NULL, 'Inscription', '2026-04-22 00:06:33'),
	(12, 38, 4, 50000.00, 'cash', NULL, '2025-10-24', 24, NULL, 'Inscription', '2026-04-22 00:06:33'),
	(13, 26, 7, 100000.00, 'cash', NULL, '2025-11-03', 24, NULL, 'Deuxième tranche', '2026-04-22 00:06:33'),
	(14, 27, 7, 170000.00, 'cash', NULL, '2025-10-24', 24, NULL, 'Deuxième et demi tranche', '2026-04-22 00:06:33'),
	(15, 27, 7, 80000.00, 'cash', NULL, '2025-12-01', 24, NULL, 'Second instalment', '2026-04-22 00:06:33'),
	(16, 28, 7, 250000.00, 'cash', NULL, '2025-10-24', 24, NULL, 'Inscription et deux tranche', '2026-04-22 00:06:33'),
	(17, 28, 7, 150000.00, 'cash', NULL, '2025-12-02', 24, NULL, '3ème et 4ème tranche', '2026-04-22 00:06:33'),
	(18, 29, 7, 80000.00, 'cash', NULL, '2025-12-02', 24, NULL, 'Inscription et avance de la première tranche', '2026-04-22 00:06:33');

-- Dumping structure for table istapa.gallery_albums
DROP TABLE IF EXISTS `gallery_albums`;
CREATE TABLE IF NOT EXISTS `gallery_albums` (
  `id` int NOT NULL AUTO_INCREMENT,
  `slug` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_en` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_fr` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_en` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_fr` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `cover_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_album_slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table istapa.gallery_albums: ~3 rows (approximately)
DELETE FROM `gallery_albums`;
INSERT INTO `gallery_albums` (`id`, `slug`, `title_en`, `title_fr`, `description_en`, `description_fr`, `cover_image`, `sort_order`, `created_at`) VALUES
	(1, 'rentree-2025', 'Sciences in Motion', 'Sciences en mouvement', 'This album opens the doors to our state-of-the-art laboratories, where theory meets experimentation. Behind the workbenches, our students don\'t just memorize formulas—they test them, handle them, and push their boundaries.\r\n\r\nThrough these authentic snapshots, experience the vibrant energy of our lab sessions: microscope observations, precise titrations, peer-to-peer brainstorming, and the shared smiles of a successful experiment. Each frame captures a moment of scientific curiosity, intellectual rigor, and true team spirit.\r\n\r\nHere, the laboratory is an educational playground. Far more than just a class, it’s a collaborative adventure shaping our students into the informed, innovative leaders of tomorrow.\r\n\r\nEnjoy the gallery! And feel free to tag your future scientists in the comments below. 🔬🧪', 'Cet album vous ouvre les portes de nos laboratoires modernes, où la théorie laisse place à l\'expérimentation. Derrière les paillasses, nos étudiants ne se contentent pas d\'apprendre des formules : ils les testent, les manipulent et les challengent.\r\n\r\nÀ travers ces clichés authentiques, découvrez l\'effervescence des travaux dirigés : observations au microscope, dosages précis, collaborations en binôme et éclats de rire partagés autour d\'une manipulation réussie. Chaque photo capture un instant de curiosité scientifique, de rigueur intellectuelle et d\'esprit d\'équipe.\r\n\r\nChez nous, le laboratoire est un véritable terrain de jeu éducatif. Bien plus qu\'un cours, c\'est une aventure collaborative qui prépare nos élèves à devenir les acteurs éclairés et innovants du monde de demain.\r\n\r\nBon visionnage ! Et n\'hésitez pas à identifier vos futurs grands scientifiques dans les commentaires. 🔬🧪', 'gallery_images/6a5e0774eec03_1784547188_1.jpg', 1, '2026-04-22 00:06:34'),
	(2, 'activites-pedagogiques', '', '', '', '', 'gallery_images/6a0129be22c41_1778461118_0.jpg', 2, '2026-04-22 00:06:34'),
	(3, 'fsdfsdf-6a0084e209b22', 'dfsdfsdf', 'fsdfsdf', 'azrtyuilkjhjkhjkj', 'iouusfoauodquoduqsodi', 'gallery_images/6a108bff16342_1779469311_0.jpg', 0, '2026-05-10 12:15:14');

-- Dumping structure for table istapa.gallery_album_translations
DROP TABLE IF EXISTS `gallery_album_translations`;
CREATE TABLE IF NOT EXISTS `gallery_album_translations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `album_id` int NOT NULL,
  `language_code` char(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_gat` (`album_id`,`language_code`),
  KEY `fk_gat_lang` (`language_code`),
  CONSTRAINT `fk_gat_album` FOREIGN KEY (`album_id`) REFERENCES `gallery_albums` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_gat_lang` FOREIGN KEY (`language_code`) REFERENCES `languages` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table istapa.gallery_album_translations: ~4 rows (approximately)
DELETE FROM `gallery_album_translations`;
INSERT INTO `gallery_album_translations` (`id`, `album_id`, `language_code`, `title`, `description`) VALUES
	(1, 1, 'fr', 'Rentrée 2025', 'Photos de la rentrée académique 2025-2026.'),
	(2, 1, 'en', 'Back to School 2025', 'Photos from the 2025-2026 academic year opening.'),
	(3, 2, 'fr', 'Activités pédagogiques', 'Photos des activités en classe et sur le terrain.'),
	(4, 2, 'en', 'Teaching Activities', 'Photos from classroom and field activities.');

-- Dumping structure for table istapa.gallery_images
DROP TABLE IF EXISTS `gallery_images`;
CREATE TABLE IF NOT EXISTS `gallery_images` (
  `id` int NOT NULL AUTO_INCREMENT,
  `album_id` int DEFAULT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `caption` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `uploaded_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_album` (`album_id`),
  KEY `fk_gi_user` (`uploaded_by`),
  CONSTRAINT `fk_gi_album` FOREIGN KEY (`album_id`) REFERENCES `gallery_albums` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_gi_user` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table istapa.gallery_images: ~14 rows (approximately)
DELETE FROM `gallery_images`;
INSERT INTO `gallery_images` (`id`, `album_id`, `image_path`, `caption`, `sort_order`, `uploaded_by`, `created_at`) VALUES
	(8, 2, 'gallery_images/6a0129be22c41_1778461118_0.jpg', '457774318_122130731990331499_8404464423876650403_n-768x768', 1, 1, '2026-05-10 23:58:38'),
	(9, 2, 'gallery_images/6a0129be2806e_1778461118_1.jpg', '457504865_122130726842331499_374861020851708552_n-1024x768', 2, 1, '2026-05-10 23:58:38'),
	(10, 2, 'gallery_images/6a0129be28f8c_1778461118_2.jpg', '457504865_122130726842331499_374861020851708552_n-1', 3, 1, '2026-05-10 23:58:38'),
	(11, 2, 'gallery_images/6a0129be29cec_1778461118_3.png', 'slide3', 4, 1, '2026-05-10 23:58:38'),
	(12, 3, 'gallery_images/6a108bff16342_1779469311_0.jpg', '475105121_122156457968331499_8259807869563249512_n-768x962', 1, 1, '2026-05-22 21:01:51'),
	(14, 3, 'gallery_images/6a108bff17aa6_1779469311_2.jpg', '457774318_122130731990331499_8404464423876650403_n-768x768', 3, 1, '2026-05-22 21:01:51'),
	(15, 3, 'gallery_images/6a108bff180fd_1779469311_3.jpg', '457504865_122130726842331499_374861020851708552_n-1', 4, 1, '2026-05-22 21:01:51'),
	(16, 3, 'gallery_images/6a108c4de9747_1779469389_0.jpg', '475105121_122156457968331499_8259807869563249512_n-768x962', 5, 1, '2026-05-22 21:03:09'),
	(17, 1, 'gallery_images/6a5e0774e711d_1784547188_0.jpg', 'WhatsApp Image 2026-07-02 at 14.25.33', 1, 24, '2026-07-20 15:33:08'),
	(18, 1, 'gallery_images/6a5e0774eec03_1784547188_1.jpg', 'WhatsApp Image 2026-07-02 at 14.24.58', 2, 24, '2026-07-20 15:33:08'),
	(19, 1, 'gallery_images/6a5e0774ef6ca_1784547188_2.jpg', 'WhatsApp Image 2026-07-02 at 14.24.54', 3, 24, '2026-07-20 15:33:08'),
	(20, 1, 'gallery_images/6a5e0774f0250_1784547188_3.jpg', 'WhatsApp Image 2026-07-02 at 14.24.53', 4, 24, '2026-07-20 15:33:08'),
	(21, 1, 'gallery_images/6a5e0774f0b6b_1784547188_4.jpg', 'WhatsApp Image 2026-07-02 at 14.24.51', 5, 24, '2026-07-20 15:33:08'),
	(22, 1, 'gallery_images/6a5e08edeef25_1784547565_0.jpg', 'WhatsApp Image 2026-07-02 at 14.24.51 (1)', 6, 24, '2026-07-20 15:39:25');

-- Dumping structure for table istapa.grades
DROP TABLE IF EXISTS `grades`;
CREATE TABLE IF NOT EXISTS `grades` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mark_from` decimal(5,2) NOT NULL,
  `mark_to` decimal(5,2) NOT NULL,
  `point` decimal(4,2) NOT NULL,
  `comment` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table istapa.grades: ~6 rows (approximately)
DELETE FROM `grades`;
INSERT INTO `grades` (`id`, `name`, `mark_from`, `mark_to`, `point`, `comment`) VALUES
	(1, 'A+', 18.00, 20.00, 4.00, 'Excellent'),
	(2, 'A', 16.00, 17.99, 3.70, 'Très bien'),
	(3, 'B+', 14.00, 15.99, 3.30, 'Bien'),
	(4, 'B', 12.00, 13.99, 3.00, 'Assez bien'),
	(5, 'C', 10.00, 11.99, 2.00, 'Passable'),
	(6, 'D', 0.00, 9.99, 0.00, 'Insuffisant');

-- Dumping structure for table istapa.languages
DROP TABLE IF EXISTS `languages`;
CREATE TABLE IF NOT EXISTS `languages` (
  `code` char(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table istapa.languages: ~2 rows (approximately)
DELETE FROM `languages`;
INSERT INTO `languages` (`code`, `name`, `is_default`, `is_active`, `sort_order`) VALUES
	('en', 'English', 0, 1, 2),
	('fr', 'Français', 1, 1, 1);

-- Dumping structure for table istapa.leave_requests
DROP TABLE IF EXISTS `leave_requests`;
CREATE TABLE IF NOT EXISTS `leave_requests` (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_id` bigint unsigned NOT NULL,
  `leave_type` enum('medical','family','personal','academic','other') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'personal',
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `reason` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','approved','rejected','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `reviewed_by` bigint unsigned DEFAULT NULL,
  `review_comment` text COLLATE utf8mb4_unicode_ci,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_student` (`student_id`),
  KEY `idx_status` (`status`),
  KEY `idx_dates` (`start_date`,`end_date`),
  KEY `fk_leave_reviewer` (`reviewed_by`),
  CONSTRAINT `fk_leave_reviewer` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_leave_student` FOREIGN KEY (`student_id`) REFERENCES `students` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table istapa.leave_requests: ~2 rows (approximately)
DELETE FROM `leave_requests`;
INSERT INTO `leave_requests` (`id`, `student_id`, `leave_type`, `start_date`, `end_date`, `reason`, `attachment`, `status`, `reviewed_by`, `review_comment`, `reviewed_at`, `created_at`, `updated_at`) VALUES
	(1, 8, 'medical', '2025-11-03', '2025-11-05', 'Raisons médicales — fièvre.', NULL, 'approved', 24, NULL, NULL, '2026-04-22 00:06:33', '2026-04-22 00:06:33'),
	(2, 28, 'family', '2025-11-04', '2025-11-04', 'Cérémonie familiale.', NULL, 'approved', 1, NULL, '2026-04-29 08:49:41', '2026-04-22 00:06:33', '2026-04-29 08:49:41');

-- Dumping structure for table istapa.marks
DROP TABLE IF EXISTS `marks`;
CREATE TABLE IF NOT EXISTS `marks` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `exam_subject_id` int NOT NULL,
  `student_id` bigint unsigned NOT NULL,
  `mark` decimal(5,2) DEFAULT NULL,
  `grade_id` int DEFAULT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `entered_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_mark_es_student` (`exam_subject_id`,`student_id`),
  KEY `idx_student` (`student_id`),
  KEY `fk_marks_grade` (`grade_id`),
  KEY `fk_marks_enterer` (`entered_by`),
  CONSTRAINT `fk_marks_enterer` FOREIGN KEY (`entered_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_marks_es` FOREIGN KEY (`exam_subject_id`) REFERENCES `exam_subjects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_marks_grade` FOREIGN KEY (`grade_id`) REFERENCES `grades` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_marks_student` FOREIGN KEY (`student_id`) REFERENCES `students` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table istapa.marks: ~49 rows (approximately)
DELETE FROM `marks`;
INSERT INTO `marks` (`id`, `exam_subject_id`, `student_id`, `mark`, `grade_id`, `comment`, `entered_by`, `created_at`, `updated_at`) VALUES
	(1, 13, 5, 16.00, NULL, 'bien', 1, '2026-04-22 00:06:33', '2026-05-20 23:54:45'),
	(2, 14, 5, 15.00, 3, NULL, 23, '2026-04-22 00:06:33', '2026-04-22 00:06:33'),
	(3, 15, 5, 10.00, 5, NULL, 23, '2026-04-22 00:06:33', '2026-04-22 00:06:33'),
	(4, 16, 5, 15.00, 3, NULL, 23, '2026-04-22 00:06:33', '2026-04-22 00:06:33'),
	(5, 17, 5, 10.00, 5, NULL, 23, '2026-04-22 00:06:33', '2026-04-22 00:06:33'),
	(6, 18, 5, 18.00, 1, NULL, 23, '2026-04-22 00:06:33', '2026-04-22 00:06:33'),
	(7, 19, 5, 13.00, 4, NULL, 23, '2026-04-22 00:06:33', '2026-04-22 00:06:33'),
	(8, 13, 6, 16.00, NULL, NULL, 1, '2026-04-22 00:06:33', '2026-05-20 23:54:45'),
	(9, 14, 6, 14.00, 3, NULL, 23, '2026-04-22 00:06:33', '2026-04-22 00:06:33'),
	(10, 15, 6, 18.00, 1, NULL, 23, '2026-04-22 00:06:33', '2026-04-22 00:06:33'),
	(11, 16, 6, 0.00, 6, NULL, 23, '2026-04-22 00:06:33', '2026-04-22 00:06:33'),
	(12, 17, 6, 14.00, 3, NULL, 23, '2026-04-22 00:06:33', '2026-04-22 00:06:33'),
	(13, 18, 6, 11.00, 5, NULL, 23, '2026-04-22 00:06:33', '2026-04-22 00:06:33'),
	(14, 19, 6, 16.00, 2, NULL, 23, '2026-04-22 00:06:33', '2026-04-22 00:06:33'),
	(15, 13, 7, 17.00, NULL, NULL, 1, '2026-04-22 00:06:33', '2026-05-20 23:54:45'),
	(16, 14, 7, 16.00, 2, NULL, 23, '2026-04-22 00:06:33', '2026-04-22 00:06:33'),
	(17, 15, 7, 17.00, 2, NULL, 23, '2026-04-22 00:06:33', '2026-04-22 00:06:33'),
	(18, 16, 7, 17.00, 2, NULL, 23, '2026-04-22 00:06:33', '2026-04-22 00:06:33'),
	(19, 17, 7, 5.00, 6, NULL, 23, '2026-04-22 00:06:33', '2026-04-22 00:06:33'),
	(20, 18, 7, 13.00, 4, NULL, 23, '2026-04-22 00:06:33', '2026-04-22 00:06:33'),
	(21, 19, 7, 16.00, 2, NULL, 23, '2026-04-22 00:06:33', '2026-04-22 00:06:33'),
	(22, 13, 8, 0.00, NULL, NULL, 1, '2026-04-22 00:06:33', '2026-05-20 23:54:45'),
	(23, 14, 8, 0.00, 6, NULL, 23, '2026-04-22 00:06:33', '2026-04-22 00:06:33'),
	(24, 15, 8, 0.00, 6, NULL, 23, '2026-04-22 00:06:33', '2026-04-22 00:06:33'),
	(25, 16, 8, 0.00, 6, NULL, 23, '2026-04-22 00:06:33', '2026-04-22 00:06:33'),
	(26, 17, 8, 0.00, 6, NULL, 23, '2026-04-22 00:06:33', '2026-04-22 00:06:33'),
	(27, 18, 8, 0.00, 6, NULL, 23, '2026-04-22 00:06:33', '2026-04-22 00:06:33'),
	(28, 19, 8, 0.00, 6, NULL, 23, '2026-04-22 00:06:33', '2026-04-22 00:06:33'),
	(29, 13, 9, 17.00, NULL, NULL, 1, '2026-04-22 00:06:33', '2026-05-20 23:54:45'),
	(30, 14, 9, 0.00, 6, NULL, 23, '2026-04-22 00:06:33', '2026-04-22 00:06:33'),
	(31, 15, 9, 17.00, 2, NULL, 23, '2026-04-22 00:06:33', '2026-04-22 00:06:33'),
	(32, 16, 9, 17.00, 2, NULL, 23, '2026-04-22 00:06:33', '2026-04-22 00:06:33'),
	(33, 17, 9, 0.00, 6, NULL, 23, '2026-04-22 00:06:33', '2026-04-22 00:06:33'),
	(34, 18, 9, 10.00, 5, NULL, 23, '2026-04-22 00:06:33', '2026-04-22 00:06:33'),
	(35, 19, 9, 0.00, 6, NULL, 23, '2026-04-22 00:06:33', '2026-04-22 00:06:33'),
	(36, 13, 10, 16.00, NULL, NULL, 1, '2026-04-22 00:06:33', '2026-05-20 23:54:45'),
	(37, 14, 10, 18.00, 1, NULL, 23, '2026-04-22 00:06:33', '2026-04-22 00:06:33'),
	(38, 15, 10, 18.00, 1, NULL, 23, '2026-04-22 00:06:33', '2026-04-22 00:06:33'),
	(39, 16, 10, 15.00, 3, NULL, 23, '2026-04-22 00:06:33', '2026-04-22 00:06:33'),
	(40, 17, 10, 14.00, 3, NULL, 23, '2026-04-22 00:06:33', '2026-04-22 00:06:33'),
	(41, 18, 10, 14.00, 3, NULL, 23, '2026-04-22 00:06:33', '2026-04-22 00:06:33'),
	(42, 19, 10, 17.00, 2, NULL, 23, '2026-04-22 00:06:33', '2026-04-22 00:06:33'),
	(43, 6, 5, 12.00, NULL, NULL, 1, '2026-04-29 14:57:21', '2026-04-29 14:57:21'),
	(44, 6, 6, 11.00, NULL, NULL, 1, '2026-04-29 14:57:21', '2026-04-29 14:57:21'),
	(45, 6, 7, 15.00, NULL, NULL, 1, '2026-04-29 14:57:21', '2026-04-29 14:57:21'),
	(46, 6, 8, 9.00, NULL, NULL, 1, '2026-04-29 14:57:21', '2026-04-29 14:57:21'),
	(47, 6, 9, 2.00, NULL, NULL, 1, '2026-04-29 14:57:21', '2026-04-29 14:57:21'),
	(48, 6, 10, 10.00, NULL, NULL, 1, '2026-04-29 14:57:21', '2026-04-29 14:57:21'),
	(49, 20, 5, 15.00, NULL, NULL, 1, '2026-05-20 23:55:38', '2026-05-20 23:55:38');

-- Dumping structure for table istapa.monthly_views_stats
DROP TABLE IF EXISTS `monthly_views_stats`;
CREATE TABLE IF NOT EXISTS `monthly_views_stats` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `item_type` enum('blog_post','program') COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_id` int NOT NULL,
  `year` smallint unsigned NOT NULL,
  `month` tinyint unsigned NOT NULL,
  `cumulative_views` int unsigned NOT NULL,
  `month_views` int unsigned NOT NULL,
  `recorded_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_item_month` (`item_type`,`item_id`,`year`,`month`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table istapa.monthly_views_stats: ~13 rows (approximately)
DELETE FROM `monthly_views_stats`;
INSERT INTO `monthly_views_stats` (`id`, `item_type`, `item_id`, `year`, `month`, `cumulative_views`, `month_views`, `recorded_at`) VALUES
	(1, 'blog_post', 1, 2026, 8, 165, 165, '2026-08-02 05:47:21'),
	(2, 'blog_post', 2, 2026, 8, 118, 118, '2026-08-02 05:47:21'),
	(3, 'blog_post', 3, 2026, 8, 147, 147, '2026-08-02 05:47:21'),
	(4, 'blog_post', 4, 2026, 8, 176, 176, '2026-08-02 05:47:21'),
	(5, 'blog_post', 5, 2026, 8, 128, 128, '2026-08-02 05:47:21'),
	(6, 'blog_post', 6, 2026, 8, 141, 141, '2026-08-02 05:47:21'),
	(7, 'blog_post', 7, 2026, 8, 24, 24, '2026-08-02 05:47:21'),
	(8, 'program', 1, 2026, 8, 33, 33, '2026-08-02 05:47:21'),
	(9, 'program', 2, 2026, 8, 15, 15, '2026-08-02 05:47:21'),
	(10, 'program', 3, 2026, 8, 10, 10, '2026-08-02 05:47:21'),
	(11, 'program', 4, 2026, 8, 16, 16, '2026-08-02 05:47:21'),
	(12, 'program', 5, 2026, 8, 14, 14, '2026-08-02 05:47:21'),
	(13, 'program', 6, 2026, 8, 17, 17, '2026-08-02 05:47:21');

-- Dumping structure for table istapa.partners
DROP TABLE IF EXISTS `partners`;
CREATE TABLE IF NOT EXISTS `partners` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `is_published` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table istapa.partners: ~3 rows (approximately)
DELETE FROM `partners`;
INSERT INTO `partners` (`id`, `name`, `logo`, `website`, `sort_order`, `is_published`, `created_at`) VALUES
	(1, 'Ministère de l\'Agriculture du Cameroun', NULL, 'https://minader.cm', 1, 1, '2026-04-22 00:06:34'),
	(2, 'FAO Cameroun', NULL, 'https://fao.org/cameroon', 2, 1, '2026-04-22 00:06:34'),
	(3, 'IRAD', NULL, 'https://irad-cameroon.org', 3, 1, '2026-04-22 00:06:34');

-- Dumping structure for table istapa.password_resets
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expires_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_token` (`token`),
  KEY `idx_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table istapa.password_resets: ~1 rows (approximately)
DELETE FROM `password_resets`;
INSERT INTO `password_resets` (`id`, `email`, `token`, `expires_at`, `created_at`) VALUES
	(1, 'celine@istapa.site', 'test_reset_token_abc123', '2026-04-22 01:06:34', '2026-04-22 00:06:34');

-- Dumping structure for table istapa.programs
DROP TABLE IF EXISTS `programs`;
CREATE TABLE IF NOT EXISTS `programs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `slug` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cover_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duration_months` int DEFAULT NULL,
  `degree_code` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `degree_name_en` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `degree_name_fr` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `degree_description_en` text COLLATE utf8mb4_unicode_ci,
  `degree_description_fr` text COLLATE utf8mb4_unicode_ci,
  `title_en` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_fr` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description_en` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description_fr` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_en` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_fr` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `view_count` int unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_programs_slug` (`slug`),
  KEY `idx_published` (`is_published`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table istapa.programs: ~12 rows (approximately)
DELETE FROM `programs`;
INSERT INTO `programs` (`id`, `slug`, `cover_image`, `duration_months`, `degree_code`, `degree_name_en`, `degree_name_fr`, `degree_description_en`, `degree_description_fr`, `title_en`, `title_fr`, `short_description_en`, `short_description_fr`, `content_en`, `content_fr`, `is_published`, `sort_order`, `view_count`, `created_at`, `updated_at`) VALUES
	(1, 'hnd-production-animale', NULL, 24, 'BTS_HND', 'BTS / HND', 'BTS / HND', 'A two-year professional diploma (Brevet de Technicien Supérieur / Higher National Diploma) combining theory with hands-on practice, preparing graduates for immediate entry into technical and field roles.', 'Un diplôme professionnel de deux ans (Brevet de Technicien Supérieur / Higher National Diploma) combinant théorie et pratique de terrain, préparant les diplômés à une insertion immédiate dans des postes techniques.', 'Animal Production', 'Production Animale', 'Scientific and technical skills for sustainable livestock farming and food security.', 'Compétences scientifiques et techniques pour un élevage durable et la sécurité alimentaire.', '<h2>Program Overview</h2><p>Higher education in Animal Production equips students with scientific, technical and entrepreneurial skills. Career opportunities span the public sector, private agribusiness, NGOs and academia, with strong prospects in commercial farming, food security and sustainable livestock systems.</p><h3>Program Highlights</h3><ul><li><strong>Hands-on training:</strong> students train on experimental farms, ranches and in laboratories.</li><li><strong>Research-driven:</strong> universities and institutes collaborate with IRAD.</li><li><strong>Technology integration:</strong> courses in biotechnology, artificial insemination and feed formulation.</li><li><strong>Sustainability focus:</strong> emphasis on climate-smart livestock systems and animal welfare.</li></ul><h3>Program Content</h3><ul><li>Animal science and zootechnics</li><li>Animal physiology, nutrition and genetics</li><li>Livestock production systems (cattle, poultry, pigs, small ruminants)</li><li>Pasture and forage management</li><li>Fundamentals of animal and veterinary health</li><li>Breeding and biotechnology</li><li>Livestock production technology and related fields</li><li>Animal-based agro-industry</li></ul><h3>Career Opportunities</h3><p><strong>Public sector:</strong> Ministry of Livestock, Fisheries and Animal Industries (MINEPIA), IRAD, municipal councils.</p><p><strong>Private sector:</strong> agribusiness startups in poultry, aquaculture and small ruminants; agropastoral farms (cattle, poultry, piggeries, fish farming); animal feed plants and veterinary pharmaceutical companies; meat and dairy processing industries.</p><p><strong>NGOs and international organizations:</strong> FAO, GIZ, World Bank, IFAD, NGOs promoting sustainable livestock farming and rural livelihoods.</p><p><strong>Academia and research:</strong> teaching and research positions in universities and agropastoral colleges; doctoral opportunities in animal genetics, nutrition and production systems.</p><h3>Outlook</h3><ul><li>The livestock sector contributes significantly to GDP and rural employment.</li><li>Growing demand for animal protein (meat, milk, eggs) driven by population growth.</li><li>Expansion of commercial poultry and pig farms around urban centers.</li><li>Strong prospects in aquaculture and integrated crop-livestock systems.</li><li>Emerging opportunities in animal biotechnology, food innovation and climate-resilient livestock systems.</li></ul>', '<h2>Présentation du programme</h2><p>L\'enseignement supérieur en Production Animale dote les étudiants de compétences scientifiques, techniques et entrepreneuriales. Les opportunités de carrière couvrent le secteur public, l\'agro-industrie privée, les ONG et le milieu universitaire, avec de solides perspectives dans l\'agriculture commerciale, la sécurité alimentaire et les systèmes d\'élevage durables.</p><h3>Points forts du programme</h3><ul><li><strong>Orientation pratique:</strong> les étudiants se forment dans des fermes expérimentales, des ranchs et des laboratoires.</li><li><strong>Axé sur la recherche:</strong> les universités et instituts collaborent avec l\'IRAD.</li><li><strong>Intégration technologique:</strong> cours en biotechnologie, insémination artificielle et formulation d\'aliments.</li><li><strong>Focus sur la durabilité:</strong> accent mis sur les systèmes d\'élevage intelligents face au climat et le bien-être animal.</li></ul><h3>Contenu du programme</h3><ul><li>Sciences animales et zootechnie</li><li>Physiologie animale, nutrition et génétique</li><li>Systèmes de production animale (bovins, volailles, porcs, petits ruminants)</li><li>Gestion des pâturages et des fourrages</li><li>Bases de la santé animale et vétérinaire</li><li>Sélection et biotechnologie</li><li>Technologie de la production animale et domaines connexes</li><li>Agro-industrie d\'origine animale</li></ul><h3>Débouchés professionnels</h3><p><strong>Secteur public:</strong> Ministère de l\'Élevage, de la Pêche et des Industries Animales (MINEPIA), IRAD, mairies.</p><p><strong>Secteur privé:</strong> startups agroalimentaires dans la volaille, l\'aquaculture et les petits ruminants ; exploitations agropastorales (fermes bovines, volailles, porcheries, pisciculture) ; usines d\'alimentation animale et entreprises pharmaceutiques vétérinaires ; industries de transformation de la viande et des produits laitiers.</p><p><strong>ONG et organisations internationales:</strong> FAO, GIZ, Banque mondiale, FIDA, ONG promouvant l\'élevage durable et les moyens de subsistance ruraux.</p><p><strong>Académie et recherche:</strong> postes d\'enseignement et de recherche dans des universités et collèges agropastoraux ; études doctorales en génétique animale, nutrition et systèmes de production.</p><h3>Perspectives</h3><ul><li>Le secteur de l\'élevage contribue de manière significative au PIB et à l\'emploi rural.</li><li>Demande croissante de protéines animales (viande, lait, œufs) due à la croissance démographique.</li><li>Expansion des fermes commerciales d\'aviculture et de porcs dans les centres urbains.</li><li>Perspectives solides en aquaculture et systèmes intégrés culture-élevage.</li><li>Opportunités émergentes en biotechnologie animale, innovation alimentaire et systèmes d\'élevage résilients au climat.</li></ul>', 1, 1, 101, '2026-04-21 23:06:33', '2026-08-28 14:11:56'),
	(2, 'hnd-production-vegetale', NULL, 24, 'BTS_HND', 'BTS / HND (Level 1)', 'BTS / HND (Niveau 1)', 'A two-year professional diploma (Brevet de Technicien Supérieur / Higher National Diploma) combining theory with hands-on practice, preparing graduates for immediate entry into technical and field roles.', 'Un diplôme professionnel de deux ans (Brevet de Technicien Supérieur / Higher National Diploma) combinant théorie et pratique de terrain, préparant les diplômés à une insertion immédiate dans des postes techniques.', 'Crop Production', 'Production Végétale', 'Modern agricultural, technological and entrepreneurial skills for sustainable farming.', 'Compétences agricoles, technologiques et entrepreneuriales modernes pour une agriculture durable.', '<h2>Program Overview</h2><p>Higher education in Crop Production equips students with modern agricultural, technological and entrepreneurial skills. Career opportunities span government, agribusiness, NGOs and research, with strong prospects in sustainable farming, agro-industry and digital agriculture.</p><h3>Program Highlights</h3><ul><li><strong>Hands-on training:</strong> strong emphasis on fieldwork, experimental farms and internships with agricultural companies.</li><li><strong>Research-driven:</strong> universities run experimental stations on maize, cassava, cocoa, coffee, horticultural crops and more.</li><li><strong>Technology integration:</strong> training in mechanization, irrigation systems and biotechnology.</li><li><strong>Sustainability focus:</strong> climate-smart agriculture, organic farming and conservation practices.</li></ul><h3>Program Content</h3><ul><li>Crop production and soil science</li><li>Plant physiology and genetics</li><li>Soil fertility and crop nutrition</li><li>Irrigation and mechanization technologies</li><li>Integrated pest management</li><li>Sustainable and climate-smart agriculture</li><li>Crop agro-industrial technologies</li><li>Post-harvest technology and agro-industry</li><li>Food processing</li></ul><h3>Career Opportunities</h3><p><strong>Public sector:</strong> Ministry of Agriculture and Rural Development (MINADER), IRAD, municipal councils.</p><p><strong>Private sector:</strong> agribusiness startups, horticulture, greenhouse farming and mechanized crop production; agro-industrial companies; seed and agrochemical firms.</p><p><strong>NGOs and international organizations:</strong> FAO, GIZ, World Bank, IFAD, NGOs promoting sustainable agriculture and climate resilience.</p><p><strong>Academia and research:</strong> teaching and research positions in universities and agricultural colleges; doctoral opportunities in crop science, biotechnology and sustainable agriculture.</p><h3>Outlook</h3><ul><li>Cameroonian agriculture employs over 60% of the population, making crop production technologies central to national development.</li><li>Growing demand for climate-smart and precision agriculture.</li><li>Expansion of agri-food entrepreneurship in horticulture, seed production and food processing.</li><li>Strong prospects in digital agriculture (GIS, drones, AI) for crop monitoring.</li><li>Opportunities in export-oriented crops (cocoa, coffee, banana) and food-security crops (cassava, maize, rice).</li></ul>', '<h2>Présentation du programme</h2><p>L\'enseignement supérieur en Production Végétale dote les étudiants de compétences agricoles, technologiques et entrepreneuriales modernes. Les opportunités de carrière couvrent le gouvernement, l\'agro-industrie, les ONG et la recherche, avec de solides perspectives dans l\'agriculture durable, l\'agro-industrie et l\'agriculture numérique.</p><h3>Points forts du programme</h3><ul><li><strong>Orientation pratique:</strong> fort accent sur le travail de terrain, les exploitations agricoles expérimentales et les stages en entreprises agricoles.</li><li><strong>Axée sur la recherche:</strong> les universités gèrent des stations expérimentales sur le maïs, le manioc, le cacao, le café, les cultures horticoles, etc.</li><li><strong>Intégration technologique:</strong> formation en mécanisation, systèmes d\'irrigation et biotechnologie.</li><li><strong>Orientation durable:</strong> agriculture intelligente face au climat, agriculture biologique et pratiques de conservation.</li></ul><h3>Contenu du programme</h3><ul><li>Production agricole et science du sol</li><li>Physiologie et génétique des plantes</li><li>Fertilité des sols et nutrition des cultures</li><li>Technologies d\'irrigation et de mécanisation</li><li>Gestion intégrée des nuisibles</li><li>Agriculture durable et agriculture respectueuse du climat</li><li>Technologies agro-industrielles des cultures</li><li>Technologie post-récolte et agro-industrie</li><li>Transformation alimentaire</li></ul><h3>Débouchés professionnels</h3><p><strong>Secteur public:</strong> Ministère de l\'Agriculture et du Développement Rural (MINADER), IRAD, communes.</p><p><strong>Secteur privé:</strong> startups agroalimentaires, horticulture, agriculture sous serre et production mécanisée ; entreprises agro-industrielles ; entreprises semencières et agrochimiques.</p><p><strong>ONG et organisations internationales:</strong> FAO, GIZ, Banque mondiale, FIDA, ONG promouvant l\'agriculture durable et la résilience climatique.</p><p><strong>Académie et recherche:</strong> postes d\'enseignement et de recherche dans des universités et collèges agricoles ; études doctorales en sciences des cultures, biotechnologie et agriculture durable.</p><h3>Perspectives</h3><ul><li>L\'agriculture camerounaise emploie plus de 60 % de la population, faisant des technologies de production agricole un pilier central du développement national.</li><li>Demande croissante pour une agriculture respectueuse du climat et de précision.</li><li>Expansion de l\'entrepreneuriat agroalimentaire dans l\'horticulture, la production de semences et la transformation.</li><li>Perspectives solides dans l\'agriculture numérique (SIG, drones, IA) pour le suivi des cultures.</li><li>Opportunités dans les cultures d\'exportation (cacao, café, banane) et les cultures vivrières stratégiques (manioc, maïs, riz).</li></ul>', 1, 2, 53, '2026-04-21 23:06:33', '2026-08-28 05:47:12'),
	(3, 'hnd-environment', NULL, 24, 'BTS_HND', 'BTS / HND (Level 1)', 'BTS / HND (Niveau 1)', 'A two-year professional diploma (Brevet de Technicien Supérieur / Higher National Diploma) combining theory with hands-on practice, preparing graduates for immediate entry into technical and field roles.', 'Un diplôme professionnel de deux ans (Brevet de Technicien Supérieur / Higher National Diploma) combinant théorie et pratique de terrain, préparant les diplômés à une insertion immédiate dans des postes techniques.', 'Environmental Management', 'Gestion Environnementale', 'Technical and policy skills for climate resilience and sustainable development.', 'Compétences techniques et politiques pour la résilience climatique et le développement durable.', '<h2>Program Overview</h2><p>Higher education in Environmental Management equips students with technical and policy-oriented skills. Career opportunities span government, private industry, NGOs and academia, with strong prospects in climate resilience, green innovation and sustainable development.</p><h3>Program Highlights</h3><ul><li><strong>Multidisciplinary approach:</strong> combines ecology, economics, law and engineering for holistic environmental solutions.</li><li><strong>Applied learning:</strong> fieldwork, laboratory analysis and internships with NGOs and government agencies.</li><li><strong>Policy integration:</strong> strong emphasis on environmental legislation and sustainable development frameworks.</li><li><strong>Research orientation:</strong> students take part in projects on deforestation, waste recycling and renewable energy.</li><li><strong>International collaboration:</strong> partnerships with organizations such as WWF, UNDP, GIZ, FAO and the World Bank for training and research support.</li></ul><h3>Program Content</h3><ul><li>Environmental law and policy</li><li>Waste management and pollution control</li><li>Climate change adaptation and mitigation</li><li>Sustainable development and natural resource management</li><li>Sustainable agriculture</li><li>Ecology and biodiversity conservation</li><li>Pollution control</li><li>GIS and environmental data analysis</li><li>Environmental and social impact assessment</li></ul><h3>Career Opportunities</h3><p><strong>Public sector:</strong> Ministry of Environment, Nature Protection and Sustainable Development (MINEPDED), Ministry of Agriculture and Rural Development (MINADER), municipal councils.</p><p><strong>Private sector:</strong> environmental consulting firms (ESIA, audit and compliance), corporate sustainability departments, renewable energy and waste recycling companies.</p><p><strong>NGOs and international organizations:</strong> WWF, UNDP, GIZ, FAO and World Bank on conservation and climate resilience.</p><p><strong>Academia and research:</strong> teaching and research positions in universities and environmental institutes; doctoral opportunities in environmental science or climate change adaptation.</p><h3>Outlook</h3><ul><li>The environmental management sector is expanding due to national commitments under the Paris Climate Agreement.</li><li>Growth of green economy initiatives and sustainable urban development.</li><li>Rising demand for professionals in climate risk assessment, renewable energy and environmental governance.</li><li>Expected growth areas: environmental data analysis and GIS mapping, circular economy and waste valorization, carbon credits and sustainable finance.</li></ul>', '<h2>Présentation du programme</h2><p>L\'enseignement supérieur en Gestion de l\'Environnement dote les étudiants de compétences techniques et orientées vers les politiques. Les opportunités de carrière couvrent le gouvernement, l\'industrie privée, les ONG et le milieu universitaire, avec de solides perspectives en matière de résilience climatique, d\'innovation verte et de développement durable.</p><h3>Points forts du programme</h3><ul><li><strong>Approche multidisciplinaire:</strong> combine écologie, économie, droit et ingénierie pour des solutions environnementales holistiques.</li><li><strong>Apprentissage appliqué:</strong> travail de terrain, analyse en laboratoire et stages auprès d\'ONG et d\'agences gouvernementales.</li><li><strong>Intégration des politiques:</strong> accent marqué sur la législation environnementale et les cadres de développement durable.</li><li><strong>Orientation recherche:</strong> les étudiants participent à des projets portant sur la déforestation, le recyclage des déchets et les énergies renouvelables.</li><li><strong>Collaboration internationale:</strong> partenariats avec des organisations telles que le WWF, le PNUD, la GIZ, la FAO et la Banque mondiale pour la formation et le soutien à la recherche.</li></ul><h3>Contenu du programme</h3><ul><li>Droit et politique de l\'environnement</li><li>Gestion des déchets et contrôle de la pollution</li><li>Adaptation et atténuation du changement climatique</li><li>Développement durable et gestion des ressources naturelles</li><li>Agriculture durable</li><li>Écologie et conservation de la biodiversité</li><li>Contrôle de la pollution</li><li>SIG et analyse des données environnementales</li><li>Évaluation de l\'impact environnemental et social</li></ul><h3>Débouchés professionnels</h3><p><strong>Secteur public:</strong> Ministère de l\'Environnement, de la Protection de la Nature et du Développement Durable (MINEPDED), Ministère de l\'Agriculture et du Développement Rural (MINADER), conseils municipaux.</p><p><strong>Secteur privé:</strong> bureaux d\'études et de conseil en environnement (EIES, audit et conformité), départements de durabilité d\'entreprise, entreprises d\'énergie renouvelable et de recyclage des déchets.</p><p><strong>ONG et organisations internationales:</strong> WWF, PNUD, GIZ, FAO et Banque mondiale sur la conservation et la résilience climatique.</p><p><strong>Académie et recherche:</strong> postes d\'enseignement et de recherche dans des universités et instituts environnementaux ; études doctorales en sciences de l\'environnement ou adaptation au changement climatique.</p><h3>Perspectives</h3><ul><li>Le secteur de la gestion environnementale s\'étend en raison des engagements nationaux dans le cadre de l\'Accord de Paris sur le climat.</li><li>Croissance des initiatives d\'économie verte et de développement urbain durable.</li><li>Demande croissante de professionnels dans l\'évaluation des risques climatiques, les énergies renouvelables et la gouvernance environnementale.</li><li>Zones de croissance prévues : analyse des données environnementales et cartographie SIG, économie circulaire et valorisation des déchets, crédit carbone et financement durable.</li></ul>', 1, 3, 58, '2026-04-21 23:06:33', '2026-08-28 09:23:56'),
	(4, 'hnd-energies-renouvelables', NULL, 24, 'BTS_HND', 'BTS / HND (Level 1)', 'BTS / HND (Niveau 1)', 'A two-year professional diploma (Brevet de Technicien Supérieur / Higher National Diploma) combining theory with hands-on practice, preparing graduates for immediate entry into technical and field roles.', 'Un diplôme professionnel de deux ans (Brevet de Technicien Supérieur / Higher National Diploma) combinant théorie et pratique de terrain, préparant les diplômés à une insertion immédiate dans des postes techniques.', 'Renewable Energy', 'Énergies Renouvelables', 'Technical, entrepreneurial and policy skills for sustainable electrification.', 'Compétences techniques, entrepreneuriales et politiques pour l\'électrification durable.', '<h2>Program Overview</h2><p>Higher education in Renewable Energy equips students with technical, entrepreneurial and policy skills. Career opportunities span government, private industry, NGOs and academia, with strong prospects in electrification, climate resilience and green innovation. Graduates can pursue careers in the solar, wind, hydropower and bioenergy sectors, with growing opportunities in national and international electrification and sustainable development projects.</p><h3>Program Content</h3><ul><li>Fundamentals of electrical and energy engineering</li><li>Renewable energy technologies</li><li>Solar photovoltaic system design and installation</li><li>Wind energy conversion</li><li>Hydropower energy conversion</li><li>Biomass systems</li><li>Energy efficiency and management</li><li>Environmental sustainability and policy</li><li>Project management and entrepreneurship in green technologies</li><li>Environmental law</li></ul><h3>Career Opportunities</h3><p><strong>Public sector:</strong> Ministry of Water Resources and Energy (MINEE), SONATREL, AER, SONADEL, municipal councils.</p><p><strong>Private sector:</strong> solar and energy startups; engineering consulting firms focused on sustainable infrastructure; construction and industrial companies implementing energy-efficient systems; opportunities in universities and research centers for innovation in renewable technologies.</p><p><strong>NGOs and international organizations:</strong> UNDP, GIZ, World Bank, WWF.</p><p><strong>Academia and research:</strong> teaching and research positions in universities and institutes; doctoral opportunities in renewable energy systems and climate adaptation.</p><h3>Outlook</h3><ul><li>Cameroon\'s renewable energy sector is growing rapidly.</li><li>Growing market for solar installation, energy audit and eco-consulting firms.</li><li>The government aims to reach a 25% share of renewable energy by 2035.</li><li>Increased investment in solar mini-grids and hydropower modernization.</li><li>Regional demand for energy engineers skilled in sustainable technologies.</li></ul>', '<h2>Présentation du programme</h2><p>L\'enseignement supérieur en Énergies Renouvelables dote les étudiants de compétences techniques, entrepreneuriales et politiques. Les opportunités de carrière couvrent le gouvernement, l\'industrie privée, les ONG et le milieu universitaire, avec de solides perspectives en électrification, résilience climatique et innovation verte. Les diplômés peuvent poursuivre des carrières dans les secteurs solaire, éolien, hydroélectrique et bioénergétique, avec des opportunités croissantes dans les projets nationaux et internationaux d\'électrification et de développement durable.</p><h3>Contenu du programme</h3><ul><li>Fondamentaux du génie électrique et énergétique</li><li>Technologies des énergies renouvelables</li><li>Conception et installation de systèmes photovoltaïques solaires</li><li>Conversion de l\'énergie éolienne</li><li>Conversion de l\'énergie hydroélectrique</li><li>Systèmes de biomasse</li><li>Efficacité énergétique et gestion</li><li>Durabilité environnementale et politique</li><li>Gestion de projet et entrepreneuriat dans les technologies vertes</li><li>Droit de l\'environnement</li></ul><h3>Débouchés professionnels</h3><p><strong>Secteur public:</strong> Ministère de l\'Eau et de l\'Énergie (MINEE), SONATREL, AER, SONADEL, mairies.</p><p><strong>Secteur privé:</strong> startups solaires et énergétiques ; cabinets de conseil en ingénierie axés sur les infrastructures durables ; entreprises de construction et industrielles mettant en œuvre des systèmes économes en énergie ; opportunités dans les universités et centres de recherche pour l\'innovation dans les technologies renouvelables.</p><p><strong>ONG et organisations internationales:</strong> PNUD, GIZ, Banque mondiale, WWF.</p><p><strong>Académie et recherche:</strong> postes d\'enseignement et de recherche dans des universités et instituts ; études doctorales en systèmes d\'énergie renouvelable et adaptation au climat.</p><h3>Perspectives</h3><ul><li>Le secteur des énergies renouvelables au Cameroun se développe rapidement.</li><li>Marché en croissance pour les entreprises d\'installation solaire, d\'audit énergétique et d\'éco-conseil.</li><li>Le gouvernement vise à atteindre 25 % de part d\'énergie renouvelable d\'ici 2035.</li><li>Augmentation des investissements dans les mini-réseaux solaires et la modernisation de l\'hydroélectricité.</li><li>Demande régionale d\'ingénieurs énergétiques compétents dans les technologies durables.</li></ul>', 1, 4, 50, '2026-07-17 15:40:23', '2026-08-28 09:51:53'),
	(5, 'hnd-gestion-forestiere', NULL, 24, 'BTS_HND', 'BTS / HND (Level 1)', 'BTS / HND (Niveau 1)', 'A two-year professional diploma (Brevet de Technicien Supérieur / Higher National Diploma) combining theory with hands-on practice, preparing graduates for immediate entry into technical and field roles.', 'Un diplôme professionnel de deux ans (Brevet de Technicien Supérieur / Higher National Diploma) combinant théorie et pratique de terrain, préparant les diplômés à une insertion immédiate dans des postes techniques.', 'Forestry Management', 'Gestion Forestière', 'Technical and policy skills for sustainable forestry and climate resilience.', 'Compétences techniques et politiques pour la foresterie durable et la résilience climatique.', '<h2>Program Overview</h2><p>Higher education in Forestry Management equips students with technical and policy-oriented skills. Graduates can expect careers in the public, industrial, NGO and academic sectors, with growing opportunities in sustainable forestry, climate resilience and green innovation.</p><h3>Program Highlights</h3><ul><li><strong>Multidisciplinary training:</strong> combines forestry, wildlife, environmental science and industrial wood processing.</li><li><strong>Applied fieldwork:</strong> strong emphasis on practical skills: forest inventories, GIS mapping, wildlife monitoring and industrial wood processing.</li><li><strong>Sustainability focus:</strong> integration of climate resilience, ecosystem protection and community forest management.</li><li><strong>Wood technology innovation:</strong> development of bio-based materials, composites and design applications.</li><li><strong>International collaboration:</strong> partnerships with Western universities and organizations such as GIZ and WWF for training and research support.</li></ul><h3>Program Content</h3><ul><li>Forest exploitation</li><li>Wood industry</li><li>Forest ecosystem protection</li><li>Wood technology innovation</li><li>Participatory forest management</li><li>Environmental impact studies</li><li>Forestry and wildlife technology</li><li>Wildlife conservation</li><li>Ecosystem monitoring</li><li>Biodiversity assessment</li><li>Policy analysis</li></ul><h3>Career Opportunities</h3><p><strong>Public sector:</strong> Ministry of Forestry and Wildlife (MINFOF), National Forestry Development Agency (ANAFOR), municipal councils.</p><p><strong>Private sector:</strong> forestry companies, environmental consulting firms, ecotourism and wildlife reserve management.</p><p><strong>NGOs and international organizations:</strong> WWF, FAO, GIZ and World Bank projects on forest conservation and climate adaptation; community forest management initiatives.</p><p><strong>Research and academia:</strong> teaching and research in forestry, biodiversity and sustainable resource management; doctoral opportunities in forestry, climate change or conservation biology.</p><h3>Outlook</h3><ul><li>Cameroon is Central Africa\'s second most forest-rich country, making forestry management a strategic sector.</li><li>Growing demand for sustainable forest certification and eco-friendly wood products.</li><li>Expansion of community forestry projects to empower rural populations.</li><li>Growing role of digital tools (GIS, AI, remote sensing) in forest monitoring.</li><li>Strong prospects in climate change mitigation, carbon markets and biodiversity conservation.</li></ul>', '<h2>Présentation du programme</h2><p>L\'enseignement supérieur en Gestion Forestière dote les étudiants de compétences techniques et orientées politiques. Les diplômés peuvent s\'attendre à des carrières dans le secteur public, industriel, les ONG et le milieu universitaire, avec des opportunités croissantes dans la foresterie durable, la résilience climatique et l\'innovation verte.</p><h3>Points forts du programme</h3><ul><li><strong>Formation multidisciplinaire:</strong> combine la foresterie, la faune, les sciences de l\'environnement et la transformation industrielle du bois.</li><li><strong>Travail de terrain appliqué:</strong> fort accent sur les compétences pratiques : inventaires forestiers, cartographie SIG, suivi de la faune et transformation industrielle du bois.</li><li><strong>Focus sur la durabilité:</strong> intégration de la résilience climatique, de la protection des écosystèmes et de la gestion forestière communautaire.</li><li><strong>Innovation dans la technologie du bois:</strong> développement de matériaux bio-based, composites et applications de conception.</li><li><strong>Collaboration internationale:</strong> partenariats avec des universités occidentales et des organisations telles que GIZ et WWF pour la formation et le soutien à la recherche.</li></ul><h3>Contenu du programme</h3><ul><li>Exploitation forestière</li><li>Industrie du bois</li><li>Protection des écosystèmes forestiers</li><li>Innovation dans la technologie du bois</li><li>Gestion participative des forêts</li><li>Études d\'impact environnemental</li><li>Technologie forestière et faune</li><li>Conservation de la faune</li><li>Surveillance des écosystèmes</li><li>Évaluation de la biodiversité</li><li>Analyse des politiques</li></ul><h3>Débouchés professionnels</h3><p><strong>Secteur public:</strong> Ministère des Forêts et de la Faune (MINFOF), Agence Nationale de Développement Forestier (ANAFOR), mairies.</p><p><strong>Secteur privé:</strong> entreprises forestières, cabinets de conseil environnemental, écotourisme et gestion des réserves fauniques.</p><p><strong>ONG et organisations internationales:</strong> projets du WWF, de la FAO, de la GIZ et de la Banque mondiale sur la conservation des forêts et l\'adaptation au climat ; initiatives de gestion forestière communautaire.</p><p><strong>Recherche et académie:</strong> enseignement et recherche en foresterie, biodiversité et gestion durable des ressources ; études doctorales en foresterie, changement climatique ou biologie de la conservation.</p><h3>Perspectives</h3><ul><li>Le Cameroun est le deuxième pays le plus riche en ressources forestières d\'Afrique centrale, faisant de la gestion forestière un secteur stratégique.</li><li>Demande croissante pour la certification forestière durable et les produits en bois écologiques.</li><li>Expansion des projets forestiers communautaires pour autonomiser les populations rurales.</li><li>Rôle croissant des outils numériques (SIG, IA, télédétection) dans la surveillance forestière.</li><li>Fortes perspectives dans l\'atténuation du changement climatique, les marchés du carbone et la conservation de la biodiversité.</li></ul>', 1, 5, 43, '2026-07-17 15:40:23', '2026-08-28 09:51:53'),
	(6, 'hnd-eaux-assainissement', NULL, 24, 'BTS_HND', 'BTS / HND (Level 1)', 'BTS / HND (Niveau 1)', 'A two-year professional diploma (Brevet de Technicien Supérieur / Higher National Diploma) combining theory with hands-on practice, preparing graduates for immediate entry into technical and field roles.', 'Un diplôme professionnel de deux ans (Brevet de Technicien Supérieur / Higher National Diploma) combinant théorie et pratique de terrain, préparant les diplômés à une insertion immédiate dans des postes techniques.', 'Water and Sanitation', 'Eaux et Assainissement', 'A two-year program on water treatment, distribution systems and sanitation infrastructure management', 'Un programme de deux ans sur le traitement de l\'eau, les systèmes de distribution et la gestion des ', '<h2>Program Overview</h2><p>The HND in Water and Sanitation trains students to design and manage water supply and sanitation systems, critical to public health in Cameroon.</p><h3>What You Will Learn</h3><ul><li><strong>Water Treatment:</strong> purification techniques for safe drinking water.</li><li><strong>Distribution Systems:</strong> piping networks and pumping stations.</li><li><strong>Sanitation Infrastructure:</strong> wastewater treatment and latrine system design.</li></ul><h3>Career Opportunities</h3><p>Graduates can work as water treatment technicians, sanitation project officers, or with NGOs on rural water access programs.</p>', '<h2>Présentation du programme</h2><p>Le BTS Eaux et Assainissement forme les étudiants à concevoir et gérer des systèmes d\'approvisionnement en eau et d\'assainissement, essentiels à la santé publique au Cameroun.</p><h3>Ce que vous allez apprendre</h3><ul><li><strong>Traitement de l\'eau :</strong> techniques de purification pour une eau potable saine.</li><li><strong>Systèmes de distribution :</strong> réseaux de canalisation et stations de pompage.</li><li><strong>Infrastructures d\'assainissement :</strong> traitement des eaux usées et conception de systèmes de latrines.</li></ul><h3>Débouchés professionnels</h3><p>Les diplômés peuvent devenir techniciens en traitement de l\'eau, chargés de projets d\'assainissement, ou travailler avec des ONG sur des programmes d\'accès à l\'eau en milieu rural.</p>', 1, 6, 48, '2026-07-17 15:40:23', '2026-08-28 09:10:43'),
	(7, 'master-production-animale-halieutique', NULL, NULL, 'MASTER', 'Master\'s Degree', 'Master', 'An advanced-level track delivered under the academic supervision of ISABEE (University of Bertoua), open to holders of a first higher-education diploma (DUT, DTS, HND/BTS or Bachelor\'s), leading to an Engineering, Bachelor\'s or Master\'s degree depending on the track and duration chosen.', 'Une filière de niveau avancé dispensée sous la supervision académique de l\'ISABEE (Université de Bertoua), ouverte aux titulaires d\'un premier diplôme de l\'enseignement supérieur (DUT, DTS, HND/BTS ou Licence), menant à un diplôme d\'Ingénieur, de Licence ou de Master selon la filière et la durée choisies.', 'Animal and Fishery Production', 'Production Animale et Halieutique', 'Advanced scientific training in livestock and fish farming, Engineering/Master level.', 'Approfondissement scientifique en élevage et pisciculture, niveau Ingénieur/Master.', '<h2>Program Overview</h2><p>This advanced track builds on the animal and fisheries sciences covered at BTS/HND level, with a focus on research, value-chain management and innovation, training professionals able to design and manage modern, sustainable livestock and aquaculture production systems.</p><h3>Program Content</h3><ul><li>Advanced zootechnics and fisheries science</li><li>Animal genetics and breeding improvement</li><li>Aquaculture and fish-farming systems management</li><li>Nutrition and industrial-scale feed formulation</li><li>Animal health and farm biosecurity</li><li>Economics and management of livestock value chains</li><li>Agropastoral project design and management</li><li>Research methodology</li></ul><h3>Career Opportunities</h3><p><strong>Public sector:</strong> Ministry of Livestock, Fisheries and Animal Industries (MINEPIA), IRAD, technical and management positions.</p><p><strong>Private sector:</strong> technical management of agropastoral and fish farms, meat, dairy and fisheries agro-industry.</p><p><strong>NGOs and international organizations:</strong> FAO, GIZ, World Bank, IFAD on livestock and food security programs.</p><p><strong>Academia and research:</strong> higher education teaching, applied research and doctoral studies in animal science.</p><h3>Outlook</h3><ul><li>Growing demand for professionals able to modernize livestock and aquaculture value chains.</li><li>Expansion of commercial aquaculture in Cameroon.</li><li>Opportunities in processing and value-addition of animal and fisheries products.</li></ul>', '<h2>Présentation du programme</h2><p>Ce cursus avancé approfondit les sciences animales et halieutiques abordées en BTS/HND, avec une orientation recherche, gestion de filière et innovation, en vue de former des cadres capables de concevoir et piloter des systèmes de production animale et aquacole modernes et durables.</p><h3>Contenu du programme</h3><ul><li>Zootechnie et sciences halieutiques avancées</li><li>Génétique et amélioration animale</li><li>Aquaculture et gestion des systèmes piscicoles</li><li>Nutrition et formulation d\'aliments à l\'échelle industrielle</li><li>Santé animale et biosécurité des élevages</li><li>Économie et gestion des filières animales</li><li>Montage et gestion de projets agropastoraux</li><li>Méthodologie de la recherche</li></ul><h3>Débouchés professionnels</h3><p><strong>Secteur public:</strong> Ministère de l\'Élevage, des Pêches et des Industries Animales (MINEPIA), IRAD, postes de cadre technique et de direction.</p><p><strong>Secteur privé:</strong> direction technique d\'exploitations agropastorales et piscicoles, agro-industrie de la viande, du lait et des produits halieutiques.</p><p><strong>ONG et organisations internationales:</strong> FAO, GIZ, Banque mondiale, FIDA sur les programmes d\'élevage et de sécurité alimentaire.</p><p><strong>Académie et recherche:</strong> enseignement supérieur, recherche appliquée et poursuite d\'études doctorales en sciences animales.</p><h3>Perspectives</h3><ul><li>Demande croissante de cadres capables de moderniser les filières animales et aquacoles.</li><li>Développement de l\'aquaculture commerciale au Cameroun.</li><li>Opportunités dans la transformation et la valorisation des produits animaux et halieutiques.</li></ul>', 1, 7, 7, '2026-08-20 10:27:49', '2026-08-28 08:10:06'),
	(8, 'master-production-vegetale', NULL, NULL, 'MASTER', 'Master\'s Degree', 'Master', 'An advanced-level track delivered under the academic supervision of ISABEE (University of Bertoua), open to holders of a first higher-education diploma (DUT, DTS, HND/BTS or Bachelor\'s), leading to an Engineering, Bachelor\'s or Master\'s degree depending on the track and duration chosen.', 'Une filière de niveau avancé dispensée sous la supervision académique de l\'ISABEE (Université de Bertoua), ouverte aux titulaires d\'un premier diplôme de l\'enseignement supérieur (DUT, DTS, HND/BTS ou Licence), menant à un diplôme d\'Ingénieur, de Licence ou de Master selon la filière et la durée choisies.', 'Crop Production', 'Production Végétale', 'Advanced scientific training in crop production, Engineering/Master level.', 'Approfondissement scientifique en production végétale, niveau Ingénieur/Master.', '<h2>Program Overview</h2><p>This advanced track builds on the agronomic sciences covered at BTS/HND level, with a focus on research, value-chain management and innovation, training professionals able to design and manage high-performing, sustainable crop production systems.</p><h3>Program Content</h3><ul><li>Advanced agronomy and plant physiology</li><li>Plant breeding and biotechnology</li><li>Precision and digital agriculture</li><li>Integrated soil and fertility management</li><li>Agro-industry and crop product processing</li><li>Economics and management of agricultural value chains</li><li>Agricultural project design and management</li><li>Research methodology</li></ul><h3>Career Opportunities</h3><p><strong>Public sector:</strong> Ministry of Agriculture and Rural Development (MINADER), IRAD, technical and management positions.</p><p><strong>Private sector:</strong> technical management of farms, agro-industrial, seed and agrochemical companies.</p><p><strong>NGOs and international organizations:</strong> FAO, GIZ, World Bank, IFAD on agricultural and climate resilience programs.</p><p><strong>Academia and research:</strong> higher education teaching, applied research and doctoral studies in crop science.</p><h3>Outlook</h3><ul><li>Growing demand for professionals able to modernize agricultural value chains.</li><li>Rise of precision agriculture and digital tools (GIS, drones, AI).</li><li>Opportunities in export-oriented and food-security value chains.</li></ul>', '<h2>Présentation du programme</h2><p>Ce cursus avancé approfondit les sciences agronomiques abordées en BTS/HND, avec une orientation recherche, gestion de filière et innovation, en vue de former des cadres capables de concevoir et piloter des systèmes de production végétale performants et durables.</p><h3>Contenu du programme</h3><ul><li>Agronomie et physiologie végétale avancées</li><li>Amélioration des plantes et biotechnologie</li><li>Agriculture de précision et agriculture numérique</li><li>Gestion intégrée des sols et de la fertilité</li><li>Agro-industrie et transformation des produits végétaux</li><li>Économie et gestion des filières agricoles</li><li>Montage et gestion de projets agricoles</li><li>Méthodologie de la recherche</li></ul><h3>Débouchés professionnels</h3><p><strong>Secteur public:</strong> Ministère de l\'Agriculture et du Développement Rural (MINADER), IRAD, postes de cadre technique et de direction.</p><p><strong>Secteur privé:</strong> direction technique d\'exploitations agricoles, entreprises agro-industrielles, semencières et agrochimiques.</p><p><strong>ONG et organisations internationales:</strong> FAO, GIZ, Banque mondiale, FIDA sur les programmes agricoles et de résilience climatique.</p><p><strong>Académie et recherche:</strong> enseignement supérieur, recherche appliquée et poursuite d\'études doctorales en sciences des cultures.</p><h3>Perspectives</h3><ul><li>Demande croissante de cadres capables de moderniser les filières agricoles.</li><li>Essor de l\'agriculture de précision et des outils numériques (SIG, drones, IA).</li><li>Opportunités dans les filières d\'exportation et de sécurité alimentaire.</li></ul>', 1, 8, 7, '2026-08-20 10:27:49', '2026-08-28 09:57:40'),
	(9, 'master-agro-industrie-alimentaire', NULL, NULL, 'MASTER', 'Master\'s Degree', 'Master', 'An advanced-level track delivered under the academic supervision of ISABEE (University of Bertoua), open to holders of a first higher-education diploma (DUT, DTS, HND/BTS or Bachelor\'s), leading to an Engineering, Bachelor\'s or Master\'s degree depending on the track and duration chosen.', 'Une filière de niveau avancé dispensée sous la supervision académique de l\'ISABEE (Université de Bertoua), ouverte aux titulaires d\'un premier diplôme de l\'enseignement supérieur (DUT, DTS, HND/BTS ou Licence), menant à un diplôme d\'Ingénieur, de Licence ou de Master selon la filière et la durée choisies.', 'Agro-Food Processing', 'Agro-Industrie Alimentaire', 'Advanced training in food processing and product quality.', 'Formation avancée en transformation agroalimentaire et qualité des produits.', '<h2>Program Overview</h2><p>This track trains professionals able to design, manage and optimize food-processing operations, from raw material to finished product, with a focus on quality, food safety and industrial competitiveness.</p><h3>Program Content</h3><ul><li>Food processing technologies</li><li>Food safety and quality (HACCP)</li><li>Packaging, preservation and conditioning</li><li>Food process engineering</li><li>Food standards and regulation</li><li>Production and supply chain management</li><li>Marketing of agri-food products</li><li>Agro-industrial project design and management</li></ul><h3>Career Opportunities</h3><p><strong>Public sector:</strong> Ministry of Agriculture and Rural Development (MINADER), Ministry of SMEs, quality control and standards bodies.</p><p><strong>Private sector:</strong> food processing units, dairy, milling, brewing and canning industries.</p><p><strong>NGOs and international organizations:</strong> FAO and organizations promoting food security and local value-chain development.</p><p><strong>Entrepreneurship:</strong> founding and managing one\'s own food processing business.</p><h3>Outlook</h3><ul><li>Growing demand for locally processed products to reduce imports.</li><li>Development of agro-industry as a driver of added value for Cameroonian agriculture.</li><li>Opportunities in exporting processed products (cocoa, coffee, fruit, dairy).</li></ul>', '<h2>Présentation du programme</h2><p>Cette filière forme des cadres capables de concevoir, gérer et optimiser des unités de transformation agroalimentaire, de la matière première au produit fini, en intégrant qualité, sécurité sanitaire et compétitivité industrielle.</p><h3>Contenu du programme</h3><ul><li>Technologies de transformation agroalimentaire</li><li>Sécurité sanitaire et qualité des aliments (HACCP)</li><li>Emballage, conservation et conditionnement</li><li>Génie des procédés agroalimentaires</li><li>Normes et réglementation agroalimentaire</li><li>Gestion de production et de la chaîne logistique</li><li>Marketing et commercialisation des produits agroalimentaires</li><li>Montage et gestion de projets agro-industriels</li></ul><h3>Débouchés professionnels</h3><p><strong>Secteur public:</strong> Ministère de l\'Agriculture et du Développement Rural (MINADER), Ministère des Petites et Moyennes Entreprises, organismes de normalisation et de contrôle qualité.</p><p><strong>Secteur privé:</strong> unités de transformation agroalimentaire, industries laitières, meunières, brassicoles et de conserverie.</p><p><strong>ONG et organisations internationales:</strong> FAO et organisations promouvant la sécurité alimentaire et la valorisation des filières locales.</p><p><strong>Entrepreneuriat:</strong> création et gestion de sa propre unité de transformation agroalimentaire.</p><h3>Perspectives</h3><ul><li>Demande croissante de produits transformés localement pour réduire les importations.</li><li>Développement de l\'agro-industrie comme moteur de valeur ajoutée pour l\'agriculture camerounaise.</li><li>Opportunités dans l\'exportation de produits transformés (cacao, café, fruits, produits laitiers).</li></ul>', 1, 9, 9, '2026-08-20 10:27:49', '2026-08-28 09:24:17'),
	(10, 'master-entrepreneuriat-agropastoral', NULL, NULL, 'MASTER', 'Master\'s Degree', 'Master', 'An advanced-level track delivered under the academic supervision of ISABEE (University of Bertoua), open to holders of a first higher-education diploma (DUT, DTS, HND/BTS or Bachelor\'s), leading to an Engineering, Bachelor\'s or Master\'s degree depending on the track and duration chosen.', 'Une filière de niveau avancé dispensée sous la supervision académique de l\'ISABEE (Université de Bertoua), ouverte aux titulaires d\'un premier diplôme de l\'enseignement supérieur (DUT, DTS, HND/BTS ou Licence), menant à un diplôme d\'Ingénieur, de Licence ou de Master selon la filière et la durée choisies.', 'Agro-Pastoral Entrepreneurship', 'Entrepreneuriat Agropastoral', 'Advanced training in launching and managing agropastoral businesses.', 'Formation avancée à la création et à la gestion d\'entreprises agropastorales.', '<h2>Program Overview</h2><p>This track trains professionals and future entrepreneurs able to design, finance and lead viable agropastoral businesses, combining technical agropastoral knowledge with management, finance and marketing skills.</p><h3>Program Content</h3><ul><li>Agropastoral business management</li><li>Business plan development and project design</li><li>Agricultural financing and microfinance</li><li>Marketing of agropastoral products</li><li>Accounting and financial management</li><li>Agropastoral value chains</li><li>Business law and taxation</li><li>Innovation and digital tools in agribusiness</li></ul><h3>Career Opportunities</h3><p><strong>Entrepreneurship:</strong> founding and leading one\'s own agropastoral or agro-industrial business.</p><p><strong>Public sector:</strong> Ministry of Small and Medium-sized Enterprises, Social Economy and Handicrafts, rural entrepreneurship support structures.</p><p><strong>Private sector:</strong> business development consulting, microfinance institutions, agricultural cooperatives.</p><p><strong>NGOs and international organizations:</strong> rural entrepreneurship and financial inclusion programs (GIZ, IFAD, World Bank).</p><h3>Outlook</h3><ul><li>Growth of agribusiness and agri-food startups in Cameroon.</li><li>Increasing access to financing for young agropastoral entrepreneurs.</li><li>Demand for management skills to structure still-informal value chains.</li></ul>', '<h2>Présentation du programme</h2><p>Cette filière forme des cadres et futurs entrepreneurs capables de concevoir, financer et diriger des entreprises agropastorales viables, en combinant compétences techniques agro-pastorales et compétences de gestion, de finance et de commercialisation.</p><h3>Contenu du programme</h3><ul><li>Gestion d\'entreprise agropastorale</li><li>Business plan et montage de projets</li><li>Financement et microfinance agricole</li><li>Marketing et commercialisation des produits agropastoraux</li><li>Comptabilité et gestion financière</li><li>Chaînes de valeur agropastorales</li><li>Droit des affaires et fiscalité</li><li>Innovation et numérique en agrobusiness</li></ul><h3>Débouchés professionnels</h3><p><strong>Entrepreneuriat:</strong> création et direction de sa propre entreprise agropastorale ou agro-industrielle.</p><p><strong>Secteur public:</strong> Ministère des Petites et Moyennes Entreprises, de l\'Économie Sociale et de l\'Artisanat, structures d\'appui à l\'entrepreneuriat rural.</p><p><strong>Secteur privé:</strong> conseil en développement d\'entreprise, institutions de microfinance, coopératives agricoles.</p><p><strong>ONG et organisations internationales:</strong> programmes d\'appui à l\'entrepreneuriat rural et à l\'inclusion financière (GIZ, FIDA, Banque mondiale).</p><h3>Perspectives</h3><ul><li>Essor de l\'agrobusiness et des start-ups agroalimentaires au Cameroun.</li><li>Accès croissant au financement pour les jeunes entrepreneurs agropastoraux.</li><li>Demande de compétences en gestion pour structurer des filières encore informelles.</li></ul>', 1, 10, 9, '2026-08-20 10:27:49', '2026-08-28 09:04:21'),
	(11, 'master-gestion-environnementale', NULL, NULL, 'MASTER', 'Master\'s Degree', 'Master', 'An advanced-level track delivered under the academic supervision of ISABEE (University of Bertoua), open to holders of a first higher-education diploma (DUT, DTS, HND/BTS or Bachelor\'s), leading to an Engineering, Bachelor\'s or Master\'s degree depending on the track and duration chosen.', 'Une filière de niveau avancé dispensée sous la supervision académique de l\'ISABEE (Université de Bertoua), ouverte aux titulaires d\'un premier diplôme de l\'enseignement supérieur (DUT, DTS, HND/BTS ou Licence), menant à un diplôme d\'Ingénieur, de Licence ou de Master selon la filière et la durée choisies.', 'Environmental Management', 'Gestion Environnementale', 'Advanced training in environmental management and climate governance.', 'Approfondissement en gestion environnementale et gouvernance climatique.', '<h2>Program Overview</h2><p>This advanced track builds on the environmental management covered at BTS/HND level, with a focus on research, public policy and governance, training professionals able to lead complex environmental and climate strategies.</p><h3>Program Content</h3><ul><li>Environmental governance and public policy</li><li>Advanced environmental and social impact assessment</li><li>Environmental economics and climate finance</li><li>Climate risk management and adaptation</li><li>Advanced GIS and remote sensing</li><li>Circular economy and waste management</li><li>Environmental project design and management</li><li>Research methodology</li></ul><h3>Career Opportunities</h3><p><strong>Public sector:</strong> Ministry of Environment, Nature Protection and Sustainable Development (MINEPDED), management positions.</p><p><strong>Private sector:</strong> leadership of environmental consulting firms, corporate sustainability departments.</p><p><strong>NGOs and international organizations:</strong> WWF, UNDP, GIZ, FAO, World Bank on conservation and climate resilience.</p><p><strong>Academia and research:</strong> higher education teaching, research and doctoral studies in environmental science.</p><h3>Outlook</h3><ul><li>Strengthening of national and international climate policies.</li><li>Growing demand for professionals in environmental governance and climate finance.</li><li>Development of carbon markets and the circular economy.</li></ul>', '<h2>Présentation du programme</h2><p>Ce cursus avancé approfondit la gestion environnementale abordée en BTS/HND, avec une orientation recherche, politique publique et gouvernance, en vue de former des cadres capables de piloter des stratégies environnementales et climatiques complexes.</p><h3>Contenu du programme</h3><ul><li>Gouvernance environnementale et politiques publiques</li><li>Évaluation environnementale et sociale approfondie</li><li>Économie de l\'environnement et finance climatique</li><li>Gestion des risques climatiques et adaptation</li><li>SIG avancé et télédétection</li><li>Économie circulaire et gestion des déchets</li><li>Montage et gestion de projets environnementaux</li><li>Méthodologie de la recherche</li></ul><h3>Débouchés professionnels</h3><p><strong>Secteur public:</strong> Ministère de l\'Environnement, de la Protection de la Nature et du Développement Durable (MINEPDED), postes de cadre et de direction.</p><p><strong>Secteur privé:</strong> direction de bureaux d\'études environnementales, départements de durabilité d\'entreprise.</p><p><strong>ONG et organisations internationales:</strong> WWF, PNUD, GIZ, FAO, Banque mondiale sur la conservation et la résilience climatique.</p><p><strong>Académie et recherche:</strong> enseignement supérieur, recherche et poursuite d\'études doctorales en sciences de l\'environnement.</p><h3>Perspectives</h3><ul><li>Renforcement des politiques climatiques nationales et internationales.</li><li>Demande croissante de cadres en gouvernance environnementale et finance climatique.</li><li>Développement des marchés du carbone et de l\'économie circulaire.</li></ul>', 1, 11, 10, '2026-08-20 10:27:49', '2026-08-28 07:04:03'),
	(12, 'master-energies-renouvelables', NULL, NULL, 'MASTER', 'Master\'s Degree', 'Master', 'An advanced-level track delivered under the academic supervision of ISABEE (University of Bertoua), open to holders of a first higher-education diploma (DUT, DTS, HND/BTS or Bachelor\'s), leading to an Engineering, Bachelor\'s or Master\'s degree depending on the track and duration chosen.', 'Une filière de niveau avancé dispensée sous la supervision académique de l\'ISABEE (Université de Bertoua), ouverte aux titulaires d\'un premier diplôme de l\'enseignement supérieur (DUT, DTS, HND/BTS ou Licence), menant à un diplôme d\'Ingénieur, de Licence ou de Master selon la filière et la durée choisies.', 'Renewable Energy', 'Énergies Renouvelables', 'Advanced training in renewable energy engineering and project management.', 'Approfondissement en ingénierie et gestion de projets énergétiques renouvelables.', '<h2>Program Overview</h2><p>This advanced track builds on the renewable energy technologies covered at BTS/HND level, with a focus on engineering, project management and energy policy, training professionals able to design and lead sustainable electrification projects.</p><h3>Program Content</h3><ul><li>Advanced photovoltaic systems engineering</li><li>Smart grids and mini-grids</li><li>Industrial-scale hydropower and bioenergy</li><li>Energy economics and policy</li><li>Energy project management and financing</li><li>Industrial energy efficiency</li><li>Energy law and regulation</li><li>Research methodology</li></ul><h3>Career Opportunities</h3><p><strong>Public sector:</strong> Ministry of Water Resources and Energy (MINEE), SONATREL, AER, engineering and management positions.</p><p><strong>Private sector:</strong> technical leadership of solar and energy projects, sustainable infrastructure engineering firms.</p><p><strong>NGOs and international organizations:</strong> UNDP, GIZ, World Bank, WWF on sustainable electrification projects.</p><p><strong>Academia and research:</strong> higher education teaching, research and doctoral studies in renewable energy.</p><h3>Outlook</h3><ul><li>National target of 25% renewable energy share by 2035.</li><li>Development of solar mini-grids and hydropower modernization.</li><li>Regional demand for engineers skilled in sustainable energy.</li></ul>', '<h2>Présentation du programme</h2><p>Ce cursus avancé approfondit les technologies des énergies renouvelables abordées en BTS/HND, avec une orientation ingénierie, gestion de projets et politique énergétique, en vue de former des cadres capables de concevoir et piloter des projets d\'électrification durable.</p><h3>Contenu du programme</h3><ul><li>Ingénierie avancée des systèmes photovoltaïques</li><li>Réseaux électriques intelligents et mini-réseaux</li><li>Hydroélectricité et bioénergie à l\'échelle industrielle</li><li>Économie et politique de l\'énergie</li><li>Gestion de projets énergétiques et financement</li><li>Efficacité énergétique industrielle</li><li>Droit et réglementation de l\'énergie</li><li>Méthodologie de la recherche</li></ul><h3>Débouchés professionnels</h3><p><strong>Secteur public:</strong> Ministère de l\'Eau et de l\'Énergie (MINEE), SONATREL, AER, postes d\'ingénieur et de cadre.</p><p><strong>Secteur privé:</strong> direction technique de projets solaires et énergétiques, bureaux d\'ingénierie en infrastructures durables.</p><p><strong>ONG et organisations internationales:</strong> PNUD, GIZ, Banque mondiale, WWF sur les projets d\'électrification durable.</p><p><strong>Académie et recherche:</strong> enseignement supérieur, recherche et poursuite d\'études doctorales en énergies renouvelables.</p><h3>Perspectives</h3><ul><li>Objectif national de 25 % d\'énergie renouvelable d\'ici 2035.</li><li>Développement des mini-réseaux solaires et de la modernisation hydroélectrique.</li><li>Demande régionale d\'ingénieurs qualifiés en énergies durables.</li></ul>', 1, 12, 7, '2026-08-20 10:27:49', '2026-08-28 08:30:17');

-- Dumping structure for table istapa.program_certificates
DROP TABLE IF EXISTS `program_certificates`;
CREATE TABLE IF NOT EXISTS `program_certificates` (
  `program_id` int NOT NULL,
  `certificate_id` int NOT NULL,
  PRIMARY KEY (`program_id`,`certificate_id`),
  KEY `idx_pc_certificate` (`certificate_id`),
  CONSTRAINT `fk_pc_certificate` FOREIGN KEY (`certificate_id`) REFERENCES `certificates` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_pc_program` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table istapa.program_certificates: ~36 rows (approximately)
DELETE FROM `program_certificates`;
INSERT INTO `program_certificates` (`program_id`, `certificate_id`) VALUES
	(1, 1),
	(2, 1),
	(3, 1),
	(4, 1),
	(5, 1),
	(6, 1),
	(1, 2),
	(2, 2),
	(3, 2),
	(4, 2),
	(5, 2),
	(6, 2),
	(7, 3),
	(8, 3),
	(9, 3),
	(10, 3),
	(11, 3),
	(12, 3),
	(7, 4),
	(8, 4),
	(9, 4),
	(10, 4),
	(11, 4),
	(12, 4),
	(7, 5),
	(8, 5),
	(9, 5),
	(10, 5),
	(11, 5),
	(12, 5),
	(7, 6),
	(8, 6),
	(9, 6),
	(10, 6),
	(11, 6),
	(12, 6);

-- Dumping structure for table istapa.program_images
DROP TABLE IF EXISTS `program_images`;
CREATE TABLE IF NOT EXISTS `program_images` (
  `id` int NOT NULL AUTO_INCREMENT,
  `program_id` int NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alt_en` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alt_fr` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_cover` tinyint(1) NOT NULL DEFAULT '0',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_program_images_program` (`program_id`),
  KEY `idx_program_images_cover` (`program_id`,`is_cover`),
  CONSTRAINT `fk_program_images_program` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table istapa.program_images: ~1 rows (approximately)
DELETE FROM `program_images`;
INSERT INTO `program_images` (`id`, `program_id`, `image_path`, `alt_en`, `alt_fr`, `is_cover`, `sort_order`, `created_at`, `updated_at`) VALUES
	(1, 1, 'programs/gallery/cwr9owBUykTrFNg6VL3gjIIi013VXRbv6kDsrOZJ.jpg', 'Production animal', 'animal production', 0, 1, '2026-08-13 14:50:16', '2026-08-13 14:50:16');

-- Dumping structure for table istapa.program_translations
DROP TABLE IF EXISTS `program_translations`;
CREATE TABLE IF NOT EXISTS `program_translations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `program_id` int NOT NULL,
  `language_code` char(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` text COLLATE utf8mb4_unicode_ci,
  `content` mediumtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_progtrans` (`program_id`,`language_code`),
  KEY `fk_progtrans_lang` (`language_code`),
  CONSTRAINT `fk_progtrans_lang` FOREIGN KEY (`language_code`) REFERENCES `languages` (`code`),
  CONSTRAINT `fk_progtrans_prog` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table istapa.program_translations: ~12 rows (approximately)
DELETE FROM `program_translations`;
INSERT INTO `program_translations` (`id`, `program_id`, `language_code`, `title`, `short_description`, `content`) VALUES
	(19, 1, 'fr', 'Production Animale', 'Formation en élevage moderne.', 'Contenu détaillé du BTS Agriculture.'),
	(20, 1, 'en', 'Animal Production', 'Training in modern livestock management.', 'Detailed content for HND Agriculture.'),
	(21, 2, 'fr', 'Production Végétale', 'Formation en culture des plantes.', 'Contenu détaillé du BTS Agroalimentaire.'),
	(22, 2, 'en', 'Crop Production', 'Training in crop cultivation.', 'Detailed content for HND Agri-Food.'),
	(23, 3, 'fr', 'BTS Environnement', 'Gestion durable de l\'environnement.', 'Contenu détaillé du BTS Environnement.'),
	(24, 3, 'en', 'HND Environmental Science', 'Sustainable environmental management.', 'Detailed content for HND Environment.'),
	(25, 4, 'fr', 'Energies Renouvelables', 'Solutions énergétiques propres.', 'Contenu détaillé du BTS Energies Renouvelables.'),
	(26, 4, 'en', 'Renewable Energy', 'Clean energy solutions.', 'Detailed content for HND Renewable Energy.'),
	(27, 5, 'fr', 'Gestion Forestière', 'Gestion durable des forêts.', 'Contenu détaillé du BTS Gestion Forestière.'),
	(28, 5, 'en', 'Forestry Management', 'Sustainable forest management.', 'Detailed content for HND Forestry Management.'),
	(29, 6, 'fr', 'Eaux et Assainissement', 'Traitement de l\'eau et assainissement.', 'Contenu détaillé du BTS Eaux et Assainissement.'),
	(30, 6, 'en', 'Water and Sanitation', 'Water treatment and sanitation.', 'Detailed content for HND Water and Sanitation.');

-- Dumping structure for procedure istapa.record_monthly_views_istapa
DROP PROCEDURE IF EXISTS `record_monthly_views_istapa`;
DELIMITER //
CREATE PROCEDURE `record_monthly_views_istapa`()
BEGIN
    DECLARE cur_year  INT DEFAULT YEAR(CURDATE());
    DECLARE cur_month INT DEFAULT MONTH(CURDATE());

    -- Articles de blog
    INSERT INTO monthly_views_stats
        (item_type, item_id, year, month, cumulative_views, month_views)
    SELECT
        'blog_post',
        b.id,
        cur_year,
        cur_month,
        b.view_count,
        GREATEST(b.view_count - COALESCE((
            SELECT m.cumulative_views
            FROM monthly_views_stats m
            WHERE m.item_type = 'blog_post'
              AND m.item_id   = b.id
            ORDER BY m.year DESC, m.month DESC
            LIMIT 1
        ), 0), 0)
    FROM blog_posts b
    ON DUPLICATE KEY UPDATE
        cumulative_views = VALUES(cumulative_views),
        month_views       = VALUES(month_views),
        recorded_at       = CURRENT_TIMESTAMP;

    -- Programmes
    INSERT INTO monthly_views_stats
        (item_type, item_id, year, month, cumulative_views, month_views)
    SELECT
        'program',
        p.id,
        cur_year,
        cur_month,
        p.view_count,
        GREATEST(p.view_count - COALESCE((
            SELECT m.cumulative_views
            FROM monthly_views_stats m
            WHERE m.item_type = 'program'
              AND m.item_id   = p.id
            ORDER BY m.year DESC, m.month DESC
            LIMIT 1
        ), 0), 0)
    FROM programs p
    ON DUPLICATE KEY UPDATE
        cumulative_views = VALUES(cumulative_views),
        month_views       = VALUES(month_views),
        recorded_at       = CURRENT_TIMESTAMP;
END//
DELIMITER ;

-- Dumping structure for table istapa.site_pages
DROP TABLE IF EXISTS `site_pages`;
CREATE TABLE IF NOT EXISTS `site_pages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_page_slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table istapa.site_pages: ~4 rows (approximately)
DELETE FROM `site_pages`;
INSERT INTO `site_pages` (`id`, `slug`, `is_published`) VALUES
	(1, 'about', 1),
	(2, 'mission', 1),
	(3, 'terms', 1),
	(4, 'privacy', 1);

-- Dumping structure for table istapa.site_page_translations
DROP TABLE IF EXISTS `site_page_translations`;
CREATE TABLE IF NOT EXISTS `site_page_translations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `site_page_id` int NOT NULL,
  `language_code` char(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_description` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_spt` (`site_page_id`,`language_code`),
  KEY `fk_spt_lang` (`language_code`),
  CONSTRAINT `fk_spt_lang` FOREIGN KEY (`language_code`) REFERENCES `languages` (`code`),
  CONSTRAINT `fk_spt_page` FOREIGN KEY (`site_page_id`) REFERENCES `site_pages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table istapa.site_page_translations: ~8 rows (approximately)
DELETE FROM `site_page_translations`;
INSERT INTO `site_page_translations` (`id`, `site_page_id`, `language_code`, `title`, `content`, `meta_description`) VALUES
	(1, 1, 'fr', 'À propos de l\'ISTAPA', 'L\'ISTAPA est un institut supérieur de technologie agricole situé à Yaoundé, Cameroun. Fondé pour former les techniciens agricoles de demain.', 'Découvrez l\'ISTAPA, ses missions et ses valeurs.'),
	(2, 1, 'en', 'About ISTAPA', 'ISTAPA is a higher institute of agricultural technology located in Yaoundé, Cameroon. Founded to train tomorrow\'s agricultural technicians.', 'Discover ISTAPA, its missions and values.'),
	(3, 2, 'fr', 'Notre Mission', 'Former des techniciens supérieurs compétents, capables de contribuer au développement agricole durable du Cameroun et de l\'Afrique.', 'La mission de l\'ISTAPA en matière de formation agricole.'),
	(4, 2, 'en', 'Our Mission', 'To train competent higher technicians capable of contributing to the sustainable agricultural development of Cameroon and Africa.', 'ISTAPA mission in agricultural training.'),
	(5, 3, 'fr', 'Conditions d\'utilisation', 'Les présentes conditions régissent l\'utilisation du portail étudiant de l\'ISTAPA.', 'Conditions d\'utilisation du portail ISTAPA.'),
	(6, 3, 'en', 'Terms of Use', 'These terms govern the use of the ISTAPA student portal.', 'ISTAPA portal terms of use.'),
	(7, 4, 'fr', 'Politique de confidentialité', 'L\'ISTAPA s\'engage à protéger les données personnelles de ses utilisateurs.', 'Politique de confidentialité de l\'ISTAPA.'),
	(8, 4, 'en', 'Privacy Policy', 'ISTAPA is committed to protecting the personal data of its users.', 'ISTAPA privacy policy.');

-- Dumping structure for table istapa.site_settings
DROP TABLE IF EXISTS `site_settings`;
CREATE TABLE IF NOT EXISTS `site_settings` (
  `setting_key` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `setting_value` text COLLATE utf8mb4_unicode_ci,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table istapa.site_settings: ~7 rows (approximately)
DELETE FROM `site_settings`;
INSERT INTO `site_settings` (`setting_key`, `setting_value`, `updated_at`) VALUES
	('contact_address', 'Douala, Cameroun', '2026-04-21 13:39:42'),
	('contact_email', 'contact@istapa.site', '2026-04-21 13:39:42'),
	('contact_phone', '', '2026-04-21 13:39:42'),
	('facebook_url', '', '2026-04-21 13:39:42'),
	('linkedin_url', '', '2026-04-21 13:39:42'),
	('school_name', 'ISTAPA', '2026-04-21 13:39:42'),
	('youtube_url', '', '2026-04-21 13:39:42');

-- Dumping structure for table istapa.students
DROP TABLE IF EXISTS `students`;
CREATE TABLE IF NOT EXISTS `students` (
  `user_id` bigint unsigned NOT NULL,
  `matricule` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enrollment_date` date DEFAULT NULL,
  `guardian_name` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guardian_phone` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guardian_email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `blood_group` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `medical_notes` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `uq_students_matricule` (`matricule`),
  CONSTRAINT `fk_students_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table istapa.students: ~22 rows (approximately)
DELETE FROM `students`;
INSERT INTO `students` (`user_id`, `matricule`, `enrollment_date`, `guardian_name`, `guardian_phone`, `guardian_email`, `blood_group`, `medical_notes`) VALUES
	(2, 'IS241004', '2024-09-01', NULL, NULL, NULL, NULL, NULL),
	(3, 'IS241003', '2024-09-01', NULL, NULL, NULL, NULL, NULL),
	(4, 'IS241007', '2024-09-01', NULL, NULL, NULL, NULL, NULL),
	(5, 'IS241002', '2024-09-01', NULL, NULL, NULL, NULL, NULL),
	(6, 'IS241008', '2024-09-01', NULL, NULL, NULL, NULL, NULL),
	(7, 'IS241001', '2024-09-01', NULL, NULL, NULL, NULL, NULL),
	(8, 'IS241006', '2024-09-01', NULL, NULL, NULL, NULL, NULL),
	(9, 'IS241009', '2024-09-01', NULL, NULL, NULL, NULL, NULL),
	(10, 'IS241005', '2024-09-01', NULL, NULL, NULL, NULL, NULL),
	(25, 'ISTF251002', '2025-09-15', NULL, '677377160', NULL, NULL, NULL),
	(26, 'ISTF251001', '2025-09-15', NULL, '697307262', NULL, NULL, NULL),
	(27, 'IST251001', '2025-09-16', NULL, NULL, NULL, NULL, NULL),
	(28, '001', '2025-09-16', NULL, NULL, NULL, NULL, NULL),
	(29, 'ISTF251003', '2025-09-30', NULL, NULL, NULL, NULL, NULL),
	(31, 'ISTF251004', '2025-10-13', NULL, NULL, NULL, NULL, NULL),
	(32, 'ISTF251005', '2025-10-13', NULL, NULL, NULL, NULL, NULL),
	(33, 'ISTE251002', '2025-10-13', NULL, NULL, NULL, NULL, NULL),
	(34, 'ISTF251006', '2025-10-13', NULL, NULL, NULL, NULL, NULL),
	(35, 'IST261001', '2025-10-13', NULL, NULL, NULL, NULL, NULL),
	(36, 'ISTE261003', '2025-10-13', NULL, NULL, NULL, NULL, NULL),
	(37, 'ISTF261007', '2025-10-14', NULL, '655969742', NULL, NULL, NULL),
	(38, 'ISTF261008', '2025-10-14', NULL, '695796402', NULL, NULL, NULL),
	(39, 'IST26-001', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(40, 'IST26-002', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(41, 'IST26-003', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(42, 'IST26-004', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(43, 'IST26-005', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(44, 'IST26-006', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(45, 'IST26-007', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(46, 'IST26-008', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(47, 'IST26-009', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(48, 'IST26-010', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(49, 'IST26-011', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(50, 'IST26-012', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(51, 'IST26-013', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(52, 'IST26-014', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(53, 'IST26-015', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(54, 'IST26-016', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(55, 'IST26-017', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(56, 'IST26-018', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(57, 'IST26-019', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(58, 'IST26-020', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(59, 'IST26-021', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(60, 'IST26-022', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(61, 'IST26-023', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(62, 'IST26-024', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(63, 'IST26-025', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(64, 'IST26-026', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(65, 'IST26-027', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(66, 'IST26-028', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(67, 'IST26-029', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(68, 'IST26-030', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(69, 'IST26-031', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(70, 'IST26-032', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(71, 'IST26-033', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(72, 'IST26-034', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(73, 'IST26-035', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(74, 'IST26-036', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(75, 'IST26-037', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(76, 'IST26-038', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(77, 'IST26-039', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(78, 'IST26-040', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(79, 'IST26-041', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(80, 'IST26-042', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(81, 'IST26-043', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(82, 'IST26-044', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(83, 'IST26-045', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(84, 'IST26-046', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(85, 'IST26-047', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(86, 'IST26-048', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(87, 'IST26-049', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(88, 'IST26-050', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(89, 'IST26-051', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(90, 'IST26-052', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(91, 'IST26-053', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(92, 'IST26-054', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(93, 'IST26-055', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(94, 'IST26-056', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(95, 'IST26-057', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(96, 'IST26-058', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(97, 'IST26-059', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(98, 'IST26-060', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(99, 'IST26-061', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(100, 'IST26-062', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(101, 'IST26-063', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(102, 'IST26-064', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(103, 'IST26-065', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(104, 'IST26-066', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(105, 'IST26-067', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(106, 'IST26-068', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(107, 'IST26-069', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(108, 'IST26-070', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(109, 'IST26-071', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(110, 'IST26-072', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(111, 'IST26-073', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(112, 'IST26-074', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(113, 'IST26-075', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(114, 'IST26-076', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(115, 'IST26-077', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(116, 'IST26-078', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(117, 'IST26-079', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(118, 'IST26-080', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(119, 'IST26-081', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(120, 'IST26-082', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(121, 'IST26-083', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(122, 'IST26-084', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(123, 'IST26-085', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(124, 'IST26-086', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(125, 'IST26-087', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(126, 'IST26-088', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(127, 'IST26-089', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(128, 'IST26-090', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(129, 'IST26-091', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(130, 'IST26-092', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(131, 'IST26-093', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(132, 'IST26-094', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(133, 'IST26-095', '2026-09-01', NULL, NULL, NULL, NULL, NULL),
	(134, 'IST26-096', '2026-09-01', NULL, NULL, NULL, NULL, NULL);

-- Dumping structure for table istapa.subjects
DROP TABLE IF EXISTS `subjects`;
CREATE TABLE IF NOT EXISTS `subjects` (
  `id` int NOT NULL AUTO_INCREMENT,
  `class_id` int NOT NULL,
  `teacher_id` bigint unsigned DEFAULT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coefficient` decimal(4,2) NOT NULL DEFAULT '1.00',
  `hours_per_week` int DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_class` (`class_id`),
  KEY `idx_teacher` (`teacher_id`),
  CONSTRAINT `fk_subj_class` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_subj_teacher` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`user_id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=146 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table istapa.subjects: ~130 rows (approximately)
DELETE FROM `subjects`;
INSERT INTO `subjects` (`id`, `class_id`, `teacher_id`, `name`, `code`, `coefficient`, `hours_per_week`, `description`, `created_at`) VALUES
	(1, 2, 18, 'Biologie végétale', 'BV201', 2.00, 4, NULL, '2026-04-22 00:06:33'),
	(2, 2, 19, 'Agroforesterie', 'AF201', 2.00, 3, NULL, '2026-04-22 00:06:33'),
	(3, 2, 21, 'Économie rurale', 'ER201', 1.50, 2, NULL, '2026-04-22 00:06:33'),
	(4, 2, 18, 'Phytopathologie', 'PP201', 2.00, 3, NULL, '2026-04-22 00:06:33'),
	(5, 2, 19, 'Hydraulique agricole', 'HA201', 1.50, 2, NULL, '2026-04-22 00:06:33'),
	(6, 2, 20, 'Informatique agricole', 'IA201', 1.00, 2, NULL, '2026-04-22 00:06:33'),
	(7, 2, 17, 'Agronomie générale', 'AG201', 2.00, 4, NULL, '2026-04-22 00:06:33'),
	(8, 2, 21, 'Gestion d\'exploitation', 'GE201', 2.00, 3, NULL, '2026-04-22 00:06:33'),
	(9, 2, 18, 'Pédologie', 'PE201', 1.50, 2, NULL, '2026-04-22 00:06:33'),
	(10, 2, 19, 'Techniques d\'irrigation', 'TI201', 1.50, 2, NULL, '2026-04-22 00:06:33'),
	(11, 1, 17, 'Introduction à l\'agronomie', 'AG101', 2.00, 4, NULL, '2026-04-22 00:06:33'),
	(12, 1, 18, 'Botanique', 'BO101', 2.00, 3, NULL, '2026-04-22 00:06:33'),
	(13, 1, 21, 'Économie générale', 'EG101', 1.50, 2, NULL, '2026-04-22 00:06:33'),
	(14, 1, 19, 'Écologie', 'EC101', 2.00, 3, NULL, '2026-04-22 00:06:33'),
	(15, 1, 20, 'Informatique de base', 'IB101', 1.00, 2, NULL, '2026-04-22 00:06:33'),
	(16, 3, 21, 'Gestion environnementale', 'ENV101', 2.00, 4, NULL, '2026-04-22 00:06:33'),
	(17, 3, 18, 'Biologie environnementale', 'BE101', 2.00, 3, NULL, '2026-04-22 00:06:33'),
	(18, 3, 19, 'Cartographie', 'CA101', 1.50, 2, NULL, '2026-04-22 00:06:33'),
	(19, 15, 20, 'Physique et chimie', 'PAN111', 4.00, 4, NULL, '2026-08-28 11:49:18'),
	(20, 15, 21, 'Mathématiques et TIC', 'PAN112', 5.00, 5, NULL, '2026-08-28 11:49:18'),
	(21, 15, 17, 'Ecologie appliquée et environnement', 'PAN113', 4.00, 4, NULL, '2026-08-28 11:49:18'),
	(22, 15, 18, 'Biologie', 'PAN114', 4.00, 4, NULL, '2026-08-28 11:49:18'),
	(23, 15, 19, 'Connaissances de base en zootechnie', 'PAN115', 5.00, 5, NULL, '2026-08-28 11:49:18'),
	(24, 15, 20, 'Anatomie et physiologie animales', 'PAN116', 5.00, 5, NULL, '2026-08-28 11:49:18'),
	(25, 15, 21, 'Formation Bilingue', 'PAN117', 3.00, 3, NULL, '2026-08-28 11:49:18'),
	(26, 15, 17, 'Biochimie et Microbiologie', 'PAN121', 5.00, 5, NULL, '2026-08-28 11:49:18'),
	(27, 15, 18, 'Statistiques et Probabilités', 'PAN122', 4.00, 4, NULL, '2026-08-28 11:49:18'),
	(28, 15, 19, 'Agro-climatologie', 'PAN123', 4.00, 4, NULL, '2026-08-28 11:49:18'),
	(29, 15, 20, 'Biosécurité et prophylaxie animale', 'PAN124', 5.00, 5, NULL, '2026-08-28 11:49:18'),
	(30, 15, 21, 'Nutrition animale', 'PAN125', 5.00, 5, NULL, '2026-08-28 11:49:18'),
	(31, 15, 17, 'Marchés et filières agricoles', 'PAN126', 4.00, 4, NULL, '2026-08-28 11:49:18'),
	(32, 15, 18, 'Economie et gestion des entreprises', 'PAN127', 3.00, 3, NULL, '2026-08-28 11:49:18'),
	(33, 16, 19, 'Génétique et sélection des espèces animales', 'PAN231', 6.00, 6, NULL, '2026-08-28 11:49:18'),
	(34, 16, 20, 'Commercialisation des produits d\'origine animale', 'PAN232', 3.00, 3, NULL, '2026-08-28 11:49:18'),
	(35, 16, 21, 'Conduite d\'élevage des polygastriques (bovins, ovins, caprins...)', 'PAN233', 5.00, 5, NULL, '2026-08-28 11:49:18'),
	(36, 16, 17, 'Conduite d\'élevage des Volailles', 'PAN234', 5.00, 5, NULL, '2026-08-28 11:49:18'),
	(37, 16, 18, 'Conduite d\'élevage des porcins', 'PAN235', 5.00, 5, NULL, '2026-08-28 11:49:18'),
	(38, 16, 19, 'Topographie appliquée et construction des fermes', 'PAN236', 3.00, 3, NULL, '2026-08-28 11:49:18'),
	(39, 16, 20, 'Education citoyenne et déontologie professionnelle', 'PAN237', 3.00, 3, NULL, '2026-08-28 11:49:18'),
	(40, 16, 21, 'Techniques de transformation, de conditionnement et de conservation', 'PAN241', 4.00, 4, NULL, '2026-08-28 11:49:18'),
	(41, 16, 17, 'Sociologie rurale et vulgarisation agricole', 'PAN242', 5.00, 5, NULL, '2026-08-28 11:49:18'),
	(42, 16, 18, 'Pisciculture et Conduite d\'autres élevages', 'PAN243', 4.00, 4, NULL, '2026-08-28 11:49:18'),
	(43, 16, 19, 'Hygiène et qualité des produits d\'origine animale', 'PAN244', 2.00, 2, NULL, '2026-08-28 11:49:18'),
	(44, 16, 20, 'Mécanisation et équipements / Bâtiments d\'élevage', 'PAN245', 4.00, 4, NULL, '2026-08-28 11:49:18'),
	(45, 16, 21, 'Stage professionnel', 'PAN246', 6.00, 6, NULL, '2026-08-28 11:49:18'),
	(46, 16, 17, 'Entrepreneuriat et Marketing appliqué aux disciplines', 'PAN247', 3.00, 3, NULL, '2026-08-28 11:49:18'),
	(47, 17, 18, 'Physique et chimie', 'PVE111', 4.00, 4, NULL, '2026-08-28 11:49:18'),
	(48, 17, 19, 'Mathématiques et TIC', 'PVE112', 5.00, 5, NULL, '2026-08-28 11:49:18'),
	(49, 17, 20, 'Ecologie appliquée', 'PVE113', 4.00, 4, NULL, '2026-08-28 11:49:18'),
	(50, 17, 21, 'Connaissance de base en production végétale', 'PVE114', 5.00, 5, NULL, '2026-08-28 11:49:18'),
	(51, 17, 17, 'Biologie', 'PVE115', 4.00, 4, NULL, '2026-08-28 11:49:18'),
	(52, 17, 18, 'Pédologie', 'PVE116', 5.00, 5, NULL, '2026-08-28 11:49:18'),
	(53, 17, 19, 'Formation Bilingue', 'PVE117', 3.00, 3, NULL, '2026-08-28 11:49:18'),
	(54, 17, 20, 'Biochimie et Microbiologie', 'PVE121', 5.00, 5, NULL, '2026-08-28 11:49:18'),
	(55, 17, 21, 'Statistiques et Probabilités', 'PVE122', 4.00, 4, NULL, '2026-08-28 11:49:18'),
	(56, 17, 17, 'Agro climatologie', 'PVE123', 4.00, 4, NULL, '2026-08-28 11:49:18'),
	(57, 17, 18, 'Agroforesterie', 'PVE124', 5.00, 5, NULL, '2026-08-28 11:49:18'),
	(58, 17, 19, 'Phytopathologie et défense des cultures', 'PVE125', 6.00, 6, NULL, '2026-08-28 11:49:18'),
	(59, 17, 20, 'Stage monographique', 'PVE126', 3.00, 3, NULL, '2026-08-28 11:49:18'),
	(60, 17, 21, 'Economie et gestion des entreprises', 'PVE127', 3.00, 3, NULL, '2026-08-28 11:49:18'),
	(61, 18, 17, 'Génétique et sélection des espèces végétales', 'PVE231', 6.00, 6, NULL, '2026-08-28 11:49:18'),
	(62, 18, 18, 'Fertilité et Fertilisation', 'PVE232', 3.00, 3, NULL, '2026-08-28 11:49:18'),
	(63, 18, 19, 'Conduite durable des productions végétales', 'PVE233', 6.00, 6, NULL, '2026-08-28 11:49:18'),
	(64, 18, 20, 'Horticulture maraîchère et ornementale', 'PVE234', 5.00, 5, NULL, '2026-08-28 11:49:18'),
	(65, 18, 21, 'Cultures pérennes', 'PVE235', 4.00, 4, NULL, '2026-08-28 11:49:18'),
	(66, 18, 17, 'Topographie et Construction rurale', 'PVE236', 3.00, 3, NULL, '2026-08-28 11:49:18'),
	(67, 18, 18, 'Education citoyenne et déontologie professionnelle', 'PVE237', 3.00, 3, NULL, '2026-08-28 11:49:18'),
	(68, 18, 19, 'Marchés et filières agropastorales', 'PVE241', 4.00, 4, NULL, '2026-08-28 11:49:18'),
	(69, 18, 20, 'Sociologie rurale et vulgarisation agricole', 'PVE242', 5.00, 5, NULL, '2026-08-28 11:49:18'),
	(70, 18, 21, 'Systèmes semenciers', 'PVE243', 4.00, 4, NULL, '2026-08-28 11:49:18'),
	(71, 18, 17, 'Techniques de transformation, de conditionnement et de conservation des produits agricoles', 'PVE244', 4.00, 4, NULL, '2026-08-28 11:49:18'),
	(72, 18, 18, 'Mécanisation agropastorale et maintenance des infrastructures, des équipements et des matériels de production', 'PVE245', 4.00, 4, NULL, '2026-08-28 11:49:18'),
	(73, 18, 19, 'Stage professionnel', 'PVE246', 6.00, 6, NULL, '2026-08-28 11:49:18'),
	(74, 18, 20, 'Entrepreneuriat et marketing', 'PVE247', 3.00, 3, NULL, '2026-08-28 11:49:18'),
	(75, 19, 21, 'Mathématiques', 'GEN111', 4.00, 4, NULL, '2026-08-28 11:49:18'),
	(76, 19, 17, 'Economie rurale', 'GEN112', 5.00, 5, NULL, '2026-08-28 11:49:18'),
	(77, 19, 18, 'Topographie et Dessin technique', 'GEN113', 5.00, 5, NULL, '2026-08-28 11:49:18'),
	(78, 19, 19, 'Hydraulique générale', 'GEN114', 4.00, 4, NULL, '2026-08-28 11:49:18'),
	(79, 19, 20, 'Ecosystèmes et Milieux naturels', 'GEN115', 4.00, 4, NULL, '2026-08-28 11:49:18'),
	(80, 19, 21, 'Pollution et Nuisances', 'GEN116', 5.00, 5, NULL, '2026-08-28 11:49:18'),
	(81, 19, 17, 'Formation bilingue', 'GEN117', 3.00, 3, NULL, '2026-08-28 11:49:18'),
	(82, 19, 18, 'Physique', 'GEN121', 4.00, 4, NULL, '2026-08-28 11:49:18'),
	(83, 19, 19, 'Informatique appliquée et multimédia', 'GEN122', 5.00, 5, NULL, '2026-08-28 11:49:18'),
	(84, 19, 20, 'Assainissement I', 'GEN123', 4.00, 4, NULL, '2026-08-28 11:49:18'),
	(85, 19, 21, 'Irrigation', 'GEN124', 4.00, 4, NULL, '2026-08-28 11:49:18'),
	(86, 19, 17, 'Biodiversité', 'GEN125', 4.00, 4, NULL, '2026-08-28 11:49:18'),
	(87, 19, 18, 'Aménagements', 'GEN126', 6.00, 6, NULL, '2026-08-28 11:49:18'),
	(88, 19, 19, 'Economie et Gestion des entreprises', 'GEN127', 3.00, 3, NULL, '2026-08-28 11:49:18'),
	(89, 20, 20, 'Sociologie rurale', 'GEN231', 4.00, 4, NULL, '2026-08-28 11:49:18'),
	(90, 20, 21, 'Vulgarisation rurale', 'GEN232', 5.00, 5, NULL, '2026-08-28 11:49:18'),
	(91, 20, 17, 'Assainissement II', 'GEN233', 5.00, 5, NULL, '2026-08-28 11:49:18'),
	(92, 20, 18, 'Environnement et développement durable', 'GEN234', 5.00, 5, NULL, '2026-08-28 11:49:18'),
	(93, 20, 19, 'Protection des milieux naturels et des paysages', 'GEN235', 5.00, 5, NULL, '2026-08-28 11:49:18'),
	(94, 20, 20, 'Traitement des déchets', 'GEN236', 3.00, 3, NULL, '2026-08-28 11:49:18'),
	(95, 20, 21, 'Education citoyenne et déontologie', 'GEN237', 3.00, 3, NULL, '2026-08-28 11:49:18'),
	(96, 20, 17, 'Géographie économique', 'GEN241', 4.00, 4, NULL, '2026-08-28 11:49:18'),
	(97, 20, 18, 'Pédologie', 'GEN242', 5.00, 5, NULL, '2026-08-28 11:49:18'),
	(98, 20, 19, 'Assainissement III', 'GEN243', 4.00, 4, NULL, '2026-08-28 11:49:18'),
	(99, 20, 20, 'Lutte contre la pollution', 'GEN244', 3.00, 3, NULL, '2026-08-28 11:49:18'),
	(100, 20, 21, 'Projet tutoré', 'GEN245', 5.00, 5, NULL, '2026-08-28 11:49:18'),
	(101, 20, 17, 'Stage professionnel', 'GEN246', 6.00, 6, NULL, '2026-08-28 11:49:18'),
	(102, 20, 18, 'Entrepreneuriat et Marketing appliqué aux disciplines', 'GEN247', 3.00, 3, NULL, '2026-08-28 11:49:18'),
	(103, 21, 19, 'Mathématiques I', 'ENR111', 4.00, 4, NULL, '2026-08-28 11:49:18'),
	(104, 21, 20, 'TIC I', 'ENR112', 5.00, 5, NULL, '2026-08-28 11:49:18'),
	(105, 21, 21, 'Electricité générale et Circuits électriques', 'ENR113', 5.00, 5, NULL, '2026-08-28 11:49:18'),
	(106, 21, 17, 'Machine électrique I', 'ENR114', 4.00, 4, NULL, '2026-08-28 11:49:18'),
	(107, 21, 18, 'Electronique et automatisme', 'ENR115', 5.00, 5, NULL, '2026-08-28 11:49:18'),
	(108, 21, 19, 'Sources et stockage d\'énergies', 'ENR116', 4.00, 4, NULL, '2026-08-28 11:49:18'),
	(109, 21, 20, 'Formation bilingue', 'ENR117', 3.00, 3, NULL, '2026-08-28 11:49:18'),
	(110, 21, 21, 'Mathématiques II', 'ENR121', 4.00, 4, NULL, '2026-08-28 11:49:18'),
	(111, 21, 17, 'Physique et Chimie I', 'ENR122', 5.00, 5, NULL, '2026-08-28 11:49:18'),
	(112, 21, 18, 'Machines électriques et techniques de mesures', 'ENR123', 5.00, 5, NULL, '2026-08-28 11:49:18'),
	(113, 21, 19, 'Mécanique des fluides et Transfert thermique I', 'ENR124', 5.00, 5, NULL, '2026-08-28 11:49:18'),
	(114, 21, 20, 'Energies Renouvelables I', 'ENR125', 4.00, 4, NULL, '2026-08-28 11:49:18'),
	(115, 21, 21, 'CAO et DAO en Energies renouvelables', 'ENR126', 4.00, 4, NULL, '2026-08-28 11:49:18'),
	(116, 21, 17, 'Economie et Gestion des entreprises', 'ENR127', 3.00, 3, NULL, '2026-08-28 11:49:18'),
	(117, 22, 18, 'Statistiques et TIC II', 'ENR231', 4.00, 4, NULL, '2026-08-28 11:49:18'),
	(118, 22, 19, 'Physique II et Base QHSE', 'ENR232', 5.00, 5, NULL, '2026-08-28 11:49:18'),
	(119, 22, 20, 'Productions et schémas + TP', 'ENR233', 5.00, 5, NULL, '2026-08-28 11:49:18'),
	(120, 22, 21, 'Transfert thermique II et Fluides et réseaux', 'ENR234', 5.00, 5, NULL, '2026-08-28 11:49:18'),
	(121, 22, 17, 'Energies Renouvelables II', 'ENR235', 4.00, 4, NULL, '2026-08-28 11:49:18'),
	(122, 22, 18, 'Efficacité énergétique et couplage au réseau', 'ENR236', 4.00, 4, NULL, '2026-08-28 11:49:18'),
	(123, 22, 19, 'Education citoyenne et déontologie professionnelle', 'ENR237', 3.00, 3, NULL, '2026-08-28 11:49:18'),
	(124, 22, 20, 'Mathématiques III', 'ENR241', 5.00, 5, NULL, '2026-08-28 11:49:18'),
	(125, 22, 21, 'Normes et Réglementation en Thermique et Energétique', 'ENR242', 4.00, 4, NULL, '2026-08-28 11:49:18'),
	(126, 22, 17, 'Dimensionnement et maintenance des systèmes énergétiques', 'ENR243', 4.00, 4, NULL, '2026-08-28 11:49:18'),
	(127, 22, 18, 'Installations électriques et appareillages', 'ENR244', 3.00, 3, NULL, '2026-08-28 11:49:18'),
	(128, 22, 19, 'TP Energie renouvelables', 'ENR245', 5.00, 5, NULL, '2026-08-28 11:49:18'),
	(129, 22, 20, 'Stage professionnel', 'ENR246', 6.00, 6, NULL, '2026-08-28 11:49:18'),
	(130, 22, 21, 'Entrepreneuriat et marketing appliqué aux disciplines', 'ENR247', 3.00, 3, NULL, '2026-08-28 11:49:18');

-- Dumping structure for table istapa.subjects_class
DROP TABLE IF EXISTS `subjects_class`;
CREATE TABLE IF NOT EXISTS `subjects_class` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table istapa.subjects_class: ~0 rows (approximately)
DELETE FROM `subjects_class`;

-- Dumping structure for table istapa.teachers
DROP TABLE IF EXISTS `teachers`;
CREATE TABLE IF NOT EXISTS `teachers` (
  `user_id` bigint unsigned NOT NULL,
  `employee_number` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hire_date` date DEFAULT NULL,
  `specialization` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`user_id`),
  CONSTRAINT `fk_teachers_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table istapa.teachers: ~5 rows (approximately)
DELETE FROM `teachers`;
INSERT INTO `teachers` (`user_id`, `employee_number`, `hire_date`, `specialization`, `bio`) VALUES
	(17, 'EMP-001', '2024-09-01', 'Agriculture générale', 'Enseignant en agriculture et agronomie.'),
	(18, 'EMP-002', '2024-09-01', 'Biologie végétale', 'Spécialiste en biologie et sciences végétales.'),
	(19, 'EMP-003', '2024-09-01', 'Agroforesterie', 'Expert en systèmes agroforestiers tropicaux.'),
	(20, 'EMP-004', '2024-09-01', 'Informatique appliquée', 'Enseignant en informatique et outils numériques.'),
	(21, 'EMP-005', '2024-09-01', 'Économie rurale', 'Spécialiste en économie et développement rural.');

-- Dumping structure for table istapa.testimonials
DROP TABLE IF EXISTS `testimonials`;
CREATE TABLE IF NOT EXISTS `testimonials` (
  `id` int NOT NULL AUTO_INCREMENT,
  `author_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author_role` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` tinyint unsigned DEFAULT NULL,
  `content_en` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_fr` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table istapa.testimonials: ~3 rows (approximately)
DELETE FROM `testimonials`;
INSERT INTO `testimonials` (`id`, `author_name`, `author_role`, `author_photo`, `rating`, `content_en`, `content_fr`, `is_published`, `sort_order`, `created_at`) VALUES
	(1, 'Jean Claude FOUMA', 'Étudiant BTS Agriculture', NULL, 5, 'ISTAPA gave me practical skills that I apply every day on my farm.', 'L\'ISTAPA m\'a donné des compétences pratiques que j\'applique chaque jour sur mon exploitation.', 1, 1, '2026-04-22 00:06:34'),
	(2, 'Emilienne ONANA', 'Diplômée 2025', NULL, 4, 'A rigorous program with passionate teachers. I highly recommend it.', 'Un programme rigoureux avec des enseignants passionnés. Je le recommande vivement.', 1, 2, '2026-04-22 00:06:34'),
	(3, 'Mirian ABANE', 'Étudiant HND2', NULL, 5, 'The agricultural field trips are an excellent complement to theory.', 'Les sorties agricoles sur le terrain sont un excellent complément à la théorie.', 1, 3, '2026-04-22 00:06:34');

-- Dumping structure for table istapa.testimonial_translations
DROP TABLE IF EXISTS `testimonial_translations`;
CREATE TABLE IF NOT EXISTS `testimonial_translations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `testimonial_id` int NOT NULL,
  `language_code` char(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_tt` (`testimonial_id`,`language_code`),
  KEY `fk_tt_lang` (`language_code`),
  CONSTRAINT `fk_tt_lang` FOREIGN KEY (`language_code`) REFERENCES `languages` (`code`),
  CONSTRAINT `fk_tt_test` FOREIGN KEY (`testimonial_id`) REFERENCES `testimonials` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table istapa.testimonial_translations: ~6 rows (approximately)
DELETE FROM `testimonial_translations`;
INSERT INTO `testimonial_translations` (`id`, `testimonial_id`, `language_code`, `content`) VALUES
	(1, 1, 'fr', 'L\'ISTAPA m\'a donné des compétences pratiques que j\'applique chaque jour.'),
	(2, 1, 'en', 'ISTAPA gave me practical skills I apply every day.'),
	(3, 2, 'fr', 'Un programme rigoureux. Je le recommande vivement.'),
	(4, 2, 'en', 'A rigorous program. I highly recommend it.'),
	(5, 3, 'fr', 'Les sorties terrain sont un excellent complément à la théorie.'),
	(6, 3, 'en', 'Field trips are an excellent complement to theory.');

-- Dumping structure for table istapa.upcoming_sessions
DROP TABLE IF EXISTS `upcoming_sessions`;
CREATE TABLE IF NOT EXISTS `upcoming_sessions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `program_id` int DEFAULT NULL,
  `start_date` date NOT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_date` (`start_date`),
  KEY `fk_us_prog` (`program_id`),
  CONSTRAINT `fk_us_prog` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table istapa.upcoming_sessions: ~3 rows (approximately)
DELETE FROM `upcoming_sessions`;
INSERT INTO `upcoming_sessions` (`id`, `program_id`, `start_date`, `is_published`, `sort_order`) VALUES
	(1, 1, '2026-09-01', 1, 1),
	(2, 2, '2026-09-01', 1, 2),
	(3, 3, '2026-09-01', 1, 3);

-- Dumping structure for table istapa.upcoming_session_translations
DROP TABLE IF EXISTS `upcoming_session_translations`;
CREATE TABLE IF NOT EXISTS `upcoming_session_translations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `upcoming_session_id` int NOT NULL,
  `language_code` char(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_ust` (`upcoming_session_id`,`language_code`),
  KEY `fk_ust_lang` (`language_code`),
  CONSTRAINT `fk_ust_lang` FOREIGN KEY (`language_code`) REFERENCES `languages` (`code`),
  CONSTRAINT `fk_ust_us` FOREIGN KEY (`upcoming_session_id`) REFERENCES `upcoming_sessions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table istapa.upcoming_session_translations: ~6 rows (approximately)
DELETE FROM `upcoming_session_translations`;
INSERT INTO `upcoming_session_translations` (`id`, `upcoming_session_id`, `language_code`, `title`, `description`) VALUES
	(1, 1, 'fr', 'Rentrée BTS Agriculture — Septembre 2026', 'Inscriptions ouvertes jusqu\'au 31 juillet 2026.'),
	(2, 1, 'en', 'HND Agriculture — September 2026 Intake', 'Admissions open until 31 July 2026.'),
	(3, 2, 'fr', 'Rentrée BTS Agroalimentaire — Septembre 2026', 'Inscriptions ouvertes jusqu\'au 31 juillet 2026.'),
	(4, 2, 'en', 'HND Agri-Food — September 2026 Intake', 'Admissions open until 31 July 2026.'),
	(5, 3, 'fr', 'Rentrée BTS Environnement — Septembre 2026', 'Inscriptions ouvertes jusqu\'au 31 juillet 2026.'),
	(6, 3, 'en', 'HND Environment — September 2026 Intake', 'Admissions open until 31 July 2026.');

-- Dumping structure for table istapa.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','teacher','student','manager') COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `middle_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alt_phone` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` enum('M','F','other') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preferred_language` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'fr',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_users_email` (`email`),
  KEY `idx_role` (`role`),
  KEY `idx_active` (`is_active`),
  KEY `fk_users_lang` (`preferred_language`),
  CONSTRAINT `fk_users_lang` FOREIGN KEY (`preferred_language`) REFERENCES `languages` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=135 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table istapa.users: ~30 rows (approximately)
DELETE FROM `users`;
INSERT INTO `users` (`id`, `email`, `password_hash`, `role`, `first_name`, `last_name`, `middle_name`, `phone`, `alt_phone`, `avatar`, `gender`, `birth_date`, `address`, `city`, `country`, `preferred_language`, `is_active`, `email_verified_at`, `last_login_at`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'admine@istapa.xyz', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'admin', 'Wylona', 'Wilfried', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, '2026-04-22 00:06:32', '2026-08-28 14:44:38', 's5Z650PfqHsseuRASq8r3UD4c1iq7avD33fG0l1n3HuuJfIcAG48tLNUbvjP', '2026-04-22 00:06:32', '2026-08-28 14:44:38'),
	(2, 'celine@istapa.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Celine Christiane', 'MENGUENE', NULL, '683378610', '687534112', NULL, 'F', '1994-09-25', 'Soa', 'Yaoundé', 'Cameroun', 'fr', 1, '2026-04-22 00:06:32', NULL, NULL, '2026-04-22 00:06:32', '2026-08-24 12:22:21'),
	(3, 'flavien@istapa.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Flavien', 'GAINMI', NULL, '651884352', '675202887', NULL, 'M', '2004-04-29', 'Soa', 'Yaoundé', 'Cameroun', 'fr', 1, '2026-04-22 00:06:32', NULL, NULL, '2026-04-22 00:06:32', '2026-08-24 12:22:21'),
	(4, 'fouma@istapa.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Jean Claude', 'FOUMA ZENGUE', NULL, '698560919', '677637116', NULL, 'M', '1998-09-29', 'Biyam Asi', 'Yaoundé', 'Cameroun', 'fr', 1, '2026-04-22 00:06:32', NULL, NULL, '2026-04-22 00:06:32', '2026-08-24 12:22:21'),
	(5, 'abane@istapa.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Mirian Stephane', 'ABANE ABANE', NULL, '693203784', '696082384', NULL, 'M', '1998-09-24', 'Mimboman', 'Yaoundé', 'Cameroun', 'fr', 1, '2026-04-22 00:06:32', NULL, NULL, '2026-04-22 00:06:32', '2026-08-24 12:22:21'),
	(6, 'dimitri@istapa.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'DIEUDONNE Dimitri', 'BIBOUM', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, '2026-04-22 00:06:32', NULL, NULL, '2026-04-22 00:06:32', '2026-08-24 12:22:21'),
	(7, 'anastasie@istapa.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'ANASTASIE', 'KANA KELYANNE', NULL, NULL, NULL, NULL, 'F', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, '2026-04-22 00:06:32', NULL, NULL, '2026-04-22 00:06:32', '2026-08-24 12:22:21'),
	(8, 'atangana@istapa.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'ATANGANA BINIGA', 'GILLES LOIC', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, '2026-04-22 00:06:32', NULL, NULL, '2026-04-22 00:06:32', '2026-08-24 12:22:21'),
	(9, 'emilienne@istapa.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Emilienne', 'ONANA ATEBA', NULL, NULL, NULL, NULL, 'F', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, '2026-04-22 00:06:32', NULL, NULL, '2026-04-22 00:06:32', '2026-08-24 12:22:21'),
	(10, 'venance@istapa.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'VENANCE', 'KENJIO', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, '2026-04-22 00:06:32', NULL, NULL, '2026-04-22 00:06:32', '2026-08-24 12:22:21'),
	(17, 'teacher1@istapa.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'teacher', 'MARTIN', 'NGONO', NULL, '00000000', NULL, NULL, 'M', '2000-12-01', 'Yaounde', 'Yaoundé', 'Cameroun', 'fr', 1, '2026-04-22 00:06:32', NULL, NULL, '2026-04-22 00:06:32', '2026-08-24 12:22:21'),
	(18, 'nken@istapa.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'teacher', 'Gregoire Juste', 'Nken Mbaga', NULL, '697562079', NULL, NULL, 'M', '1988-10-14', 'Yaoundé', 'Yaoundé', 'Cameroun', 'fr', 1, '2026-04-22 00:06:32', NULL, NULL, '2026-04-22 00:06:32', '2026-08-24 12:22:21'),
	(19, 'tsimi@istapa.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'teacher', 'JEAN VICTOR', 'TSIMI NDONGO', NULL, '650942998', '694591651', NULL, 'M', '1986-12-05', 'Yaoundé', 'Yaoundé', 'Cameroun', 'fr', 1, '2026-04-22 00:06:32', NULL, NULL, '2026-04-22 00:06:32', '2026-08-24 12:22:21'),
	(20, 'wyl@istapa.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'teacher', 'Wyl', 'Me', NULL, '698785662', NULL, NULL, 'M', '1997-11-06', 'Fougerolle', 'Yaoundé', 'Cameroun', 'fr', 1, '2026-04-22 00:06:32', NULL, NULL, '2026-04-22 00:06:32', '2026-08-24 12:22:21'),
	(21, 'zenabou@istapa.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'teacher', 'DAOUDOU', 'ZENABOU', NULL, '658964384', NULL, NULL, 'M', '1991-12-27', 'Yaoundé', 'Yaoundé', 'Cameroun', 'fr', 1, '2026-04-22 00:06:32', NULL, NULL, '2026-04-22 00:06:32', '2026-08-24 12:22:21'),
	(23, 'istapa@istapa.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'admin', 'ISTAPA', 'Admin', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, '2026-04-22 00:06:32', NULL, NULL, '2026-04-22 00:06:32', '2026-08-24 12:22:21'),
	(24, 'marie@istapa.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'manager', 'Marie', 'CARNU', NULL, NULL, NULL, NULL, 'F', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, '2026-04-22 00:06:32', '2026-08-24 13:20:04', 'SMjSDYl02SAMTRaANct7SaptFh6MuhUDwrlNe5yLGDDQbglhFG9Au3JqLaof', '2026-04-22 00:06:32', '2026-08-24 13:20:04'),
	(25, 'atono@istapa.com', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'ATONO ELOUNDOU', 'Emilienne Stephanie', NULL, '655018354', '677377160', NULL, 'F', '2005-01-04', 'Soa', 'Yaoundé', 'Cameroun', 'fr', 1, '2026-04-22 00:06:32', NULL, NULL, '2026-04-22 00:06:32', '2026-08-24 12:22:21'),
	(26, 'tchiaga@istapa.com', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Tchiaga Tchouaga', 'Patrick Kadin', NULL, '657730424', '697307262', NULL, 'M', '2005-01-10', 'Nkolfoulou', 'Yaoundé', 'Cameroun', 'fr', 1, '2026-04-22 00:06:32', NULL, NULL, '2026-04-22 00:06:32', '2026-08-24 12:22:21'),
	(27, 'ndy@istapa.com', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'NDY SADY', 'Max Rodolph', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, '2026-04-22 00:06:32', NULL, NULL, '2026-04-22 00:06:32', '2026-08-24 12:22:21'),
	(28, 'oben@istapa.com', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'OBEN NDJOUKA', 'Joysline Michelle', NULL, NULL, NULL, NULL, 'F', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, '2026-04-22 00:06:32', NULL, NULL, '2026-04-22 00:06:32', '2026-08-24 12:22:21'),
	(29, 'asse@istapa.com', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'ASSE', 'Divine Gracia', NULL, NULL, NULL, NULL, 'F', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, '2026-04-22 00:06:32', NULL, NULL, '2026-04-22 00:06:32', '2026-08-24 12:22:21'),
	(31, 'akaam@istapa.com', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'AKAAM ZOOH', 'Sanda Fahdel', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, '2026-04-22 00:06:32', NULL, NULL, '2026-04-22 00:06:32', '2026-08-24 12:22:21'),
	(32, 'ngonini@istapa.com', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'NGONINI MBIDA', 'Pulcherie Surprise', NULL, NULL, NULL, NULL, 'F', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, '2026-04-22 00:06:32', NULL, NULL, '2026-04-22 00:06:32', '2026-08-24 12:22:21'),
	(33, 'onana@istapa.com', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'ONANA NGOUE', 'Martial Gael', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, '2026-04-22 00:06:32', NULL, NULL, '2026-04-22 00:06:32', '2026-08-24 12:22:21'),
	(34, 'ngah@istapa.com', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'NGAH', 'Odile Sandrine', NULL, NULL, NULL, NULL, 'F', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, '2026-04-22 00:06:32', NULL, NULL, '2026-04-22 00:06:32', '2026-08-24 12:22:21'),
	(35, 'nzeusseu@istapa.com', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Nzeusseu', 'Franck Cabrice', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, '2026-04-22 00:06:32', NULL, NULL, '2026-04-22 00:06:32', '2026-08-24 12:22:21'),
	(36, 'manyim@istapa.com', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'MANYIM', 'Manuella Serena', NULL, '699297330', NULL, NULL, 'F', '2009-01-16', 'Soa', 'Yaoundé', 'Cameroun', 'fr', 1, '2026-04-22 00:06:32', NULL, NULL, '2026-04-22 00:06:32', '2026-08-24 12:22:21'),
	(37, 'bidoung@istapa.com', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'BIDOUNG', 'Max Kevin Well', NULL, '692632130', '655969742', NULL, 'M', '2006-04-22', 'Soa', 'Yaoundé', 'Cameroun', 'fr', 1, '2026-04-22 00:06:32', NULL, NULL, '2026-04-22 00:06:32', '2026-08-24 12:22:21'),
	(38, 'moffor@istapa.com', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'NJIKE MOFFOR', 'Donatien Cyrille', NULL, '690560209', '695796402', NULL, 'M', '1996-07-18', 'Soa', 'Yaoundé', 'Cameroun', 'fr', 1, '2026-04-22 00:06:32', NULL, NULL, '2026-04-22 00:06:32', '2026-08-24 12:22:21'),
	(39, 'etudiant.test001@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Patrick', 'Fotso', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(40, 'etudiant.test002@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Sandrine', 'Njoya', NULL, NULL, NULL, NULL, 'F', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(41, 'etudiant.test003@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Serge', 'Owona', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(42, 'etudiant.test004@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Pauline', 'Amougou', NULL, NULL, NULL, NULL, 'F', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(43, 'etudiant.test005@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Hervé', 'Sonkeng', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(44, 'etudiant.test006@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Carine', 'Nkolo', NULL, NULL, NULL, NULL, 'F', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(45, 'etudiant.test007@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Aristide', 'Ekotto', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(46, 'etudiant.test008@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Stephanie', 'Talla', NULL, NULL, NULL, NULL, 'F', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(47, 'etudiant.test009@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Rodrigue', 'Kamdem', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(48, 'etudiant.test010@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Divine', 'Tchoumi', NULL, NULL, NULL, NULL, 'F', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(49, 'etudiant.test011@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Boris', 'Djeukam', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(50, 'etudiant.test012@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Marie', 'Kenfack', NULL, NULL, NULL, NULL, 'F', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(51, 'etudiant.test013@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Patrick', 'Zambo', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(52, 'etudiant.test014@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Sandrine', 'Nguema', NULL, NULL, NULL, NULL, 'F', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(53, 'etudiant.test015@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Serge', 'Biya', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(54, 'etudiant.test016@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Pauline', 'Essomba', NULL, NULL, NULL, NULL, 'F', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(55, 'etudiant.test017@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Hervé', 'Ngo Bell', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(56, 'etudiant.test018@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Carine', 'Mbarga', NULL, NULL, NULL, NULL, 'F', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(57, 'etudiant.test019@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Aristide', 'Tabi', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(58, 'etudiant.test020@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Stephanie', 'Mballa', NULL, NULL, NULL, NULL, 'F', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(59, 'etudiant.test021@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Rodrigue', 'Fotso', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(60, 'etudiant.test022@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Divine', 'Njoya', NULL, NULL, NULL, NULL, 'F', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(61, 'etudiant.test023@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Boris', 'Owona', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(62, 'etudiant.test024@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Marie', 'Amougou', NULL, NULL, NULL, NULL, 'F', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(63, 'etudiant.test025@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Patrick', 'Sonkeng', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(64, 'etudiant.test026@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Sandrine', 'Nkolo', NULL, NULL, NULL, NULL, 'F', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(65, 'etudiant.test027@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Serge', 'Ekotto', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(66, 'etudiant.test028@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Pauline', 'Talla', NULL, NULL, NULL, NULL, 'F', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(67, 'etudiant.test029@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Hervé', 'Kamdem', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(68, 'etudiant.test030@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Carine', 'Tchoumi', NULL, NULL, NULL, NULL, 'F', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(69, 'etudiant.test031@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Aristide', 'Djeukam', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(70, 'etudiant.test032@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Stephanie', 'Kenfack', NULL, NULL, NULL, NULL, 'F', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(71, 'etudiant.test033@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Rodrigue', 'Zambo', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(72, 'etudiant.test034@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Divine', 'Nguema', NULL, NULL, NULL, NULL, 'F', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(73, 'etudiant.test035@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Boris', 'Biya', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(74, 'etudiant.test036@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Marie', 'Essomba', NULL, NULL, NULL, NULL, 'F', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(75, 'etudiant.test037@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Patrick', 'Ngo Bell', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(76, 'etudiant.test038@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Sandrine', 'Mbarga', NULL, NULL, NULL, NULL, 'F', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(77, 'etudiant.test039@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Serge', 'Tabi', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(78, 'etudiant.test040@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Pauline', 'Mballa', NULL, NULL, NULL, NULL, 'F', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(79, 'etudiant.test041@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Hervé', 'Fotso', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(80, 'etudiant.test042@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Carine', 'Njoya', NULL, NULL, NULL, NULL, 'F', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(81, 'etudiant.test043@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Aristide', 'Owona', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(82, 'etudiant.test044@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Stephanie', 'Amougou', NULL, NULL, NULL, NULL, 'F', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(83, 'etudiant.test045@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Rodrigue', 'Sonkeng', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(84, 'etudiant.test046@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Divine', 'Nkolo', NULL, NULL, NULL, NULL, 'F', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(85, 'etudiant.test047@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Boris', 'Ekotto', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(86, 'etudiant.test048@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Marie', 'Talla', NULL, NULL, NULL, NULL, 'F', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(87, 'etudiant.test049@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Patrick', 'Kamdem', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(88, 'etudiant.test050@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Sandrine', 'Tchoumi', NULL, NULL, NULL, NULL, 'F', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(89, 'etudiant.test051@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Serge', 'Djeukam', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(90, 'etudiant.test052@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Pauline', 'Kenfack', NULL, NULL, NULL, NULL, 'F', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(91, 'etudiant.test053@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Hervé', 'Zambo', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(92, 'etudiant.test054@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Carine', 'Nguema', NULL, NULL, NULL, NULL, 'F', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(93, 'etudiant.test055@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Aristide', 'Biya', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(94, 'etudiant.test056@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Stephanie', 'Essomba', NULL, NULL, NULL, NULL, 'F', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(95, 'etudiant.test057@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Rodrigue', 'Ngo Bell', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(96, 'etudiant.test058@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Divine', 'Mbarga', NULL, NULL, NULL, NULL, 'F', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(97, 'etudiant.test059@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Boris', 'Tabi', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(98, 'etudiant.test060@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Marie', 'Mballa', NULL, NULL, NULL, NULL, 'F', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(99, 'etudiant.test061@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Patrick', 'Fotso', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(100, 'etudiant.test062@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Sandrine', 'Njoya', NULL, NULL, NULL, NULL, 'F', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(101, 'etudiant.test063@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Serge', 'Owona', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(102, 'etudiant.test064@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Pauline', 'Amougou', NULL, NULL, NULL, NULL, 'F', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(103, 'etudiant.test065@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Hervé', 'Sonkeng', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(104, 'etudiant.test066@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Carine', 'Nkolo', NULL, NULL, NULL, NULL, 'F', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(105, 'etudiant.test067@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Aristide', 'Ekotto', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(106, 'etudiant.test068@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Stephanie', 'Talla', NULL, NULL, NULL, NULL, 'F', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(107, 'etudiant.test069@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Rodrigue', 'Kamdem', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(108, 'etudiant.test070@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Divine', 'Tchoumi', NULL, NULL, NULL, NULL, 'F', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(109, 'etudiant.test071@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Boris', 'Djeukam', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(110, 'etudiant.test072@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Marie', 'Kenfack', NULL, NULL, NULL, NULL, 'F', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(111, 'etudiant.test073@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Patrick', 'Zambo', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(112, 'etudiant.test074@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Sandrine', 'Nguema', NULL, NULL, NULL, NULL, 'F', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(113, 'etudiant.test075@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Serge', 'Biya', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(114, 'etudiant.test076@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Pauline', 'Essomba', NULL, NULL, NULL, NULL, 'F', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(115, 'etudiant.test077@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Hervé', 'Ngo Bell', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(116, 'etudiant.test078@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Carine', 'Mbarga', NULL, NULL, NULL, NULL, 'F', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(117, 'etudiant.test079@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Aristide', 'Tabi', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(118, 'etudiant.test080@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Stephanie', 'Mballa', NULL, NULL, NULL, NULL, 'F', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(119, 'etudiant.test081@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Rodrigue', 'Fotso', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(120, 'etudiant.test082@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Divine', 'Njoya', NULL, NULL, NULL, NULL, 'F', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(121, 'etudiant.test083@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Boris', 'Owona', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(122, 'etudiant.test084@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Marie', 'Amougou', NULL, NULL, NULL, NULL, 'F', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(123, 'etudiant.test085@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Patrick', 'Sonkeng', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(124, 'etudiant.test086@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Sandrine', 'Nkolo', NULL, NULL, NULL, NULL, 'F', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(125, 'etudiant.test087@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Serge', 'Ekotto', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(126, 'etudiant.test088@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Pauline', 'Talla', NULL, NULL, NULL, NULL, 'F', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(127, 'etudiant.test089@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Hervé', 'Kamdem', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(128, 'etudiant.test090@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Carine', 'Tchoumi', NULL, NULL, NULL, NULL, 'F', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(129, 'etudiant.test091@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Aristide', 'Djeukam', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(130, 'etudiant.test092@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Stephanie', 'Kenfack', NULL, NULL, NULL, NULL, 'F', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(131, 'etudiant.test093@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Rodrigue', 'Zambo', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(132, 'etudiant.test094@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Divine', 'Nguema', NULL, NULL, NULL, NULL, 'F', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(133, 'etudiant.test095@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Boris', 'Biya', NULL, NULL, NULL, NULL, 'M', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18'),
	(134, 'etudiant.test096@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Marie', 'Essomba', NULL, NULL, NULL, NULL, 'F', NULL, NULL, 'Yaoundé', 'Cameroun', 'fr', 1, NULL, NULL, NULL, '2026-08-28 11:49:18', '2026-08-28 11:49:18');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
