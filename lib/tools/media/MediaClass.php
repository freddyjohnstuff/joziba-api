<?php

namespace app\lib\tools\media;

use app\lib\tools\clients\ClientTools;
use app\lib\tools\files\FilesTools;
use app\models\Media;

final class MediaClass
{

    private static ?MediaClass $instance = null;

    /**
     * @return MediaClass
     */
    public static function getInstance(): MediaClass
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /*
     * multiple construct, clone, wakeup,
     */
    private function __construct() {}
    private function __clone() {}
    private function __wakeup() {}



    public function getMediaList($id, $entity = 'ads') {

        /**
         *  * @property int $id
         * @property string|null $target_entity ads,category,client
         * @property int|null $target_id
         * @property string|null $media_url
         * @property string|null $media_path
         * @property string|null $created_at
         * @property int $client_id
         */
        $media = Media::find()
            ->select(['id', 'target_entity', 'target_id', 'media_url'])
            ->where([
                'AND',
                ['target_entity' => $entity],
                ['target_id' => $id ]
            ])
            ->all();

        if (empty($media)) {
            return null;
        }
        return $media;

    }

    public function createMediaList( $id, $entity = 'ads', $key = 'images') {
        global $_FILES;
        $files = $_FILES[$key];

        if(empty($files)) {
            return 0;
        }

        $files = FilesTools::getInstance()->remapFileArr($files);
        if (array_search($entity, ['ads', 'category', 'client']) !== false) {
            $target = $entity;
        } else {
            $target = 'others';
        }

        $imagesCNT = 0;
        if (count($files) > 0) {
            foreach ($files as $file) {
                $media = new Media();
                $media->target_entity = $target;
                $media->target_id = $id;
                $media->client_id = ClientTools::getInstance()->getCurrentClientId();
                $media->file_name = $file['name'];
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $name = md5($target . $id . date('Ymdhis') . time()) . '.' . $ext;

                if (move_uploaded_file($file['tmp_name'],\Yii::getAlias('@upload') . '/' . $name)) {
                    $media->media_path = \Yii::getAlias('@upload') . '/' . $name;
                    $media->media_url = 'http://' . env('PROJECT_DOMAIN') . '/uploads/' . $name;
                    $media->save();
                    $imagesCNT++;
                }
            }
        }

        return $imagesCNT;
    }

}