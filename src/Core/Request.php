<?php
namespace App\Core;

/**
 * Class Request
 * 
 * Singleton wrapper for HTTP request data (GET, POST, SESSION, etc).
 */
class Request //implements \Psr\Http\Message\ServerRequestInterface
{
    /**
     * @var Request|null
     */
    private static ?Request $instance = null;

    /**
     * @var array
     */
    private array $session = [];
    /**
     * @var array
     */
    private array $cookies = [];
    /**
     * @var array
     */
    private array $server = [];
    /**
     * @var array
     */
    private array $params = [];
    /**
     * @var array
     */
    private array $queryParams = [];
    /**
     * @var array
     */
    private array $postParams = [];
    /**
     * @var array
     */
    private array $files = [];
    /**
     * @var array
     */
    private array $filesRaw = [];


    /**
     * Request constructor.
     * Initializes request data from PHP superglobals.
     */
    private function __construct()
    {
        session_start();
        $this->params = &$_REQUEST;
        $this->session = &$_SESSION;
        $this->cookies = &$_COOKIE;
        $this->server = &$_SERVER;
        $this->queryParams = &$_GET;
        $this->postParams = &$_POST;
        $this->filesRaw = &$_FILES;
        $this->files = $this->normalizeFiles($this->filesRaw);

        // echo "<pre>";
        // print_r($this->files);
        // die();
    }

    /**
     * Get the singleton instance.
     * 
     * @return Request
     */
    public static function getInstance(): Request
    {   
        if (static::$instance === null) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    public function __invoke(string $key): mixed
    {
        return $this->request($key);
    }

    public function request(string $key): mixed
    {
        return $this->server($key) ?? $this->query($key) ?? $this->post($key) ?? $this->session($key) ?? $this->cookie($key) ?? null;
    }

    /**
     * @deprecated
     * Alias for request method to get a value from the request.
     * 
     * @param string $key
     * @return mixed
     */
    public function getRequest(string $key)
    {
        return $this->request($key);
    }

    /**
     * Get or set a value from $_GET 
     * 
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    public function query(string $key, mixed $value = null): mixed
    {
        return $value ? $this->queryParams[$key] = $value : ($this->queryParams[$key] ?? null);
    }

    /**
     * 
     * 
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    public function post(string $key, mixed $value = null): mixed
    {
        return $value ? $this->postParams[$key] = $value : ($this->postParams[$key] ?? null);
    }

    /**
     * Get or set a value in $_SESSION.
     * 
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    public function session(string $key, mixed $value = null): mixed
    {
        return $value ? $this->session[$key] = $value : ($this->session[$key] ?? null);
    }

    /**
     * Cleans the session data.
     * @return void
     */
    public function clearSession(): void
    {
        $this->session = [];
        $_SESSION = []; //fallback if not enough
    }

    /**
     * Get or set a value from $_COOKIE.
     * 
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    public function cookie(string $key, mixed $value = null): mixed
    {
        return $value ? $this->cookies[$key] = $value : ($this->cookies[$key] ?? null);
    }

    /**
     * Get or set a value from $_SERVER.
     * 
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    public function server(string $key, mixed $value = null): mixed
    {
        return $value ? $this->server[$key] = $value : ($this->server[$key] ?? null);
    }

    public function files(?string $key = null): array
    {
        if ($key === null) {
            return $this->files;
        }

        return $this->files[$key] ?? [];
    }

    /**
     * Get a value from $_FILES or all files.
     * 
     * @param string|null $key
     * @param mixed $default
     * @return mixed
     */
    public function getFile(?string $key = null, mixed $default = null): mixed
    {
        if ($key === null) {
            return $this->files;
        }

        return $this->files[$key] ?? $default;
    }

    protected function normalizeFiles(array $files): array
    {
        foreach ($files as $key => $fileData) {
            $files[$key] = $this->normalizeFileArray($fileData);
        }

            return $files;
    }

    protected function normalizeFileArray(array $files): array
    {
        $normalized = [];

        if (is_array($files['name']) && count($files['name']) > 0 && is_array($files['name'])) {
            $fileCount = count($files['name']);
            for ($i = 0; $i < $fileCount; $i++) {
                $normalized[] = [
                    'name'     => $files['name'][$i],
                    'type'     => $files['type'][$i],
                    'tmp_name' => $files['tmp_name'][$i],
                    'error'    => $files['error'][$i],
                    'size'     => $files['size'][$i],
                ];
            }
        } else {
            $normalized[] = [
                'name'     => $files['name'],
                'type'     => $files['type'],
                'tmp_name' => $files['tmp_name'],
                'error'    => $files['error'],
                'size'     => $files['size'],
            ];
        }

        return $normalized;
    }

     /**
     * Check if the request method is POST.
     * 
     * @return bool
     */
    public function isPost(): bool
    {
        return $this->server('REQUEST_METHOD') === 'POST';
    }

    /**
     * Check if the request method is GET.
     * 
     * @return bool
     */
    public function isGet(): bool
    {
        return $this->server('REQUEST_METHOD') === 'GET';
    }

    
}