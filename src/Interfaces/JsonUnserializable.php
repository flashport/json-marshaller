<?php declare(strict_types=1);

namespace JsonMarshaller\Interfaces;

interface JsonUnserializable
{
    /**
     * @param string $json
     * @return mixed
     */
    public static function jsonUnserialize(string $json): mixed;
}