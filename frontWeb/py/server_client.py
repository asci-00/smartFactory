import socket
import sys
import json
import pymysql
from threading import Thread

HOST = 'localhost'
PORT = 9009
deviceid = 'PHP' #나중에 파일로 저장(토큰)

class MysqlController:
   def __init__(self, host, id, pw, db_name):
      self.conn = pymysql.connect(host=host, user= id, password=pw, db=db_name,charset='utf8')
      self.curs = self.conn.cursor(pymysql.cursors.DictCursor)

   def find_work(self, id):
      sql = "SELECT * FROM `work` WHERE id=%s" %id
      self.curs.execute(sql)
      rows = self.curs.fetchone()
      return rows

def router():
    mysql = MysqlController(HOST, 'root', '3qufvv', 'worklist')

    name = sys.argv[1]
    workID = sys.argv[2]
    
    with socket.socket(socket.AF_INET, socket.SOCK_STREAM) as sock:
         sock.connect((HOST, PORT))
         sock.send(deviceid.encode())

         name = sys.argv[1]
         workID = sys.argv[2]

         data = mysql.find_work(workID)
         id = data['id']
         json_str = json.dumps(data)
         msg = "%s=>%s<=%s" %(name, id, json_str)
         sock.send(msg.encode())
         print (sock.recv(1024).decode())
         sock.close()
router()
