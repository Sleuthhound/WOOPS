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

/**
 * AMF3 packet
 *
 * @author      Jean-David Gadina <macmade@eosgarden.com>
 * @version     1.0
 * @package     Woops.Amf.Packet
 */
class Woops_Amf_Packet_Amf3 extends Woops_Amf_Packet
{
    /**
     * The minimum version of PHP required to run this class (checked by the WOOPS class manager)
     */
    const PHP_COMPATIBLE = '5.2.0';
    
    /**
     * The allowed AMF markers
     */
    const MARKER_UNDEFINED  = 0x0000;
    const MARKER_NULL       = 0x0001;
    const MARKER_FALSE      = 0x0002;
    const MARKER_TRUE       = 0x0003;
    const MARKER_INTEGER    = 0x0004;
    const MARKER_DOUBLE     = 0x0005;
    const MARKER_STRING     = 0x0006;
    const MARKER_XML_DOC    = 0x0007;
    const MARKER_DATE       = 0x0008;
    const MARKER_ARRAY      = 0x0009;
    const MARKER_OBJECT     = 0x000A;
    const MARKER_XML        = 0x000B;
    const MARKER_BYTE_ARRAY = 0x000C;
    
    /**
     * The AMF packet version
     */
    protected $_version = 3;
    
    /**
     * The allowed AMF markers
     */
    protected $_markers = array(
        0x0000 => 'Woops_Amf_Marker_Amf3_Undefined',
        0x0001 => 'Woops_Amf_Marker_Amf3_Null',
        0x0002 => 'Woops_Amf_Marker_Amf3_False',
        0x0003 => 'Woops_Amf_Marker_Amf3_True',
        0x0004 => 'Woops_Amf_Marker_Amf3_Integer',
        0x0005 => 'Woops_Amf_Marker_Amf3_Double',
        0x0006 => 'Woops_Amf_Marker_Amf3_String',
        0x0007 => 'Woops_Amf_Marker_Amf3_XmlDoc',
        0x0008 => 'Woops_Amf_Marker_Amf3_Date',
        0x0009 => 'Woops_Amf_Marker_Amf3_Array',
        0x000A => 'Woops_Amf_Marker_Amf3_Object',
        0x000B => 'Woops_Amf_Marker_Amf3_Xml',
        0x000C => 'Woops_Amf_Marker_Amf3_ByteArray'
    );
}