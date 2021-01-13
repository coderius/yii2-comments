<?php

use yii\db\Migration;

/**
 * Class m210112_143756_comments_likes_table
 */
class m210112_143756_comments_likes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ('mysql' === $this->db->driverName) {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%comments_likes}}', [
            'id' => $this->char(36)->notNull(),
            'commentId' => $this->char(36)->notNull(),
            'score' => $this->smallInteger()->notNull()->defaultValue(1),
            'ipStr' => $this->char(16)->null()->comment('Ip address of user'),
            'createdBy' => $this->integer()->unsigned()->null(),
            'updatedBy' => $this->integer()->unsigned()->null(),
            'createdAt' => $this->integer()->notNull(),
            'updatedAt' => $this->integer()->null(),
        ], $tableOptions);

        $this->addPrimaryKey('id_pk', '{{%comments_likes}}', ['id']);

        $this->createIndex('idx-comments_likes-id', '{{%comments_likes}}', 'id');
        $this->createIndex('idx-comments_likes-commentId', '{{%comments_likes}}', 'commentId');
        $this->createIndex('idx-comments_likes-score', '{{%comments_likes}}', 'score');
        $this->createIndex('idx-comments_likes-ipStr', '{{%comments_likes}}', 'ipStr');

        $this->addForeignKey(
            'fk-comments_likes_commentId',
            '{{%comments_likes}}',
            'commentId',
            '{{%comments}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addCommentOnColumn('{{%comments_likes}}', 'score', 'Score = 1: if like is set by user (or guest) or if like is removed = 0. ');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%comments_likes}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210112_143756_comments_likes_table cannot be reverted.\n";

        return false;
    }
    */
}
