<?php

if (!function_exists('sort_url')) {
    function sort_url(string $column, string $currentSort = '', string $currentDirection = ''): string
    {
        $newDirection = 'asc';

        if ($currentSort === $column && strtolower($currentDirection) === 'asc') {
            $newDirection = 'desc';
        }

        // Mengembalikan URL dengan query parameter 'sort' dan 'direction' yang sudah di-update
        return request()->fullUrlWithQuery([
            'sort' => $column,
            'direction' => $newDirection,
        ]);
    }
}
