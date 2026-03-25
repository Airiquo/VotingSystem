-- =====================
-- COLLEGES
-- =====================
INSERT INTO College (college_name) VALUES
('College of Engineering'),
('College of Information Technology'),
('College of Arts and Letters'),
('College of Social Sciences and Philosophy'),
('College of Education');

-- =====================
-- STUDENTS (16)
-- =====================
INSERT INTO Students (first_name, middle_name, last_name, college_id) VALUES
('Juan',      'Santos',    'Dela Cruz',   1000),
('Maria',     'Reyes',     'Garcia',      1001),
('Carlos',    'Mendoza',   'Lopez',       1002),
('Ana',       'Cruz',      'Martinez',    1003),
('Jose',      'Bautista',  'Rodriguez',   1004),
('Luisa',     'Villanueva','Hernandez',   1000),
('Miguel',    'Aquino',    'Gonzales',    1001),
('Sofia',     'Ramos',     'Perez',       1002),
('Ramon',     'Torres',    'Castillo',    1003),
('Elena',     'Flores',    'Morales',     1004),
('Diego',     'Pascual',   'Navarro',     1000),
('Isabella',  'Aguilar',   'Reyes',       1001),
('Marco',     'Domingo',   'Santiago',    1002),
('Gabrielle', 'Espinosa',  'Valdez',      1003),
('Rafael',    'Mercado',   'Salazar',     1004),
('Camille',   'Ocampo',    'Fuentes',     1000);

-- =====================
-- ROLES (already inserted: admin at 1000)
-- Add voter role
-- =====================
INSERT INTO Roles (role_name) VALUES ('voter');

-- =====================
-- USERS (16 student voter accounts)
-- role_id 1001 = voter
-- =====================
INSERT INTO Users (username, password, role_id) VALUES
('juan.delacruz',    '123456', 1001),
('maria.garcia',     '123456', 1001),
('carlos.lopez',     '123456', 1001),
('ana.martinez',     '123456', 1001),
('jose.rodriguez',   '123456', 1001),
('luisa.hernandez',  '123456', 1001),
('miguel.gonzales',  '123456', 1001),
('sofia.perez',      '123456', 1001),
('ramon.castillo',   '123456', 1001),
('elena.morales',    '123456', 1001),
('diego.navarro',    '123456', 1001),
('isabella.reyes',   '123456', 1001),
('marco.santiago',   '123456', 1001),
('gabrielle.valdez', '123456', 1001),
('rafael.salazar',   '123456', 1001),
('camille.fuentes',  '123456', 1001);

-- =====================
-- STUDENT VOTERS (link Users to Students)
-- Users start at 1001 (1000 is the admin)
-- Students start at 1000
-- =====================
INSERT INTO StudentVoters (user_id, student_id) VALUES
(1001, 1000),
(1002, 1001),
(1003, 1002),
(1004, 1003),
(1005, 1004),
(1006, 1005),
(1007, 1006),
(1008, 1007),
(1009, 1008),
(1010, 1009),
(1011, 1010),
(1012, 1011),
(1013, 1012),
(1014, 1013),
(1015, 1014),
(1016, 1015);

-- =====================
-- ELECTION
-- =====================
INSERT INTO Elections (title, status, start_date, end_date) VALUES
('Student Council Election 2025', 'active', '2025-06-01 08:00:00', '2025-06-01 17:00:00');

-- =====================
-- POSITIONS (for election_id 1000)
-- =====================
INSERT INTO Positions (name, election_id) VALUES
('President',      1000),
('Vice-President', 1000),
('Senator',        1000),
('Senator',        1000),
('Senator',        1000),
('Vice-Governor',  1000);

-- =====================
-- PARTYLISTS (for election_id 1000)
-- =====================
INSERT INTO Partylists (name, election_id) VALUES
('Partido Uno',  1000),
('Partido Dos',  1000);

-- =====================
-- CANDIDATES (16 students assigned to positions)
-- partylist 1000 = Partido Uno
-- partylist 1001 = Partido Dos
-- Positions: 1000=President, 1001=VP, 1002-1004=Senator, 1005=Vice-Governor
-- =====================
INSERT INTO Candidates (partylist_id, student_id, position_id) VALUES
-- Partido Uno
(1000, 1000, 1000),   -- Juan        -> President
(1000, 1001, 1001),   -- Maria       -> Vice-President
(1000, 1002, 1002),   -- Carlos      -> Senator
(1000, 1003, 1003),   -- Ana         -> Senator
(1000, 1004, 1004),   -- Jose        -> Senator
(1000, 1005, 1005),   -- Luisa       -> Vice-Governor
(1000, 1006, 1002),   -- Miguel      -> Senator (shared slot)
(1000, 1007, 1003),   -- Sofia       -> Senator (shared slot)

-- Partido Dos
(1001, 1008, 1000),   -- Ramon       -> President
(1001, 1009, 1001),   -- Elena       -> Vice-President
(1001, 1010, 1002),   -- Diego       -> Senator
(1001, 1011, 1003),   -- Isabella    -> Senator
(1001, 1012, 1004),   -- Marco       -> Senator
(1001, 1013, 1005),   -- Gabrielle   -> Vice-Governor
(1001, 1014, 1002),   -- Rafael      -> Senator (shared slot)
(1001, 1015, 1003);   -- Camille     -> Senator (shared slot)