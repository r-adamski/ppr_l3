Do procesu 3 potrzebne biblioteki perl: XML-RPC i XML-TreePP.
Instalacja:
gunzip -c <nazwa>.tar.gz | tar xvf -
cd <nazwa>
perl Makefile.PL
make
make test
su -c 'make install'