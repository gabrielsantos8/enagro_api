WITH user_animal_types as (

    SELECT
    	a.animal_subtype_id
   	FROM user_addresses ad
    LEFT JOIN animals a ON a.user_address_id = ad.id
    WHERE ad.user_id = ?
    GROUP BY 1
)

SELECT
	*
FROM health_plans hp
WHERE NOT EXISTS (
    SELECT
        1
    FROM health_plan_contracts hpc
    WHERE hpc.health_plan_id = hp.id
      AND hpc.user_id = ?    
      AND hpc.health_plan_contract_status_id = 1
)