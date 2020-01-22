<?php
namespace App\Services\FeedReader;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ItemsCollection extends Collection
{
    private $defaultPerPage = 15;

    /**
     * Set pagination option for collection
     *
     * @param int $perPage
     * @param null $total
     * @param int $page
     * @param string $pageName
     * @return LengthAwarePaginator
     */
    public function paginate($perPage = 15, $total = null, $page = null, $pageName = 'page'): LengthAwarePaginator
    {
        $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);
        $perPage = $perPage ?: $this->defaultPerPage;

        return new LengthAwarePaginator(
            $this->forPage($page, $perPage),
            $total ?: $this->count(),
            $perPage,
            $page,
            [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'pageName' => $pageName,
            ]
        );
    }
}
