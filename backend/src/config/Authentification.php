<?php
namespace MyApp\Config;
require "../configkey.php";
use \Firebase\JWT\JWT;
use Exception;

class Authentification{
    protected $secret_key;
    protected $jwt;
    protected $authHeader;

    public function __construct(){
        $this->secret_key = secret;
        $this->jwt = null;
    }

    public function getToken(){
        $headers = apache_request_headers();
        foreach ($headers as $header => $value) {
            if($header == 'Authorization'){
                $token = $value;
            }
        }
        return $token;
    }

    public function getSecretKey(){
        return $this->secret_key;
    }

    public function createTokenAuthentification($user){
         $tokenKey = $this->getSecretKey();
         $tokenId = base64_encode(random_bytes(32));
         $issuedat_claim = time(); // issued at
         $notbefore_claim = $issuedat_claim + 10; //not before in seconds
         $expire_claim = $issuedat_claim + 1800; // expire time in seconds -- 30min session time.
         $token = array(
             "iat" => $issuedat_claim,
             // "nbf" => $notbefore_claim,
             "exp" => $expire_claim,
             "jti" => $tokenId,
             "data" => array(
                 "Id" => $user['id'],
                 "Pseudo" => $user['pseudo'],
                 "Email" => $user['email'],
                 "Date_Creation" => $user['date_creation'],
                 "Rôle" => $user['role_id']
         ));
         $jwt = JWT::encode($token, $tokenKey);
         $data['message'] = "Successful login.";
         $data['user'] = $user;
         $data['sessionConnected'] = true;
         $data['jwt'] = $jwt;
         $data['expireAt'] = $expire_claim;
         return $data;
    }

    public function checkAuthentification(){
        $this->authHeader = $this->getToken();
        if($this->authHeader){
            $arr = explode(" ", $this->authHeader);
            $arr2 = str_replace("\"","", $arr[1]);
            $this->jwt = $arr2;

            if($this->jwt){
                try {
                    $decoded = JWT::decode($this->jwt, $this->secret_key, ['HS256']);
                    // Access is granted. Add code of the operation here 
                    $data['access'] = true;
                    $data['message'] = 'Access granted:';
                    header('HTTP/1.1 200 OK');
                    return $data;
                    // echo json_encode(array(
                    //     "access" => true,
                    //     "message" => "Access granted:"
                    // ));
                }catch (Exception $e){
                    $data['access'] = false;
                    $data['message'] = 'Access Denied:';
                    header('HTTP/1.1 401 Unauthorized');
                    return $data;
                    // echo json_encode(array(
                    //     "message" => "Access denied."
                    // ));
                }
            }
        }
    }
}
?>