SELECT
	 s.*,
	 vs.id as vetservice_id,
	 asb.description as animal_subtype,
     atp.description as animal_type
FROM veterinarian_services vs
LEFT JOIN services s on s.id = vs.service_id
LEFT JOIN animal_subtypes asb ON asb.id = s.animal_subtype_id
LEFT JOIN animal_types atp ON atp.id = asb.animal_type_id
WHERE vs.veterinarian_id = ?