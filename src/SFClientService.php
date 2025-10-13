<?php

namespace Amx\Salesforce;

use Omniphx\Forrest\Exceptions\SalesforceException;
use Omniphx\Forrest\Providers\Laravel\Facades\Forrest;
use Amx\Salesforce\Traits\SFSanitizes;

class SFClientService
{
    use SFSanitizes;

    private array $fields = [];
    private ?string $table = null;
    private array $conditions = [];
    private ?string $orderBy = null;
    private ?int $limit = null;

    public function __construct()
    {
        $this->ensureAuthenticated();
    }

    private function ensureAuthenticated(): void
    {
        if (php_sapi_name() === 'cli') {
            Forrest::authenticate();
            return;
        }

        if (!function_exists('session') || !session()->has("forrest_token")) {
            Forrest::authenticate();
        }
    }

    public function select(array $fields): self
    {
        $this->fields = $fields;
        return $this;
    }

    public function from(string $table): self
    {
        $this->table = $table;
        return $this;
    }


    public function where(array|string $conditions, string $boolean = "AND"): self
    {
        if (is_string($conditions)) {
            $this->conditions[] = [$boolean, $conditions];
            return $this;
        }

        if (isset($conditions[0]) && !is_array($conditions[0])) {
            $this->conditions[] = [$boolean, $this->buildCondition($conditions)];
            return $this;
        }

        $group = array_map(fn($cond) => $this->buildCondition($cond), $conditions);
        $this->conditions[] = [$boolean, "(" . implode(" $boolean ", $group) . ")"];

        return $this;
    }

    public function orWhere(array|string $conditions): self
    {
        return $this->where($conditions, "OR");
    }

    private function buildCondition(array|string $condition): string
    {
        if (is_string($condition)) {
            return $condition;
        }

        [$field, $operator, $value] = $condition;
        $operator = strtoupper($operator ?? '=');

        if (in_array($operator, ['IN','NOT IN']) && is_array($value)) {
            $sanitized = $this->sanitizeArray($value);
            return "$field $operator $sanitized";
        }

        $val = $this->sanitizeValue($value);
        return "$field $operator '$val'";
    }

    public function orderBy(string $field, string $direction = "ASC"): self
    {
        $this->orderBy = "$field $direction";
        return $this;
    }

    public function limit(int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }

    private function buildQuery(): string
    {
        if (!$this->table) {
            throw new \RuntimeException("Table not specified. Use from() method to set the table.");
        }

        $fields = !empty($this->fields) ? implode(", ", $this->fields) : "Id";
        $query = "SELECT $fields FROM {$this->table}";

        if (!empty($this->conditions)) {
            $clauses = [];
            foreach ($this->conditions as $index => [$boolean, $clause]) {
                if ($index === 0) {
                    $clauses[] = $clause;
                } else {
                    $clauses[] = "$boolean $clause";
                }
            }
            $query .= " WHERE " . implode(" ", $clauses);
        }

        if ($this->orderBy) {
            $query .= " ORDER BY {$this->orderBy}";
        }

        if ($this->limit) {
            $query .= " LIMIT {$this->limit}";
        }

        return $query;
    }

    public function execute(): array
    {
        $query = $this->buildQuery();
        $this->reset();
        return Forrest::query($query);
    }

    public function query(string $query): array
    {
        return Forrest::query($query);
    }

    public function object(string $object, array $options = []): mixed
    {
        return Forrest::sobjects($object, $options);
    }

    public function describe(string $object): array
    {
        return Forrest::sobjects("{$object}/describe");
    }

    public function custom(string $path, array $options = []): mixed
    {
        return Forrest::custom($path, $options);
    }

    public function uiObjectInfo(string $object): array {
        $version = config('forrest.defaults.version', 'v62.0');
        $path = "/services/data/{$version}/ui-api/object-info/{$object}";
        $res = Forrest::get($path);
        return is_array($res) ? $res : json_decode($res, true);
    }

    private function reset(): void
    {
        $this->fields = [];
        $this->table = null;
        $this->conditions = [];
        $this->orderBy = null;
        $this->limit = null;
    }
}