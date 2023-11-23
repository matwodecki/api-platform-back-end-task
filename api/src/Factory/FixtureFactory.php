<?php

namespace App\Factory;

use App\Entity\Fixture;
use App\Enum\Status;
use Doctrine\ORM\EntityRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Fixture>
 *
 * @method        Fixture|Proxy                    create(array|callable $attributes = [])
 * @method static Fixture|Proxy                    createOne(array $attributes = [])
 * @method static Fixture|Proxy                    find(object|array|mixed $criteria)
 * @method static Fixture|Proxy                    findOrCreate(array $attributes)
 * @method static Fixture|Proxy                    first(string $sortedField = 'id')
 * @method static Fixture|Proxy                    last(string $sortedField = 'id')
 * @method static Fixture|Proxy                    random(array $attributes = [])
 * @method static Fixture|Proxy                    randomOrCreate(array $attributes = [])
 * @method static EntityRepository|RepositoryProxy repository()
 * @method static Fixture[]|Proxy[]                all()
 * @method static Fixture[]|Proxy[]                createMany(int $number, array|callable $attributes = [])
 * @method static Fixture[]|Proxy[]                createSequence(iterable|callable $sequence)
 * @method static Fixture[]|Proxy[]                findBy(array $attributes)
 * @method static Fixture[]|Proxy[]                randomRange(int $min, int $max, array $attributes = [])
 * @method static Fixture[]|Proxy[]                randomSet(int $number, array $attributes = [])
 */
final class FixtureFactory extends ModelFactory
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
            'brand' => self::faker()->word(),
            'model' => self::faker()->word(),
            'orderDate' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'serialNumber' => self::faker()->numerify('##########'),
            'status' => self::faker()->randomElement(Status::cases()),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Fixture $fixture): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Fixture::class;
    }
}
