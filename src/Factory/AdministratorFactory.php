<?php

namespace App\Factory;

use App\Entity\Administrator;
use App\Repository\AdministratorRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Administrator>
 *
 * @method        Administrator|Proxy create(array|callable $attributes = [])
 * @method static Administrator|Proxy createOne(array $attributes = [])
 * @method static Administrator|Proxy find(object|array|mixed $criteria)
 * @method static Administrator|Proxy findOrCreate(array $attributes)
 * @method static Administrator|Proxy first(string $sortedField = 'id')
 * @method static Administrator|Proxy last(string $sortedField = 'id')
 * @method static Administrator|Proxy random(array $attributes = [])
 * @method static Administrator|Proxy randomOrCreate(array $attributes = [])
 * @method static AdministratorRepository|RepositoryProxy repository()
 * @method static Administrator[]|Proxy[] all()
 * @method static Administrator[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Administrator[]|Proxy[] createSequence(array|callable $sequence)
 * @method static Administrator[]|Proxy[] findBy(array $attributes)
 * @method static Administrator[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Administrator[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class AdministratorFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'email' => self::faker()->text(180),
            'password' => self::faker()->text(),
            'roles' => [],
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Administrator $administrator): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Administrator::class;
    }
}
