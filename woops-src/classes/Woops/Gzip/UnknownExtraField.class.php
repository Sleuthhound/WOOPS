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
 * Unknown GZIP extra field
 * 
 * @author      Jean-David Gadina - www.xs-labs.com
 * @version     1.0
 * @package     Woops.Gzip
 */
class Woops_Gzip_UnknownExtraField extends Woops_Gzip_ExtraField
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
     * Class constructor
     * 
     * @param   int     The extra field type
     */
    public function __construct( $type )
    {
        $this->_type = ( int )$type;
    }
}
