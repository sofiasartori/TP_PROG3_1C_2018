<?php

    use Firebase\JWT\JWT;

    class JsonWToken
    {
        private static $restaurantLoloToken = 'restaurantLolo@';
        private static $encrypt = ['HS256'];
        private static $aud = null;
        
        public static function LogIn($data)
        {
            $time = time();
            
            $token = array(
                'exp' => $time + (60*60),
                'aud' => self::Aud(),
                'data' => $data
            );

            return JWT::encode($token, self::$restaurantLoloToken);
        }
        
        public static function Checkear($token)
        {
            if(empty($token))
            {
                throw new Exception("Token no valido.");
            }
            
            $decode = JWT::decode(
                $token,
                self::$restaurantLoloToken,
                self::$encrypt
            );
            
            if($decode->aud !== self::Aud())
            {
                throw new Exception("Usuario invalido.");
            }
        }
        
        public static function ObtenerDatos($token)
        {
            return JWT::decode(
                $token,
                self::$restaurantLoloToken,
                self::$encrypt
            )->data;
        }
        
        private static function Aud()
        {
            $aud = '';
            
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $aud = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $aud = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $aud = $_SERVER['REMOTE_ADDR'];
            }
            
            $aud .= @$_SERVER['HTTP_USER_AGENT'];
            $aud .= gethostname();
            
            return sha1($aud);
        }
    }
?>