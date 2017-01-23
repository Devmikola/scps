<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\markdown\MarkdownEditor;
?>

<div class="question-create">

    <h1>Add new question</h1>

    <div class="question-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'question')->textInput(['maxlength' => true]) ?>

        <? echo MarkdownEditor::widget([
            'model' => $model,
            'attribute' => 'answer',
            'id' => 'question-answer-container'
        ]); ?>

        <div class="form-group">
            <select id="tags-filter" name="Question[selected_tags][]" multiple="multiple">
                <? foreach($tags as $tag) : ?>
                    <option value="<?= $tag->id ?>"><?= $tag->name ?></option>
                <? endforeach; ?>
            </select>
        </div>

        <?= $form->field($model, 'new_tags')->textInput() ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#tags-filter').multiselect({
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search...',
            nonSelectedText: 'Tags',
            buttonWidth: '240px'
        });
    });
</script>