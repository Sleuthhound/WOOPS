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
namespace Woops\Unit;

/**
 * Power units
 *
 * @author      Jean-David Gadina <macmade@eosgarden.com>
 * @version     1.0
 * @package     Woops.Unit
 */
class Power extends Base
{
    /**
     * The minimum version of PHP required to run this class (checked by the WOOPS class manager)
     */
    const PHP_COMPATIBLE = '5.3.0RC2';
    
    /**
     * The available units
     */
    const UNIT_BTUS_PER_MINUTE        = 'BTUS_PER_MINUTE';
    const UNIT_FOOT_POUNDS_PER_MINUTE = 'FOOT_POUNDS_PER_MINUTE';
    const UNIT_FOOT_POUNDS_PER_SECOND = 'FOOT_POUNDS_PER_SECOND';
    const UNIT_HORSEPOWER             = 'HORSEPOWER';
    const UNIT_KILOWATTS              = 'KILOWATTS';
    const UNIT_WATTS                  = 'WATTS';
    
    /**
     * The default unit
     */
    protected $_defaultType = 'WATTS';
    
    /**
     * The conversion operations for each unit from the default type
     */
    protected $_types = array(
        'BTUS_PER_MINUTE'        => array(),
        'FOOT_PER_POUNDS_MINUTE' => array(),
        'FOOT_PER_POUNDS_SECOND' => array(),
        'HORSEPOWER'             => array(),
        'KILOWATTS'              => array(),
        'WATTS'                  => array()
    );
}
