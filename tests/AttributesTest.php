<?php

namespace Laasti\Form\Tests;

class AttributesTest extends \PHPUnit_Framework_TestCase
{

    public function testAttributes()
    {
        $attributes = new \Laasti\Form\Attributes(['class' => 'some-class and another', 'data-dangerous' => ' \' " É;`¸<>?', 'data-array' => [0,1,2]]);
        //echo $attributes;
    }

}
