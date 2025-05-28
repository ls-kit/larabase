<?php

namespace App\Services;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class BaserowService
{
    protected $token;
    protected $url;
    protected $tables;

    public function __construct()
    {
        $this->token = config('baserow.token');
        $this->url   = config('baserow.url');
        $this->tables= config('baserow.tables');
    }
     protected function headers(): array
        {
            return [
                'Authorization' => "Token {$this->token}",
                'Content-Type'  => 'application/json',
            ];
        }


    public function fetch(string $tableName)
    {
        $id       = $this->tables[$tableName];
        $endpoint = "{$this->url}/rows/table/{$id}/?user_field_names=true";

        $response = Http::withHeaders($this->headers())->get($endpoint);
        $response->throw(); // throws on 4xx/5xx

        return $response->json()['results'] ?? [];
    }


    public function create(string $table, array $data)
    {
        $id       = $this->tables[$table];
        $endpoint = "{$this->url}/rows/table/{$id}/?user_field_names=true";

        $response = Http::withHeaders($this->headers())
                        ->post($endpoint, $data);

        $response->throw();
        return $response->json();
    }

    public function update(string $table, int $rowId, array $data)
    {
        $id       = $this->tables[$table];
        $endpoint = "{$this->url}/rows/table/{$id}/{$rowId}/?user_field_names=true";

        $response = Http::withHeaders($this->headers())
                        ->patch($endpoint, $data);

        $response->throw();
        return $response->json();
    }

    public function delete(string $table, int $rowId)
    {
        $id       = $this->tables[$table];
        $endpoint = "{$this->url}/rows/table/{$id}/{$rowId}/?user_field_names=true";

        $response = Http::withHeaders($this->headers())
                        ->delete($endpoint);

        $response->throw();
    }

  public function find(string $table, int $rowId): array
{
    $tableId  = $this->tables[$table];
    $endpoint = "{$this->url}/rows/table/{$tableId}/{$rowId}/?user_field_names=true";

    $response = Http::withHeaders($this->headers())
                    ->get($endpoint);

    // Throw a 404-style exception if not found
    if ($response->status() === 404) {
        throw new \Illuminate\Http\Exceptions\HttpResponseException(
            response()->view('errors.404', [], 404)
        );
    }
    $response->throw(); // for other 4xx/5xx

    return $response->json();
}


    




}