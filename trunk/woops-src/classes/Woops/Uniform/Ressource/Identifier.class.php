<?php
################################################################################
#                                                                              #
#                WOOPS - Web Object Oriented Programming System                #
#                                                                              #
#                               COPYRIGHT NOTICE                               #
#                                                                              #
# (c) 2009 eosgarden - Jean-David Gadina (macmade@eosgarden.com)               #
# All rights reserved                                                          #
################################################################################

# $Id$

/**
 * URI class (RFC-2396)
 *
 * @author      Jean-David Gadina <macmade@eosgarden.com>
 * @version     1.0
 * @package     Woops.Uniform.Ressource
 */
class Woops_Uniform_Ressource_Identifier
{
    /**
     * The minimum version of PHP required to run this class (checked by the WOOPS class manager)
     */
    const PHP_COMPATIBLE = '5.2.0';
    
    /**
     * The registered URI schemes (IANA)
     */
    const SCHEME_AAA             = 'aaa';
    const SCHEME_AAAS            = 'aaas';
    const SCHEME_ACAP            = 'acap';
    const SCHEME_CAP             = 'cap';
    const SCHEME_CID             = 'cid';
    const SCHEME_CRID            = 'crid';
    const SCHEME_DATA            = 'data';
    const SCHEME_DAV             = 'dav';
    const SCHEME_DICT            = 'dict';
    const SCHEME_DNS             = 'dns';
    const SCHEME_FAX             = 'fax';
    const SCHEME_FILE            = 'file';
    const SCHEME_FTP             = 'ftp';
    const SCHEME_GO              = 'go';
    const SCHEME_GOPHER          = 'gopher';
    const SCHEME_H323            = 'h323';
    const SCHEME_HTTP            = 'http';
    const SCHEME_HTTPS           = 'https';
    const SCHEME_IAX             = 'iax';
    const SCHEME_ICAP            = 'icap';
    const SCHEME_IM              = 'im';
    const SCHEME_IMAP            = 'imap';
    const SCHEME_INFO            = 'info';
    const SCHEME_IPP             = 'ipp';
    const SCHEME_IRIS            = 'iris';
    const SCHEME_IRIS_BEEP       = 'iris.beep';
    const SCHEME_IRIS_XPC        = 'iris.xpc';
    const SCHEME_IRIS_XPCS       = 'iris.xpcs';
    const SCHEME_IRIS_LWZ        = 'iris.lwz';
    const SCHEME_LDAP            = 'ldap';
    const SCHEME_MAILTO          = 'mailto';
    const SCHEME_MID             = 'mid';
    const SCHEME_MODEM           = 'modem';
    const SCHEME_MSRP            = 'msrp';
    const SCHEME_MSRPS           = 'msrps';
    const SCHEME_MTQP            = 'mtqp';
    const SCHEME_MUPDATE         = 'mupdate';
    const SCHEME_NEWS            = 'news';
    const SCHEME_NFS             = 'nfs';
    const SCHEME_NNTP            = 'nntp';
    const SCHEME_OPAQUELOCKTOKEN = 'opaquelocktoken';
    const SCHEME_POP             = 'pop';
    const SCHEME_PRES            = 'pres';
    const SCHEME_RTSP            = 'rtsp';
    const SCHEME_SERVICE         = 'service';
    const SCHEME_SHTTP           = 'shttp';
    const SCHEME_SIEVE           = 'sieve';
    const SCHEME_SIP             = 'sip';
    const SCHEME_SIPS            = 'sips';
    const SCHEME_SNMP            = 'snmp';
    const SCHEME_SOAP_BEEP       = 'soap.beep';
    const SCHEME_SOAP_BEEPS      = 'soap.beeps';
    const SCHEME_TAG             = 'tag';
    const SCHEME_TEL             = 'tel';
    const SCHEME_TELNET          = 'telnet';
    const SCHEME_TFTP            = 'tftp';
    const SCHEME_THISMESSAGE     = 'thismessage';
    const SCHEME_TIP             = 'tip';
    const SCHEME_TV              = 'tv';
    const SCHEME_URN             = 'urn';
    const SCHEME_VEMMI           = 'vemmi';
    const SCHEME_XMLRPC_BEEP     = 'xmlrpc.beep';
    const SCHEME_XMLRPC_BEEPS    = 'xmlrpc.beeps';
    const SCHEME_XMPP            = 'xmpp';
    const SCHEME_Z39_50R         = 'z39.50r';
    const SCHEME_Z39_50S         = 'z39.50s';
    
    /**
     * The registered URI schemes (IANA)
     */
    protected static $_schemes = array(
        'aaa'             => true, // Diameter Protocol - RFC-3588
        'aaas'            => true, // Diameter Protocol with Secure Transport - RFC-3588
        'acap'            => true, // application configuration access protocol - RFC-2244
        'cap'             => true, // Calendar Access Protocol - RFC-4324
        'cid'             => true, // content identifier - RFC-2392
        'crid'            => true, // TV-Anytime Content Reference Identifier - RFC-4078
        'data'            => true, // data - RFC-2397
        'dav'             => true, // dav - RFC-4918
        'dict'            => true, // dictionary service protocol - RFC-2229
        'dns'             => true, // Domain Name System - RFC-4501
        'fax'             => true, // fax - RFC-3966
        'file'            => true, // Host-specific file names - RFC-1738
        'ftp'             => true, // File Transfer Protocol - RFC-1738
        'go'              => true, // go - RFC-3368
        'gopher'          => true, // The Gopher Protocol - RFC-4266
        'h323'            => true, // H.323 - RFC-3508
        'http'            => true, // Hypertext Transfer Protocol - RFC-2616
        'https'           => true, // Hypertext Transfer Protocol Secure - RFC-2818
        'iax'             => true, // Inter-Asterisk eXchange Version 2
        'icap'            => true, // Internet Content Adaptation Protocol - RFC-3507
        'im'              => true, // Instant Messaging - RFC-3860
        'imap'            => true, // internet message access protocol - RFC-5092
        'info'            => true, // Information Assets with Identifiers in Public Namespaces - RFC-4452
        'ipp'             => true, // Internet Printing Protocol - RFC-3510
        'iris'            => true, // Internet Registry Information Service - RFC-3981
        'iris.beep'       => true, // iris.beep - RFC-3983
        'iris.xpc'        => true, // iris.xpc - RFC-4992
        'iris.xpcs'       => true, // iris.xpcs - RFC-4992
        'iris.lwz'        => true, // iris.lwz - RFC-4993
        'ldap'            => true, // Lightweight Directory Access Protocol - RFC-4516
        'mailto'          => true, // Electronic mail address - RFC-2368
        'mid'             => true, // message identifier - RFC-2392
        'modem'           => true, // modem - RFC-3966
        'msrp'            => true, // Message Session Relay Protocol - RFC-4975
        'msrps'           => true, // Message Session Relay Protocol Secure - RFC-4975
        'mtqp'            => true, // Message Tracking Query Protocol - RFC-3887
        'mupdate'         => true, // Mailbox Update (MUPDATE) Protocol - RFC-3656
        'news'            => true, // USENET news
        'nfs'             => true, // network file system protocol - RFC-2224
        'nntp'            => true, // USENET news using NNTP access
        'opaquelocktoken' => true, // opaquelocktokent - RFC-4918
        'pop'             => true, // Post Office Protocol v3 - RFC-2384
        'pres'            => true, // Presence - RFC-3859
        'rtsp'            => true, // real time streaming protocol - RFC-2326
        'service'         => true, // service location - RFC-2609
        'shttp'           => true, // Secure Hypertext Transfer Protocol - RFC-2660
        'sieve'           => true, // ManageSieve Protocol
        'sip'             => true, // session initiation protocol - RFC-3261
        'sips'            => true, // secure session initiation protocol - RFC-3261
        'snmp'            => true, // Simple Network Management Protocol - RFC-4088
        'soap.beep'       => true, // soap.beep - RFC-3288
        'soap.beeps'      => true, // soap.beeps - RFC-3288
        'tag'             => true, // tag - RFC-4151
        'tel'             => true, // telephone - RFC-3966
        'telnet'          => true, // Reference to interactive sessions - RFC-4248
        'tftp'            => true, // Trivial File Transfer Protocol - RFC-3617
        'thismessage'     => true, // multipart/related relative reference resolution - RFC-2557
        'tip'             => true, // Transaction Internet Protocol - RFC-2371
        'tv'              => true, // TV Broadcasts - RFC-2838
        'urn'             => true, // Uniform Resource Names (click for registry) - RFC-2141
        'vemmi'           => true, // versatile multimedia interface - RFC-2122
        'xmlrpc.beep'     => true, // xmlrpc.beep - RFC-3529
        'xmlrpc.beeps'    => true, // xmlrpc.beeps - RFC-3529
        'xmpp'            => true, // Extensible Messaging and Presence Protocol - RFC-5122
        'z39.50r'         => true, // Z39.50 Retrieval - RFC-2056
        'z39.50s'         => true  // Z39.50 Session - RFC-2056
    }
    
    /**
     * The URI scheme
     */
    protected $_scheme             = '';
    
    /**
     * The URI scheme specific part
     */
    protected $_schemeSpecificPart = '';
    
    /**
     * Class constructor
     * 
     * @param   string                                          The URI
     * @return  void
     * @throws  Woops_Uniform_Ressource_Identifier_Exception    If the URI is invalid
     * @throws  Woops_Uniform_Ressource_Identifier_Exception    If the URI scheme is invalid
     */
    public function __construct( $uri )
    {
        // Gets the position of the scheme separator
        $sep = strpos( $uri, ':' );
        
        // Checks for the separator
        if( !$sep ) {
            
            // Invalid URI
            throw new Woops_Uniform_Ressource_Identifier_Exception(
                'Invalid URI (' . $uri . ')',
                Woops_Uniform_Ressource_Identifier_Exception::EXCEPTION_INVALID_URI
            );
        }
        
        // Scheme and scheme specific part
        $this->_scheme             = substr( $uri, 0, $sep );
        $this->_schemeSpecificPart = substr( $uri, $sep + 1 );
        
        if( !isset( self::$_schemes[ $this->_scheme ] ) ) {
            
            // Invalid scheme
            throw new Woops_Uniform_Ressource_Identifier_Exception(
                'Invalid URI scheme (' . $this->_scheme . ')',
                Woops_Uniform_Ressource_Identifier_Exception::EXCEPTION_INVALID_SCHEME
            );
        }
    }
    
    /**
     * Gets the URI scheme
     * 
     * @return  string  The URI scheme
     */
    public function getScheme()
    {
        return $this->_scheme;
    }
    
    /**
     * Gets the URI scheme specific part
     * 
     * @return  string  The URI scheme specific part
     */
    public function getScheme()
    {
        return $this->_schemeSpecificPart;
    }
}
