<?php

declare(strict_types=1);

namespace Yiisoft\Factory\Definitions;

use Yiisoft\Factory\Exceptions\InvalidConfigException;

/**
 * Normalizer normalizes i.e. validates and converts raw definition
 * into a resolvable `DefinitionInterface`.
 */
interface NormalizerInterface
{
    /**
     * Definition may be defined multiple ways.
     * Interface name as string:
     *
     * ```php
     * $container->set('interface_name', EngineInterface::class);
     * ```
     *
     * A closure:
     *
     * ```php
     * $container->set('closure', function($container) {
     *     return new MyClass($container->get('db'));
     * });
     * ```
     *
     * A callable array:
     *
     * ```php
     * $container->set('static_call', [MyClass::class, 'create']);
     * ```
     *
     * A definition array:
     *
     * ```php
     * $container->set('full_definition', [
     *     '__class' => EngineMarkOne::class,
     *     '__construct()' => [42],
     *     'argName' => 'value',
     *     'setX()' => [42],
     * ]);
     * ```
     *
     * @param mixed $definition
     * @param string $id
     * @param array $params
     * @throws InvalidConfigException
     */
    public function normalize($definition, string $id = null, array $params = []): DefinitionInterface;

    /**
     * Validates defintion for corectness.
     * @param mixed $definition @see normalize()
     * @param bool $id
     * @return bool
     * @throws InvalidConfigException
     */
    public function parse($definition, bool $throw = true): RawDefinition;
}
