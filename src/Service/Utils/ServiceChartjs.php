<?php

namespace App\Service\Utils;

use App\Entity\Depense;

class ServiceChartjs
{
    /**
     * param array<Depenses> $depensesByMonthByCategory
     */
    public function TransformToDataSet(array $depensesByMonthByCategory) : array 
    {
        $res = []; 
        foreach($depensesByMonthByCategory as $depense)
        {
            if( $depense instanceof Depense)
            {
                $current = [
                    'label' => $depense->getCategory()->getName(),
                    'backgroundColor' => 'rgb(255, 99, 132, .4)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => [2, 10, 5, 18, 20, 30, 45],
    
                ];
    
                $res[] = $current;
            }
        }

        return $res;
    }
}
