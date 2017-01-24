<?php

namespace app\controllers;

use app\models\Question;
use app\models\Tag;

use yii\filters\AccessControl;

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
                        'actions' => ['index', 'create', 'update', 'view'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function () {
                            if (Yii::$app->user->getId() == 1) {
                                return true;
                            }
                            return false;
                        }
                    ],

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
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
                    'questions' => $queried_questions,
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
        $model = $this->findModel($id);

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
        $question = $this->findModel($id);

        return $this->render('view', [
            'model' => $question,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Question::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
