<?php 

    class GlobalVar
    {

        private static $instance = null;

        public static function getInstance()
        {
            if( is_null(self::$instance) ){
                self::$instance = new GlobalVar;
            }

            return self::$instance;
        }

        public function set($name , $value)
        {
            $this->$name = $value;
        }

        public function get($name)
        {
            return $this->$name;
        }
    }