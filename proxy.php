<?php
// PSGC API URL
$apiUrl = 'https://psgc.vercel.app/api';

// Get the endpoint from the request
$endpoint = $_GET['endpoint'];

// Create the final URL to fetch
$url = $apiUrl . '/' . $endpoint;

// Make the request and return the response
$response = file_get_contents($url);
header('Content-Type: application/json');
echo $response;
?>