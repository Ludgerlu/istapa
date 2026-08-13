-- ============================================================================
-- ISTAPA - Mise à jour du module "programs" (v2 - simplifiée)
-- Ajoute : galerie d'images (1..n), certificats d'admission requis (n..n),
--          diplôme obtenu en fin de cursus (1-to-1, directement sur programs)
-- Compatible MariaDB 10.4 / InnoDB / utf8mb4
-- ============================================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- ----------------------------------------------------------------------------
-- 1) DIPLÔME : relation 1-to-1 -> on ajoute directement les champs sur
--    `programs` plutôt qu'une table séparée. Chaque ligne de `programs`
--    représente déjà une offre précise (ex: slug 'hnd-production-animale'),
--    donc pas besoin de jointure ici.
-- ----------------------------------------------------------------------------
ALTER TABLE `programs`
  ADD COLUMN `degree_code` varchar(30) DEFAULT NULL AFTER `duration_months`,
  ADD COLUMN `degree_name_en` varchar(120) DEFAULT NULL AFTER `degree_code`,
  ADD COLUMN `degree_name_fr` varchar(120) DEFAULT NULL AFTER `degree_name_en`,
  ADD COLUMN `degree_description_en` text DEFAULT NULL AFTER `degree_name_fr`,
  ADD COLUMN `degree_description_fr` text DEFAULT NULL AFTER `degree_description_en`;

-- Remplissage pour les 6 programmes existants (tous niveau BTS/HND d'après l'affiche)
UPDATE `programs` SET
  `degree_code` = 'BTS_HND',
  `degree_name_en` = 'BTS / HND (Level 1)',
  `degree_name_fr` = 'BTS / HND (Niveau 1)',
  `degree_description_en` = 'A two-year professional diploma (Brevet de Technicien Supérieur / Higher National Diploma) combining theory with hands-on practice, preparing graduates for immediate entry into technical and field roles.',
  `degree_description_fr` = 'Un diplôme professionnel de deux ans (Brevet de Technicien Supérieur / Higher National Diploma) combinant théorie et pratique de terrain, préparant les diplômés à une insertion immédiate dans des postes techniques.'
WHERE `id` IN (1,2,3,4,5,6);

-- Note : si tu ajoutes plus tard les filières avancées (Ingénieur/Licence/Master
-- sous supervision ISABEE - Univ. de Bertoua vues sur l'affiche), ce sera de
-- NOUVELLES lignes `programs` (nouveaux slugs), avec degree_code='LICENCE_MASTER'
-- par exemple — cohérent avec le fait que chaque ligne = une offre précise.

-- ----------------------------------------------------------------------------
-- 2) CERTIFICATS (référentiel réutilisable) — un programme peut exiger
--    PLUSIEURS certificats différents, donc relation many-to-many
-- ----------------------------------------------------------------------------
CREATE TABLE `certificates` (
  `id` int(11) NOT NULL,
  `code` varchar(30) NOT NULL,
  `name_en` varchar(120) NOT NULL,
  `name_fr` varchar(120) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `certificates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_certificates_code` (`code`);

ALTER TABLE `certificates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

INSERT INTO `certificates` (`id`,`code`,`name_en`,`name_fr`) VALUES
(1, 'GCE_AL', 'GCE Advanced Level', 'GCE Advanced Level'),
(2, 'TVEE_AL', 'TVEE Advanced Level', 'TVEE Advanced Level'),
(3, 'DUT', 'DUT (University Diploma of Technology)', 'DUT (Diplôme Universitaire de Technologie)'),
(4, 'DTS', 'DTS (Higher Technician Diploma)', 'DTS (Diplôme de Technicien Supérieur)'),
(5, 'HND_BTS', 'HND / BTS', 'HND / BTS'),
(6, 'BACHELOR', 'Bachelor''s Degree', 'Licence');

-- ----------------------------------------------------------------------------
-- 3) PROGRAM_CERTIFICATES : table pivot many-to-many
--    (un programme peut accepter plusieurs certificats d'entrée différents)
-- ----------------------------------------------------------------------------
CREATE TABLE `program_certificates` (
  `program_id` int(11) NOT NULL,
  `certificate_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `program_certificates`
  ADD PRIMARY KEY (`program_id`,`certificate_id`),
  ADD KEY `idx_pc_certificate` (`certificate_id`);

ALTER TABLE `program_certificates`
  ADD CONSTRAINT `fk_pc_program`
  FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`)
  ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pc_certificate`
  FOREIGN KEY (`certificate_id`) REFERENCES `certificates` (`id`)
  ON DELETE RESTRICT ON UPDATE CASCADE;

-- Rattachement des certificats requis : GCE AL + TVEE AL pour les 6 programmes
-- existants (visibles sur l'affiche pour 1 à 5 ; 6 = Water/Sanitation par
-- défaut, à confirmer avec ISTAPA car absent de cette affiche)
INSERT INTO `program_certificates` (`program_id`, `certificate_id`)
SELECT p.id, c.id
FROM `programs` p
JOIN `certificates` c ON c.code IN ('GCE_AL','TVEE_AL')
WHERE p.id IN (1,2,3,4,5,6);

-- ----------------------------------------------------------------------------
-- 4) GALERIE D'IMAGES : un programme peut avoir 0..n images
--    (programs.cover_image reste en place pour compat ; is_cover=1 marque
--    l'image de couverture dans la galerie)
-- ----------------------------------------------------------------------------
CREATE TABLE `program_images` (
  `id` int(11) NOT NULL,
  `program_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `alt_en` varchar(150) DEFAULT NULL,
  `alt_fr` varchar(150) DEFAULT NULL,
  `is_cover` tinyint(1) NOT NULL DEFAULT 0,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `program_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_program_images_program` (`program_id`),
  ADD KEY `idx_program_images_cover` (`program_id`,`is_cover`);

ALTER TABLE `program_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `program_images`
  ADD CONSTRAINT `fk_program_images_program`
  FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`)
  ON DELETE CASCADE ON UPDATE CASCADE;

COMMIT;

-- ============================================================================
-- REQUÊTES UTILES POUR L'APPLICATION
-- ============================================================================

-- A) Toutes les images d'un programme, couverture en premier
-- SELECT * FROM program_images WHERE program_id = ? ORDER BY is_cover DESC, sort_order ASC;

-- B) Fiche complète d'un programme : diplôme + certificats requis
-- SELECT p.title_fr, p.degree_name_fr, p.degree_description_fr,
--        GROUP_CONCAT(c.name_fr SEPARATOR ' ou ') AS certificats_requis
-- FROM programs p
-- LEFT JOIN program_certificates pc ON pc.program_id = p.id
-- LEFT JOIN certificates c ON c.id = pc.certificate_id
-- WHERE p.id = ?
-- GROUP BY p.id;

-- C) Ajouter une image à un programme
-- INSERT INTO program_images (program_id, image_path, alt_fr, is_cover, sort_order)
-- VALUES (?, '/uploads/programs/xxx.jpg', 'Étudiants en travaux pratiques', 0, 1);

-- D) Ajouter un certificat requis à un programme (ex: accepter aussi Probatoire)
-- INSERT INTO program_certificates (program_id, certificate_id)
-- SELECT ?, id FROM certificates WHERE code = 'GCE_AL';

-- E) Mettre à jour la description du diplôme pour TOUS les programmes du
--    même niveau en une seule requête (puisque le champ vit sur `programs`)
-- UPDATE programs SET degree_description_fr = '...', degree_description_en = '...'
-- WHERE degree_code = 'BTS_HND';

-- F) Lister tous les programmes qui acceptent un certificat donné
-- SELECT p.title_fr FROM programs p
-- JOIN program_certificates pc ON pc.program_id = p.id
-- JOIN certificates c ON c.id = pc.certificate_id
-- WHERE c.code = 'GCE_AL';
