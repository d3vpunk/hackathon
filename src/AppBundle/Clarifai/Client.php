<?php

namespace AppBundle\Clarifai;

class Client
{
    private $clientId = "QhK6U2u8R17RJbWVt0Mn6QLWOvsKagclh1A4rH8P";
    private $clientSecret = "ImZ2tKfJht9uWraS6fbjEBjnORq_Rsu_X9txBRPM";
    private $accessToken = "Zvby0BiaQnTM6khQnRepMjwLAYGst4";

    public function getTagsByImageFile(\SplFileInfo $imageFile)
    {
        $accessToken = $this->getAccessToken();
    }

    private function getAccessToken()
    {

        $accessToken = "";

        $ch = curl_init();

        $postVars = sprintf("client_id=%s&client_secret=%s&grant_type=client_credentials", $this->clientId, $this->clientSecret);

        curl_setopt($ch, CURLOPT_URL,"https://api.clarifai.com/v1/token/");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
            $postVars);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec ($ch);

        var_dump($response);
        die();

        curl_close ($ch);

        return $accessToken;
    }
}