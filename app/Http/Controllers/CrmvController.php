<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class CrmvController
{

    protected $url = 'https://app.cfmv.gov.br/pf/consultaInscricao/';

    public function validate(string $uf, string $nome, string $crmv, string $idcrmv)
    {

        $response = Http::get($this->url . $crmv . '/1/2/' . $uf . '/' . getenv('API_CRMV_KEY'));
        $dados = json_decode($response);
        if($dados->type == "sucess") {
            
            if(strtoupper($dados->data[0]->nome) === strtoupper($nome)) {
                
            }
        }       
    }
}
