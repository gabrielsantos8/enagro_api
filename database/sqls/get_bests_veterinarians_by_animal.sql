SELECT
	 v.id
    ,v.nome
    ,c.description as city
FROM veterinarians v
LEFT JOIN service_cities sc ON sc.veterinarian_id = v.id
LEFT JOIN cities c ON c.id = sc.city_id
LEFT JOIN veterinarian_services vs ON vs.veterinarian_id = v.id
WHERE sc.city_id IN (
    SELECT
    	c.id
    FROM cities c
    INNER JOIN user_addresses ad ON ad.city_id = c.id
    INNER JOIN animals a ON a.user_address_id = ad.id
    WHERE a.id IN (:animals_id)
   	GROUP BY 1
)
  AND vs.service_id IN (:services_id)
GROUP BY 1,2,3