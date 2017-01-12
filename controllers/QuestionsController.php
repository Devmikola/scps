<?php

namespace app\controllers;

use yii\helpers\VarDumper;

use app\models\Question;
use app\models\Test;
use app\models\Tag;

use yii\filters\AccessControl;

use yii\data\Pagination;

use Yii;

class QuestionsController extends \yii\web\Controller
{
    public $questionsPerPortion = 20;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'delete', 'update', 'view'],
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ],
            ],
        ];
    }

    public function actionCreate()
    {
        $model = new Question();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $tags = Tag::find()->indexBy('id')->all();

            return $this->render('create', [
                'model' => $model,
                'tags' => $tags,
            ]);
        }
    }

    public function actionDelete($id)
    {
        $model = Question::findOne($id);
        if($model) {
            $model->delete();
            return $this->redirect(['index']);
        } else {
            return $this->redirect(Yii::$app->request->referrer);
        }
    }

    public function actionIndex()
    {
        $query = Question::find();

        if(Yii::$app->request->post('getNextQuestionPortion') == 'true') {
            $currentPortion = intval(Yii::$app->request->post('currentNumQuestionPortion'));
        } else {
            $currentPortion = 0;
        }
        $questions = $query->offset($this->questionsPerPortion * $currentPortion)->limit($this->questionsPerPortion);

        if(Yii::$app->request->isAjax) {
            \Yii::$app->response->format = 'json';

            if(Yii::$app->request->post('searchTerm')) {
                $exp_terms = explode(" ", Yii::$app->request->post('searchTerm'));
                $questions->where(['like', 'question', $exp_terms]);
            }
            if(Yii::$app->request->post('filterTags')) {
                $filter_tags = json_decode(Yii::$app->request->post('filterTags'));
                if(! empty($filter_tags) ) {
                    $questions->joinWith('tags')
                        ->andWhere(['in', 'tag_id', $filter_tags]);
                }
            }

            if($queried_questions = $questions->all()) {
                return $this->renderPartial('_index_table', [
                    'questions' => $questions->all(),
                ]);
            } else {
                return "Offset exhausted";
            }

        } else {

            return $this->render('index', [
                'tags' => Tag::find()->all(),
                'questions' => $questions->all(),
            ]);
        }

    }

    public function actionUpdate($id)
    {
        $model = Question::findOne($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $tags = Tag::find()->indexBy('id')->all();
            return $this->render('update', [
                'model' => $model,
                'tags' => $tags
            ]);
        }

    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => Question::findOne($id),
        ]);
    }

}
