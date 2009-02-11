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
 * XHTML page class
 *
 * @author      Jean-David Gadina <macmade@eosgarden.com>
 * @version     1.0
 * @package     Woops.Xhtml
 */
class Woops_Xhtml_Page
{
    /**
     * The minimum version of PHP required to run this class (checked by the WOOPS class manager)
     */
    const PHP_COMPATIBLE = '5.2.0';
    
    /**
     * Wether the static variables are set or not
     */
    private static $_hasStatic = false;
    
    /**
     * The string utilities
     */
    protected static $_str     = NULL;
    
    /**
     * The XHTML page object
     */
    protected $_xhtml          = NULL;
    
    /**
     * The XHTML page head tag
     */
    protected $_head           = NULL;
    
    /**
     * The XHTML page body tag
     */
    protected $_body           = NULL;
    
    /**
     * The name of the language to use
     */
    protected $_language       = 'en';
    
    /**
     * The character set to use
     */
    protected $_charset        = 'utf-8';
    
    /**
     * The XHTML namespace
     */
    protected $_xmlns          = 'http://www.w3.org/1999/xhtml';
    
    /**
     * The document type to use
     */
    protected $_dtd            = 'xhtml1-strict';
    
    /**
     * The available XHTML document types
     */
    protected $_docTypes       = array(
        'xhtml11'             => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">',
        'xhtml1-strict'       => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">',
        'xhtml1-transitional' => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">',
        'xhtml1-frameset'     => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">'
    );
    
    /**
     * Wheter to insert the document types
     */
    protected $_docType        = true;
    
    /**
     * Wheter to insert the XML declaration
     */
    protected $_xmlDeclaration = true;
    
    /**
     * The XHTML head parts
     */
    protected $_headParts      = array(
        'title'     => NULL,
        'meta-http' => array(),
        'meta-name' => array(),
        'base'      => NULL,
        'link'      => array(),
        'style'     => array(),
        'script'    => array()
    );
    
    /**
     * Class constructor
     * 
     * The class constructor is private to avoid multiple instances of the
     * class (singleton).
     * 
     * @return  NULL
     */
    public function __construct()
    {
        // Checks if the static variables are set
        if( !self::$_hasStatic ) {
            
            // Sets the static variables
            self::_setStaticVars();
        }
        
        $this->_xhtml    = new Woops_Xhtml_Tag( 'html' );
        
        $this->_head     = $this->_xhtml->head;
        $this->_body     = $this->_xhtml->body;
        
        $this->_xhtml[ 'xmlns' ]    = $this->_xmlns;
        $this->_xhtml[ 'xml:lang' ] = $this->_language;
        $this->_xhtml[ 'lang' ]     = $this->_language;
        
        $this->addMetaHttp( 'content-type', 'text/html; charset=' . $this->_charset );
        $this->setLanguage( $this->_language );
    }
    
    /**
     * 
     */
    public function __toString()
    {
        $out = '';
        
        $this->_head->removeAllTags();
        $this->_head->comment( 'This page has been generated with WOOPS - eosgarden © 2009 - www.eosgarden.com' );
        
        foreach( $this->_headParts as $headPart ) {
            
            if( is_array( $headPart ) ) {
                
                foreach( $headPart as $headPartGroup ) {
                    
                    $this->_head->addChildNode( $headPartGroup );
                }
                
            } elseif( is_object( $headPart ) ) {
                
                $this->_head->addChildNode( $headPart );
            }
        }
        
        if( $this->_xmlDeclaration ) {
            
            $out .= '<?xml version="1.0" encoding="' . $this->_charset . '"?>' . self::$_str->NL;
        }
        
        if( $this->_docType ) {
            
            $out .= $this->_docTypes[ $this->_dtd ] . self::$_str->NL;
        }
        
        $out .= ( string )$this->_xhtml;
        
        return $out;
    }
    
    /**
     * Sets the needed static variables
     * 
     * @return  NULL
     */
    private static function _setStaticVars()
    {
        // Gets the instance of the string utilities
        self::$_str       = Woops_String_Utils::getInstance();
        
        // Static variables are set
        self::$_hasStatic = true;
    }
    
    /**
     * 
     */
    public function insertXmlDeclaration( $value )
    {
        $this->_xmlDeclaration = ( boolean )$value;
    }
    
    /**
     * 
     */
    public function insertDocType( $value )
    {
        $this->_docType = ( boolean )$value;
    }
    
    /**
     * 
     */
    public function setDocType( $name )
    {
        $name = strtolower( $name );
        
        if( isset( $this->_docTypes[ $name ] ) ) {
            
            $this->_dtd = $name;
        }
    }
    
    /**
     * 
     */
    public function setCharset( $charset )
    {
        $this->_charset     = strtolower( $charset );
        $cType              = $this->_headParts[ 'meta' ][ 'content-type' ];
        $cType[ 'content' ] = 'text/html; charset=' . $charset;
    }
    
    /**
     * 
     */
    public function setTitle( $title )
    {
        $this->_headParts[ 'title' ] = new Woops_Xhtml_Tag( 'title' );
        $this->_headParts[ 'title' ]->addTextData( ( string )$title );
    }
    
    /**
     * 
     */
    public function setLanguage( $name )
    {
        $this->_xhtml[ 'xml:lang' ] = $this->_language;
        $this->_xhtml[ 'lang' ]     = $this->_language;
        $this->addMetaHttp( 'content-language', $name );
        $this->addMetaName( 'DC.Language', $name, 'NISOZ39.50' );
    }
    
    /**
     * 
     */
    public function setBase( $href, $target = '' )
    {
        $this->_headParts[ 'base' ]           = new Woops_Xhtml_Tag( 'title' );
        $this->_headParts[ 'base' ][ 'href' ] = ( string )$href;
        
        if( $target ) {
            
            $this->_headParts[ 'base' ][ 'target' ] = ( string )$target;
            
        } else {
            
            $this->_headParts[ 'base' ][ 'target' ]->removeAttribute( 'href' );
        }
    }
    
    /**
     * 
     */
    public function addMetaName( $name, $content, $scheme = '' )
    {
        if( !isset( $this->_headParts[ 'meta-name' ][ $name ] ) ) {
            
            $this->_headParts[ 'meta-name' ][ $name ] = new Woops_Xhtml_Tag( 'meta' );
        }
        
        $this->_headParts[ 'meta-name' ][ $name ][ 'name'    ] = (string)$name;
        $this->_headParts[ 'meta-name' ][ $name ][ 'content' ] = (string)$content;
        
        if( $scheme ) {
            
            $this->_headParts[ 'meta-name' ][ $name ][ 'scheme' ] = (string)$scheme;
            
        } else {
            
            $this->_headParts[ 'meta-name' ][ $name ]->removeAttribute( 'scheme' );
        }
    }
    
    /**
     * 
     */
    public function addMetaHttp( $httpEquiv, $content, $scheme = '' )
    {
        if( $httpEquiv !== 'content-type' || $httpEquiv !== 'content-language' ) {
            
            if( !isset( $this->_headParts[ 'meta-http' ][ $httpEquiv ] ) ) {
                
                $this->_headParts[ 'meta-http' ][ $httpEquiv ] = new Woops_Xhtml_Tag( 'meta' );
            }
            
            $this->_headParts[ 'meta-http' ][ $httpEquiv ][ 'http-equiv' ] = (string)$httpEquiv;
            $this->_headParts[ 'meta-http' ][ $httpEquiv ][ 'content' ]    = (string)$content;
            
            if( $scheme ) {
                
                $this->_headParts[ 'meta-http' ][ $httpEquiv ][ 'scheme' ] = (string)$scheme;
                
            } else {
                
                $this->_headParts[ 'meta-http' ][ $httpEquiv ]->removeAttribute( 'scheme' );
            }
        }
    }
    
    /**
     * 
     */
    public function addLink( $href = '', $type = '', $title = '', $rel = '', $rev = '', $media = '', $charset = '', $hreflang = '', $target = '' )
    {
        $link = new Woops_Xhtml_Tag( 'link' );
        
        if( $href ) {
            
            $link[ 'href' ] = ( string )$href;
        }
        
        if( $type ) {
            
            $link[ 'type' ] = ( string )$type;
        }
        
        if( $title ) {
            
            $link[ 'title' ] = ( string )$title;
        }
        
        if( $rel ) {
            
            $link[ 'rel' ] = ( string )$rel;
        }
        
        if( $rev ) {
            
            $link[ 'rev' ] = ( string )$rev;
        }
        
        if( $media ) {
            
            $link[ 'media' ] = ( string )$media;
        }
        
        if( $charset ) {
            
            $link[ 'charset' ] = ( string )$charset;
        }
        
        if( $hreflang ) {
            
            $link[ 'hreflang' ] = ( string )$hreflang;
        }
        
        if( $target ) {
            
            $link[ 'target' ] = ( string )$target;
        }
        
        $this->_headParts[ 'link' ][] = $link;
    }
    
    /**
     * 
     */
    public function addStylesheet( $href, $media = 'screen' )
    {
        $this->addLink(
            $href,
            'text/css',
            '',
            'stylesheet',
            '',
            $media
        );
    }
    
    /**
     * 
     */
    public function addRssLink( $href, $title )
    {
        $this->addLink(
            $href,
            'application/rss+xml',
            $title,
            'alternate'
        );
    }
    
    /**
     * 
     */
    public function addAtomLink( $href, $title )
    {
        $this->addLink(
            $href,
            'application/atom+xml',
            $title,
            'alternate'
        );
    }
    
    /**
     * 
     */
    public function addFavicon( $href = 'favicon.ico' )
    {
        $this->addLink(
            $href,
            '',
            '',
            'shortcut icon'
        );
    }
    
    /**
     * 
     */
    public function addScriptSource( $source, $type, $defer = false, $charset = '' )
    {
        $script = new Woops_Xhtml_Tag( 'script' );
        
        $script[ 'src' ]  = $source;
        $script[ 'type' ] = $type;
        
        if( $defer ) {
            
            $script[ 'defer' ] = 'defer';
        }
        
        if( $charset ) {
            
            $link[ 'charset' ] = ( string )$charset;
        }
        
        $this->_headParts[ 'script' ][] = $script;
    }
    
    /**
     * 
     */
    public function addJavaScriptSource( $source, $defer = false, $charset = '' )
    {
        $this->addScriptSource(
            $source,
            'text/javascript',
            $defer,
            $charset
        );
    }
    
    /**
     * 
     */
    public function addScriptContent( $content, $type, $defer = false )
    {
        $script = new Woops_Xhtml_Tag( 'script' );
        
        $script[ 'src' ]  = $source;
        $script[ 'type' ] = $type;
        
        if( $defer ) {
            
            $script[ 'defer' ] = 'defer';
        }
        
        $script->addTextData( ( string )$content );
        
        $this->_headParts[ 'script' ][] = $script;
    }
    
    /**
     * 
     */
    public function addJavaScriptContent( $content, $defer = false )
    {
        $this->addScriptContent(
            $source,
            'text/javascript',
            $defer
        );
    }
    
    /**
     * 
     */
    public function addStyle( $content, $media = 'screen', $type = 'text/css' )
    {
        $style = new Woops_Xhtml_Tag( 'script' );
        
        if( $media ) {
            
            $style[ 'media' ] = $media;
        }
        
        if( $type ) {
            
            $style[ 'type' ] = $type;
        }
        
        $style->addTextData( ( string )$content );
        
        $this->_headParts[ 'style' ][] = $style;
    }
    
    /**
     * 
     */
    public function getBody()
    {
        return $this->_body;
    }
    
    /**
     * 
     */
    public function addBodyAttribute( $parameter, $value )
    {
        $this->_body[ $parameter ] = $value;
    }
}