# Dernek Framework - Standart Sayfa Envanteri


## 1. Başlıca Sayfalar ve Akışlar

### 1. Anasayfa (Home Page)
- **URL:** `/`
- **Şablon Adı:** `front-page.php`
- **Dinamik mi statik mi:** Dinamik (Gutenberg blokları ve dinamik döngüler)
- **CRM bağlantısı var mı:** Evet (Aktif bağış projeleri, genel bağış istatistikleri ve hızlı bağış seçenekleri CRM'den anlık çekilir)
- **CPT gerektiriyor mu:** Hayır
- **ACF gerektiriyor mu:** Evet (Slider alanları, öne çıkarılan bağış kutuları, genel anasayfa ayarları için `peta_home_fields` grubu)

### 2. Kurumsal Sayfa (Corporate Page - Hakkımızda vb.)
- **URL:** `/hakkimizda` (veya kurumsal alt kırılımlar)
- **Şablon Adı:** `page.php` (Varsayılan sayfa şablonu)
- **Dinamik mi statik mi:** Dinamik (Gutenberg Blokları ile içerik oluşturulur)
- **CRM bağlantısı var mı:** Hayır
- **CPT gerektiriyor mu:** Hayır
- **ACF gerektiriyor mu:** Evet (Gutenberg blok bazlı ACF şeması)

### 3. İletişim (Contact)
- **URL:** `/iletisim`
- **Şablon Adı:** `page-contact.php`
- **Dinamik mi statik mi:** Dinamik
- **CRM bağlantısı var mı:** Evet (Form üzerinden girilen mesajlar, şikayetler ve öneriler doğrudan CRM müşteri ilişkileri veya talep modülüne gönderilir)
- **CPT gerektiriyor mu:** Hayır
- **ACF gerektiriyor mu:** Evet (Harita iframe/koordinatları, şube iletişim bilgileri, form alıcıları için `peta_contact_fields` grubu)

### 4. Faaliyetler (Activities Archive / Page)
- **URL:** `/faaliyetler` (Kategori filtreli listeleme sayfası)
- **Şablon Adı:** `page-faaliyetler.php`
- **Dinamik mi statik mi:** Dinamik
- **CRM bağlantısı var mı:** Hayır
- **CPT gerektiriyor mu:** Evet (`peta_activity` CPT'sini listeler)
- **ACF gerektiriyor mu:** Evet (Faaliyete bağlı bağış kategorisi eşleme alanı. Faaliyet detay sayfasındaki sidebar bağış kutusunda listelenecek ürün kategorileri ACF üzerinden seçilebilir)

### 5. Projeler (Projects Archive / Page)
- **URL:** `/projeler`
- **Şablon Adı:** `page-projeler.php`
- **Dinamik mi statik mi:** Dinamik
- **CRM bağlantısı var mı:** Evet (Projelerin CRM entegrasyonu ile anlık toplanan bağış ve hedef bağış tutarları çekilir)
- **CPT gerektiriyor mu:** Evet (`peta_project` CPT'sini listeler)
- **ACF gerektiriyor mu:** Evet (CRM Ürün Kodu eşleştirmesi, proje kısa açıklaması)

### 6. Bağış Yap (Bağış Kataloğu / Donation Page)
- **URL:** `/online-bagis` veya `/bagis`
- **Şablon Adı:** `page-templates/template-donation.php`
- **Dinamik mi statik mi:** Dinamik
- **CRM bağlantısı var mı:** Evet (CRM'deki tüm aktif fonlar ve projeler kategorilerine göre listelenir ve filtrelenir (Ör: kurban, yetim vb.). İçi boş olan, yani aktif bağış ürünü barındırmayan kategoriler arayüzde gösterilmez/gizlenir. Asgari bağış limitleri doğrulanır, sepete ekleme yapılır)
- **CPT gerektiriyor mu:** Hayır
- **ACF gerektiriyor mu:** Evet (Varsayılan seçili fon, form başlıkları, öne çıkarılan projeler listesi için `peta_donation_page_fields` grubu)

### 7. Hesap Numaraları (Bank Accounts Page)
- **URL:** `/hesap-numaralari`
- **Şablon Adı:** `page-templates/template-hesap-numaralari.php` (Page Template)
- **Dinamik mi statik mi:** Dinamik
- **CRM bağlantısı var mı:** Hayır
- **CPT gerektiriyor mu:** Hayır
- **ACF gerektiriyor mu:** Evet (ACF Options Page (`peta_options`) altındaki Banka Hesapları sekmesinden/tabından dinamik olarak beslenir ve listelenir)

### 8. Flyout Ajax Sepet (Ajax Cart Drawer)
- **Tür:** Sayfa dışı, sağdan açılan dinamik Flyout / Drawer bileşenidir (Tüm sayfalarda enjektedir)
- **Özellikler:**
  - Sepetten ürün/bağış çıkarma (Remove Item)
  - Sepeti tamamen temizleme (Clear Cart)
  - Sepetteki bağış adedi/miktarını dinamik değiştirme (Change Quantity - örn. hisse adedi artırma/azaltma)
- **CRM bağlantısı var mı:** Evet (Sepetteki bağış kalemleri CRM ürün ID'leri ve limitleri ile dinamik olarak doğrulanır)
- **CPT / ACF gereksinimi:** Hayır

### 9. Payment / Ödeme Sayfası (Donation Checkout)
- **URL:** `/odeme`
- **Şablon Adı:** `page-odeme.php`
- **Dinamik mi statik mi:** Dinamik
- **CRM bağlantısı var mı:** Evet (POS entegrasyonu ve CRM bağış kaydı aktarımı için yoğun bağlantı)
- **Özellikler ve Form Bölümleri:**
  - **Bağışçı Bilgileri:** Ad, Soyad, Telefon (SMS OTP için), E-posta, T.C. Kimlik No (Vergi indirimi/makbuz için).
  - **Sepet Özeti:** Sepetteki ürünler listelenir; kullanıcı bu sayfada da sepetten ürün çıkarma yapabilir.
  - **Kredi Kartı Bilgileri:** Kart No, S.K.T, CVC alanları (Sanal POS entegrasyonu).
  - **Adına Bağış / Hisse Bilgileri:** Bağışın kimin adına yapılacağı bilgisi ("Adına Bağış" alanı) veya CRM'den dinamik gelen hisse bilgileri (Hissedar ad-soyad listesi giriş alanları).
- **CPT / ACF gereksinimi:** Hayır (Sanal POS ve API ayarları ACF Options sayfasından okunur)

### 10. Ödeme Onay Modalı (Payment Verification Modal Overlay)
- **Tür:** Dinamik Ödeme/Onay Modalı (Ödeme tetiklendiğinde açılır)
- **Özellikler:**
  - Cloudflare Turnstile Captcha doğrulaması (Güvenlik katmanı)
  - Banka Response yönetimi (3D Secure yönlendirmesi veya modal içi banka arayüzü)
  - SMS OTP / SMS Onay Kodu giriş ekranı
- **CRM bağlantısı var mı:** Evet (Ödeme doğrulanıp tamamlandığında işlem kodu CRM'e gönderilerek bağış kaydı nihayete erdirilir)
- **CPT / ACF gereksinimi:** Hayır

### 11. Video Galeri / İzleme Sayfası (Video Gallery / Query Page)
- **URL:** `/video-galeri` (Sorgulama parametresi: `/video-galeri?code=XYZ` veya `.htaccess` / WordPress rewrite kuralları ile `/v/{video_code}` örneğin: `/v/ABC-Xy44`)
- **Şablon Adı:** `page-video-galeri.php`
- **Dinamik mi statik mi:** Dinamik
- **CRM bağlantısı var mı:** Evet (Yoğun entegrasyon: Bağışçının SMS ile aldığı veya doğrudan formdan sorguladığı video kodu ile CRM'den ilişkili su kuyusu/proje video URL'si, plaket yazısı ve proje detayları sorgulanarak dinamik video oynatıcı üzerinde gösterilir)
- **CPT gerektiriyor mu:** Hayır (Gutenberg/varsayılan sayfa şablonu dışında özel dinamik sorgu şablonu kullanır)
- **ACF gerektiriyor mu:** Evet (Arama kutusu placeholder, video bulunamadı hata mesajları ve varsayılan kapak görselleri için `peta_video_gallery_fields` grubu)

### 12. Elementler ve Stil Rehberi Sayfası (Style Guide & Elements Page)
- **URL:** `/elementler` veya `/elements`
- **Şablon Adı:** `page-elements.php`
- **Dinamik mi statik mi:** Statik
- **CRM bağlantısı var mı:** Hayır
- **CPT gerektiriyor mu:** Hayır
- **ACF gerektiriyor mu:** Hayır (Geliştirme ve test süreçlerinde temadaki tüm UI bileşenlerini, butonları, form elemanlarını, renk paletlerini ve tipografi kurallarını canlı önizlemek amacıyla kullanılan teknik şablon sayfasıdır)

---

## 2. Başlıca Gutenberg Bileşenleri (`@blocks`)

Tema içerisindeki `blocks/` dizininde yer alan ve sayfalarda kullanılan başlıca Gutenberg bileşenleri şunlardır:

### 1. `hero` (Hero/Slider Bloğu)
- **Kullanım Yeri:** Anasayfa ve Kurumsal sayfaların en üst alanı.
- **ACF Alanları:** Başlık, alt başlık, arka plan görseli/videosu, buton linkleri.

### 2. `featured-donations` (Öne Çıkan Bağışlar)
- **Kullanım Yeri:** Anasayfa ve Bağış Sayfası.
- **Açıklama:** Belirli bağış fonlarını kart tasarımları ile yan yana listeler.
- **ACF Alanları:** Listelenecek bağış kategorileri, başlık, alt başlık.

### 3. `featured-projects` (Öne Çıkan Projeler)
- **Kullanım Yeri:** Anasayfa ve Faaliyet sayfaları.
- **Açıklama:** Aktif yardım projelerini dinamik ilerleme çubukları (hedef vs. toplanan tutar) ile listeler.
- **ACF Alanları:** Seçilen projeler (`peta_project` CPT ilişkisi), başlık.

### 4. `donation-appeal` (Bağış Çağrısı Kutusu)
- **Kullanım Yeri:** Proje ve Faaliyet detay sayfaları (`single-project.php` / `single-activity.php`) sidebar alanı.
- **Açıklama:** Ziyaretçinin doğrudan proje detayından sepete bağış eklemesini sağlayan form kutusudur.
- **ACF Alanları:** Seçilebilir alt ürünler/hisseler, varsayılan bağış miktarları, CRM ürün kodu.

### 5. `donation-process` (Bağış Adımları)
- **Kullanım Yeri:** Anasayfa ve Kurumsal sayfalar.
- **Açıklama:** Derneğin bağışları nasıl topladığını ve ulaştırdığını adımlı şema ile gösterir.
- **ACF Alanları:** Adım başlıkları, ikonlar, kısa açıklamalar.

### 6. `faq` (Sıkça Sorulan Sorular)
- **Kullanım Yeri:** SSS Sayfası (`/sss`).
- **Açıklama:** Akordeon yapısında soruları ve cevapları listeler.
- **ACF Alanları:** Soru-cevap tekrarlayıcı (repeater) alanları.

### 7. `gallery` (Fotoğraf & Video Galerisi)
- **Kullanım Yeri:** Galeri sayfası (`/galeri`).
- **Açıklama:** Resim albümlerini ve YouTube videolarını lightbox destekli listeler.
- **ACF Alanları:** Galeri tipi (Fotoğraf/Video), resim yükleme alanları, YouTube URL tekrarlayıcı.

### 8. `stats-grid` (İstatistik Izgarası)
- **Kullanım Yeri:** Anasayfa ve Kurumsal sayfalar.
- **Açıklama:** Derneğin başarı/yardım istatistiklerini sayısal verilerle kutular halinde listeler.
- **ACF Alanları:** İstatistik sayısı, başlık, simge/ikon seçimi.

### 9. `timeline` (Zaman Çizelgesi / Tarihçe)
- **Kullanım Yeri:** Kurumsal / Hakkımızda sayfası.
- **Açıklama:** Derneğin kuruluşundan bugüne kadar olan önemli kilometre taşlarını dikey/yatay çizgide listeler.
- **ACF Alanları:** Yıl, olay başlığı, olay görseli ve açıklama tekrarlayıcı alanı.

---

## 3. Diğer Yardımcı ve Yasal Sayfalar

### 1. KVKK ve Gizlilik Politikası
- **URL:** `/kvkk` veya `/gizlilik-politikasi`
- **Şablon:** `page.php` (Varsayılan sayfa şablonu)
- **Gutenberg:** `content-section` bloğu ile içerik yönetilir.

### 2. Kullanıcı Sözleşmesi ve Üyelik Şartları
- **URL:** `/kullanici-sozlesmesi`
- **Şablon:** `page.php`
- **Gutenberg:** `content-section` bloğu ile içerik yönetilir.

### 3. Mesafeli Satış/Bağış Sözleşmesi
- **URL:** `/mesafeli-bagis-sozlesmesi`
- **Şablon:** `page.php`
- **Gutenberg:** `content-section` bloğu ile içerik yönetilir.

### 4. İade ve İptal Koşulları
- **URL:** `/iptal-ve-iade-kosullari`
- **Şablon:** `page.php`
- **Gutenberg:** `content-section` bloğu ile içerik yönetilir.

### 5. Çerez Politikası
- **URL:** `/cerez-politikasi`
- **Şablon:** `page.php`
- **Gutenberg:** `content-section` bloğu ile içerik yönetilir.

### 6. 404 Sayfası (Not Found Page)
- **URL:** Tanımsız / Hatalı istekler
- **Şablon:** `404.php`
- **Dinamik mi statik mi:** Statik
- **CRM bağlantısı var mı:** Hayır
- **CPT gerektiriyor mu:** Hayır
- **ACF gerektiriyor mu:** Evet (Hata başlıkları, görseller ve anasayfaya yönlendirme butonları yönetimi için `peta_404_fields` grubu)

