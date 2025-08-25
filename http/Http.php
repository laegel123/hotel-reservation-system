<?php declare(strict_types=1);

namespace http;


class HttpRequest
{

    private string $raw;

    public function __construct(string $raw)
    {
        $this->raw = $raw;
    }

    public function json(string $key, $default)
    {
        $data = null;
        if ($data === null) {
            $data = json_decode($this->raw, true);
        }

        return $data[$key] ?? $default;
    }
}

class HttpResponse
{

    public function json(int $status, array $body): void {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($body, JSON_UNESCAPED_UNICODE);
    }
}

if (!function_exists('json_input')) {
    function json_input(): \http\HttpRequest {
        return new \http\HttpRequest(file_get_contents('php://input'));
    }
}
