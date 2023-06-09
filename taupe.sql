USE TAUPEH;

SET FOREIGN_KEY_CHECKS = FALSE;
DROP TABLE IF EXISTS USER;
DROP TABLE IF EXISTS SESSION;
DROP TABLE IF EXISTS HOTEL;
DROP TABLE IF EXISTS ROOM;
DROP TABLE IF EXISTS TAKEN;
DROP TABLE IF EXISTS NOTE;
DROP TABLE IF EXISTS RATEL;
DROP FUNCTION IF EXISTS MAX_RESERVE_D2D;
SET FOREIGN_KEY_CHECKS = TRUE;

CREATE TABLE USER (
	ID INT AUTO_INCREMENT NOT NULL,
    LNAME VARCHAR(512) NOT NULL,
    FNAME VARCHAR(512) NOT NULL,
    PHONE VARCHAR(13) NOT NULL,
    EMAIL VARCHAR(512) NOT NULL,
    HPWD VARCHAR(128) NOT NULL,
    TYPE ENUM("CLIENT", "MANAGER", "ADMIN") NOT NULL DEFAULT "CLIENT",
    PERM INT NOT NULL DEFAULT 0,
    CONSTRAINT prime_user PRIMARY KEY (ID),
    CONSTRAINT unique_email_user UNIQUE (EMAIL)
) ENGINE = InnoDB COLLATE utf8mb4_bin;

CREATE TABLE SESSION (
	ID INT AUTO_INCREMENT NOT NULL,
	TOKEN VARCHAR(128) NOT NULL,
    DC DATETIME NOT NULL DEFAULT NOW(),
    NAME VARCHAR(512) NOT NULL,
    USER INT NOT NULL,
    CONSTRAINT prime_session PRIMARY KEY (ID),
	CONSTRAINT user_session FOREIGN KEY (USER) 
		REFERENCES USER (ID) ON DELETE CASCADE
) ENGINE = InnoDB COLLATE utf8mb4_bin;

CREATE TABLE HOTEL (
	ID INT AUTO_INCREMENT NOT NULL,
    NAME VARCHAR(512) NOT NULL,
    COUNTRY VARCHAR(512) NOT NULL,
    CITY VARCHAR(512) NOT NULL,
    ADDRESS VARCHAR(512) NOT NULL,
    DESCR VARCHAR(2048) NOT NULL,
    IMG0 VARCHAR(1024) NOT NULL,
    IMG1 VARCHAR(1024),
    IMG2 VARCHAR(1024),
    IMG3 VARCHAR(1024),
    IMG4 VARCHAR(1024),
    MANAGER INT NOT NULL,
    CONSTRAINT prime_hotel PRIMARY KEY (ID),
    CONSTRAINT manager_hotel FOREIGN KEY (MANAGER) 
		REFERENCES USER (ID) ON DELETE CASCADE 
) ENGINE = InnoDB COLLATE utf8mb4_bin;

CREATE TABLE ROOM (
	ID INT AUTO_INCREMENT NOT NULL,
    PRICE DECIMAL(10,2) NOT NULL,
    NAME VARCHAR(512) NOT NULL,
	DESCR VARCHAR(2048) NOT NULL,
	IMG0 VARCHAR(1024) NOT NULL,
    IMG1 VARCHAR(1024),
    IMG2 VARCHAR(1024),
    IMG3 VARCHAR(1024),
    IMG4 VARCHAR(1024),
    TYPE ENUM("DORMITORY", "SOLO") NOT NULL,
    PLACE INT NOT NULL,
    HOTEL INT NOT NULL,
    DTO DATE NOT NULL,
    CONSTRAINT prime_room PRIMARY KEY (ID),
    CONSTRAINT hotel_room FOREIGN KEY (HOTEL)
		REFERENCES HOTEL (ID) ON DELETE CASCADE,
	CONSTRAINT place_room CHECK (PLACE > 0),
    CONSTRAINT price_room CHECK (PRICE >= 0)
) ENGINE = InnoDB COLLATE utf8mb4_bin;

CREATE TABLE TAKEN (
	DFROM DATE NOT NULL,
    DTO DATE NOT NULL,
    ROOM INT NOT NULL,
    USER INT NOT NULL,
    PLACE INT NOT NULL,
    CONSTRAINT prime_taken PRIMARY KEY (DFROM, DTO, ROOM, USER),
	CONSTRAINT room_taken FOREIGN KEY (ROOM)
		REFERENCES ROOM (ID) ON DELETE CASCADE,
	CONSTRAINT user_taken FOREIGN KEY (USER)
		REFERENCES USER (ID) ON DELETE CASCADE,
	CONSTRAINT place_taken CHECK (PLACE > 0)
) ENGINE = InnoDB COLLATE utf8mb4_bin;

CREATE TABLE NOTE (
	NOTE INT NOT NULL,
    U_ID INT NOT NULL,
    R_ID INT NOT NULL,
    DTO DATE NOT NULL,
    DFROM DATE NOT NULL,
    CONSTRAINT prime_note PRIMARY KEY (DFROM, DTO, R_ID, U_ID),
    CONSTRAINT taken_note FOREIGN KEY (DFROM, DTO, R_ID, U_ID) 
		REFERENCES TAKEN (DFROM, DTO, ROOM, USER) ON DELETE CASCADE,
	CONSTRAINT note_note CHECK (NOTE >= 0 AND NOTE <= 5 )
) ENGINE = InnoDB COLLATE utf8mb4_bin;


CREATE TABLE RATEL (
	IP VARCHAR(128) NOT NULL,
    DL DATETIME NOT NULL DEFAULT NOW(),
    CL INT NOT NULL DEFAULT 0,
    DG DATETIME NOT NULL DEFAULT NOW(),
    CG INT NOT NULL DEFAULT 0,
    DP DATETIME NOT NULL DEFAULT NOW(),
    CP INT NOT NULL DEFAULT 0,
    DM DATETIME NOT NULL DEFAULT NOW(),
    CM INT NOT NULL DEFAULT 0,
    CONSTRAINT prime_ratel PRIMARY KEY (IP),
	CONSTRAINT count_ratel CHECK (CL >= 0 
		AND CG >= 0 AND CP >= 0 AND CM >= 0)
) ENGINE = InnoDB COLLATE utf8mb4_bin;

DELIMITER $$
CREATE FUNCTION MAX_RESERVE_D2D(_FROM DATE, _TO DATE, _ID INT) 
RETURNS INT DETERMINISTIC
BEGIN
	DECLARE MAX INT DEFAULT 0;
    DECLARE CUR INT;
    WHILE _FROM < _TO DO
		SET CUR = (SELECT SUM(PLACE) FROM TAKEN WHERE 
			ROOM = _ID AND _FROM BETWEEN DFROM AND DTO 
            AND DATE_ADD(_FROM, INTERVAL 1 DAY) BETWEEN DFROM AND DTO);
		IF CUR > MAX THEN
			SET MAX = CUR;
		END IF;
        SET _FROM = DATE_ADD(_FROM, INTERVAL 1 DAY);
    END WHILE;
    RETURN MAX;
END $$