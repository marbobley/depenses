<?php

namespace App\Factory;

use App\Entity\Family;
use App\Service\HasherService;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Family>
 */
final class FamilyFactory extends PersistentProxyObjectFactory
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
        return Family::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        $hasher = new HasherService();
        $hashPassword = $hasher->hash('123456');

        return [
            'name' => self::faker()->unique()->word(),
            'password' => $hashPassword,
            'mainMember' => UserFactory::random(),
            'members' => UserFactory::randomSet(self::faker()->numberBetween(1, 10)),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Family $family): void {})
        ;
    }
}
