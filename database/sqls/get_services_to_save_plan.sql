SELECT
    s.*
FROM services s
WHERE NOT s.id in (select hps.service_id from health_plan_services hps where hps.health_plan_id = :plan_id )
