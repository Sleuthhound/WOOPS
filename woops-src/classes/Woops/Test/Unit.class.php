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

# $Id: Angle.class.php 434 2009-02-24 15:19:13Z macmade $

/**
 * Abstract for the test unit classes
 * 
 * @author      Jean-David Gadina - www.xs-labs.com
 * @version     1.0
 * @package     Woops.Test
 */
abstract class Woops_Test_Unit extends Woops_Core_Object
{
    /**
     * The minimum version of PHP required to run this class (checked by the WOOPS class manager)
     */
    const PHP_COMPATIBLE = '5.2.0';
    
    /**
     * The test unit's title
     */
    protected $_title = '';
    
    /**
     * Class constructor
     * 
     * @param   string  The test unit's title
     * @return  void
     */
    public function __construct( $title = '' )
    {
        // Checks if we have a title
        if( $title ) {
            
            // Sets the title
            $this->_title = ( string )$title;
        }
    }
    
    /**
     * Gets the test unit's title
     * 
     * @return  string  The test unit's title
     */
    public function getTitle()
    {
        return $this->_title;
    }
    
    /**
     * Sets the test unit's title
     * 
     * @param   string  The test unit's title
     * @return  void
     */
    public function setTitle( $title )
    {
        $this->_title = ( string )$title;
    }
}
