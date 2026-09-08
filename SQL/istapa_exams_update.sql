INSERT INTO `exams` (`class_id`, `academic_year_id`, `name`, `term`, `exam_type`, `passing_mark`, `total_mark`, `start_date`, `end_date`, `created_by`)
SELECT
    c.id,
    c.academic_year_id,
    t.name,
    t.term,
    t.exam_type,
    10.00,
    20.00,
    t.start_date,
    t.end_date,
    1
FROM `classes` c
CROSS JOIN (
    SELECT 'Contrôle Continu S1' AS name, 'term_1' AS term, 'devoir'      AS exam_type, '2026-11-01' AS start_date, '2026-11-15' AS end_date
    UNION ALL SELECT 'SN Semestre 1',       'term_1', 'composition', '2027-01-10', '2027-01-20'
    UNION ALL SELECT 'Rattrapage SN1',      'term_1', 'composition', '2027-02-05', '2027-02-10'
    UNION ALL SELECT 'Contrôle Continu S2', 'term_2', 'devoir',      '2027-03-01', '2027-03-15'
    UNION ALL SELECT 'SN Semestre 2',       'term_2', 'composition', '2027-05-01', '2027-05-20'
    UNION ALL SELECT 'Rattrapage SN2',      'term_2', 'composition', '2027-06-10', '2027-06-15'
) t
WHERE c.academic_year_id = 3;