
DROP TABLE IF EXISTS event_tag;
DROP TABLE IF EXISTS tag;
DROP TABLE IF EXISTS participation;
DROP TABLE IF EXISTS comment;
DROP TABLE IF EXISTS "match";
DROP TABLE IF EXISTS competitor;
DROP TABLE IF EXISTS "file";
DROP TABLE IF EXISTS poll_answer;
DROP TABLE IF EXISTS poll_option;
DROP TABLE IF EXISTS poll;
DROP TABLE IF EXISTS "event";
DROP TABLE IF EXISTS category;
DROP TABLE IF EXISTS suspension;
DROP TABLE IF EXISTS banned_user;
DROP TABLE IF EXISTS user;

DROP TYPE IF EXISTS gender;
DROP TYPE IF EXISTS "status";
DROP TYPE IF EXISTS visibility;
DROP TYPE IF EXISTS event_type;
DROP TYPE IF EXISTS result;

-- Types

CREATE TYPE gender AS ENUM ('Male', 'Female', 'Other');
CREATE TYPE "status" AS ENUM ('JoinRequest', 'Invitation', 'Accepted', 'Declined');
CREATE TYPE visibility AS ENUM ('Public', 'Private');
CREATE TYPE event_type AS ENUM ('InPerson', 'Mixed', 'Virtual');
CREATE TYPE result AS ENUM ('TBD', 'Winner1', 'Winner2', 'Tie');

-- Tables

-- R01
CREATE TABLE user (
    id SERIAL PRIMARY KEY,
    username TEXT NOT NULL CONSTRAINT username_uk UNIQUE,
    "name" TEXT NOT NULL,
    email NOT NULL CONSTRAINT email_uk UNIQUE,
    "password" TEXT NOT NULL,
    "address" TEXT,
    gender gender,
    age INTEGER,
    website TEXT,
    picture BYTEA,
    "description" TEXT,
    active BOOLEAN NOT NULL DEFAULT true
);

-- R02
CREATE TABLE "event" (
    id SERIAL PRIMARY KEY,
    id_organizer INTEGER REFERENCES user(id) NOT NULL,
    title TEXT NOT NULL,
    visibility visibility NOT NULL DEFAULT 'Public',
    "description" TEXT NOT NULL,
    picture BYTEA,
    "start_date" TIMESTAMP,
    end_date TIMESTAMP,
    "type" event_type NOT NULL DEFAULT 'InPerson',
    "location" TEXT,
    max_attendance INTEGER CONSTRAINT max_attendance_ck CHECK ((max_attendance >= 0) AND (max_attendance <= 10000)),
    cancelled BOOLEAN NOT NULL DEFAULT false,
    keywords tsvector,
    id_category INTEGER REFERENCES category(id) NOT NULL,
    win_points REAL NOT NULL DEFAULT 1 CONSTRAINT win_points_ck CHECK ((win_points) >= 0) AND (win_points <= 100)),
    draw_points REAL NOT NULL DEFAULT 0.5 CONSTRAINT draw_points_ck CHECK ((draw_points >= 0) AND (draw_points <= 100)),
    loss_points REAL NOT NULL DEFAULT 0 CONSTRAINT loss_points_ck CHECK ((loss_points >= 0) AND (loss_points <= 100)),
    leaderboard BOOLEAN NOT NULL DEFAULT false,
    CONSTRAINT date_ck CHECK ("start_date" < end_date)
);

-- R03
CREATE TABLE "match" (
    id SERIAL PRIMARY KEY,
    id_event INTEGER REFERENCES "event"(id) NOT NULL,
    "date" TIMESTAMP,
    "description" TEXT,
    result result NOT NULL,
    id_competitor1 INTEGER REFERENCES competitor(id) NOT NULL,
    id_competitor2 INTEGER REFERENCES competitor(id) NOT NULL,
    CONSTRAINT competitor_ids_ck CHECK (id_competitor1 <> id_competitor2)
);

-- R04
CREATE TABLE competitor (
    id SERIAL PRIMARY KEY,
    id_event INTEGER REFERENCES "event"(id) NOT NULL,
    "name" TEXT NOT NULL,
    CONSTRAINT competitor_uk UNIQUE (id_event, "name")
);

-- R05
CREATE TABLE tag (
    id SERIAL PRIMARY KEY,
    "name" TEXT NOT NULL CONSTRAINT tag_uk UNIQUE
);

-- R06
CREATE TABLE category (
    id SERIAL PRIMARY KEY,
    "name" TEXT NOT NULL CONSTRAINT category_uk UNIQUE
);

-- R07
CREATE TABLE "file" (
    id SERIAL PRIMARY KEY,
    id_event INTEGER REFERENCES "event"(id) NOT NULL,
    "name" TEXT NOT NULL,
    "data" BYTEA NOT NULL,
    date_uploaded TIMESTAMP NOT NULL DEFAULT now()
);

-- R08
CREATE TABLE event_tag (
    id_event INTEGER REFERENCES "event"(id),
    id_tag INTEGER REFERENCES tag(id),
    PRIMARY KEY (id_event, id_tag)
);

-- R09
CREATE TABLE comment (
    id SERIAL PRIMARY KEY,
    id_author INTEGER REFERENCES user(id),
    id_event INTEGER REFERENCES "event"(id) NOT NUL,
    id_parent INTEGER REFERENCES comment(id),
    "text" TEXT NOT NULL,
    "date" TIMESTAMP NOT NULL DEFAULT now()  
);

-- R10
CREATE TABLE participation (
    id_user INTEGER REFERENCES user(id),
    id_event INTEGER REFERENCES "event"(id),
    "status" "status" NOT NULL,
    PRIMARY KEY (id_user, id_event)
);

-- R11
CREATE TABLE poll (
    id SERIAL PRIMARY KEY,
    id_event INTEGER REFERENCES "event"(id) NOT NULL,
    question TEXT NOT NULL
);

-- R12
CREATE TABLE poll_option (
    id SERIAL PRIMARY KEY,
    id_poll INTEGER REFERENCES poll(id) NOT NULL,
    "option" TEXT NOT NULL
);

-- R13
CREATE TABLE poll_answer (
    id_user INTEGER REFERENCES user(id) NOT NULL,
    id_poll INTEGER REFERENCES poll(id) NOT NULL,
    id_poll_option INTEGER REFERENCES poll_option(id),
    PRIMARY KEY (id_user, id_poll)
);

-- R14
CREATE TABLE banned_user (
    id_user INTEGER REFERENCES user(id) PRIMARY KEY,
    since TIMESTAMP NOT NULL,
    reason TEXT NOT NULL
);

-- R15
CREATE TABLE suspension (
    id SERIAL PRIMARY KEY,
    id_user INTEGER REFERENCES user(id) NOT NULL, 
    "from" TIMESTAMP NOT NULL,
    until TIMESTAMP NOT NULL,
    reason TEXT NOT NULL
    CONSTRAINT date_ck CHECK "from" < until
);
