<?
/*
#===========================================================================
#= Script : EGAT e-Learning
#= Author : S.Kongdej
#= Web Designer: somboonph@egat.or.th
#= Email  : skongdej@hotmail.com
#= Support: http://www.learningnuke.com
#===========================================================================
#= Copyright (c) 2004 Electricity Generating Authority of Thailand,Jongdee Group
#= You are free to use and modify this script as long as this header
#=
#= This program is free software; you can redistribute it and/or modify
#= it under the terms of the GNU General Public License as published by
#= the Free Software Foundation; either version 2 of the License, or
#= (at your option) any later version.
#=
#= This program is distributed in the hope that it will be useful,
#= but WITHOUT ANY WARRANTY; without even the implied warranty of
#= MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#= GNU General Public License for more details.
#=
#= You should have received a copy of the GNU General Public License
#= along with this program; if not, write to the Free Software
#= Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
#===========================================================================
*/

// For Global register =Off
if (phpversion() >= "4.2.0") {
	if ( ini_get('register_globals') != 1 ) {
		$supers = array('_REQUEST',
                                '_ENV',
                                '_SERVER',
                                '_POST',
                                '_GET',
                                '_COOKIE',
                                '_SESSION',
                                '_FILES',
                                '_GLOBALS' );

		foreach( $supers as $__s) {
			if ( (isset($$__s) == true) && (is_array( $$__s ) == true) ) extract( $$__s, EXTR_OVERWRITE );
		}
		unset($supers);
	}
} else {
	if ( ini_get('register_globals') != 1 ) {

		$supers = array('HTTP_POST_VARS',
                                'HTTP_GET_VARS',
                                'HTTP_COOKIE_VARS',
                                'GLOBALS',
                                'HTTP_SESSION_VARS',
                                'HTTP_SERVER_VARS',
                                'HTTP_ENV_VARS'
                                 );

		foreach( $supers as $__s) {
			if ( (isset($$__s) == true) && (is_array( $$__s ) == true) ) extract( $$__s, EXTR_OVERWRITE );
		}
		unset($supers);
	}
}

// Session variable
	$usersess = new Session();

///////////////////////////////////////////////////////////////////
//
//You can register your global variables for use like this:
//
// register a GET var
// var_register('GET', 'user_id', 'password');
//
// register a server var
// var_register('SERVER', 'PHP_SELF');
//
// register some POST vars
// var_register('POST', 'submit', 'field1', 'field2', 'field3');
//
///////////////////////////////////////////////////////////////////


function var_register()
{
		$num_args = func_num_args();
		$vars = array();

		if ($num_args >= 2) {
			$method = strtoupper(func_get_arg(0));

			if (($method != 'SESSION') && ($method != 'GET') && ($method != 'POST') && ($method != 'SERVER') && ($method != 'COOKIE') && ($method != 'ENV')) {
				die('The first argument of var_register must be one of the following: GET, POST, SESSION, SERVER, COOKIE, or ENV');
			}

			$varname = "HTTP_{$method}_VARS";
			global ${$varname};

			for ($i = 1; $i < $num_args; $i++) {
				$parameter = func_get_arg($i);

				if (isset(${$varname}[$parameter])) {
					global $$parameter;
					$$parameter = ${$varname}[$parameter];
				}

			}

		} else {
			die('You must specify at least two arguments');
		}

}


/***************************************************/
/* Session-Class v1.0.0                            */
/* Author: tgc_md                                  */
/* Date: 03.02.2003                                */
/* E-Mail: tgc_md@tool-garage.de                   */
/* Website: http://www.tool-garage.de              */
/***************************************************/

    class Session
    {
        // constructor
        function Session()
        {
            session_start();
        }
        
        
        // sets a session-variable
        function set_var( $varname, $varvalue )
        {
            if( !isset($varname) || !isset($varvalue) )
                die("Function setvar( String \$varname, mixed \$value ) expects two parameters!");
            
            if( phpversion() >= "4.1.0" )
                $_SESSION[$varname] = $varvalue;
                if( !isset($GLOBALS[$varname]) )
                    $GLOBALS[$varname] = $varvalue;
            else
            {
                global $HTTP_SESSION_VARS;
                session_register($varname);
                $GLOBALS['HTTP_SESSION_VARS'][$varname] = $varvalue;
                if( !isset($GLOBALS[$varname]) )
                    $GLOBALS[$varname] = $varvalue;
                
            }
        }

        
        // returns the value of a certain session-variable
        function get_var( $varname )
        {
            if( !isset($varname) )
                die("Function getvar( String \$varname ) expects a parameter!");
            
            if( phpversion() >= "4.1.0" )
            {
                if (isset($GLOBALS[$varname])) 
                    return $GLOBALS[$varname];
                elseif (isset($GLOBALS['_SESSION'][$varname])) 
                {
                    $GLOBALS[$varname] = $GLOBALS['_SESSION'][$varname];
                    return $GLOBALS['_SESSION'][$varname];
                }
            }
            else
            {
                if (isset($GLOBALS[$varname])) 
                    return $GLOBALS[$varname];
                elseif (isset($GLOBALS['HTTP_SESSION_VARS'][$varname])) 
                {
                    $GLOBALS[$varname] = $GLOBALS['HTTP_SESSION_VARS'][$varname];
                    return $GLOBALS['HTTP_SESSION_VARS'][$varname];
                }
            }
        }
        
        
        // returns a string like "PHPSESSID=b188e8c9c45b347cdded2..."
        function get_sid_string()
        {
            return session_name() . "=" . session_id();
        }
        
        
        // returns the session-id
        function get_sid()
        {
            return session_id();
        }
        
        
        // unsets a certain session-variable
        function var_unset( $varname )
        {
            if( !isset($varname) )
                die("Function var_unset( String \$varname ) expects a parameter!");
            
            if( phpversion() >= "4.1.0" )
            {
                if (isset($GLOBALS[$varname])) 
                    unset( $GLOBALS[$varname] );
                if (isset($GLOBALS['_SESSION'][$varname])) 
                    unset( $GLOBALS['_SESSION'][$varname] );
            }
            else
            {
                if (isset($GLOBALS[$varname])) 
                    unset( $GLOBALS[$varname] );
                if (isset($GLOBALS['HTTP_SESSION_VARS'][$varname])) 
                    unset( $GLOBALS['HTTP_SESSION_VARS'][$varname] );
            }
        }
        
        
        // unsets the value of every session-variable
        function ses_unset()
        {
            if( phpversion() >= "4.1.0" )
            {
                if( isset($GLOBALS['_SESSION']) ) $a = $GLOBALS['_SESSION'];
                while( list($key,) = each($a) )
                    $this->var_unset($key);
            }      
            else
            {
                if( isset($GLOBALS['HTTP_SESSION_VARS']) ) $a = $GLOBALS['HTTP_SESSION_VARS'];
                while( list($key,) = each($a) )
                    $this->var_unset($key);
            }
        }
        
        
        //deletes every session-variable and destroys the Session
        function destroy()
        {
            $this->ses_unset();
            session_destroy();
        }
        
        
        // shows the variables currently set in the session 
        function show()
        {
            echo "Variables set in current session:<br />\n";
            if( phpversion() >= "4.1.0" )
            {
                if( isset($GLOBALS['_SESSION']) ) $a = $GLOBALS['_SESSION'];
                while( list($key,$value) = each($a) )
                    echo "Variable: $key - Value: $value<br />\n";
                    
            }    
            else
            {
                if( isset($GLOBALS['HTTP_SESSION_VARS']) ) $a = $GLOBALS['HTTP_SESSION_VARS'];
                while( list($key,$value) = each($a) )
                    echo "Variable: $key - Value: $value<br />\n";
            }
        }
    }

?>
