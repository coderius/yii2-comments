<?php

use yii\db\Migration;

/**
 * Class m201213_152854_comments_table
 */
class m201213_152854_comments_table extends Migration
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
        $this->createTable('{{%comments}}', [
            'id' => $this->primaryKey()->char(36)->notNull(),
            'materialId' => $this->char(255)->notNull(),
            'content' => $this->text()->notNull(),
            'parentId' => $this->integer()->unsigned()->null(),
            'level' => $this->smallInteger()->notNull()->defaultValue(1),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'ipStr' => $this->char(16)->null(),
            'introducedName' => $this->char(255)->null(),
            'introducedAvatar' => $this->char(255)->notNull(),
            'createdBy' => $this->integer()->unsigned()->null(),
            'updatedBy' => $this->integer()->unsigned()->null(),
            'createdAt' => $this->integer()->notNull(),
            'updatedAt' => $this->integer()->null(),
        ], $tableOptions);

        $this->createIndex('idx-comments-material-id', '{{%comments}}', 'materialId');
        $this->createIndex('idx-comments-status', '{{%comments}}', 'status');
        $this->createIndex('idx-comments-parentId', '{{%comments}}', 'parentId');
        $this->createIndex('idx-comments-createdBy', '{{%comments}}', 'createdBy');
        $this->createIndex('idx-comments-updatedBy', '{{%comments}}', 'updatedBy');
        $this->createIndex('idx-comments-ipStr', '{{%comments}}', 'ipStr');

        $this->addCommentOnColumn('{{%comments}}', 'entity', 'Related entity name like `article.123` where id = 123');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%comments}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201213_152854_comments_table cannot be reverted.\n";

        return false;
    }
    */
}
