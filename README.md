Panduan Instalasi Utuh Web App Final Project Data Warehouse - Data Warehouse Paralel B

1. Clone repository atau unduh file secara manual. Jika mengunduh manual, pastikan untuk mengekstrak file hasil unduhan dari repository.  
2. Pindahkan source code aplikasi web tersebut ke direktori C:\xampp\htdocs.  
3. Buka source code aplikasi web menggunakan Visual Studio Code atau editor teks favorit Anda.  
4. Dalam source code, Anda akan menemukan folder database berisi uasdwo.sql dwuas.sql. Buat database baru di XAMPP, lalu impor file tersebut agar aplikasi web dapat terhubung dengan database.  
5  Salin file mondrianuas.xml, mondrianuas.jsp, ke direktori C:\xampp\tomcat\webapps\mondrian\WEB-INF\queries. Pastikan Mondrian.war sudah terinstall serta plugin mysql-connector, jtds & sqljdbc. 
6. Untuk koneksi database, gunakan username root dan password kosong (`""`), yang merupakan kredensial default pada XAMPP. Jika kredensial XAMPP Anda berbeda, sesuaikan dengan mengubah source code.  
7. Buka terminal atau Command Prompt, arahkan ke direktori source code aplikasi web, lalu jalankan perintah npm install untuk menginstal semua library JavaScript yang diperlukan.  
8. Ketikkan perintah npm start untuk membangun (build) aplikasi web agar file library yang diperlukan ter-generate.  
9. Jalankan Apache, MySQL, dan Tomcat dari XAMPP, lalu akses aplikasi web melalui browser dengan URL: http://localhost/uasdwo/index.php 
10. Masukkan username = mizan, password = toko.
10. Anda akan melihat tampilan aplikasi web lengkap dengan Mondrian Cube.
