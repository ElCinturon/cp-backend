<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Class BaseModel
 *
 * @package App\Model
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel query()
 * @mixin \Eloquent
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

    // Sorgt dafür, dass beim Abruf des Arrays der Models die Keys immer CamelCase sind.
    public function toArray()
    {
        $array = parent::toArray();

        // Alle attribute in camelCase umwandeln
        return $this->setKeysCamelCaseRecursive($array);
    }

    // Setzt alle Keys eines Arrays rekursiv als CamelCase. Rückgabe enthält ein neues Array 
    private function setKeysCamelCaseRecursive(array $array)
    {
        $result = [];
        foreach ($array as $key => $value) {
            // Wenn Value Array ist, dessen Werte durchlaufen und zurückgeben
            if (is_array($value)) {
                $result[Str::camel($key)] = $this->setKeysCamelCaseRecursive($value);
            } else {
                // Neuen Key im Camel-Case setzen und alten verwerfen
                $result[Str::camel($key)] = $value;
            }
        }
        return $result;
    }
}
