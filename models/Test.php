<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "test".
 *
 * @property integer $id
 * @property string $title
 * @property integer $time
 * @property integer $questions_count
 *
 * @property QuestionToTest[] $questionToAnswers
 */
class Test extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'test';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['time', 'questions_count'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'time' => 'Time',
            'questions_count' => 'Questions Count',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionToTest()
    {
        return $this->hasMany(QuestionToTest::className(), ['test_id' => 'id']);
    }

    public function getQuestions()
    {
        return $this->hasMany(Question::className(), ['id' => 'question_id'])
            ->via('questionToTest');
    }

}
