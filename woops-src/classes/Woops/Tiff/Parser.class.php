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
 * TIFF file parser
 * 
 * @author      Jean-David Gadina - www.xs-labs.com
 * @version     1.0
 * @package     Woops.Tiff
 */
class Woops_Tiff_Parser extends Woops_Core_Object
{
    /**
     * The minimum version of PHP required to run this class (checked by the WOOPS class manager)
     */
    const PHP_COMPATIBLE = '5.2.0';
    
    /**
     * The TIFF file object
     */
    protected $_file     = NULL;
    
    /**
     * The binary stream
     */
    protected $_stream   = NULL;
    
    /**
     * The file path
     */
    protected $_filePath = '';
    
    /**
     * Class constructor
     * 
     * @param   string      The location of the TIFF file
     * @return  void
     */
    public function __construct( $file )
    {
        // Create a new TIFF file object
        $this->_file     = new Woops_Tiff_File();
        
        // Stores the file path
        $this->_filePath = $file;
        
        // Creates the binary stream
        $this->_stream   = new Woops_Tiff_Binary_File_Stream( $file );
        
        // Parses the file
        $this->_parseFile();
        
        // Deletes the stream object
        unset( $this->_stream );
    }
    
    protected function _parseFile()
    {
        // Gets the TIFF header
        $header = $this->_file->getHeader();
        
        // Process the header data
        $header->processData( $this->_stream );
        
        // Gets the first IFD offset
        $offset = $header->getFirstIfdOffset();
        
        // Processes the IFDs
        while( $offset !== 0 ) {
            
            // Seeks to the start of the IFD
            $this->_stream->seek( $offset, Woops_Tiff_Binary_File_Stream::SEEK_SET );
            
            // Creates a new IFD
            $ifd = $this->_file->newIfd();
            
            // Process the IFD data
            $ifd->processData( $this->_stream );
            
            // Gets the offset for the next IFD, if any
            $offset = $ifd->getNextIfdOffset();
        }
    }
    
    /**
     * Gets the TIFF file object
     * 
     * @return  Woops_Tiff_File  The TIFF file object
     */
    public function getFile()
    {
        return $this->_file;
    }
}
