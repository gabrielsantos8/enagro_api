SELECT 
	 hpci.contract_id 
   ,hpci.installment_number as "Número Parcela"
   ,hpcis.description as "Situação"
   ,DATE_FORMAT(hpci.due_date, '%d/%m/%Y') as "Data de Vencimento"
   ,hpci.value as "Valor"
   ,hp.description as "Plano"
   ,hpct.description as "Tipo" 
   ,DATE_FORMAT(hpci.created_at, '%d/%m/%Y %H:%i:%s') as "Data de Criação"
FROM health_plan_contract_installments hpci
LEFT JOIN health_plan_contracts hpc on hpc.id = hpci.contract_id
LEFT JOIN health_plan_contracts_installments_status hpcis on hpcis.id = hpc.health_plan_contract_status_id
LEFT JOIN health_plan_contract_types hpct on hpct.id = hpc.health_plan_contract_type_id
LEFT JOIN health_plans hp on hp.id = hpc.health_plan_id
LEFT JOIN users u on u.id = hpc.user_id
WHERE hpc.user_id = :user_id
  AND hpci.status_id = :status_id
  AND CAST(hpci.created_at as date) between ':dini' and ':dfim'