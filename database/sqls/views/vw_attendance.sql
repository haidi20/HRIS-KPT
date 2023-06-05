-- Active: 1685931372338@@127.0.0.1@3306@hris_kpt

DROP VIEW IF EXISTS `VW_ATTENDANCE`;

CREATE VIEW VW_ATTENDANCE AS 
	SELECT
	    DATE_FORMAT(af.scan_date, "%Y-%m-%d") AS "date",
	    af.pin,
	    -- af_hour_start.hour_start,
	    -- af_hour_end.hour_end,
	    af_hour_start.datetime_start,
	    af_hour_end.datetime_end,
	    TIMESTAMPDIFF(
	        MINUTE,
	        af_hour_start.datetime_start,
	        af_hour_end.datetime_end
	    ) as duration_work,
	    af_hour_rest.hour_rest_start,
	    af_hour_rest.hour_rest_end,
	    -- af_hour_rest.date as date_rest,
	    TIMESTAMPDIFF(
	        MINUTE,
	        af_hour_rest.datetime_start,
	        af_hour_rest.datetime_end
	    ) as duration_rest,
	    em.name
	FROM
	    attendance_fingerspots af
	    LEFT JOIN fingers fi ON af.pin = fi.id_finger
	    LEFT JOIN employees em ON fi.employee_id = em.id
	    LEFT JOIN (
	        SELECT
	            af.pin,
	            DATE_FORMAT(af.scan_date, "%Y-%m-%d") AS "date",
	            DATE_FORMAT(min(af.scan_date), "%H:%i") as hour_rest_start,
	            min(af.scan_date) as datetime_start, (
	                CASE
	                    WHEN max(af.scan_date) = min(af.scan_date) THEN NULL
	                    ELSE DATE_FORMAT(max(af.scan_date), "%H:%i")
	                END
	            ) as hour_rest_end, (
	                CASE
	                    WHEN max(af.scan_date) = min(af.scan_date) THEN NULL
	                    ELSE max(af.scan_date)
	                END
	            ) as datetime_end
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
	    LEFT JOIN (
	        SELECT
	            af.pin,
	            DATE_FORMAT(af.scan_date, "%Y-%m-%d") AS "date",
	            DATE_FORMAT(min(af.scan_date), "%H:%i") AS hour_start,
	            min(af.scan_date) AS datetime_start
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
	            DATE_FORMAT(af.scan_date, "%H:%i") >= DATE_FORMAT(wh.start_time, "%H:%i")
	            AND DATE_FORMAT(af.scan_date, "%H:%i") <= DATE_FORMAT(wh.start_rest, "%H:%i")
	        GROUP BY
	            af.pin,
	            date
	    ) AS af_hour_start ON af.pin = af_hour_start.pin
	    AND DATE_FORMAT(af.scan_date, "%Y-%m-%d") = af_hour_start.date
	    LEFT JOIN (
	        SELECT
	            af.pin,
	            DATE_FORMAT(af.scan_date, "%Y-%m-%d") AS "date",
	            DATE_FORMAT(max(af.scan_date), "%H:%i") AS hour_end,
	            max(af.scan_date) AS datetime_end
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
	            DATE_FORMAT(af.scan_date, "%H:%i") >= DATE_FORMAT(wh.end_rest, "%H:%i")
	            AND DATE_FORMAT(af.scan_date, "%H:%i") <= DATE_FORMAT(wh.after_work_limit, "%H:%i")
	        GROUP BY
	            af.pin,
	            date
	    ) AS af_hour_end ON af.pin = af_hour_end.pin
	    AND DATE_FORMAT(af.scan_date, "%Y-%m-%d") = af_hour_end.date
	GROUP BY
	    DATE_FORMAT(af.scan_date, "%Y-%m-%d"),
	    af.pin,
	    af_hour_rest.hour_rest_start,
	    af_hour_rest.hour_rest_end,
	    -- date_rest,
	    duration_rest,
	    -- af_hour_start.hour_start,
	    -- af_hour_end.hour_end,
	    af_hour_start.datetime_start,
	    af_hour_end.datetime_end,
	    duration_work,
	    em.name
