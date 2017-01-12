<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
/**
 * This is the model class for table "question".
 *
 * @property integer $id
 * @property string $question
 * @property string $answer
 * @property string $created_at
 * @property string $updated_at
 *
 * @property QuestionToTest[] $questionToTest
 */
class Question extends \yii\db\ActiveRecord
{
    public $new_tags; // extra property for creating new tags
    public $selected_tags = []; // extra property for selected tags which already exists
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'question';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['question', 'answer'], 'required'],
            [['question', 'answer', 'new_tags'], 'string'],
            ['selected_tags', 'each', 'rule' => ['integer']],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }


    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'question' => 'Question',
            'answer' => 'Answer',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionToTest()
    {
        return $this->hasMany(QuestionToTest::className(), ['question_id' => 'id']);
    }

    public function getQuestionToTags()
    {
        return $this->hasMany(TagToQuestion::className(), ['question_id' => 'id']);
    }


    public function getTags()
    {
        return $this->hasMany(\app\models\Tag::className(), ['id' => 'tag_id'])
            ->via('questionToTags');
    }


    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if(! $this->isNewRecord) {
            TagToQuestion::deleteAll(['question_id' => $this->id]);
        }

        if(! empty($this->new_tags) ) {
            $exp_new_tags = explode(', ', $this->new_tags);
            foreach($exp_new_tags as $exp_new_tag) {
                if( ! $existing_tag = \app\models\Tag::findOne(['name' => $exp_new_tag]) ) {
                    $current_tag_model = new \app\models\Tag();
                    $current_tag_model->name = $exp_new_tag;
                    $current_tag_model->save();
                    $this->link('tags', $current_tag_model);
                } else {
                    $this->link('tags', $existing_tag);
                }

            }
        }
        if(! empty($this->selected_tags) ) {
            foreach($this->selected_tags as $tag) {
                if($tagModel = \app\models\Tag::findOne($tag)) {
                    $this->link('tags', $tagModel);
                }
            }
        }

    }
}
