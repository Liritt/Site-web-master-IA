<?php

namespace App\Factory;

use App\Entity\Internship;
use App\Repository\InternshipRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Internship>
 *
 * @method        Internship|Proxy                     create(array|callable $attributes = [])
 * @method static Internship|Proxy                     createOne(array $attributes = [])
 * @method static Internship|Proxy                     find(object|array|mixed $criteria)
 * @method static Internship|Proxy                     findOrCreate(array $attributes)
 * @method static Internship|Proxy                     first(string $sortedField = 'id')
 * @method static Internship|Proxy                     last(string $sortedField = 'id')
 * @method static Internship|Proxy                     random(array $attributes = [])
 * @method static Internship|Proxy                     randomOrCreate(array $attributes = [])
 * @method static InternshipRepository|RepositoryProxy repository()
 * @method static Internship[]|Proxy[]                 all()
 * @method static Internship[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Internship[]|Proxy[]                 createSequence(array|callable $sequence)
 * @method static Internship[]|Proxy[]                 findBy(array $attributes)
 * @method static Internship[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Internship[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class InternshipFactory extends ModelFactory
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
            'beginDate' => self::faker()->dateTime(),
            'city' => self::faker()->text(20),
            'company' => CompanyFactory::new(),
            'endDate' => self::faker()->dateTime(),
            'studentsNumber' => self::faker()->randomNumber(),
            'subject' => self::faker()->text(800),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Internship $internship): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Internship::class;
    }
}
