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
 * Interface for the multi singleton classes
 *
 * @author      Jean-David Gadina - www.xs-labs.com
 * @version     1.0
 * @package     Woops.Core.MultiSingleton
 */
interface Woops_Core_MultiSingleton_Interface
{
    /**
     * Gets a singleton instance
     * 
     * @param   string  The instance name
     * @return  object  The requested instance
     */
    public static function getInstance( $instanceName );
}
