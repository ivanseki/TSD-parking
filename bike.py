from socket import *
import mysql.connector
import datetime

address1 = ("192.168.0.24", 23)
client_socket = socket(AF_INET, SOCK_DGRAM)
client_socket.settimeout(1)

mydb = mysql.connector.connect(
  host="localhost",
  user="root",
  passwd="lozinka123",
  database="baza"
)

mycursor = mydb.cursor()
station = mydb.cursor()

d = "rfid"
client_socket.sendto(d.encode(), address1)
print(d)

while(1):
    try:
        mycursor.execute("SELECT * FROM korisnik")
        myresult = mycursor.fetchall()
        rec_data1, address1 = client_socket.recvfrom(2048)
        t1 = str(rec_data1.decode())
        print(t1)
        for x in myresult:
            if t1 == x[8] and x[7] == 0:
                mail = x[4]
                data = b"zakljucaj"
                client_socket.sendto(data, address1)
                print(data)
                mycursor.execute("UPDATE `korisnik` SET `Stanje` = 1 WHERE Kartica = %s", [x[8]])
                mydb.commit()
                mycursor.execute("UPDATE `korisnik` SET `Stanica` = 1 WHERE uid = %s", [x[6]])
                mydb.commit()
                station.execute("INSERT INTO `zapisi` (`Email`, `Vrijeme`, `Kartica`, `Stanje`, `Stanica`) VALUES (%s, %s, %s, 'zaključano', 1)", [mail, datetime.datetime.now().strftime("%Y-%m-%d %H:%M:%S"), t1])
                mydb.commit()
            elif t1 == x[8] and x[7] == 1:
                mail = x[4]
                data = b"otkljucaj"
                client_socket.sendto(data, address1)
                print(data)
                mycursor.execute("UPDATE `korisnik` SET `Stanje` = 0 WHERE Kartica = %s", [x[8]])
                mydb.commit()
                mycursor.execute("UPDATE `korisnik` SET `Stanica` = 0 WHERE uid = %s", [x[6]])
                mydb.commit()
                station.execute("INSERT INTO `zapisi` (`Email`, `Vrijeme`, `Kartica`, `Stanje`, `Stanica`) VALUES (%s, %s, %s, 'otključano', 1)", [mail, datetime.datetime.now().strftime("%Y-%m-%d %H:%M:%S"), t1])
                mydb.commit()
        print("")
    except:
        pass