<?php
declare(strict_types = 1);

namespace JeanSouzaK\Duf\Prepare;

class Authentication
{

    /**
     * @var array
     */
    public $authHeaders;

    /**
     * @var string username
     * @var string password
     *
     */
    public function buildBasicAuthenticationFromCredentials($username, $password)
    {
        $this->generateBasicAuthHeaders(base64_encode("$username:$password"));
        return $this->authHeaders;
    }

    /**
     * @var string token
     */
    public function buildBasicAuthenticationFromToken($token)
    {
        $this->generateBasicAuthHeaders($token);
        return $this->authHeaders;
    }

    private function generateBasicAuthHeaders($token)
    {
        $this->authHeaders = [
            'Authorization' => 'Basic ' . $token
        ];
    }
}
