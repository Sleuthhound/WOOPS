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

# $Id: Helper.class.php 534 2009-03-03 07:15:08Z macmade $

/**
 * Event object for the Woops_Log_Writer class
 * 
 * @author      Jean-David Gadina - www.xs-labs.com
 * @version     1.0
 * @package     Woops.Log.Writer
 */
class Woops_Log_Writer_Event extends Woops_Core_Event
{
    /**
     * The minimum version of PHP required to run this class (checked by the WOOPS class manager)
     */
    const PHP_COMPATIBLE = '5.2.0';
    
    /**
     * The available events
     */
    const EVENT_LOG                 = 0x01;
    const EVENT_LOG_WRITER_REGISTER = 0x02;
}
