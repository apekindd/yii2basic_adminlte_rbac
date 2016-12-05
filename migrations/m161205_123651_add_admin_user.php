<?php

use yii\db\Migration;

class m161205_123651_add_admin_user extends Migration
{
    public function up()
    {
        $this->insert('user',[
            'id' => 1,
            'username' => 'admin',
            'password' => Yii::$app->security->generatePasswordHash('admin'),
        ]);
    }

    public function down()
    {
        $this->delete('user', 'id=1');
    }
}
