# 🚀 WooCommerce Sahte Sipariş & Bot Kalkanı

[🇬🇧 English](README.md) · [🇹🇷 Türkçe](README.tr.md)

> Kapıda ödeme ve kredi kartı dolandırıcılıklarını, test kartı deneyen botları ve tek kullanımlık geçici e-postaları ödeme aşamasında engelleyen akıllı güvenlik kalkanı.

Geliştirici ve Bakım Sorumlusu: **[Harun Sekmen](https://github.com/harunsekmen)** — E-Ticaret Sistem Mühendisi & WooCommerce Uzmanı.

[✉️ İletişime Geç](mailto:sekmenwp@gmail.com) · [💼 Upwork Profili](https://www.upwork.com/freelancers/~01a7a8b58043e6e6d9) · [🔗 GitHub Ana Profil](https://github.com/harunsekmen)

---

## ⚡ Çözdüğü Kritik Sorun

Özellikle kapıda ödeme sunan veya yüksek hacimli mağazalarda:
- Sahte telefon ve teslim alınmayan siparişler kargo maliyetlerini şişirir.
- Çalıntı kart deneyen kart dolandırıcısı botlar ödeme ağ geçidinizin ceza almasına veya kapanmasına neden olur.

Bu eklenti, kullanıcı deneyimini bozmadan arka planda çalışan hafif sinyallerle botları ve sahte siparişleri filtreler.

---

## 🛠️ Öne Çıkan Özellikler

- **Tek Kullanımlık E-posta Engelleme:** Geçici e-posta servislerinden gelen siparişleri anında reddeder.
- **Honeypot & Hız Kontrolü:** İnsan gözüyle görünmeyen tuzak alanlarla otomatik botları sessizce eler.
- **Şüpheli IP ve Cihaz Tespiti:** Aynı IP üzerinden kısa sürede çok sayıda kart denemesi yapılmasını engeller.
- **Sıfır Yanlış Pozitif:** Gerçek müşterilerin alışveriş akışını zorlaştırmadan arka planda çalışır.

---

## 🏗️ Teknik Mimari ve Standartlar

`PHP 8.1+` • `WooCommerce HPOS` • `Disposable Email DB` • `Session Rate Limiter`

---

## 🚀 Kurulum ve Test

1. Klonlayın ve test edin:
   ```bash
   git clone https://github.com/harunsekmen/woo-fraud-fake-order-shield.git wp-content/plugins/woo-fraud-fake-order-shield
   ```
2. Testi çalıştırın:
   ```bash
   php wp-content/plugins/woo-fraud-fake-order-shield/tests/test-fraud.php
   ```

---

## 📄 Lisans

Bu proje **GPL-3.0 Lisansı** ile açık kaynak olarak sunulmaktadır.
