<?php

use yii\db\Migration;

/**
 * Class m240222_033822_seed_goods_category
 */
class m240222_033822_seed_goods_category extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $data = [
            [1,'nedvizhimost','Недвижимость',0,'/nedvizhimost'],
            [2,'transport','Транспорт',0,'/transport'],
            [3,'rabota','Работа',0,'/rabota'],
                [11,'vakansii','Вакансии',3,'/rabota/vakansii'],
                [12,'resume','Резюме',3,'/rabota/resume'],

            [4,'telefonyi-i-svyaz','Телефоны и связь',0,'/telefonyi-i-svyaz'],
                [13,'smartfony','Смартфоны',4,'/telefonyi-i-svyaz/smartfony'],
                [14,'planshety','Планшеты',4,'/telefonyi-i-svyaz/planshety'],
                [15,'fotoapparaty','Фотоаппараты',4,'/telefonyi-i-svyaz/fotoapparaty'],

            [5,'odezhda-i-obuv','Одежда и личные вещи',0,'/odezhda-i-obuv'],
                [16,'jinsy','Джинсы',5,'/odezhda-i-obuv/jinsy'],
                [17,'obuv','Обувь',5,'/odezhda-i-obuv/obuv'],

            [6,'kompyuteryi-i-orgtehnika','Компьютеры и оргтехника',0,'/kompyuteryi-i-orgtehnika'],
                [18,'noutbuki','Ноутбуки',6,'/kompyuteryi-i-orgtehnika/noutbuki'],
                [19,'personalnye-kompyutery','Персональные компьютеры',6,'/kompyuteryi-i-orgtehnika/personalnye-kompyutery'],
                [20,'monobloki','Моноблоки',6,'/kompyuteryi-i-orgtehnika/monobloki'],

            [7,'elektronika-i-tehnika','Электроника и бытовая',0,'/elektronika-i-tehnika'],

                [21,'xolodilniki','Холодильники',7,'/elektronika-i-tehnika/xolodilniki'],
                [22,'plity-elektricheskie','Плиты электрические',7,'/elektronika-i-tehnika/plity-elektricheskie'],

            [8,'hobbi','Хобби, музыка и спорт',0,'/hobbi'],
                [23,'nastolnye-igry','Настольные игры',8,'/hobbi/nastolnye-igry'],
                [24,'konstruktory','Конструкторы',8,'/hobbi/konstruktory'],
                [25,'videoigry','Видеоигры',8,'/hobbi/videoigry'],

            [9,'zhivotnyie-i-rasteniya','Животные и растения',0,'/zhivotnyie-i-rasteniya'],
                [26,'igrushki','Игрушки для животных',9,'/zhivotnyie-i-rasteniya/igrushki'],
                [27,'aksessuary-dlya-kormleniya','Аксессуары для кормления',9,'/zhivotnyie-i-rasteniya/aksessuary-dlya-kormleniya'],
                [28,'transportirovka','Транспортировка',9,'/zhivotnyie-i-rasteniya/transportirovka'],

            [10,'uslugi','Услуги',0,'/uslugi'],
                [29,'cleaning','Клининг',10,'/uslugi/cleaning'],
                [30,'fitness-trener','Фитнес-тренер',10,'/uslugi/fitness-trener'],
                [31,'lower','Юридические услуги',10,'/uslugi/lower'],
        ];

        $this->batchInsert(
            '{{%goods_category}}',
            [
                'id',
                'fld_key',
                'fld_label',
                'parent_id',
                'fld_breadcrumb'
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
            $this->truncateTable('{{%goods_category}}');
            return true;
        } catch (\yii\db\Exception $e) {
            echo "m240222_033822_seed_goods_category cannot be reverted.\n";
            echo $e->getMessage();
            return false;
        }

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240222_033822_seed_goods_category cannot be reverted.\n";

        return false;
    }
    */
}
