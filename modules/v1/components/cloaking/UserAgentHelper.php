<?php


namespace app\api\modules\v1\components\cloaking;

class UserAgentHelper
{
    public static function getGoogleUserAgents()
    {
        return [
            'bot',
            'APIs-Google',
            'Mediapartners-Google',
            'AdsBot-Google-Mobile',
            'AdsBot-Google',
            'Googlebot',
            'Googlebot-Image',
            'Googlebot-News',
            'Googlebot-Video',
            'AdsBot-Google-Mobile-Apps',
            'FeedFetcher-Google',
            'Google-Read-Aloud',
            'googleweblight',
            'Google Favicon',
            'DuplexWeb-Google'
        ];
    }
}
