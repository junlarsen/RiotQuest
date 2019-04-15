<?php

namespace RiotQuest\Components\Framework\Mock;

use RiotQuest\Components\Framework\Engine\Library;

class Mock
{

    /**
     * Directory path to mocks
     *
     * @var string
     */
    private static $path = __DIR__ . '/../../../../mocks';

    /**
     * Creates a collection mock from mocked data.
     *
     * @param string $mock
     * @return mixed
     */
    public static function createCollectionMock(string $mock)
    {
        $file = json_decode(file_get_contents(static::$path . "/Collections/$mock.json"));

        return Library::traverse($file, Library::loadTemplate($mock), 'euw1');
    }

}
