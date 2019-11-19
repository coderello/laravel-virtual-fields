<?php

namespace Coderello\VirtualFields\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;

class VirtualFieldMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:virtual-field';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new virtual field class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Virtual field';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/Stubs/VirtualField.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\VirtualFields';
    }
}
