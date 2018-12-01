<?php

namespace Launcher\Larachatter;

use Launcher\Larachatter\Setup\ProvidesScriptVariables;

class Larachatter
{
    use ProvidesScriptVariables;

    public static $version = '1.0.0-alpha';

    protected $models = [
        'user',
        'message',
    ];

    public function _construct()
    {
        foreach ($this->models as $model) {
            $this->models[$model] = config('larachatter.models.'.$model);
        }
    }

    public function model(string $name)
    {
        $class = strtolower($name);
        if (!in_array($class, $this->models)) {
            throw new \Exception("[{$class}] class not found.");
        }
        return app($this->models[$class]);
    }

    public function user()
    {
        return app($this->models['user']);
    }
}
