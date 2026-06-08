# Dernek Tema - CRM UI Foundation

Bu kılavuz, dernek teması içinde CRM verisi tüketen veya bağış işlemleriyle ilişkili olan tüm ekranlarda ortak bir görsel dil oluşturmak amacıyla geliştirilen **CRM UI Foundation** bileşen kütüphanesini açıklar.

---

## 1. Bileşenler ve Konumları

Tüm bileşenler [resources/components/crm/](file:///c:/laragon/www/dernekwp/wp-content/themes/dernek-tema/resources/components/crm/) dizini altında toplanmıştır:

| Bileşen Dosyası | İşlevi | Girdi Parametreleri (`$args`) |
| :--- | :--- | :--- |
| **`donation-badge.php`** | Kategori veya statü etiket pillerini çizer. | `text` (String), `variant` (primary, secondary, success, vb.) |
| **`donation-price.php`** | Sabit veya serbest bağış fiyat etiketlerini çizer. | `price` (Float/Null), `currency` (String) |
| **`donation-progress.php`** | Kampanyalı fonlar için toplanan/hedef ilerleme çubuğunu çizer. | `collected_amount`, `target_amount`, `percentage` |
| **`donation-quantity-selector.php`** | Adet, kurban hissesi veya yetim sayısı arttırma seçicisi. | `name` (String), `value` (Int), `min` (Int), `step` (Int) |
| **`donation-card.php`** | Yukarıdaki tüm bileşenleri sarmalayan ana kart yapısı. | `title`, `description`, `image_url`, `badge_text`, `price`, vb. |

---

## 2. Bileşen Detayları ve Kullanım Kılavuzları

---

### A. Donation Badge (`donation-badge.php`)
Bağış fonlarının statülerini (örn: "Zekat Uyumlu", "Hisse Seçimli", "Kritik Kampanya") belirtmek için kullanılan hap tasarımlı etiketlerdir.

```php
get_template_part( 'resources/components/crm/donation-badge', null, [
    'text'    => 'Zekat Geçerli',
    'variant' => 'success'
] );
```

---

### B. Donation Price (`donation-price.php`)
Sabit fiyatlı paketlerde tutarı ve para birimini (örn: "500 TL") kalın bir fontla gösterir. Fiyat belirtilmemişse, otomatik olarak serbest miktarlı bir bağış olduğunu belirten bir rozet çizer.

```php
get_template_part( 'resources/components/crm/donation-price', null, [
    'price'    => 35000,
    'currency' => 'TL'
] );
```

---

### C. Donation Progress (`donation-progress.php`)
Su kuyusu fonları veya acil barınma projeleri gibi hedefi olan kampanyalarda, toplanan miktarı, hedeflenen miktarı ve tamamlanma yüzdesini gösteren ilerleme çubuğudur.

```php
get_template_part( 'resources/components/crm/donation-progress', null, [
    'collected_amount' => 75000,
    'target_amount'    => 100000,
    'percentage'       => 75
] );
```

---

### D. Donation Quantity Selector (`donation-quantity-selector.php`)
Adet bazlı bağışlarda (kurban hissesi veya yetim sponsorluğu gibi) artı/eksi butonlarıyla çalışan etkileşimli sayı seçicidir. İçinde barındırdığı JavaScript sayesinde sepet güncellemelerini anında tetikler.

```php
get_template_part( 'resources/components/crm/donation-quantity-selector', null, [
    'name'  => 'yetim_adeti',
    'value' => 1,
    'min'   => 1,
    'step'  => 1
] );
```

---

### E. Donation Card (`donation-card.php`)
Kapak resmi, kategori rozeti, başlık, açıklama, ilerleme barı, fiyat ve adet seçicileri bir araya getiren kompozit (composite) kart yapısıdır. 

```php
get_template_part( 'resources/components/crm/donation-card', null, [
    'title'          => 'Afrika Su Kuyusu Projesi',
    'description'    => 'Afrika\'da susuzlukla mücadele eden köylere temiz içme suyu ulaştırıyoruz.',
    'image_url'      => 'https://images.unsplash.com/photo-1541812903702-82887e37cb62?q=80&w=600',
    'badge_text'     => 'Kalıcı Eser',
    'price'          => 35000,
    'donation_url'   => '/online-bagis?requested_category=SU_KUYUSU',
    'allow_quantity' => false
] );
```

---

## 3. Gelecekteki Entegrasyon Kılavuzu

Aynı UI bileşenlerinin gelecekteki ekranlarda nasıl kullanılacağına dair kurallar aşağıda belirlenmiştir:

1. **Donation Catalog (Bağış Kataloğu)**:
   Katalog listeleme ekranında tüm kategoriler yan yana dizilirken `donation-card.php` bileşeni kullanılacaktır.
2. **Cart (Alışveriş Sepeti & Sepet Çekmecesi)**:
   Sepet listesinde her bir sepet satırı için adet güncellemesi yapılırken `donation-quantity-selector.php` bileşeni kullanılacaktır. Birim fiyatlar ise `donation-price.php` ile gösterilecektir.
3. **Checkout (Ödeme Sayfası)**:
   Ödeme sayfasında, kullanıcının sepetindeki toplam bağış özeti listelenirken `donation-price.php` ve `donation-badge.php` standartları korunacaktır.
