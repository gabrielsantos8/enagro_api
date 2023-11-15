SELECT 
	1
FROM health_plan_contracts hpc
WHERE hpc.user_id = :user_id
  AND hpc.health_plan_contract_status_id = 1
LIMIT 1