<?php
	use PHPMailer\PHPMailer\PHPMailer; //Kullanılacak sınıfın (PHPMailer) yolu belirtiliyor ve projeye dahil ediliyor
	//use PHPMailer\PHPMailer\Exception;
?>

<form method="post" enctype="multipart/form-data">
		<label>Konu</label>
		  <input name="konu" class="form-control" placeholder="Konu:" required>
		  <input name="mesaj" class="form-control" placeholder="Mesaj:" required>
		  <input type="submit" name="kaydetBtn" class="btn btn-primary" value="Kaydet">
</div>

</form>
<?php
if(isset($_POST['kaydetBtn'])) {
	$konu = $_POST['konu'];
	$mesaj = $_POST['mesaj'];
	$gonderen_email = "noreply@domain.com";
	
	require 'src/Exception.php'; //Mail gönderirken bir hata ortaya çıkarsa hata mesajlarını görebilmek için gerekli. Şart değil
	require 'src/PHPMailer.php'; //Mail göndermek için gerekli.
	require 'src/SMTP.php'; //SMTP ile mail göndermek için gerekli.
	
	$mail = new PHPMailer(); //PHPMailer sınıfı kuruluyor
	$mail->Host = 'smtp.domain.com'; //SMPT mail sunucusu. Ornek: smtp.yandex.com (YANDEX MAIL), smtp.gmail.com (GOOGLE/GMAIL), smtp.live.com (HOTMAIL), mail.ornekmailsunucusu.com (SITENIZE OZEL MAIL SUNUCU)
	$mail->Username = $gonderen_email; //Tanımlanan web sunucusuna ait mail hesabı kullanıcı adı. Ornek: gonderenmailadresi@yandex.com, mail@domainadresi.com
	$mail->Password = 'ŞİFRE'; //Mail hesabı şifre
	$mail->Port = 587; //Mail sunucu mail gönderme portu. Ornek: 587, 465
	$mail->SMTPSecure = 'tls'; //Veri gizliliği yöntemi. Örnek: tls, ssl

	$mail->isSMTP(); //SMPT kullanarak mail gönderilecek
	$mail->SMTPAuth = true; //SMPT kimlik doğrulanmasını etkinleştir
	$mail->isHTML(true); //Mail içeriğinde HTML etiketlerinin algılanmasına izin vermek. False olarak seçilirse ve mail içeriğinde HTML içerikleri varsa etiketler algılanmaksızın normal düz yazı olarak içerikte belirecek

	$mail->CharSet = "UTF-8"; //Mail başlık, konu ve içerikte türkçe karakter desteği mevcut
	$mail->setLanguage('tr', 'language/'); //hata mesajlarını tr dili ile yazdır. 'language' isimli klasörden dil ayarları çekilir. Varsayılan olarak ingilizce seçilidir
	$mail->SMTPDebug  = 2; //işlem sürecini göster. Hataları belirlemenizi kolaylaştırır

	$mail->setFrom($gonderen_email, $konu); //Tanımlanan web sunucusuna ait bir gönderen mail adresi ve isim. Username kısmında belirtilen mail adresi ile aynı olmalı. Ornek: gonderenmailadresi@yandex.com, mail@domainadresi.com

	$mail->AddAddress("XXX@gmail.com"); // Gönderilecek Ana Mail Adresi
	//$mail->addCC('mailadresi@hotmail.com', 'Mert'); //Gönderilecek mail bu adrese de gidecek. Aynı zamanda bu adrese gittiği de mail mesajında belirtilecek.
	//$mail->addBCC('mailadresi2@gmail.com', 'Ömer'); //Gönderilecek mail bu adrese de gidecek. Ancak bu adrese gittiği mail mesajında belirmeyecek.

	$mail->Subject = $konu; //Mail konusu
	$mail->Body = //Mail mesaj içeriği
	'
	'.$mesaj.'
	';

	$mail_gonder = $mail->send(); //Maili gönder ve sonucu değişkene aktar
	if($mail_gonder){ //Mail gönderildi mi
		header("Location: index.php");
		// echo "gönderildi";
	}else{
		echo 'Mail gönderilemedi. Mail hata mesajı: '.$mail->ErrorInfo; //Mail gönderilemezse sebebini belirten hata mesajını ekrana yazdır
	}
}
?>