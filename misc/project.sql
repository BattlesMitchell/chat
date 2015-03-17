DROP SCHEMA IF EXISTS project CASCADE;
CREATE SCHEMA project;

SET search_path = project;

CREATE TABLE users (
    username varchar(35),
    password varchar(35),
    fname varchar(25),
    lname varchar(30),
    image varchar(2083),
    is_active boolean,
    is_private boolean,
    PRIMARY KEY (username)
);

INSERT INTO users VALUES ('jlhthd', 'xxxxxx', 'Joshua', 'Heffron', 'http://placehold.it/50', TRUE, FALSE);
INSERT INTO users VALUES ('klaricm', 'yyyyyy', 'Matthew', 'Klaric', 'http://placehold.it/50', TRUE, FALSE);

CREATE TABLE user_varification (
    username varchar(35) REFERENCES users ON DELETE CASCADE,
    email varchar(100),
    PRIMARY KEY (username)
);

INSERT INTO user_varification VALUES ('jlhthd', 'jlhthd@mail.missouri.edu');

CREATE TABLE boards (
    board_id serial NOT NULL,
    board_name varchar(40),
    PRIMARY KEY (board_id)
);

INSERT INTO boards VALUES (DEFAULT, 'Example Board One');
INSERT INTO boards VALUES (DEFAULT, 'Example Board Two');
INSERT INTO boards VALUES (DEFAULT, 'Example Board Three');

CREATE TABLE posted_to (
    post_id serial,
    board_id serial REFERENCES boards ON DELETE CASCADE,
    username varchar(35) REFERENCES users,
    post varchar(511),
    post_timestamp timestamp,
    has_attachment boolean,
    PRIMARY KEY (post_id)
);

INSERT INTO posted_to VALUES (DEFAULT, 1, 'jlhthd', 'Test Post One', NOW(), FALSE);
INSERT INTO posted_to VALUES (DEFAULT, 1, 'klaricm', 'Test Post Two', NOW(), FALSE);
INSERT INTO posted_to VALUES (DEFAULT, 2, 'klaricm', 'Test Post Three', NOW(), FALSE);

CREATE INDEX ON posted_to USING hash (board_id);

CREATE TABLE attachment (
    post_id serial REFERENCES posted_to,
    file_location varchar(2083),
    PRIMARY KEY (post_id)
);

CREATE TABLE belongs_to (
    board_id serial REFERENCES boards ON DELETE CASCADE,
    username varchar(35) REFERENCES users,
    PRIMARY KEY (board_id, username)
);

INSERT INTO belongs_to VALUES (1, 'jlhthd');
INSERT INTO belongs_to VALUES (2, 'jlhthd');
INSERT INTO belongs_to VALUES (3, 'jlhthd');
INSERT INTO belongs_to VALUES (1, 'klaricm');
INSERT INTO belongs_to VALUES (2, 'klaricm');

CREATE TABLE friends_with (
    user_one varchar(35) REFERENCES users(username),
    user_two varchar(35) REFERENCES users(username),
    PRIMARY KEY (user_one, user_two)
);

INSERT INTO friends_with VALUES ('jlhthd', 'klaricm');