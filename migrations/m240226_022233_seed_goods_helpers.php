<?php

use yii\db\Migration;

/**
 * Class m240226_022233_seed_goods_helpers
 */
class m240226_022233_seed_goods_helpers extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $autoBrand = json_encode([
            'toyota'=>'Toyota',
            'mercedes-benz'=>'Mercedes-Benz',
            'bmw'=>'BMW',
            'skoda'=>'Skoda',
            'lada'=>'Лада',
            'nissan'=>'Nissan',
            'kia'=>'Kia',
            'honda'=>'Honda',
            'subaru'=>'Subaru',
        ]);

        $autoModel = json_encode([
            'toyota'=>[
                'camry' => 'Camry',
                'corolla' => 'Corolla',
                'rav4' => 'RAV4',
                'lcprado' => 'Land Cruiser Prado',
                'lc' => 'Land Cruiser',
                'prius' => 'Prius',

            ],
            'mercedes-benz'=> [
                'e-class' => 'E-Class',
                'c-class' => 'C-Class',
                's-class' => 'S-Class',
                'm-class' => 'M-Class',
                'g-class' => 'G-Class',
                'amg-gt' => 'AMG GT',
            ],
            'bmw'=>[
                '3-series' => '3 Series',
                '5-series' => '5 Series',
                'x3' => 'X3',
                'x5' => 'X5',
                'x6' => 'X6',
                'x7' => 'X7',
                'm4' => 'M4',
                'm5' => 'M5',
                'm6' => 'M6',
                'm8' => 'M8',
            ],
            'skoda'=>[
                'octavia'=>'Octavia',
                'rapid'=>'Rapid',
                'fabia'=>'Fabia',
                'kodiaq'=>'Kodiaq',
                'yeti'=>'Yeti',
            ],
            'lada'=>[
                'granta' => 'Гранта',
                'vesta' => 'Веста',
                'priora' => 'Priora',
                'kalina' => 'Kalina',
                'largus' => 'Largus',
                'xray' => 'XRAY',
            ],
            'nissan'=>[
                'x-trail' => 'X-Trail',
                'qashkai' => 'Qashkai',
                'note' => 'Note',
                'juke' => 'Juke',
                'teana' => 'Teana',
                'leaf' => 'Leaf',
                'patrol' => 'Patrol',
            ],
            'kia'=>[
                'rio' => 'Rio',
                'sportage' => 'Sportage',
                'ceed' => 'Ceed',
                'sorento' => 'Sorento',
                'cerato' => 'Cerato',
                'optima' => 'Optima',
            ],
            'honda'=> [
                'feed' => 'Feed',
                'freed' => 'Freed',
                'cr-v' => 'CR-V',
                'accord' => 'Accord',
                'stepwgn' => 'stepwgn',
            ],
            'subaru'=>[
                'forester' => 'Forester',
                'impreza' => 'Impreza',
                'levord' => 'Levord',
                'legacy' => 'Legacy',
                'outback' => 'Outback',
                'justy' => 'Justy',
            ],
        ]);

        $jobType = json_encode([
            'full-time' => 'Полная занятость',
            'part-time' => 'Частичная занятость',
            'project' => 'Проектная работа',
            'volunteering' => 'Волонтерство',
            'internship' => 'Стажировка',
        ]);

        $data = [

            [1, 1, 2, 'price','Цена', '0', null],
            [2, 1, 2, 'floor','Этаж', '0', null],
            [3, 1, 2, 'square','Плошадь', '0', null],

            [4, 2, 2, 'price','Цена', '0', null],
            [5, 2, 3, 'brand','Бренд', '0', $autoBrand],
            [6, 2, 3, 'model','Модель', '0', $autoModel],
            [7, 2, 2, 'square','Обьем двигателя', '0', null],
            [8, 2, 2, 'square','Плошадь', '0', null],

            [9, 11, 2, 'salary','Зарплата', '0', null],
            [10, 11, 3, 'job-type','Тип занятости', '0', $jobType],
            [11, 11, 2, 'experience','Опыт работы', '0', null],

            [12, 12, 2, 'salary','Зарплата', '0', null],
            [13, 12, 3, 'job-type','Тип занятости', '0', $jobType],
            [14, 12, 2, 'experience','Опыт работы', '0', null],
            [15, 12, 2, 'age','Возраст', '0', null],

            [16, 13, 2, 'price','Цена', '0', null],
            [17, 14, 2, 'price','Цена', '0', null],
            [18, 15, 2, 'price','Цена', '0', null],
            [19, 16, 2, 'price','Цена', '0', null],
            [20, 17, 2, 'price','Цена', '0', null],
            [21, 18, 2, 'price','Цена', '0', null],
            [22, 19, 2, 'price','Цена', '0', null],
            [23, 20, 2, 'price','Цена', '0', null],
            [24, 21, 2, 'price','Цена', '0', null],
            [25, 22, 2, 'price','Цена', '0', null],
            [26, 23, 2, 'price','Цена', '0', null],
            [27, 24, 2, 'price','Цена', '0', null],
            [28, 25, 2, 'price','Цена', '0', null],
            [29, 26, 2, 'price','Цена', '0', null],
            [30, 27, 2, 'price','Цена', '0', null],
            [31, 28, 2, 'price','Цена', '0', null],
            [32, 29, 2, 'price','Цена', '0', null],
            [33, 30, 2, 'price','Цена', '0', null],
            [34, 31, 2, 'price','Цена', '0', null],

        ];

        $this->batchInsert(
            '{{%goods_helpers}}',
            [
                'id',
                'category_id',
                'type_id',
                'fld_name',
                'fld_label',
                'fld_default',
                'fld_parameters'
            ],
            $data
        );



    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        try {
            $this->truncateTable('{{%goods_helpers}}');
            return true;
        } catch (\yii\db\Exception $e) {
            echo "m240226_022233_seed_goods_helpers cannot be reverted.\n";
            echo $e->getMessage();
            return false;
        }

    }

}
