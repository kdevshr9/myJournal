<?php

class Day extends Eloquent {

    // MASS ASSIGNMENT -------------------------------------------------------
    // define which attributes are mass assignable (for security)
//    protected $fillable = array('journal_id', 'date', 'description');

    public function journal() {
        return $this->belongsTo('Journal');
    }

}
