<?php

namespace App\Utils;

class SqlGetter
{
    public static function getSql(string $sql_name, array $params = [])
    {
        $sql_path =  __DIR__.'/../../database/sqls/';
        $sql = file_get_contents($sql_path . $sql_name . '.sql');
        if(!empty($params)) {
            $sql = self::switchParams($params, $sql);
        }
        return $sql;
    }

    public static function switchParams( $params, $sql ){
		foreach($params as $nome => $valor){
			$valor = trim(str_replace('\"', "'", $valor));
			$sql = preg_replace( '/:'.$nome.'\b/i', $valor, $sql);
		};
		return $sql;
	}

}
