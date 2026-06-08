# Dernek Framework - Design Token System v1 Reference Guide

Bu doküman, Dernek Framework bünyesinde kullanılan **Design Token System v1** standartlarını tanımlar. Token mimarisi Tailwind CSS v4'ün "CSS-first" konfigürasyon yapısına göre [tokens.css](file:///c:/laragon/www/dernekwp/wp-content/themes/dernek-tema/resources/css/tokens.css) dosyasında kurgulanmıştır.

---

## 1. Amaç ve Marka Dönüşümü (White-labeling)

Dernek Framework, çoklu dernek projelerinde tekrar kullanılabilir bir temel oluşturmayı hedefler. Yeni bir dernek/vakıf projesi geldiğinde, tasarımcılar ve yazılımcılar tema dosyalarını değiştirmek yerine yalnızca `resources/css/tokens.css` dosyasındaki CSS değişken değerlerini güncelleyerek saniyeler içinde yeni derneğin kurumsal kimliğini arayüze uygulayabilirler.

---

## 2. Token Grupları Kılavuzu

### 2.1 Colors (Marka & Durum Renkleri)
İletişim ve etkileşim öğelerinde kullanılan ana marka renk kodlarıdır.

| Token Adı | CSS Değişkeni | Tailwind Sınıfları | Kullanım Amacı / Örnek |
| :--- | :--- | :--- | :--- |
| **primary** | `--color-primary` | `bg-primary`, `text-primary` | Derneğin ana kimlik rengi. Birincil butonlar, aktif linkler, öne çıkan başlıklar. |
| **primary-hover** | `--color-primary-hover` | `hover:bg-primary-hover` | Birincil elemanların hover/odaklanma (active) durumları. |
| **secondary** | `--color-secondary` | `bg-secondary` | İkincil marka rengi. Başarı kutuları, ikincil eylemler, alternatif butonlar. |
| **secondary-hover**| `--color-secondary-hover`| `hover:bg-secondary-hover`| İkincil elemanların hover durumları. |
| **accent** | `--color-accent` | `bg-accent`, `text-accent` | Dikkat çekici eylemler (CTA). Özellikle "Bağış Yap" butonları ve acil yardım çağrıları. |
| **success** | `--color-success` | `bg-success`, `text-success` | Başarılı işlem uyarıları, tamamlanan bağış hedefleri ve onay durumları. |
| **warning** | `--color-warning` | `bg-warning`, `text-warning` | Beklemede olan işlemler, dikkat gerektiren uyarılar veya kritik bilgilendirmeler. |
| **danger** | `--color-danger` | `bg-danger`, `text-danger` | Başarısız ödeme hataları, sepetten çıkarma butonları, iptal/ret durumları. |

### 2.2 Neutral Colors (Zemin, Kenarlık & Metin)
Metin okunabilirliği ve arayüz derinliğini (katmanları) yöneten doğal tonlardır.

| Token Adı | CSS Değişkeni | Tailwind Sınıfları | Kullanım Amacı / Örnek |
| :--- | :--- | :--- | :--- |
| **background** | `--color-background` | `bg-background` | Tüm sayfanın ana arka plan (body) zemini. |
| **surface** | `--color-surface` | `bg-surface` | Kartlar, form panelleri ve modallerin arka plan zemini. |
| **surface-alt** | `--color-surface-alt` | `bg-surface-alt` | Header bar, grileşmiş alanlar, input kutularının iç zeminleri. |
| **border** | `--color-border` | `border-border` | Tablo çizgileri, kart kenarlıkları ve divider çizgileri. |
| **text** | `--color-text` | `text-text` | Tüm ana metinler, paragraflar ve kalın başlıklar. |
| **text-muted** | `--color-text-muted` | `text-text-muted` | Yardımcı alt metinler, tarihler, placeholder yazıları ve deaktif öğeler. |

### 2.3 Typography (Tipografi)
Sistem genelindeki yazı karakterleri ve ölçekli büyüklük kurallarıdır.

*   **font-sans** (`--font-sans`): Arayüzün ana okuma fontudur (`font-sans`). Varsayılan: `Inter`.
*   **font-heading** (`--font-heading`): Başlık etiketlerinde (`<h1>` - `<h6>`) kullanılan ve tasarıma karakter katan fonttur (`font-heading`). Varsayılan: `Outfit`.
*   **Size & Line Height Scale**: Metin boyutları (`text-xs` ile `text-5xl` arası) satır yükseklikleri ile orantılı olarak bind edilmiştir:
    *   `text-xs` (0.75rem / line-height: 1.25rem) - Dipnotlar, rozetler.
    *   `text-sm` (0.875rem / line-height: 1.5rem) - Yardımcı metinler, form etiketleri.
    *   `text-base` (1rem / line-height: 1.625rem) - Ana paragraf ve okuma metinleri.
    *   `text-lg` (1.125rem / line-height: 1.75rem) - Özet giriş metinleri, kart başlıkları.
    *   `text-xl` (1.25rem / line-height: 1.875rem) - Küçük bölüm başlıkları.
    *   `text-2xl` (1.5rem) ila `text-5xl` (3rem) - H3, H2, H1 ve Hero başlıkları.

### 2.4 Spacing (Yerleşim ve Boşluk Düzeni)
Mizanpajın nefes almasını ve bileşenlerin düzenli hizalanmasını sağlayan orantılı boşluk gruplarıdır.

| Token Adı | CSS Değişkeni | Tailwind Sınıfları | Kullanım Amacı / Örnek |
| :--- | :--- | :--- | :--- |
| **section-sm** | `--spacing-section-sm` | `py-section-sm`, `my-section-sm` | Küçük sayfa bölümleri arası dikey boşluklar (48px). |
| **section-md** | `--spacing-section-md` | `py-section-md`, `my-section-md` | Standart bloklar ve slider altı bölümler arası dikey boşluklar (80px). |
| **section-lg** | `--spacing-section-lg` | `py-section-lg`, `my-section-lg` | Geniş/ferah anasayfa bölümleri arası dikey boşluklar (128px). |
| **container-px**| `--spacing-container-px`| `px-container-px` | Sayfa dış çerçevesinin sağ-sol mobil kenar boşluğu (16px). |
| **container-py**| `--spacing-container-py`| `py-container-py` | Sayfa dış çerçevesinin dikey iç boşlukları (32px). |
| **component-xs**| `--spacing-component-xs`| `p-component-xs`, `gap-component-xs`| Buton içi ikon boşlukları, küçük badge dolguları (8px). |
| **component-sm**| `--spacing-component-sm`| `p-component-sm`, `gap-component-sm`| Form input içi padding değerleri, etiket araları (16px). |
| **component-md**| `--spacing-component-md`| `p-component-md`, `gap-component-md`| Standart kartların iç padding değerleri (24px). |
| **component-lg**| `--spacing-component-lg`| `p-component-lg`, `gap-component-lg`| Büyük bağış formlarının iç padding değerleri (32px). |

### 2.5 Radius (Köşe Yuvarlama)
Arayüze yumuşaklık ve modernlik katan köşe yuvarlama değerleridir.

*   **small** (`--radius-small` / `rounded-small`): 0.25rem (4px). Küçük checkbox kutuları, form inputları ve mini rozetler.
*   **medium** (`--radius-medium` / `rounded-medium`): 0.5rem (8px). Standart butonlar, bağış kartları ve görseller.
*   **large** (`--radius-large` / `rounded-large`): 1rem (16px). Modaller, ödeme form blokları ve slider sarmalayıcıları.
*   **pill** (`--radius-pill` / `rounded-pill`): 9999px. Arama çubukları ve dairesel badge/etiketler.

### 2.6 Shadows (Görsel Derinlik / Gölgeler)
Elemanların zemin üzerindeki yükseltisini (elevation) gösteren gölge kütüphanesidir.

*   **sm** (`--shadow-sm` / `shadow-sm`): Hafif derinlik. Form alanları ve deaktif butonlar.
*   **md** (`--shadow-md` / `shadow-md`): Standart kart gölgesi. Sayfa üzerindeki interaktif nesneler.
*   **lg** (`--shadow-lg` / `shadow-lg`): Belirgin derinlik. Hover durumundaki kartlar, sepet çekmecesi kenarları.
*   **xl** (`--shadow-xl` / `shadow-xl`): Maksimum derinlik. Global açılır modaller ve bildirim kutuları.

### 2.7 Container Widths (Sayfa Genişlik Limitleri)
Sayfaların maksimum genişlik sınırlarını belirleyen ve responsive mizanpajı koruyan tokenlardır.

| Token Adı | CSS Değişkeni | Tailwind Sınıfları | Kullanım Amacı / Örnek |
| :--- | :--- | :--- | :--- |
| **narrow** | `--container-narrow` | `max-w-container-narrow` | KVKK/Sözleşme gibi uzun okuma metinleri içeren şablonlar (768px). |
| **default** | `--container-default`| `max-w-container-default`| Standart içerik, grid ve sütun düzenleri (1280px). |
| **wide** | `--container-wide` | `max-w-container-wide` | Geniş mega menü alanları veya genişletilmiş görsel galeriler (1536px). |
| **full** | `--container-full` | `max-w-container-full` | Ekranı kaplayan sliderlar veya tam ekran yerleşimler (100%). |

---

## 3. Yeni Dernek Kurulumu İçin Token Değişimi Örneği

Yeni bir dernek projesinde renkleri değiştirmek için sadece `resources/css/tokens.css` dosyasındaki `@theme` bloğunun üzerine yeni oklch/hex/rgb değerleri yazılır:

```css
/* Yeni Dernek Kurumsal Kimliği İçin Swapping Örneği */
@theme {
  /* Kırmızı Temalı Bir Vakıf İçin Renk Değişimi */
  --color-primary: oklch(0.52 0.20 25);           /* Vakıf Kırmızısı */
  --color-primary-hover: oklch(0.44 0.18 25);     /* Koyu Kırmızı */
  --color-secondary: oklch(0.72 0.13 85);         /* Yardımcı Altın Sarısı */
  --color-secondary-hover: oklch(0.64 0.12 85);
  --color-accent: oklch(0.55 0.18 200);           /* Aksiyon Butonları İçin Mavi */

  /* Tipografi Değişimi */
  --font-sans: "Roboto", sans-serif;
  --font-heading: "Playfair Display", serif;
}
```

Bu değişiklik yapıldığında, derleme sonrasında tüm butonlar, metinler ve başlıklar yeni vakfın renk ve yazı fontlarına otomatik olarak bürünecektir.
