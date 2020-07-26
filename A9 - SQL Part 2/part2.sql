#Assignment 9, Part 2
#Question 1: Make a View
SELECT * FROM football_schedule;

# Question 2: Add two games
INSERT INTO venues (id, venue) VALUES (10, 'Folsom Field');

INSERT INTO schedule SELECT MAX(id + 1), '2017-11-18', 7, 10, 4, 10 FROM schedule;

INSERT INTO schedule SELECT MAX(id + 1), '2017-11-18', 7, 8, 6, 9 FROM schedule;

#Question 3: Change a game's details
UPDATE schedule
SET date = '2017-11-06', away_team_id = 1
WHERE home_team_id = 3 AND date = '2017-11-04';

#Question 4: Delete a game 
DELETE FROM schedule
WHERE date = '2017-11-18' AND home_team_id = 9;

#Question 5: Display Venues and # of games played
SELECT s.venue_id AS venue_id, v.venue AS venue, COUNT(s.venue_id) AS game_count 
FROM schedule s
JOIN venues v
	ON s.venue_id = v.id
GROUP BY s.venue_id, v.venue;