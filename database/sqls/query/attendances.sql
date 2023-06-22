-- hapus data

DELETE a1
FROM
    attendance_has_employees a1
    JOIN (
        SELECT
            hour_start,
            MIN(id) AS min_id
        FROM
            attendance_has_employees
        GROUP BY hour_start
        HAVING
            COUNT(hour_start) > 1
    ) a2 ON a1.hour_start = a2.hour_start
    AND a1.id > a2.min_id;

-- lihat data

SELECT
    hour_start,
    COUNT(hour_start)
FROM attendance_has_employees
GROUP BY hour_start
HAVING COUNT(hour_start) > 1;