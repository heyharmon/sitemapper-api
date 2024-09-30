<?php

namespace DDD\App\Services\Screenshot;

use DDD\App\Services\Screenshot\ScreenshotInterface;

class ThumbioService
{
    protected $token;

    public function __construct()
    {
        $this->token = config('services.thumio.token');
    }
    
    /**
     * Take a screenshot
     * 
     * Docs: https://www.thum.io/documentation/api/url
     * Test URL: https://image.thum.io/get/width/1200/crop/1200/png/noanimate/wait/3/https://www.google.com
     */
    public function getScreenshot(string $url, string $width = '1400', string $height = '1200')
    {
        return 'https://image.thum.io/get/auth/' . $this->token . '/width/' . $width . '/crop/' . $height . '/png/noanimate/wait/5/' . $url;
    }
}
