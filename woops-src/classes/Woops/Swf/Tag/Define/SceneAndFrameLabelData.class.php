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

# $Id: Stream.class.php 637 2009-03-09 09:05:52Z macmade $

/**
 * SWF DefineSceneAndFrameLabelData Tag
 * 
 * The DefineSceneAndFrameLabelData tag contains scene and frame label data for
 * a MovieClip. Scenes are supported for the main timeline only, for all other
 * movie clips a single scene is exported.
 * 
 * @author      Jean-David Gadina - www.xs-labs.com
 * @version     1.0
 * @package     Woops.Swf.Tag.Define
 */
class Woops_Swf_Tag_Define_SceneAndFrameLabelData extends Woops_Swf_Tag
{
    /**
     * The minimum version of PHP required to run this class (checked by the WOOPS class manager)
     */
    const PHP_COMPATIBLE = '5.2.0';
    
    /**
     * The SWF tag type
     */
    protected $_type       = 0x56;
    
    /**
     * The scenes
     */
    protected $_scenes     = array();
    
    /**
     * The frame offset for the scenes
     */
    protected $_offsets    = array();
    
    /**
     * The frame labels
     */
    protected $frameLabels = array();
    
    /**
     * Process the raw data from a binary stream
     * 
     * @return  void
     */
    public function processData( Woops_Swf_Binary_Stream $stream )
    {
        // Resets the storage arrays
        $this->_offsets    = array();
        $this->_scenes     = array();
        $this->frameLabels = array();
        
        // Gets the number of scenes
        $sceneCount        = $stream->encodedU32();
        
        // Process eachs scene
        for( $i = 0; $i < $sceneCount; $i++ ) {
            
            // Gets the frame offset and name for the current scene
            $this->_offsets[] = $stream->encodedU32();
            $this->_scenes[]  = $stream->nullTerminatedString();
        }
        
        // Gets the number of frame labels
        $frameLabelCount = $stream->encodedU32();
        
        // Process each frame label
        for( $i = 0; $i < $frameLabelCount; $i++ ) {
            
            // Gets the frame number and label
            $this->_frameLabels[ $stream->encodedU32() ] = $stream->nullTerminatedString();
        }
    }
}
