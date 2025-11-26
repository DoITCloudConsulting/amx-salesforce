<?php

namespace Amx\Salesforce\Objects\Custom;

use Amx\Salesforce\Traits\Custom\SFSecurity_GroupsFields;
use Amx\Salesforce\Objects\SFBaseObject;

class SFSecurity_Groups extends SFBaseObject
{
    use SFSecurity_GroupsFields;

    protected string $sObject = 'Security_Groups__c';

    public function allFields(): array
    {
        return array_merge($this->getBaseFields(), $this->getSecurity_GroupsFields());
    }
}