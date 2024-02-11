<?php
namespace app\modules\v1\components\files;

use app\models\Files;
use PHPUnit\Framework\Constraint\FileExists;
use Yii;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class FileStorage
{

    public const BASE_PATH = '@app/uploads';

    public static function saveFile(UploadedFile $file)
    {
        $hash = Files::getHash($file->tempName);
        if ($fileModel = Files::findOne(['hash' => $hash ])) {
            return $fileModel;
        }
        $uploadDir = Yii::getAlias(self::BASE_PATH) . "/$hash/";

        if (FileHelper::createDirectory($uploadDir)) {
            $fileName = $file->baseName . '.' . $file->extension;
            $file->saveAs($uploadDir . $fileName);
            $fileModel = new Files();
            $fileModel->hash = $hash;
            $fileModel->name = $fileName;
            $fileModel->save();
            return $fileModel;
        } else {
            return false;
        }
    }

    public static function getFilePath($hash)
    {
        $path  = Yii::getAlias(self::BASE_PATH) . "/$hash/";
        $files = scandir($path);
        return $path.'/'.$files[2];
    }

}