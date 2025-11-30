<?php

namespace App\Trait;

trait Filterable
{
    public function scopeFilter($query, array $filters)
    {
        foreach($filters as $field => $value)
        {
            // skip if value is null or empty
            if(is_null($value) || $value ==='')
            {
                continue;
            }
            // handle nested relationship filters (any depth)
            if (str_contains($field, '.')) {
                $this->applyRelationshipFilter($query, $field, $value);
                continue;
            }
             // Handle Null/Not null
            if(!is_array($value) && strtolower($value) === 'null')
            {
                $query->whereNull($field);
                continue;
            }
            if(!is_array($value) && (strtolower($value) === 'not_null' || strtolower($value) === 'notnull'))
            {
                $query->whereNotNull($field);
                continue;
            }
             // handle array with operators
            if (is_array($value))
            {
                $this->applyOperatorFilter($query, $field, $value);
                continue;
            }


            // default equality filter
            $query->where($field, $value);
        }
        return $query;
    }
    private function applyRelationshipFilter($query, string $field, $value): void
    {
        $parts = explode('.', $field);
        $fieldName = array_pop($parts); // Last part is the actual field name
        $relationPath = implode('.', $parts); // All other parts form the relation path
        // check is relation or join
        if(method_exists($this,$parts[0])){
            $query->whereHas($relationPath, function ($q) use ($fieldName, $value) {
                if (is_array($value)) {
                    $this->applyOperatorFilter($q, $fieldName, $value);
                } else {
                    // Handle special cases for nested fields too
                    if(strtolower($value) === 'null') {
                        $q->whereNull($fieldName);
                    } elseif(strtolower($value) === 'not_null' || strtolower($value) === 'notnull') {
                        $q->whereNotNull($fieldName);
                    } else {
                        $q->where($fieldName, $value);
                    }
                }
            });
        }else{
            $query->where("$parts[0].$fieldName",$value);
        }
    }
    private function applyOperatorFilter($query, string $field, array $value): void
    {
        $operator = strtolower($value[0]);
        $actualValue = $value[1] ?? null;
        switch($operator)
        {
            case '>':
            case '<':
            case '>=':
            case '<=':
            case '=':
            case '!=':
                $query->where($field, $operator, $actualValue);
                break;
            case 'like':
                $query->where($field, 'like', '%' . $actualValue . '%');
                break;
            case 'in':
                $query->whereIn($field, $actualValue);
                break;
            case 'notin':
            case 'not_in':
                $query->whereNotIn($field, $actualValue);
                break;
            case 'between':
                if (is_array($actualValue) && count($actualValue) === 2) {
                    $query->whereBetween($field, $actualValue);
                }
                break;
            case 'date':
                $query->whereDate($field, $actualValue);
                break;
            default:
                // If no operator matches, just use the value directly
                $query->where($field, $actualValue);
                break;
        }
    }

}
