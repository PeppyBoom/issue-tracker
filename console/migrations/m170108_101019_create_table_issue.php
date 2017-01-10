<?php

use yii\db\Migration;

class m170108_101019_create_table_issue extends Migration
{
    public $tableName = '{{%issue}}';

    public function up()
    {
        try {
            $tableOptions = null;
            if ('mysql' === $this->db->driverName) {
                $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
            }
            $this->createTable($this->tableName, [
                'id' => $this->primaryKey() . ' AUTO_INCREMENT',
                'name' => $this->string(),
                'solution' => $this->string(),
                'rating' => $this->integer(),
            ], $tableOptions);
        } catch (Exception $e) {
            echo 'Exception: ', $e->getMessage(), "\n";
            $this->down();
        }
    }

    public function down()
    {
        try {
            $tableToCheck = Yii::$app->db->schema->getTableSchema($this->tableName);
            if (is_object($tableToCheck)) {
                $this->dropTable($this->tableName);
            }
        } catch (Exception $e) {
            echo 'Exception while down ', $e->getMessage(), "\n";
        }
    }
}
