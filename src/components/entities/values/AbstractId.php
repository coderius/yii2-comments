<?php

namespace coderius\comments\components\entities\values;

use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

abstract class AbstractId
{
    protected $id;

    private function __construct(UuidInterface $id)
    {
        $this->id = $id;
    }

    public static function fromString(string $id)
    {
        try {
            return new static(Uuid::fromString($id));
        } catch (InvalidUuidStringException $exception) {
            throw new InvalidIdentityException($id);
        }
    }

    public static function next()
    {
        return new static(Uuid::uuid4());
    }

    public function getId()
    {
        return $this->id->toString();
    }

    public function equalTo(AbstractId $id)
    {
        return $this->getId() === $id->getId();
    }

    public function __toString()
    {
        return $this->getId();
    }
}