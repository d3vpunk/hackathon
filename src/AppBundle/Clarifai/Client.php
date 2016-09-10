<?php

namespace AppBundle\Clarifai;

use AppBundle\Model\MediaTag;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Client
{
    private $clientId = "QhK6U2u8R17RJbWVt0Mn6QLWOvsKagclh1A4rH8P";
    private $clientSecret = "ImZ2tKfJht9uWraS6fbjEBjnORq_Rsu_X9txBRPM";
    private $kernelCacheDir;

    /**
     * Client constructor.
     * @param $kernelCacheDir
     */
    public function __construct($kernelCacheDir)
    {
        $this->kernelCacheDir = $kernelCacheDir;
    }


    /**
     * @param \SplFileInfo|UploadedFile $imageFile
     * @return array
     */
    public function getTagsByImageFile(\SplFileInfo $imageFile)
    {
        $accessToken = $this->getAccessToken();

        $imageFile = $imageFile->move($this->kernelCacheDir . "/" . rand(0,9999999), $imageFile->getClientOriginalName());

        $cmd='curl "https://api.clarifai.com/v1/tag/" \
  -X POST -F "encoded_data=@%s" \
  -H "Authorization: Bearer %s"';
        $cmd = sprintf($cmd, $imageFile->getRealPath(), $accessToken);
        $result = exec($cmd,$result);

        $imageResult = json_decode($result, true);

        $classes = $imageResult['results'][0]['result']['tag']['classes'];
        $scores = $imageResult['results'][0]['result']['tag']['probs'];

        $mediaTags = [];

        foreach($classes as $i => $class) {
            $mediaTags[] = new MediaTag($class, $scores[$i]);
        }

        return $mediaTags;
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

        $jsonResponse = json_decode($response, true);


        if (!isset($jsonResponse["access_token"])) {
            throw new \Exception("Kon geen access token van Clarifai verkrijgen..");
        }

        curl_close ($ch);

        return $jsonResponse["access_token"];
    }
}