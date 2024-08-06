<?php

/**
 * Shortcut for define() but with a twist of validating the definition's previous existence.
 * 
 * @param string $name The definition name.
 * @param mixed $value The defined value.
 */
function def($name, $value)
{
    if (!defined($name)) {
        define($name, $value);
    }
}

def('BASE_URL', "http://interlinkiq.com/");

def('DEFAULT_TIMEZONE', 'America/Chicago');

// current Consultare Inc. Group ID from the tbl_user table
def('CIG_USER_ID', 34);

// Arnel's data
def('ARNEL_RYAN_SIGN_PNG', BASE_URL . 'assets/arnel_signature.png');
def('ARNEL_RYAN_TITLE', 'FSC, PCQI, FSVPQI'); // as of 2024
