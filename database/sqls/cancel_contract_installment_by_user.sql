 UPDATE health_plan_contract_installments SET status_id = 3
 WHERE contract_id in (SELECT 
    		hpc.id
   		FROM health_plan_contracts hpc
    	WHERE hpc.user_id = :user_id
    	  AND hpc.health_plan_contract_status_id = 1)
	AND status_id = 2
	AND current_date < due_date