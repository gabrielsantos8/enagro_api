SELECT DISTINCT
	 hp.description as "Plano"
    ,hp.value as "Valor"
    ,CONCAT(hp.minimal_animals,' - ', hp.maximum_animals) as "Média de Animais"
    ,hpcs.description as "Situação"
    ,u.name as "Cliente"
    ,c.description as "Cidade"
    ,c.uf as "UF"
    ,DATE_FORMAT(hpc.created_at, '%d/%m/%Y %H:%i:%s') as "Data da Assinatura"
FROM health_plan_contract_animals hpca
LEFT JOIN health_plan_contracts hpc on hpc.id = hpca.contract_id
LEFT JOIN health_plan_contract_status hpcs on hpcs.id = hpc.health_plan_contract_status_id
LEFT JOIN health_plans hp on hp.id = hpc.health_plan_id
LEFT JOIN animals a on a.id = hpca.animal_id
LEFT JOIN user_addresses ad on ad.id = a.user_address_id
LEFT JOIN users u on u.id = ad.user_id
LEFT JOIN cities c on c.id = ad.city_id
WHERE CAST(hpc.created_at as date) between ':dini' and ':dfim'
 AND hpc.health_plan_contract_status_id = :status_id
 AND c.uf = ':UF'