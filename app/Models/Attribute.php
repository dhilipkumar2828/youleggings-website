<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model

{

    use HasFactory;

    protected $fillable=['attribute_type','value','created_by'];

    /**
     * Cast value to array and handle legacy serialized values.
     */
    // removed redundant $casts to avoid double handling with accessors

    public function getValueAttribute($value)
    {
        if (is_null($value) || $value === '' || (is_array($value) && empty($value))) {
            return [];
        }

        if (is_array($value)) {
            return $value;
        }

        // Handle legacy PHP serialized data (starts with a:)
        if (is_string($value) && preg_match('/^a:\\d+:/', $value)) {
            $un = @unserialize($value);
            if ($un !== false) {
                return (array)$un;
            }
        }

        // Potential double encoding check: decode recursively if it looks like a JSON string even after one decode
        $decoded = $value;
        while (is_string($decoded) && (strpos($decoded, '[') === 0 || strpos($decoded, '{') === 0 || strpos($decoded, '"') === 0)) {
            $prev = $decoded;
            $decoded = json_decode($decoded, true);
            if (json_last_error() !== JSON_ERROR_NONE || $decoded === $prev) {
                $decoded = $prev; // restore if decode failed or stalled
                break;
            }
        }

        // If after decoding we have an array, return it. 
        // If it's still a string (and not a JSON string), wrap it in an array if it was meant to be one.
        if (is_array($decoded)) {
            return $decoded;
        }

        return [$decoded]; // Wrap single string values in array for consistency
    }

    public function setValueAttribute($value)
    {
        $this->attributes['value'] = is_array($value) ? json_encode($value) : $value;
    }

}
