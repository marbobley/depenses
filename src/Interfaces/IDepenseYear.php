<?php
namespace App\Interfaces;

interface IDepenseYear{
    /**
     * To sum on year
     */
    public function GetDepenseYear($year) : float;
}