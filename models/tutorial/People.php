<?php

namespace app\models\tutorial;

use Yii;

/**
 * This is the model class for table "people".
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property int $age
 * @property string $createdon
 * @property string $modifiedon
 * @property string $deletedon
 */
class People extends \yii\db\ActiveRecord
{
    const SCENARIO_CREATE = 'create';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'people';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['age'], 'integer'],
            [['createdon', 'modifiedon'], 'required'],
            [['createdon', 'modifiedon', 'deletedon'], 'safe'],
            [['first_name', 'last_name'], 'string', 'max' => 50],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['create'] = ['first_name', 'last_name', 'age'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'age' => 'Age',
            'createdon' => 'Createdon',
            'modifiedon' => 'Modifiedon',
            'deletedon' => 'Deletedon',
        ];
    }
}
