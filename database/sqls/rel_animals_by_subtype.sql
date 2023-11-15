SELECT
	 a.name
    ,u.name as u_owner
    ,a.description
    ,atp.description as a_type
    ,astp.description as a_subtype
    ,CONCAT(c.uf, ' - ', c.description) as city
    ,a.birth_date
    ,a.weight
    ,a.amount
    ,DATE_FORMAT(a.created_at, '%d/%m/%Y %H:%i:%s') as created_at
FROM animals a
LEFT JOIN animal_types atp on atp.id = a.animal_type_id
LEFT JOIN animal_subtypes astp on astp.id = a.animal_subtype_id
LEFT JOIN user_addresses ad on ad.id = a.user_address_id
LEFT JOIN cities c on c.id = ad.city_id
LEFT JOIN users u on u.id = ad.user_id
WHERE a.animal_subtype_id = :subtype_id
  and CAST(a.created_at as DATE) BETWEEN ':dini' and ':dfim'