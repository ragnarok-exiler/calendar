<?php

use yii\db\Migration;

class m190104_095531_create_table_festive_type extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%festive_type}}',
            [
                'id' => $this->primaryKey(),
                'name' => $this->string(50)->notNull(),
                'requestable' => $this->tinyInteger()->notNull()->defaultValue('0'),
            ],
            $tableOptions);

        $this->batchInsert('{{%festive_type}}',
            ['id', 'name'],
            [
                [1, 'Fiestas Laborales'],
                [2 , 'Fiestas Locales Barcelona'],
                [3, 'Fiestas Locales Madrid']
            ]
        );

    }

    public function down()
    {
        $this->dropTable('{{%festive_type}}');
    }
}
