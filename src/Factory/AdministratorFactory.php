<?php

namespace App\Factory;

use App\Entity\Administrator;
use App\Repository\AdministratorRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
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
final class AdministratorFactory extends UserFactory
{
    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        parent::__construct($userPasswordHasher);
    }

    protected function getDefaults(): array
    {
        return [
            'email' => self::faker()->unique()->numerify('admin-####').'@univ-reims.fr',
            'roles' => ['ROLE_ADMIN'],
            'password' => 'test',
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return parent::initialize();
    }

    protected static function getClass(): string
    {
        return Administrator::class;
    }
}
