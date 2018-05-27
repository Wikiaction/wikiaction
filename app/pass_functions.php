<?php

function generate_hash($pass){
	$salt = str_replace('+', '.', base64_encode(mcrypt_create_iv(17,MCRYPT_DEV_URANDOM)));
	return crypt($pass, '$2y$' . 10 . '$' . $salt .'$');
}
function is_pass_valid($pass,$hash){
	return $hash === crypt($pass, $hash);
}
?>