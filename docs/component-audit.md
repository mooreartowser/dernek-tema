# Component Usage Audit

Bu denetim raporu, WordPress framework teması içinde mevcut olan **bölgesel bileşen kütüphanesi (Component Library)** yerine el ile (hardcoded) HTML ve Tailwind CSS sınıfları kullanılarak yazılmış alanları listelemektedir. 

Mevcut bileşenlerin (`button.php`, `card.php`, `container.php`, `section.php`, `input.php`, `textarea.php`, `select.php`, `checkbox.php`, `badge.php`) yerine doğrudan HTML yazılmaması; projenin sürdürülebilirliği, ortak tasarım sisteminin korunması ve merkezi bakım kolaylığı için önem arz eder.

---

## 1. Section (Bölüm) Bileşeni Denetimi

**Hedef Component**: `resources/components/section.php`
**Amaç**: `<div class="py-section-*">` veya `<section class="py-section-*">` gibi manuel dikey bölüm dolgusu alanları yerine merkezi bölüm bileşeninin kullanılması.

| Dosya Yolu | Satır | Mevcut Kullanım | Kullanılması Gereken Component |
| :--- | :--- | :--- | :--- |
| `template-donation-catalog.php` | 36 | `<div id="primary" class="content-area flex-1 py-section-md">` | `section.php` |
| `single.php` | 23 | `<div id="primary" class="content-area flex-1 py-section-md">` | `section.php` |
| `single-project.php` | 29 | `<div id="primary" class="content-area flex-1 py-section-md">` | `section.php` |
| `single-activity.php` | 26 | `<div id="primary" class="content-area flex-1 py-section-md">` | `section.php` |
| `page.php` | 29 | `<div id="primary" class="content-area flex-1 py-section-md">` | `section.php` |
| `page-tesekkur.php` | 56 | `<div id="primary" class="content-area flex-1 py-section-md bg-background">` | `section.php` |
| `page-odeme.php` | 22 | `<div class="content-area flex-1 py-section-md">` | `section.php` |
| `page-odeme.php` | 51 | `<div class="content-area flex-1 py-section-lg bg-background">` | `section.php` |
| `page-odeme.php` | 79 | `<div id="primary" class="content-area flex-1 py-section-md bg-background">` | `section.php` |
| `index.php` | 15 | `<div id="primary" class="content-area flex-1 py-section-md">` | `section.php` |
| `archive.php` | 20 | `<div id="primary" class="content-area flex-1 py-section-md">` | `section.php` |
| `archive-project.php` | 20 | `<div id="primary" class="content-area flex-1 py-section-md">` | `section.php` |
| `archive-activity.php` | 20 | `<div id="primary" class="content-area flex-1 py-section-md">` | `section.php` |
| `404.php` | 21 | `<div id="primary" class="content-area flex-1 py-section-md">` | `section.php` |
| `resources/views/blocks/timeline/timeline.php` | 16 | `<section class="w-full py-section-md bg-background">` | `section.php` |
| `resources/views/blocks/stats-grid/stats-grid.php` | 16 | `<section class="w-full py-section-md bg-surface-alt">` | `section.php` |
| `resources/views/blocks/rich-image-content/rich-image-content.php` | 26 | `<section class="w-full py-section-md bg-background">` | `section.php` |
| `resources/views/blocks/gallery/gallery.php` | 17 | `<section class="w-full py-section-md bg-surface-alt">` | `section.php` |
| `resources/views/blocks/featured-projects/featured-projects.php` | 34 | `<section class="w-full py-section-md bg-background">` | `section.php` |
| `resources/views/blocks/featured-donations/featured-donations.php` | 23 | `<section class="w-full py-section-md bg-surface-alt">` | `section.php` |
| `resources/views/blocks/faq/faq.php` | 16 | `<section class="w-full py-section-md bg-background">` | `section.php` |
| `resources/views/blocks/donation-process/donation-process.php` | 16 | `<section class="w-full py-section-md bg-background">` | `section.php` |
| `resources/views/blocks/cta-section/cta-section.php` | 20 | `<section class="relative w-full py-section-lg overflow-hidden bg-primary-900 text-white">` | `section.php` |
| `resources/views/blocks/content-section/content-section.php` | 19 | `<section class="w-full py-section-md bg-background">` | `section.php` |
| `resources/views/blocks/hero/hero.php` | 40 | `<div class="relative w-full mx-auto px-container-px max-w-container-default z-10 py-section-md">` | `section.php` |

---

## 2. Container (Kapsayıcı) Bileşeni Denetimi

**Hedef Component**: `resources/components/container.php`
**Amaç**: `<div class="px-container-px max-w-container-default">` gibi manuel hizalama ve genişlik kısıtlama blokları yerine container bileşeninin çağrılması.

| Dosya Yolu | Satır | Mevcut Kullanım | Kullanılması Gereken Component |
| :--- | :--- | :--- | :--- |
| `template-donation-catalog.php` | 38 | `<div class="w-full mx-auto px-container-px max-w-container-default">` | `container.php` |
| `single.php` | 26 | `<div class="w-full mx-auto px-container-px max-w-container-default">` | `container.php` |
| `single-project.php` | 31 | `<div class="w-full mx-auto px-container-px max-w-container-default">` | `container.php` |
| `single-activity.php` | 28 | `<div class="w-full mx-auto px-container-px max-w-container-default">` | `container.php` |
| `page.php` | 32 | `<div class="w-full mx-auto px-container-px max-w-container-default">` | `container.php` |
| `page-tesekkur.php` | 58 | `<div class="w-full mx-auto px-container-px max-w-container-default">` | `container.php` |
| `page-odeme.php` | 23 | `<div class="w-full mx-auto px-container-px max-w-container-default">` | `container.php` |
| `page-odeme.php` | 52 | `<div class="w-full mx-auto px-container-px max-w-container-default flex flex-col items-center justify-center font-sans">` | `container.php` |
| `page-odeme.php` | 81 | `<div class="w-full mx-auto px-container-px max-w-container-default">` | `container.php` |
| `index.php` | 17 | `<div class="w-full mx-auto px-container-px max-w-container-default">` | `container.php` |
| `archive.php` | 22 | `<div class="w-full mx-auto px-container-px max-w-container-default">` | `container.php` |
| `archive-project.php` | 22 | `<div class="w-full mx-auto px-container-px max-w-container-default">` | `container.php` |
| `archive-activity.php` | 22 | `<div class="w-full mx-auto px-container-px max-w-container-default">` | `container.php` |
| `404.php` | 23 | `<div class="w-full mx-auto px-container-px max-w-container-default">` | `container.php` |
| `header.php` | 53 | `<div class="max-w-container-default mx-auto px-container-px flex justify-between items-center">` | `container.php` |
| `header.php` | 95 | `<div class="max-w-container-default mx-auto px-container-px flex justify-between items-center">` | `container.php` |
| `footer.php` | 33 | `<div class="max-w-container-default mx-auto px-container-px grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">` | `container.php` |
| `footer.php` | 161 | `<div class="border-t border-white/10 pt-8 max-w-container-default mx-auto px-container-px ...">` | `container.php` |
| `front-page.php` | 38 | `<div class="relative w-full h-full mx-auto px-container-px max-w-container-default z-20 flex items-center">` | `container.php` |
| `front-page.php` | 129 | `<div class="max-w-container-default mx-auto px-container-px">` | `container.php` |
| `resources/views/blocks/timeline/timeline.php` | 17 | `<div class="w-full mx-auto px-container-px max-w-container-default flex flex-col gap-component-lg">` | `container.php` |
| `resources/views/blocks/stats-grid/stats-grid.php` | 17 | `<div class="w-full mx-auto px-container-px max-w-container-default flex flex-col gap-component-lg">` | `container.php` |
| `resources/views/blocks/rich-image-content/rich-image-content.php` | 27 | `<div class="w-full mx-auto px-container-px max-w-container-default">` | `container.php` |
| `resources/views/blocks/gallery/gallery.php` | 18 | `<div class="w-full mx-auto px-container-px max-w-container-default flex flex-col gap-component-lg">` | `container.php` |
| `resources/views/blocks/featured-projects/featured-projects.php` | 35 | `<div class="w-full mx-auto px-container-px max-w-container-default flex flex-col gap-component-lg">` | `container.php` |
| `resources/views/blocks/featured-donations/featured-donations.php` | 24 | `<div class="w-full mx-auto px-container-px max-w-container-default flex flex-col gap-component-lg">` | `container.php` |
| `resources/views/blocks/faq/faq.php` | 17 | `<div class="w-full mx-auto px-container-px max-w-container-narrow flex flex-col gap-component-lg">` | `container.php` (width: narrow) |
| `resources/views/blocks/donation-process/donation-process.php` | 17 | `<div class="w-full mx-auto px-container-px max-w-container-default flex flex-col gap-component-lg">` | `container.php` |
| `resources/views/blocks/cta-section/cta-section.php` | 28 | `<div class="relative w-full mx-auto px-container-px max-w-container-default z-10">` | `container.php` |
| `resources/views/blocks/content-section/content-section.php` | 20 | `<div class="w-full mx-auto px-container-px max-w-container-default">` | `container.php` |
| `resources/views/blocks/content-section/content-section.php` | 59 | `<div class="max-w-container-narrow mx-auto flex flex-col gap-component-md">` | `container.php` (width: narrow) |
| `resources/views/blocks/hero/hero.php` | 40 | `<div class="relative w-full mx-auto px-container-px max-w-container-default z-10 py-section-md">` | `container.php` |
| `resources/components/page-hero.php` | 94 | `<div class="relative w-full mx-auto px-container-px max-w-container-default z-10 flex flex-col gap-4">` | `container.php` (nested component composition) |

---

## 3. Card (Kart) Bileşeni Denetimi

**Hedef Component**: `resources/components/card.php`
**Amaç**: `bg-white border border-border rounded-large shadow-sm` şablonuna sahip elle çizilmiş kart yüzeylerinin yerini kart bileşeninin alması.

| Dosya Yolu | Satır | Mevcut Kullanım | Kullanılması Gereken Component |
| :--- | :--- | :--- | :--- |
| `template-donation-catalog.php` | 67 | `<div class="text-center py-12 bg-white border border-border rounded-large shadow-sm p-8 max-w-lg mx-auto">` | `card.php` |
| `page-tesekkur.php` | 70 | `<div class="bg-white border border-border rounded-large shadow-sm p-6 md:p-8 flex flex-col gap-6">` | `card.php` |
| `page-tesekkur.php` | 166 | `<div class="bg-white border border-border rounded-large shadow-sm p-6 md:p-8 flex flex-col gap-6 text-center">` | `card.php` |
| `page-odeme.php` | 24 | `<div class="text-center py-16 bg-white border border-border rounded-large shadow-sm max-w-lg mx-auto p-8 font-sans">` | `card.php` |
| `page-odeme.php` | 85 | `<div class="text-center p-8 bg-white/10 rounded-large border border-white/20 backdrop-blur-md max-w-sm">` | `card.php` (transparent variant) |
| `page-odeme.php` | 111 | `<div class="bg-white border border-border border-t-4 border-t-primary rounded-large shadow-sm p-6 flex flex-col gap-4">` | `card.php` (border-t emphasis) |
| `page-odeme.php` | 148 | `<div class="bg-white border border-border border-t-4 border-t-primary rounded-large shadow-sm p-6 flex flex-col gap-6">` | `card.php` (border-t emphasis) |
| `page-odeme.php` | 232 | `<div class="bg-white border border-border border-t-4 border-t-primary rounded-large shadow-sm p-6 flex flex-col gap-4">` | `card.php` (border-t emphasis) |
| `page-odeme.php` | 277 | `<div class="bg-white border border-border border-t-4 border-t-primary rounded-large shadow-sm p-6 flex flex-col gap-4">` | `card.php` (border-t emphasis) |
| `page-odeme.php` | 337 | `<div class="bg-white rounded-large shadow-xl max-w-lg w-full overflow-hidden flex flex-col h-[500px]">` | `card.php` |
| `resources/components/crm/donation-card.php` | 34 | `<form class="... bg-white border border-border rounded-large shadow-sm hover:shadow-md transition-all ...">` | `card.php` |
| `resources/views/blocks/timeline/timeline.php` | 40 | `<div class="max-w-md p-component-md bg-surface border border-border rounded-large shadow-sm flex flex-col gap-component-xs w-full">` | `card.php` |
| `resources/views/blocks/timeline/timeline.php` | 66 | `<div class="max-w-md p-component-md bg-surface border border-border rounded-large shadow-sm flex flex-col gap-component-xs w-full">` | `card.php` |
| `single.php` | 54 | `<div class="bg-surface border border-border rounded-large p-6">` | `card.php` |
| `single-project.php` | 59 | `<div class="bg-white border border-border rounded-large p-6 shadow-sm flex flex-col gap-5">` | `card.php` |
| `single-project.php` | 96 | `<div class="bg-surface-alt border border-border rounded-large p-6 shadow-sm flex flex-col gap-4">` | `card.php` (alt background variant) |
| `single-activity.php` | 61 | `<div class="bg-white border border-border rounded-large p-6 shadow-sm flex flex-col gap-4">` | `card.php` |
| `single-activity.php` | 87 | `<div class="bg-surface-alt border border-border rounded-large p-6 shadow-sm flex flex-col gap-4">` | `card.php` (alt background variant) |
| `resources/views/blocks/stats-grid/stats-grid.php` | 37 | `<div class="p-component-md bg-surface rounded-large border border-border flex flex-col gap-component-sm text-center items-center shadow-sm hover:shadow-md transition-shadow duration-200">` | `card.php` |
| `resources/views/blocks/gallery/gallery.php` | 60 | `<a href="..." class="flex flex-col rounded-large border border-border bg-surface overflow-hidden group shadow-sm hover:shadow-md transition-shadow duration-200">` | `card.php` |
| `resources/views/blocks/faq/faq.php` | 30 | `<details class="group bg-surface rounded-large border border-border overflow-hidden transition-all duration-200 [\&_summary::-webkit-details-marker]:hidden shadow-sm">` | `card.php` |
| `resources/views/blocks/cta-section/cta-section.php` | 64 | `<div class="p-component-md bg-white/10 backdrop-blur-md rounded-large border border-white/15 flex flex-col gap-component-xs shadow-sm">` | `card.php` (transparent blur variant) |

---

## 4. Button (Buton) Bileşeni Denetimi

**Hedef Component**: `resources/components/button.php`
**Amaç**: Tailwind renk ve çerçeve sınıflarıyla el ile çizilen buton veya link elementleri yerine button bileşeninin (`url` veya `type` argümanıyla) enjekte edilmesi.

| Dosya Yolu | Satır | Mevcut Kullanım | Kullanılması Gereken Component |
| :--- | :--- | :--- | :--- |
| `page-odeme.php` | 309 | `<button type="button" id="submit-checkout-btn" class="w-full bg-primary hover:bg-primary-hover text-white text-base font-bold py-3.5 rounded-medium shadow-sm ...">` | `button.php` (variant: primary) |
| `header.php` | 137 | `<button id="header-logout-btn" class="w-full flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-danger ...">` | `button.php` (variant: text, class: text-danger) |
| `header.php` | 313 | `<button id="cart-drawer-clear" class="w-full border border-border hover:bg-danger/5 text-text-muted hover:text-danger ...">` | `button.php` (variant: outline) |
| `header.php` | 349 | `<button type="submit" class="w-full bg-primary hover:bg-primary-hover text-white text-sm font-bold py-3.5 rounded-medium shadow-sm ...">` | `button.php` (variant: primary) |
| `header.php` | 366 | `<button type="submit" class="w-full bg-primary hover:bg-primary-hover text-white text-sm font-bold py-3.5 rounded-medium shadow-sm ...">` | `button.php` (variant: primary) |
| `header.php` | 370 | `<button type="button" id="otp-back-btn" class="w-full border border-border hover:bg-surface-alt text-text-muted hover:text-secondary ...">` | `button.php` (variant: outline) |
| `resources/components/crm/donation-card.php` | 129 | `<button type="submit" class="w-full bg-primary hover:bg-primary-hover text-white text-sm font-bold py-3 rounded-medium ... focus:ring-primary">` | `button.php` (variant: primary) |

---

## 5. Badge (Etiket) Bileşeni Denetimi

**Hedef Component**: `resources/components/badge.php` veya `resources/components/crm/donation-badge.php`
**Amaç**: Manuel `rounded-pill` veya küçük metin etiketleri yerine merkezi kütüphanedeki `badge.php` veya `donation-badge.php` bileşenlerinin kullanılması.

| Dosya Yolu | Satır | Mevcut Kullanım | Kullanılması Gereken Component |
| :--- | :--- | :--- | :--- |
| `page-odeme.php` | 181 | `<span class="text-xs font-bold text-primary px-2.5 py-0.5 bg-primary/10 rounded-pill uppercase border border-primary/20">` | `donation-badge.php` veya `badge.php` (variant: primary) |
| `resources/views/blocks/hero/hero.php` | 44 | `<span class="inline-flex bg-accent text-white text-xs font-bold font-sans uppercase px-component-sm py-component-xs rounded-pill">` | `badge.php` (variant: secondary or custom class) |
| `header.php` | 152 | `<span id="cart-badge" class="...">` | `badge.php` (Özel bildirim / sepet sayısı balonu) |

---

## 6. Form Elementleri Bileşenleri Denetimi

**Hedef Componentler**: `input.php`, `textarea.php`, `select.php`, `checkbox.php`
**Amaç**: Form alanlarında manuel `<input>`, `<textarea>`, `<select>` veya `<input type="checkbox">` tanımlamak yerine merkezi kütüphane bileşenlerinin kullanılması.

| Dosya Yolu | Satır | Mevcut Kullanım | Kullanılması Gereken Component |
| :--- | :--- | :--- | :--- |
| `page-odeme.php` | 119 | `<input type="text" id="donor_name" required ...>` | `input.php` (type: text) |
| `page-odeme.php` | 123 | `<input type="tel" id="donor_phone" required ...>` | `input.php` (type: tel) |
| `page-odeme.php` | 128 | `<input type="email" id="donor_email" ...>` | `input.php` (type: email) |
| `page-odeme.php` | 132 | `<textarea id="donor_note" rows="2" ...>` | `textarea.php` |
| `page-odeme.php` | 156 | `<input type="checkbox" id="sync_donor_to_hisse" checked ...>` | `checkbox.php` |
| `page-odeme.php` | 190 | `<select class="intent-purpose-select ...">` | `select.php` |
| `page-odeme.php` | 210 | `<input type="text" required class="beneficiary-name-input ...">` | `input.php` |
| `page-odeme.php` | 216 | `<input type="tel" required class="beneficiary-phone-input ...">` | `input.php` |
| `page-odeme.php` | 286 | `<input type="text" id="card_holder" required ...>` | `input.php` |
| `page-odeme.php` | 291 | `<input type="text" id="card_number" required ...>` | `input.php` |
| `page-odeme.php` | 300 | `<input type="text" id="card_expiry" required ...>` | `input.php` |
| `page-odeme.php` | 304 | `<input type="text" id="card_cvv" required ...>` | `input.php` |
| `header.php` | 345 | `<input type="tel" id="login-phone" required ...>` | `input.php` (type: tel) |
| `header.php` | 359 | `<input type="text" id="login-otp" required ...>` | `input.php` |
| `404.php` | 34 | `<input type="search" class="flex-1 px-4 py-2 border ..." placeholder="Arama yapın...">` | `input.php` (type: search) |
| `resources/components/crm/donation-card.php` | 94 | `<select name="product_code" class="product-variant-select ...">` | `select.php` |
| `resources/components/crm/donation-card.php` | 108 | `<input type="<?php echo $is_variable ? 'number' : 'text'; ?>" ...>` | `input.php` (Özel satır içi tutar alanı - inline input) |
