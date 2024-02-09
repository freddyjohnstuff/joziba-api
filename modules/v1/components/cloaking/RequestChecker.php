<?php


namespace app\api\modules\v1\components\cloaking;

use app\api\modules\v1\components\logs\LoggingInterface;
use app\api\modules\v1\components\logs\TrackComponent;
use app\api\modules\v1\components\tracker\Tracker;
use app\models\Campaigns;
use app\models\CampaignsKeys;
use Curl\Curl;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use yii\web\Request;

class RequestChecker
{
    protected const BOT_URL = 'https://www.google.com';
    protected const TRAFFIC_ARMOR = 'https://bot.com';

    protected Request $request;
    protected LoggingInterface $logger;
    protected Campaigns $company;

    public function __construct(LoggingInterface $logger, Request $request)
    {
        $this->request = $request;
        $this->logger = $logger;
    }

    public function run() : string
    {
        try {
            $this->logger->log('status.start', time());
            $this->logger->log('enter.url', $this->request->getUrl());
            $this->company = $this->getCompanyData();
            $this->filterByCountry();
            $this->filterByDevice();
            $this->filterByInternalSettings();
            $this->checkByTrafficArmor();
            $urlByBinom = $this->getUrlByBinom();
            $this->logger->commit();
            return $urlByBinom;
        } catch (\Exception $e) {
            $this->logger->commit();
            \Yii::error($e->getMessage());
            return self::BOT_URL;
        }
    }

    /**
     * @return Campaigns
     * @throws Exception
     */
    public function getCompanyData()
    {
        $key = $this->request->get('key');
        $this->logger->log('incoming_key', $key);
        $companyKey = CampaignsKeys::findOne(['campaing_key' => $key]);
        $company = Campaigns::findOne($companyKey->campaign_id ?? null);
        if ($company) {
            return $company;
        } else {
            $this->logger->log('db.company.error', 'Cannot retrieve data of manager by key: ' . $key);
            throw new Exception('Company not found by key ' . $key);
        }
    }

    /**
     * @return mixed
     */
    public function filterByCountry()
    {
        $countryCodes = ArrayHelper::map((array)$this->company->filterByCountry, 'id', 'country_code');
        $ip = $this->request->getUserIP();
        $this->logger->log('ip', $ip);
        $this->logger->log('ua', $this->request->getUserAgent());
        $this->logger->log('referer', $this->request->getReferrer());
        $country = DataService::getCountry(trim($ip));
        $this->logger->log('country', $country);
        if (in_array($country, $countryCodes)) {
            return true;
        } else {
            throw new Exception('Country not matches');
        }
    }

    public function filterByDevice()
    {
        $browserHelper = new BrowserHelper($this->request->getUserAgent());
        $browser = $browserHelper->getBrowserWithVersion();
        $os = $browserHelper->getPlatform();
        $this->logger->log('os', $os);
        $this->logger->log('browser', $browser);
        $this->validateUserAgent($this->request->getUserAgent());
    }

    public function filterByInternalSettings()
    {
        $ip = $this->request->getUserIP();
        if (strpos($ip, ':') !== false) {
            $IPPPv4 = '';
            $IPPPv6 = $ip;
        } else {
            $IPPPv4 = $ip;
            $IPPPv6 = '';
        }
        $userAgent = $this->request->getUserAgent();
        $browserHelper = new BrowserHelper($userAgent);
        $blockingClaass = new BlockingComponent([
//            'ASN' => $this->cache['asn'], ??
            'UserAgent' => $userAgent,
            'OS' => $browserHelper->getPlatform(),
            'IPv6'  => $IPPPv6,
            'IPv4'  => $IPPPv4,
            'Browser' => $browserHelper->getBrowserWithVersion(),
//            'ISP' => $this->cache['ISP'] ??
        ]);
        if ($blockingClaass->block(true)) {
            throw new Exception('Block by internal rules');
        }
    }
    
    
    protected function getUrlByBinom() : string
    {
        TrackComponent::getInstance()->log('company_key', $this->request->get('key'));
        TrackComponent::getInstance()->log('phpsessid', $this->request->cookies->getValue('PHPSESSID'));
        /**
         * @var $tracker Tracker
         */
        $tracker = \Yii::$app->tracker;
        $params = [
            'lp_type' => 'click_info',
            'id' => $this->company->binom_id,
        ];
        $result = $tracker->getCompany($params);
        if ($result['status'] == 'true' && isset($result['offer']) && isset($result['offer']['url'])) {
            $logClickData = [
                'uclick' => $result['uclick'],
                'clickid' => $result['clickid'],
                'offerurl' => $result['offer']['url'],
            ];
            $this->logger->log('binom.api.clickData', $logClickData);
            TrackComponent::getInstance()->log('uclick', $result['uclick']);
            TrackComponent::getInstance()->log('url', $result['offer']['url']);
            TrackComponent::getInstance()->log('click_id', $result['clickid']);
            TrackComponent::getInstance()->log('ip', $this->request->getUserIP());
            TrackComponent::getInstance()->commit(true);
            $this->logger->log('binom.offer.url', $result['offer']['url']);
            $this->logger->log('binom.result', true);
            return $result['offer']['url'];
        } else {
            if ($result['status'] == 'error') {
                $this->logger->log('binom.result', false);
                $this->logger->log('binom.api.error', $result['error']);
            } else {
                $this->logger->log('binom.result', false);
                $this->logger->log('binom.api.error', 'Empty click data');
            }
            TrackComponent::getInstance()->commit(true);
            throw new Exception('Error get data from Binom');
        }
    }

    public function validateUserAgent($userAgent)
    {
        foreach (UserAgentHelper::getGoogleUserAgents() as $botUserAgent) {
            if (stripos($userAgent, $botUserAgent) !== false) {
                throw new Exception('Fail check by user agent');
            }
        }
    }

    public function checkByTrafficArmor()
    {
        $this->logger->log('checkByTrafficArmor', true);
        $payload = [
            'visitor' => [
                'remote_addr' => $this->request->getUserIP(),
                'v' => 4,
                'xi' => 1,
                'lp_url' => $this->request->getReferrer(), //???
                'referrer' => $_SERVER['HTTP_REFERER'] ?? '',
            ],
            'browser_headers' => $this->browserHeaders(),
        ];

        try {
            $curl = new Curl();
            $curl->setOpts(
                [
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
                    CURLOPT_USERAGENT => $this->request->getUserAgent(),
                    CURLOPT_SSL_VERIFYHOST => 0,
                    CURLOPT_SSL_VERIFYPEER => 0,
                    CURLOPT_ENCODING => "",
                ]
            );
            $curl->setHeaders([
                'Content-type' => 'application/json'
            ]);
            $curl->post(\Yii::$app->params['traffic_armor_api_url'], $payload);
            
            $responseData = $curl->getResponse();
        } catch (\Exception $e) {
            \Yii::error($e->getMessage());
            $responseData = 'Response error';
        }
        $this->logger->log('TrafficArmorScope', \yii\helpers\Json::encode($responseData));
        $url = $responseData->url ?? null;
        $isBot = !$url || $url == self::TRAFFIC_ARMOR;
        if ($isBot) {
            $this->logger->log('TrafficArmorCheckResult', 'bot');
            throw new Exception('Is Bot');
        }
        $this->logger->log('TrafficArmorCheckResult', 'real');
        return $responseData;
    }

    private function browserHeaders()
    {
        $headers = [];

        foreach ($_SERVER as $name => $value) {
            if (preg_match('/^HTTP_/', $name)) {
                $name = strtr(substr($name, 5), '_', '-');
                $name = strtolower($name);
                $headers[$name] = $value;
            }
        }

        return $headers;
    }

    public function saveLogs()
    {
        $this->logger->commit();
    }
}
