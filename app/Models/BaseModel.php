<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Class BaseModel
 *
 * @package App\Model
 */
class BaseModel extends Model
{

    /**
     * Get an attribute from the model.
     *
     * @param string $key
     * @return mixed
     */
    public function getAttribute($key)
    {
        if (array_key_exists($key, $this->relations)) {
            return parent::getAttribute($key);
        } else {
            return parent::getAttribute(Str::snake($key));
        }
    }

    /**
     * Set a given attribute on the model.
     *
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    public function setAttribute($key, $value)
    {
        return parent::setAttribute(Str::snake($key), $value);
    }

    // Überschreibt Fill Funktion, damit Json-Attribute in snakeCase umgewandelt werden,
    // bevor sie in ein DB Objekt geschrieben werden
    public function fill(array $attributes)
    {
        foreach ($attributes as $key => $value) {
            $snakeCase = Str::snake($key);
            if ($snakeCase !== $key) {
                $attributes[$snakeCase] = $attributes[$key];
                unset($attributes[$key]);
            }
        }

        parent::fill($attributes);
    }
}
