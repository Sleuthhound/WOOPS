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

# $Id: Parser.class.php 588 2009-03-07 11:52:36Z macmade $

/**
 * Abstract for the GZIP extra fields
 * 
 * @author      Jean-David Gadina - www.xs-labs.com
 * @version     1.0
 * @package     Woops.Gzip
 */
abstract class Woops_Gzip_ExtraField extends Woops_Core_Object
{
    /**
     * The minimum version of PHP required to run this class (checked by the WOOPS class manager)
     */
    const PHP_COMPATIBLE = '5.2.0';
    
    /**
     * The extra field type
     */
    protected $_type = 0x0000;
    
    /**
     * The data
     */
    protected $_data = '';
    
    /**
     * Process the raw data from a binary stream
     * 
     * @param   Woops_Gzip_Binary_Stream    The binary stream
     * @return  void
     */
    public function processData( Woops_Gzip_Binary_Stream $stream )
    {
        // Gets the data length
        $length = $stream->littleEndianUnsignedShort();
        
        // Reads the field data
        $this->_data = $stream->read( $length );
    }
    
    /**
     * Gets the field data
     * 
     * @return  string  The field data
     */
    public function getData()
    {
        return $this->_data;
    }
    
    /**
     * Sets the field data
     * 
     * @param   string  The field data
     * @return  void
     */
    public function setData( $value )
    {
        $this->_data = ( string )$value;
    }
}
