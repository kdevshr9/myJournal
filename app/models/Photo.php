<?php

class Photo extends Eloquent {

    public function day() {
        return $this->belongsTo('Day');
    }
    
    public function daylocation() {
        return $this->belongsTo('daylocation');
    }

}
