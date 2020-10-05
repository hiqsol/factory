<?php

declare(strict_types=1);

namespace Yiisoft\Factory\Normalizers;

use Yiisoft\Factory\Exceptions\InvalidConfigException;
use League\Container\Definition\DefinitionInterface;
use Yiisoft\Factory\Definitions\ArrayDefinition;
use Yiisoft\Factory\Definitions\Reference;
use Yiisoft\Factory\Definitions\CallableDefinition;
use Yiisoft\Factory\Definitions\ValueDefinition;

/**
 * Simple normalizer allows any definitions including definition objects and any scalars.
 */
class SimpleNormalizer implements NormalizerInterface
{
    public static function normalize($definition, string $id = null, array $params = []): DefinitionInterface
    {
        if ($definition instanceof DefinitionInterface) {
            return $definition;
        }

        if (\is_string($definition)) {
            if ($id === $definition || (!empty($params) && class_exists($definition))) {
                return ArrayDefinition::fromArray($definition, $params);
            }
            return Reference::to($definition);
        }

        if (\is_callable($definition)) {
            return new CallableDefinition($definition);
        }

        if (\is_array($definition)) {
            return ArrayDefinition::fromArray($id, [], $definition);
        }

        if (\is_object($definition)) {
            return new ValueDefinition($definition);
        }

        throw new InvalidConfigException('Invalid definition:' . var_export($definition, true));
    }

    /**
     * Validates defintion for corectness.
     * @param mixed $definition @see normalize()
     * @param bool $id
     * @return bool
     * @throws InvalidConfigException
     */
    public static function validate($definition, bool $throw = true): bool
    {
        if ($definition instanceof DefinitionInterface) {
            return true;
        }

        if (\is_string($definition)) {
            return true;
        }

        if (\is_callable($definition)) {
            return true;
        }

        if (\is_array($definition)) {
            return true;
        }

        if (\is_object($definition)) {
            return true;
        }

        if ($throw) {
            throw new InvalidConfigException('Invalid definition:' . var_export($definition, true));
        }

        return false;
    }
}
