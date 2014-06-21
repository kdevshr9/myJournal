@extends('general')

<?php
$user_error = '';
$password_error = '';
if ($errors->first('username')){
    $user_error = 'error';
}
if ($errors->first('password')){
    $password_error = 'error';
}
?>

@section('content')
{{ Form::open() }}
    <div class="ui form segment">
      <div class="field {{ $user_error }}">
        <div class="ui left labeled icon input">
          <input type="text" placeholder="Username" name="username">
          <i class="user icon"></i>
          <div class="ui corner label">
            <i class="icon asterisk"></i>
          </div>
        </div>
      </div>
      <div class="field {{ $password_error }}">
        <div class="ui left labeled icon input">
          <input type="password" placeholder="Password" name="password">
          <i class="lock icon"></i>
          <div class="ui corner label">
            <i class="icon asterisk"></i>
          </div>
        </div>
      </div>
      <div class="ui error message">
        <div class="header">We noticed some issues</div>
      </div>
        <input type="submit" class="ui blue submit button" value="Login">
    </div>
{{ Form::close() }}
@stop