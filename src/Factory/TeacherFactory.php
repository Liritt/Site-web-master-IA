<?php

namespace App\Factory;

use App\Entity\Teacher;
use App\Repository\TeacherRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Teacher>
 *
 * @method        Teacher|Proxy                     create(array|callable $attributes = [])
 * @method static Teacher|Proxy                     createOne(array $attributes = [])
 * @method static Teacher|Proxy                     find(object|array|mixed $criteria)
 * @method static Teacher|Proxy                     findOrCreate(array $attributes)
 * @method static Teacher|Proxy                     first(string $sortedField = 'id')
 * @method static Teacher|Proxy                     last(string $sortedField = 'id')
 * @method static Teacher|Proxy                     random(array $attributes = [])
 * @method static Teacher|Proxy                     randomOrCreate(array $attributes = [])
 * @method static TeacherRepository|RepositoryProxy repository()
 * @method static Teacher[]|Proxy[]                 all()
 * @method static Teacher[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Teacher[]|Proxy[]                 createSequence(array|callable $sequence)
 * @method static Teacher[]|Proxy[]                 findBy(array $attributes)
 * @method static Teacher[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Teacher[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class TeacherFactory extends UserFactory
{
    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        parent::__construct($userPasswordHasher);
    }

    protected function getDefaults(): array
    {
        $firstname = self::faker()->firstName();
        $lastname = self::faker()->lastName();
        $emailF = transliterator_transliterate('Any-Latin; Latin-ASCII', mb_strtolower($firstname));
        $emailL = transliterator_transliterate('Any-Latin; Latin-ASCII', mb_strtolower($lastname));

        return [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'birthdate' => self::faker()->dateTimeBetween('-65 years', '-30 years'),
            'email' => self::faker()->unique()->numerify($emailF.'.'.$emailL.'##').'@univ-reims.fr',
            'roles' => ['ROLE_TEACHER'],
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
        return Teacher::class;
    }
}
