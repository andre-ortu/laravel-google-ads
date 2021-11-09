<?php

namespace AndreOrtu\LaravelGoogleAds;

use AndreOrtu\LaravelGoogleAds\Exceptions\ColumnsNotImpementedException;
use AndreOrtu\LaravelGoogleAds\Exceptions\DateNotImpementedException;
use AndreOrtu\LaravelGoogleAds\Exceptions\ReportNameNotImpementedException;
abstract class GoogleAdsReport
{
    use Builder;

    protected $columns = [];
    protected $report_name = "";
    protected $date = "TODAY";
    protected $type = "";

    private $googleAdsClient;
    private $clientCustomerId;

    public function __construct($configuration = [])
    {
        $googleAds = (new GoogleAds())->init($configuration);
        $configuration = $googleAds->getConfiguration();
        $this->googleAdsClient = $googleAds->getClient();
        $this->clientCustomerId = $configuration->getConfiguration('clientCustomerId', 'GOOGLE_ADS');
    }

    public function searchStream()
    {
        $this->checkVariables();
        $query = $this->getQuery();
        $stream = $this->googleAdsClient->searchStream($this->clientCustomerId, $query);
        return $this->build($stream);
    }

    public function search()
    {
        $this->checkVariables();
        $query = $this->getQuery();
        $stream = $this->googleAdsClient->search($this->clientCustomerId, $query);
        return $this->build($stream);
    }

    public function build($stream): array
    {
        $results = [];
        $gaRow = new GoogleAdsRow();
        foreach ($stream->iterateAllElements() as $googleAdsRow) {
            $results[] = $gaRow->toJson($googleAdsRow)->result();
        }

        return $results;
    }

    public function getGoogleAdsClient()
    {
        return $this->googleAdsClient;
    }

    private function checkVariables()
    {
        if($this->columnsNotImplemented()) {
            throw new ColumnsNotImpementedException();
        }
        if($this->reportNameNotImplemented()) {
            throw new ReportNameNotImpementedException();
        }
        if($this->dateNotImplemented()) {
            throw new DateNotImpementedException();
        }
    }

    private function reportNameNotImplemented(): bool
    {
        return ! $this->report_name;
    }

    private function columnsNotImplemented(): bool
    {
        return ! count($this->columns);
    }

    private function dateNotImplemented(): bool
    {
        return ! $this->date;
    }
}
