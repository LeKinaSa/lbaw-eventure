
-- SELECT01 - User profile details
SELECT id, username, "name", email, "address", gender, age, website, picture, "description", active
    FROM "user"
    WHERE "user".id = $idUser;

-- SELECT02 - Events the user is organizing
SELECT id, title, visibility, picture, "start_date", end_date, "type", "location", max_attendance, cancelled
    FROM "event"
    WHERE id_organizer = $idUser;

-- SELECT03 - Events the user is attending
SELECT id, title, visibility, picture, "start_date", end_date, "type", "location", max_attendance, cancelled
    FROM "event" JOIN participation ON "event".id = participation.id_event
    WHERE participation.id_user = $idUser AND participation."status" = 'Accepted';

-- SELECT04 - Event page
-- Event details
SELECT "user".username, "user"."name", id_organizer, title, visibility, "event"."description", "event".picture,
"start_date", end_date, "type", "location", max_attendance, cancelled, id_category, leaderboard, (SELECT count(*) AS attendance
        FROM participation
        WHERE id_event = $idEvent AND "status" = 'Accepted')
    FROM "event" JOIN "user" ON "user".id = "event".id_organizer
    WHERE "event".id = $idEvent;

-- Comments
SELECT comment.id, id_author, "user"."username", "user"."name", id_parent, "text", "date"
    FROM comment JOIN "user" ON "user".id = comment.id_author
    WHERE id_event = $idEvent
    ORDER BY "date";

-- Polls
SELECT id, question
    FROM poll
    WHERE id_event = $idEvent;

-- Files
SELECT id, "name", "data"
    FROM "file"
    WHERE id_event = $idEvent;

-- SELECT05 - Poll options (with answer count sorted in descending order)
SELECT poll_option.id, poll_option."option", count(poll_answer.id_user) AS answer_count
    FROM poll_option LEFT JOIN poll_answer ON poll_option.id = poll_answer.id_poll_option
    WHERE poll_option.id_poll = $idPoll
    GROUP BY poll_option.id
    ORDER BY answer_count DESC;

-- SELECT06 - Event competitors
SELECT id, "name"
    FROM competitor
    WHERE id_event = $idEvent;

-- SELECT07 - Match results
SELECT "match".id, "date", "description", result, id_competitor1, c1."name" AS name_competitor1, id_competitor2, c2."name" AS name_competitor2
    FROM "match" JOIN competitor AS c1 ON id_competitor1 = c1.id JOIN competitor AS c2 ON id_competitor2 = c2.id
    WHERE "match".id_event = $idEvent;

-- SELECT08 - Sign in
SELECT id, username, "password"
    FROM "user"
    WHERE username = $username;

-- SELECT09 - Sign in (administrator)
SELECT id, username, "password"
    FROM administrator
    WHERE username = $username;

-- SELECT10 - Event participants
SELECT id_user, "user".username, "user"."name"
    FROM participation JOIN "user" ON id_user = "user".id
    WHERE id_event = $idEvent AND "status" = 'Accepted';

-- SELECT11 - Invitations
SELECT id_user, "user".username, "user"."name"
    FROM participation JOIN "user" ON id_user = "user".id
    WHERE id_event = $idEvent AND "status" = 'Invitation';

-- SELECT12 - User management (banned users and suspensions)
SELECT username, "name", since, reason
    FROM banned_user JOIN "user"
    ON banned_user.id_user = "user".id;

SELECT suspension.id, username, "name", "from", until, reason
    FROM suspension JOIN "user"
    ON suspension.id_user = "user".id;

-- SELECT13 - Event full-text search (only public events or private events the user is organizing or participating in are shown)
-- Basic full-text search
SELECT "event".id, id_organizer, "user".username, "user"."name", title, 
"event"."description", "event".picture, "start_date", end_date, "type", "location", max_attendance,
ts_rank(keywords, search_query) AS "rank"
    FROM "event" JOIN "user" ON "user".id = id_organizer, to_tsquery('english', $search) AS search_query
    WHERE keywords @@ search_query
        AND (visibility = 'Public' OR $idUser = id_organizer OR $idUser IN 
            (SELECT id_user FROM participation WHERE id_event = "event".id AND ("status" = 'Accepted' OR "status" = 'Invitation')))
    ORDER BY "rank" DESC;

-- Using filters
SELECT "event".id, id_organizer, "user".username, "user"."name", title, 
"event"."description", "event".picture, "start_date", end_date, "type", "location", max_attendance,
ts_rank(keywords, search_query) AS "rank"
    FROM "event" JOIN "user" ON "user".id = id_organizer, to_tsquery('english', $search) AS search_query
    WHERE keywords @@ search_query
        AND (visibility = 'Public' OR $idUser = id_organizer OR $idUser IN 
            (SELECT id_user FROM participation WHERE id_event = "event".id AND ("status" = 'Accepted' OR "status" = 'Invitation')))
        AND "event"."type" = $type
        AND "event"."start_date" >= $startDate
        AND "event".end_date <= $endDate
        AND "event".id_category = $idCategory
    ORDER BY "rank" DESC;
