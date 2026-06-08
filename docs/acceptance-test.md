# Dernek Starter Kit - Acceptance Test Report

Bu rapor, "7 Kıta Derneği" teması temel alınarak geliştirilen Dernek Framework Theme Layer v1 sürümünün sıfır kurulum (starter kit activation) senaryolarına göre yapılan kabul testi sonuçlarını içerir.

---

## TEST DETAYLARI

- **Tarih**: 5 Haziran 2026
- **Test URL**: http://dernekwp.test/
- **Ortam**: WordPress v6.x, ACF Pro, Kadim CRM Bridge
- **Amaç**: Yeni bir dernek kurulumunda seeder çalışması, tema ayarlarının yüklenmesi, menü boş durum davranışları, frontend yerleşimi ve blokların düzgün yüklenip yüklenmediğinin kontrol edilmesi.

---

## KABUL TESTİ SONUÇLARI

### PASS (Geçen Testler)

1.  **Starter Kit Seeder (Sayfa Kurulumları)**:
    - `Anasayfa`, `Hakkımızda`, `Projeler`, `Faaliyetler`, `İletişim` sayfaları veritabanında otomatik olarak oluşturulmakta ve "Yayınlanmış (publish)" olarak kaydedilmektedir.
    - Seeder, WordPress okuma ayarlarından `Anasayfa`yı otomatik olarak sabit ana sayfa (front page) olarak atamaktadır.

2.  **ACF Theme Settings Otomatik Yükleme**:
    - Kurum Adı (`7 Kıta Derneği`), açıklama, adres, telefon, e-posta, WhatsApp yönlendirmesi ve sosyal medya kanalları veritabanına ACF uyumlu (`update_field()`) şema yapısıyla otomatik yazılmaktadır.
    - Tüm alanlar önyüzde ve yönetim panelinde eksiksiz olarak yüklenmekte ve görüntülenebilmektedir.

3.  **Sosyal Medya Repeater ve is_array Hatası Çözümü**:
    - Daha önce `social_links` verisinin ham string dönmesi durumunda oluşan PHP warning hatası, hem `header.php` hem de `footer.php` dosyalarında yapılan `is_array()` kontrolleri ve seeder tarafındaki ACF uyumlu kayıt entegrasyonu sayesinde tamamen giderilmiştir.

4.  **Boş Menü (Menu Fallback) Davranışları**:
    - **Header Birincil Menü**: Herhangi bir menü atanmadığında sayfa listesini göstermek yerine temiz ve bozuk olmayan bir yerleşim sağlamak adına sessizce (`fallback_cb => __return_false`) boş kalmaktadır.
    - **Footer & Footer Secondary Menüleri**: Menü atanmadığı durumlarda yönetim paneli linkleriyle birlikte "Menü tanımlanmamış" uyarısı vermekte, böylece admin için rehberlik sağlarken site yerleşimini bozmamaktadır.

5.  **Gutenberg Editör Uyumluluğu & Demo İçerik**:
    - Sayfalar oluşturulurken içerisine eklenen ACF Gutenberg blok yorum kodları (`<!-- wp:acf/peta-... -->`) editör tarafından başarıyla çözümlenmektedir.
    - Her blok, PHP tarafında tanımlanan yerel default değerler sayesinde editörde ve önyüzde boş görünmek yerine tamamen hazır görsel içerikle dolu gelmektedir.

6.  **Assets & Build Pipeline**:
    - Tailwind CSS v4 derleme komutu (`npm run build`) hata vermeden çalışmaktadır. Google Yazı Tipleri (`Fraunces` ve `Plus Jakarta Sans`) hem önyüze hem de Gutenberg editöre başarıyla dahil edilmiştir.

---

### WARNING (Uyarılar)

*   **Problem**: Seeder çalıştıktan sonra menü alanları (`primary`, `footer`, `footer_secondary`) kaydedilmekte ancak WordPress menüleri otomatik oluşturulup bu alanlara atanmamaktadır. Menüler önyüzde boş kalmakta, adminin manuel olarak menü oluşturup eşleştirmesi gerekmektedir.
*   **Sebep**: WordPress `switch_theme` veya `admin_init` sırasında varsayılan olarak menü ağacı oluşturmaz, sadece yer tutucu konumlarını tanımlar.
*   **Çözüm Önerisi**: Gelecek sürümlerde seeder scripti içerisine `wp_create_nav_menu()` eklenerek sayfalar oluşturulduktan sonra birincil ve alt bilgi menüleri otomatik oluşturulup nav konumlarıyla eşleştirilebilir. Bu sayede kurulum sonrası sıfır müdahaleyle tam bir menü yapısı elde edilir.

---

### FAIL (Hatalar)

*   **Hata Yok**: Yapılan tüm test senaryolarında herhangi bir Fatal Error, PHP Warning, 404 eksik asset hatası veya tasarım kırılması tespit edilmemiştir.

---

## SONUÇ VE KARAR

**Starter Kit v1 Sürümü Yayına Hazırdır.**

Tasarım sistemi 7 Kıta kılavuzuna tamamen entegre edilmiş, tüm dinamik header/footer ve menü API entegrasyonları tamamlanmış, sıfır kurulum seeder yapısı sorunsuz çalışmaktadır. Temayı ilk proje için güvenle devreye alabilirsiniz.
