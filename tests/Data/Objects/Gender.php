<?php declare(strict_types=1);

namespace Tests\Data\Objects;

enum Gender: string{
    
    case FEMALE = "female";
    case MALE = "male";
    case NON_BINARY = "non-binary";
    case OTHER = "other";
    
}