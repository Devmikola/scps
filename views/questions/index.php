<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\widgets\ActiveField;
use yii\widgets\LinkPager;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
?>

<div class="interface-panel">
    <form class="navbar-form" role="search" style="background-color: #aa0000; padding: 10px; border-radius: 10px; color: #c67605;">
        <div class="form-group" style="font-size: 20px; font-weight: bold;">
            Queestions Index
        </div>
        <div class="form-group">
            <input type="text" id="search-field" class="form-control" placeholder="Search" style="width: 400px;" autocomplete="off">
        </div>

        <div class="form-group">
            <select id="tags-filter" name="filterTags[]" multiple="multiple">
                <? foreach($tags as $tag) : ?>
                    <option value="<?= $tag->id ?>"><?= $tag->name ?></option>
                <? endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <input id="showing-answer" type="checkbox" data-width="160" checked data-toggle="toggle" data-on="Show Answers" data-off="Hide Answers" data-onstyle="success" data-offstyle="warning">
        </div>
        <div class="form-group">
            <?= Html::a('Add Question', ['/questions/create'], ['class'=>'btn btn-warning']) ?>
        </div>
    </form>
</div>


<!-- Including table of questions from partial -->
<?= $this->render('_index_table', ['questions' => $questions, 'pagination' => $pagination]) ?>


<script type="text/javascript">
    $(document).ready(function() {
        $('#tags-filter').multiselect({
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search...',
            nonSelectedText: 'Tags',
            onChange: searchRequest,
            buttonWidth: '160px'
        });

        function searchRequest() {
            var selectedOptions = $('#tags-filter option:selected');
            var selectedTags = selectedOptions.map(function(index, el) {return $(el).val(); }).get();
            $.ajax({
                url: document.location,
                type: 'POST',
                data: {searchTerm: $("#search-field").val(), filterTags: JSON.stringify(selectedTags)},
                success: function(data) {
                    $("#questions-table").html(data);
                }
            });
        }

        if(localStorage.getItem("showing-answer") == "false") {
            $('#showing-answer').bootstrapToggle("off");
        }

        $("#showing-answer").change(function(){
            localStorage.setItem("showing-answer", this.checked);
        });

        $("body").on("mouseenter", "#questions-table tr", function(){
            $(this).css("background-color", changeColors($(this).css("background-color"), +15))
        }).on("mouseleave", "#questions-table tr", function(){
            $(this).css("background-color", changeColors($(this).css("background-color"), -15))
        });

        function changeColors(str, addVal) {
            var vals = str.substring(str.indexOf('(') + 1, str.length - 1).split(', ');
            return 'rgb(' + (parseInt(vals[0]) + addVal) + ', ' + (parseInt(vals[1]) + addVal) + ', ' + (parseInt(vals[2]) + addVal) + ')';
        }

        $("body").on('click', "#questions-table tr[data-href]", function(){
            window.open($(this).data('href'), '_blank');
        });

        $("#search-field").keyup(function(){
            if($(this).val().length > 2 || $(this).val().length == 0) {
                searchRequest();
            }
        });
    });
</script>

<style>
    .multiselect-container > li > a > label {
        padding-left: 20px;
    }

    .form-group + .form-group {
        margin-left: 10px;
    }


    tr:hover {
        cursor: pointer;
    }
</style>
