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
 * Getter class for the WOOPS pages
 *
 * @author      Jean-David Gadina <macmade@eosgarden.com>
 * @version     1.0
 * @package     Woops.Page
 */
final class Woops_Page_Getter implements Woops_Core_Singleton_Interface
{
    /**
     * The minimum version of PHP required to run this class (checked by the WOOPS class manager)
     */
    const PHP_COMPATIBLE = '5.2.0';
    
    /**
     * The unique instance of the class (singleton)
     */
    private static $_instance = NULL;
    
    /**
     * The configuration object
     */
    private $_conf            = NULL;
    
    /**
     * The environment object
     */
    private $_env             = NULL;
    
    /**
     * The request object
     */
    private $_request         = NULL;
    
    /**
     * The database object
     */
    private $_db              = NULL;
    
    /**
     * The string utilities
     */
    private $_str             = NULL;
    
    /**
     * The XHTML page object
     */
    private $_xhtml           = NULL;
    
    /**
     * The XHTML page head tag
     */
    private $_head            = NULL;
    
    /**
     * The XHTML page body tag
     */
    private $_body            = NULL;
    
    /**
     * The ID of the current page
     */
    private $_pageId          = 0;
    
    /**
     * The name of the current language
     */
    private $_langName        = '';
    
    /**
     * The character set to use
     */
    private $_charset         = 'utf-8';
    
    /**
     * The XHTML namespace
     */
    private $_xmlns           = 'http://www.w3.org/1999/xhtml';
    
    /**
     * The document type to use
     */
    private $_dtd             = 'xhtml1-strict';
    
    /**
     * The available XHTML document types
     */
    private $_docTypes        = array(
        'xhtml11'             => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">',
        'xhtml1-strict'       => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">',
        'xhtml1-transitional' => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">',
        'xhtml1-frameset'     => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">'
    );
    
    /**
     * Wheter to insert the document types
     */
    private $_docType         = true;
    
    /**
     * Wheter to insert the XML declaration
     */
    private $_xmlDeclaration  = true;
    
    /**
     * The database row for the current page
     */
    private $_page            = array();
    
    /**
     * Class constructor
     * 
     * The class constructor is private to avoid multiple instances of the
     * class (singleton).
     * 
     * @return  NULL
     */
    private function __construct()
    {
        $this->_conf     = Woops_Core_Config_Getter::getInstance();
        $this->_env      = Woops_Core_Env_Getter::getInstance();
        $this->_request  = Woops_Core_Request_Getter::getInstance();
        $this->_db       = Woops_Database_Layer::getInstance();
        $this->_str      = Woops_String_Utils::getInstance();
        
        $this->_pageId   = $this->_getPageId();
        $this->_langName = $this->_getLanguage();
        $this->_page     = $this->_getPage( $this->_pageId, $this->_langName );
        $this->_template = $this->_getTemplate( $this->_page->id_templates );
        $this->_xhtml    = $this->_parseTemplate();
        
        $this->_head     = $this->_xhtml->getTag( 'head' );
        $this->_body     = $this->_xhtml->getTag( 'body' );
        
        $this->_xhtml->removeAllAttributes();
        
        $this->_xhtml[ 'xmlns' ]    = $this->_xmlns;
        $this->_xhtml[ 'xml:lang' ] = $this->_langName;
        $this->_xhtml[ 'lang' ]     = $this->_langName;
        
        $keepHead        = unserialize( $this->_template->keephead );
        $keepTags        = array();
        
        foreach( $keepHead as $keepTag ) {
            
            if( $tag = $this->_head->getTag( $keepTag[ 0 ], $keepTag[ 1 ] ) ) {
                
                $keepTags[] = $tag;
            }
        }
        
        $this->_head->removeAllTags();
        
        $this->_buildHeader();
        
        foreach( $keepTags as $tag ) {
            
            $this->_head->addChildNode( $tag );
        }
    }
    
    /**
     * Clones an instance of the class
     * 
     * A call to this method will produce an exception, as the class cannot
     * be cloned (singleton).
     * 
     * @return  NULL
     * @throws  Woops_Core_Singleton_Exception  Always, as the class cannot be cloned (singleton)
     */
    public function __clone()
    {
        throw new Woops_Core_Singleton_Exception(
            'Class ' . __CLASS__ . ' cannot be cloned',
            Woops_Core_Singleton_Exception::EXCEPTION_CLONE
        );
    }
    
    /**
     * 
     */
    public function __toString()
    {
        $out = '';
        
        if( $this->_xmlDeclaration ) {
            
            $out .= '<?xml version="1.0" encoding="' . $this->_charset . '"?>' . $this->_str->NL;
        }
        
        if( $this->_docType ) {
            
            $out .= $this->_docTypes[ $this->_dtd ] . $this->_str->NL;
        }
        
        $out .= ( string )$this->_xhtml;
        
        return $out;
    }
    
    /**
     * Gets the unique class instance
     * 
     * This method is used to get the unique instance of the class
     * (singleton). If no instance is available, it will create it.
     * 
     * @return  Woops_Color_Converter   The unique instance of the class
     */
    public static function getInstance()
    {
        // Checks if the unique instance already exists
        if( !is_object( self::$_instance ) ) {
            
            // Creates the unique instance
            self::$_instance = new self();
        }
        
        // Returns the unique instance
        return self::$_instance;
    }
    
    /**
     * 
     */
    private function _getPageId()
    {
        $id = ( int )$this->_request->woopsPageId;
        
        if( !$id || !$this->_db->getRecord( 'pageinfos', $id ) ) {
            
            $homeRecords = $this->_db->getRecordsByFields(
                'pageinfos',
                array(
                    'home' => 1
                )
            );
            
            if( !count( $homeRecords ) ) {
                
                throw new Woops_Page_Getter_Exception(
                    'No home page is defined in the database',
                    Woops_Page_Getter_Exception::EXCEPTION_NO_HOMEPAGE
                );
            }
            
            $homePage = array_shift( $homeRecords );
            
            $id       = $homePage->id_pageinfos;
        }
        
        return $id;
    }
    
    /**
     * 
     */
    private function _getLanguage()
    {
        $lang = $this->_request->woopsLanguage;
        
        if( !$lang ) {
            
            $lang = $this->_conf->getVar( 'lang', 'defaultLanguage' );
        }
        
        if( !$lang ) {
            
            throw new Woops_Page_Getter_Exception(
                'The WOOPS default language is not configured',
                Woops_Page_Getter_Exception::EXCEPTION_NO_DEFAULT_LANG
            );
        }
        
        return $lang;
    }
    
    /**
     * 
     */
    private function _getPage( $id, $lang )
    {
        $page = $this->_db->getRecordsByFields(
            'pageheaders',
            array(
                'id_pageinfos' => $id,
                'lang'         => $lang
            )
        );
        
        if( !count( $page ) ) {
            
            $page = $this->_db->getRecordsByFields(
                'pageheaders',
                array(
                    'id_pageinfos' => $id,
                    'lang'         => $this->_conf->getVar( 'lang', 'defaultLanguage' )
                )
            );
        }
        
        if( !count( $page ) ) {
            
            throw new Woops_Page_Getter_Exception(
                'Cannot find a page record for page ID ' . $id,
                Woops_Page_Getter_Exception::EXCEPTION_NO_PAGE
            );
        }
        
        return array_shift( $page );
    }
    
    /**
     * 
     */
    private function _getTemplate( $id )
    {
        $template = $this->_db->getRecord( 'templates', $id );
        
        if( !is_object( $template ) ) {
            
            throw new Woops_Page_Getter_Exception(
                'Cannot find a template record for page ID ' . $this->_pageId,
                Woops_Page_Getter_Exception::EXCEPTION_NO_TEMPLATE
            );
        }
        
        if( $template->id_parent ) {
            
            $parent         = $this->_getTemplate( $template->id_parent );
            $template->file = $parent->file;
        }
        
        return $template;
    }
    
    /**
     * 
     */
    private function _parseTemplate()
    {
        $templateDir    = $this->_env->getPath( 'ressources/templates/' );
        $templateDirRel = $this->_env->getWebPath( 'ressources/templates/' );
        
        if( !$templateDir ) {
            
            throw new Woops_Page_Getter_Exception(
                'The templates directory does not exist',
                Woops_Page_Getter_Exception::EXCEPTION_NO_TEMPLATE_DIR
            );
        }
        
        $path = $templateDir . $this->_template->file;
        
        if( !file_exists( $path ) ) {
            
            throw new Woops_Page_Getter_Exception(
                'The template file for page ID ' . $this->_pageId . ' does not exist (' . $this->_template->file . ')',
                Woops_Page_Getter_Exception::EXCEPTION_NO_TEMPLATE_FILE
            );
        }
        
        $parser = new Woops_Xhtml_Parser( $path, $templateDirRel );
        
        return $parser->getXhtmlObject();
    }
    
    /**
     * 
     */
    protected function _buildHeader()
    {
        $this->_head->comment( 'This page has been generated with WOOPS - eosgarden © 2009 - www.eosgarden.com' );
        $this->_head->title = $this->_page->title;
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
        $this->_charset = strtolower( $charset );
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
