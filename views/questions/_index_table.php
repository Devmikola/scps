<?php
/* @var $this yii\web\View */

use yii\helpers\ArrayHelper;
use yii\helpers\Url;
?>

<? $tr_colors = ['#FE2E64', '#FE2EF7', '#642EFE', '#2E9AFE', '#2EFEF7', '#2EFE64', '#9AFE2E', '#FFFF00', '#FFBF00']; ?>
<? foreach($questions as $question) : ?>
    <tr style="background-color: <?= $tr_colors[rand(0, count($tr_colors) - 1)] ?>" data-href="<?= Url::to(['view', 'id' => $question->id]);?>">
        <th scope="row"> <?= $question->id; ?> </th>
        <td width="70%"> <?= $question->question; ?> </td>
        <td> <?= implode(', ', ArrayHelper::map($question->tags, 'id', 'name')); ?> </td>
    </tr>
<? endforeach; ?>
