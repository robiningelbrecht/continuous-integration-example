<?php

namespace App\Domain\Order;

use Ramsey\Uuid\Uuid;

class OrderId implements \Stringable
{
    private function __construct(
        private string $identifier
    ) {
        $this->validate($identifier);
    }

    public static function getPrefix(): string
    {
        return 'order-';
    }

    protected function validate(string $identifier): void
    {
        if (empty($identifier)) {
            throw new \InvalidArgumentException(get_called_class().' cannot be empty');
        }
        if (!str_starts_with($identifier, self::getPrefix())) {
            throw new \InvalidArgumentException('Identifier does not start with prefix "'.$this->getPrefix().'", got: '.$identifier);
        }
    }

    public function __toString()
    {
        return $this->identifier;
    }

    public static function random(): OrderId
    {
        return new self(self::getPrefix().Uuid::uuid4()->toString());
    }

    public static function fromString(string $identifier): OrderId
    {
        return new self($identifier);
    }
}
