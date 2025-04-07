<?php

namespace App\Services;

use GuzzleHttp\Client;

class ResumeAIService
{
    protected $client;
    protected $huggingFaceToken;

    public function __construct()
    {
        $this->client = new Client();
        $this->huggingFaceToken = env('HUGGINGFACE_API_KEY'); // Store API key in .env file
    }

    public function generateResume($jobRole)
    {
        $prompt = "Generate a professional resume for a job in: " . $jobRole;
        
        $response = $this->client->post('https://api-inference.huggingface.co/models/mistralai/Mistral-7B-Instruct-v0.1', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->huggingFaceToken,
                'Content-Type' => 'application/json'
            ],
            'json' => ['inputs' => $prompt],
        ]);

        $output = json_decode($response->getBody(), true);
        return $output[0]['generated_text'] ?? 'AI could not generate a response.';
    }
}
