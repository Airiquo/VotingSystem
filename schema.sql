CREATE TABLE `VotingSystem`.`Admins` (
  `id`       INT          NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB AUTO_INCREMENT = 1000;


INSERT INTO Admins(username, password) VALUES ("admin", "1234");