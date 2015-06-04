<?php
class Functions{

    function __construct() {

    }

    function __destruct() {
        // $this->close();
    }



    public function hashSSHA($password) {


        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }

    public function checkhashSSHA($salt, $password) {

        $hash = base64_encode(sha1($password . $salt, true) . $salt);

        return $hash;
    }

    function encryptIt( $q ) {
        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $cryptKey  = $salt;
        $qEncoded      = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $q, MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ) );
        $hash = array("salt" => $salt, "encrypted" => $qEncoded);
        return( $hash );
    }

    function decryptIt( $q,$salt ) {
        $cryptKey  = $salt;
        $qDecoded      = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $q ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
        return( $qDecoded );
    }

}

?>