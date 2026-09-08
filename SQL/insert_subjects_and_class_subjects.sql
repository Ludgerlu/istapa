-- ============================================================
-- Insertion des matières + liaison class_subjects
-- pour les 24 classes de l'année académique id = 3
-- ============================================================

-- ÉTAPE 1 : insertion des matières dans `subjects`
-- (teacher_id repris cycliquement parmi 17-21, à corriger avec les vrais enseignants)

INSERT INTO `subjects` (`class_id`, `teacher_id`, `name`, `code`, `coefficient`, `hours_per_week`)
SELECT c.id, t.teacher_id, t.name, t.code, t.coefficient, t.hours_per_week
FROM `classes` c
JOIN (
    SELECT 'HND1 Production Animale' AS class_name, 17 AS teacher_id, 'Zootechnie générale' AS name, 'ZOO101' AS code, 2.00 AS coefficient, 4 AS hours_per_week
    UNION ALL SELECT 'HND1 Production Animale' AS class_name, 18 AS teacher_id, 'Anatomie et physiologie animale' AS name, 'APA101' AS code, 2.00 AS coefficient, 3 AS hours_per_week
    UNION ALL SELECT 'HND1 Production Animale' AS class_name, 19 AS teacher_id, 'Alimentation animale' AS name, 'ALA101' AS code, 2.00 AS coefficient, 3 AS hours_per_week
    UNION ALL SELECT 'HND1 Production Animale' AS class_name, 20 AS teacher_id, 'Biologie générale' AS name, 'BIO101b' AS code, 1.50 AS coefficient, 2 AS hours_per_week
    UNION ALL SELECT 'HND1 Production Animale' AS class_name, 21 AS teacher_id, 'Informatique de base' AS name, 'IB101b' AS code, 1.00 AS coefficient, 2 AS hours_per_week
    UNION ALL SELECT 'HND2 Production Animale' AS class_name, 17 AS teacher_id, 'Pathologie animale' AS name, 'PAT201' AS code, 2.00 AS coefficient, 4 AS hours_per_week
    UNION ALL SELECT 'HND2 Production Animale' AS class_name, 18 AS teacher_id, 'Reproduction animale' AS name, 'REP201' AS code, 2.00 AS coefficient, 3 AS hours_per_week
    UNION ALL SELECT 'HND2 Production Animale' AS class_name, 19 AS teacher_id, 'Élevage avicole et porcin' AS name, 'EAP201' AS code, 2.00 AS coefficient, 3 AS hours_per_week
    UNION ALL SELECT 'HND2 Production Animale' AS class_name, 20 AS teacher_id, 'Gestion d\'exploitation d\'élevage' AS name, 'GEE201' AS code, 1.50 AS coefficient, 2 AS hours_per_week
    UNION ALL SELECT 'HND2 Production Animale' AS class_name, 21 AS teacher_id, 'Économie rurale' AS name, 'ECR201b' AS code, 1.50 AS coefficient, 2 AS hours_per_week
    UNION ALL SELECT 'HND1 Production Végétale' AS class_name, 17 AS teacher_id, 'Botanique' AS name, 'BOT101b' AS code, 2.00 AS coefficient, 3 AS hours_per_week
    UNION ALL SELECT 'HND1 Production Végétale' AS class_name, 18 AS teacher_id, 'Pédologie' AS name, 'PED101b' AS code, 2.00 AS coefficient, 3 AS hours_per_week
    UNION ALL SELECT 'HND1 Production Végétale' AS class_name, 19 AS teacher_id, 'Introduction à l\'agronomie' AS name, 'IAG101b' AS code, 2.00 AS coefficient, 4 AS hours_per_week
    UNION ALL SELECT 'HND1 Production Végétale' AS class_name, 20 AS teacher_id, 'Écologie' AS name, 'ECO101b' AS code, 2.00 AS coefficient, 3 AS hours_per_week
    UNION ALL SELECT 'HND1 Production Végétale' AS class_name, 21 AS teacher_id, 'Informatique de base' AS name, 'IB102' AS code, 1.00 AS coefficient, 2 AS hours_per_week
    UNION ALL SELECT 'HND2 Production Végétale' AS class_name, 17 AS teacher_id, 'Phytopathologie' AS name, 'PHY201b' AS code, 2.00 AS coefficient, 3 AS hours_per_week
    UNION ALL SELECT 'HND2 Production Végétale' AS class_name, 18 AS teacher_id, 'Techniques d\'irrigation' AS name, 'IRR201b' AS code, 1.50 AS coefficient, 2 AS hours_per_week
    UNION ALL SELECT 'HND2 Production Végétale' AS class_name, 19 AS teacher_id, 'Amélioration des plantes' AS name, 'AMP201' AS code, 2.00 AS coefficient, 3 AS hours_per_week
    UNION ALL SELECT 'HND2 Production Végétale' AS class_name, 20 AS teacher_id, 'Gestion d\'exploitation agricole' AS name, 'GEA201' AS code, 1.50 AS coefficient, 2 AS hours_per_week
    UNION ALL SELECT 'HND2 Production Végétale' AS class_name, 21 AS teacher_id, 'Économie rurale' AS name, 'ECR202' AS code, 1.50 AS coefficient, 2 AS hours_per_week
    UNION ALL SELECT 'HND1 Gestion Environnementale' AS class_name, 17 AS teacher_id, 'Écologie générale' AS name, 'ECG101' AS code, 2.00 AS coefficient, 3 AS hours_per_week
    UNION ALL SELECT 'HND1 Gestion Environnementale' AS class_name, 18 AS teacher_id, 'Biologie environnementale' AS name, 'BIE101b' AS code, 2.00 AS coefficient, 3 AS hours_per_week
    UNION ALL SELECT 'HND1 Gestion Environnementale' AS class_name, 19 AS teacher_id, 'Cartographie' AS name, 'CAR101b' AS code, 1.50 AS coefficient, 2 AS hours_per_week
    UNION ALL SELECT 'HND1 Gestion Environnementale' AS class_name, 20 AS teacher_id, 'Chimie de l\'environnement' AS name, 'CHE101' AS code, 2.00 AS coefficient, 3 AS hours_per_week
    UNION ALL SELECT 'HND1 Gestion Environnementale' AS class_name, 21 AS teacher_id, 'Informatique de base' AS name, 'IB103' AS code, 1.00 AS coefficient, 2 AS hours_per_week
    UNION ALL SELECT 'HND2 Gestion Environnementale' AS class_name, 17 AS teacher_id, 'Gestion environnementale' AS name, 'GEN201' AS code, 2.00 AS coefficient, 4 AS hours_per_week
    UNION ALL SELECT 'HND2 Gestion Environnementale' AS class_name, 18 AS teacher_id, 'Évaluation d\'impact environnemental' AS name, 'EIE201' AS code, 2.00 AS coefficient, 3 AS hours_per_week
    UNION ALL SELECT 'HND2 Gestion Environnementale' AS class_name, 19 AS teacher_id, 'Traitement des déchets' AS name, 'TDD201' AS code, 1.50 AS coefficient, 2 AS hours_per_week
    UNION ALL SELECT 'HND2 Gestion Environnementale' AS class_name, 20 AS teacher_id, 'Droit de l\'environnement' AS name, 'DRE201' AS code, 1.50 AS coefficient, 2 AS hours_per_week
    UNION ALL SELECT 'HND2 Gestion Environnementale' AS class_name, 21 AS teacher_id, 'Économie de l\'environnement' AS name, 'ECE201' AS code, 1.50 AS coefficient, 2 AS hours_per_week
    UNION ALL SELECT 'HND1 Énergies Renouvelables' AS class_name, 17 AS teacher_id, 'Physique appliquée' AS name, 'PHA101' AS code, 2.00 AS coefficient, 3 AS hours_per_week
    UNION ALL SELECT 'HND1 Énergies Renouvelables' AS class_name, 18 AS teacher_id, 'Électricité générale' AS name, 'ELG101' AS code, 2.00 AS coefficient, 4 AS hours_per_week
    UNION ALL SELECT 'HND1 Énergies Renouvelables' AS class_name, 19 AS teacher_id, 'Introduction aux énergies renouvelables' AS name, 'IER101' AS code, 2.00 AS coefficient, 3 AS hours_per_week
    UNION ALL SELECT 'HND1 Énergies Renouvelables' AS class_name, 20 AS teacher_id, 'Mathématiques appliquées' AS name, 'MAA101' AS code, 1.50 AS coefficient, 2 AS hours_per_week
    UNION ALL SELECT 'HND1 Énergies Renouvelables' AS class_name, 21 AS teacher_id, 'Informatique de base' AS name, 'IB104' AS code, 1.00 AS coefficient, 2 AS hours_per_week
    UNION ALL SELECT 'HND2 Énergies Renouvelables' AS class_name, 17 AS teacher_id, 'Énergie solaire photovoltaïque' AS name, 'ESP201' AS code, 2.00 AS coefficient, 4 AS hours_per_week
    UNION ALL SELECT 'HND2 Énergies Renouvelables' AS class_name, 18 AS teacher_id, 'Énergie éolienne et biomasse' AS name, 'EEB201' AS code, 2.00 AS coefficient, 3 AS hours_per_week
    UNION ALL SELECT 'HND2 Énergies Renouvelables' AS class_name, 19 AS teacher_id, 'Installation et maintenance des systèmes énergétiques' AS name, 'IMS201' AS code, 2.00 AS coefficient, 3 AS hours_per_week
    UNION ALL SELECT 'HND2 Énergies Renouvelables' AS class_name, 20 AS teacher_id, 'Gestion de projet énergétique' AS name, 'GPE201' AS code, 1.50 AS coefficient, 2 AS hours_per_week
    UNION ALL SELECT 'HND2 Énergies Renouvelables' AS class_name, 21 AS teacher_id, 'Économie de l\'énergie' AS name, 'ECN201' AS code, 1.50 AS coefficient, 2 AS hours_per_week
    UNION ALL SELECT 'HND1 Gestion Forestière' AS class_name, 17 AS teacher_id, 'Écologie forestière' AS name, 'ECF101' AS code, 2.00 AS coefficient, 3 AS hours_per_week
    UNION ALL SELECT 'HND1 Gestion Forestière' AS class_name, 18 AS teacher_id, 'Dendrologie' AS name, 'DEN101' AS code, 2.00 AS coefficient, 3 AS hours_per_week
    UNION ALL SELECT 'HND1 Gestion Forestière' AS class_name, 19 AS teacher_id, 'Sylviculture' AS name, 'SYL101' AS code, 2.00 AS coefficient, 3 AS hours_per_week
    UNION ALL SELECT 'HND1 Gestion Forestière' AS class_name, 20 AS teacher_id, 'Cartographie forestière' AS name, 'CAF101' AS code, 1.50 AS coefficient, 2 AS hours_per_week
    UNION ALL SELECT 'HND1 Gestion Forestière' AS class_name, 21 AS teacher_id, 'Informatique de base' AS name, 'IB105' AS code, 1.00 AS coefficient, 2 AS hours_per_week
    UNION ALL SELECT 'HND2 Gestion Forestière' AS class_name, 17 AS teacher_id, 'Aménagement forestier' AS name, 'AMF201' AS code, 2.00 AS coefficient, 4 AS hours_per_week
    UNION ALL SELECT 'HND2 Gestion Forestière' AS class_name, 18 AS teacher_id, 'Exploitation forestière' AS name, 'EXF201' AS code, 2.00 AS coefficient, 3 AS hours_per_week
    UNION ALL SELECT 'HND2 Gestion Forestière' AS class_name, 19 AS teacher_id, 'Faune et conservation' AS name, 'FAC201' AS code, 1.50 AS coefficient, 2 AS hours_per_week
    UNION ALL SELECT 'HND2 Gestion Forestière' AS class_name, 20 AS teacher_id, 'Droit forestier' AS name, 'DRF201' AS code, 1.50 AS coefficient, 2 AS hours_per_week
    UNION ALL SELECT 'HND2 Gestion Forestière' AS class_name, 21 AS teacher_id, 'Gestion de projet forestier' AS name, 'GPF201' AS code, 1.50 AS coefficient, 2 AS hours_per_week
    UNION ALL SELECT 'HND1 Eaux et Assainissement' AS class_name, 17 AS teacher_id, 'Hydraulique générale' AS name, 'HYG101' AS code, 2.00 AS coefficient, 4 AS hours_per_week
    UNION ALL SELECT 'HND1 Eaux et Assainissement' AS class_name, 18 AS teacher_id, 'Chimie de l\'eau' AS name, 'CDE101' AS code, 2.00 AS coefficient, 3 AS hours_per_week
    UNION ALL SELECT 'HND1 Eaux et Assainissement' AS class_name, 19 AS teacher_id, 'Microbiologie de l\'eau' AS name, 'MIE101' AS code, 2.00 AS coefficient, 3 AS hours_per_week
    UNION ALL SELECT 'HND1 Eaux et Assainissement' AS class_name, 20 AS teacher_id, 'Topographie' AS name, 'TOP101' AS code, 1.50 AS coefficient, 2 AS hours_per_week
    UNION ALL SELECT 'HND1 Eaux et Assainissement' AS class_name, 21 AS teacher_id, 'Informatique de base' AS name, 'IB106' AS code, 1.00 AS coefficient, 2 AS hours_per_week
    UNION ALL SELECT 'HND2 Eaux et Assainissement' AS class_name, 17 AS teacher_id, 'Traitement des eaux usées' AS name, 'TEU201' AS code, 2.00 AS coefficient, 4 AS hours_per_week
    UNION ALL SELECT 'HND2 Eaux et Assainissement' AS class_name, 18 AS teacher_id, 'Réseaux d\'assainissement' AS name, 'RES201' AS code, 2.00 AS coefficient, 3 AS hours_per_week
    UNION ALL SELECT 'HND2 Eaux et Assainissement' AS class_name, 19 AS teacher_id, 'Adduction d\'eau potable' AS name, 'AEP201' AS code, 2.00 AS coefficient, 3 AS hours_per_week
    UNION ALL SELECT 'HND2 Eaux et Assainissement' AS class_name, 20 AS teacher_id, 'Gestion de projet hydraulique' AS name, 'GPH201' AS code, 1.50 AS coefficient, 2 AS hours_per_week
    UNION ALL SELECT 'HND2 Eaux et Assainissement' AS class_name, 21 AS teacher_id, 'Droit de l\'eau' AS name, 'DRO201' AS code, 1.50 AS coefficient, 2 AS hours_per_week
    UNION ALL SELECT 'M1 Production Animale et Halieutique' AS class_name, 17 AS teacher_id, 'Nutrition animale avancée' AS name, 'NAA301' AS code, 2.00 AS coefficient, 3 AS hours_per_week
    UNION ALL SELECT 'M1 Production Animale et Halieutique' AS class_name, 18 AS teacher_id, 'Pisciculture et halieutique' AS name, 'PIH301' AS code, 2.00 AS coefficient, 3 AS hours_per_week
    UNION ALL SELECT 'M1 Production Animale et Halieutique' AS class_name, 19 AS teacher_id, 'Génétique animale' AS name, 'GEA301' AS code, 2.00 AS coefficient, 3 AS hours_per_week
    UNION ALL SELECT 'M1 Production Animale et Halieutique' AS class_name, 20 AS teacher_id, 'Méthodologie de la recherche' AS name, 'MDR301' AS code, 1.50 AS coefficient, 2 AS hours_per_week
    UNION ALL SELECT 'M1 Production Animale et Halieutique' AS class_name, 21 AS teacher_id, 'Anglais scientifique' AS name, 'ANS301' AS code, 1.00 AS coefficient, 2 AS hours_per_week
    UNION ALL SELECT 'M2 Production Animale et Halieutique' AS class_name, 17 AS teacher_id, 'Reproduction et biotechnologies animales' AS name, 'RBA401' AS code, 2.00 AS coefficient, 3 AS hours_per_week
    UNION ALL SELECT 'M2 Production Animale et Halieutique' AS class_name, 18 AS teacher_id, 'Gestion des systèmes aquacoles' AS name, 'GSA401' AS code, 2.00 AS coefficient, 3 AS hours_per_week
    UNION ALL SELECT 'M2 Production Animale et Halieutique' AS class_name, 19 AS teacher_id, 'Économie de l\'élevage et de la pêche' AS name, 'EEP401' AS code, 1.50 AS coefficient, 2 AS hours_per_week
    UNION ALL SELECT 'M2 Production Animale et Halieutique' AS class_name, 20 AS teacher_id, 'Mémoire de fin d\'études' AS name, 'MFE401' AS code, 3.00 AS coefficient, 4 AS hours_per_week
    UNION ALL SELECT 'M2 Production Animale et Halieutique' AS class_name, 21 AS teacher_id, 'Séminaire professionnel' AS name, 'SEM401' AS code, 1.00 AS coefficient, 2 AS hours_per_week
    UNION ALL SELECT 'M1 Production Végétale' AS class_name, 17 AS teacher_id, 'Physiologie végétale avancée' AS name, 'PVA301' AS code, 2.00 AS coefficient, 3 AS hours_per_week
    UNION ALL SELECT 'M1 Production Végétale' AS class_name, 18 AS teacher_id, 'Génétique et amélioration des plantes' AS name, 'GAP301' AS code, 2.00 AS coefficient, 3 AS hours_per_week
    UNION ALL SELECT 'M1 Production Végétale' AS class_name, 19 AS teacher_id, 'Agroécologie' AS name, 'AGE301' AS code, 2.00 AS coefficient, 3 AS hours_per_week
    UNION ALL SELECT 'M1 Production Végétale' AS class_name, 20 AS teacher_id, 'Méthodologie de la recherche' AS name, 'MDR302' AS code, 1.50 AS coefficient, 2 AS hours_per_week
    UNION ALL SELECT 'M1 Production Végétale' AS class_name, 21 AS teacher_id, 'Anglais scientifique' AS name, 'ANS302' AS code, 1.00 AS coefficient, 2 AS hours_per_week
    UNION ALL SELECT 'M2 Production Végétale' AS class_name, 17 AS teacher_id, 'Biotechnologies végétales' AS name, 'BTV401' AS code, 2.00 AS coefficient, 3 AS hours_per_week
    UNION ALL SELECT 'M2 Production Végétale' AS class_name, 18 AS teacher_id, 'Protection des cultures avancée' AS name, 'PCA401' AS code, 2.00 AS coefficient, 3 AS hours_per_week
    UNION ALL SELECT 'M2 Production Végétale' AS class_name, 19 AS teacher_id, 'Économie agricole' AS name, 'ECA401' AS code, 1.50 AS coefficient, 2 AS hours_per_week
    UNION ALL SELECT 'M2 Production Végétale' AS class_name, 20 AS teacher_id, 'Mémoire de fin d\'études' AS name, 'MFE402' AS code, 3.00 AS coefficient, 4 AS hours_per_week
    UNION ALL SELECT 'M2 Production Végétale' AS class_name, 21 AS teacher_id, 'Séminaire professionnel' AS name, 'SEM402' AS code, 1.00 AS coefficient, 2 AS hours_per_week
    UNION ALL SELECT 'M1 Agro-Industrie Alimentaire' AS class_name, 17 AS teacher_id, 'Technologie alimentaire' AS name, 'TAL301' AS code, 2.00 AS coefficient, 3 AS hours_per_week
    UNION ALL SELECT 'M1 Agro-Industrie Alimentaire' AS class_name, 18 AS teacher_id, 'Microbiologie alimentaire' AS name, 'MAL301' AS code, 2.00 AS coefficient, 3 AS hours_per_week
    UNION ALL SELECT 'M1 Agro-Industrie Alimentaire' AS class_name, 19 AS teacher_id, 'Chimie des aliments' AS name, 'CAL301' AS code, 2.00 AS coefficient, 3 AS hours_per_week
    UNION ALL SELECT 'M1 Agro-Industrie Alimentaire' AS class_name, 20 AS teacher_id, 'Méthodologie de la recherche' AS name, 'MDR303' AS code, 1.50 AS coefficient, 2 AS hours_per_week
    UNION ALL SELECT 'M1 Agro-Industrie Alimentaire' AS class_name, 21 AS teacher_id, 'Anglais scientifique' AS name, 'ANS303' AS code, 1.00 AS coefficient, 2 AS hours_per_week
    UNION ALL SELECT 'M2 Agro-Industrie Alimentaire' AS class_name, 17 AS teacher_id, 'Qualité et sécurité alimentaire' AS name, 'QSA401' AS code, 2.00 AS coefficient, 3 AS hours_per_week
    UNION ALL SELECT 'M2 Agro-Industrie Alimentaire' AS class_name, 18 AS teacher_id, 'Génie des procédés agroalimentaires' AS name, 'GPA401' AS code, 2.00 AS coefficient, 3 AS hours_per_week
    UNION ALL SELECT 'M2 Agro-Industrie Alimentaire' AS class_name, 19 AS teacher_id, 'Marketing agroalimentaire' AS name, 'MKA401' AS code, 1.50 AS coefficient, 2 AS hours_per_week
    UNION ALL SELECT 'M2 Agro-Industrie Alimentaire' AS class_name, 20 AS teacher_id, 'Mémoire de fin d\'études' AS name, 'MFE403' AS code, 3.00 AS coefficient, 4 AS hours_per_week
    UNION ALL SELECT 'M2 Agro-Industrie Alimentaire' AS class_name, 21 AS teacher_id, 'Séminaire professionnel' AS name, 'SEM403' AS code, 1.00 AS coefficient, 2 AS hours_per_week
    UNION ALL SELECT 'M1 Entrepreneuriat Agropastoral' AS class_name, 17 AS teacher_id, 'Gestion d\'entreprise agricole' AS name, 'GEA302' AS code, 2.00 AS coefficient, 3 AS hours_per_week
    UNION ALL SELECT 'M1 Entrepreneuriat Agropastoral' AS class_name, 18 AS teacher_id, 'Marketing agricole' AS name, 'MAG301' AS code, 2.00 AS coefficient, 3 AS hours_per_week
    UNION ALL SELECT 'M1 Entrepreneuriat Agropastoral' AS class_name, 19 AS teacher_id, 'Comptabilité et finance agricole' AS name, 'CFA301' AS code, 2.00 AS coefficient, 3 AS hours_per_week
    UNION ALL SELECT 'M1 Entrepreneuriat Agropastoral' AS class_name, 20 AS teacher_id, 'Méthodologie de la recherche' AS name, 'MDR304' AS code, 1.50 AS coefficient, 2 AS hours_per_week
    UNION ALL SELECT 'M1 Entrepreneuriat Agropastoral' AS class_name, 21 AS teacher_id, 'Anglais scientifique' AS name, 'ANS304' AS code, 1.00 AS coefficient, 2 AS hours_per_week
    UNION ALL SELECT 'M2 Entrepreneuriat Agropastoral' AS class_name, 17 AS teacher_id, 'Montage de projets agropastoraux' AS name, 'MPA401' AS code, 2.00 AS coefficient, 3 AS hours_per_week
    UNION ALL SELECT 'M2 Entrepreneuriat Agropastoral' AS class_name, 18 AS teacher_id, 'Microfinance rurale' AS name, 'MFR401' AS code, 2.00 AS coefficient, 3 AS hours_per_week
    UNION ALL SELECT 'M2 Entrepreneuriat Agropastoral' AS class_name, 19 AS teacher_id, 'Droit des affaires agricoles' AS name, 'DAA401' AS code, 1.50 AS coefficient, 2 AS hours_per_week
    UNION ALL SELECT 'M2 Entrepreneuriat Agropastoral' AS class_name, 20 AS teacher_id, 'Mémoire de fin d\'études' AS name, 'MFE404' AS code, 3.00 AS coefficient, 4 AS hours_per_week
    UNION ALL SELECT 'M2 Entrepreneuriat Agropastoral' AS class_name, 21 AS teacher_id, 'Séminaire professionnel' AS name, 'SEM404' AS code, 1.00 AS coefficient, 2 AS hours_per_week
    UNION ALL SELECT 'M1 Gestion Environnementale' AS class_name, 17 AS teacher_id, 'Évaluation environnementale avancée' AS name, 'EEA301' AS code, 2.00 AS coefficient, 3 AS hours_per_week
    UNION ALL SELECT 'M1 Gestion Environnementale' AS class_name, 18 AS teacher_id, 'Changement climatique' AS name, 'CHC301' AS code, 2.00 AS coefficient, 3 AS hours_per_week
    UNION ALL SELECT 'M1 Gestion Environnementale' AS class_name, 19 AS teacher_id, 'Gestion des ressources naturelles' AS name, 'GRN301' AS code, 2.00 AS coefficient, 3 AS hours_per_week
    UNION ALL SELECT 'M1 Gestion Environnementale' AS class_name, 20 AS teacher_id, 'Méthodologie de la recherche' AS name, 'MDR305' AS code, 1.50 AS coefficient, 2 AS hours_per_week
    UNION ALL SELECT 'M1 Gestion Environnementale' AS class_name, 21 AS teacher_id, 'Anglais scientifique' AS name, 'ANS305' AS code, 1.00 AS coefficient, 2 AS hours_per_week
    UNION ALL SELECT 'M2 Gestion Environnementale' AS class_name, 17 AS teacher_id, 'Politique et gouvernance environnementale' AS name, 'PGE401' AS code, 2.00 AS coefficient, 3 AS hours_per_week
    UNION ALL SELECT 'M2 Gestion Environnementale' AS class_name, 18 AS teacher_id, 'Développement durable' AS name, 'DDU401' AS code, 2.00 AS coefficient, 3 AS hours_per_week
    UNION ALL SELECT 'M2 Gestion Environnementale' AS class_name, 19 AS teacher_id, 'Audit environnemental' AS name, 'AUE401' AS code, 1.50 AS coefficient, 2 AS hours_per_week
    UNION ALL SELECT 'M2 Gestion Environnementale' AS class_name, 20 AS teacher_id, 'Mémoire de fin d\'études' AS name, 'MFE405' AS code, 3.00 AS coefficient, 4 AS hours_per_week
    UNION ALL SELECT 'M2 Gestion Environnementale' AS class_name, 21 AS teacher_id, 'Séminaire professionnel' AS name, 'SEM405' AS code, 1.00 AS coefficient, 2 AS hours_per_week
    UNION ALL SELECT 'M1 Énergies Renouvelables' AS class_name, 17 AS teacher_id, 'Systèmes énergétiques avancés' AS name, 'SEA301' AS code, 2.00 AS coefficient, 3 AS hours_per_week
    UNION ALL SELECT 'M1 Énergies Renouvelables' AS class_name, 18 AS teacher_id, 'Efficacité énergétique' AS name, 'EFE301' AS code, 2.00 AS coefficient, 3 AS hours_per_week
    UNION ALL SELECT 'M1 Énergies Renouvelables' AS class_name, 19 AS teacher_id, 'Modélisation énergétique' AS name, 'MOE301' AS code, 2.00 AS coefficient, 3 AS hours_per_week
    UNION ALL SELECT 'M1 Énergies Renouvelables' AS class_name, 20 AS teacher_id, 'Méthodologie de la recherche' AS name, 'MDR306' AS code, 1.50 AS coefficient, 2 AS hours_per_week
    UNION ALL SELECT 'M1 Énergies Renouvelables' AS class_name, 21 AS teacher_id, 'Anglais scientifique' AS name, 'ANS306' AS code, 1.00 AS coefficient, 2 AS hours_per_week
    UNION ALL SELECT 'M2 Énergies Renouvelables' AS class_name, 17 AS teacher_id, 'Réseaux électriques intelligents' AS name, 'RSI401' AS code, 2.00 AS coefficient, 3 AS hours_per_week
    UNION ALL SELECT 'M2 Énergies Renouvelables' AS class_name, 18 AS teacher_id, 'Politique énergétique' AS name, 'POE401' AS code, 1.50 AS coefficient, 2 AS hours_per_week
    UNION ALL SELECT 'M2 Énergies Renouvelables' AS class_name, 19 AS teacher_id, 'Gestion de projets énergétiques avancée' AS name, 'GPE402' AS code, 2.00 AS coefficient, 3 AS hours_per_week
    UNION ALL SELECT 'M2 Énergies Renouvelables' AS class_name, 20 AS teacher_id, 'Mémoire de fin d\'études' AS name, 'MFE406' AS code, 3.00 AS coefficient, 4 AS hours_per_week
    UNION ALL SELECT 'M2 Énergies Renouvelables' AS class_name, 21 AS teacher_id, 'Séminaire professionnel' AS name, 'SEM406' AS code, 1.00 AS coefficient, 2 AS hours_per_week
) t ON t.class_name = c.name
WHERE c.academic_year_id = 3;

-- ÉTAPE 2 : liaison dans le pivot `class_subjects`
-- (reprend exactement les valeurs des matières qu'on vient de créer)

INSERT INTO `class_subjects` (`class_id`, `subject_id`, `teacher_id`, `coefficient`, `hours_per_week`)
SELECT s.class_id, s.id, s.teacher_id, s.coefficient, s.hours_per_week
FROM `subjects` s
JOIN `classes` c ON c.id = s.class_id
WHERE c.academic_year_id = 3;