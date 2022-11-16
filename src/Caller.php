<?php

namespace WendellAdriel\LaravelCaller;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class Caller
{
    private const DEFAULT_TIMEOUT     = 30;
    private const DEFAULT_RETRIES     = 0;
    private const DEFAULT_RETRY_AFTER = 100;
    private const DEFAULT_TOKEN_TYPE  = 'Bearer';

    private const AUTH_TYPE_BASIC  = 'basic';
    private const AUTH_TYPE_DIGEST = 'digest';
    private const AUTH_TYPE_TOKEN  = 'token';

    private string $url;
    private int $timeout;
    private array $headers;
    private array $cookies;
    private string $cookiesDomain;
    private string $authType;
    private string $authUser;
    private string $authPassword;
    private string $authToken;
    private string $authTokenType;
    private int $retries;
    private int $retryAfter;
    private ?CallerAttachment $attachment;

    /**
     * @param string $service
     */
    public function __construct(string $service = 'default')
    {
        $this->configure($service);
    }

    /**
     * @param string $service
     * @return Caller
     */
    public static function make(string $service = 'default'): Caller
    {
        return new static($service);
    }

    /**
     * @param string $url      - The URL for the request that will be joined with the base URL configured in the service
     * @param array  $params   - The params to be sent to the request
     * @param bool   $asForm   - If the request should be sent as "application/x-www-form-urlencoded"
     * @param bool   $isPublic - If is set to true the auth won't be configured for the request
     * @param array  $headers  - Specific headers for the request that will be merged with the headers configured in the service
     * @param array  $cookies  - Specific cookies for the request that will be merged with the cookies configured in the service
     * @param bool   $debug    - Dumps the outgoing request before it is sent and terminate the script's execution
     * @return Response
     */
    public function head(
        string $url,
        array $params,
        bool $asForm = false,
        bool $isPublic = false,
        array $headers = [],
        array $cookies = [],
        bool $debug = false
    ): Response {
        return $this->buildBaseRequest($asForm, $isPublic, $headers, $cookies, $debug)
            ->head("{$this->url}/{$url}", $params);
    }

    /**
     * @param string $url      - The URL for the request that will be joined with the base URL configured in the service
     * @param array  $params   - The params to be sent to the request
     * @param bool   $asForm   - If the request should be sent as "application/x-www-form-urlencoded"
     * @param bool   $isPublic - If is set to true the auth won't be configured for the request
     * @param array  $headers  - Specific headers for the request that will be merged with the headers configured in the service
     * @param array  $cookies  - Specific cookies for the request that will be merged with the cookies configured in the service
     * @param bool   $debug    - Dumps the outgoing request before it is sent and terminate the script's execution
     * @return Response
     */
    public function get(
        string $url,
        array $params,
        bool $asForm = false,
        bool $isPublic = false,
        array $headers = [],
        array $cookies = [],
        bool $debug = false
    ): Response {
        return $this->buildBaseRequest($asForm, $isPublic, $headers, $cookies, $debug)
            ->get("{$this->url}/{$url}", $params);
    }

    /**
     * @param string $url      - The URL for the request that will be joined with the base URL configured in the service
     * @param array  $params   - The params to be sent to the request
     * @param bool   $asForm   - If the request should be sent as "application/x-www-form-urlencoded"
     * @param bool   $isPublic - If is set to true the auth won't be configured for the request
     * @param array  $headers  - Specific headers for the request that will be merged with the headers configured in the service
     * @param array  $cookies  - Specific cookies for the request that will be merged with the cookies configured in the service
     * @param bool   $debug    - Dumps the outgoing request before it is sent and terminate the script's execution
     * @return Response
     */
    public function post(
        string $url,
        array $params,
        bool $asForm = false,
        bool $isPublic = false,
        array $headers = [],
        array $cookies = [],
        bool $debug = false
    ): Response {
        return $this->buildBaseRequest($asForm, $isPublic, $headers, $cookies, $debug)
            ->post("{$this->url}/{$url}", $params);
    }

    /**
     * @param string $url      - The URL for the request that will be joined with the base URL configured in the service
     * @param array  $params   - The params to be sent to the request
     * @param bool   $asForm   - If the request should be sent as "application/x-www-form-urlencoded"
     * @param bool   $isPublic - If is set to true the auth won't be configured for the request
     * @param array  $headers  - Specific headers for the request that will be merged with the headers configured in the service
     * @param array  $cookies  - Specific cookies for the request that will be merged with the cookies configured in the service
     * @param bool   $debug    - Dumps the outgoing request before it is sent and terminate the script's execution
     * @return Response
     */
    public function put(
        string $url,
        array $params,
        bool $asForm = false,
        bool $isPublic = false,
        array $headers = [],
        array $cookies = [],
        bool $debug = false
    ): Response {
        return $this->buildBaseRequest($asForm, $isPublic, $headers, $cookies, $debug)
            ->put("{$this->url}/{$url}", $params);
    }

    /**
     * @param string $url      - The URL for the request that will be joined with the base URL configured in the service
     * @param array  $params   - The params to be sent to the request
     * @param bool   $asForm   - If the request should be sent as "application/x-www-form-urlencoded"
     * @param bool   $isPublic - If is set to true the auth won't be configured for the request
     * @param array  $headers  - Specific headers for the request that will be merged with the headers configured in the service
     * @param array  $cookies  - Specific cookies for the request that will be merged with the cookies configured in the service
     * @param bool   $debug    - Dumps the outgoing request before it is sent and terminate the script's execution
     * @return Response
     */
    public function patch(
        string $url,
        array $params,
        bool $asForm = false,
        bool $isPublic = false,
        array $headers = [],
        array $cookies = [],
        bool $debug = false
    ): Response {
        return $this->buildBaseRequest($asForm, $isPublic, $headers, $cookies, $debug)
            ->patch("{$this->url}/{$url}", $params);
    }

    /**
     * @param string $url      - The URL for the request that will be joined with the base URL configured in the service
     * @param array  $params   - The params to be sent to the request
     * @param bool   $asForm   - If the request should be sent as "application/x-www-form-urlencoded"
     * @param bool   $isPublic - If is set to true the auth won't be configured for the request
     * @param array  $headers  - Specific headers for the request that will be merged with the headers configured in the service
     * @param array  $cookies  - Specific cookies for the request that will be merged with the cookies configured in the service
     * @param bool   $debug    - Dumps the outgoing request before it is sent and terminate the script's execution
     * @return Response
     */
    public function delete(
        string $url,
        array $params,
        bool $asForm = false,
        bool $isPublic = false,
        array $headers = [],
        array $cookies = [],
        bool $debug = false
    ): Response {
        return $this->buildBaseRequest($asForm, $isPublic, $headers, $cookies, $debug)
            ->delete("{$this->url}/{$url}", $params);
    }

    /**
     * @param string $service
     * @return Caller
     */
    public function setService(string $service): Caller
    {
        $this->configure($service);
        return $this;
    }

    /**
     * @param string $authUser
     * @return Caller
     */
    public function setAuthUser(string $authUser): Caller
    {
        $this->authUser = $authUser;
        return $this;
    }

    /**
     * @param string $authPassword
     * @return Caller
     */
    public function setAuthPassword(string $authPassword): Caller
    {
        $this->authPassword = $authPassword;
        return $this;
    }

    /**
     * @param string $authToken
     * @return Caller
     */
    public function setAuthToken(string $authToken): Caller
    {
        $this->authToken = $authToken;
        return $this;
    }

    /**
     * @param CallerAttachment $attachment
     * @return Caller
     */
    public function setAttachment(CallerAttachment $attachment): Caller
    {
        $this->attachment = $attachment;
        return $this;
    }

    /**
     * @param string $service
     * @return void
     */
    private function configure(string $service): void
    {
        $serviceConfig = config("caller.services.{$service}");
        if (empty($serviceConfig)) {
            $serviceConfig = config('caller.services.default');
        }

        $this->url           = $serviceConfig['url'] ?? '';
        $this->timeout       = $serviceConfig['timeout'] ?? self::DEFAULT_TIMEOUT;
        $this->headers       = $serviceConfig['headers'] ?? [];
        $this->cookies       = $serviceConfig['cookies'] ?? [];
        $this->cookiesDomain = $serviceConfig['cookies_domain'] ?? '';
        $this->authType      = $serviceConfig['auth']['type'] ?? '';
        $this->authUser      = $serviceConfig['auth']['user'] ?? '';
        $this->authPassword  = $serviceConfig['auth']['password'] ?? '';
        $this->authToken     = $serviceConfig['auth']['token'] ?? '';
        $this->authTokenType = $serviceConfig['auth']['token_type'] ?? self::DEFAULT_TOKEN_TYPE;
        $this->retries       = $serviceConfig['retries'] ?? self::DEFAULT_RETRIES;
        $this->retryAfter    = $serviceConfig['retry_after'] ?? self::DEFAULT_RETRY_AFTER;
    }

    /**
     * @param bool  $asForm
     * @param bool  $isPublic
     * @param array $headers
     * @param array $cookies
     * @param bool  $debug
     * @return PendingRequest
     */
    private function buildBaseRequest(
        bool $asForm,
        bool $isPublic,
        array $headers,
        array $cookies,
        bool $debug
    ): PendingRequest {
        $request = Http::timeout($this->timeout)
            ->withHeaders(array_merge($this->headers, $headers))
            ->withCookies(array_merge($this->cookies, $cookies), $this->cookiesDomain);

        if (!$isPublic) {
            $request = $this->configureAuth($request);
        }

        if ($this->retries > 0) {
            $request->retry($this->retries, $this->retryAfter);
        }

        if ($asForm) {
            $request->asForm();
        }

        if (!is_null($this->attachment)) {
            $request->attach(
                $this->attachment->getName(),
                $this->attachment->getContent(),
                $this->attachment->getFilename()
            );

            $this->attachment = null;
        }

        if ($debug) {
            $request->dd();
        }

        return $request;
    }

    /**
     * @param PendingRequest $request
     * @return PendingRequest
     */
    private function configureAuth(PendingRequest $request): PendingRequest
    {
        switch ($this->authType) {
            case self::AUTH_TYPE_BASIC:
                $request->withBasicAuth($this->authUser, $this->authPassword);
                break;

            case self::AUTH_TYPE_DIGEST:
                $request->withDigestAuth($this->authUser, $this->authPassword);
                break;

            case self::AUTH_TYPE_TOKEN:
                $request->withToken($this->authToken, $this->authTokenType);
                break;

            default:
                // DO NOTHING
        }

        return $request;
    }
}
