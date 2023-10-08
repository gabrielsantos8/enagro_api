<?php

namespace App\Utils;

class SqlGetter
{
    public static function getSql(string $sql_name)
    {
        $sql_path =  __DIR__.'/../../database/sqls/';
        $sql = file_get_contents($sql_path . $sql_name . '.sql');

        return $sql;
    }
}
