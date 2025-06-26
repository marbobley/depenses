<?php

interface IDepenseMonth{
    /**
     * to sum on month
     */
    public function GetDepenseMonth(string $month, string $year) : float;
}