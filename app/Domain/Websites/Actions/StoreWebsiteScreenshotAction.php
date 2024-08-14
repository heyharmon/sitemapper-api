<?php

namespace DDD\Domain\Websites\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use DDD\Domain\Websites\Website;
use DDD\App\Actions\GetScreenshotAction;

class StoreWebsiteScreenshotAction
{
    use AsAction;

    function handle(Website $website)
    {
        if (is_null($website->domain)) {
            return;
        }

        $screenshot = GetScreenshotAction::run($website->domain);

        $website->update([
            'screenshot_file_id' => $screenshot->id,
        ]);
    }
}
