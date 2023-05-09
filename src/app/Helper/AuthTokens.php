<?php

namespace App\Helper;

use Config;
use Illuminate\Validation\ValidationException;

class AuthTokens {

    public const ADMIN = 1;

    private $type;

    public static function checkToken($token)
    {
        $tokenConfig = Config::get('auth.credentials.tokens.admin');

        if (!$tokenConfig) {
            throw ValidationException::withMessages([
                'token' => 'Can not access',
            ]);
        }
        // disabled
        // if ($tokenConfig != $token) {
        //     throw ValidationException::withMessages([
        //         'token' => 'Unauthorised',
        //     ]);
        // }

        return new self(self::ADMIN);
    }

    public function __construct(int $ident)
    {
        $this->type = $ident;
    }

    public function getAuthIdentifier(){
        return $this->type;
    }

}