#Assignment 9, Part 3
#Question 1: Create view 'dramas'
SELECT * FROM sagartiw_dvd_db.dramas;

#Question 2: Add 'The Godfather'
INSERT INTO dvd_titles (title, release_date, award, label_id, sound_id, genre_id, rating_id,format_id)
VALUES ('The Godfather', '1972-03-24', '45th Academy Award for Best Picture', 92, 4, 9, 7, 2);

#Question 3: Update 'Zero Effect'
UPDATE dvd_titles
SET label_id = 24, genre_id = 7, format_id = 4
WHERE title = 'Zero Effect';

#Question 4: Delete 'Major League 3:Back To The Minors'
DELETE FROM dvd_titles
WHERE title = 'Major League 3:Back To The Minors';

#NOTE; I typically use id's instead of strings for WHERE. 
#Made an exception for this assignment. Needed to turn off safe mode.

#Question 5: Display # of Chars for longest and shortest titles
SELECT MAX(CHAR_LENGTH(title)) AS longest_title, MIN(CHAR_LENGTH(title)) AS shortest_title
FROM dvd_titles;

#Question 6: Display all genres and # of DVDs per genre
SELECT d.genre_id AS genre_id, g.genre AS genre, COUNT(d.genre_id) AS dvd_count
FROM dvd_titles d
JOIN genres g
	ON d.genre_id = g.genre_id
GROUP BY d.genre_id, g.genre;