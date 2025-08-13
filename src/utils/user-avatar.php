<?php
function avatarui($nome)
{
    $iniciais = "";
    $palavras = explode(" ", $nome);
    foreach ($palavras as $palavra) {
        if (!empty($palavra)) {
            $iniciais .= strtoupper(substr($palavra, 0, 1));
        }
    }
    if (strlen($iniciais) > 2) {
        $iniciais = substr($iniciais, 0, 2);
    }
    return "https://ui-avatars.com/api/?name=" . urlencode($iniciais) . "&background=random&color=fff&size=128";
}
?>