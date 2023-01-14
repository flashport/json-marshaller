<?php namespace Tests\Unit;

use JsonMarshaller\JsonMarshaller;
use PHPUnit\Framework\TestCase;

abstract class BaseTestCase extends TestCase
{

    protected JsonMarshaller $jsonMarshaller;

    public function setUp(): void
    {
        $this->jsonMarshaller = new JsonMarshaller();
    }

    /**
     * @param string $filename
     * @return string
     */
    protected function getJsonFile(string $filename): string
    {
        $path = join(DIRECTORY_SEPARATOR, [dirname(__FILE__), "..", "Data", "Files", $filename]);
        $this->assertFileExists($path);
        return file_get_contents($path);
    }

}
