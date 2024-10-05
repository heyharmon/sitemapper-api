<?php

namespace DDD\App\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use DDD\Domain\Base\Files\Actions\StoreFileFromUrlAction;
use DDD\App\Services\Screenshot\ThumbioService;

class GetScreenshotAction
{
    use AsAction;

    public function __construct(
        protected ThumbioService $screenshotter,
    ) {}

    function handle(string $url)
    {
        try {
            $screenshotUrl = $this->screenshotter->getScreenshot('https://' . $url, '1200', '1200');

            $file = StoreFileFromUrlAction::run($screenshotUrl, 'screenshots');
    
            return $file;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
