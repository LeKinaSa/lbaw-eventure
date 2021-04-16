
----------------------------
--         INSERTS        --
----------------------------

-- INSERT01 - Create an event
INSERT INTO "event" (id_organizer, title, visibility, "description", picture, "start_date", end_date, "type", "location", max_attendance, id_category)
    VALUES ($idOrganizer, $title, $visibility, $description, $picture, $startDate, $endDate, $type, $location, $maxAttendance, $idCategory);

-- INSERT02 - Comment on an event
INSERT INTO comment (id_author, id_event, id_parent, "text", "date")
    VALUES ($idAuthor, $idEvent, $idParent, $text, $date);

-- INSERT03 - Answer a poll
INSERT INTO poll_answer (id_user, id_poll_option)
    VALUES ($idUser, $idPollOption);

-- INSERT04 - Create polls
INSERT INTO poll (id_event, question)
    VALUES ($idEvent, $question);
    
-- INSERT05 - Add poll option
INSERT INTO poll_option (id_poll, "option")
    VALUES ($idPoll, $option);

-- INSERT06 - Upload files
INSERT INTO "file" (id_event, "name", "data", date_uploaded)
    VALUES ($idEvent, $name, $data, $dateUploaded);

-- INSERT07 - Suspend users
INSERT INTO suspension (id_user, "from", until, reason)
    VALUES ($idUser, $from, $until, $reason);

-- INSERT08 - Ban users
INSERT INTO banned_user (id_user, since, reason)
    VALUES ($idUser, $since, $reason);

-- INSERT09 - Send invitations
INSERT INTO participation (id_user, id_event, "status")
    VALUES ($idUser, $idEvent, 'Invitation');

-- INSERT10 - Post results
INSERT INTO "match" (id_event, "date", "description", result, id_competitor1, id_competitor2)
    VALUES (id_event, $date, $description, $result, $id_competitor1, $id_competitor2);

-- INSERT11 - Sign up
INSERT INTO "user" (username, "name", email, "password")
    VALUES ($username, $name, $email, $password);

-- INSERT12 - Add competitor
INSERT INTO competitor (id_event, "name")
    VALUES ($idEvent, $name);

-- INSERT13 - Add tag to event
INSERT INTO event_tag (id_event, tag_name)
    VALUES ($idEvent, $tagName);

----------------------------
--         UPDATES        --
----------------------------

-- UPDATE01 - Update personal information
UPDATE "user"
    SET username = $username, "name" = $name, email = $email,
        "address" = $address, gender = $gender, age = $age, website = $website,
        picture = $picture, "description" = $description
    WHERE id = $id;

-- UPDATE02 - Manage invitations
UPDATE participation
    SET "status" = $status
    WHERE id_event = $idEvent;

-- UPDATE03 - Manage event details
UPDATE "event"
    SET title = $title, visibility = $visibility, "description" = $description,
        picture = $picture, "start_date" = $startDate, end_date = $endDate,
        "type" = $type, "location" = $location, max_attendance = $maxAttendance,
        id_category = $idCategory
    WHERE id = $id;

-- UPDATE04 - Update results
UPDATE "match"
    SET result = $result
    WHERE id = $id;

-- UPDATE05 - Delete account
UPDATE "user"
    SET active = false
    WHERE id = $id;

-- UPDATE06 - Manage event leaderboard details
UPDATE "event"
    SET win_points = $winPoints, drawPoints = $drawPoints, lossPoints = $lossPoints,
        leaderboard = $leaderboard
    WHERE id = $id;

-- UPDATE07 - Delete comment (the child comments are preserved)
UPDATE comment
    SET id_author = NULL, "text" = NULL
    WHERE id = $id;
    
----------------------------
--         DELETES        --
----------------------------

-- DELETE01 - Delete event
DELETE FROM "event"
    WHERE id = $id;

-- DELETE02 - Delete poll
DELETE FROM "poll"
    WHERE id = $id;

-- DELETE03 - Delete file
DELETE FROM "file"
    WHERE id = $id;

-- DELETE04 - Remove poll answer
DELETE FROM poll_answer
    WHERE id_user = $idUser AND id_poll_option = $idPollOption;

-- DELETE05 - Remove tag from event
DELETE FROM event_tag
    WHERE id_event = $idEvent AND tag_name = $tagName;
