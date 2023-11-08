<?php
namespace App\Data\Pipelines;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class UserNameFilter
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function handle($queryAndFilters , $next)
    {
        [$query, $filters] = $queryAndFilters;

        if (array_key_exists('name', $filters)) {
            $query->where('name',  'LIKE', '%' . $filters['name'] . '%');
        }

        return $next($query);
    }
}
