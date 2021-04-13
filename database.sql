
DROP TRIGGER IF EXISTS comment_author ON comment;
DROP TRIGGER IF EXISTS comment_parent ON parent;
DROP TRIGGER IF EXISTS match_competitors ON "match";
DROP TRIGGER IF EXISTS poll_answer_user ON poll_answer;
DROP TRIGGER IF EXISTS poll_answer_option ON poll_answer;
DROP TRIGGER IF EXISTS match_during_event ON "match";

DROP FUNCTION IF EXISTS comment_author();
DROP FUNCTION IF EXISTS comment_parent();
DROP FUNCTION IF EXISTS match_competitors();
DROP FUNCTION IF EXISTS poll_answer_user();
DROP FUNCTION IF EXISTS poll_answer_option();
DROP FUNCTION IF EXISTS match_during_event();

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
DROP TABLE IF EXISTS "user";
DROP TABLE IF EXISTS administrator;

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
CREATE TABLE administrator (
    id SERIAL PRIMARY KEY,
    username TEXT NOT NULL CONSTRAINT administrator_username_uk UNIQUE,
    "password" TEXT NOT NULL
);

-- R02
CREATE TABLE "user" (
    id SERIAL PRIMARY KEY,
    username TEXT NOT NULL CONSTRAINT user_username_uk UNIQUE,
    "name" TEXT NOT NULL,
    email TEXT NOT NULL CONSTRAINT user_email_uk UNIQUE,
    "password" TEXT NOT NULL,
    "address" TEXT,
    gender gender,
    age INTEGER,
    website TEXT,
    picture BYTEA,
    "description" TEXT,
    active BOOLEAN NOT NULL DEFAULT true
);

-- R03
CREATE TABLE banned_user (
    id_user INTEGER REFERENCES "user"(id) PRIMARY KEY,
    since TIMESTAMP NOT NULL,
    reason TEXT NOT NULL
);

-- R04
CREATE TABLE suspension (
    id SERIAL PRIMARY KEY,
    id_user INTEGER REFERENCES "user"(id) NOT NULL, 
    "from" TIMESTAMP NOT NULL,
    until TIMESTAMP NOT NULL,
    reason TEXT NOT NULL,
    CONSTRAINT suspension_date_ck CHECK ("from" < until)
);

-- R05
CREATE TABLE category (
    id SERIAL PRIMARY KEY,
    "name" TEXT NOT NULL CONSTRAINT category_uk UNIQUE
);

-- R06
CREATE TABLE "event" (
    id SERIAL PRIMARY KEY,
    id_organizer INTEGER REFERENCES "user"(id) NOT NULL,
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
    win_points NUMERIC(3) NOT NULL DEFAULT 1 CONSTRAINT win_points_ck CHECK ((win_points >= 0) AND (win_points <= 100)),
    draw_points NUMERIC(3) NOT NULL DEFAULT 0.5 CONSTRAINT draw_points_ck CHECK ((draw_points >= 0) AND (draw_points <= 100)),
    loss_points NUMERIC(3) NOT NULL DEFAULT 0 CONSTRAINT loss_points_ck CHECK ((loss_points >= 0) AND (loss_points <= 100)),
    leaderboard BOOLEAN NOT NULL DEFAULT false,
    CONSTRAINT event_date_ck CHECK ("start_date" < end_date)
);

-- R07
CREATE TABLE poll (
    id SERIAL PRIMARY KEY,
    id_event INTEGER REFERENCES "event"(id) NOT NULL,
    question TEXT NOT NULL
);

-- R08
CREATE TABLE poll_option (
    id SERIAL PRIMARY KEY,
    id_poll INTEGER REFERENCES poll(id) NOT NULL,
    "option" TEXT NOT NULL
);

-- R09
CREATE TABLE poll_answer (
    id_user INTEGER REFERENCES "user"(id) NOT NULL,
    id_poll INTEGER REFERENCES poll(id) NOT NULL,
    id_poll_option INTEGER REFERENCES poll_option(id),
    PRIMARY KEY (id_user, id_poll)
);

-- R10
CREATE TABLE "file" (
    id SERIAL PRIMARY KEY,
    id_event INTEGER REFERENCES "event"(id) NOT NULL,
    "name" TEXT NOT NULL,
    "data" BYTEA NOT NULL,
    date_uploaded TIMESTAMP NOT NULL DEFAULT now()
);

-- R11
CREATE TABLE competitor (
    id SERIAL PRIMARY KEY,
    id_event INTEGER REFERENCES "event"(id) NOT NULL,
    "name" TEXT NOT NULL,
    CONSTRAINT competitor_uk UNIQUE (id_event, "name")
);

-- R12
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

-- R13
CREATE TABLE comment (
    id SERIAL PRIMARY KEY,
    id_author INTEGER REFERENCES "user"(id),
    id_event INTEGER REFERENCES "event"(id) NOT NULL,
    id_parent INTEGER REFERENCES comment(id),
    "text" TEXT NOT NULL,
    "date" TIMESTAMP NOT NULL DEFAULT now()  
);

-- R14
CREATE TABLE participation (
    id_user INTEGER REFERENCES "user"(id),
    id_event INTEGER REFERENCES "event"(id),
    "status" "status" NOT NULL,
    PRIMARY KEY (id_user, id_event)
);

-- R15
CREATE TABLE tag (
    id SERIAL PRIMARY KEY,
    "name" TEXT NOT NULL CONSTRAINT tag_uk UNIQUE
);

-- R16
CREATE TABLE event_tag (
    id_event INTEGER REFERENCES "event"(id),
    id_tag INTEGER REFERENCES tag(id),
    PRIMARY KEY (id_event, id_tag)
);


-- Triggers

-- TRIGGER01
CREATE FUNCTION comment_author() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF (NEW.id_author IS NOT NULL 
    AND NEW.id_author <> (SELECT id_organizer FROM "event" WHERE "event".id = NEW.id_event)
    AND NOT EXISTS (SELECT * FROM participation WHERE id_user = NEW.id_author AND participation.id_event = NEW.id_event AND "status" = 'Accepted')) THEN
        RAISE EXCEPTION 'Comment author must be the event organizer or one of its participants.';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER comment_author
    BEFORE INSERT OR UPDATE ON comment
    FOR EACH ROW
    EXECUTE PROCEDURE comment_author();

-- TRIGGER02
CREATE FUNCTION comment_parent() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF (NEW.id_parent IS NOT NULL AND NEW.id_event <> (SELECT id_event FROM comment WHERE comment.id = NEW.id_parent)) THEN
        RAISE EXCEPTION 'The parent comment must be from the same event.';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER comment_parent
    BEFORE INSERT ON comment
    FOR EACH ROW
    EXECUTE PROCEDURE comment_parent();

-- TRIGGER03
CREATE FUNCTION match_competitors() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF (NEW.id_event <> (SELECT id_event FROM competitor AS c1 WHERE c1.id = NEW.id_competitor1) OR NEW.id_event <> (SELECT id_event FROM competitor AS c2 WHERE c2.id = NEW.id_competitor2)) THEN
        RAISE EXCEPTION 'The competitors must be part of the same event as the match.';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER match_competitors
    BEFORE INSERT OR UPDATE ON "match"
    FOR EACH ROW
    EXECUTE PROCEDURE match_competitors();

-- TRIGGER04
CREATE FUNCTION poll_answer_user() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NOT EXISTS (SELECT * FROM participation WHERE participation.id_user = NEW.id_user AND "status" = 'Accepted' AND participation.id_event = (SELECT id_event FROM poll WHERE poll.id = NEW.id_poll)) THEN
        RAISE EXCEPTION 'The user who answered the poll must be a participant in the event.';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER poll_answer_user
    BEFORE INSERT OR UPDATE ON poll_answer
    FOR EACH ROW
    EXECUTE PROCEDURE poll_answer_user();

-- TRIGGER05
CREATE FUNCTION poll_answer_option() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NEW.id_poll_option NOT IN (SELECT id FROM poll_option WHERE poll_option.id_poll = NEW.id_poll) THEN
        RAISE EXCEPTION 'The chosen option in a poll answer must be one of the options from the poll.';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER poll_answer_option
    BEFORE INSERT OR UPDATE ON poll_answer
    FOR EACH ROW
    EXECUTE PROCEDURE poll_answer_option();

-- TRIGGER06
CREATE FUNCTION match_during_event() RETURNS TRIGGER AS
$BODY$
DECLARE
    ev_start_date TIMESTAMP;
    ev_end_date TIMESTAMP;
BEGIN
    SELECT "start_date", end_date INTO ev_start_date, ev_end_date FROM "event" WHERE NEW.id_event = "event".id;
    IF NEW.date IS NOT NULL AND ev_start_date IS NOT NULL AND ev_end_date IS NOT NULL AND (NEW.date < ev_start_date OR NEW.date > ev_end_date) THEN
        RAISE EXCEPTION 'The date of a match must be between the start and end dates of the event.';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER match_during_event
    BEFORE INSERT OR UPDATE ON "match"
    FOR EACH ROW
    EXECUTE PROCEDURE match_during_event();
