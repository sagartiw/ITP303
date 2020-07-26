/*Sagar Tiwari
ITP 303, Spring 2020
Assignment 8
Description: SQL Query Statements, interacting with my ITP song and dvd db's.*/
/*SONG DB Question 1*/
SELECT 
    album_id, title, artist_id
FROM
    sagartiw_song_db.albums
WHERE
    title LIKE '%On%'
ORDER BY title;
/*SONG DB Question 2*/
SELECT 
    title, name
FROM
    sagartiw_song_db.albums
        JOIN
    sagartiw_song_db.artists ON sagartiw_song_db.albums.artist_id = sagartiw_song_db.artists.artist_id
WHERE
    title LIKE '%On%'
ORDER BY title;
/*SONG DB Question 3*/
SELECT
	sagartiw_song_db.tracks.name, composer, sagartiw_song_db.media_types.name, unit_price
FROM
	sagartiw_song_db.tracks
		JOIN
	sagartiw_song_db.media_types ON sagartiw_song_db.tracks.media_type_id = sagartiw_song_db.media_types.media_type_id
WHERE
	sagartiw_song_db.media_types.media_type_id = 5
ORDER BY 
	sagartiw_song_db.tracks.name;
/*SONG DB Question 4*/
SELECT track_id, t.name, composer, milliseconds, g.name
FROM
	sagartiw_song_db.tracks t
		JOIN
	sagartiw_song_db.genres g ON t.genre_id = g.genre_id
WHERE
	(t.genre_id = 2 or t.genre_id = 14) AND composer IS NOT NULL
ORDER BY
	t.name DESC;
/*DVD DB Question 1*/
SELECT d.title, d.award, g.genre, l.label, r.rating
FROM
	sagartiw_dvd_db.dvd_titles d
		JOIN
	sagartiw_dvd_db.genres g ON d.genre_id = g.genre_id
		JOIN
	sagartiw_dvd_db.labels l ON d.label_id = l.label_id
		JOIN
	sagartiw_dvd_db.ratings r ON d.rating_id = r.rating_id
WHERE
	d.genre_id = 9 AND d.award IS NOT NULL 
ORDER BY
	d.award;
/*DVD DB Question 2*/
SELECT d.title, s.sound, l.label, g.genre, r.rating
FROM
	sagartiw_dvd_db.dvd_titles d
		JOIN
	sagartiw_dvd_db.labels l ON d.label_id = l.label_id
		JOIN
	sagartiw_dvd_db.sounds s ON d.sound_id = s.sound_id
		JOIN
	sagartiw_dvd_db.genres g ON d.genre_id = g.genre_id
		JOIN
	sagartiw_dvd_db.ratings r ON d.rating_id = r.rating_id
WHERE
	d.label_id = 127 AND d.sound_id = 4
ORDER BY
	d.title;
/*DVD DB Question 3*/
SELECT d.title, d.release_date, r.rating, g.genre, s.sound, l.label
FROM
	sagartiw_dvd_db.dvd_titles d
		JOIN
	sagartiw_dvd_db.labels l ON d.label_id = l.label_id
		JOIN
	sagartiw_dvd_db.sounds s ON d.sound_id = s.sound_id
		JOIN
	sagartiw_dvd_db.genres g ON d.genre_id = g.genre_id
		JOIN
	sagartiw_dvd_db.ratings r ON d.rating_id = r.rating_id
WHERE
	d.rating_id = 7 AND d.genre_id = 19 AND d.release_date IS NOT NULL
ORDER BY
	d.release_date DESC;
