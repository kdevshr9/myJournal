@extends('general')

@section('content')
<!-- if there are creation errors, they will show here -->
{{ HTML::ul($errors->all()) }}
{{ Form::open(array('url' => 'journal')) }}
<div class="ui form segment">
    <!--    <div class="inline field">
            <label for="check3">Multiple Day Journal</label>
            <div class="ui toggle checkbox">
                <input id="journal_type" type="checkbox" checked="checked" name="type">
                <label for="journal_type">Single Day Journal</label>
            </div>
        </div>-->
        <div class="grouped inline fields">
            <div class="field">
                <div class="ui radio checkbox">
                    <input id="single_day_journal" name="type" checked="" type="radio" value="1">
                    <label for="single_day_journal">Single Day Journal</label>
                </div>
            </div>
            <div class="field">
                <div class="ui radio checkbox">
                    <input id="multiple_day_journal" name="type" type="radio" value="2">
                    <label for="multiple_day_journal">Multiple Day Journal</label>
                </div>
            </div>
        </div>
        <div class="inline fields" id="single_day_journal_date">
            <div class="date field">
                <input placeholder="Journal Date" type="text" name="date" class="datepicker">
            </div>
        </div>
        <div class="inline fields hide" id="multiple_day_journal_date">
            <div class="date field">
                <input placeholder="Journal Date From" name="date_from" type="text" class="datepicker">
            </div>
            <div class="field">
                <input placeholder="Journal Date To" name="date_to" type="text" class="datepicker">
            </div>
        </div>
        <div class="inline field" >
            <div class="field">
                <input placeholder="Journal Title" type="text" name="title">
            </div>
        </div>
        <div class="field">
            <textarea class="editor" name="description"></textarea>
            <!--<div class="editor"></div>-->
        </div>
        <input type="submit" class="ui blue submit button" value="Save">
    </div>
    {{ Form::close() }}

    {{ HTML::script('js/datepicker/picker.js'); }}
    {{ HTML::script('js/datepicker/picker.date.js'); }}
    {{ HTML::script('js/froala_editor/froala_editor.min.js'); }}

    {{ HTML::style('js/datepicker/default.css'); }}
    {{ HTML::style('js/datepicker/default.date.css'); }}
    {{ HTML::style('css/froala_editor/font-awesome.min.css'); }}
    {{ HTML::style('css/froala_editor/froala_editor.min.css'); }}
    <script>
        $(document).ready(function() {
            $('input[name="type"]').click(function() {
                var value = $(this).val();
                if (value === '1') {
                    $('#single_day_journal_date').addClass('show').removeClass('hide');
                    $('#multiple_day_journal_date').addClass('hide').removeClass('show');
                } else if(value === '2') {
                    $('#single_day_journal_date').addClass('hide').removeClass('show');
                    $('#multiple_day_journal_date').addClass('show').removeClass('hide');
                }
            });
        });
    </script>
    @stop