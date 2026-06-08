# Dernek Tema - CRM Adapter Sprint v1

Bu kılavuz, **Featured Donations** (Öne Çıkan Bağışlar) Gutenberg bloğunun veri akışını **Kadim CRM** kataloğu ile dinamik olarak bağlayan **CRMDonationAdapter** entegrasyon yapısını açıklar.

---

## 1. Veri Akışı Karşılaştırması

### A. Mevcut Akış (Static / Manual)
```text
Featured Donations Block -> DonationProvider::getItems('manual') -> ACF Block Repeater Fields
```
Editörler kartları (başlık, görsel, açıklama, link) Gutenberg yazı düzenleyicisi içinde tek tek manuel girmek zorundaydı.

### B. Yeni Akış (Dynamic / CRM)
```text
Featured Donations Block 
  ↓
DonationProvider::getItems('crm', $args)
  ↓
CRMDonationAdapter::getFeaturedDonations($selected_codes)
  ↓
kadim-crm-bridge (CatalogBrowser SDK)
  ↓
_esas (GraphQL Gateway)
```

---

## 2. Gutenberg Editör Değişiklikleri

Bloğun alanları [register.php](file:///c:/laragon/www/dernekwp/wp-content/themes/dernek-tema/resources/views/blocks/featured-donations/register.php) dosyasında güncellenmiştir:

1. **`source_type` (Veri Kaynağı)**: Manuel veya CRM seçim alanı.
2. **`crm_categories` (CRM Kategorileri)**: AJAX autocomplete destekli, çoklu seçim (multiple select) alanı. Sadece `source_type == 'crm'` olduğunda gösterilir.
3. **`cards` (Manuel Kartlar)**: ACF repeater alanı. Sadece `source_type == 'manual'` olduğunda gösterilir.

---

## 3. Canlı CRM Arama & AJAX Altyapısı

Editör panelinde CRM kategorilerinin aranabilmesi için, WordPress AJAX kancaları tema tarafında tescil edilmiştir:

- **`acf/fields/select/query/key=field_feat_don_crm_categories`**:
  Yazı düzenleyicide arama yapıldığında tetiklenir ve `CatalogBrowser::search_categories()` üzerinden arama terimine uyan CRM kategorilerini döndürür. Kategorinin benzersiz **kodu** (örn: `KURBAN`, `YETIM`) değer olarak veritabanına kaydedilir.
- **`acf/prepare_field/key=field_feat_don_crm_categories`**:
  Sayfa yüklendiğinde, veritabanında kayıtlı olan kategori kodlarının etiketlerini (örn: "Kurban Bağışları") `CatalogBrowser::get_category_labels()` üzerinden çözerek seçili alanları doldurur.

---

## 4. CRMDonationAdapter Sınıfı

[CRMDonationAdapter.php](file:///c:/laragon/www/dernekwp/wp-content/themes/dernek-tema/app/providers/CRMDonationAdapter.php) sınıfı, seçilen kategori kodlarını alır ve aşağıdaki adımları çalıştırır:

1. `\kadim_crm_bridge()->catalog_browser()->get_catalog_tree()` üzerinden tüm CRM ağacını çeker.
2. Seçilen her bir kodu `findCategoryNode()` metodu ile ağaçta recursive (özyinelemeli) olarak arar.
3. Bulunan CRM kategori düğümünü `normalizeCategory()` ile temadaki ortak kart şemasına dönüştürür.
4. Kategorideki ilk ürünün fiyatını otomatik olarak algılar ve bağış butonuna (`/online-bagis?requested_category=KOD`) parametreleri iliştirir.

---

## 5. UI & Şablon Uyumluluğu

`DonationProvider::normalize()` metodu, hem eski manuel repeater yapısıyla (`url`, `image`) hem de yeni provider standartlarıyla (`donation_url`, `image_url`) tam uyumlu çalışabilmesi için **çift yönlü anahtar eşlemesi** yapmaktadır:

```php
return [
    'id'           => $id,
    'code'         => $code,
    'title'        => $title,
    'description'  => $description,
    'image'        => $image_url,
    'image_url'    => $image_url,
    'url'          => $donation_url,
    'donation_url' => $donation_url,
];
```

Bu sayede, `featured-donations.php` şablon dosyasında tek bir satır HTML veya Tailwind CSS sınıfı değiştirilmeden veri kaynağı tamamen dinamikleştirilmiştir. CRM veya sunucu bağlantısı kesilirse sistem otomatik olarak manuel şablonlara güvenli geçiş (fallback) yapar.
