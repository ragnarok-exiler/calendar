<?php

use yii\db\Migration;

/**
 * Class m190220_083028_holidays_type
 */
class m190220_083028_create_table_holiday_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%holiday_type}}',
            [
                'id' => $this->primaryKey(2)->unsigned(),
                'name' => $this->string(50)->notNull(),
                'requestable' => $this->tinyInteger()->notNull()->defaultValue('1'),
            ],
            $tableOptions);
        $this->batchInsert('{{%holiday_type}}',
            ['id', 'name'],
            [
                [1, 'Varios días'],
                [2, '1 Día'],
                [3 , '1/2 día']
            ]
        );
        $this->addForeignKey('FK_holidays_holiday_type', '{{%holidays}}', 'holiday_type', '{{%holiday_type}}', 'id',
            'RESTRICT', 'RESTRICT');

        echo "Migration m190220_083028_createtable_holiday_type done.\n";
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FK_holidays_holiday_type', '{{%holidays}}');
        $this->dropTable('{{%holiday_type}}');
        echo "m190220_083028_createtable_holiday_type has been reverted.\n";

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190220_083028_holidays_type cannot be reverted.\n";

        return false;
    }
    */
}
