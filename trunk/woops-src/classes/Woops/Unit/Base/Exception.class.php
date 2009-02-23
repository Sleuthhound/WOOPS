<?php
################################################################################
#                                                                              #
#                WOOPS - Web Object Oriented Programming System                #
#                                                                              #
#                               COPYRIGHT NOTICE                               #
#                                                                              #
# (c) 2009 Jean-David Gadina (macmade@eosgarden.com)                           #
# All rights reserved                                                          #
################################################################################

# $Id$

/**
 * Exception class for the Woops_Unit_Base class
 *
 * @author      Jean-David Gadina <macmade@eosgarden.com>
 * @version     1.0
 * @package     Woops.Unit.Base
 */
final class Woops_Unit_Base_Exception extends Woops_Core_Exception_Base
{
    /**
     * The minimum version of PHP required to run this class (checked by the WOOPS class manager)
     */
    const PHP_COMPATIBLE = '5.2.0';
    
    /**
     * Error codes for the exceptions
     */
    const EXCEPTION_INVALID_UNIT = 0x01;
    const EXCEPTION_INVALID_TYPE = 0x02;
}
