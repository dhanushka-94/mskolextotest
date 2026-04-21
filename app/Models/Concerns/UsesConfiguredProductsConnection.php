<?php

namespace App\Models\Concerns;

trait UsesConfiguredProductsConnection
{
    /**
     * Allow product-side models to use a configurable DB connection.
     */
    public function initializeUsesConfiguredProductsConnection(): void
    {
        $configured = config('database.products_model_connection')
            ?: env('PRODUCTS_MODEL_CONNECTION')
            ?: 'products_db';

        $this->setConnection($configured);
    }
}
