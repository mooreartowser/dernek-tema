# Dernek Framework - Template Registry & Architecture Map

Bu doküman, Dernek Framework altındaki tüm sayfaların, bileşenlerin (Gutenberg Blocks), yerleşim taslaklarının (Layouts) ve CRM entegrasyon bileşenlerinin katmanlı mimari yapısını ve birbirleriyle olan ilişkilerini tanımlar.

---

## 1. Katman Tanımları (Layer Definitions)

Dernek Framework mimarisi, kod tekrarını önlemek, CRM mantığını arayüzden soyutlamak ve Gutenberg editörünü esnek tutmak adına **4 katmana** ayrılmıştır:

```
┌─────────────────────────────────────────────────────────┐
│                      1. LAYOUT                          │  <- Global Çerçeveler (Header, Footer, Sidebar Yapısı)
│  ┌───────────────────────────────────────────────────┐  │
│  │                   2. TEMPLATE                     │  │  <- Sayfa Şablonu (Sorgu döngüleri, veri hazırlığı)
│  │  ┌─────────────────────────────────────────────┐  │  │
│  │  │                3. COMPONENT                 │  │  │  <- Görsel Bileşenler (Gutenberg Blokları, UI Elemanları)
│  │  └─────────────────────────────────────────────┘  │  │
│  │  ┌─────────────────────────────────────────────┐  │  │
│  │  │              4. CRM COMPONENT               │  │  │  <- Dinamik Entegrasyonlar (Sepet, Ödeme, Üye Paneli)
│  │  └─────────────────────────────────────────────┘  │  │
│  └───────────────────────────────────────────────────┘  │
└─────────────────────────────────────────────────────────┘
```

1. **Layout (Yerleşim)**: Sayfanın dış iskeletini ve global alanları (Header, Footer, Yan Menüler, Script/Stil enjeksiyonları) tanımlar.
2. **Template (Şablon)**: WordPress hiyerarşisinde (`front-page.php`, `page.php`, vb.) yer alan, veriyi çeken, sorguları (WP_Query) yöneten ve bileşenleri bir araya getiren ana sayfa şablonudur.
3. **Component (Bileşen)**: Bağımsız, tekrar kullanılabilir, görsel ve statik/yarı-dinamik HTML/CSS/JS bloklarıdır (Gutenberg ACF Blokları). CRM bağımlılıkları yoktur veya sadece veri prop olarak dışarıdan beslenir.
4. **CRM Component (CRM Bileşeni)**: CRM SDK/API, Redis oturumları, GraphQL sorguları veya `_esas/` ağ geçidi ile doğrudan haberleşen, durum yönetimine (state management) sahip dinamik arayüz elemanlarıdır (örn. Sepet Çekmecesi, Ödeme Formu).

---

## 2. Global Bileşenler ve Layout Haritası

Tüm sistemi saran veya global olarak enjekte edilen ortak yerleşimler ve bileşenler şunlardır:

### Layouts
*   **Default Layout (`layouts/default.php`)**: Standart başlık (Header), ana içerik alanı ve alt bilgiyi (Footer) içerir. Kurumsal, blog, faaliyetler, iletişim ve yasal sayfalar için kullanılır.
*   **Checkout Layout (`layouts/checkout.php`)**: Minimalist yerleşim. Dikkat dağıtıcı ana navigasyonu, sosyal medya butonlarını ve geniş footer alanını gizleyerek yalnızca sepet özeti ve güvenli ödeme formuna odaklandırır.
*   **Account Layout (`layouts/account.php`)**: Oturum açmış kullanıcılar için sol tarafta profil navigasyonu (Profilim, Bağış Geçmişim, Güvenli Çıkış) ve sağ tarafta dinamik içerik alanı barındıran iki sütunlu panel yerleşimi.
*   **Full Width Layout (`layouts/full-width.php`)**: İçerik sınırlandırması (container) bulunmayan, ekranı tamamen kaplayan özel açılış (landing) veya stil rehberi sayfaları için yerleşim.

### Global Components (Genel Bileşenler)
*   **Site Header (`components/header.php`)**: Logolar (Light/Dark), dinamik WordPress menüsü, dil değiştirici ve Header CTA butonu (Bağış Yap).
*   **Site Footer (`components/footer.php`)**: Kurumsal bilgiler, site haritası, sosyal medya linkleri (repeater), bülten aboneliği ve copyright alanı.
*   **Notification Toast (`components/notification.php`)**: Sepete ekleme, hata veya başarılı işlem durumlarında tetiklenen global bilgilendirme balonları.

---

## 3. Sayfa Bazlı Mimari Harita (Page-by-Page Mapping)

### 1. Anasayfa (Home Page)
*   **URL**: `/`
*   **WordPress Dosyası**: `front-page.php`
*   **1. Layout**: `Default Layout`
*   **2. Template**: `Home Template`
*   **3. Component**:
    *   `hero` (Slider/Banner bloğu)
    *   `featured-donations` (ACF üzerinden seçilen bağış türleri)
    *   `featured-projects` (Öne çıkan projelerin dinamik listesi)
    *   `donation-process` (Bağış adımları şeması)
    *   `stats-grid` (Dernek istatistikleri)
*   **4. CRM Component**:
    *   `Quick Donation Form`: Hızlı bağış miktarı seçip doğrudan sepete ekleme sağlayan widget (Hero içinde veya bağımsız blok).
    *   `Cart Drawer (Flyout)`: Sağdan açılan sepet çekmecesi entegrasyonu.
*   **ACF Field Group**: `peta_home_fields` (Slider, öne çıkanlar yönetimi).

### 2. Kurumsal Sayfa (Corporate Page / Hakkımızda)
*   **URL**: `/hakkimizda` (ve alt kırılımlar)
*   **WordPress Dosyası**: `page.php`
*   **1. Layout**: `Default Layout`
*   **2. Template**: `Default Page Template`
*   **3. Component**:
    *   `hero` (Kurumsal iç sayfa başlığı ve görseli)
    *   `timeline` (Dikey/yatay tarihçe akışı)
    *   `stats-grid` (Kurumsal başarı sayıları)
    *   Gutenberg default block yapısı (`content-section`)
*   **4. CRM Component**:
    *   `Cart Drawer (Flyout)` (Global tetikleyici)
*   **ACF Field Group**: Esnek Gutenberg blok yapıları (`blocks/` ACF tanımlamaları).

### 3. İletişim (Contact Page)
*   **URL**: `/iletisim`
*   **WordPress Dosyası**: `page-contact.php`
*   **1. Layout**: `Default Layout`
*   **2. Template**: `Contact Template`
*   **3. Component**:
    *   `Contact Info Grid`: Şube telefonları, adresler ve e-posta listesi (ACF Options panelinden veya sayfa alanından beslenir).
    *   `Map Embed Block`: Google Maps iframe alanı.
*   **4. CRM Component**:
    *   `CRM Contact Form`: Form verilerini alan ve `_esas/` veya WordPress API üzerinden doğrudan CRM Talep/Destek modülüne aktaran AJAX tabanlı form bileşeni.
*   **ACF Field Group**: `peta_contact_fields` (Iframe kodları, şube listeleri, form alıcı e-postaları).

### 4. Faaliyetler Arşivi (Activities Page)
*   **URL**: `/faaliyetler`
*   **WordPress Dosyası**: `page-faaliyetler.php`
*   **1. Layout**: `Default Layout`
*   **2. Template**: `Activities Archive Template`
*   **3. Component**:
    *   `Archive Header`: Kategori bazlı filtreleme butonları.
    *   `Activity Card Grid`: `peta_activity` CPT'sine bağlı faaliyet kartları.
*   **4. CRM Component**:
    *   Yok (Statik/Dinamik içerik sunumu).
*   **ACF Field Group**: `peta_activity_fields` (Faaliyet detay sayfaları ve kategorileri için özel ACF alanları).

### 5. Faaliyet Detay Sayfası (Single Activity Page)
*   **URL**: `/faaliyet/{faaliyet-slug}`
*   **WordPress Dosyası**: `single-peta_activity.php`
*   **1. Layout**: `Default Layout`
*   **2. Template**: `Single Activity Template`
*   **3. Component**:
    *   `Post Content`: Zengin metin, fotoğraf galerisi veya video bloğu.
*   **4. CRM Component**:
    *   `donation-appeal` (Sidebar): Bu faaliyete atanmış CRM Ürün Kategorisindeki ürünleri listeler, asgari bağış limitlerini denetler ve sepete ekletir.
*   **ACF Field Group**: `peta_activity_donation_mapping` (İlişkili CRM bağış kategori/ürün eşleşmesi).

### 6. Projeler Arşivi (Projects Page)
*   **URL**: `/projeler`
*   **WordPress Dosyası**: `page-projeler.php`
*   **1. Layout**: `Default Layout`
*   **2. Template**: `Projects Archive Template`
*   **3. Component**:
    *   `Project Filter Tab`: Aktif/Tamamlanan proje sekmeleri.
    *   `Project Grid`: `peta_project` CPT döngüsü.
*   **4. CRM Component**:
    *   `Project Progress Info`: Projelerin CRM Ürün ID'si üzerinden anlık toplanan miktar ve hedef miktar verilerini çekerek "Donation Progress Bar" çizer.
*   **ACF Field Group**: `peta_project_fields` (Proje kodları ve genel CPT alanları).

### 7. Proje Detay Sayfası (Single Project Page)
*   **URL**: `/proje/{proje-slug}`
*   **WordPress Dosyası**: `single-peta_project.php`
*   **1. Layout**: `Default Layout`
*   **2. Template**: `Single Project Template`
*   **3. Component**:
    *   `Project Content Section`: Detay yazıları, güncellemeler, belgeler.
*   **4. CRM Component**:
    *   `donation-appeal` (Sidebar): Proje için belirlenen CRM ürününü (örn: Su kuyusu hissesi veya Yetim sponsorluğu) sepete ekleyen dinamik form.
    *   `Project Progress Detail`: Detaylı bağış durumu, kalan tutar ve hedef grafik göstergesi.
*   **ACF Field Group**: `peta_project_crm_meta` (CRM Ürün Kodu, Hisseli/Tekil bağış seçimi).

### 8. Bağış Yap (Donation Catalog Page)
*   **URL**: `/online-bagis` veya `/bagis`
*   **WordPress Dosyası**: `page-templates/template-donation.php`
*   **1. Layout**: `Default Layout`
*   **2. Template**: `Donation Catalog Template`
*   **3. Component**:
    *   `Catalog Header`: Kategori açıklamaları ve hızlı yönlendirmeler.
*   **4. CRM Component**:
    *   `Donation Catalog Filter & Grid`: `getCategoriesWithProducts` GraphQL sorgusu ile aktif olan tüm CRM kategorilerini ve bunlara bağlı ürünleri (Adak, Yetim, Kurban, Genel vb.) çeker ve listeler.
    *   `Catalog Donation Card`: Her ürün için fiyat tipine göre (sabit/serbest tutar) giriş alanları sunan ve sepet işlemlerini AJAX ile gerçekleştiren dinamik kartlar.
*   **ACF Field Group**: `peta_donation_page_fields` (Varsayılan seçili kategori, filtre ayarları).

### 9. Hesap Numaraları (Bank Accounts Page)
*   **URL**: `/hesap-numaralari`
*   **WordPress Dosyası**: `page-templates/template-hesap-numaralari.php`
*   **1. Layout**: `Default Layout`
*   **2. Template**: `Bank Accounts Template`
*   **3. Component**:
    *   `Bank Account Grid`: Banka adı, şube kodu, hesap no, IBAN ve Swift kodunu listeleyen arayüz kartları.
    *   `Copy Button Tool`: Kullanıcının IBAN numarasını tek tıkla kopyalamasını sağlayan mikro etkileşim.
*   **4. CRM Component**:
    *   Yok (Veriler ACF Options'tan okunur).
*   **ACF Field Group**: `peta_options` -> `bank_accounts` (ACF Repeater alanları).

### 10. Ödeme Sayfası (Donation Checkout)
*   **URL**: `/odeme`
*   **WordPress Dosyası**: `page-odeme.php`
*   **1. Layout**: `Checkout Layout` (Minimalist, menüsüz çerçeve)
*   **2. Template**: `Checkout Template`
*   **3. Component**:
    *   `Security Badges`: SSL, 3D Secure ve PCI-DSS logoları.
*   **4. CRM Component**:
    *   `Checkout Basket Summary`: Sepetteki ürünleri listeler, miktar güncelleme ve ürünü listeden çıkarma yeteneğine sahiptir.
    *   `Donor Details Form`: Bağışçı Ad, Soyad, Telefon, E-posta ve T.C. Kimlik No giriş alanları.
    *   `Intent/Beneficiary Form`: Bağış adına (veya hisse adına) yapılacak kişilerin ad-soyad bilgilerini toplayan dinamik form alanları.
    *   `Credit Card Form`: Kart numarası, son kullanma tarihi ve CVC bilgilerini toplayan ve `_esas/` güvenli ödeme başlatma servisine gönderen form.
    *   `Payment Verification Modal Overlay`: Cloudflare Turnstile CAPTCHA doğrulamasını tetikleyen ve 3D Secure yönlendirmesi ile SMS OTP (Tek Kullanımlık Şifre) giriş ekranını yöneten modal katman.

### 11. Video Galeri / Sorgulama Sayfası (Video Gallery / Query Page)
*   **URL**: `/video-galeri` veya `/v/{video_code}`
*   **WordPress Dosyası**: `page-video-galeri.php`
*   **1. Layout**: `Default Layout`
*   **2. Template**: `Video Gallery Query Template`
*   **3. Component**:
    *   `Video Query Form`: Video kodu giriş alanı ve sorgula butonu.
*   **4. CRM Component**:
    *   `Dynamic Video Player & Plaque Display`: Girilen video kodunu CRM API'ye ileterek ilişkili proje/su kuyusu video URL'sini (YouTube/Vimeo/S3), plaket görselini ve proje detay metnini getiren, bulunamazsa hata durumlarını yöneten dinamik oynatıcı alanı.
*   **ACF Field Group**: `peta_video_gallery_fields` (Hata mesajları, placeholder ve varsayılan görseller).

### 12. Üye Giriş / Kayıt Paneli (Auth Modal & Page)
*   **URL**: `/giris` veya Global Modal üzerinden açılır
*   **WordPress Dosyası**: Global bileşen veya özel sayfa şablonu
*   **1. Layout**: `Default Layout` (Sayfa ise) veya Modal Overlay
*   **2. Template**: `Auth Template`
*   **3. Component**:
    *   `Logo & Welcome Screen`
*   **4. CRM Component**:
    *   `Login Phone Form`: Telefon numarasını alıp `endUserSendOtp` mutasyonu ile SMS OTP kodunu tetikleyen form.
    *   `OTP Form`: Gelen SMS şifresini alıp `endUserLogin` mutasyonuna gönderen ve JWT token'ı alan form. Çerez (`endUserToken`) yönetimini koordine eder.

### 13. Hesabım Paneli (User Dashboard)
*   **URL**: `/hesabim`
*   **WordPress Dosyası**: `page-templates/template-account.php`
*   **1. Layout**: `Account Layout` (Yan navigasyonlu yapı)
*   **2. Template**: `User Dashboard Template`
*   **3. Component**:
    *   `Dashboard Navigation Sidebar`
*   **4. CRM Component**:
    *   `Account Summary Cards`: Toplam bağış miktarı, bağış adedi ve son bağış tarihini (`getDonorSummary`) gösteren sayaçlar.
    *   `Donor Profile Editor`: Kullanıcının ad, soyad ve telefon bilgilerini görüntüleyen/güncelleyen (`endUserMe` verisi) form.
    *   `Donation History Table`: `getTransactions` sorgusundan gelen geçmiş bağış işlemlerini (Tarih, Miktar, Durum, Sipariş No) listeleyen arama/sayfalama destekli tablo.

### 14. Stil Rehberi ve Elemanlar (Style Guide & Elements)
*   **URL**: `/elementler`
*   **WordPress Dosyası**: `page-elements.php`
*   **1. Layout**: `Full Width Layout`
*   **2. Template**: `Style Guide Template`
*   **3. Component**:
    *   Renk paletleri, tipografi hiyerarşisi, tüm buton çeşitleri, form input tasarımları, kart varyasyonları, akordeon ve tab bileşenleri.
*   **4. CRM Component**:
    *   Yok (Yalnızca görsel test amaçlı statik HTML).

### 15. Yasal Sayfalar (Legal / KVKK vb.)
*   **URL**: `/kvkk`, `/gizlilik-politikasi`, `/kullanici-sozlesmesi`, `/mesafeli-bagis-sozlesmesi`, `/iptal-ve-iade-kosullari`, `/cerez-politikasi`
*   **WordPress Dosyası**: `page.php`
*   **1. Layout**: `Default Layout`
*   **2. Template**: `Default Page Template`
*   **3. Component**:
    *   `Legal Content Block`: Sol tarafta diğer yasal sözleşmelere hızlı geçiş linkleri, sağ tarafta okunabilirliği yüksek zengin metin alanı içeren Gutenberg yerleşimi.
*   **4. CRM Component**:
    *   Yok.

### 16. 404 Hata Sayfası (Not Found)
*   **URL**: Hatalı / Tanımsız URL istekleri
*   **WordPress Dosyası**: `404.php`
*   **1. Layout**: `Default Layout`
*   **2. Template**: `404 Template`
*   **3. Component**:
    *   `404 Graphic`: Hata görseli veya animasyonu.
    *   `Home Redirect Button`: Anasayfaya yönlendiren buton bileşeni.
*   **4. CRM Component**:
    *   Yok.
*   **ACF Field Group**: `peta_404_fields` (Hata başlığı, alt metinler ve buton metni yönetimi).

---

## 4. Gutenberg Bileşenleri Mimari Detayı (Blocks Map)

Tema içerisinde `blocks/` dizininde kayıtlı olan ve editörde kullanılabilen ACF tabanlı Gutenberg bloklarının katman ve CRM ilişkileri:

| Blok Adı | Klasör / ID | Katman | ACF Alanları (Field Group) | CRM İlişkisi | Görevi / Açıklama |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **Hero Slider** | `blocks/hero` | Component | Slider Görsel/Video, Başlık, Alt Başlık, Buton Linkleri | `Quick Donation` (Opsiyonel) | Anasayfa ve iç sayfa karşılama alanları. |
| **Featured Donations** | `blocks/featured-donations` | Component | Seçilen Bağış Kategorileri, Blok Başlığı | `getCategoriesWithProducts` | Belirli bağış fonlarını kart halinde listeleme. |
| **Featured Projects** | `blocks/featured-projects` | Component / CRM | Seçilen Projeler (`peta_project` CPT), Başlık | `Project Progress` | Proje kartları ve ilerleme barlarının listelenmesi. |
| **Donation Appeal** | `blocks/donation-appeal` | CRM Component | Seçilebilir Alt Ürünler/Hisseler, CRM Kategori Kodu | `_esas/basket.php` | Proje/Faaliyet sidebar alanında hızlı sepete ekleme formu. |
| **Donation Process** | `blocks/donation-process` | Component | Adım Başlıkları, İkonlar, Açıklamalar (Repeater) | Yok | Dernek yardım dağıtım zincirini gösteren statik adımlar. |
| **FAQ Accordion** | `blocks/faq` | Component | Soru - Cevap Listesi (Repeater) | Yok | Akordeon yapısında sıkça sorulan sorular bloğu. |
| **Lightbox Gallery** | `blocks/gallery` | Component | Galeri Türü (Görsel/Video), Görsel Listesi, Video Linkleri | Yok | Lightbox destekli fotoğraf albümü ve video izleme alanı. |
| **Stats Grid** | `blocks/stats-grid` | Component | İstatistik Kartları, Rakamlar, İkonlar (Repeater) | Yok | Yardım rakamlarını gösteren dinamik/statik sayaçlar. |
| **Timeline History** | `blocks/timeline` | Component | Yıl, Olay Başlığı, Görsel, Olay Detayı (Repeater) | Yok | Dernek kilometre taşlarını gösteren dikey çizgi. |

---

## 5. Katmanlar Arası Geçiş ve Bağımlılık Matrisi (Dependency Matrix)

Aşağıdaki şema, bir kullanıcının sepet işlemlerinden ödeme onayına kadar olan süreçte katmanların nasıl çalıştığını ve birbiri içerisine nasıl yuvalandığını gösterir:

```
[Kullanıcı Arayüzü]
        │
        ▼
┌────────────────────────────────────────────────────────┐
│ 1. LAYOUT: Checkout Layout (layouts/checkout.php)      │
│   ├── Hides Header Navigation                          │
│   └── Hides Footer Widget area                         │
│                                                        │
│   ┌────────────────────────────────────────────────────┐
│   │ 2. TEMPLATE: Checkout Template (page-odeme.php)    │
│   │   ├── Loads WordPress Query & POS Configurations    │
│   │   │                                                │
│   │   ├── 3. COMPONENT: Security Badges & SSL          │
│   │   │                                                │
│   │   └── 4. CRM COMPONENT: Checkout Form & OTP Modal  │
│   │       ├── Fetches Basket from Redis                │
│   │       ├── Validates Form with Turnstile            │
│   │       ├── Fires payment-start.php to bank POS      │
│   │       └── Triggers OTP / 3D Verification Modal     │
│   └────────────────────────────────────────────────────┘
└────────────────────────────────────────────────────────┘
```

### Katman Kuralları (Architectural Rules)
1.  **Layouts** asla doğrudan veritabanı veya API sorgusu yapmaz. Sadece içerisine enjekte edilen `Template` kodunu `get_header()` ve `get_footer()` arasına yerleştirir.
2.  **Templates** sayfa şablonlarıdır ve sayfa durumuna göre uygun `Layout` seçimini yapar (örn: `get_template_part('resources/layouts/checkout')`).
3.  **Components (Blocks)** bağımsız ve taşınabilir olmalıdır. CSS/JS dosyaları sadece o blok çağrıldığında yüklenir (WordPress block assets enqueue).
4.  **CRM Components** veri alışverişi için asla doğrudan sayfa yenilemesine ihtiyaç duymaz. Tüm iletişim `_esas/` gateway veya WP AJAX/REST API üzerinden asenkron (Fetch API) yönetilir.

---

## 6. CRM Bileşeni ve API Eşleşme Tablosu (API Endpoints Map)

Aşağıdaki tablo, `CRM Component` katmanındaki bileşenlerin arka planda hangi GraphQL veya gateway servislerini tetiklediğini özetler:

| CRM Bileşeni (Component Name) | Tetiklenen Gateway / API | İstek Tipi | Görevi / Veri Akışı |
| :--- | :--- | :--- | :--- |
| **Donation Catalog Grid** | `getCategoriesWithProducts` | GraphQL Query | Aktif bağış kategorilerini ve ürün limitlerini çeker. |
| **Cart Drawer (Flyout)** | `_esas/basket.php?action=get` | JSON POST | Sepetteki ürün listesini ve sepet toplamını günceller. |
| **Cart Item Adder / Remover** | `_esas/basket.php?action=add / remove` | JSON POST | Sepete ürün ekler, adet günceller veya ürünü siler. |
| **Donor & Intent Form** | `_esas/basket.php?action=updateDonor / Card` | JSON POST | Bağışçı bilgilerini ve geçici kart verisini sepet session'ına yazar. |
| **Payment Verification Modal** | `/checkout/payment-start.php` | HTML Form | Turnstile sonrası 3D Secure banka sayfasına yönlendirir. |
| **OTP SMS Login Form** | `endUserSendOtp(phone)` | GraphQL Mutation | Girilen telefona SMS şifresi gönderilmesini tetikler. |
| **OTP Code Verification** | `endUserLogin(phone, otp)` | GraphQL Mutation | Kodu doğrular ve tarayıcıya `endUserToken` cookie yazar. |
| **User Profile Summary** | `endUserMe` & `getDonorSummary` | GraphQL Query | Giriş yapmış üyenin adını ve toplam bağış istatistiğini okur. |
| **Donation History List** | `getTransactions` | GraphQL Query | Üyenin geçmiş başarılı bağış ve makbuz listesini çeker. |
| **Dynamic Video Player Query** | `getProjeVideo(code)` (Özel Query) | GraphQL Query | Girilen koda göre video URL ve plaket verisini çizer. |
