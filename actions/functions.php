<?php
 session_start();
function isUserLoggedIn() {
    // Check if a specific session variable exists (e.g., 'user_id')
    if (isset($_SESSION['user'])) {
        return true;
    } else {
        return false;
    }
};

function isUser(){
    if($_SESSION['type'] == 'user')
        return true;
    return false;
}
function isAgent(){
    if($_SESSION['type'] == 'agent')
        return true;
    return false;
};

function isAdmin(){
    if($_SESSION['type'] == 'admin')
        return true;
    return false;
};
