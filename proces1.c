#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <string.h>
#include <sys/types.h>
#include <sys/socket.h>
#include <netinet/in.h>
#include <netdb.h> 
int error( int ern, const char *err ){
	perror( err );
	return ern;
}
int main( void )
{
	int  	port   = 12345;
	char 	host[] = "127.0.0.1";
    int 	fd, n;
    struct 	sockaddr_in serv_addr;
    struct 	hostent *server;
    char 	buffer[256];
    char *b = buffer;
    size_t len = 250;
    
    fd = socket(AF_INET, SOCK_STREAM, 0);
    
    if (fd < 0) 
        return error( 1, "socket()");
  
    server = gethostbyname( host );
  
    if( server == NULL )
		return error( 2, "gethostbyname()" );
    
    bzero((char *) &serv_addr, sizeof(serv_addr));
    
    serv_addr.sin_family = AF_INET;	
    serv_addr.sin_port = htons(port);
    
    bcopy( (char *) server->h_addr, (char *) &serv_addr.sin_addr.s_addr, server->h_length );
    
    if( connect( fd, (struct sockaddr *) &serv_addr, sizeof( serv_addr ) ) < 0 ) 
        return error( 3, "connect()" );
	
    bzero( buffer, 256 );
    
    getline(&b, &len, stdin);
    
    write( fd, buffer, sizeof( buffer ) );
    
    
    close(fd);
    
    return 0;
}
