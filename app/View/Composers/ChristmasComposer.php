<?php

namespace App\View\Composers;

use Illuminate\View\View;

class ChristmasComposer
{
    /**
     * Check if Christmas theme should be active
     * 
     * @return bool
     */
    public function isChristmasActive(): bool
    {
        // Check environment variable first (manual override)
        if (env('CHRISTMAS_THEME_ENABLED', false)) {
            return true;
        }

        // Check if Christmas theme is disabled via env
        if (env('CHRISTMAS_THEME_DISABLED', false)) {
            return false;
        }

        // Automatically activate during December
        $currentMonth = (int) date('n');
        $currentDay = (int) date('j');
        
        // Active from December 1st to December 31st
        if ($currentMonth === 12) {
            return true;
        }

        // Early November activation for festive season (Nov 15–30)
        if ($currentMonth === 11 && $currentDay >= 15) {
            return true;
        }

        return false;
    }

    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('isChristmasActive', $this->isChristmasActive());
    }
}

