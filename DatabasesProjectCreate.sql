ALTER TABLE Discs DROP FOREIGN KEY DiscManufacturer;
ALTER TABLE Players DROP FOREIGN KEY PlayerManufacturer;
ALTER TABLE Player_Stats DROP FOREIGN KEY EventsWon;

DROP TABLE IF EXISTS Discs, Manufacturers, Players, Player_Stats, Tour_Events;

CREATE TABLE Discs (
  Disc_ID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  Disc_Name varchar(40),
  Manufacturer_ID int,
  Speed int,
  Glide int,
  Turn int,
  Fade int
) engine = InnoDB;

CREATE TABLE Manufacturers (
  Manufacturer_ID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  Manufacturer_Name varchar(40)
) engine = InnoDB;

CREATE TABLE Players (
  Player_ID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  Player_Name varchar(40),
  Manufacturer_ID int
) engine = InnoDB;

CREATE TABLE Player_Stats (
  Player_Rank int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  Player_Name varchar(40),
  C1_Putting int,
  C2_Putting int,
  Best_Tour_Finish_2021 int,
  Last_Event_Won int
) engine = InnoDB;

CREATE TABLE Tour_Events (
  Event_ID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  Event_Name varchar(40),
  Event_Tier varchar(40)
) engine = InnoDB;

ALTER TABLE Discs ADD CONSTRAINT DiscManufacturer FOREIGN KEY Manufacturers (Manufacturer_ID)
    REFERENCES Manufacturers (Manufacturer_ID) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE Players ADD CONSTRAINT PlayerManufacturer FOREIGN KEY Manufacturers (Manufacturer_ID)
    REFERENCES Manufacturers (Manufacturer_ID) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE Player_Stats ADD CONSTRAINT EventsWon FOREIGN KEY (Last_Event_Won)
    REFERENCES Tour_Events(Event_ID) ON DELETE CASCADE ON UPDATE CASCADE;
