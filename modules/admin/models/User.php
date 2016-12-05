<?php

namespace app\modules\admin\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\rbac\Item;


/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $email
 * @property integer $created_at
 * @property integer $updated_at
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    public function getRoles($id=false){
        if(!$id) {
            $id = (int)Yii::$app->request->get('id');
        }
        $roles = Role::find()->where(['=','type',Item::TYPE_ROLE])->asArray()->indexBy('name')->all();
        $res = [];
        $hisRoles = [];
        if($id > 0){
            $hisRoles = AuthAssignment::find()->where(['=','user_id', $id])->asArray()->indexBy('item_name')->all();
        }
        foreach($roles as $name=>$role){
            $res[$name]['role'] = $name;
            if($hisRoles[$name]){
                $res[$name]['checked'] = 1;
            }else{
                $res[$name]['checked'] = 0;
            }
        }
        return $res;
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => time(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password_hash', 'email'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['username', 'password_hash', 'email'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Логин',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Пароль(hash)',
            'email' => 'Email',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
