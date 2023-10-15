SELECT
	s.*,
    asb.description as animal_subtype,
    atp.description as animal_type
FROM services s
LEFT JOIN animal_subtypes asb ON asb.id = s.animal_subtype_id
LEFT JOIN animal_types atp ON atp.id = asb.animal_type_id
WHERE NOT s.id IN (
    SELECT
        vs.service_id
    FROM veterinarian_services vs
    WHERE vs.veterinarian_id = ?
)