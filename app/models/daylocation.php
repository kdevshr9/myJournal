<?php

class daylocation extends Eloquent {
    
    public function photos() {
        return $this->hasMany('Photo');
    }
    
    public function day() {
        return $this->belongsTo('Day');
    }
}
