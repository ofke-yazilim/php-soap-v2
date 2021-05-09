# PHP İle Soap Servis İşlemleri 
Örnek bir soap web servis kodlandı. Kodlanan web servise istemciler tarafında 
nasıl istek atılacağı gösterildi.
## Server Tarafı 
Soap servisin oluşturulduğu: yani istemcilere cevap veren taraftır. Bir soap web servisine ait tüm 
tanımlamarı içeren `WSDL`dosyası server tarafında oluşturulmaktadır. Örnek bir WSDL dosyası aşağıdaki 
bilgileri içermektedir. 

- Web servise ait tanım bilgilerini içerir. **`<definitions>`**
- Web servise ait veri türlerini içerir. **`<types>`**
- Web servise ait girdi ve çıktı tanımlamalarını içerir. **`<message>`**
- Web servisin işlevini içerir. **`<portType>`**
- Web servise ait her bir port(işlev) için mesaj formatı ve protokol bilgilerini barındırır.**`<binding>`**

### a) **`definitions`** etiketi
Oluşturulacak olan xml dosyasının ilk etiketidir. Diğer etiketleri içerisinde barındırır. Etiket içerisinde 
`name` parametresi servise vermek istediğiniz ismi belirtir. `targetNamespace` parametresi oluşturduğunuz bu wsdl 
dosyasına ait http ya da https adresini içeririr. Örnek bir kullanım aşağıdaır.
```html
<wsdl:definitions name="OrnekServisAd"
      xmlns:soap="http://schemas.xmlsoap.org/wsdl/soap/"
      xmlns:xsd="http://www.w3.org/2001/XMLSchema"
      xmlns:wsdl="http://schemas.xmlsoap.org/wsdl/"
      xmlns="http://schemas.xmlsoap.org/wsdl/"
      xmlns:tns="http://okesmez.com/php-soap-v2"
      targetNamespace="http://okesmez.com/php-soap-v2">
</wsdl:definitions>
```
### b) **`types`** etiketi
Servise ait girdi ve çıktı parametrelerine ait datatype değerlerini belirlemenizi sağlar. Aşağıda giriş değerini ve çıkış değerini **object**
türünde olan bir tanımlama örneğini göreblirsiniz. Bir çok data tipi için input ve output tanımlayabilirsiniz. (_**int,float,string,double vb.**_)
```html
<types>
   <schema targetNamespace = "http://okesmez.com/php-soap-v2/ornek.xsd" 
           xmlns = "http://www.w3.org/2000/10/XMLSchema">	
      <element name = "ornekInput">
         <complexType>
            <all>
               <element name = "getData" type = "object"/>
            </all>
         </complexType>
      </element>
		
      <element name = "ornekOutput">
         <complexType>
            <all>
               <element name = "sendData" type = "object"/>
            </all>
         </complexType>
      </element>
		
   </schema>
</types>
```
### c) **`message`** etiketi
Tanımlanan data tiplerine göre nasıl mesaj dönüleceğini belirlediğimiz kısımdır. Yukarıda tanımlamış olduğumuz **ornekInput** ve **ornekOutput** için 
örnek kullanım aşağıdadır.
```html
<message name = "ornekRequest">
   <part name = "ornekInput" type = "xsd:ornekInput"/>
</message>

<message name = "ornekResponse">
   <part name = "ornekOutput" type = "xsd:ornekOutput"/>
</message>
```

### d) **`portType`** etiketi
Hangi response verisinin hangi request değerine göre gönderileceğini belirlediğimiz kısımdır. Aşağıda, yukarıda tanımladığımız request ve response tanımlamalarını
ornek adında bir işleve atıyoruz. ornek işlevimiz aynı zamanda sunucuda yazdığımız fonksiyonun ismidir.
```html
<portType name = "Ornek_PortType">
   <operation name = "ornek">
      <input message = "tns:ornekRequest"/>
      <output message = "tns:ornekResponse"/>
   </operation>
</portType>
```

### e) **`binding`** etiketi
portType işleminin nasıl iletileceğine dair ayrıntıları saklayan etikettir. Verilerin nasıl taşınacağını belirtir.
```html
<binding name = "Ornek_Binding" type = "tns:Ornek_PortType">
    <soap:binding style="document" transport="http://schemas.xmlsoap.org/soap/http" xmlns:soap="http://schemas.xmlsoap.org/wsdl/soap/"/>
    <operation name = "ornek">
        <soap:operation soapAction = "ornek"/>
        <input>
            <soap:body use="literal" xmlns:soap="http://schemas.xmlsoap.org/wsdl/soap/"/>
        </input>
    
        <output>
           <soap:body use="literal" xmlns:soap="http://schemas.xmlsoap.org/wsdl/soap/"/>
        </output>
    </operation>
</binding>
```

### f) **`service`** etiketi
Bu etiket içerisinde sunucu tarafında kodların koşturulacağı adres tanımlanır.
```html
<service name = "Ornek_Service">
   <documentation>WSDL File for OrnekService</documentation>
   <port binding = "tns:Ornek_Binding" name = "Ornek_Port">
      <soap:address
         location = "http://okesmez.com/php-soap-v2/server.php">
   </port>
</service>
```
### g) Server üzerinde PHP işlemleri.
Yukarıda oluşturduğumuz wsdl dosyası web servisimizin hangi giriş parametreleri ile hangi işlevi gerçekleştirdiğini ve sonucunda hangi veriyi döndüğünü 
içermektedir. Bizim örneğimizde sunucu tarafında `ornek` adında bir fonksiyon çalıştırılmaktadır. Bu fonksiyon tanımlamsını **portType** etiketi altında yaptık. 
ornek fonksiyonu `ornekInput` adında **object** türünde bir girdi alıp, `ornekOutput ` adında **object** türünde bir çıktı üretmektedir. Bu girdi ve
çıktı tanımlamalarınıda **message** etiketi altında yaptık.
Şimdi php tarafında bir class oluşturup bu class içerisinde `ornek` fonksiyonunu tanımlayarak istediğimiz işlemleri gerçeklemeliyiz. Class/Response.php 
oluşturup içerisinde ornek fonksiyonunu tanımladık. Sonrasında Tanımlamış olduğumuz bu Response class'ını soap server'a atamak için server.php adında bir
dosya oluşturup gerekli gerekli standart tanımlamaları yaptık.