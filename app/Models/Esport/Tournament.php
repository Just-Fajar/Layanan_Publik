<?php

namespace App\Models\Esport;

use App\Models\Tournament as BaseTournament;

/**
 * Alias for App\Models\Tournament
 * This exists for better organization and namespace clarity
 */
class Tournament extends BaseTournament
{
    protected static function newFactory()
    {
        return \Database\Factories\TournamentFactory::new();
    }
}
