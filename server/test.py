import socket

server = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
server.bind(('', 1337))
server.listen(5)

while True:
    (client_socket, addr) = server.accept()
    print("Client", addr, "connected")
    chunk = client_socket.recv(1024)
    print("Got:", str(chunk))
    client_socket.close()
