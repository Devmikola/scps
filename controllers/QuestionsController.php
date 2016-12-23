<?php

namespace app\controllers;

use yii\helpers\VarDumper;

use app\models\Question;
use app\models\Test;
use app\models\Tag;

use yii\data\Pagination;

use Yii;

class QuestionsController extends \yii\web\Controller
{
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

    public function actionTest() {

    }

    public function actionDelete()
    {
        return $this->render('delete');
    }

    public function actionIndex()
    {
        $query = Question::find();

        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => 10]);
        $questions = $query->offset($pagination->offset)
            ->limit($pagination->limit);

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

            return $this->renderPartial('_index_table', [
                'questions' => $questions->all(),
                'pagination' => $pagination
            ]);
        } else {

            return $this->render('index', [
                'tags' => Tag::find()->all(),
                'questions' => $questions->all(),
                'pagination' => $pagination
            ]);
        }

    }

    public function actionUpdate()
    {
        return $this->render('update');
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => Question::findOne($id),
        ]);
    }

}
