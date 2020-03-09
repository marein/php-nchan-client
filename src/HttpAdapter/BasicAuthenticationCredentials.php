<?php
declare(strict_types=1);

namespace Marein\Nchan\HttpAdapter;

use Marein\Nchan\Http\Request;

class BasicAuthenticationCredentials implements Credentials
{
    /**
     * @var string
     */
    private string $username;

    /**
     * @var string
     */
    private string $password;

    /**
     * BasicAuthenticationCredentials constructor.
     *
     * @param string $username
     * @param string $password
     */
    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @inheritdoc
     */
    public function authenticate(Request $request): Request
    {
        $headers = $request->headers();

        $encodedCredentials = base64_encode($this->username . ':' . $this->password);

        $headers['Authorization'] = 'Basic ' . $encodedCredentials;

        return new Request(
            $request->url(),
            $headers,
            $request->body()
        );
    }
}
