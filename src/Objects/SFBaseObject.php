<?php

namespace Amx\Salesforce\Objects;

use Amx\Salesforce\Traits\SFBaseFields;
use Amx\Salesforce\SFClientService;

abstract class SFBaseObject
{
    use SFBaseFields;

    protected string $sObject;
    protected static ?SFClientService $client = null;
    protected array $attributes = [];

    public function __construct(array $attributes = [])
    {
        if (!self::$client) {
            self::$client = new SFClientService();
        }

        $this->attributes = $attributes;
    }

    public static function setClient(SFClientService $client): void
    {
        self::$client = $client;
    }

    protected function client(): SFClientService
    {
        return self::$client;
    }

    public function toArray(): array
    {
        return $this->attributes;
    }

    public function __get(string $key): mixed
    {
        return $this->attributes[$key] ?? null;
    }

    public function __set(string $key, mixed $value): void
    {
        $this->attributes[$key] = $value;
    }

    public function findById(string $id, array $fields = ['Id']): static
    {
        $record = self::$client
            ->select($fields)
            ->from($this->sObject)
            ->where(['Id', '=', $id])
            ->execute();

        $this->attributes = $record['records'][0] ?? [];
        return $this;
    }

    public function save(): array
    {
        if (!empty($this->attributes['Id'])) {
            return self::$client->update($this->sObject, $this->attributes['Id'], $this->attributes);
        }
        return self::$client->create($this->sObject, $this->attributes);
    }

    public function sync(string $mode = 'api'): array
    {
        $object = $this->sObject;

        $describe = $mode === 'ui'
            ? $this->client()->uiObjectInfo($object)
            : $this->client()->describe($object);

        if ($mode === 'api') {
            if (empty($describe['fields'])) {
                throw new \RuntimeException("Describe response for {$object} contains no 'fields'.");
            }

            $filtered = array_filter($describe['fields'], fn(array $f) =>
                !$f['deprecatedAndHidden'] &&
                !$f['defaultedOnCreate'] &&
                !$f['calculated'] &&
                ($f['createable'] || $f['updateable'] || $f['filterable']) &&
                !str_starts_with($f['name'], 'Jigsaw') &&
                !str_contains($f['name'], '__History') &&
                !str_contains($f['name'], 'DataDotCom')
            );

            $fields = array_values(array_map(fn($f) => [
                'name'  => $f['name'],
                'type'  => $f['type'],
                'label' => $f['label'],
            ], $filtered));
        } else {
            $uiFields = $describe['fields'] ?? [];
            $fields = array_values(array_map(fn($f) => [
                'name'  => $f['apiName'],
                'type'  => $f['dataType'],
                'label' => $f['label'],
            ], $uiFields));
        }

        $reflect = new \ReflectionClass($this);
        $namespace = $reflect->getNamespaceName();
        $objectName = $reflect->getShortName();
        $baseName = str_starts_with($objectName, 'SF') ? substr($objectName, 2) : $objectName;

        $folder = str_contains($namespace, 'Custom') ? 'Custom' : 'Standard';

        $packageBase = dirname(__DIR__, 1);
        $traitNamespace = "Amx\\Salesforce\\Traits\\{$folder}";
        $traitFile = "{$packageBase}/Traits/{$folder}/SF{$baseName}Fields.php";

        if (!file_exists($traitFile)) {
            $content = "<?php\n\nnamespace {$traitNamespace};\n\ntrait SF{$baseName}Fields\n{\n}\n";
            file_put_contents($traitFile, $content);
        }

        $fieldNames = array_column($fields, 'name');
        $formatted = implode(",\n            ", array_map(fn($f) => "'{$f}'", $fieldNames));
        $methodName = "get{$baseName}Fields";

        $method = <<<PHP
        public function {$methodName}(): array
        {
            return [
                {$formatted}
            ];
        }
        PHP;

        $contents = file_get_contents($traitFile);
        $contents = preg_replace('/public function\s+\w+\s*\(.*?\)\s*:\s*array\s*\{.*?\}/s', '', $contents);
        $newContents = preg_replace('/}\s*$/', "    {$method}\n}\n", $contents);
        file_put_contents($traitFile, $newContents);

        return $fields;
    }
}