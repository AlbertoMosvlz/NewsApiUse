<?php

/** 
 * @author AlbertoMosvlz 
 * 23/02/2024
 * Este archivo contiene la implementación de la clase NewsController, la cual se encarga de manejar 
 * la lógica para obtener y procesar artículos de noticias desde la API de NewsAPI. Además, se realiza la maquetación 
 * básica de una aplicación web tipo blog para mostrar estos artículos en formato de tarjetas.
 * */

require 'vendor/autoload.php';

use GuzzleHttp\Client;
class NewsController
{
    private $client;
    private $api_key_news_api;

    public function __construct($api_key_news_api)
    {
        $this->client = new Client();
        $this->api_key_news_api = $api_key_news_api;
    }

    private function getRandomAuthors($count)
    {
        $authors = [];

        $random_user_url = 'https://randomuser.me/api/?results=' . $count;
        $response_random_user = $this->client->get($random_user_url);
        $body_random_user = $response_random_user->getBody();
        $decoded_data_random_user = json_decode($body_random_user, true);

        foreach ($decoded_data_random_user['results'] as $result) {
            $authors[] = $result['name']['first'];
        }

        return $authors;
    }

    public function getArticles($page = 1, $pageSize = 30)
    {
        $articles = [];

        $authors = $this->getRandomAuthors($pageSize);

        $url = 'https://newsapi.org/v2/everything?q=null&page=' . $page . '&pageSize=' . $pageSize . '&language=en&apiKey=' . urlencode($this->api_key_news_api);

        try {
            $response = $this->client->get($url);
            $body = $response->getBody();
            $decoded_data = json_decode($body, true);

            if ($decoded_data !== null && isset($decoded_data['articles'])) {
                foreach ($decoded_data['articles'] as $key => $article_data) {
                    $article_data['author'] = $authors[$key];

                    $articles[] = $article_data;
                }
            }
        } catch (Exception $e) {
            error_log('Error al obtener los artículos de la API de NewsAPI: ' . $e->getMessage());
            throw $e;
        }

        return $articles;
    }
}
