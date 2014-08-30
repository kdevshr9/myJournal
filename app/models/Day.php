<?php

class Day extends Eloquent {
    
    public function dayLocations() {
        return $this->hasMany('dayLocation');
    }
    
    public function photos() {
        return $this->hasMany('Photo');
    }

    public function journal() {
        return $this->belongsTo('Journal');
    }
}
