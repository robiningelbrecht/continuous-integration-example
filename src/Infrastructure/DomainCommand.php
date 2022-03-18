<?php

namespace App\Infrastructure;

abstract class DomainCommand implements \JsonSerializable
{
    /**
     * @return array<mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'commandName' => get_called_class(),
            'payload' => $this->getSerializablePayload(),
        ];
    }

    /**
     * @return array<mixed>
     */
    protected function getSerializablePayload(): array
    {
        $serializedPayload = [];
        // @phpstan-ignore-next-line
        foreach ($this as $property => $value) {
            $serializedPayload[$property] = $value;
        }

        return $serializedPayload;
    }
}
