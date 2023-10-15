WITH plan_subtypes as (

    SELECT
    	s.animal_subtype_id
    FROM health_plans hp
    LEFT JOIN health_plan_services hps on hps.health_plan_id = hp.id
    LEFT JOIN services s on s.id = hps.id
    WHERE hp.id = ?
    GROUP BY 1
      
)


SELECT
     a.*
    ,atp.description as animal_type
    ,ad.complement
    ,c.id as city_id
    ,c.description as city
    ,c.uf
    ,c.ibge
    ,atsp.description as animal_subtype
FROM animals a
LEFT JOIN animal_types atp on atp.id = a.animal_type_id
LEFT JOIN animal_subtypes atsp on atsp.id = a.animal_subtype_id
LEFT JOIN user_addresses ad on ad.id = a.user_address_id
LEFT JOIN cities c on c.id = ad.city_id
WHERE ad.user_id = ?
  AND a.animal_subtype_id in (SELECT ps.animal_subtype_id FROM plan_subtypes ps)