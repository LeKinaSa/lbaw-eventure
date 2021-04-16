
-- INSERT01 - Create an event

INSERT INTO "event" (id, id_organizer, title, visibility, "description", keywords, picture, "start_date", end_date, "type", "location", max_attendance, cancelled, id_category, win_points, draw_points, loss_points, leaderboard)
    VALUES ($id, $id_organizer, $title, $visibility, $event_description, $keywords, $picture, $starting_date, $end_date, $event_type, $event_location, $max_attendance, $cancelled, $id_category, $win_points, $draw_points, $loss_points, $leaderboard);

-- INSERT02 - Comment on an event

INSERT INTO comment (id, id_author, id_event, id_parent, "text", "date")
    VALUES ($id, $id_author, $id_event, $id_parent, $comment_text, $comment_date);

-- INSERT03 - Answer a poll

INSERT INTO poll_answer (id_user, id_poll, id_poll_option)
    VALUES ($id_user, $id_poll, $id_poll_option);

-- INSERT04 - Create polls

INSERT INTO poll (id, id_event, question)
    VALUES ($id, $id_event, $question);

-- INSERT05 - Upload files

INSERT INTO "file" (id, id_event, "name", "data", date_uploaded)
    VALUES ($id, $id_event, $file_name, $file_data, $date_uploaded);

-- INSERT06 - Suspend users

INSERT INTO suspension (id, id_user, "from", until, reason)
    VALUES ($id, $id_user, $from_date, $until, $reason);

-- INSERT07 - Ban users

INSERT INTO banned_user (id_user, since, reason)
    VALUES ($id_user, $since, $reason);

-- INSERT08 - Send invitations ??

-- UPDATE01 - Update personal information

-- UPDATE02 - Manage invitations

-- UPDATE03 - Manage event details

-- UPDATE04 - Post results

-- DELETE01 - Delete account

DELETE FROM "user"
    WHERE id = $id;