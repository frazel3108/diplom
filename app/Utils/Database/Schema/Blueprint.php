<?php

namespace App\Utils\Database\Schema;

use Illuminate\Database\Schema\Blueprint as LaravelBlueprint;

class Blueprint extends LaravelBlueprint
{
    /**
     * @param int|null $precision
     *
     * @return void
     */
    public function timestamps($precision = 0): void
    {
        $this->timestamp('created_at', $precision)->useCurrent();

        $this->timestamp('updated_at', $precision)->useCurrentOnUpdate()->nullable();
    }
}