<?php

namespace App\Factory;

use App\Entity\Depense;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Depense>
 */
final class DepenseFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return Depense::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'amount' => self::faker()->randomFloat(),
            'created' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'name' => self::faker()->text(255),
            'createdBy' => UserFactory::random(), 
            'category' => CategoryFactory::random(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Depense $depense): void {})
        ;
    }
}
