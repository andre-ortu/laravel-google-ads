<?php

namespace AndreOrtu\LaravelGoogleAds;

use Google\Ads\GoogleAds\Lib\Configuration;
use Google\Ads\GoogleAds\Lib\OAuth2TokenBuilder;
use Google\Ads\GoogleAds\Lib\V8\GoogleAdsClientBuilder;
use Illuminate\Support\Facades\Config;

class GoogleAds
{
    private $configuration;
    private $googleAdsClient;
    private $oAuth2Credential;

    public function init(array $configuration = []): GoogleAds
    {
        $this->setConfiguration($configuration);
        $this->auth();
        $this->setGoogleAdsClient();

        return $this;
    }

    public function getClient()
    {
        return $this->googleAdsClient->getGoogleAdsServiceClient();
    }

    public function getConfiguration()
    {
        return $this->configuration;
    }

    private function setConfiguration(array $configuration = []): void
    {
        $configuration = count($configuration)
            ? $configuration
            : array_values(Config::get('googleads.accounts'))[0];

        $this->configuration = new Configuration($configuration);
    }

    private function auth(): void
    {
        $this->oAuth2Credential = (new OAuth2TokenBuilder())
            ->from($this->configuration)
            ->build();
    }

    private function setGoogleAdsClient(): void
    {
        $this->googleAdsClient = (new GoogleAdsClientBuilder())
            ->from($this->configuration)
            ->withOAuth2Credential($this->oAuth2Credential)
            ->build();
    }
}
