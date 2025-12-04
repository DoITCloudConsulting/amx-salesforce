<?php

namespace Amx\Salesforce\Objects\Custom;

use Amx\Salesforce\Traits\Custom\SFTracker_Trade_SiteFields;
use Amx\Salesforce\Objects\SFBaseObject;

class SFTracker_Trade_Site extends SFBaseObject
{
    use SFTracker_Trade_SiteFields;

    protected string $sObject = 'Tracker_Trade_Site__c';

    public function allFields(): array
    {
        return array_merge($this->getBaseFields(), $this->getTracker_Trade_SiteFields());
    }

    public function create(?SFTracker_Trade_Site $tracker = null): array|null
    {
        $instance = $tracker ?? $this;

        $payload = $instance->toArray();
        
        if (empty($payload)) {
            throw new \InvalidArgumentException(
                'No data provided to create Tracker_Trade_Site record. You must either instantiate with data or pass an instance to create().'
            );
        }

        $response = $this->client()->object($this->sObject, [
            'method' => 'POST',
            'body'   => $payload,
        ]);

        return json_decode($response, true);
    }

    public function getByHerokuId(string $herokuId): SFTracker_Trade_Site|null
    {
        $response = $this->client()
            ->select(['Id'])
            ->from($this->sObject)
            ->where(['Heroku_Id__c', '=', $herokuId])
            ->limit(1)
            ->execute();

        return $this->hydrateResponse($response);
    }
}