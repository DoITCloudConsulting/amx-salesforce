<?php

namespace Amx\Salesforce\Objects\Custom;

use Amx\Salesforce\Traits\Custom\SFAmount_BudgetFields;
use Amx\Salesforce\Objects\SFBaseObject;

class SFAmount_Budget extends SFBaseObject
{
    use SFAmount_BudgetFields;

    protected string $sObject = 'Amount_Budget__c';

    public function allFields(): array
    {
        return array_merge($this->getBaseFields(), $this->getAmount_BudgetFields());
    }

    public function getCurrencyById(string $budgetId): SFAmount_Budget|null
    {
        $response = $this->client()
            ->select(['Id', 'CurrencyIsoCode'])
            ->from($this->sObject)
            ->where(['Id', '=', $budgetId])
            ->limit(1)
            ->execute();

        return $this->hydrateResponse($response);
    }

    public function getBudgetDetailsById(string $budgetId): SFAmount_Budget|null
    {
        $response = $this->client()
            ->select([
                'Id',
                'CurrencyIsoCode',
                'ActivoQ1__c',
                'ActivoQ2__c',
                'ActivoQ3__c',
                'ActivoQ4__c',
                'DisponibleQ1__c',
                'DisponibleQ2__c',
                'DisponibleQ3__c',
                'DisponibleQ4__c',
                'Presupuesto_UsadoQ1__c',
                'Presupuesto_UsadoQ2__c',
                'Presupuesto_UsadoQ3__c',
                'Presupuesto_UsadoQ4__c'
            ])
            ->from($this->sObject)
            ->where(['Id', '=', $budgetId])
            ->limit(1)
            ->execute();

        return $this->hydrateResponse($response);
    }

    public function reduceBudget(string $budgetId, string $qActive, float $amountSpent, float $amountToReduce): SFAmount_Budget|array|null
    {
        $newBudget = $amountSpent + $amountToReduce;

        if ($newBudget < 0) {
            throw new \InvalidArgumentException('El presupuesto no puede ser negativo');
        }

        $payload = [$qActive => $newBudget];

        $response = $this->client()->object("{$this->sObject}/{$budgetId}", [
            'method' => 'patch',
            'body' => $payload
        ]);

        return $this->hydrateResponse(['records' => [$response]]);
    }

    public function deductFromBudget(string $budgetId, string $ancillaryUsedField, float $currentUsed, float $amount): SFAmount_Budget|array|null
    {
        $newBudget = $currentUsed + $amount;

        $payload = [$ancillaryUsedField => $newBudget];

        $response = $this->client()->object("{$this->sObject}/{$budgetId}", [
            'method' => 'patch',
            'body' => $payload
        ]);

        return $this->hydrateResponse(['records' => [$response]]);
    }
}