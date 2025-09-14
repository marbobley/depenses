<?php

namespace App\Service\Business;

use App\Entity\User;
use App\Interfaces\IDepenseMonth;
use App\Interfaces\IDepenseYear;
use App\Service\Entity\ServiceCategoryEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * Service to get user depense.
 */
class ServiceDepenseCategory 
{
    public function __construct(
        private Security $security,
        private ServiceDepense $serviceDepense,
        private ServiceCategoryEntity $serviceCategoryEntity
    ) {}

    public function getDepenseByCategory(int $idCategory): ?array
    {
        if (!$this->serviceCategoryEntity->IsExistingCategory($idCategory)) {
            return [];
        }

        $category = $this->serviceCategoryEntity->GetCategoryById($idCategory);
        $allDepenseCategory = $category->getDepenses();

        return $allDepenseCategory->toArray();
    }
}
