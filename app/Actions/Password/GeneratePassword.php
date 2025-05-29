<?php

namespace App\Actions\Password;

class GeneratePassword
{
    protected function generate(int $size = 8): string
    {
        $randonBytes = random_bytes($size * 2);
        $password = substr(base64_encode($randonBytes), 0, $size);

        $password = preg_replace('/[^a-zA-Z0-9]/', '', $password);
        
        while (strlen($password) < $size) {
            $bytesAdicionais = random_bytes(1);
            $password .= preg_replace('/[^a-zA-Z0-9]/', '', base64_encode($bytesAdicionais));
            $password = substr($password, 0, $size);
        }

        return $password;
    }

    public static function run(int $size = 8): string
    {
        return (new self())->generate($size);
    }
}