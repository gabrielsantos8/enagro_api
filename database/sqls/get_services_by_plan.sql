SELECT
	 hps.id
    ,s.id as service_id
    ,s.description as service
    ,s.value as service_value
    ,asm.description as animal_subtype
    ,hp.id as plan_id
    ,hp.description as plan
    ,hps.created_at
    ,hps.updated_at
FROM health_plan_services hps
LEFT JOIN health_plans hp on hp.id = hps.health_plan_id
LEFT JOIN services s on s.id = hps.service_id
LEFT JOIN animal_subtypes asm on asm.id = s.animal_subtype_id
WHERE hps.health_plan_id = :plan_id