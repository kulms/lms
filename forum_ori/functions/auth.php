<?php

/**
 * auth.php
 *
 * Copyright (c) 1999-2002 The SquirrelMail Project Team
 * Licensed under the GNU GPL. For full terms see the file COPYING.
 *
 * Contains functions used to do authentication.
 *
 * $Id: auth.php,v 1.24 2002/04/06 21:00:18 graf25 Exp $
 */

function is_logged_in() {

    if ( session_is_registered('user_is_logged_in') ) {
    	return;
    } else {	
        include_once( '../functions/display_messages.php' );
        logout_error( _("You must be logged in to access this page.") );
        exit;
    }
} 

?>