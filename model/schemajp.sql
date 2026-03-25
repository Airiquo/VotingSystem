-- ============================================================
-- VOTING SYSTEM DATABASE
-- ============================================================


-- ============================================================
-- SCHEMA: ROLES
-- ============================================================

CREATE TABLE `VotingSystem`.`Roles` (
    `role_id`   INT          NOT NULL AUTO_INCREMENT,
    `role_name` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`role_id`)
) ENGINE = InnoDB AUTO_INCREMENT = 1000;


-- ============================================================
-- SCHEMA: USERS
-- ============================================================

CREATE TABLE `VotingSystem`.`Users` (
    `user_id`          INT          NOT NULL AUTO_INCREMENT,
    `username`         VARCHAR(255) NOT NULL,
    `password`         VARCHAR(255) NOT NULL,
    `role_id`          INT          NOT NULL,
    `activated_status` TINYINT(1)   NOT NULL DEFAULT 0,
    `created_date`     DATETIME              DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`user_id`),
    FOREIGN KEY (`role_id`) REFERENCES `Roles`(`role_id`)
) ENGINE = InnoDB AUTO_INCREMENT = 1000;


-- ============================================================
-- SCHEMA: COLLEGE
-- ============================================================

CREATE TABLE `VotingSystem`.`College` (
    `college_id`   INT          NOT NULL AUTO_INCREMENT,
    `college_name` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`college_id`)
) ENGINE = InnoDB AUTO_INCREMENT = 1000;


-- ============================================================
-- SCHEMA: STUDENTS
-- ============================================================

CREATE TABLE `VotingSystem`.`Students` (
    `student_id`  INT          NOT NULL AUTO_INCREMENT,
    `first_name`  VARCHAR(255) NOT NULL,
    `middle_name` VARCHAR(255),
    `last_name`   VARCHAR(255) NOT NULL,
    `college_id`  INT          NOT NULL,
    PRIMARY KEY (`student_id`),
    FOREIGN KEY (`college_id`) REFERENCES `College`(`college_id`)
) ENGINE = InnoDB AUTO_INCREMENT = 1000;


-- ============================================================
-- SCHEMA: STUDENT VOTERS
-- ============================================================

CREATE TABLE `VotingSystem`.`StudentVoters` (
    `studentvoter_id` INT        NOT NULL AUTO_INCREMENT,
    `user_id`         INT        NOT NULL,
    `student_id`      INT        NOT NULL,
    `has_voted`       TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (`studentvoter_id`),
    FOREIGN KEY (`user_id`)    REFERENCES `Users`(`user_id`),
    FOREIGN KEY (`student_id`) REFERENCES `Students`(`student_id`)
) ENGINE = InnoDB AUTO_INCREMENT = 1000;


-- ============================================================
-- SCHEMA: ELECTIONS
-- ============================================================

CREATE TABLE `VotingSystem`.`Elections` (
    `election_id` INT          NOT NULL AUTO_INCREMENT,
    `title`       VARCHAR(255) NOT NULL,
    `status`      VARCHAR(50)  NOT NULL,
    `start_date`  DATETIME     NOT NULL,
    `end_date`    DATETIME     NOT NULL,
    PRIMARY KEY (`election_id`)
) ENGINE = InnoDB AUTO_INCREMENT = 1000;


-- ============================================================
-- SCHEMA: POSITIONS
-- ============================================================

CREATE TABLE `VotingSystem`.`Positions` (
    `position_id` INT          NOT NULL AUTO_INCREMENT,
    `name`        VARCHAR(255) NOT NULL,
    `election_id` INT          NOT NULL,
    PRIMARY KEY (`position_id`),
    FOREIGN KEY (`election_id`) REFERENCES `Elections`(`election_id`)
) ENGINE = InnoDB AUTO_INCREMENT = 1000;


-- ============================================================
-- SCHEMA: PARTYLISTS
-- ============================================================

CREATE TABLE `VotingSystem`.`Partylists` (
    `partylist_id` INT          NOT NULL AUTO_INCREMENT,
    `name`         VARCHAR(255) NOT NULL,
    `election_id`  INT          NOT NULL,
    PRIMARY KEY (`partylist_id`),
    FOREIGN KEY (`election_id`) REFERENCES `Elections`(`election_id`)
) ENGINE = InnoDB AUTO_INCREMENT = 1000;


-- ============================================================
-- SCHEMA: CANDIDATES
-- ============================================================

CREATE TABLE `VotingSystem`.`Candidates` (
    `candidate_id` INT NOT NULL AUTO_INCREMENT,
    `partylist_id` INT NOT NULL,
    `student_id`   INT NOT NULL,
    `position_id`  INT NOT NULL,
    PRIMARY KEY (`candidate_id`),
    FOREIGN KEY (`partylist_id`) REFERENCES `Partylists`(`partylist_id`),
    FOREIGN KEY (`student_id`)   REFERENCES `Students`(`student_id`),
    FOREIGN KEY (`position_id`)  REFERENCES `Positions`(`position_id`)
) ENGINE = InnoDB AUTO_INCREMENT = 1000;


-- ============================================================
-- SCHEMA: VOTES
-- ============================================================

CREATE TABLE `VotingSystem`.`Votes` (
    `vote_id`         INT      NOT NULL AUTO_INCREMENT,
    `vote_date`       DATETIME          DEFAULT CURRENT_TIMESTAMP,
    `studentvoter_id` INT      NOT NULL,
    `candidate_id`    INT      NOT NULL,
    `position_id`     INT      NOT NULL,
    PRIMARY KEY (`vote_id`),
    UNIQUE (`studentvoter_id`, `position_id`),
    FOREIGN KEY (`studentvoter_id`) REFERENCES `StudentVoters`(`studentvoter_id`),
    FOREIGN KEY (`candidate_id`)    REFERENCES `Candidates`(`candidate_id`),
    FOREIGN KEY (`position_id`)     REFERENCES `Positions`(`position_id`)
) ENGINE = InnoDB AUTO_INCREMENT = 1000;


-- ============================================================
-- SCHEMA: ABSTAIN VOTES
-- ============================================================

CREATE TABLE `VotingSystem`.`AbstainVotes` (
    `abstain_vote_id` INT      NOT NULL AUTO_INCREMENT,
    `studentvoter_id` INT      NOT NULL,
    `position_id`     INT      NOT NULL,
    `vote_date`       DATETIME NOT NULL,
    PRIMARY KEY (`abstain_vote_id`),
    FOREIGN KEY (`studentvoter_id`) REFERENCES `StudentVoters`(`studentvoter_id`),
    FOREIGN KEY (`position_id`)     REFERENCES `Positions`(`position_id`)
) ENGINE = InnoDB AUTO_INCREMENT = 1000;


-- ============================================================
-- DATA: ROLES
-- role_id 1000 = admin
-- role_id 1001 = student_voter
-- ============================================================

INSERT INTO Roles (role_name) VALUES ('admin');         -- role_id: 1000
INSERT INTO Roles (role_name) VALUES ('student_voter'); -- role_id: 1001


-- ============================================================
-- DATA: USERS
-- user_id 1000 = admin
-- user_id 1001–1016 = student voters
-- ============================================================

INSERT INTO Users (username, password, role_id, activated_status) VALUES
('tephL', '123456', 1000, 1);                           -- user_id: 1000 (admin)

INSERT INTO Users (username, password, role_id) VALUES
('juan.delacruz',    '123456', 1001),                   -- user_id: 1001
('maria.garcia',     '123456', 1001),                   -- user_id: 1002
('carlos.lopez',     '123456', 1001),                   -- user_id: 1003
('ana.martinez',     '123456', 1001),                   -- user_id: 1004
('jose.rodriguez',   '123456', 1001),                   -- user_id: 1005
('luisa.hernandez',  '123456', 1001),                   -- user_id: 1006
('miguel.gonzales',  '123456', 1001),                   -- user_id: 1007
('sofia.perez',      '123456', 1001),                   -- user_id: 1008
('ramon.castillo',   '123456', 1001),                   -- user_id: 1009
('elena.morales',    '123456', 1001),                   -- user_id: 1010
('diego.navarro',    '123456', 1001),                   -- user_id: 1011
('isabella.reyes',   '123456', 1001),                   -- user_id: 1012
('marco.santiago',   '123456', 1001),                   -- user_id: 1013
('gabrielle.valdez', '123456', 1001),                   -- user_id: 1014
('rafael.salazar',   '123456', 1001),                   -- user_id: 1015
('camille.fuentes',  '123456', 1001);                   -- user_id: 1016


-- ============================================================
-- DATA: COLLEGES
-- college_id 1000–1004
-- ============================================================

INSERT INTO College (college_name) VALUES
('College of Engineering'),                             -- college_id: 1000
('College of Information Technology'),                  -- college_id: 1001
('College of Arts and Letters'),                        -- college_id: 1002
('College of Social Sciences and Philosophy'),          -- college_id: 1003
('College of Education');                               -- college_id: 1004


-- ============================================================
-- DATA: STUDENTS
-- student_id 1000–1015
-- Names match exactly as displayed in the UI
-- ============================================================

INSERT INTO Students (first_name, middle_name, last_name, college_id) VALUES
('Juan',      'Santos',    'Dela Cruz',  1000),         -- student_id: 1000
('Maria',     'Reyes',     'Garcia',     1001),         -- student_id: 1001
('Carlos',    'Mendoza',   'Lopez',      1002),         -- student_id: 1002
('Ana',       'Cruz',      'Martinez',   1003),         -- student_id: 1003
('Jose',      'Bautista',  'Rodriguez',  1004),         -- student_id: 1004
('Luisa',     'Villanueva','Hernandez',  1000),         -- student_id: 1005
('Miguel',    'Aquino',    'Gonzales',   1001),         -- student_id: 1006
('Sofia',     'Ramos',     'Perez',      1002),         -- student_id: 1007
('Ramon',     'Torres',    'Castillo',   1003),         -- student_id: 1008
('Elena',     'Flores',    'Morales',    1004),         -- student_id: 1009
('Diego',     'Pascual',   'Navarro',    1000),         -- student_id: 1010
('Isabella',  'Aguilar',   'Reyes',      1001),         -- student_id: 1011
('Marco',     'Domingo',   'Santiago',   1002),         -- student_id: 1012
('Gabrielle', 'Espinosa',  'Valdez',     1003),         -- student_id: 1013
('Rafael',    'Mercado',   'Salazar',    1004),         -- student_id: 1014
('Camille',   'Ocampo',    'Fuentes',    1000);         -- student_id: 1015


-- ============================================================
-- DATA: STUDENT VOTERS
-- studentvoter_id 1000–1015
-- user_id offset: user 1001 → student 1000, etc.
-- ============================================================

INSERT INTO StudentVoters (user_id, student_id) VALUES
(1001, 1000),                                           -- studentvoter_id: 1000 | Juan Dela Cruz
(1002, 1001),                                           -- studentvoter_id: 1001 | Maria Garcia
(1003, 1002),                                           -- studentvoter_id: 1002 | Carlos Lopez
(1004, 1003),                                           -- studentvoter_id: 1003 | Ana Martinez
(1005, 1004),                                           -- studentvoter_id: 1004 | Jose Rodriguez
(1006, 1005),                                           -- studentvoter_id: 1005 | Luisa Hernandez
(1007, 1006),                                           -- studentvoter_id: 1006 | Miguel Gonzales
(1008, 1007),                                           -- studentvoter_id: 1007 | Sofia Perez
(1009, 1008),                                           -- studentvoter_id: 1008 | Ramon Castillo
(1010, 1009),                                           -- studentvoter_id: 1009 | Elena Morales
(1011, 1010),                                           -- studentvoter_id: 1010 | Diego Navarro
(1012, 1011),                                           -- studentvoter_id: 1011 | Isabella Reyes
(1013, 1012),                                           -- studentvoter_id: 1012 | Marco Santiago
(1014, 1013),                                           -- studentvoter_id: 1013 | Gabrielle Valdez
(1015, 1014),                                           -- studentvoter_id: 1014 | Rafael Salazar
(1016, 1015);                                           -- studentvoter_id: 1015 | Camille Fuentes


-- ============================================================
-- DATA: ELECTION
-- election_id: 1000
-- ============================================================

INSERT INTO Elections (title, status, start_date, end_date) VALUES
('Student Council Election 2025', 'active', '2025-06-01 08:00:00', '2025-06-01 17:00:00');
-- election_id: 1000


-- ============================================================
-- DATA: POSITIONS
-- All under election_id 1000
-- position_id 1000–1005
-- ============================================================

INSERT INTO Positions (name, election_id) VALUES
('President',      1000),                               -- position_id: 1000
('Vice-President', 1000),                               -- position_id: 1001
('Senator',        1000),                               -- position_id: 1002
('Senator',        1000),                               -- position_id: 1003
('Senator',        1000),                               -- position_id: 1004
('Senator',        1000),                               -- position_id: 1005
('Vice-Governor',  1000);                               -- position_id: 1006


-- ============================================================
-- DATA: PARTYLISTS
-- All under election_id 1000
-- partylist_id 1000–1001
-- ============================================================

INSERT INTO Partylists (name, election_id) VALUES
('Partido Uno', 1000),                                  -- partylist_id: 1000
('Partido Dos', 1000);                                  -- partylist_id: 1001


-- ============================================================
-- DATA: CANDIDATES
-- candidate_id auto-increments from 1000
--
-- Partido Uno  (partylist_id: 1000)
--   candidate_id 1000 | Juan Dela Cruz    (student 1000) | President      (position 1000)
--   candidate_id 1001 | Maria Garcia      (student 1001) | Vice-President  (position 1001)
--   candidate_id 1002 | Carlos Lopez      (student 1002) | Senator         (position 1002)
--   candidate_id 1003 | Ana Martinez      (student 1003) | Senator         (position 1003)
--   candidate_id 1004 | Jose Rodriguez    (student 1004) | Senator         (position 1004)
--   candidate_id 1005 | Luisa Hernandez   (student 1005) | Vice-Governor   (position 1005)
--   candidate_id 1006 | Miguel Gonzales   (student 1006) | Senator         (position 1002)
--
-- Partido Dos  (partylist_id: 1001)
--   candidate_id 1007 | Ramon Castillo    (student 1008) | President       (position 1000)
--   candidate_id 1008 | Elena Morales     (student 1009) | Vice-President  (position 1001)
--   candidate_id 1009 | Diego Navarro     (student 1010) | Senator         (position 1002)
--   candidate_id 1010 | Isabella Reyes    (student 1011) | Senator         (position 1003)
--   candidate_id 1011 | Marco Santiago    (student 1012) | Senator         (position 1004)
--   candidate_id 1012 | Gabrielle Valdez  (student 1013) | Vice-Governor   (position 1005)
--   candidate_id 1013 | Camille Fuentes   (student 1015) | Senator         (position 1003)
-- ============================================================

INSERT INTO Candidates (partylist_id, student_id, position_id) VALUES
-- Partido Uno
(1000, 1000, 1000),                                     -- candidate_id: 1000 | Juan Dela Cruz    -> President
(1000, 1001, 1001),                                     -- candidate_id: 1001 | Maria Garcia      -> Vice-President
(1000, 1002, 1002),                                     -- candidate_id: 1002 | Carlos Lopez      -> Senator
(1000, 1003, 1003),                                     -- candidate_id: 1003 | Ana Martinez      -> Senator
(1000, 1004, 1004),                                     -- candidate_id: 1004 | Jose Rodriguez    -> Senator
(1000, 1005, 1005),                                     -- candidate_id: 1005 | Luisa Hernandez   -> Vice-Governor
(1000, 1006, 1002),                                     -- candidate_id: 1006 | Miguel Gonzales   -> Senator

-- Partido Dos
(1001, 1008, 1000),                                     -- candidate_id: 1007 | Ramon Castillo    -> President
(1001, 1009, 1001),                                     -- candidate_id: 1008 | Elena Morales     -> Vice-President
(1001, 1010, 1002),                                     -- candidate_id: 1009 | Diego Navarro     -> Senator
(1001, 1011, 1003),                                     -- candidate_id: 1010 | Isabella Reyes    -> Senator
(1001, 1012, 1004),                                     -- candidate_id: 1011 | Marco Santiago    -> Senator
(1001, 1013, 1005),                                     -- candidate_id: 1012 | Gabrielle Valdez  -> Vice-Governor
(1001, 1015, 1003);                                     -- candidate_id: 1013 | Camille Fuentes   -> Senator