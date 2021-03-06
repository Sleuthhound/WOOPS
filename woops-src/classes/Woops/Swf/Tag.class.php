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

# $Id: Stream.class.php 637 2009-03-09 09:05:52Z macmade $

/**
 * Abstract for the SWF tag classes
 * 
 * @author      Jean-David Gadina - www.xs-labs.com
 * @version     1.0
 * @package     Woops.Swf
 */
abstract class Woops_Swf_Tag extends Woops_Core_Object
{
    /**
     * The minimum version of PHP required to run this class (checked by the WOOPS class manager)
     */
    const PHP_COMPATIBLE = '5.2.0';
    
    /**
     * Process the raw data from a binary stream
     * 
     * @return  void
     */
    abstract public function processData( Woops_Swf_Binary_Stream $stream );
    
    /**
     * The SWF tag type
     */
    protected $_type = 0x00;
    
    /**
     * The instance of the SWF file in which the tag is contained
     */
    protected $_file = NULL;
    
    /**
     * Class constructor
     * 
     * @param   Woops_Swf_File  The instance of the SWF file in which the tag is contained
     */
    public function __construct( Woops_Swf_File $file )
    {
        $this->_file = $file;
    }
    
    /**
     * Gets the SWF tag type
     * 
     * @return  int     The SWF tag type
     */
    public function getType()
    {
        return $this->_type;
    }
}
