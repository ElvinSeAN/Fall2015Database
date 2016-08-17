USE yourdatabase;

CREATE TABLE actor (
	aid 	BIGINT AUTO_INCREMENT PRIMARY KEY,
	fname	VARCHAR(25) NOT NULL,
	lname	VARCHAR(25) NOT NULL,
	dob		date ,
	gender	CHAR(1)
	);

CREATE TABLE genre (
	gid	BIGINT AUTO_INCREMENT PRIMARY KEY,
	gname	VARCHAR(50) UNIQUE NOT NULL

	);

CREATE TABLE movie (
	mid	BIGINT AUTO_INCREMENT PRIMARY KEY,
	title	VARCHAR(50) NOT NULL,
	year 	BIGINT,
	rating		VARCHAR(10),
	gid	BIGINT,
		FOREIGN KEY (gid) REFERENCES genre(gid)
		
	);

CREATE TABLE medium(
	medid BIGINT AUTO_INCREMENT PRIMARY KEY,
	medname	VARCHAR(30) NOT NULL
);


CREATE TABLE role(
	roleid BIGINT AUTO_INCREMENT PRIMARY KEY,
	mid 	BIGINT,
	aid 	BIGINT,
	rolename	VARCHAR(50),
		FOREIGN KEY(mid) REFERENCES movie(mid),
		FOREIGN KEY(aid) REFERENCES actor(aid)
);


CREATE TABLE releaserecord(
	releaseid BIGINT AUTO_INCREMENT PRIMARY KEY,
	mid 	BIGINT,
	medid	BIGINT,
	releasedate	date,
		FOREIGN KEY(mid) REFERENCES movie(mid),
		FOREIGN KEY(medid) REFERENCES medium(medid)
);
