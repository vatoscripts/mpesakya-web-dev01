<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Response;
use GuzzleHttp\Psr7;
use Session;
use Exception;
use Illuminate\Support\Facades\View;
use Debugbar;
use Illuminate\Support\Facades\Log;

class GuzzleController extends Controller
{
    protected $token;
    protected $baseUrl;
    public $user;

    //Constructor method
    public function __constructor()
    {
        $this->middleware(function ($request, $next) {

            if (session::has('user')) {
                $this->user = session::get('user');
                // Sharing is caring
                View::share('user', $this->user);
            } else {
                $this->user = NULL;
            }

            return $next($request);
        });
    }

    protected function postRequest($url, $body)
    {
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => isset($this->user['Token']) ? 'bearer ' . $this->user['Token'] : null,
        ];

        $client = new Client([
            'headers' => $headers
        ]);

        try {
            $r = $client->request('POST', env('API_URL') . $url, ['json' => $body]);

            $status = $r->getStatusCode();

            if ($status === 200) {
                $response = $r->getBody()->getContents();

                $data = json_decode($response, true);

                return $data;
            } else {
                return response()->json(['error' => 'Something went wrong'], 400);
            }
        } catch (Exception $e) {
            return response()->json(['ErrorMessage' => $e->getMessage()], 400);
        }
    }

    protected function getRequest($url)
    {
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => isset($this->user['Token']) ? 'bearer ' . $this->user['Token'] : null,
        ];

        $client = new Client([
            'headers' => $headers,
        ]);

        try {
            $r = $client->request('GET', env('API_URL') . $url);
            $status = $r->getStatusCode();
            if ($status === 200) {
                $response = $r->getBody()->getContents();

                $data = json_decode($response, true);

                return $data;
            } else {
                return response()->json(['error' => 'Something went wrong'], 400);
            }
        } catch (Exception $e) {
            return response()->json(['ErrorMessage' => $e->getMessage()], 400);
        }
    }
}
