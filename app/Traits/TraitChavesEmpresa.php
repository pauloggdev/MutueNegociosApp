<?php

namespace App\Traits;


trait TraitChavesEmpresa{

    public function pegarChavePrivada(){


        $privatekey = "MIICXAIBAAKBgQCqJsIyoKXnIyhFSwNZFE1lyGcsqn+6alTls2kzK8AsxIT21vD3
        ct0M8DlAUiPaeODU+wFmVpcGkSVRysDzXF6XvtBrZMk9qWbYrjuiXwAcMupXcR7d
        UWbc4QQbVqVYjE+MaOaR8YircAbq8bwHPpF+TYdQD5VdoAgE5YR240R4FQIDAQAB
        AoGAZq6pN2BXfltrLBYO2S01YB1Gll/2YQtWXKCe9fCLMvkNvOEN3mcFG4/FHRn0
        5R1ZoW4w9A+BaMcjHG8dbj/qHPD/9G3qvXmNN1J3d4vIe5QMqNEl8/OrdGGtxVlt
        QxDXjnsWr2vtayRZb7puxkxOBlLTyxfLlMVI3kefnv9U/+kCQQDdqzXNZsQiUIaP
        9GBaKE4/0rANYIINhf291u7XgyjuCdo+q3xuOyK0MNcJ/+ei0jLkXx9ao35mRggC
        nrJwWvnHAkEAxID4wrgWkb/7DEdf0xsMW2gk7Lq2L0/GziK1A3kMTUfCOfBy+fhY
        Suuu+1tw0oSlklYYlCzPT1CI+xf0HxofQwJAUxjzumRj8lktmJmL5UBm1RYuWVVs
        a5VnYdtI/hF1LocTAZtXshsJD3OfqWf9ddRGr8XZAyl3IO/v4MuNKQFx0QJATq7d
        7QpNbzsSSU5jHmLcRdWjw27X+IXXMz9Of/9+X4t2SEDxqQo6QHWy8U8iFAmtSrVS
        zjJLKJU05GYpCDMrhQJBAL6uhphR3SQgypTLlRB+XezzrDsjYBTPWjbGHekmT69k
        YODqjiQlUizmtxgJ3cZLU/hOFyJJ41qF+o2+SmwYy5s=";

        return $privatekey;
    }
    public function pegarChavePublica(){


        $publickey = "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCqJsIyoKXnIyhFSwNZFE1lyGcs
        qn+6alTls2kzK8AsxIT21vD3ct0M8DlAUiPaeODU+wFmVpcGkSVRysDzXF6XvtBr
        ZMk9qWbYrjuiXwAcMupXcR7dUWbc4QQbVqVYjE+MaOaR8YircAbq8bwHPpF+TYdQ
        D5VdoAgE5YR240R4FQIDAQAB";

        return $publickey;
    }

}