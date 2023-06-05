-- Active: 1685931372338@@127.0.0.1@3306@hris_kpt

DROP VIEW IF EXISTS `VW_ATTENDANCE`;

CREATE VIEW VW_ATTENDANCE AS 
	SELECT
	    DATE_FORMAT(af.scan_date, "%Y-%m-%d") AS "date", (
	        CASE
	            WHEN (
	                DATE_FORMAT(af.scan_date, "%H:%i") >= DATE_FORMAT(wh.start_time, "%H:%i") && DATE_FORMAT(af.scan_date, "%H:%i") <= DATE_FORMAT(wh.start_rest, "%H:%i")
	            ) THEN DATE_FORMAT(af.scan_date, "%H:%i")
	            ELSE NULL
	        END
	    ) AS hour_start, (
	        CASE
	            WHEN (
	                DATE_FORMAT(af.scan_date, "%H:%i") >= DATE_FORMAT(wh.fastest_time, "%H:%i") && DATE_FORMAT(af.scan_date, "%H:%i") <= DATE_FORMAT(wh.after_work_end, "%H:%i")
	            ) THEN DATE_FORMAT(af.scan_date, "%H:%i")
	            ELSE NULL
	        END
	    ) AS hour_end, (
	        CASE
	            WHEN (
	                DATE_FORMAT(af.scan_date, "%H:%i") >= DATE_FORMAT(wh.start_rest, "%H:%i") && DATE_FORMAT(af.scan_date, "%H:%i") <= DATE_FORMAT(wh.end_rest, "%H:%i")
	            ) THEN DATE_FORMAT(af.scan_date, "%H:%i")
	            ELSE NULL
	        END
	    ) AS hour_rest_start, (
	        CASE
	            WHEN (
	                DATE_FORMAT(af.scan_date, "%H:%i") >= DATE_FORMAT(wh.start_rest, "%H:%i") && DATE_FORMAT(af.scan_date, "%H:%i") <= DATE_FORMAT(wh.end_rest, "%H:%i")
	            ) THEN DATE_FORMAT(af.scan_date, "%H:%i")
	            ELSE NULL
	        END
	    ) AS hour_rest_end,
	    DATE_FORMAT(jt.datetime_start, "%H:%i") AS hour_overtime_job_order_start,
	    DATE_FORMAT(jt.datetime_end, "%H:%i") AS hour_overtime_job_order_end,
	    DATE_FORMAT(jt.datetime_start, "%Y-%m-%d") AS jt_date_overtime_start,
	    DATE_FORMAT(jt.datetime_end, "%Y-%m-%d") AS jt_date_overtime_end,
	    af.pin,
	    fi.id_finger,
	    em.name as employee_name,
	    fi.employee_id
	FROM
	    attendance_fingerspots af
	    LEFT JOIN fingers fi ON af.pin = fi.id_finger
	    LEFT JOIN employees em ON fi.employee_id = em.id
	    LEFT JOIN job_status_has_parents jt ON fi.employee_id = jt.employee_id
	    AND DATE_FORMAT(jt.datetime_start, "%Y-%m-%d") = DATE_FORMAT(af.scan_date, "%Y-%m-%d")
	    LEFT JOIN (
	        SELECT *
	        FROM working_hours
	        LIMIT 1
	    ) as wh ON 1 = 1
	WHERE
	    fi.employee_id IS NOT NULL
	GROUP BY
	    af.pin,
	    fi.id_finger,
	    hour_start,
	    hour_end,
	    hour_rest_start,
	    hour_overtime_job_order_start,
	    hour_overtime_job_order_end,
	    jt_date_overtime_start,
	    jt_date_overtime_end,
	    date,
	    fi.employee_id
	ORDER BY date
DESC; 