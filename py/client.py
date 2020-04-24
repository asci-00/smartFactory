import socket
from threading import Thread

#HOST = '119.67.102.198'
#HOST = '192.168.219.106'
HOST = 'localhost'
PORT = 9009
deviceid = 'ajh' #나중에 파일로 저장(토큰)

def receiveFile():
   with socket.socket(socket.AF_INET, socket.SOCK_STREAM) as sock:
      sock.connect((HOST, PORT))
      sock.send(deviceid.encode())
      print('connect %s'%HOST)
      while True:
         try:
            data = sock.recv(2048)
            if not data:
               break
            data = data.decode()
            filename = data.split('<=')[0]
            file = open('./%s.json' %filename, 'w')
            file.write(data.split('<=')[1])
            file.close()
            sock.send('success'.encode())
         except Exception as e:
            print(e)
      sock.close()
receiveFile()
