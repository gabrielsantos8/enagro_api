WITH user_animal_types as (

    SELECT
    	a.animal_subtype_id
       ,SUM(a.amount) as amount 
   	FROM user_addresses ad
    LEFT JOIN animals a ON a.user_address_id = ad.id
    WHERE ad.user_id = ?
    GROUP BY 1
)

SELECT
	hp.*
FROM health_plans hp
WHERE NOT EXISTS (
    SELECT
        1
    FROM health_plan_contracts hpc
    WHERE hpc.health_plan_id = hp.id
      AND hpc.user_id = ?    
)
AND EXISTS (

    SELECT 
    	1
    FROM health_plan_services hps
    INNER JOIN services s ON s.id = hps.service_id
    WHERE hps.health_plan_id = hp.id
      AND s.animal_subtype_id in (SELECT uat.animal_subtype_id FROM user_animal_types uat)     
      AND (SELECT uat.amount FROM user_animal_types uat WHERE uat.animal_subtype_id = s.animal_subtype_id) BETWEEN hp.minimal_animals AND hp.maximum_animals
)