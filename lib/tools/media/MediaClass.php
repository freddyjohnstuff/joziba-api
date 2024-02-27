<?php

namespace app\lib\tools\media;

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

        $media = Media::find()
            ->select(['media_url'])
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

}