<?php

use yii\db\Migration;

class m190104_095530_create_table_holidays extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%holidays}}',
            [
                'id' => $this->primaryKey()->unsigned(),
                'user_id' => $this->integer()->notNull(),
                'start_date' => $this->date()->notNull(),
                'end_date' => $this->date()->notNull(),
                'holiday_type' => $this->integer()->unsigned()->notNull()->defaultValue('1'),
                'days_number' => $this->decimal(4, 2)->unsigned()->notNull()->defaultValue('1'),
                'departmen_responsable_accepted' => $this->tinyInteger()->unsigned()->notNull()->defaultValue('0'),
                'boss_accepted' => $this->tinyInteger()->unsigned()->notNull()->defaultValue('0'),
            ],
            $tableOptions);

        $this->addForeignKey('FK_holidays_user', '{{%holidays}}', 'user_id', '{{%user}}', 'id', 'RESTRICT', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable('{{%holidays}}');
    }
}
