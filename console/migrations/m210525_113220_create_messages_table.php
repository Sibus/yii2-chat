<?php

use yii\db\Migration;

class m210525_113220_create_messages_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%messages}}', [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer()->notNull(),
            'content' => $this->text()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'hidden_at' => $this->integer()->notNull()->defaultValue(null),
        ]);

        $this->createIndex(
            '{{%idx-messages-author_id}}',
            '{{%messages}}',
            'author_id'
        );

        $this->addForeignKey(
            '{{%fk-messages-author_id}}',
            '{{%messages}}',
            'author_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey(
            '{{%fk-messages-author_id}}',
            '{{%messages}}'
        );

        $this->dropIndex(
            '{{%idx-messages-author_id}}',
            '{{%messages}}'
        );

        $this->dropTable('{{%messages}}');
    }
}
