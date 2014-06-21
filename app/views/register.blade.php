@extends('general')
@section('content')
{{ Form::open() }}
<div class="ui form segment">
    <div class="grouped inline fields">
        <div class="field">
            <div class="ui radio checkbox">
                <input id="shop_flag_yes" name="shop_flag" checked="" value='1' type="radio">
                <label for="shop_flag_yes">I have a shop</label>
            </div>
        </div>
        <div class="field">
            <div class="ui radio checkbox">
                <input id="shop_flag_no" name="shop_flag" value='0' type="radio">
                <label for="shop_flag_no">I don't have shop</label>
            </div>
        </div>
    </div>
    <div class="field">
        <div class="ui left labeled icon input">
            <input type="text" placeholder="Shop Name" name="shop_name">
            <i class="user icon"></i>
            <div class="ui corner label">
                <i class="icon asterisk"></i>
            </div>
        </div>
    </div>
    <div class="two fields">
        <div class="field">
            <div class="ui left labeled icon input">
                <input type="text" placeholder="Shop Address" name="shop_address">
                <i class="user icon"></i>
                <div class="ui corner label">
                    <i class="icon asterisk"></i>
                </div>
            </div>
        </div>
        <div class="field">
            <div class="ui left labeled icon input">
                <input type="text" placeholder="Shop Phone Number" name="shop_ph_number">
                <i class="lock icon"></i>
                <div class="ui corner label">
                    <i class="icon asterisk"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="two fields">
        <div class="field">
            <div class="ui left labeled icon input">
                <input type="text" placeholder="Your First Name" name="first_name">
                <i class="user icon"></i>
                <div class="ui corner label">
                    <i class="icon asterisk"></i>
                </div>
            </div>
        </div>
        <div class="field">
            <div class="ui left labeled icon input">
                <input type="text" placeholder="Your Last Name" name="last_name">
                <i class="lock icon"></i>
                <div class="ui corner label">
                    <i class="icon asterisk"></i>
                </div>
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