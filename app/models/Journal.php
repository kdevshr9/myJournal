<?php

class Journal extends Eloquent {

    // MASS ASSIGNMENT -------------------------------------------------------
    // define which attributes are mass assignable (for security)
//    protected $fillable = array('type', 'title', 'latitude', 'longitude');

    public function days() {
        return $this->hasMany('Day');
    }

}
