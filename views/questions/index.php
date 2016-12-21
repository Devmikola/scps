<?php
/* @var $this yii\web\View */
use yii\widgets\ActiveField;
?>

<div class="interface-panel">
    <form class="navbar-form" role="search" style="background-color: #aa0000; padding: 10px; border-radius: 10px; color: #c67605;">
        <div class="form-group" style="font-size: 20px; font-weight: bold;">
            Queestions Index
        </div>
        <div class="form-group">
            <input type="text" id="search-field" class="form-control" placeholder="Search" style="width: 400px;">
        </div>

        <!--
        Bootstrap Multiselect

        http://davidstutz.github.io/bootstrap-multiselect/#getting-started
        and https://github.com/davidstutz/bootstrap-multiselect
        -->

        <div class="form-group">
            <select id="example-filterBehavior" multiple="multiple">
                <option value="1">PHP</option>
                <option value="2">MySQL</option>
                <option value="3">GIT</option>
                <option value="4">JavaScript</option>
                <option value="5">jQuery</option>
                <option value="6">Yii 2</option>
                <option value="7">Backbone.js</option>
            </select>
        </div>
        <div class="form-group">
            <input type="checkbox" data-width="160" checked data-toggle="toggle" data-on="Show Answers" data-off="Hide Answers" data-onstyle="success" data-offstyle="warning">
        </div>
        <div class="form-group">
            <button type="button" class="btn btn-warning">Add Question</button>
        </div>
    </form>
</div>


<table id="questions-table" class="table table-sm table-inverse">
        <tr class="bg-danger">
            <th scope="row">1</th>
            <td colspan="2">Yii 2 installation issue</td>
            <td>Yii 2, PHP</td>
        </tr>
        <tr class="bg-success">
            <th scope="row">2</th>
            <td colspan="2">GIT update</td>
            <td>GIT</td>
        </tr>
        <tr class="bg-warning">
            <th scope="row">3</th>
            <td colspan="2">Optimisation requests select when using subqueries</td>
            <td>SQL, MySQL</td>
        </tr>
        <tr class="bg-danger">
            <th scope="row">4</th>
            <td colspan="2">My Algorithm of building applications</td>
            <td>Xtra</td>
        </tr>
</table>


<script type="text/javascript">
    $(document).ready(function() {
        $('#example-filterBehavior').multiselect({
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search...',
            nonSelectedText: 'Tags',
            buttonWidth: '160px'
        });

        var questions_trs = $("#questions-table tr");
        for(var i = 0, size = questions_trs.length; i < size; i++) {
            $(questions_trs[i]).hover(function(){
                $(this).css("background-color", changeColors($(this).css("background-color"), +10))
            }, function(){
                $(this).css("background-color", changeColors($(this).css("background-color"), -10))

            });
        }

        function changeColors(str, addVal) {
            var vals = str.substring(str.indexOf('(') + 1, str.length - 1).split(', ');
            return 'rgb(' + (parseInt(vals[0]) + addVal) + ', ' + (parseInt(vals[1]) + addVal) + ', ' + (parseInt(vals[2]) + addVal) + ')';
        }
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
