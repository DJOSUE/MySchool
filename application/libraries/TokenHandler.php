<?php
require APPPATH . '/libraries/JWT.php';
class TokenHandler
{
   //////////The function generate token/////////////
   PRIVATE $key = "my-school-api-token-handler";
   public function GenerateToken($userdata)
   {
        $issuedAt   = new DateTimeImmutable();
        $expire     = $issuedAt->modify('+60 minutes')->getTimestamp();      // Add 60 seconds
        $serverName = $this->crud->getInfo('system_domain'); 
        $username   = $userdata['username'];
        $userRole   = $userdata['user_role'];

        $data = [
            'iat'       => $issuedAt->getTimestamp(),         // Issued at: time when the token was generated
            'iss'       => $serverName,                       // Issuer
            'nbf'       => $issuedAt->getTimestamp(),         // Not before
            'exp'       => $expire,                           // Expire
            'userName'  => $username,                         // User name
            'userRole'  => $userRole,                         // User Role
        ];
       $jwt = JWT::encode($data, $this->key);
       return $jwt;
   }

  //////This function decode the token////////////////////
   public function DecodeToken($token)
   {
       $decoded = JWT::decode($token, $this->key, array('HS256'));
       $decodedData = (array) $decoded;
       return $decodedData;
   }
}
?>
