<?php

namespace App\Services;

use App\Traits\TokenManagementTrait;

class LoginService
{
    use TokenManagementTrait;

    /**
     * Gera um token válido para a aplicação consumidora
     * @param void
     * @return array - token válido disponibilizado
     */
    public function login(): array
    {
        return [ "token" => $this->generateToken() ];
    }

    /**
     * Realiza o logout na aplicação e cancela o token que estava sendo utilizado
     * @param string - $token token utilizado
     * @return void
     */
    public function logout(string $token)
    {
        $this->revokeToken($token);
    }

}