<?php namespace JsonMarshaller\Processors\Traits;


use JsonMarshaller\Exceptions\InvalidFlagException;
use JsonMarshaller\JsonMarshallerFlags;
use ReflectionClass;

trait UsesFlags{

    /**
     * The array of flags available on the JsonMarshallerFlags class
     * @var array
     */
    protected array $flags;

    /**
     * @param string ...$flags
     * @return $this
     * @throws InvalidFlagException
     */
    public function setFlags(string ...$flags): static
    {
        foreach($flags as $flag){
            $this->addFlag($flag);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getFlags() : array
    {
        return $this->flags;
    }

    /**
     * @param string $flag
     * @return $this
     * @throws InvalidFlagException
     */
    public function addFlag(string $flag) : static
    {
        $this->validateFlag($flag);

        // Avoid duplication
        if(! $this->hasFlag($flag)){
            $this->flags[] = $flag;
        }

        return $this;
    }

    /**
     * @param string $flag
     * @return $this
     * @throws InvalidFlagException
     */
    public function removeFlag(string $flag) : static
    {
        $this->validateFlag($flag);

        if(! $this->hasFlag($flag)){
            return $this;
        }

        $this->flags = array_filter($this->flags, function($setFlag) use($flag){
            return $setFlag != $flag;
        });

        return $this;
    }

    /**
     * @param string $flag
     * @return bool
     */
    public function hasFlag(string $flag) : bool
    {
        return isset($this->flags) && in_array($flag, $this->flags);
    }

    /**
     * @param string $flag
     * @return bool
     */
    protected function isFlagValid(string $flag) : bool
    {
        $reflectionClass = new ReflectionClass(JsonMarshallerFlags::class);
        return in_array($flag, $reflectionClass->getConstants());
    }

    /**
     * @param string $flag
     * @return void
     * @throws InvalidFlagException
     */
    protected function validateFlag(string $flag) : void
    {
        if(! $this->isFlagValid($flag)){
            throw new InvalidFlagException("Flag $flag doesn't exist");
        }
    }
}