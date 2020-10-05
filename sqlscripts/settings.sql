-- ALTER TABLE settings ADD bookingUser_maxTimePerDay INT NULL;
-- ALTER TABLE settings ADD bookingUser_maxTimePerWeek INT NULL;
-- ALTER TABLE settings ADD bookingUser_maxTimePerMonth INT NULL;

-- ALTER TABLE settings ADD bookingGuest_maxTimePerDay INT NULL;
-- ALTER TABLE settings ADD bookingGuest_maxTimePerWeek INT NULL;
-- ALTER TABLE settings ADD bookingGuest_maxTimePerMonth INT NULL;

-- ALTER TABLE settings DROP COLUMN bookingUserPerWeek
-- ALTER TABLE settings DROP COLUMN bookingUserPerMonth
-- ALTER TABLE settings DROP COLUMN bookingGuestPerDay
-- ALTER TABLE settings DROP COLUMN bookingGuestPerWeek
-- ALTER TABLE settings DROP COLUMN bookingGuestPerMonth


-- ALTER TABLE settings ADD bookingUserPlayPerWeek INT NULL;
-- ALTER TABLE settings ADD bookingUserPlayPerMonth INT NULL;
-- ALTER TABLE settings ADD bookingGuestPlayPerDay INT NULL;
-- ALTER TABLE settings ADD bookingGuestPlayPerWeek INT NULL;
-- ALTER TABLE settings ADD bookingGuestPlayPerMonth INT NULL;

-- ALTER TABLE settings ADD bookingUser_MinGuests INT NULL;

ALTER TABLE settings ADD ClientAllowDeleteBookings INT NULL;

ALTER TABLE settings ADD AdminAllowDeleteBookings INT NULL;
ALTER TABLE settings ADD AdminAllowCancelBookings INT NULL;

ALTER TABLE settings ADD AllowNotificationChangeNewBookingPlayer INT NULL;
ALTER TABLE settings ADD AllowNotificationPreviousBookingPlayer INT NULL;