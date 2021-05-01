
DROP INDEX IF EXISTS event_id_organizer_idx;
DROP INDEX IF EXISTS poll_id_event_idx;
DROP INDEX IF EXISTS file_id_event_idx;
DROP INDEX IF EXISTS competitor_id_event_idx;
DROP INDEX IF EXISTS match_id_event_idx;
DROP INDEX IF EXISTS poll_option_id_poll_idx;
DROP INDEX IF EXISTS poll_answer_id_poll_option_idx;
DROP INDEX IF EXISTS event_tag_tag_name_idx;
DROP INDEX IF EXISTS participation_status_id_event_idx;
DROP INDEX IF EXISTS event_type_idx;
DROP INDEX IF EXISTS event_start_date_idx;
DROP INDEX IF EXISTS event_end_date_idx;
DROP INDEX IF EXISTS event_id_category_idx;

DROP INDEX IF EXISTS search_idx;

DROP TRIGGER IF EXISTS comment_author ON comment;
DROP TRIGGER IF EXISTS comment_parent ON comment;
DROP TRIGGER IF EXISTS match_competitors ON "match";
DROP TRIGGER IF EXISTS poll_answer_user ON poll_answer;
DROP TRIGGER IF EXISTS poll_answer_option ON poll_answer;
DROP TRIGGER IF EXISTS match_during_event ON "match";
DROP TRIGGER IF EXISTS account_deletion ON "user";
DROP TRIGGER IF EXISTS update_event_keywords ON "event";

DROP FUNCTION IF EXISTS comment_author();
DROP FUNCTION IF EXISTS comment_parent();
DROP FUNCTION IF EXISTS match_competitors();
DROP FUNCTION IF EXISTS poll_answer_user();
DROP FUNCTION IF EXISTS poll_answer_option();
DROP FUNCTION IF EXISTS match_during_event();
DROP FUNCTION IF EXISTS account_deletion();
DROP FUNCTION IF EXISTS update_event_keywords();

DROP TABLE IF EXISTS event_tag;
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
    picture TEXT,
    "description" TEXT
);

-- R03
CREATE TABLE banned_user (
    id_user INTEGER PRIMARY KEY REFERENCES "user"(id) ON DELETE CASCADE,
    since TIMESTAMP NOT NULL,
    reason TEXT NOT NULL
);

-- R04
CREATE TABLE suspension (
    id SERIAL PRIMARY KEY,
    id_user INTEGER NOT NULL REFERENCES "user"(id) ON DELETE CASCADE, 
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
    id_organizer INTEGER NOT NULL REFERENCES "user"(id) ON DELETE CASCADE,
    title TEXT NOT NULL,
    visibility visibility NOT NULL DEFAULT 'Public',
    "description" TEXT NOT NULL,
    keywords tsvector,
    picture TEXT,
    "start_date" TIMESTAMP,
    end_date TIMESTAMP,
    "type" event_type NOT NULL DEFAULT 'InPerson',
    "location" TEXT,
    max_attendance INTEGER CONSTRAINT max_attendance_ck CHECK ((max_attendance >= 0) AND (max_attendance <= 10000)),
    cancelled BOOLEAN NOT NULL DEFAULT false,
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
    id_event INTEGER NOT NULL REFERENCES "event"(id) ON DELETE CASCADE,
    question TEXT NOT NULL
);

-- R08
CREATE TABLE poll_option (
    id SERIAL PRIMARY KEY,
    id_poll INTEGER NOT NULL REFERENCES poll(id) ON DELETE CASCADE,
    "option" TEXT NOT NULL
);

-- R09
CREATE TABLE poll_answer (
    id_user INTEGER NOT NULL REFERENCES "user"(id) ON DELETE CASCADE,
    id_poll_option INTEGER REFERENCES poll_option(id) ON DELETE CASCADE,
    PRIMARY KEY (id_user, id_poll_option)
);

-- R10
CREATE TABLE "file" (
    id SERIAL PRIMARY KEY,
    id_event INTEGER NOT NULL REFERENCES "event"(id) ON DELETE CASCADE,
    "name" TEXT NOT NULL,
    "data" BYTEA NOT NULL,
    date_uploaded TIMESTAMP NOT NULL DEFAULT now()
);

-- R11
CREATE TABLE competitor (
    id SERIAL PRIMARY KEY,
    id_event INTEGER NOT NULL REFERENCES "event"(id) ON DELETE CASCADE,
    "name" TEXT NOT NULL,
    CONSTRAINT competitor_uk UNIQUE (id_event, "name")
);

-- R12
CREATE TABLE "match" (
    id SERIAL PRIMARY KEY,
    id_event INTEGER NOT NULL REFERENCES "event"(id) ON DELETE CASCADE,
    "date" TIMESTAMP,
    "description" TEXT,
    result result NOT NULL,
    id_competitor1 INTEGER NOT NULL REFERENCES competitor(id) ON DELETE CASCADE,
    id_competitor2 INTEGER NOT NULL REFERENCES competitor(id) ON DELETE CASCADE,
    CONSTRAINT competitor_ids_ck CHECK (id_competitor1 <> id_competitor2)
);

-- R13
CREATE TABLE comment (
    id SERIAL PRIMARY KEY,
    id_author INTEGER REFERENCES "user"(id) ON DELETE SET NULL,
    id_event INTEGER NOT NULL REFERENCES "event"(id) ON DELETE CASCADE,
    id_parent INTEGER REFERENCES comment(id) ON DELETE SET NULL,
    "text" TEXT,
    "date" TIMESTAMP NOT NULL DEFAULT now()  
);

-- R14
CREATE TABLE participation (
    id_user INTEGER REFERENCES "user"(id) ON DELETE CASCADE,
    id_event INTEGER REFERENCES "event"(id) ON DELETE CASCADE,
    "status" "status" NOT NULL,
    PRIMARY KEY (id_user, id_event)
);

-- R15
CREATE TABLE event_tag (
    id_event INTEGER REFERENCES "event"(id) ON DELETE CASCADE,
    tag_name TEXT NOT NULL,
    PRIMARY KEY (id_event, tag_name)
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
DECLARE
    var_id_poll INTEGER;
BEGIN
    SELECT id_poll FROM poll_option INTO var_id_poll WHERE poll_option.id = NEW.id_poll_option;
    IF NOT EXISTS (SELECT * FROM participation WHERE participation.id_user = NEW.id_user AND "status" = 'Accepted' AND participation.id_event = (SELECT id_event FROM poll WHERE poll.id = var_id_poll)) THEN
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
DECLARE
    var_id_poll INTEGER;
BEGIN
    SELECT id_poll FROM poll_option INTO var_id_poll WHERE poll_option.id = NEW.id_poll_option;
    IF var_id_poll IN (SELECT id_poll 
            FROM poll_answer JOIN poll_option ON poll_option.id = poll_answer.id_poll_option
            WHERE poll_answer.id_user = NEW.id_user) THEN
        RAISE EXCEPTION 'A user cannot vote twice on the same poll.';
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

-- TRIGGER07
CREATE FUNCTION account_deletion() RETURNS TRIGGER AS
$BODY$
BEGIN
    -- Set the text of any comments the user has made to NULL
    UPDATE "comment" SET "text" = NULL WHERE id_author = OLD.id;
    RETURN OLD;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER account_deletion
    BEFORE DELETE ON "user"
    FOR EACH ROW
    EXECUTE PROCEDURE account_deletion();

-- TRIGGER08
CREATE FUNCTION update_event_keywords() RETURNS TRIGGER AS
$BODY$
BEGIN
    UPDATE "event"
        SET keywords = setweight(to_tsvector('english', NEW.title), 'A') || setweight(to_tsvector('english', NEW."description"), 'B')
        WHERE "event".id = NEW.id;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER update_event_keywords
    AFTER INSERT OR UPDATE OF title, "description" ON "event"
    FOR EACH ROW
    EXECUTE PROCEDURE update_event_keywords();

-- Indices

CREATE INDEX event_id_organizer_idx ON "event" USING hash(id_organizer);
CREATE INDEX poll_id_event_idx ON poll USING hash(id_event);
CREATE INDEX file_id_event_idx ON "file" USING hash(id_event);
CREATE INDEX competitor_id_event_idx ON competitor USING hash(id_event);
CREATE INDEX match_id_event_idx ON "match" USING hash(id_event);
CREATE INDEX poll_option_id_poll_idx ON poll_option USING hash(id_poll);
CREATE INDEX poll_answer_id_poll_option_idx ON poll_answer USING hash(id_poll_option);
CREATE INDEX event_tag_tag_name_idx ON event_tag USING hash(tag_name);
CREATE INDEX participation_status_id_event_idx ON participation USING btree("status", id_event);
CREATE INDEX event_type_idx ON "event" USING hash("type");
CREATE INDEX event_start_date_idx ON "event" USING btree("start_date");
CREATE INDEX event_end_date_idx ON "event" USING btree(end_date);
CREATE INDEX event_id_category_idx ON "event" USING hash(id_category);

-- Full-text search indices

CREATE INDEX search_idx ON "event" USING GIST (keywords);


-- POPULATION

-- R02

-- R05
INSERT INTO "category" (id,"name") VALUES (1,'Board Games');
INSERT INTO "category" (id,"name") VALUES (2,'Video Games');
INSERT INTO "category" (id,"name") VALUES (3,'Card Games');
INSERT INTO "category" (id,"name") VALUES (4,'Role-Playing Games');
