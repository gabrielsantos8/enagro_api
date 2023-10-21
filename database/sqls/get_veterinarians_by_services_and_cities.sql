SELECT
	tb.*
FROM (


SELECT
	 v.*
    ,u.image_url
    ,count(distinct vs.service_id) as service_count
    ,count(distinct sc.city_id)  as city_count
FROM veterinarians v
LEFT JOIN veterinarian_services vs on vs.veterinarian_id = v.id
LEFT JOIN service_cities sc on sc.veterinarian_id = v.id
LEFT JOIN users u on u.id = v.user_id
LEFT JOIN situations s on s.id = v.situation_id
WHERE vs.service_id in (?)
  AND sc.city_id in (
                        SELECT
                             ad.city_id 
                        FROM animals a
                        LEFT JOIN user_addresses ad on ad.id = a.user_address_id
                         WHERE a.id in (28))
  AND NOT v.user_id in (
    SELECT
        ad.user_id
    FROM animals a
    LEFT JOIN user_addresses ad on ad.id = a.user_address_id
        WHERE a.id in (28)
  )
  GROUP BY 1,2,3,4,5,6,7,8,9,10,11,12
    
) tb
WHERE tb.service_count = 2
  and tb.city_count  = 1