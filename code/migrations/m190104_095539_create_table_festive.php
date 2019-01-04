<?php

use yii\db\Migration;

class m190104_095539_create_table_festive extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%festive}}', [
            'id' => $this->primaryKey()->unsigned(),
            'free_day' => $this->date()->notNull(),
            'festive_type_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addForeignKey('FK_festive_festive_type', '{{%festive}}', 'festive_type_id', '{{%festive_type}}', 'id', 'RESTRICT', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable('{{%festive}}');
    }
}
