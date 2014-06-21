<?php

class Authentication extends BaseController{
    
    public function login(){
//        $validator = Validator::make(
//            array('username' => 'required'),
//            array('password' => 'required')
//        );
//        
//        if($validator->fails()){
//            $messages = $validator->messages();
//        }
            
        echo $username = Input::get('username');
        $password = Input::get('password');
    }
}