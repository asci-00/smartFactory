import socketserver
import threading

HOST = 'localhost'
PORT = 9009
lock = threading.Lock()

class UserManager:
   def __init__(self):
      self.users = {}

   def addUser(self, username, conn, addr):
      if username in self.users.keys():
         print('Is already connect user\n')
         return None
      lock.acquire()
      self.users[username] = (conn, addr)
      lock.release()
      print(self.users.keys())
      print('%s key connect [%d]' %(username, len(self.users)))
      return username

   def removeUser(self, username):
        if username not in self.users:
            return
        lock.acquire()
        del self.users[username]
        lock.release()
        print('disconnect Factory [%d]' %len(self.users))

   def messageHandler(self, username, msg):
      if username == 'PHP':
        targetuser = msg.split("=>")[0]
        content = msg.split("=>")[1]
        if targetuser in self.users.keys():
           self.sendMessageTo(content, targetuser)
        else:
           self.sendMessageTo('x', 'PHP')
      else :
        self.sendMessageTo(msg, 'PHP') 
        return

   def sendMessageTo(self, msg, target):
      self.users[target][0].send(msg.encode())
         

class MyTcpHandler(socketserver.BaseRequestHandler):
   userman = UserManager()
    
   def handle(self):
      print('[%s] connect' %self.client_address[0])
      try:
         username = self.registerUsername()  #처음 receive (사용자 id)
         msg = self.request.recv(1024)       #]
         while msg:
            if self.userman.messageHandler(username, msg.decode()) == -1:
               self.request.close()
               break
            msg = self.request.recv(1024)                
      except Exception as e:
         print(e)
      print('[%s] disconnect' %self.client_address[0])
      self.userman.removeUser(username)

   def registerUsername(self):
      while True:
         username = self.request.recv(1024)
         username = username.decode().strip()
         if self.userman.addUser(username, self.request, self.client_address):
            return username

class ChatingServer(socketserver.ThreadingMixIn, socketserver.TCPServer):
    pass
        
def runServer():
   print('server start')
   print('if you escape this server press Ctrl-C')

   try:
      server = ChatingServer((HOST, PORT), MyTcpHandler)
      server.serve_forever()
   except KeyboardInterrupt:
      print('server close')
      server.shutdown()
      server.server_close()
runServer()
