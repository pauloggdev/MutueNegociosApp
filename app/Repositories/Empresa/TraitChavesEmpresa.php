<?php

namespace App\Repositories\Empresa;


trait TraitChavesEmpresa
{

    public function pegarChavePrivada()
    {


        $privatekey = "MIICXQIBAAKBgQDLCBFpQtDzVaCRm6PR3QZRb+v5jVROVMsB79HeEjkEVFxOnKD2
        WBolwYMvKHsNh6xEMnyL8sLqTc1MX1gSx/7PTOy7Umq6pnn2N37JYRg6J2i7r65T
        UaHZ7QikB+smhaCtwKK7dgL31elWXK5yD1TwpHOqSpiacQbGy79CwMfP2QIDAQAB
        AoGAFHV/q6e7/olGYOXaIC+xj0tD8CW5tRr+SfesokAb1r/ZfWJzJd/C4sMZQQtH
        OxnM1iJwQnn4AjxMz8Fb0qismHEltP7/85RrHkd0ObWXxbtZg63UrVAMPfvdrCbM
        1lCvf3ticPXp3qo3MHin1d0zTj9DlwJCBDQntXZikDBTkAECQQDp2E2QSUhp3U4z
        SbqCzojCrzlZmyFKnCn/s01GYMe4N++mHxs1Dt1hFWiWtJLvKKMrO0Sp/AsRiYkb
        GV2xd2dZAkEA3kRp2r+BQ1RzMnjtnZJJOpQF2bR9DBQvEfC0s9tsFAuL6ILWWuS6
        8AbWrP/56RUQvxR9lvVQBn1VVSm/u+ccgQJAbmxQvBiO1EbHnZpsM0aZ9+zMVQ7X
        GqdBgdhGXjxnMwte4//+VgCt8yEr4TZlx/9VhZ2YH/i/tUlP7/b7ckjjCQJBAKX3
        H7OfW74SyRHfCk6mdNewv82X3+etCpiyy7uhFErDdGzhhX3JXWztLk9vtAQ/HooP
        mtelxWOTIqy8x9Ze9AECQQCQSlsCyczzoY18cyfCzteR4fUzvHAo/cmgZc/5XUGC
        9US5flMuq+lXE5e7V6d5Ed8Y22G8wWNZqx1WR9ri+vtY";

        return $privatekey;
    }
    public function pegarChavePublica()
    {


        $publickey = "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDLCBFpQtDzVaCRm6PR3QZRb+v5
        jVROVMsB79HeEjkEVFxOnKD2WBolwYMvKHsNh6xEMnyL8sLqTc1MX1gSx/7PTOy7
        Umq6pnn2N37JYRg6J2i7r65TUaHZ7QikB+smhaCtwKK7dgL31elWXK5yD1TwpHOq
        SpiacQbGy79CwMfP2QIDAQAB";

        return $publickey;
    }
}
