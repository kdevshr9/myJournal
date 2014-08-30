<?php

class Journal extends Eloquent {
    
    public function journallocations() {
        return $this->hasMany('journallocation');
    }

    public function days() {
        return $this->hasMany('Day');
    }

//    public function photos() {
//        return $this->hasManyThrough('Photo', 'Day');
//    }
    
    public function daylocations() {
        return $this->hasManyThrough('daylocation', 'Day');
    }

}
