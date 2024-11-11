<?php

namespace Forge\Concerns;

trait HasStubs
{

    abstract public function name(): string;

    /**
     * @param array<int,mixed> $parameters
     */
    public function renderStub(string $name, array $parameters): string
    {
        return view(sprintf('%s::%s', self::name(), $name), $parameters);
    }

}
