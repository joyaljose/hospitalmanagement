<?php

namespace common\models;

use Yii;
 
/**
 * This is the model class for table "user_roles_mapping".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $role_id
 * @property integer $status
 */
class UserRolesMapping extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_roles_mapping';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'role_id', 'status'], 'required'],
            [['user_id', 'role_id', 'status'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Sub Super Admin',
            'role_id' => 'Roles',
            'status' => 'Status',
        ];
    }
}