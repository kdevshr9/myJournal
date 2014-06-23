@extends('general')

@section('content')
<!-- if there are creation errors, they will show here -->
{{ HTML::ul($errors->all()) }}
{{ Form::model($journal, array('route' => array('journal.update', $journal->id), 'method' => 'PUT')) }}
<div class="ui form segment">
    <div class="grouped inline fields">
        <div class="field">
            <div class="ui radio checkbox">
                {{ Form::radio('type', '1', null, array('class' => 'form-control', 'id' => 'single_day_journal')) }}
                <label for="single_day_journal">Single Day Journal</label>
            </div>
        </div>
        <div class="field">
            <div class="ui radio checkbox">
                {{ Form::radio('type', '2', null, array('class' => 'form-control', 'id' => 'multiple_day_journal')) }}
                <label for="multiple_day_journal">Multiple Day Journal</label>
            </div>
        </div>
    </div>
    <div class="inline fields" id="single_day_journal_date">
        <div class="date field">
            {{ Form::text('date', null, array('class' => 'datepicker', 'placeholder' => 'Journal Date')) }}
        </div>
    </div>
    <div class="inline fields hide" id="multiple_day_journal_date">
        <div class="date field">
            {{ Form::text('date_from', null, array('class' => 'datepicker', 'placeholder' => 'Journal Date From')) }}
        </div>
        <div class="field">
            {{ Form::text('date_to', null, array('class' => 'datepicker', 'placeholder' => 'Journal Date To')) }}
        </div>
    </div>

    <div class="inline field" >
        <div class="field">
            {{ Form::text('title', null, array('class' => 'form-control', 'placeholder' => 'Journal Title')) }}
        </div>
    </div>
    <div class="field">
        <textarea class="editor" name="description">{{ $journal->description }}</textarea>
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
            } else if (value === '2') {
                $('#single_day_journal_date').addClass('hide').removeClass('show');
                $('#multiple_day_journal_date').addClass('show').removeClass('hide');
            }
        });
        
        <?php if($journal->type===2){?>
                $('input[name="type"]').trigger('click');
        <?php } ?>
    });
</script>
@stop