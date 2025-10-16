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

    public function findById(string $id, array $fields, int $limit = 1): static
    {
        $record = self::$client
            ->select($fields)
            ->from($this->sObject)
            ->where(['Id', '=', $id])
            ->limit($limit)
            ->execute();

        return $this->hydrateResponse($record);
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

        if (empty($describe['fields'])) {
            throw new \RuntimeException("Describe response for {$object} contains no 'fields'.");
        }

        // 🔹 Filtra campos válidos (como antes)
        $filtered = array_filter($describe['fields'], fn(array $f) =>
            !$f['deprecatedAndHidden'] &&
            !$f['defaultedOnCreate'] &&
            !$f['calculated'] &&
            ($f['createable'] || $f['updateable'] || $f['filterable']) &&
            !str_starts_with($f['name'], 'Jigsaw') &&
            !str_contains($f['name'], '__History') &&
            !str_contains($f['name'], 'DataDotCom')
        );

        // 🔹 Convierte a estructura más simple
        $fields = array_values(array_map(fn($f) => [
            'name'  => $f['name'],
            'type'  => $f['type'],
            'label' => $f['label'],
        ], $filtered));

        // 🔹 Prepara nombres y namespaces
        $reflect = new \ReflectionClass($this);
        $namespace = $reflect->getNamespaceName();
        $objectName = $reflect->getShortName();
        $baseName = str_starts_with($objectName, 'SF') ? substr($objectName, 2) : $objectName;
        $folder = str_contains($namespace, 'Custom') ? 'Custom' : 'Standard';

        $packageBase = dirname(__DIR__, 1);
        $traitNamespace = "Amx\\Salesforce\\Traits\\{$folder}";
        $traitFile = "{$packageBase}/Traits/{$folder}/SF{$baseName}Fields.php";

        // 🔹 Si no existe el trait, lo crea vacío
        if (!file_exists($traitFile)) {
            $content = "<?php\n\nnamespace {$traitNamespace};\n\ntrait SF{$baseName}Fields\n{\n}\n";
            file_put_contents($traitFile, $content);
        }

        // 🔹 Mapea tipos de Salesforce → PHP
        $typeMap = [
            'string' => '?string',
            'picklist' => '?string',
            'textarea' => '?string',
            'phone' => '?string',
            'email' => '?string',
            'url' => '?string',
            'boolean' => '?bool',
            'double' => '?float',
            'currency' => '?float',
            'int' => '?int',
            'date' => '?string',
            'datetime' => '?string',
            'reference' => '?string',
            'id' => '?string',
            'percent' => '?float',
        ];

        // 🔹 Genera propiedades tipadas
        $properties = array_map(function ($field) use ($typeMap) {
            $type = $typeMap[$field['type']] ?? '?string';
            return "    /** {$field['label']} */\n    public {$type} \${$field['name']} = null;";
        }, $fields);

        $body = implode("\n\n", $properties);

        // 🔹 Escribe el nuevo contenido del trait
        $content = <<<PHP
        <?php
        
        namespace {$traitNamespace};
        
        trait SF{$baseName}Fields
        {
        {$body}
        }
        
        PHP;

        file_put_contents($traitFile, $content);

        return $fields;
    }

    public function hydrate(array $data): static
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $subKey => $subValue) {
                    $flatKey = "{$key}_{$subKey}";

                    if (property_exists($this, $flatKey)) {
                        $this->$flatKey = $subValue;
                    }
                }
            } elseif (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }

        return $this;
    }

    public function hydrateMany(array $records): array
    {
        return array_map(function ($data) {
            $instance = new static();
            return $instance->hydrate($data);
        }, $records);
    }

    public function hydrateResponse(array $response): static|array|null
    {
        $records = $response['records'] ?? [];

        if (empty($records)) {
            return null;
        }

        return count($records) === 1
            ? (new static())->hydrate($records[0])
            : $this->hydrateMany($records);
    }
}