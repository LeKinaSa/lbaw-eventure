
-- INSERT01 - Create an event

INSERT INTO "event" (id, id_organizer, title, visibility, "description", keywords, picture, "start_date", end_date, "type", "location", max_attendance, cancelled, id_category, win_points, draw_points, loss_points, leaderboard)
    VALUES ($id, $id_organizer, $title, $visibility, $event_description, $keywords, $picture, $starting_date, $end_date, $event_type, $event_location, $max_attendance, $cancelled, $id_category, $win_points, $draw_points, $loss_points, $leaderboard);

-- INSERT02 - Comment on an event

INSERT INTO comment (id, id_author, id_event, id_parent, "text", "date")
    VALUES ($id, $id_author, $id_event, $id_parent, $comment_text, $comment_date);

-- INSERT03 - Answer a poll

INSERT INTO poll_answer (id_user, id_poll, id_poll_option)
    VALUES ($id_user, $id_poll, $id_poll_option)

-- INSERT04 - Send invitations

-- INSERT05 - Post results

-- INSERT06 - Create polls

-- INSERT07 - Upload files

-- INSERT08 - Suspend users

-- INSERT09 - Ban users

-- UPDATE01 - Update personal information

-- UPDATE02 - Manage invitations

-- UPDATE03 - Manage event details

-- DELETE01 - Delete account