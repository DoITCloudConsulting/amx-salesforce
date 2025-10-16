<?php

namespace Amx\Salesforce\Objects\Fields;

/**
 * Representa la estructura de los campos de un Account en Salesforce.
 *
 * @property string $Id
 * @property string|null $Name
 * @property string|null $Branches__c
 * @property string|null $Home_IATA__c
 * @property string|null $Cuenta_Principal_NG__c
 * @property string|null $Cuenta_Principal_NG2__c
 * @property string|null $RecordType__c
 * @property string|null $RecordType_Name
 */
abstract class AccountFields
{
    protected array $attributes = [];

    public function __get(string $name)
    {
        return $this->attributes[$name] ?? null;
    }

    public function __set(string $name, $value): void
    {
        $this->attributes[$name] = $value;
    }

    public function fromArray(array $data): static
    {
        $this->attributes = $data;
        return $this;
    }

    public static function all(): array
    {
        return [
            'Id',
            'Name',
            'Branches__c',
            'Home_IATA__c',
            'Cuenta_Principal_NG__c',
            'Cuenta_Principal_NG2__c',
            'RecordType__c',
            'RecordType.Name'
        ];
    }

    public static function base(): array
    {
        return ['Id', 'Name', 'Type', 'ParentId'];
    }

    public static function iataFields(): array
    {
        return ['Branches__c', 'Home_IATA__c'];
    }
}