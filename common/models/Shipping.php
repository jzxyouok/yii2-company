<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "shipping".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $address
 * @property string $city
 * @property integer $postal_code
 *
 * @property User $user
 * @property Transaction[] $transactions
 */
class Shipping extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shipping';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'postal_code'], 'integer'],
            [['address', 'city'], 'required'],
            [['address', 'city'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'address' => 'Address',
            'city' => 'City',
            'postal_code' => 'Postal Code',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransactions()
    {
        return $this->hasMany(Transaction::className(), ['shipping_id' => 'id']);
    }
}