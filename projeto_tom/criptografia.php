
<?php

$chave = "123456";

function criptografarCPF($cpf) {
    global $chave;

    return openssl_encrypt(
        $cpf,
        'AES-128-ECB',
        $chave
    );
}

function descriptografarCPF($cpf) {
    global $chave;

    return openssl_decrypt(
        $cpf,
        'AES-128-ECB',
        $chave
    );
}
