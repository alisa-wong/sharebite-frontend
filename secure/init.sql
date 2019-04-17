BEGIN TRANSACTION; 

CREATE TABLE `sections` (
    `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
    `name` TEXT NOT NULL UNIQUE
);

INSERT INTO `sections` (name) VALUES ("Lunch Specials");
INSERT INTO `sections` (name) VALUES ("Dinner Specials");

CREATE TABLE `items` (
    `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
    `name` TEXT NOT NULL UNIQUE
);

INSERT INTO `items` (name) VALUES ("Chicken Over Rice");

CREATE TABLE `section_items` (
    `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
    `section_id` TEXT NOT NULL,
    `item_id` TEXT NOT NULL
);

INSERT INTO `section_items` (section_id, item_id) VALUES (1, 1);

COMMIT;