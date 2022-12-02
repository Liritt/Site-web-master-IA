<?php

namespace App\Factory;

use App\Entity\Company;
use App\Repository\CompanyRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Company>
 *
 * @method        Company|Proxy create(array|callable $attributes = [])
 * @method static Company|Proxy createOne(array $attributes = [])
 * @method static Company|Proxy find(object|array|mixed $criteria)
 * @method static Company|Proxy findOrCreate(array $attributes)
 * @method static Company|Proxy first(string $sortedField = 'id')
 * @method static Company|Proxy last(string $sortedField = 'id')
 * @method static Company|Proxy random(array $attributes = [])
 * @method static Company|Proxy randomOrCreate(array $attributes = [])
 * @method static CompanyRepository|RepositoryProxy repository()
 * @method static Company[]|Proxy[] all()
 * @method static Company[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Company[]|Proxy[] createSequence(array|callable $sequence)
 * @method static Company[]|Proxy[] findBy(array $attributes)
 * @method static Company[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Company[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class CompanyFactory extends UserFactory
{
    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        parent::__construct($userPasswordHasher);
    }

    protected function getDefaults(): array
    {
        $firstname = self::faker()->firstName();
        $lastname = self::faker()->lastName();
        $company = self::faker()->text(15);
        $emailF = transliterator_transliterate('Any-Latin; Latin-ASCII', mb_strtolower($firstname));
        $emailL = transliterator_transliterate('Any-Latin; Latin-ASCII', mb_strtolower($lastname));

        return [
            'company_name' => $company,
            'supervisor_firstname' => $firstname,
            'supervisor_lastname' => $lastname,
            'email' => self::faker()->unique()->numerify($emailF . '.' . $emailL . '##').'@' . $company . '.fr',
            'roles' => [],
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
        return Company::class;
    }
}
