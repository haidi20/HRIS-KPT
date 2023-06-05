-- Active: 1685931372338@@127.0.0.1@3306@hris_kpt

DROP VIEW IF EXISTS `VW_ATTENDANCE`;

CREATE VIEW VW_ATTENDANCE AS 
	SELECT
	    DATE_FORMAT(af.scan_date, "%Y-%m-%d") AS "date",
	    af.pin,
	    af_hour_rest.hour_rest_start,
	    af_hour_rest.hour_rest_end,
	    af_hour_rest.date as af_hour_rest_date
	FROM
	    attendance_fingerspots af
	    LEFT JOIN (
	        SELECT
	            af.pin,
	            DATE_FORMAT(af.scan_date, "%Y-%m-%d") AS "date",
	            DATE_FORMAT(min(af.scan_date), "%H:%i") as hour_rest_start, (
	                CASE
	                    WHEN max(af.scan_date) = min(af.scan_date) THEN NULL
	                    ELSE DATE_FORMAT(max(af.scan_date), "%H:%i")
	                END
	            ) as hour_rest_end
	        FROM
	            attendance_fingerspots af
	            LEFT JOIN (
	                SELECT *
	                FROM
	                    working_hours
	                LIMIT
	                    1
	            ) as wh ON 1 = 1
	        WHERE
	            DATE_FORMAT(af.scan_date, "%H:%i") >= DATE_FORMAT(wh.start_rest, "%H:%i")
	            AND DATE_FORMAT(af.scan_date, "%H:%i") <= DATE_FORMAT(wh.end_rest, "%H:%i")
	        GROUP BY
	            af.pin,
	            date
	    ) AS af_hour_rest ON af.pin = af_hour_rest.pin
	    AND DATE_FORMAT(af.scan_date, "%Y-%m-%d") = af_hour_rest.date
	GROUP BY
	    DATE_FORMAT(af.scan_date, "%Y-%m-%d"),
	    af.pin,
	    af_hour_rest.hour_rest_start,
	    af_hour_rest.hour_rest_end,
	    af_hour_rest_date
