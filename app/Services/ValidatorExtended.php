<?php 

     namespace App\Services;     
     use Illuminate\Validation\Validator;
     use Carbon\Carbon;

     class ValidatorExtended extends Validator {

         private $_custom_messages = array(        
         );

         public function __construct( $translator, $data, $rules, $messages = array(), $customAttributes = array() ) {
             parent::__construct( $translator, $data, $rules, $messages, $customAttributes );

             $this->_set_custom_stuff();
         }

         protected function _set_custom_stuff() {
             //setup our custom error messages
             $this->setCustomMessages( $this->_custom_messages );
         }

    }