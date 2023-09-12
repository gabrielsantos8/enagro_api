<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CrmvService
{

    protected $url = 'https://app.cfmv.gov.br/pf/consultaInscricao/';

    public function validate(string $uf, string $nome, string $crmv, string $idcrmv)
    {
        $ret = [];
        $response = Http::get($this->url . $crmv . '/1/2/' . $uf . '/' . getenv('API_CRMV_KEY'));
        $dados = json_decode($response);
        if ($dados->type == "sucess") {
            if (
                intval($dados->data[0]->id_pf_inscricao) === intval($idcrmv) &&
                strtoupper($dados->data[0]->nome) === strtoupper($nome)      &&
                intval($dados->data[0]->pf_inscricao) === intval($crmv)      &&
                $dados->data[0]->pf_uf === $uf                               &&
                $dados->data[0]->pf_classe === "VP"                          &&
                $dados->data[0]->atuante
            ) {
                $ret = $dados->data[0];
            }
        }

        return $ret;
    }
}
