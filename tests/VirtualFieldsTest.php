<?php

namespace Coderello\VirtualFields\Tests;

use Coderello\VirtualFields\VirtualFields;
use Illuminate\Contracts\Support\Arrayable;
use stdClass;

class VirtualFieldsTest extends AbstractTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testTrue()
    {
        $this->assertTrue(true);
    }
}
