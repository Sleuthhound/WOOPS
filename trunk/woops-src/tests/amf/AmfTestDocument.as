﻿package {        import flash.display.MovieClip;    import fl.events.*;    import flash.events.*;    import flash.net.NetConnection;    import flash.net.Responder;    import flash.net.ObjectEncoding;        public class AmfTestDocument extends MovieClip    {        private var _url:String               = 'http://woops.localhost/woops-src/tests/amf/';        private var _connection:NetConnection = null;        private var _responder:Responder      = null;                public function AmfTestDocument()        {            this.amfSend.addEventListener( MouseEvent.CLICK, _send );                        this._responder  = new Responder( _onResult, _onStatus );            this._connection = new NetConnection();        }                public function _send( e:MouseEvent ):void        {            if( this.amfVersion.selectedItem.data == 3 ) {                                this._connection.objectEncoding = ObjectEncoding.AMF3;                            } else {                                this._connection.objectEncoding = ObjectEncoding.AMF0;            }                        this._connection.connect( this._url );                        var object = new Object();            object.foo = 'Hello World';            object.bar = new Array( 27, true );            object.ref = object.bar;                        this._connection.addHeader( 'Foo', false, object );            this._connection.call( 'Bar', this._responder, 'Hello Universe!' );        }                private function _onResult( result:Object ):void        {            this.amfResponse.text = result.toString();        }                private function _onStatus( status:Object ):void        {            this.amfResponse.text = String( 'Error type ' + status.code + ': ' + status.message );        }    }}