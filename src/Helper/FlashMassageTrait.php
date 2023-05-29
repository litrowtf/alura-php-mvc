<?php

declare(strict_types=1);

namespace Alura\Mvc\Helper;

//Trait para reutilizar código (herança horizontal)
trait FlashMassageTrait
{
    private function addErrorMassage(string $erroMassage): void
    {
        $_SESSION['error_message'] = $erroMassage;
    }

}