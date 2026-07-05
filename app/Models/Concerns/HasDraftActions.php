<?php

namespace App\Models\Concerns;

use Carbon\Carbon;

trait HasDraftActions
{
    /**
     * Publish the record.
     */
    public function publish(): void
    {
        $this->updateQuietly([
            'status' => 'published',
            'published_at' => $this->published_at ?? Carbon::now(),
        ]);
    }

    /**
     * Unpublish the record (revert to draft).
     */
    public function unpublish(): void
    {
        $this->updateQuietly([
            'status' => 'draft',
            'published_at' => null,
        ]);
    }
}
