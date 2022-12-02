<?php

namespace App\Factory;

use App\Entity\Student;
use App\Repository\StudentRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Student>
 *
 * @method        Student|Proxy create(array|callable $attributes = [])
 * @method static Student|Proxy createOne(array $attributes = [])
 * @method static Student|Proxy find(object|array|mixed $criteria)
 * @method static Student|Proxy findOrCreate(array $attributes)
 * @method static Student|Proxy first(string $sortedField = 'id')
 * @method static Student|Proxy last(string $sortedField = 'id')
 * @method static Student|Proxy random(array $attributes = [])
 * @method static Student|Proxy randomOrCreate(array $attributes = [])
 * @method static StudentRepository|RepositoryProxy repository()
 * @method static Student[]|Proxy[] all()
 * @method static Student[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Student[]|Proxy[] createSequence(array|callable $sequence)
 * @method static Student[]|Proxy[] findBy(array $attributes)
 * @method static Student[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Student[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class StudentFactory extends UserFactory
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
            'birthdate' => self::faker()->dateTimeBetween('-30 years', '-21 years'),
            'email' => self::faker()->unique()->numerify($emailF . '.' . $emailL . '##').'@etudiant.univ-reims.fr',
            'degree' => self::faker()->randomElement([1, 2]),
            'roles' => [],
            'password' => 'test',
            'cv' => self::faker()->text(100),
            'certificate' => self::faker()->text(100),
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
        return Student::class;
    }
}
