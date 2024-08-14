<?php

namespace DDD\Domain\Websites\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use DDD\Domain\Websites\Website;
use DDD\App\Actions\GetFaviconAction;

class StoreWebsiteFaviconAction
{
    use AsAction;

    function handle(Website $website)
    {
        if (is_null($website->domain)) {
            return;
        }

        $favicon = GetFaviconAction::run($website->domain);

        $website->update([
            'favicon_file_id' => $favicon->id,
        ]);
    }
}
