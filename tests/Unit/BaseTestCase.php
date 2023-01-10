<?php namespace Tests\Unit;

use JsonMarshaller\JSON;
use PHPUnit\Framework\TestCase;

abstract class BaseTestCase extends TestCase{

    protected JSON $JSON;

    public function setUp() : void
    {
        $this->JSON = new JSON();
    }

    /**
     * @param string $filename
     * @return string
     */
    protected function getJsonFile(string $filename) : string
    {
        $path = join(DIRECTORY_SEPARATOR, [dirname(__FILE__), "..", "Data", "Files", $filename]);
        $this->assertFileExists($path);
        return file_get_contents($path);
    }

}
