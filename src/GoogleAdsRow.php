<?php

namespace AndreOrtu\LaravelGoogleAds;

class GoogleAdsRow
{
    private $result;

    public function toJson(\Google\Ads\GoogleAds\V8\Services\GoogleAdsRow $googleAdsRow): GoogleAdsRow
    {
        $this->result = json_decode($googleAdsRow->serializeToJsonString(), true);
        return $this;
    }

    public function result()
    {
        return $this->array_flatten($this->result);
    }

    private function array_flatten($array, $name = "") {
        $return = array();
        foreach ($array as $key => $value) {
            if (is_array($value)){
                $return = array_merge($return, $this->array_flatten($value, $key));
            } else {
                $return["$name.$key"] = $value;
            }
        }

        return $return;
    }
}
