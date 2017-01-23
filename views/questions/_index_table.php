<?php
/* @var $this yii\web\View */

use yii\helpers\ArrayHelper;
use yii\helpers\Url;
?>

<? $tr_colors = ['#FE2E64', '#FE2EF7', '#642EFE', '#2E9AFE', '#2EFEF7', '#2EFE64', '#9AFE2E', '#FFFF00', '#FFBF00']; ?>
<col width="10%"> <col width="70%"> <col width="20%">
<? foreach($questions as $question) : ?>
    <tr style="background-color: <?= $tr_colors[rand(0, count($tr_colors) - 1)] ?>" data-href="<?= Url::to(['view', 'id' => $question->id]);?>">
        <td> <?= $question->id; ?> </td>
        <td> <?= $question->question; ?> </td>
        <td> <?= implode(', ', ArrayHelper::map($question->tags, 'id', 'name')); ?> </td>
    </tr>
<? endforeach; ?>
