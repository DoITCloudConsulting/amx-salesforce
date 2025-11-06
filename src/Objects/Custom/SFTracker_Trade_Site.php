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

    public function create(SFTracker_Trade_Site $tracker): array | null
    {
        return json_decode($this->client()->object('Tracker_Trade_Site__c', [
            'method' => 'POST',
            'body' => $tracker
        ]), true);
    }
}