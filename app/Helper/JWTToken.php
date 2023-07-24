<?php
namespace App\Helper;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use PhpParser\Node\Expr\Cast\Object_;

class JWTToken {

   public static function createToken($userEmail, $userID){

        $key = env('JWT_KEY');
       $payload=[
           'iss'=>'laravel-token',
           'iat'=>time(),
           'exp'=>time()+60*60,
           'userEmail'=>$userEmail,
           'userId' => $userID,
       ];

       return JWT::encode($payload, $key, 'HS256');
    }

    public static function createTokenResetPassword($userEmail, $userID){

        $key = env('JWT_KEY');
       $payload=[
           'iss'=>'laravel-token',
           'iat'=>time(),
           'exp'=>time()+60*20,
           'userEmail'=>$userEmail,
           'userId' => '0',
       ];

       return JWT::encode($payload, $key, 'HS256');
    }

  public static function verifyToken($token):string|Object{

      try {
          if($token==null){
              return 'unauthorized';
          }
          $key =env('JWT_KEY');
          $decoded=JWT::decode($token,new Key($key,'HS256'));
          return $decoded->userEmail;
      }
      catch (Exception $e){
          return 'unauthorized';
      }
    }
}
