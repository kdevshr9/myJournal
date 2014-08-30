<?php

class journallocation extends Eloquent {
    
    public function journal() {
        return $this->belongsTo('Journal');
    }
}
