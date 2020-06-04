#!/usr/bin/perl

use warnings;
use strict;
use HTTP::Daemon;
use XML::RPC;
sub handler {
    my ( $method, @params ) = @_;
    
    return { method => $method, params => \@params };
}
my $port 	= 12346;
my $host 	= '127.0.0.1';

my $server = HTTP::Daemon->new( 
	LocalAddr => $host,
	LocalPort => $port,
) || die "HTTP::Daemon->new(): $!\n";
# XML-RPC broker -------------------------------------------------------
my $xmlrpc 	= XML::RPC->new();

while( my $client = $server->accept ){

	while( my $req = $client->get_request ){
		my $msg = $xmlrpc->receive( $req->content, \&handler );

		print $msg, "\n";
	}
	$client->close;

}
exit( 0 );
