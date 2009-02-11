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
 * Getter class for the language labels
 *
 * @author      Jean-David Gadina <macmade@eosgarden.com>
 * @version     1.0
 * @package     Woops.Lang
 */
final class Woops_Lang_Getter implements Woops_Core_Singleton_Interface
{
    /**
     * The minimum version of PHP required to run this class (checked by the WOOPS class manager)
     */
    const PHP_COMPATIBLE = '5.2.0';
    
    /**
     * An array with the instances of the class (multi-singleton)
     */
    private static $_instances           = array();
    
    /**
     * The number of instances
     */
    private static $_nbInstances         = 0;
    
    /**
     * The name of the default instance (will be set when the default instance is created)
     */
    private static $_defaultInstanceName = '';
    
    /**
     * Wether the static variables are set or not
     */
    private static $_hasStatic           = false;
    
    /**
     * The environment object
     */
    private static $_env                 = NULL;
    
    /**
     * The default language
     */
    private static $_defaultLanguage     = 'en';
    
    /**
     * The current language
     */
    private static $_language            = '';
    
    /**
     * The SimpleXMLElement object containing tha language labels
     */
    private $_labels                     = NULL;
    
    /**
     * The name of the current instance (multi-singleton)
     */
    private $_instanceName               = '';
    
    /**
     * Class constructor
     * 
     * The class constructor is private to avoid multiple instances of the
     * class (singleton).
     * 
     * @return NULL
     */
    private function __construct( $path )
    {
        // Sets the current instance name
        $this->_instanceName = $path;
        
        // Checks if the static variables are set
        if( !self::$_hasStatic ) {
            
            // Sets the static variables
            self::_setStaticVars();
        }
        
        $langFile = $path
                  . self::$_language
                  . '.xml';
        
        if( !file_exists( $langFile ) ) {
            
            $langFile = $path
                      . self::$_defaultLanguage
                      . '.xml';
        }
        
        if( !file_exists( $langFile ) ) {
            
            throw new Woops_Lang_Getter_Exception(
                'The lang file does not exist (path: ' . $langFile . ')',
                Woops_Lang_Getter_Exception::EXCEPTION_NO_LANG_FILE
            );
        }
        
        try {
            
            $this->_labels = simplexml_load_file( $langFile );
            
        } catch( Exception $e ) {
            
            throw new Woops_Lang_Getter_Exception(
                $e->getMessage(),
                Woops_Lang_Getter_Exception::EXCEPTION_BAD_XML
            );
        }
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
        return $this->getLabel( $name );
    }
    
    /**
     * Sets the needed static variables
     * 
     * @return  NULL
     */
    private static function _setStaticVars()
    {
        // Gets the instance of the environment class
        self::$_env       = Woops_Core_Env_Getter::getInstance();
        
        // Static variables are set
        self::$_hasStatic = true;
    }
    
    /**
     * 
     */
    public static function getInstance( $path, $filePrefix = '' )
    {
        // Checks if the default instance already exist
        if( !self::$_nbInstances ) {
            
            // Sets the name of the default instance
            self::$_defaultInstanceName = Woops_Core_Env_Getter::getInstance()->getSourcePath( 'lang/default/' );
            
            // Creates the default instance
            new self( self::$_defaultInstanceName );
        }
        
        // Creates the required instance if it does not exists
        if( !isset( self::$_instances[ $path . $filePrefix ] ) ) {
            
            // Registers the current instance
            self::$_instances[ $path . $filePrefix ] = new self( $path . $filePrefix );
            self::$_nbInstances++;
        }
        
        // Returns the required instance
        return self::$_instances[ $path . $filePrefix ];
    }
    
    /**
     * 
     */
    public static function setDefaultLanguage( $language )
    {
        $oldLanguage            = self::$_defaultLanguage;
        
        self::$_defaultLanguage = $language;
        
        return $oldLanguage;
    }
    
    /**
     * 
     */
    public static function getDefaultLanguage()
    {
        return self::$_defaultLanguage;
    }
    
    /**
     * 
     */
    public function getLabel( $name )
    {
        if( isset( $this->_labels->labels->$name ) ) {
            
            return nl2br( ( string )$this->_labels->labels->$name );
        }
        
        if( isset( self::$_instances[ self::$_defaultInstanceName ]->_labels->labels->$name ) ) {
            
            return nl2br( ( string )self::$_instances[ self::$_defaultInstanceName ]->_labels->labels->$name );
        }
        
        return '[LABEL: ' . $name . ']';
    }
}
