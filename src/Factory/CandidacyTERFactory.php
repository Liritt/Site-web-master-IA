<?php

namespace App\Factory;

use App\Entity\CandidacyTER;
use App\Repository\CandidacyTERRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<CandidacyTER>
 *
 * @method        CandidacyTER|Proxy create(array|callable $attributes = [])
 * @method static CandidacyTER|Proxy createOne(array $attributes = [])
 * @method static CandidacyTER|Proxy find(object|array|mixed $criteria)
 * @method static CandidacyTER|Proxy findOrCreate(array $attributes)
 * @method static CandidacyTER|Proxy first(string $sortedField = 'id')
 * @method static CandidacyTER|Proxy last(string $sortedField = 'id')
 * @method static CandidacyTER|Proxy random(array $attributes = [])
 * @method static CandidacyTER|Proxy randomOrCreate(array $attributes = [])
 * @method static CandidacyTERRepository|RepositoryProxy repository()
 * @method static CandidacyTER[]|Proxy[] all()
 * @method static CandidacyTER[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static CandidacyTER[]|Proxy[] createSequence(array|callable $sequence)
 * @method static CandidacyTER[]|Proxy[] findBy(array $attributes)
 * @method static CandidacyTER[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static CandidacyTER[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class CandidacyTERFactory extends ModelFactory
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
            'date' => self::faker()->dateTime(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(CandidacyTER $candidacyTER): void {})
        ;
    }

    protected static function getClass(): string
    {
        return CandidacyTER::class;
    }
}
