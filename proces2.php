#!/usr/bin/php

<?php

	$host = "127.0.0.1";
	$port = 12345;
	
	if( ! ( $server = socket_create( AF_INET, SOCK_STREAM, SOL_TCP ) ) ){
		print "socket_create(): " 		. socket_strerror( socket_last_error( $server ) ) . "\n";
		exit( 1 );
	}
	
	if( ! socket_set_option($server, SOL_SOCKET, SO_REUSEADDR, 1) ) {
		print "socket_set_option(): " 	. socket_strerror(socket_last_error( $server ) ) . "\n";
		exit( 1 );
	}
	
	if( ! socket_bind( $server, $host, $port ) ){
		print "socket_bind(): " 		. socket_strerror( socket_last_error( $server ) ) . "\n";
		exit( 1 );
	}
	
	if( ! socket_listen( $server, 5 ) ){
		print "socket_listen(): " 		. socket_strerror( socket_last_error( $server ) ) . "\n";
		exit( 1 );
	}
	
	while( $client = socket_accept( $server ) ){
    
       $msg = ""; 
        while( $rcv = socket_read( $client, 256 ) ){ 
            $msg .= $rcv;  
        }
    
		
		#print "$msg\n";
		
		
		$hex = bin2hex($msg);
		
		# print "$hex\n";
		
		
	$port 	= 12346;
	$host 	= '127.0.0.1';
	$req = xmlrpc_encode_request(
		"method", 
		array($hex)
	);
	$ctx = stream_context_create(
		array(
			'http' => array(
				'method' 	=> "POST",
				'header' 	=> array( "Content-Type: text/xml" ),
				'content' 	=> $req
			)
		)
	);
	$xml = file_get_contents( "http://$host:$port/RPC2", false, $ctx );
	
	
		
		socket_close( $client );
	}
	
	
	socket_close( $server );
?>
