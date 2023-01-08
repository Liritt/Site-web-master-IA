<?php

namespace App\Factory;

use App\Entity\TER;
use App\Repository\TERRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<TER>
 *
 * @method        TER|Proxy                     create(array|callable $attributes = [])
 * @method static TER|Proxy                     createOne(array $attributes = [])
 * @method static TER|Proxy                     find(object|array|mixed $criteria)
 * @method static TER|Proxy                     findOrCreate(array $attributes)
 * @method static TER|Proxy                     first(string $sortedField = 'id')
 * @method static TER|Proxy                     last(string $sortedField = 'id')
 * @method static TER|Proxy                     random(array $attributes = [])
 * @method static TER|Proxy                     randomOrCreate(array $attributes = [])
 * @method static TERRepository|RepositoryProxy repository()
 * @method static TER[]|Proxy[]                 all()
 * @method static TER[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static TER[]|Proxy[]                 createSequence(array|callable $sequence)
 * @method static TER[]|Proxy[]                 findBy(array $attributes)
 * @method static TER[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static TER[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class TERFactory extends ModelFactory
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
            'degree' => self::faker()->numberBetween(1, 2),
            'description' => self::faker()->text(2500),
            'title' => self::faker()->text(100),
            'date' => self::faker()->dateTime(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(TER $tER): void {})
        ;
    }

    protected static function getClass(): string
    {
        return TER::class;
    }
}
