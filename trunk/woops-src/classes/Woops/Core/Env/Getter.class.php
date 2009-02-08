<?php
################################################################################
#                                                                              #
#                WOOPS - Web Object Oriented Programming System                #
#                                                                              #
#                               COPYRIGHT NOTICE                               #
#                                                                              #
# (c) 2009 eosgarden - Jean-David Gadina (macmade@eosgarden.com)               #
# All rights reserved                                                          #
################################################################################

# $Id$

/**
 * WOOPS environment class
 *
 * @author      Jean-David Gadina <macmade@eosgarden.com>
 * @version     1.0
 * @package     Woops.Core.Env
 */
final class Woops_Core_Env_Getter implements Woops_Core_Singleton_Interface
{
    /**
     * The minimum version of PHP required to run this class (checked by the WOOPS class manager)
     */
    const PHP_COMPATIBLE = '5.2.0';
    
    /**
     * The unique instance of the class (singleton)
     */
    private static $_instance = NULL;
    
    /**
     * An array with references to $_SERVER and $_ENV
     */
    private $_envVars         = array(
        '_SERVER' => array(),
        '_ENV'    => array()
    );
    
    /**
     * 
     */
    private $_serverVars      = array();
    
    /**
     * 
     */
    private $_woopsVars       = array(
        'sys' => array(
            'root'   => '',
            'src'    => ''
        ),
        'web' => array(
            'root'   => '',
            'src'    => ''
        )
    );
    
    /**
     * Class constructor
     * 
     * The class constructor is private to avoid multiple instances of the
     * class (singleton).
     * 
     * @return NULL
     */
    private function __construct()
    {
        // Stores references to the environment vars
        $this->_envVars[ '_SERVER' ]  = &$_SERVER;
        $this->_envVars[ '_ENV' ]     = &$_ENV;
        
        $scriptFileName = $this->getVar( 'SCRIPT_FILENAME' );
        $scriptName     = $this->getVar( 'SCRIPT_NAME' );
        
        // Stores the paths to the WOOPS root and source directories
        $this->_woopsVars[ 'sys' ][ 'root' ] = str_replace( 'index.php', '', $scriptFileName );
        $this->_woopsVars[ 'sys' ][ 'src' ]  = realpath(
            dirname( __FILE__ )
          . DIRECTORY_SEPARATOR
          . '../'
          . DIRECTORY_SEPARATOR
          . '../'
          . DIRECTORY_SEPARATOR
          . '../'
          . DIRECTORY_SEPARATOR
          . '../'
        ) . DIRECTORY_SEPARATOR;
        
        $this->_woopsVars[ 'web' ][ 'root' ] = str_replace(
            DIRECTORY_SEPARATOR,
            '/',
            str_replace(
                'index.php',
                '',
                $scriptName
            )
        );
        
        $homeDir = ( substr( $scriptName, 0, 2 ) === '/~' ) ? substr( $scriptName, 0, strpos( $scriptName, '/', 1 ) ) : '';
        
        $this->_woopsVars[ 'web' ][ 'src' ] = $homeDir . str_replace(
            DIRECTORY_SEPARATOR,
            '/',
            str_replace(
                $this->getVar( 'DOCUMENT_ROOT' ),
                '',
                $this->_woopsVars[ 'sys' ][ 'src' ]
            )
        );
    }
    
    /**
     * Clones an instance of the class
     * 
     * A call to this method will produce an exception, as the class cannot
     * be cloned (singleton).
     * 
     * @return  NULL
     * @throws  Woops_Core_Singleton_Exception  Always, as the class cannot be cloned (singleton)
     */
    public function __clone()
    {
        throw new Woops_Core_Singleton_Exception(
            'Class ' . __CLASS__ . ' cannot be cloned',
            Woops_Core_Singleton_Exception::EXCEPTION_CLONE
        );
    }
    
    /**
     * 
     */
    public function __get( $name )
    {
        return $this->getVar( $name );
    }
    
    /**
     * Gets the unique class instance
     * 
     * This method is used to get the unique instance of the class
     * (singleton). If no instance is available, it will create it.
     * 
     * @return  Woops_Core_Env_Getter   The unique instance of the class
     * @see     __construct
     */
    public static function getInstance()
    {
        // Checks if the unique instance already exists
        if( !is_object( self::$_instance ) ) {
            
            // Creates the unique instance
            self::$_instance = new self();
        }
        
        // Returns the unique instance
        return self::$_instance;
    }
    
    /**
     * Register an server variable.
     *
     * This method is used to register a server variable (either $_SERVER or $_ENV).
     * Valid server variables will be stored in static property $_serverVars.
     * 
     * @param   string  The server variable to register
     * @return  boolean
     */
    private function _setServerVar( $var, $lookup )
    {
        $result = false;
        
        switch ( $var ) {
            
            case 'PHP_SAPI_NAME':
                
                $this->_serverVars[ $var ] = php_sapi_name();
                $result                    = true;
                break;
            
            case 'SCRIPT_NAME':
                
                $sapi = $this->getVar( 'PHP_SAPI_NAME' );
                
                if( $this->getVar( 'ORIG_PATH_INFO' ) ) {
                    
                    $this->_serverVars[ 'ORIG_PATH_INFO' ];
                    
                } else {
                    
                    $this->getVar( 'PATH_INFO' );
                }
                
                // Check SAPI
                if( ( $sapi === 'cgi' || $sapi === 'cgi-fcgi' ) && $pathInfo ) {
                    
                    $scriptName = $pathInfo;
                    
                } elseif( $this->getVar( 'ORIG_SCRIPT_NAME' ) ) {
                    
                    $scriptName = $this->_serverVars[ 'ORIG_SCRIPT_NAME' ];
                    
                } elseif( isset( $this->_envVars[ $lookup ][ 'SCRIPT_NAME' ] ) ) {
                    
                    $scriptName = $this->_envVars[ $lookup ][ 'SCRIPT_NAME' ];
                    
                } else {
                    
                    $scriptName = NULL;
                }
                
                // Store variable
                $this->_serverVars[ $var ] = $scriptName;
                $result                    = true;
                break;
            
            case 'SCRIPT_FILENAME':
                
                $sapi = $this->getVar( 'PHP_SAPI_NAME' );
                
                if( $this->getVar( 'ORIG_PATH_TRANSLATED' ) ) {
                    
                    $pathTranslated = $this->_serverVars[ 'ORIG_PATH_TRANSLATED' ];
                    
                } else {
                    
                    $pathTranslated = $this->getVar( 'PATH_TRANSLATED' );
                }
                
                // Check SAPI
                if( ( $sapi === 'cgi' || $sapi === 'cgi-fcgi' || $sapi === 'isapi' ) && $pathTranslated ) {
                    
                    $scriptFileName = $pathTranslated;
                    
                } elseif( $this->getVar( 'ORIG_SCRIPT_FILENAME' ) ) {
                    
                    $scriptFileName = $this->_serverVars[ 'ORIG_SCRIPT_FILENAME' ];
                    
                } elseif( isset( $this->_envVars[ $lookup ][ 'SCRIPT_FILENAME' ] ) ) {
                    
                    $scriptFileName = $this->_envVars[ $lookup ][ 'SCRIPT_FILENAME' ];
                    
                } else {
                    
                    $scriptFileName = NULL;
                }
                
                // Check slashes
                $scriptFileName = str_replace( '\\', '/', $scriptFileName );
                $scriptFileName = str_replace( '//', '/', $scriptFileName );
                
                // Store variable
                $this->_serverVars[ $var ] = $scriptFileName;
                $result                    = true;
                break;
            
            case 'HTTPS':
                
                $this->_serverVars[ $var ] = ( isset( $this->_envVars[ $lookup ][ $var ] ) && $this->_envVars[ $lookup ][ $var ] != 'off' ) ? true : false;
                break;
                
            case 'REQUEST_URI':
                
                if( isset( $this->_envVars[ $lookup ][ 'REQUEST_URI' ] ) ) {
                    
                    $requestUri = $this->_envVars[ $lookup ][ 'REQUEST_URI' ];
                    
                } elseif( $this->getVar( 'SCRIPT_NAME' ) ) {
                    
                    if( $this->getVar( 'QUERY_STRING' ) ) {
                        
                        $requestUri  = $this->_serverVars[ 'SCRIPT_NAME' ];
                        
                        $requestUri .= '?' . $this->_serverVars[ 'QUERY_STRING' ];
                        
                    } else {
                        
                        $requestUri = $this->_serverVars[ 'SCRIPT_NAME' ];
                    }
                    
                } else {
                    
                    $requestUri = NULL;
                }
                
                // Store variable
                $this->_serverVars[ $var ] = $requestUri;
                $result                    = true;
                break;
            
            case 'DOCUMENT_ROOT':
                
                $scriptName                = $this->getVar( 'SCRIPT_NAME' );
                $scriptFileName            = $this->getVar( 'SCRIPT_FILENAME' );
                
                if( substr( $scriptName, 0, 2 ) === '/~' ) {
                    
                    $secondSlashPos            = strpos( $scriptName, '/', 1 );
                    $webPart                   = substr( $scriptName, $secondSlashPos );
                    $this->_serverVars[ $var ] = str_replace( $webPart, '', $scriptFileName );
                    
                } else {
                    
                    $this->_serverVars[ $var ] = str_replace( $scriptName, '', $scriptFileName );
                }
                $result = true;
                break;
                
            // Default processing
            default:
                
                // Check for requested variable in ${ $lookup }
                if( isset( $this->_envVars[ $lookup ][ $var ] ) ) {
                    
                    $this->_serverVars[ $var ] = $this->_envVars[ $lookup ][ $var ];
                    $result                    = true;
                }
                break;
        }
        
        return $result;
    }
    
    /**
     * 
     */
    public function getPath( $path )
    {
        $absPath = $this->_woopsVars[ 'sys' ][ 'root' ]
                 . str_replace( '/', DIRECTORY_SEPARATOR, $path );
        
        return ( file_exists( $absPath ) ) ? $absPath : false;
    }
    
    /**
     * 
     */
    public function getSourcePath( $path )
    {
        $absPath = $this->_woopsVars[ 'sys' ][ 'src' ]
                 . str_replace( '/', DIRECTORY_SEPARATOR, $path );
        
        return ( file_exists( $absPath ) ) ? $absPath : false;
    }
    
    /**
     * 
     */
    public function getWebPath( $path )
    {
        $webPath = $this->_woopsVars[ 'web' ][ 'root' ] . $path;
        $absPath = $this->_woopsVars[ 'sys' ][ 'src' ]
                 . str_replace( '/', DIRECTORY_SEPARATOR, $path );
        
        return ( file_exists( $absPath ) ) ? $absPath : false;
    }
    
    /**
     * 
     */
    public function getSourceWebPath( $path )
    {
        $webPath = $this->_woopsVars[ 'web' ][ 'src' ] . $path;
        $absPath = $this->_woopsVars[ 'sys' ][ 'src' ]
                 . str_replace( '/', DIRECTORY_SEPARATOR, $path );
        
        return ( file_exists( $absPath ) ) ? $absPath : false;
    }
    
    /**
     * Get a server variable.
     *
     * This method is used to get a server variable (either $_SERVER or $_ENV),
     * If the variable is not already registered, it will
     * first set it using method _setServerVar.
     * 
     * @param   string  The server variable to get
     * @return  string  The server variable, if available
     * @see     _setServerVar
     */
    public function getVar( $var )
    {
        $var = ( string )$var;
        
        if( isset( $this->_serverVars[ $var ] ) ) {
            
            return $this->_serverVars[ $var ];
            
        } elseif( $this->_setServerVar( $var, '_SERVER' ) ) {
            
            return $this->_serverVars[ $var ];
            
        } elseif( $this->_setServerVar( $var, '_ENV' ) ) {
            
            return $this->_serverVars[ $var ];
        }
        
        return false;
    }
}
