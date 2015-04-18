<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;


/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property string $name
 * @property string $subtitle
 * @property string $description
 * @property integer $price
 * @property integer $cat_id
 * @property integer $discount
 * @property integer $stock
 * @property integer $status
 * @property integer $visible
 * @property integer $order
 * @property string $rating
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property ProductAttribute $productAttribute
 * @property Category $category
 * @property Cart[] $carts
 * @property UserComment[] $userComments
 */
class Product extends ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const VISIBLE_INVISIBLE = 0;
    const VISIBLE_VISIBLE = 1;

    /**
     * @param bool $with_key
     * @return array
     */
    public static function getStatusAsArray($with_key = true)
    {
        $return = ($with_key == true)
            ? [
                static::STATUS_ACTIVE => 'Active',
                static::STATUS_INACTIVE => 'Inactive',
            ]
            : [
                static::STATUS_ACTIVE,
                static::STATUS_INACTIVE,
            ];
        return $return;
    }

    /**
     * @param bool $with_key
     * @return array
     */
    public static function getVisibleAsArray($with_key = true)
    {
        $return = ($with_key == true)
            ? [
                static::VISIBLE_VISIBLE => 'Visible',
                static::VISIBLE_INVISIBLE => 'Invisible',
            ]
            : [
                static::VISIBLE_VISIBLE,
                static::VISIBLE_INVISIBLE,
            ];
        return $return;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description'], 'required'],
            [['description'], 'string'],
            [['price', 'discount', 'stock', 'status', 'visible', 'order', 'cat_id', 'created_at', 'updated_at'], 'integer'],
            [['name', 'subtitle', 'rating'], 'string', 'max' => 255],
            ['status', 'default', 'value' => static::STATUS_ACTIVE],
            ['status', 'in', 'range' => static::getStatusAsArray(false)],
            ['visible', 'default', 'value' => static::VISIBLE_VISIBLE],
            ['visible', 'in', 'range' => static::getVisibleAsArray(false)],
            ['order', 'default', 'value' => 0],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'subtitle' => 'subtitle',
            'description' => 'Description',
            'price' => 'Price',
            'cat_id' => 'Category Id',
            'discount' => 'Discount',
            'stock' => 'Stock',
            'status' => 'Status',
            'visible' => 'Visible',
            'order' => 'Order',
            'rating' => 'rating',
            'category.name' => 'Category',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductAttribute()
    {
        return $this->hasOne(ProductAttribute::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarts()
    {
        return $this->hasMany(Cart::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'cat_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransactionAttributes()
    {
        return $this->hasMany(TransactionAttribute::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserComments()
    {
        return $this->hasMany(UserComment::className(), ['table_id' => 'id'])->andWhere(['table_key' => static::tableName()]);
    }

    public function countRating()
    {
        if ($this->rating) {
            $rating = explode(',', $this->rating);
            $totalRating = intval($rating[0]);
            $totalUser = intval($rating[1]);
            return $totalUser > 0 ? round($totalRating / $totalUser, 0) : false;
        } else {
            return false;
        }
    }
}
