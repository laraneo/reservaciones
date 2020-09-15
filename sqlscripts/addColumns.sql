--ALTER TABLE events 
--ADD COLUMN drawtime1 DATETIME NULL,
-- ADD COLUMN drawtime2 DATETIME NULL;

-- ALTER TABLE session_slots 
-- ADD COLUMN booking_type INT NULL;

-- ALTER TABLE draw_requests
-- ADD COLUMN locator VARCHAR(255) NULL;

ALTER TABLE session_slots ADD package_id INT NULL;
ALTER TABLE session_slots ADD booking_time2 varchar(255) NULL;
ALTER TABLE session_slots ADD court_id INT NULL;

ALTER TABLE session_players ADD package_id INT NULL;
ALTER TABLE session_players ADD court_id INT NULL;

ALTER TABLE session_addons ADD cant INT NULL;
ALTER TABLE session_addons ADD doc_id  VARCHAR(255) NULL;
ALTER TABLE session_addons ADD package_id INT NULL;

ALTER TABLE bookings ADD booking_time2 varchar(255) NULL;
ALTER TABLE bookings ADD court_id INT NULL;

ALTER TABLE addon_booking ADD booking_players_id INT NULL;
ALTER TABLE addon_booking ADD cant INT NULL;
ALTER TABLE addon_booking ALTER COLUMN addon_id INT NULL;
ALTER TABLE addon_booking ALTER COLUMN booking_id INT NULL;

ALTER TABLE draw_requests ADD draw_time2 datetime NULL;

ALTER TABLE draw_addon ADD draw_players_id INT NULL;
ALTER TABLE draw_addon ADD cant INT NULL;
ALTER TABLE draw_addon ALTER COLUMN addon_id INT NULL;
ALTER TABLE draw_addon ALTER COLUMN draw_request_id INT NULL;
ALTER TABLE draw_addon ALTER COLUMN draw_players_id INT NULL;
ALTER TABLE draw_addon ALTER COLUMN booking_players_id INT NULL;
ALTER TABLE draw_addon ALTER COLUMN cant INT NULL;

ALTER TABLE categories ADD category_type INT NULL;

