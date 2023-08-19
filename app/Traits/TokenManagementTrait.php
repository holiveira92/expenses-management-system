<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Laravel\Passport\TokenRepository;
use Laravel\Passport\RefreshTokenRepository;

trait TokenManagementTrait
{
    /**
     * Gera um token válido para a aplicação consumidora
     * @param void
     * @return array - token válido disponibilizado
     */
    public function generateToken(): string
    {
        return Auth::user()
            ->createToken(config("auth.dafault_passport_client"))
            ?->accessToken ?? "";
        
    }

    /**
     * Revoga um token no sistema
     * @param string - $token token utilizado
     * @return void
     */
    public function revokeToken(string $token): void
    {
        $tokenRepository = app(TokenRepository::class);
        $refreshTokenRepository = app(RefreshTokenRepository::class);
        $tokenRepository->revokeAccessToken($token);
        $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($token);
    }

}
