<?php

namespace App\Overwrites\Illuminate\Pagination;

use Illuminate\Pagination\LengthAwarePaginator as LaraLengthAwarePaginator;
use Illuminate\Support\Arr;

class LengthAwarePaginator extends LaraLengthAwarePaginator
{
    /**
     * Get the URL for a given page number.
     *
     * @param  int  $page
     * @return string
     */
    public function url($page)
    {
        if ($page <= 0) {
            $page = 1;
        }

        // If we have any extra query string key / value pairs that need to be added
        // onto the URL, we will put them in query string form and then attach it
        // to the URL. This allows for extra information like sortings storage.
        $parameters = $page == 1 ? [] : [$this->pageName => $page];

        if (count($this->query) > 0) {
            $parameters = array_merge($this->query, $parameters);
        }

        $query = '';
        if (count($parameters) > 0) {
            $query = (str_contains($this->path(), '?') ? '&' : '?') . Arr::query($parameters);
        }

        return $this->path()
                        .$query
                        .$this->buildFragment();
    }

    /**
     * Get the base path for paginator generated URLs.
     *
     * @return string|null
     */
    public function path()
    {
        $referer = request()->headers->get('referer');

        if (
            str_starts_with(request()->path(), 'api/')
            && !is_null($referer)
        ) {
            $path = parse_url($referer, PHP_URL_PATH);
        } else {
            $path = $this->path;
        }

        return str_ends_with($path, '/') ? $path : ($path . '/');
    }
}