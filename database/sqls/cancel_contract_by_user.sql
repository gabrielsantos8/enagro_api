UPDATE health_plan_contracts SET health_plan_contract_status_id = 2
WHERE user_id = :user_id
	AND health_plan_contract_status_id = 1