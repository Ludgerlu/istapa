-- ============================================================
-- 1) Nettoyage : suppression des matières génériques de
--    HND1/HND2 Production Animale (remplacées par le vrai
--    programme APT ci-dessous). Le CASCADE existant sur
--    class_subjects.subject_id nettoie automatiquement le pivot.
-- ============================================================

DELETE s FROM `subjects` s
JOIN `classes` c ON c.id = s.class_id
WHERE c.name IN ('HND1 Production Animale', 'HND2 Production Animale')
  AND c.academic_year_id = 3;

-- ============================================================
-- 2) Création des 8 nouvelles classes BTS1/BTS2
-- ============================================================

INSERT INTO `classes` (`program_id`, `academic_year_id`, `name`, `section`, `head_teacher_id`) VALUES
(1, 3, 'BTS1 Production Animale', 'A', 18),
(1, 3, 'BTS2 Production Animale', 'A', 18),
(2, 3, 'BTS1 Production Végétale', 'A', 18),
(2, 3, 'BTS2 Production Végétale', 'A', 18),
(3, 3, 'BTS1 Gestion Environnementale', 'A', 18),
(3, 3, 'BTS2 Gestion Environnementale', 'A', 18),
(4, 3, 'BTS1 Énergies Renouvelables', 'A', 18),
(4, 3, 'BTS2 Énergies Renouvelables', 'A', 18);

-- ============================================================
-- 3) Insertion des vraies matières (140 au total : 5 programmes
--    x 4 semestres x 7 matières), reliées par nom de classe
-- ============================================================

INSERT INTO `subjects` (`class_id`, `teacher_id`, `name`, `code`, `coefficient`, `hours_per_week`)
SELECT c.id, t.teacher_id, t.name, t.code, t.credits, t.credits
FROM `classes` c
JOIN (
    SELECT 'HND1 Production Animale' AS class_name, 17 AS teacher_id, 'Physics and Chemistry' AS name, 'APT111' AS code, 5.00 AS credits
    UNION ALL SELECT 'HND1 Production Animale' AS class_name, 18 AS teacher_id, 'Mathematics' AS name, 'APT112' AS code, 4.00 AS credits
    UNION ALL SELECT 'HND1 Production Animale' AS class_name, 19 AS teacher_id, 'Principles of animal production' AS name, 'APT113' AS code, 4.00 AS credits
    UNION ALL SELECT 'HND1 Production Animale' AS class_name, 20 AS teacher_id, 'Pasture and Range Management' AS name, 'APT114' AS code, 4.00 AS credits
    UNION ALL SELECT 'HND1 Production Animale' AS class_name, 21 AS teacher_id, 'Animal Housing and Husbandry Techniques' AS name, 'APT115' AS code, 5.00 AS credits
    UNION ALL SELECT 'HND1 Production Animale' AS class_name, 17 AS teacher_id, 'Anatomy and Physiology of Farm Animals' AS name, 'APT116' AS code, 5.00 AS credits
    UNION ALL SELECT 'HND1 Production Animale' AS class_name, 18 AS teacher_id, 'Bilingual Training' AS name, 'APT117' AS code, 3.00 AS credits
    UNION ALL SELECT 'HND1 Production Animale' AS class_name, 19 AS teacher_id, 'Biochemistry and Microbiology' AS name, 'APT121' AS code, 5.00 AS credits
    UNION ALL SELECT 'HND1 Production Animale' AS class_name, 20 AS teacher_id, 'Statistics and Probability' AS name, 'APT122' AS code, 4.00 AS credits
    UNION ALL SELECT 'HND1 Production Animale' AS class_name, 21 AS teacher_id, 'Genetics and Breeding' AS name, 'APT123' AS code, 4.00 AS credits
    UNION ALL SELECT 'HND1 Production Animale' AS class_name, 17 AS teacher_id, 'Ruminant Animal Production' AS name, 'APT124' AS code, 5.00 AS credits
    UNION ALL SELECT 'HND1 Production Animale' AS class_name, 18 AS teacher_id, 'Applied Nutrition' AS name, 'APT125' AS code, 5.00 AS credits
    UNION ALL SELECT 'HND1 Production Animale' AS class_name, 19 AS teacher_id, 'Animal Reproduction and Physiology' AS name, 'APT126' AS code, 4.00 AS credits
    UNION ALL SELECT 'HND1 Production Animale' AS class_name, 20 AS teacher_id, 'Civic Education and Ethics / Initiation to the Law' AS name, 'APT127' AS code, 3.00 AS credits
    UNION ALL SELECT 'HND2 Production Animale' AS class_name, 21 AS teacher_id, 'Genetics and selection' AS name, 'APT231' AS code, 5.00 AS credits
    UNION ALL SELECT 'HND2 Production Animale' AS class_name, 17 AS teacher_id, 'General Ledger' AS name, 'APT232' AS code, 4.00 AS credits
    UNION ALL SELECT 'HND2 Production Animale' AS class_name, 18 AS teacher_id, 'Non-ruminant animal production' AS name, 'APT233' AS code, 5.00 AS credits
    UNION ALL SELECT 'HND2 Production Animale' AS class_name, 19 AS teacher_id, 'Livestock Diseases and Health Care' AS name, 'APT234' AS code, 5.00 AS credits
    UNION ALL SELECT 'HND2 Production Animale' AS class_name, 20 AS teacher_id, 'Principles of Aquaculture' AS name, 'APT235' AS code, 4.00 AS credits
    UNION ALL SELECT 'HND2 Production Animale' AS class_name, 21 AS teacher_id, 'Non-conventional Animal Production' AS name, 'APT236' AS code, 4.00 AS credits
    UNION ALL SELECT 'HND2 Production Animale' AS class_name, 17 AS teacher_id, 'Computing and multi-media' AS name, 'APT237' AS code, 3.00 AS credits
    UNION ALL SELECT 'HND2 Production Animale' AS class_name, 18 AS teacher_id, 'Markets and agricultural sectors' AS name, 'APT241' AS code, 4.00 AS credits
    UNION ALL SELECT 'HND2 Production Animale' AS class_name, 19 AS teacher_id, 'Rural Sociology and agricultural extension' AS name, 'APT242' AS code, 5.00 AS credits
    UNION ALL SELECT 'HND2 Production Animale' AS class_name, 20 AS teacher_id, 'Pisciculture' AS name, 'APT243' AS code, 4.00 AS credits
    UNION ALL SELECT 'HND2 Production Animale' AS class_name, 21 AS teacher_id, 'Conduct of other farms' AS name, 'APT244' AS code, 4.00 AS credits
    UNION ALL SELECT 'HND2 Production Animale' AS class_name, 17 AS teacher_id, 'Mechanization and equipment / livestock buildings' AS name, 'APT245' AS code, 4.00 AS credits
    UNION ALL SELECT 'HND2 Production Animale' AS class_name, 18 AS teacher_id, 'Professional internship' AS name, 'APT246' AS code, 6.00 AS credits
    UNION ALL SELECT 'HND2 Production Animale' AS class_name, 19 AS teacher_id, 'Economy and Management of businesses' AS name, 'APT247' AS code, 3.00 AS credits
    UNION ALL SELECT 'BTS1 Production Animale' AS class_name, 20 AS teacher_id, 'Physique et chimie' AS name, 'PAN111' AS code, 4.00 AS credits
    UNION ALL SELECT 'BTS1 Production Animale' AS class_name, 21 AS teacher_id, 'Mathématiques et TIC' AS name, 'PAN112' AS code, 5.00 AS credits
    UNION ALL SELECT 'BTS1 Production Animale' AS class_name, 17 AS teacher_id, 'Ecologie appliquée et environnement' AS name, 'PAN113' AS code, 4.00 AS credits
    UNION ALL SELECT 'BTS1 Production Animale' AS class_name, 18 AS teacher_id, 'Biologie' AS name, 'PAN114' AS code, 4.00 AS credits
    UNION ALL SELECT 'BTS1 Production Animale' AS class_name, 19 AS teacher_id, 'Connaissances de base en zootechnie' AS name, 'PAN115' AS code, 5.00 AS credits
    UNION ALL SELECT 'BTS1 Production Animale' AS class_name, 20 AS teacher_id, 'Anatomie et physiologie animales' AS name, 'PAN116' AS code, 5.00 AS credits
    UNION ALL SELECT 'BTS1 Production Animale' AS class_name, 21 AS teacher_id, 'Formation Bilingue' AS name, 'PAN117' AS code, 3.00 AS credits
    UNION ALL SELECT 'BTS1 Production Animale' AS class_name, 17 AS teacher_id, 'Biochimie et Microbiologie' AS name, 'PAN121' AS code, 5.00 AS credits
    UNION ALL SELECT 'BTS1 Production Animale' AS class_name, 18 AS teacher_id, 'Statistiques et Probabilités' AS name, 'PAN122' AS code, 4.00 AS credits
    UNION ALL SELECT 'BTS1 Production Animale' AS class_name, 19 AS teacher_id, 'Agro-climatologie' AS name, 'PAN123' AS code, 4.00 AS credits
    UNION ALL SELECT 'BTS1 Production Animale' AS class_name, 20 AS teacher_id, 'Biosécurité et prophylaxie animale' AS name, 'PAN124' AS code, 5.00 AS credits
    UNION ALL SELECT 'BTS1 Production Animale' AS class_name, 21 AS teacher_id, 'Nutrition animale' AS name, 'PAN125' AS code, 5.00 AS credits
    UNION ALL SELECT 'BTS1 Production Animale' AS class_name, 17 AS teacher_id, 'Marchés et filières agricoles' AS name, 'PAN126' AS code, 4.00 AS credits
    UNION ALL SELECT 'BTS1 Production Animale' AS class_name, 18 AS teacher_id, 'Economie et gestion des entreprises' AS name, 'PAN127' AS code, 3.00 AS credits
    UNION ALL SELECT 'BTS2 Production Animale' AS class_name, 19 AS teacher_id, 'Génétique et sélection des espèces animales' AS name, 'PAN231' AS code, 6.00 AS credits
    UNION ALL SELECT 'BTS2 Production Animale' AS class_name, 20 AS teacher_id, 'Commercialisation des produits d\'origine animale' AS name, 'PAN232' AS code, 3.00 AS credits
    UNION ALL SELECT 'BTS2 Production Animale' AS class_name, 21 AS teacher_id, 'Conduite d\'élevage des polygastriques (bovins, ovins, caprins...)' AS name, 'PAN233' AS code, 5.00 AS credits
    UNION ALL SELECT 'BTS2 Production Animale' AS class_name, 17 AS teacher_id, 'Conduite d\'élevage des Volailles' AS name, 'PAN234' AS code, 5.00 AS credits
    UNION ALL SELECT 'BTS2 Production Animale' AS class_name, 18 AS teacher_id, 'Conduite d\'élevage des porcins' AS name, 'PAN235' AS code, 5.00 AS credits
    UNION ALL SELECT 'BTS2 Production Animale' AS class_name, 19 AS teacher_id, 'Topographie appliquée et construction des fermes' AS name, 'PAN236' AS code, 3.00 AS credits
    UNION ALL SELECT 'BTS2 Production Animale' AS class_name, 20 AS teacher_id, 'Education citoyenne et déontologie professionnelle' AS name, 'PAN237' AS code, 3.00 AS credits
    UNION ALL SELECT 'BTS2 Production Animale' AS class_name, 21 AS teacher_id, 'Techniques de transformation, de conditionnement et de conservation' AS name, 'PAN241' AS code, 4.00 AS credits
    UNION ALL SELECT 'BTS2 Production Animale' AS class_name, 17 AS teacher_id, 'Sociologie rurale et vulgarisation agricole' AS name, 'PAN242' AS code, 5.00 AS credits
    UNION ALL SELECT 'BTS2 Production Animale' AS class_name, 18 AS teacher_id, 'Pisciculture et Conduite d\'autres élevages' AS name, 'PAN243' AS code, 4.00 AS credits
    UNION ALL SELECT 'BTS2 Production Animale' AS class_name, 19 AS teacher_id, 'Hygiène et qualité des produits d\'origine animale' AS name, 'PAN244' AS code, 2.00 AS credits
    UNION ALL SELECT 'BTS2 Production Animale' AS class_name, 20 AS teacher_id, 'Mécanisation et équipements / Bâtiments d\'élevage' AS name, 'PAN245' AS code, 4.00 AS credits
    UNION ALL SELECT 'BTS2 Production Animale' AS class_name, 21 AS teacher_id, 'Stage professionnel' AS name, 'PAN246' AS code, 6.00 AS credits
    UNION ALL SELECT 'BTS2 Production Animale' AS class_name, 17 AS teacher_id, 'Entrepreneuriat et Marketing appliqué aux disciplines' AS name, 'PAN247' AS code, 3.00 AS credits
    UNION ALL SELECT 'BTS1 Production Végétale' AS class_name, 18 AS teacher_id, 'Physique et chimie' AS name, 'PVE111' AS code, 4.00 AS credits
    UNION ALL SELECT 'BTS1 Production Végétale' AS class_name, 19 AS teacher_id, 'Mathématiques et TIC' AS name, 'PVE112' AS code, 5.00 AS credits
    UNION ALL SELECT 'BTS1 Production Végétale' AS class_name, 20 AS teacher_id, 'Ecologie appliquée' AS name, 'PVE113' AS code, 4.00 AS credits
    UNION ALL SELECT 'BTS1 Production Végétale' AS class_name, 21 AS teacher_id, 'Connaissance de base en production végétale' AS name, 'PVE114' AS code, 5.00 AS credits
    UNION ALL SELECT 'BTS1 Production Végétale' AS class_name, 17 AS teacher_id, 'Biologie' AS name, 'PVE115' AS code, 4.00 AS credits
    UNION ALL SELECT 'BTS1 Production Végétale' AS class_name, 18 AS teacher_id, 'Pédologie' AS name, 'PVE116' AS code, 5.00 AS credits
    UNION ALL SELECT 'BTS1 Production Végétale' AS class_name, 19 AS teacher_id, 'Formation Bilingue' AS name, 'PVE117' AS code, 3.00 AS credits
    UNION ALL SELECT 'BTS1 Production Végétale' AS class_name, 20 AS teacher_id, 'Biochimie et Microbiologie' AS name, 'PVE121' AS code, 5.00 AS credits
    UNION ALL SELECT 'BTS1 Production Végétale' AS class_name, 21 AS teacher_id, 'Statistiques et Probabilités' AS name, 'PVE122' AS code, 4.00 AS credits
    UNION ALL SELECT 'BTS1 Production Végétale' AS class_name, 17 AS teacher_id, 'Agro climatologie' AS name, 'PVE123' AS code, 4.00 AS credits
    UNION ALL SELECT 'BTS1 Production Végétale' AS class_name, 18 AS teacher_id, 'Agroforesterie' AS name, 'PVE124' AS code, 5.00 AS credits
    UNION ALL SELECT 'BTS1 Production Végétale' AS class_name, 19 AS teacher_id, 'Phytopathologie et défense des cultures' AS name, 'PVE125' AS code, 6.00 AS credits
    UNION ALL SELECT 'BTS1 Production Végétale' AS class_name, 20 AS teacher_id, 'Stage monographique' AS name, 'PVE126' AS code, 3.00 AS credits
    UNION ALL SELECT 'BTS1 Production Végétale' AS class_name, 21 AS teacher_id, 'Economie et gestion des entreprises' AS name, 'PVE127' AS code, 3.00 AS credits
    UNION ALL SELECT 'BTS2 Production Végétale' AS class_name, 17 AS teacher_id, 'Génétique et sélection des espèces végétales' AS name, 'PVE231' AS code, 6.00 AS credits
    UNION ALL SELECT 'BTS2 Production Végétale' AS class_name, 18 AS teacher_id, 'Fertilité et Fertilisation' AS name, 'PVE232' AS code, 3.00 AS credits
    UNION ALL SELECT 'BTS2 Production Végétale' AS class_name, 19 AS teacher_id, 'Conduite durable des productions végétales' AS name, 'PVE233' AS code, 6.00 AS credits
    UNION ALL SELECT 'BTS2 Production Végétale' AS class_name, 20 AS teacher_id, 'Horticulture maraîchère et ornementale' AS name, 'PVE234' AS code, 5.00 AS credits
    UNION ALL SELECT 'BTS2 Production Végétale' AS class_name, 21 AS teacher_id, 'Cultures pérennes' AS name, 'PVE235' AS code, 4.00 AS credits
    UNION ALL SELECT 'BTS2 Production Végétale' AS class_name, 17 AS teacher_id, 'Topographie et Construction rurale' AS name, 'PVE236' AS code, 3.00 AS credits
    UNION ALL SELECT 'BTS2 Production Végétale' AS class_name, 18 AS teacher_id, 'Education citoyenne et déontologie professionnelle' AS name, 'PVE237' AS code, 3.00 AS credits
    UNION ALL SELECT 'BTS2 Production Végétale' AS class_name, 19 AS teacher_id, 'Marchés et filières agropastorales' AS name, 'PVE241' AS code, 4.00 AS credits
    UNION ALL SELECT 'BTS2 Production Végétale' AS class_name, 20 AS teacher_id, 'Sociologie rurale et vulgarisation agricole' AS name, 'PVE242' AS code, 5.00 AS credits
    UNION ALL SELECT 'BTS2 Production Végétale' AS class_name, 21 AS teacher_id, 'Systèmes semenciers' AS name, 'PVE243' AS code, 4.00 AS credits
    UNION ALL SELECT 'BTS2 Production Végétale' AS class_name, 17 AS teacher_id, 'Techniques de transformation, de conditionnement et de conservation des produits agricoles' AS name, 'PVE244' AS code, 4.00 AS credits
    UNION ALL SELECT 'BTS2 Production Végétale' AS class_name, 18 AS teacher_id, 'Mécanisation agropastorale et maintenance des infrastructures, des équipements et des matériels de production' AS name, 'PVE245' AS code, 4.00 AS credits
    UNION ALL SELECT 'BTS2 Production Végétale' AS class_name, 19 AS teacher_id, 'Stage professionnel' AS name, 'PVE246' AS code, 6.00 AS credits
    UNION ALL SELECT 'BTS2 Production Végétale' AS class_name, 20 AS teacher_id, 'Entrepreneuriat et marketing' AS name, 'PVE247' AS code, 3.00 AS credits
    UNION ALL SELECT 'BTS1 Gestion Environnementale' AS class_name, 21 AS teacher_id, 'Mathématiques' AS name, 'GEN111' AS code, 4.00 AS credits
    UNION ALL SELECT 'BTS1 Gestion Environnementale' AS class_name, 17 AS teacher_id, 'Economie rurale' AS name, 'GEN112' AS code, 5.00 AS credits
    UNION ALL SELECT 'BTS1 Gestion Environnementale' AS class_name, 18 AS teacher_id, 'Topographie et Dessin technique' AS name, 'GEN113' AS code, 5.00 AS credits
    UNION ALL SELECT 'BTS1 Gestion Environnementale' AS class_name, 19 AS teacher_id, 'Hydraulique générale' AS name, 'GEN114' AS code, 4.00 AS credits
    UNION ALL SELECT 'BTS1 Gestion Environnementale' AS class_name, 20 AS teacher_id, 'Ecosystèmes et Milieux naturels' AS name, 'GEN115' AS code, 4.00 AS credits
    UNION ALL SELECT 'BTS1 Gestion Environnementale' AS class_name, 21 AS teacher_id, 'Pollution et Nuisances' AS name, 'GEN116' AS code, 5.00 AS credits
    UNION ALL SELECT 'BTS1 Gestion Environnementale' AS class_name, 17 AS teacher_id, 'Formation bilingue' AS name, 'GEN117' AS code, 3.00 AS credits
    UNION ALL SELECT 'BTS1 Gestion Environnementale' AS class_name, 18 AS teacher_id, 'Physique' AS name, 'GEN121' AS code, 4.00 AS credits
    UNION ALL SELECT 'BTS1 Gestion Environnementale' AS class_name, 19 AS teacher_id, 'Informatique appliquée et multimédia' AS name, 'GEN122' AS code, 5.00 AS credits
    UNION ALL SELECT 'BTS1 Gestion Environnementale' AS class_name, 20 AS teacher_id, 'Assainissement I' AS name, 'GEN123' AS code, 4.00 AS credits
    UNION ALL SELECT 'BTS1 Gestion Environnementale' AS class_name, 21 AS teacher_id, 'Irrigation' AS name, 'GEN124' AS code, 4.00 AS credits
    UNION ALL SELECT 'BTS1 Gestion Environnementale' AS class_name, 17 AS teacher_id, 'Biodiversité' AS name, 'GEN125' AS code, 4.00 AS credits
    UNION ALL SELECT 'BTS1 Gestion Environnementale' AS class_name, 18 AS teacher_id, 'Aménagements' AS name, 'GEN126' AS code, 6.00 AS credits
    UNION ALL SELECT 'BTS1 Gestion Environnementale' AS class_name, 19 AS teacher_id, 'Economie et Gestion des entreprises' AS name, 'GEN127' AS code, 3.00 AS credits
    UNION ALL SELECT 'BTS2 Gestion Environnementale' AS class_name, 20 AS teacher_id, 'Sociologie rurale' AS name, 'GEN231' AS code, 4.00 AS credits
    UNION ALL SELECT 'BTS2 Gestion Environnementale' AS class_name, 21 AS teacher_id, 'Vulgarisation rurale' AS name, 'GEN232' AS code, 5.00 AS credits
    UNION ALL SELECT 'BTS2 Gestion Environnementale' AS class_name, 17 AS teacher_id, 'Assainissement II' AS name, 'GEN233' AS code, 5.00 AS credits
    UNION ALL SELECT 'BTS2 Gestion Environnementale' AS class_name, 18 AS teacher_id, 'Environnement et développement durable' AS name, 'GEN234' AS code, 5.00 AS credits
    UNION ALL SELECT 'BTS2 Gestion Environnementale' AS class_name, 19 AS teacher_id, 'Protection des milieux naturels et des paysages' AS name, 'GEN235' AS code, 5.00 AS credits
    UNION ALL SELECT 'BTS2 Gestion Environnementale' AS class_name, 20 AS teacher_id, 'Traitement des déchets' AS name, 'GEN236' AS code, 3.00 AS credits
    UNION ALL SELECT 'BTS2 Gestion Environnementale' AS class_name, 21 AS teacher_id, 'Education citoyenne et déontologie' AS name, 'GEN237' AS code, 3.00 AS credits
    UNION ALL SELECT 'BTS2 Gestion Environnementale' AS class_name, 17 AS teacher_id, 'Géographie économique' AS name, 'GEN241' AS code, 4.00 AS credits
    UNION ALL SELECT 'BTS2 Gestion Environnementale' AS class_name, 18 AS teacher_id, 'Pédologie' AS name, 'GEN242' AS code, 5.00 AS credits
    UNION ALL SELECT 'BTS2 Gestion Environnementale' AS class_name, 19 AS teacher_id, 'Assainissement III' AS name, 'GEN243' AS code, 4.00 AS credits
    UNION ALL SELECT 'BTS2 Gestion Environnementale' AS class_name, 20 AS teacher_id, 'Lutte contre la pollution' AS name, 'GEN244' AS code, 3.00 AS credits
    UNION ALL SELECT 'BTS2 Gestion Environnementale' AS class_name, 21 AS teacher_id, 'Projet tutoré' AS name, 'GEN245' AS code, 5.00 AS credits
    UNION ALL SELECT 'BTS2 Gestion Environnementale' AS class_name, 17 AS teacher_id, 'Stage professionnel' AS name, 'GEN246' AS code, 6.00 AS credits
    UNION ALL SELECT 'BTS2 Gestion Environnementale' AS class_name, 18 AS teacher_id, 'Entrepreneuriat et Marketing appliqué aux disciplines' AS name, 'GEN247' AS code, 3.00 AS credits
    UNION ALL SELECT 'BTS1 Énergies Renouvelables' AS class_name, 19 AS teacher_id, 'Mathématiques I' AS name, 'ENR111' AS code, 4.00 AS credits
    UNION ALL SELECT 'BTS1 Énergies Renouvelables' AS class_name, 20 AS teacher_id, 'TIC I' AS name, 'ENR112' AS code, 5.00 AS credits
    UNION ALL SELECT 'BTS1 Énergies Renouvelables' AS class_name, 21 AS teacher_id, 'Electricité générale et Circuits électriques' AS name, 'ENR113' AS code, 5.00 AS credits
    UNION ALL SELECT 'BTS1 Énergies Renouvelables' AS class_name, 17 AS teacher_id, 'Machine électrique I' AS name, 'ENR114' AS code, 4.00 AS credits
    UNION ALL SELECT 'BTS1 Énergies Renouvelables' AS class_name, 18 AS teacher_id, 'Electronique et automatisme' AS name, 'ENR115' AS code, 5.00 AS credits
    UNION ALL SELECT 'BTS1 Énergies Renouvelables' AS class_name, 19 AS teacher_id, 'Sources et stockage d\'énergies' AS name, 'ENR116' AS code, 4.00 AS credits
    UNION ALL SELECT 'BTS1 Énergies Renouvelables' AS class_name, 20 AS teacher_id, 'Formation bilingue' AS name, 'ENR117' AS code, 3.00 AS credits
    UNION ALL SELECT 'BTS1 Énergies Renouvelables' AS class_name, 21 AS teacher_id, 'Mathématiques II' AS name, 'ENR121' AS code, 4.00 AS credits
    UNION ALL SELECT 'BTS1 Énergies Renouvelables' AS class_name, 17 AS teacher_id, 'Physique et Chimie I' AS name, 'ENR122' AS code, 5.00 AS credits
    UNION ALL SELECT 'BTS1 Énergies Renouvelables' AS class_name, 18 AS teacher_id, 'Machines électriques et techniques de mesures' AS name, 'ENR123' AS code, 5.00 AS credits
    UNION ALL SELECT 'BTS1 Énergies Renouvelables' AS class_name, 19 AS teacher_id, 'Mécanique des fluides et Transfert thermique I' AS name, 'ENR124' AS code, 5.00 AS credits
    UNION ALL SELECT 'BTS1 Énergies Renouvelables' AS class_name, 20 AS teacher_id, 'Energies Renouvelables I' AS name, 'ENR125' AS code, 4.00 AS credits
    UNION ALL SELECT 'BTS1 Énergies Renouvelables' AS class_name, 21 AS teacher_id, 'CAO et DAO en Energies renouvelables' AS name, 'ENR126' AS code, 4.00 AS credits
    UNION ALL SELECT 'BTS1 Énergies Renouvelables' AS class_name, 17 AS teacher_id, 'Economie et Gestion des entreprises' AS name, 'ENR127' AS code, 3.00 AS credits
    UNION ALL SELECT 'BTS2 Énergies Renouvelables' AS class_name, 18 AS teacher_id, 'Statistiques et TIC II' AS name, 'ENR231' AS code, 4.00 AS credits
    UNION ALL SELECT 'BTS2 Énergies Renouvelables' AS class_name, 19 AS teacher_id, 'Physique II et Base QHSE' AS name, 'ENR232' AS code, 5.00 AS credits
    UNION ALL SELECT 'BTS2 Énergies Renouvelables' AS class_name, 20 AS teacher_id, 'Productions et schémas + TP' AS name, 'ENR233' AS code, 5.00 AS credits
    UNION ALL SELECT 'BTS2 Énergies Renouvelables' AS class_name, 21 AS teacher_id, 'Transfert thermique II et Fluides et réseaux' AS name, 'ENR234' AS code, 5.00 AS credits
    UNION ALL SELECT 'BTS2 Énergies Renouvelables' AS class_name, 17 AS teacher_id, 'Energies Renouvelables II' AS name, 'ENR235' AS code, 4.00 AS credits
    UNION ALL SELECT 'BTS2 Énergies Renouvelables' AS class_name, 18 AS teacher_id, 'Efficacité énergétique et couplage au réseau' AS name, 'ENR236' AS code, 4.00 AS credits
    UNION ALL SELECT 'BTS2 Énergies Renouvelables' AS class_name, 19 AS teacher_id, 'Education citoyenne et déontologie professionnelle' AS name, 'ENR237' AS code, 3.00 AS credits
    UNION ALL SELECT 'BTS2 Énergies Renouvelables' AS class_name, 20 AS teacher_id, 'Mathématiques III' AS name, 'ENR241' AS code, 5.00 AS credits
    UNION ALL SELECT 'BTS2 Énergies Renouvelables' AS class_name, 21 AS teacher_id, 'Normes et Réglementation en Thermique et Energétique' AS name, 'ENR242' AS code, 4.00 AS credits
    UNION ALL SELECT 'BTS2 Énergies Renouvelables' AS class_name, 17 AS teacher_id, 'Dimensionnement et maintenance des systèmes énergétiques' AS name, 'ENR243' AS code, 4.00 AS credits
    UNION ALL SELECT 'BTS2 Énergies Renouvelables' AS class_name, 18 AS teacher_id, 'Installations électriques et appareillages' AS name, 'ENR244' AS code, 3.00 AS credits
    UNION ALL SELECT 'BTS2 Énergies Renouvelables' AS class_name, 19 AS teacher_id, 'TP Energie renouvelables' AS name, 'ENR245' AS code, 5.00 AS credits
    UNION ALL SELECT 'BTS2 Énergies Renouvelables' AS class_name, 20 AS teacher_id, 'Stage professionnel' AS name, 'ENR246' AS code, 6.00 AS credits
    UNION ALL SELECT 'BTS2 Énergies Renouvelables' AS class_name, 21 AS teacher_id, 'Entrepreneuriat et marketing appliqué aux disciplines' AS name, 'ENR247' AS code, 3.00 AS credits
) t ON t.class_name = c.name
WHERE c.academic_year_id = 3;

-- ============================================================
-- 4) Liaison dans le pivot class_subjects (reprend les lignes
--    qu'on vient de créer dans subjects)
-- ============================================================

INSERT INTO `class_subjects` (`class_id`, `subject_id`, `teacher_id`, `coefficient`, `hours_per_week`)
SELECT s.class_id, s.id, s.teacher_id, s.coefficient, s.hours_per_week
FROM `subjects` s
JOIN `classes` c ON c.id = s.class_id
WHERE c.name IN (
    'HND1 Production Animale',
    'HND2 Production Animale',
    'BTS1 Production Animale',
    'BTS2 Production Animale',
    'BTS1 Production Végétale',
    'BTS2 Production Végétale',
    'BTS1 Gestion Environnementale',
    'BTS2 Gestion Environnementale',
    'BTS1 Énergies Renouvelables',
    'BTS2 Énergies Renouvelables'
) AND c.academic_year_id = 3;-- ============================================================
-- Étudiants fictifs de test (96 au total, 6 par classe)
-- Emails/matricules clairement identifiables : à adapter ou
-- supprimer une fois les vraies inscriptions disponibles.
-- ============================================================

-- 1) Comptes utilisateurs
INSERT INTO `users` (`email`, `password_hash`, `role`, `first_name`, `last_name`, `gender`, `city`, `country`, `preferred_language`) VALUES
('etudiant.test001@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Patrick', 'Fotso', 'M', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test002@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Sandrine', 'Njoya', 'F', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test003@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Serge', 'Owona', 'M', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test004@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Pauline', 'Amougou', 'F', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test005@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Hervé', 'Sonkeng', 'M', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test006@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Carine', 'Nkolo', 'F', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test007@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Aristide', 'Ekotto', 'M', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test008@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Stephanie', 'Talla', 'F', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test009@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Rodrigue', 'Kamdem', 'M', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test010@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Divine', 'Tchoumi', 'F', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test011@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Boris', 'Djeukam', 'M', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test012@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Marie', 'Kenfack', 'F', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test013@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Patrick', 'Zambo', 'M', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test014@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Sandrine', 'Nguema', 'F', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test015@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Serge', 'Biya', 'M', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test016@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Pauline', 'Essomba', 'F', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test017@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Hervé', 'Ngo Bell', 'M', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test018@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Carine', 'Mbarga', 'F', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test019@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Aristide', 'Tabi', 'M', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test020@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Stephanie', 'Mballa', 'F', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test021@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Rodrigue', 'Fotso', 'M', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test022@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Divine', 'Njoya', 'F', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test023@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Boris', 'Owona', 'M', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test024@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Marie', 'Amougou', 'F', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test025@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Patrick', 'Sonkeng', 'M', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test026@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Sandrine', 'Nkolo', 'F', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test027@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Serge', 'Ekotto', 'M', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test028@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Pauline', 'Talla', 'F', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test029@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Hervé', 'Kamdem', 'M', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test030@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Carine', 'Tchoumi', 'F', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test031@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Aristide', 'Djeukam', 'M', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test032@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Stephanie', 'Kenfack', 'F', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test033@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Rodrigue', 'Zambo', 'M', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test034@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Divine', 'Nguema', 'F', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test035@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Boris', 'Biya', 'M', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test036@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Marie', 'Essomba', 'F', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test037@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Patrick', 'Ngo Bell', 'M', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test038@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Sandrine', 'Mbarga', 'F', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test039@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Serge', 'Tabi', 'M', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test040@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Pauline', 'Mballa', 'F', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test041@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Hervé', 'Fotso', 'M', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test042@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Carine', 'Njoya', 'F', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test043@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Aristide', 'Owona', 'M', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test044@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Stephanie', 'Amougou', 'F', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test045@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Rodrigue', 'Sonkeng', 'M', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test046@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Divine', 'Nkolo', 'F', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test047@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Boris', 'Ekotto', 'M', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test048@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Marie', 'Talla', 'F', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test049@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Patrick', 'Kamdem', 'M', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test050@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Sandrine', 'Tchoumi', 'F', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test051@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Serge', 'Djeukam', 'M', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test052@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Pauline', 'Kenfack', 'F', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test053@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Hervé', 'Zambo', 'M', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test054@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Carine', 'Nguema', 'F', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test055@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Aristide', 'Biya', 'M', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test056@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Stephanie', 'Essomba', 'F', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test057@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Rodrigue', 'Ngo Bell', 'M', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test058@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Divine', 'Mbarga', 'F', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test059@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Boris', 'Tabi', 'M', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test060@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Marie', 'Mballa', 'F', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test061@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Patrick', 'Fotso', 'M', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test062@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Sandrine', 'Njoya', 'F', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test063@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Serge', 'Owona', 'M', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test064@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Pauline', 'Amougou', 'F', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test065@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Hervé', 'Sonkeng', 'M', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test066@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Carine', 'Nkolo', 'F', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test067@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Aristide', 'Ekotto', 'M', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test068@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Stephanie', 'Talla', 'F', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test069@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Rodrigue', 'Kamdem', 'M', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test070@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Divine', 'Tchoumi', 'F', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test071@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Boris', 'Djeukam', 'M', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test072@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Marie', 'Kenfack', 'F', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test073@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Patrick', 'Zambo', 'M', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test074@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Sandrine', 'Nguema', 'F', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test075@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Serge', 'Biya', 'M', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test076@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Pauline', 'Essomba', 'F', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test077@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Hervé', 'Ngo Bell', 'M', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test078@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Carine', 'Mbarga', 'F', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test079@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Aristide', 'Tabi', 'M', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test080@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Stephanie', 'Mballa', 'F', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test081@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Rodrigue', 'Fotso', 'M', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test082@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Divine', 'Njoya', 'F', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test083@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Boris', 'Owona', 'M', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test084@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Marie', 'Amougou', 'F', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test085@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Patrick', 'Sonkeng', 'M', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test086@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Sandrine', 'Nkolo', 'F', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test087@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Serge', 'Ekotto', 'M', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test088@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Pauline', 'Talla', 'F', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test089@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Hervé', 'Kamdem', 'M', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test090@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Carine', 'Tchoumi', 'F', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test091@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Aristide', 'Djeukam', 'M', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test092@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Stephanie', 'Kenfack', 'F', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test093@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Rodrigue', 'Zambo', 'M', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test094@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Divine', 'Nguema', 'F', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test095@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Boris', 'Biya', 'M', 'Yaoundé', 'Cameroun', 'fr'),
('etudiant.test096@istapa-test.site', '$2y$12$2iQ6qQLNMolJ8tndRD2s7uxauCygSgX1WfY092eBkXzhRo9.blBK.', 'student', 'Marie', 'Essomba', 'F', 'Yaoundé', 'Cameroun', 'fr');

-- 2) Fiches étudiant (matricule), reliées par email
INSERT INTO `students` (`user_id`, `matricule`, `enrollment_date`)
SELECT u.id, t.matricule, '2026-09-01'
FROM `users` u
JOIN (
    SELECT 'etudiant.test001@istapa-test.site' AS email, 'IST26-001' AS matricule
    UNION ALL SELECT 'etudiant.test002@istapa-test.site' AS email, 'IST26-002' AS matricule
    UNION ALL SELECT 'etudiant.test003@istapa-test.site' AS email, 'IST26-003' AS matricule
    UNION ALL SELECT 'etudiant.test004@istapa-test.site' AS email, 'IST26-004' AS matricule
    UNION ALL SELECT 'etudiant.test005@istapa-test.site' AS email, 'IST26-005' AS matricule
    UNION ALL SELECT 'etudiant.test006@istapa-test.site' AS email, 'IST26-006' AS matricule
    UNION ALL SELECT 'etudiant.test007@istapa-test.site' AS email, 'IST26-007' AS matricule
    UNION ALL SELECT 'etudiant.test008@istapa-test.site' AS email, 'IST26-008' AS matricule
    UNION ALL SELECT 'etudiant.test009@istapa-test.site' AS email, 'IST26-009' AS matricule
    UNION ALL SELECT 'etudiant.test010@istapa-test.site' AS email, 'IST26-010' AS matricule
    UNION ALL SELECT 'etudiant.test011@istapa-test.site' AS email, 'IST26-011' AS matricule
    UNION ALL SELECT 'etudiant.test012@istapa-test.site' AS email, 'IST26-012' AS matricule
    UNION ALL SELECT 'etudiant.test013@istapa-test.site' AS email, 'IST26-013' AS matricule
    UNION ALL SELECT 'etudiant.test014@istapa-test.site' AS email, 'IST26-014' AS matricule
    UNION ALL SELECT 'etudiant.test015@istapa-test.site' AS email, 'IST26-015' AS matricule
    UNION ALL SELECT 'etudiant.test016@istapa-test.site' AS email, 'IST26-016' AS matricule
    UNION ALL SELECT 'etudiant.test017@istapa-test.site' AS email, 'IST26-017' AS matricule
    UNION ALL SELECT 'etudiant.test018@istapa-test.site' AS email, 'IST26-018' AS matricule
    UNION ALL SELECT 'etudiant.test019@istapa-test.site' AS email, 'IST26-019' AS matricule
    UNION ALL SELECT 'etudiant.test020@istapa-test.site' AS email, 'IST26-020' AS matricule
    UNION ALL SELECT 'etudiant.test021@istapa-test.site' AS email, 'IST26-021' AS matricule
    UNION ALL SELECT 'etudiant.test022@istapa-test.site' AS email, 'IST26-022' AS matricule
    UNION ALL SELECT 'etudiant.test023@istapa-test.site' AS email, 'IST26-023' AS matricule
    UNION ALL SELECT 'etudiant.test024@istapa-test.site' AS email, 'IST26-024' AS matricule
    UNION ALL SELECT 'etudiant.test025@istapa-test.site' AS email, 'IST26-025' AS matricule
    UNION ALL SELECT 'etudiant.test026@istapa-test.site' AS email, 'IST26-026' AS matricule
    UNION ALL SELECT 'etudiant.test027@istapa-test.site' AS email, 'IST26-027' AS matricule
    UNION ALL SELECT 'etudiant.test028@istapa-test.site' AS email, 'IST26-028' AS matricule
    UNION ALL SELECT 'etudiant.test029@istapa-test.site' AS email, 'IST26-029' AS matricule
    UNION ALL SELECT 'etudiant.test030@istapa-test.site' AS email, 'IST26-030' AS matricule
    UNION ALL SELECT 'etudiant.test031@istapa-test.site' AS email, 'IST26-031' AS matricule
    UNION ALL SELECT 'etudiant.test032@istapa-test.site' AS email, 'IST26-032' AS matricule
    UNION ALL SELECT 'etudiant.test033@istapa-test.site' AS email, 'IST26-033' AS matricule
    UNION ALL SELECT 'etudiant.test034@istapa-test.site' AS email, 'IST26-034' AS matricule
    UNION ALL SELECT 'etudiant.test035@istapa-test.site' AS email, 'IST26-035' AS matricule
    UNION ALL SELECT 'etudiant.test036@istapa-test.site' AS email, 'IST26-036' AS matricule
    UNION ALL SELECT 'etudiant.test037@istapa-test.site' AS email, 'IST26-037' AS matricule
    UNION ALL SELECT 'etudiant.test038@istapa-test.site' AS email, 'IST26-038' AS matricule
    UNION ALL SELECT 'etudiant.test039@istapa-test.site' AS email, 'IST26-039' AS matricule
    UNION ALL SELECT 'etudiant.test040@istapa-test.site' AS email, 'IST26-040' AS matricule
    UNION ALL SELECT 'etudiant.test041@istapa-test.site' AS email, 'IST26-041' AS matricule
    UNION ALL SELECT 'etudiant.test042@istapa-test.site' AS email, 'IST26-042' AS matricule
    UNION ALL SELECT 'etudiant.test043@istapa-test.site' AS email, 'IST26-043' AS matricule
    UNION ALL SELECT 'etudiant.test044@istapa-test.site' AS email, 'IST26-044' AS matricule
    UNION ALL SELECT 'etudiant.test045@istapa-test.site' AS email, 'IST26-045' AS matricule
    UNION ALL SELECT 'etudiant.test046@istapa-test.site' AS email, 'IST26-046' AS matricule
    UNION ALL SELECT 'etudiant.test047@istapa-test.site' AS email, 'IST26-047' AS matricule
    UNION ALL SELECT 'etudiant.test048@istapa-test.site' AS email, 'IST26-048' AS matricule
    UNION ALL SELECT 'etudiant.test049@istapa-test.site' AS email, 'IST26-049' AS matricule
    UNION ALL SELECT 'etudiant.test050@istapa-test.site' AS email, 'IST26-050' AS matricule
    UNION ALL SELECT 'etudiant.test051@istapa-test.site' AS email, 'IST26-051' AS matricule
    UNION ALL SELECT 'etudiant.test052@istapa-test.site' AS email, 'IST26-052' AS matricule
    UNION ALL SELECT 'etudiant.test053@istapa-test.site' AS email, 'IST26-053' AS matricule
    UNION ALL SELECT 'etudiant.test054@istapa-test.site' AS email, 'IST26-054' AS matricule
    UNION ALL SELECT 'etudiant.test055@istapa-test.site' AS email, 'IST26-055' AS matricule
    UNION ALL SELECT 'etudiant.test056@istapa-test.site' AS email, 'IST26-056' AS matricule
    UNION ALL SELECT 'etudiant.test057@istapa-test.site' AS email, 'IST26-057' AS matricule
    UNION ALL SELECT 'etudiant.test058@istapa-test.site' AS email, 'IST26-058' AS matricule
    UNION ALL SELECT 'etudiant.test059@istapa-test.site' AS email, 'IST26-059' AS matricule
    UNION ALL SELECT 'etudiant.test060@istapa-test.site' AS email, 'IST26-060' AS matricule
    UNION ALL SELECT 'etudiant.test061@istapa-test.site' AS email, 'IST26-061' AS matricule
    UNION ALL SELECT 'etudiant.test062@istapa-test.site' AS email, 'IST26-062' AS matricule
    UNION ALL SELECT 'etudiant.test063@istapa-test.site' AS email, 'IST26-063' AS matricule
    UNION ALL SELECT 'etudiant.test064@istapa-test.site' AS email, 'IST26-064' AS matricule
    UNION ALL SELECT 'etudiant.test065@istapa-test.site' AS email, 'IST26-065' AS matricule
    UNION ALL SELECT 'etudiant.test066@istapa-test.site' AS email, 'IST26-066' AS matricule
    UNION ALL SELECT 'etudiant.test067@istapa-test.site' AS email, 'IST26-067' AS matricule
    UNION ALL SELECT 'etudiant.test068@istapa-test.site' AS email, 'IST26-068' AS matricule
    UNION ALL SELECT 'etudiant.test069@istapa-test.site' AS email, 'IST26-069' AS matricule
    UNION ALL SELECT 'etudiant.test070@istapa-test.site' AS email, 'IST26-070' AS matricule
    UNION ALL SELECT 'etudiant.test071@istapa-test.site' AS email, 'IST26-071' AS matricule
    UNION ALL SELECT 'etudiant.test072@istapa-test.site' AS email, 'IST26-072' AS matricule
    UNION ALL SELECT 'etudiant.test073@istapa-test.site' AS email, 'IST26-073' AS matricule
    UNION ALL SELECT 'etudiant.test074@istapa-test.site' AS email, 'IST26-074' AS matricule
    UNION ALL SELECT 'etudiant.test075@istapa-test.site' AS email, 'IST26-075' AS matricule
    UNION ALL SELECT 'etudiant.test076@istapa-test.site' AS email, 'IST26-076' AS matricule
    UNION ALL SELECT 'etudiant.test077@istapa-test.site' AS email, 'IST26-077' AS matricule
    UNION ALL SELECT 'etudiant.test078@istapa-test.site' AS email, 'IST26-078' AS matricule
    UNION ALL SELECT 'etudiant.test079@istapa-test.site' AS email, 'IST26-079' AS matricule
    UNION ALL SELECT 'etudiant.test080@istapa-test.site' AS email, 'IST26-080' AS matricule
    UNION ALL SELECT 'etudiant.test081@istapa-test.site' AS email, 'IST26-081' AS matricule
    UNION ALL SELECT 'etudiant.test082@istapa-test.site' AS email, 'IST26-082' AS matricule
    UNION ALL SELECT 'etudiant.test083@istapa-test.site' AS email, 'IST26-083' AS matricule
    UNION ALL SELECT 'etudiant.test084@istapa-test.site' AS email, 'IST26-084' AS matricule
    UNION ALL SELECT 'etudiant.test085@istapa-test.site' AS email, 'IST26-085' AS matricule
    UNION ALL SELECT 'etudiant.test086@istapa-test.site' AS email, 'IST26-086' AS matricule
    UNION ALL SELECT 'etudiant.test087@istapa-test.site' AS email, 'IST26-087' AS matricule
    UNION ALL SELECT 'etudiant.test088@istapa-test.site' AS email, 'IST26-088' AS matricule
    UNION ALL SELECT 'etudiant.test089@istapa-test.site' AS email, 'IST26-089' AS matricule
    UNION ALL SELECT 'etudiant.test090@istapa-test.site' AS email, 'IST26-090' AS matricule
    UNION ALL SELECT 'etudiant.test091@istapa-test.site' AS email, 'IST26-091' AS matricule
    UNION ALL SELECT 'etudiant.test092@istapa-test.site' AS email, 'IST26-092' AS matricule
    UNION ALL SELECT 'etudiant.test093@istapa-test.site' AS email, 'IST26-093' AS matricule
    UNION ALL SELECT 'etudiant.test094@istapa-test.site' AS email, 'IST26-094' AS matricule
    UNION ALL SELECT 'etudiant.test095@istapa-test.site' AS email, 'IST26-095' AS matricule
    UNION ALL SELECT 'etudiant.test096@istapa-test.site' AS email, 'IST26-096' AS matricule
) t ON t.email = u.email;

-- 3) Inscription dans leur classe (academic_year_id = 3)
INSERT INTO `class_enrollments` (`student_id`, `class_id`)
SELECT u.id, c.id
FROM `users` u
JOIN (
    SELECT 'etudiant.test001@istapa-test.site' AS email, 'HND1 Production Animale' AS class_name
    UNION ALL SELECT 'etudiant.test002@istapa-test.site' AS email, 'HND1 Production Animale' AS class_name
    UNION ALL SELECT 'etudiant.test003@istapa-test.site' AS email, 'HND1 Production Animale' AS class_name
    UNION ALL SELECT 'etudiant.test004@istapa-test.site' AS email, 'HND1 Production Animale' AS class_name
    UNION ALL SELECT 'etudiant.test005@istapa-test.site' AS email, 'HND1 Production Animale' AS class_name
    UNION ALL SELECT 'etudiant.test006@istapa-test.site' AS email, 'HND1 Production Animale' AS class_name
    UNION ALL SELECT 'etudiant.test007@istapa-test.site' AS email, 'HND2 Production Animale' AS class_name
    UNION ALL SELECT 'etudiant.test008@istapa-test.site' AS email, 'HND2 Production Animale' AS class_name
    UNION ALL SELECT 'etudiant.test009@istapa-test.site' AS email, 'HND2 Production Animale' AS class_name
    UNION ALL SELECT 'etudiant.test010@istapa-test.site' AS email, 'HND2 Production Animale' AS class_name
    UNION ALL SELECT 'etudiant.test011@istapa-test.site' AS email, 'HND2 Production Animale' AS class_name
    UNION ALL SELECT 'etudiant.test012@istapa-test.site' AS email, 'HND2 Production Animale' AS class_name
    UNION ALL SELECT 'etudiant.test013@istapa-test.site' AS email, 'BTS1 Production Animale' AS class_name
    UNION ALL SELECT 'etudiant.test014@istapa-test.site' AS email, 'BTS1 Production Animale' AS class_name
    UNION ALL SELECT 'etudiant.test015@istapa-test.site' AS email, 'BTS1 Production Animale' AS class_name
    UNION ALL SELECT 'etudiant.test016@istapa-test.site' AS email, 'BTS1 Production Animale' AS class_name
    UNION ALL SELECT 'etudiant.test017@istapa-test.site' AS email, 'BTS1 Production Animale' AS class_name
    UNION ALL SELECT 'etudiant.test018@istapa-test.site' AS email, 'BTS1 Production Animale' AS class_name
    UNION ALL SELECT 'etudiant.test019@istapa-test.site' AS email, 'BTS2 Production Animale' AS class_name
    UNION ALL SELECT 'etudiant.test020@istapa-test.site' AS email, 'BTS2 Production Animale' AS class_name
    UNION ALL SELECT 'etudiant.test021@istapa-test.site' AS email, 'BTS2 Production Animale' AS class_name
    UNION ALL SELECT 'etudiant.test022@istapa-test.site' AS email, 'BTS2 Production Animale' AS class_name
    UNION ALL SELECT 'etudiant.test023@istapa-test.site' AS email, 'BTS2 Production Animale' AS class_name
    UNION ALL SELECT 'etudiant.test024@istapa-test.site' AS email, 'BTS2 Production Animale' AS class_name
    UNION ALL SELECT 'etudiant.test025@istapa-test.site' AS email, 'HND1 Production Végétale' AS class_name
    UNION ALL SELECT 'etudiant.test026@istapa-test.site' AS email, 'HND1 Production Végétale' AS class_name
    UNION ALL SELECT 'etudiant.test027@istapa-test.site' AS email, 'HND1 Production Végétale' AS class_name
    UNION ALL SELECT 'etudiant.test028@istapa-test.site' AS email, 'HND1 Production Végétale' AS class_name
    UNION ALL SELECT 'etudiant.test029@istapa-test.site' AS email, 'HND1 Production Végétale' AS class_name
    UNION ALL SELECT 'etudiant.test030@istapa-test.site' AS email, 'HND1 Production Végétale' AS class_name
    UNION ALL SELECT 'etudiant.test031@istapa-test.site' AS email, 'HND2 Production Végétale' AS class_name
    UNION ALL SELECT 'etudiant.test032@istapa-test.site' AS email, 'HND2 Production Végétale' AS class_name
    UNION ALL SELECT 'etudiant.test033@istapa-test.site' AS email, 'HND2 Production Végétale' AS class_name
    UNION ALL SELECT 'etudiant.test034@istapa-test.site' AS email, 'HND2 Production Végétale' AS class_name
    UNION ALL SELECT 'etudiant.test035@istapa-test.site' AS email, 'HND2 Production Végétale' AS class_name
    UNION ALL SELECT 'etudiant.test036@istapa-test.site' AS email, 'HND2 Production Végétale' AS class_name
    UNION ALL SELECT 'etudiant.test037@istapa-test.site' AS email, 'BTS1 Production Végétale' AS class_name
    UNION ALL SELECT 'etudiant.test038@istapa-test.site' AS email, 'BTS1 Production Végétale' AS class_name
    UNION ALL SELECT 'etudiant.test039@istapa-test.site' AS email, 'BTS1 Production Végétale' AS class_name
    UNION ALL SELECT 'etudiant.test040@istapa-test.site' AS email, 'BTS1 Production Végétale' AS class_name
    UNION ALL SELECT 'etudiant.test041@istapa-test.site' AS email, 'BTS1 Production Végétale' AS class_name
    UNION ALL SELECT 'etudiant.test042@istapa-test.site' AS email, 'BTS1 Production Végétale' AS class_name
    UNION ALL SELECT 'etudiant.test043@istapa-test.site' AS email, 'BTS2 Production Végétale' AS class_name
    UNION ALL SELECT 'etudiant.test044@istapa-test.site' AS email, 'BTS2 Production Végétale' AS class_name
    UNION ALL SELECT 'etudiant.test045@istapa-test.site' AS email, 'BTS2 Production Végétale' AS class_name
    UNION ALL SELECT 'etudiant.test046@istapa-test.site' AS email, 'BTS2 Production Végétale' AS class_name
    UNION ALL SELECT 'etudiant.test047@istapa-test.site' AS email, 'BTS2 Production Végétale' AS class_name
    UNION ALL SELECT 'etudiant.test048@istapa-test.site' AS email, 'BTS2 Production Végétale' AS class_name
    UNION ALL SELECT 'etudiant.test049@istapa-test.site' AS email, 'HND1 Gestion Environnementale' AS class_name
    UNION ALL SELECT 'etudiant.test050@istapa-test.site' AS email, 'HND1 Gestion Environnementale' AS class_name
    UNION ALL SELECT 'etudiant.test051@istapa-test.site' AS email, 'HND1 Gestion Environnementale' AS class_name
    UNION ALL SELECT 'etudiant.test052@istapa-test.site' AS email, 'HND1 Gestion Environnementale' AS class_name
    UNION ALL SELECT 'etudiant.test053@istapa-test.site' AS email, 'HND1 Gestion Environnementale' AS class_name
    UNION ALL SELECT 'etudiant.test054@istapa-test.site' AS email, 'HND1 Gestion Environnementale' AS class_name
    UNION ALL SELECT 'etudiant.test055@istapa-test.site' AS email, 'HND2 Gestion Environnementale' AS class_name
    UNION ALL SELECT 'etudiant.test056@istapa-test.site' AS email, 'HND2 Gestion Environnementale' AS class_name
    UNION ALL SELECT 'etudiant.test057@istapa-test.site' AS email, 'HND2 Gestion Environnementale' AS class_name
    UNION ALL SELECT 'etudiant.test058@istapa-test.site' AS email, 'HND2 Gestion Environnementale' AS class_name
    UNION ALL SELECT 'etudiant.test059@istapa-test.site' AS email, 'HND2 Gestion Environnementale' AS class_name
    UNION ALL SELECT 'etudiant.test060@istapa-test.site' AS email, 'HND2 Gestion Environnementale' AS class_name
    UNION ALL SELECT 'etudiant.test061@istapa-test.site' AS email, 'BTS1 Gestion Environnementale' AS class_name
    UNION ALL SELECT 'etudiant.test062@istapa-test.site' AS email, 'BTS1 Gestion Environnementale' AS class_name
    UNION ALL SELECT 'etudiant.test063@istapa-test.site' AS email, 'BTS1 Gestion Environnementale' AS class_name
    UNION ALL SELECT 'etudiant.test064@istapa-test.site' AS email, 'BTS1 Gestion Environnementale' AS class_name
    UNION ALL SELECT 'etudiant.test065@istapa-test.site' AS email, 'BTS1 Gestion Environnementale' AS class_name
    UNION ALL SELECT 'etudiant.test066@istapa-test.site' AS email, 'BTS1 Gestion Environnementale' AS class_name
    UNION ALL SELECT 'etudiant.test067@istapa-test.site' AS email, 'BTS2 Gestion Environnementale' AS class_name
    UNION ALL SELECT 'etudiant.test068@istapa-test.site' AS email, 'BTS2 Gestion Environnementale' AS class_name
    UNION ALL SELECT 'etudiant.test069@istapa-test.site' AS email, 'BTS2 Gestion Environnementale' AS class_name
    UNION ALL SELECT 'etudiant.test070@istapa-test.site' AS email, 'BTS2 Gestion Environnementale' AS class_name
    UNION ALL SELECT 'etudiant.test071@istapa-test.site' AS email, 'BTS2 Gestion Environnementale' AS class_name
    UNION ALL SELECT 'etudiant.test072@istapa-test.site' AS email, 'BTS2 Gestion Environnementale' AS class_name
    UNION ALL SELECT 'etudiant.test073@istapa-test.site' AS email, 'HND1 Énergies Renouvelables' AS class_name
    UNION ALL SELECT 'etudiant.test074@istapa-test.site' AS email, 'HND1 Énergies Renouvelables' AS class_name
    UNION ALL SELECT 'etudiant.test075@istapa-test.site' AS email, 'HND1 Énergies Renouvelables' AS class_name
    UNION ALL SELECT 'etudiant.test076@istapa-test.site' AS email, 'HND1 Énergies Renouvelables' AS class_name
    UNION ALL SELECT 'etudiant.test077@istapa-test.site' AS email, 'HND1 Énergies Renouvelables' AS class_name
    UNION ALL SELECT 'etudiant.test078@istapa-test.site' AS email, 'HND1 Énergies Renouvelables' AS class_name
    UNION ALL SELECT 'etudiant.test079@istapa-test.site' AS email, 'HND2 Énergies Renouvelables' AS class_name
    UNION ALL SELECT 'etudiant.test080@istapa-test.site' AS email, 'HND2 Énergies Renouvelables' AS class_name
    UNION ALL SELECT 'etudiant.test081@istapa-test.site' AS email, 'HND2 Énergies Renouvelables' AS class_name
    UNION ALL SELECT 'etudiant.test082@istapa-test.site' AS email, 'HND2 Énergies Renouvelables' AS class_name
    UNION ALL SELECT 'etudiant.test083@istapa-test.site' AS email, 'HND2 Énergies Renouvelables' AS class_name
    UNION ALL SELECT 'etudiant.test084@istapa-test.site' AS email, 'HND2 Énergies Renouvelables' AS class_name
    UNION ALL SELECT 'etudiant.test085@istapa-test.site' AS email, 'BTS1 Énergies Renouvelables' AS class_name
    UNION ALL SELECT 'etudiant.test086@istapa-test.site' AS email, 'BTS1 Énergies Renouvelables' AS class_name
    UNION ALL SELECT 'etudiant.test087@istapa-test.site' AS email, 'BTS1 Énergies Renouvelables' AS class_name
    UNION ALL SELECT 'etudiant.test088@istapa-test.site' AS email, 'BTS1 Énergies Renouvelables' AS class_name
    UNION ALL SELECT 'etudiant.test089@istapa-test.site' AS email, 'BTS1 Énergies Renouvelables' AS class_name
    UNION ALL SELECT 'etudiant.test090@istapa-test.site' AS email, 'BTS1 Énergies Renouvelables' AS class_name
    UNION ALL SELECT 'etudiant.test091@istapa-test.site' AS email, 'BTS2 Énergies Renouvelables' AS class_name
    UNION ALL SELECT 'etudiant.test092@istapa-test.site' AS email, 'BTS2 Énergies Renouvelables' AS class_name
    UNION ALL SELECT 'etudiant.test093@istapa-test.site' AS email, 'BTS2 Énergies Renouvelables' AS class_name
    UNION ALL SELECT 'etudiant.test094@istapa-test.site' AS email, 'BTS2 Énergies Renouvelables' AS class_name
    UNION ALL SELECT 'etudiant.test095@istapa-test.site' AS email, 'BTS2 Énergies Renouvelables' AS class_name
    UNION ALL SELECT 'etudiant.test096@istapa-test.site' AS email, 'BTS2 Énergies Renouvelables' AS class_name
) t ON t.email = u.email
JOIN `classes` c ON c.name = t.class_name AND c.academic_year_id = 3;

-- 

INSERT INTO `exam_subjects` (`exam_id`, `subject_id`, `exam_date`, `total_mark`)
SELECT e.id, s.id, e.start_date, 20.00
FROM `subjects` s
JOIN `classes` c ON c.id = s.class_id
JOIN `exams` e ON e.class_id = c.id
WHERE c.academic_year_id = 3
  AND c.name IN (
    'HND1 Production Animale', 'HND2 Production Animale',
    'BTS1 Production Animale', 'BTS2 Production Animale',
    'BTS1 Production Végétale', 'BTS2 Production Végétale',
    'BTS1 Gestion Environnementale', 'BTS2 Gestion Environnementale',
    'BTS1 Énergies Renouvelables', 'BTS2 Énergies Renouvelables'
  )
  AND (
        -- Semestre impair de la classe (1er semestre) → CC1 et SN1
        (SUBSTRING(s.code, 5, 1) IN ('1', '3') AND e.name IN ('Contrôle Continu S1', 'SN Semestre 1'))
        OR
        -- Semestre pair de la classe (2e semestre) → CC2 et SN2
        (SUBSTRING(s.code, 5, 1) IN ('2', '4') AND e.name IN ('Contrôle Continu S2', 'SN Semestre 2'))
      );