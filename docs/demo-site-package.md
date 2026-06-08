# Dernek Tema - Demo Site Package v1

Bu kılavuz, dernek teması etkinleştirildiğinde veya yönetim paneli ilk kez yüklendiğinde otomatik olarak çalışan ve yayına hazır (production-ready) bir örnek dernek sitesi oluşturan **Demo Site Package** sisteminin veri setini ve mimarisini açıklar.

---

## 1. Demo Medya Paketi

Dış kaynaklı Unsplash veya harici görsel bağlantıları yerine, tema klasörünün altında internet bağlantısı gerektirmeyen, bağımsız ve yerel bir medya kütüphanesi kurulmuştur:
- **Konum**: [assets/demo/](file:///c:/laragon/www/dernekwp/wp-content/themes/dernek-tema/assets/demo/)
- **Görseller (23 Adet)**:
  - **Sistem Logoları**: `logo.png` (açık renk zemin) & `logo_dark.png` (koyu zemin).
  - **Kahraman Slaytları (3 Adet)**: `hero_1.png` (Su Kuyusu), `hero_2.png` (Eğitim), `hero_3.png` (Acil Gıda).
  - **Proje Kapakları (4 Adet)**: `project_1.png` (Su Kuyusu), `project_2.png` (Yetim), `project_3.png` (Acil), `project_4.png` (Eğitim).
  - **Faaliyet Kapakları (4 Adet)**: `activity_1.png` (Uganda), `activity_2.png` (Gazze), `activity_3.png` (Kurban), `activity_4.png` (Yetim Şenliği).
  - **Sahadan Galeri Resimleri (6 Adet)**: `gallery_1.png` (Katarakt), `gallery_2.png` (Sondaj), `gallery_3.png` (Okul Çantası), `gallery_4.png` (Kışlık Battaniye), `gallery_5.png` (Güneş Enerjisi), `gallery_6.png` (Tarım Serası).
  - **Eski Görseller**: `demo_waterwell.jpg`, `demo_orphan.jpg`, `demo_relief.jpg`, `demo_education.jpg` (Geriye uyumluluk adına korunmuştur).

---

## 2. Programmatik Sideloading & Menü/Seçenek Eşleme

Seeder scripti çalıştırıldığında:
- Her yerel görsel, mükerrer yüklemeleri önleyecek şekilde başlık sorgusuyla kontrol edilir ve yoksa WordPress Ortam Kütüphanesi'ne (Media Library) otomatik yüklenir.
- **Seçenek Eşlemeleri**:
  - `site_logo`, `site_logo_dark` ve `footer_logo` alanları yüklenen logolara bağlanır.
  - `default_page_hero` ve `default_project_hero` alanları `hero_1.png` görseline, `default_activity_hero` `hero_3.png` görseline, `default_404_hero` ise `hero_2.png` görseline bağlanır.
  - `home_slides` repeater alanı, 3 farklı görsel ve başlığı barındıracak şekilde Slider için doldurulur.
  - `social_links` platform (Facebook, Instagram, X, YouTube, LinkedIn) linkleri ve genel iletişim telefon/adres bilgileri doldurulur.
  - `featured_donations_fallback` manual bağış fonu seçenekleri pre-populate edilir.

---

## 3. Sayfa Yapıları ve Gutenberg Blok Entegrasyonu

### A. Anasayfa (`anasayfa`)
Aşağıdaki Gutenberg ACF blok yorum yapılarıyla doldurulur:
1. `acf/peta-stats-grid` (Dernek istatistikleri)
2. `acf/peta-rich-image-content` (Kurumsal biz kimiz tanıtımı)
3. `acf/peta-featured-projects` (Proje listeleme ızgarası)
4. `acf/peta-featured-donations` (CRM entegreli donasyon kategorileri)
5. `acf/peta-gallery` (6 adet sahadan görsel içeren lightbox galeri)
6. `acf/peta-faq` (Soru-cevap akordeon)
7. `acf/peta-cta-section` (Büyük bağışa çağrı modülü)

### B. Hakkımızda (`hakkimizda`)
1. `acf/peta-content-section` (Hakkımızda kurumsal metin)
2. `acf/peta-timeline` (Yıllara göre derneğin kilometre taşları ve görselleri)
3. `acf/peta-stats-grid` (İstatistik kutuları)
4. `acf/peta-cta-section` (Yetim hamilik çağrısı)

### C. Projeler (`projeler`)
1. `acf/peta-content-section` (Giriş başlığı ve resmi)
2. `acf/peta-featured-projects` (Aktif projelerin listelenmesi)

### D. Faaliyetler (`faaliyetler`)
1. `acf/peta-content-section` (Sahada yürüttüğümüz çalışmaların tanıtım metni)

### E. İletişim (`iletisim`)
1. `acf/peta-content-section` (İletişim karşılama metni ve görseli)
2. **Gutenberg 2-Kolon Yerleşimi**:
   - Sol kolon: Remix Icon simgeli, kurumsal adres, e-posta, telefon ve WhatsApp link listesi.
   - Sağ kolon: Fatih/İstanbul konumunu gösteren, responsive, kenarları yuvarlatılmış Google Haritalar iframe yer tutucusu.

### F. Sıkça Sorulan Sorular (`sss`)
1. `acf/peta-faq` bloğu içerisinde zekat, sadaka, yetim sponsorluk, kredi kartı güvenliği, kurban kesim raporlaması ve su kuyusu açılış süreçlerine dair **tam 10 adet** detaylı soru-cevap yer alır.

---

## 4. Özel Yazı Türleri (Custom Post Types)

### A. Projeler (CPT `project` - 4 Adet)
- **Su Kuyusu Projesi** (Hedef: 150.000 TL, Toplanan: 90.000 TL)
- **Yetim Destek Programı** (Hedef: 60.000 TL, Toplanan: 40.000 TL)
- **Acil Yardım Fonu** (Hedef: 200.000 TL, Toplanan: 110.000 TL)
- **Eğitim Destek Programı** (Hedef: 300.000 TL, Toplanan: 150.000 TL)

*Her projenin kendi öne çıkarılan görseli (featured image) ve içerisinde 3 görselden oluşan sahadan fotoğraf galerisi (`acf/peta-gallery`) yer almaktadır.*

### B. Faaliyetler (CPT `activity` - 4 Adet)
- **Uganda Saha Ziyareti ve Yardım Dağıtımı** (Uganda ziyareti ve kuyu ihtiyaç tespiti)
- **Gazze Acil Yardım Operasyonu Tamamlandı** (Hijyen paketi ve sıcak yemek dağıtımı)
- **Uluslararası Kurban Organizasyonu Tamamlandı** (Kurban kesim videoları ve dağıtımı)
- **İstanbul’da Geleneksel Yetim Buluşması Şenliği** (Hediyeleşme ve çocuk oyunları etkinliği)

*Her faaliyetin kendi öne çıkarılan görseli ve içerisinde 2-3 görselden oluşan faaliyet albümü galerisi (`acf/peta-gallery`) yer almaktadır.*

---

## 5. CRM Çevrimdışı Güvenlik Önlemi (CRM Fallback)

featured-donations bloğunda CRM donasyon kataloğuna ulaşılamazsa, `DonationProvider` otomatik olarak `Featured Donations Fallback` seçeneğinden (ACF Option tablosuna seeder ile girilen 3 adet donasyon kartı: Yetim Sponsorluğu, Hisseli Su Kuyusu, Acil Gıda Paketi) kartları çekerek sitenin boş görünmesini veya hata vermesini engeller.
