<?php namespace Tests\Unit\General;

use JsonMarshaller\Exceptions\InvalidFlagException;
use JsonMarshaller\JsonMarshallerFlags;
use JsonMarshaller\Processors\Marshaller;
use JsonMarshaller\Processors\Unmarshaller;
use ReflectionClass;
use Tests\Unit\BaseTestCase;

class FlagsTest extends BaseTestCase{

    /**
     * @return array
     */
    protected function getAvailableFlags() : array
    {
        return (new ReflectionClass(JsonMarshallerFlags::class))->getConstants();
    }

    /**
     * @test
     * @return void
     * @throws InvalidFlagException
     */
    public function it_manipulates_flags(): void
    {

        $availableFlags = $this->getAvailableFlags();

        // Flags set on constructor
        $marshaller = new Marshaller(...$availableFlags);
        $unmarshaller = new Unmarshaller(...$availableFlags);


        foreach($availableFlags as $availableFlag){
            $this->assertTrue($marshaller->hasFlag($availableFlag));
            $this->assertTrue($unmarshaller->hasFlag($availableFlag));
        }

        $firstFlag = $availableFlags[array_key_first($availableFlags)];

        // Flag removed
        $marshaller->removeFlag($firstFlag);
        $this->assertFalse($marshaller->hasFlag($firstFlag));

        $unmarshaller->removeFlag($firstFlag);
        $this->assertFalse($unmarshaller->hasFlag($firstFlag));

        // Flag added
        $marshaller->addFlag($firstFlag);
        $this->assertTrue($marshaller->hasFlag($firstFlag));

        $unmarshaller->addFlag($firstFlag);
        $this->assertTrue($unmarshaller->hasFlag($firstFlag));

        // Flag duplication
        $this->assertEquals($marshaller->getFlags(), $marshaller->addFlag($firstFlag)->getFlags());
        $this->assertEquals($unmarshaller->getFlags(), $unmarshaller->addFlag($firstFlag)->getFlags());
    }

    /**
     * @test
     * @return void
     */
    public function it_fails_to_add_invalid_flag(): void
    {
        $this->expectException(InvalidFlagException::class);
        new Marshaller("invalid_flag");
        new Unmarshaller("invalid_flag");
    }
}