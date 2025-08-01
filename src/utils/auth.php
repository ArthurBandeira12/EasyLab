<?php
function isAdmin(): bool {
    return isset($_SESSION['papel']) && $_SESSION['papel'] === 'admin';
}