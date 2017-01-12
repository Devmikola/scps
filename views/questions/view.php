<?php
/* @var $this yii\web\View */
use yii\widgets\ActiveForm;
use kartik\markdown\Markdown;
use yii\helpers\Html;
?>

<h1><?= $model->question; ?></h1>

<button id="show-answer-button" type="button" class="btn btn-info">Show Answer</button>
<button id="hide-answer-button" type="button" style="display: none;" class="btn btn-warning">Hide Answer</button>

<?= Html::a('Update', ['update', 'id' => $model->id], ['class'=>'btn btn-warning', 'style' => 'margin-left: 20px; width: 100px;']) ?>
<?= Html::a('Delete', ['delete', 'id' => $model->id], ['class'=>'btn btn-danger disabled', 'style' => 'margin-left: 10px; width: 100px;', 'data' => ['confirm' => 'Are you sure ?']]) ?>

<div class="form-group" style="margin-top: 20px;">
    <label class="control-label" for="user-draft">Draft</label>
    <textarea id="user-draft" class="form-control" name="NoForm[user-draft]" rows="8"></textarea>
</div>

<div id="answer" style="display: none;">
    <?= Markdown::convert($model->answer); ?>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        if(localStorage.getItem("showing-answer") == "true") {
            $("#answer").show();
            $("#show-answer-button").hide();
            $("#hide-answer-button").show();
        }

        $("#show-answer-button").click(function(){
            $("#answer").show();
            $(this).hide();
            $("#hide-answer-button").show();
        });

        $("#hide-answer-button").click(function(){
            $("#answer").hide();
            $(this).hide();
            $("#show-answer-button").show();
        });
    });
</script>

<style>
    #show-answer-button {
        border: none;
        outline: none;
    }
</style>