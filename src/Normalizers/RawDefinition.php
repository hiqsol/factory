<?php

declare(strict_types=1);

namespace Yiisoft\Factory\Normalizers;

final class RawDefinition
{
    public const TAGS = '__tags';
    public const DEFINITION = '__definition';

    private $raw;
    private $defintion = null;
    private array $tags;

    private function __construct($raw, array $tags)
    {
        $this->raw = $raw;
        $this->tags = $tags;
    }

    public function getTags(): array
    {
        return $this->tags;
    }

    public function getDefinition()
    {
        return $this->defintion ?? $this->raw;
    }

    public static function parse($definition): self
    {
        if (!is_array($definition)) {
            return new self($definition, []);
        }
        $tags = (array)($definition[self::TAGS] ?? []);
        unset($definition[self::TAGS]);

        return new self($definition[self::DEFINITION] ?? $definition, $tags);
    }
}
