<?php

namespace app\api\modules\v1\components\offers;

class RawData
{
    /**
     * @var array
     */
    private $rawData = [];

    /**
     * @var array
     */
    public $dataTypes = [];

    public function __construct()
    {
        $this->dataTypes = [
            'post' => $_POST,
            'get' => $_GET,
            'cookie' => $_COOKIE,
            'server' => $_SERVER,
        ];
        return $this->rawData = json_encode($this->dataTypes);
    }

    public function getRawData()
    {
        return $this->rawData;
    }


    /**
     * Method saveRawData
     *
     * @param string $dir директория сохранения
     *
     * @return string
     */
    public function saveRawData(string $dir = '@raw')
    {
        $rawDataFile = \Yii::getAlias($dir) . DIRECTORY_SEPARATOR . \Yii::$app->getSecurity()->generateRandomString(32) . '.rjsn';
        \Yii::info('Получены данные: ' . $this->rawData, 'offers');
        \Yii::info('Сохраняются в файл: ' . $rawDataFile, 'offers');
        $result = file_put_contents($rawDataFile, $this->rawData);
        if (!$result) {
            \Yii::warning('Не получилось сохранить сырые данные запроса в файл: ' . $rawDataFile, 'offers');
            \Yii::warning($result, 'offers');
        }
        return \yii\helpers\FileHelper::normalizePath($rawDataFile);
    }
}
