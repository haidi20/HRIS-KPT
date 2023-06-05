-- Active: 1685931372338@@127.0.0.1@3306@hris_kpt

DROP VIEW IF EXISTS `vw_attendance`;

CREATE VIEW VW_ATTENDANCE AS 
	SELECT
	    af.pin,
	    -- DATE_FORMAT(
	    --     min(DISTINCT(af.scan_date)),
	    --     "%H:%i"
	    -- ) as min_hour,
	    -- (
	    --     CASE
	    --         WHEN (
	    --             DATE_FORMAT(
	    --                 DISTINCT(af.scan_date),
	    --                 "%H:%i"
	    --             )
	    --         )
	    --     END
	    -- ) AS start_time,
	    DATE_FORMAT(
	        max(DISTINCT(af.scan_date)),
	        "%H:%i"
	    ) as max_hour,
	    DATE_FORMAT(af.scan_date, "%Y-%m-%d") AS "date",
	    fi.id_finger,
	    em.name as employee_name,
	    fi.employee_id
	FROM
	    attendance_fingerspots af
	    LEFT JOIN fingers fi ON af.pin = fi.id_finger
	    LEFT JOIN employees em ON fi.employee_id = em.id
	    INNER JOIN working_hours ON
	WHERE
	    fi.employee_id IS NOT NULL
	GROUP BY
	    af.pin,
	    fi.id_finger,
	    date,
	    fi.employee_id
	ORDER BY date
DESC; 