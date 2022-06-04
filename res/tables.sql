CREATE TABLE `user_status` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `status` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `users` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `login` varchar(45) NOT NULL,
    `password` varchar(64) DEFAULT '',
    `status_id` int(10) unsigned NOT NULL,
    PRIMARY KEY (`id`,`login`),
    UNIQUE KEY `id_UNIQUE` (`id`),
    UNIQUE KEY `login_UNIQUE` (`login`),
    CONSTRAINT `status_id` FOREIGN KEY (`status_id`) REFERENCES `user_status` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `task_status` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `status` varchar(45) DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `task` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `employee_id` int(10) unsigned NOT NULL,
    `employer_id` int(10) unsigned NOT NULL,
    `status_id` int(10) unsigned NOT NULL DEFAULT '1',
    `header` varchar(240) DEFAULT '',
    `description` mediumtext,
    `datetime` datetime DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `id_UNIQUE` (`id`),
    KEY `employee_id_idx` (`employee_id`),
    KEY `employer_id_idx` (`employer_id`),
    KEY `status_id_idx` (`status_id`),
    CONSTRAINT `employee_id` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `employer_id` FOREIGN KEY (`employer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `task_status_id` FOREIGN KEY (`status_id`) REFERENCES `task_status` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

CREATE TABLE `reports` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `task_id` int(10) unsigned NOT NULL,
    `filename` varchar(80) CHARACTER SET utf8 DEFAULT NULL,
    `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `id_UNIQUE` (`id`),
    CONSTRAINT `task_id` FOREIGN KEY (`task_id`) REFERENCES `task` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `comments` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `report_id` int(10) unsigned DEFAULT NULL,
    `task_id` int(10) unsigned NOT NULL,
    `message` tinytext,
    `datetime` datetime DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `id_UNIQUE` (`id`),
    KEY `report_id_idx` (`report_id`),
    KEY `task_id_idx` (`task_id`),
    CONSTRAINT `report_id` FOREIGN KEY (`report_id`) REFERENCES `reports` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `comment_task_id` FOREIGN KEY (`task_id`) REFERENCES `task` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `feedbacks` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `email` varchar(128) NOT NULL,
    `feedback` tinytext NOT NULL,
    `datetime` datetime DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

INSERT INTO `task_status` VALUES (1,'new'),(2,'review'),(3,'completed');
INSERT INTO `user_status` VALUES (1,'employee'),(2,'employer');
Insert into `users` (login, status_id) values ("Alex" , 1);
Insert into `users` (login, status_id) values ("Valentin" , 2);
Insert into `users` (login, status_id) values ("Kate" , 2);
Insert into `users` (login, status_id) values ("Vadim" , 1);



