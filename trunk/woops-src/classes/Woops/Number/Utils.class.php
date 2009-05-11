<?php
################################################################################
#                                                                              #
#                WOOPS - Web Object Oriented Programming System                #
#                                                                              #
#                               COPYRIGHT NOTICE                               #
#                                                                              #
# Copyright (C) 2009 Jean-David Gadina (macmade@eosgarden.com)                 #
# All rights reserved                                                          #
################################################################################

# $Id$

// File encoding
declare( ENCODING = 'UTF-8' );

// Internal namespace
namespace Woops\Number;

/**
 * Number related utilities
 *
 * @author      Jean-David Gadina <macmade@eosgarden.com>
 * @version     1.0
 * @package     Woops.Number
 */
final class Utils extends \Woops\Core\Object implements \Woops\Core\Singleton\ObjectInterface
{
    /**
     * The minimum version of PHP required to run this class (checked by the WOOPS class manager)
     */
    const PHP_COMPATIBLE = '5.3.0RC2';
    
    /**
     * The unique instance of the class (singleton)
     */
    private static $_instance = NULL;
    
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
     * @throws  Woops\Core\Singleton\Exception  Always, as the class cannot be cloned (singleton)
     */
    public function __clone()
    {
        throw new \Woops\Core\Singleton\Exception(
            'Class ' . __CLASS__ . ' cannot be cloned',
            \Woops\Core\Singleton\Exception::EXCEPTION_CLONE
        );
    }
    
    /**
     * Gets the unique class instance
     * 
     * This method is used to get the unique instance of the class
     * (singleton). If no instance is available, it will create it.
     * 
     * @return  Woops\Array\Utils   The unique instance of the class
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
     * Ensures a number is in a specified range
     * 
     * This method forces the specified number into the boundaries of a
     * minimum and maximum number.
     * 
     * @param   numbe   The number to check
     * @param   number  The minimum value
     * @param   number  The maximum value
     * @param   boolean Evaluates the number as an integer
     * @return  number  A number in the specified range
     */
    public function inRange( $number, $min, $max, $int = false )
    {
        // Checks if we must evaluate the number as an integer
        if( $int ) {
            
            // Converts the number to an integer
            $number = ( int )$number;
        }
        
        // Checks the number
        if( $number > $max ) {
            
            // Number is bigger than maximum value
            $number = $max;
            
        } elseif( $number < $min ) {
            
            // Number is smaller than minimal value
            $number = $min;
        }
        
        // Returns the number
        return $number;
    }
}
