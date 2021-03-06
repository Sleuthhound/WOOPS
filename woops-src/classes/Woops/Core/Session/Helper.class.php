<?php
################################################################################
#                                                                              #
#                WOOPS - Web Object Oriented Programming System                #
#                                                                              #
#                               COPYRIGHT NOTICE                               #
#                                                                              #
# Copyright (C) 2009 Jean-David Gadina - www.xs-labs.com                       #
# All rights reserved                                                          #
################################################################################

# $Id$

/**
 * Session helper class
 *
 * @author      Jean-David Gadina - www.xs-labs.com
 * @version     1.0
 * @package     Woops.Core.Session
 */
final class Woops_Core_Session_Helper extends Woops_Core_Object implements Woops_Core_Singleton_Interface
{
    /**
     * The minimum version of PHP required to run this class (checked by the WOOPS class manager)
     */
    const PHP_COMPATIBLE = '5.2.0';
    
    /**
     * The session ID for the WOOPS
     */
    const SESSION_ID     = 'WOOPS-SESSION';
    
    /**
     * The unique instance of the class (singleton)
     */
    private static $_instance = NULL;
    
    /**
     * Whether the WOOPS session is started
     */
    protected $_started     = '';
    
    /**
     * Class constructor
     * 
     * The class constructor is private to avoid multiple instances of the
     * class (singleton).
     * 
     * @return  void
     */
    private function __construct()
    {}
    
    /**
     * Clones an instance of the class
     * 
     * A call to this method will produce an exception, as the class cannot
     * be cloned (singleton).
     * 
     * @return  void
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
        return $this->getSessionData( $name );
    }
    
    /**
     * 
     */
    public function __set( $name, $value )
    {
        $this->setSessionData( $name, $value );
    }
    
    /**
     * 
     */
    public function __isset( $name )
    {
        $this->start();
        
        $isset = isset( $_SESSION[ $name ] );
        
        $this->close();
        
        return $isset;
    }
    
    /**
     * 
     */
    public function __unset( $name )
    {
        $this->start();
        
        unset( $_SESSION[ $name ] );
        
        $this->close();
    }
    
    /**
     * Gets the unique class instance
     * 
     * This method is used to get the unique instance of the class
     * (singleton). If no instance is available, it will create it.
     * 
     * @return  Woops_Core_Session_Helper   The unique instance of the class
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
     * 
     */
    public function start()
    {
        if( !$this->_started ) {
            
            session_id( self::SESSION_ID );
            session_start();
            $this->_started = true;
        }
    }
    
    /**
     * 
     */
    public function close()
    {
        if( $this->_started ) {
            
            session_write_close();
            $this->_started = false;
            $_SESSION = array();
        }
    }
    
    /**
     * 
     */
    public function destroy()
    {
        if( $this->_started ) {
            
            session_destroy();
            $this->_started = false;
            $_SESSION = array();
        }
    }
    
    /**
     * 
     */
    public function getSessionData( $key )
    {
        $this->start();
        
        if( isset( $_SESSION[ $key ] ) ) {
            
            return $_SESSION[ $key ];
            
        } else {
            
            return false;
        }
        
        $this->close();
    }
    
    /**
     * 
     */
    public function setSessionData( $key, $value )
    {
        $this->start();
        
        $_SESSION[ $key ] = $value;
        
        $this->close();
    }
}
