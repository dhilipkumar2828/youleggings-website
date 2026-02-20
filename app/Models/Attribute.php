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
                return $un;
            }
        }

        $decoded = json_decode($value, true);
        if (is_array($decoded)) {
            return $decoded;
        }

        // Fallback: return value as single-item array
        return [$value];
    }

    public function setValueAttribute($value)
    {
        $this->attributes['value'] = is_array($value) ? json_encode($value) : $value;
    }

}
