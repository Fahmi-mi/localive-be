# PRD: Localive Backend — API & CMS untuk Website Desa Wisata

> **Version**: 1.1 — 5 Juli 2026
> **Status**: Final

---

## 1. Overview

Localive Backend adalah REST API berbasis Laravel yang menjadi *single source of truth* untuk website desa wisata Localive — mengelola konten bilingual (Indonesia/Inggris) seperti UMKM, artikel, paket wisata, mitra, potensi desa, dan informasi organisasi. Backend ini melayani dua konsumen: (1) frontend publik (TanStack Start) yang menampilkan konten ke pengunjung, dan (2) dashboard admin tempat pengelola desa membuat dan mengelola konten dua bahasa dengan alur kerja draft/publish. Tujuan utamanya: memberi admin desa (yang mungkin bukan penerjemah profesional) fleksibilitas mengerjakan konten bertahap tanpa risiko konten setengah jadi tampil ke publik.

---

## 2. Goals & Non-Goals

### Goals
- Menyediakan API translatable (ID/EN) yang konsisten untuk seluruh jenis konten, dengan kontrak response yang sama antara endpoint publik dan admin.
- Mendukung alur kerja **Draft → Publish** yang seragam di semua konten yang tampil ke publik dan dikelola berulang oleh admin — termasuk data singleton (profil desa, visi-misi).
- Optimasi penyimpanan gambar otomatis (resize, kompresi, konversi ke `.webp`) mengingat keterbatasan storage shared hosting (20GB).
- RBAC sederhana: Super Admin vs Admin, dengan pembeda hanya pada pengelolaan akun admin.
- Mencegah kehilangan data lewat soft delete di seluruh konten editorial.
- Struktur kategori yang konsisten (lookup table + slug + label multi-bahasa) untuk UMKM, paket wisata, dan artikel.

### Non-Goals
- **Tidak ada fitur pencarian (search)** — dikonfirmasi tidak dibutuhkan untuk versi ini.
- **Tidak ada approval/review layer** (`pending_review`) — Admin dan Super Admin sama-sama punya hak publish penuh.
- **Tidak ada sistem pemesanan/booking atau pembayaran** — di luar cakupan platform ini, murni informasi & promosi.
- **Tidak ada terjemahan otomatis (machine translation)** — admin mengisi manual kedua bahasa.
- **Tidak ada dukungan bahasa selain ID/EN** — struktur JSON translatable sengaja dibatasi ke dua key ini saja untuk saat ini.
- **Tidak ada real-time features** (notifikasi push, live chat, dsb).

---

## 3. Target Users

| Persona | Deskripsi |
|---|---|
| **Super Admin** | Pengelola utama desa wisata. Punya akses penuh ke semua CRUD konten **plus** kelola akun admin lain. |
| **Admin** | Staf desa/pengelola konten harian. Akses penuh ke CRUD konten (create, edit, publish, unpublish, hapus), tapi tidak bisa mengelola akun admin lain. |
| **Pengunjung Website (Publik)** | Wisatawan/masyarakat umum yang mengakses website lewat frontend TanStack, memilih bahasa ID/EN, melihat info UMKM/wisata/artikel/organisasi. Tidak berinteraksi langsung dengan backend — semua lewat frontend. |
| **Tim Frontend (Developer)** | Konsumen API ini. Butuh kontrak response yang konsisten dan terprediksi untuk integrasi TanStack Start + i18next. |

---

## 4. Core Features

### Must Have
- **Auth berbasis Sanctum** (cookie-based, stateful) dengan endpoint login/logout/forgot-password/change-password.
- **RBAC dua peran** (Super Admin, Admin) dengan middleware otorisasi di endpoint manajemen akun admin.
- **Field JSON translatable** (`{id, en}`) untuk seluruh konten teks, dengan fallback otomatis ke `id` kalau `en` kosong.
- **CRUD konten editorial**: UMKM, Artikel, Paket Wisata, Mitra, Potensi Desa, Track Record, WhatsApp Numbers, Pengurus Organisasi — semuanya dengan alur draft/publish.
- **Alur Draft/Publish seragam** (kolom `status`, endpoint aksi `/publish` & `/unpublish` terpisah dari edit biasa) — berlaku juga untuk data singleton (`profiles`, `village_info`).
- **Kategori terstandar** (lookup table + slug + `name` JSON) untuk UMKM, paket wisata, dan artikel.
- **Media pipeline otomatis**: resize max 1200px, convert ke `.webp`, kompresi 75–80%, max 2MB per file.
- **Soft delete** di semua tabel konten editorial dan singleton.
- **Slug otomatis** untuk konten yang punya halaman detail (`articles`, `tour_packages`, `umkm`).

### Should Have
- **`published_at`** terpisah dari `created_at` untuk sorting "konten terbaru" berdasarkan kapan benar-benar tayang.
- **Query scope otomatis** yang memfilter `status = published` di semua endpoint publik tanpa perlu parameter eksplisit dari frontend.
- **Endpoint restore** untuk data yang soft-deleted (belum diprioritaskan di MVP, tapi arsitektur soft delete sudah mendukung).

### Could Have
- Endpoint restore/trash management UI di dashboard admin (list data yang di-soft-delete, tombol pulihkan).

### Won't Have (untuk versi ini)
- Fitur pencarian/full-text search.
- Approval workflow multi-level.
- Multi-bahasa lebih dari ID/EN.
- Sistem notifikasi email otomatis ke admin (selain reset password).

---

## 5. User Flow

### 5.1 Alur Admin — Membuat & Mempublikasikan Konten Baru (contoh: Artikel)
1. Admin login → dapat sesi cookie via `/sanctum/csrf-cookie` + `/api/login`.
2. Admin buka dashboard, isi form artikel — minimal `title.id` dan `content.id` (Bahasa Indonesia). Field `en` boleh dikosongkan dulu.
3. Admin klik **"Simpan Draft"** → `POST /api/articles` (atau `PATCH` kalau melanjutkan draft yang sudah ada) → status tersimpan sebagai `draft`, `slug` auto-generate dari `title.id`. Artikel **tidak muncul** di endpoint publik.
4. Admin kembali beberapa saat kemudian, melengkapi `title.en` dan `content.en`, klik **"Simpan Draft"** lagi (masih `draft`).
5. Setelah yakin lengkap, admin klik **"Publish"** → `POST /api/articles/{id}/publish` → backend validasi `id` & `en` lengkap → kalau valid, `status = published`, `published_at` di-set. Artikel langsung muncul di endpoint publik.
6. Kalau ada revisi kecil setelah publish (perbaiki typo), admin `PATCH` langsung — perubahan **instant-live**, tidak perlu publish ulang.
7. Kalau admin ingin menyembunyikan sementara, klik **"Unpublish"** → `POST /api/articles/{id}/unpublish` → artikel hilang dari publik tanpa terhapus datanya.

### 5.2 Alur Admin — Mengedit Data Singleton (Profil/Visi-Misi)
Sama persis dengan alur di atas (5.1) — `profiles` dan `village_info` mengikuti mekanisme draft/publish yang identik, hanya bedanya cuma ada satu baris data per tabel (bukan banyak record).

### 5.3 Alur Publik — Mengakses Konten Website
1. Pengunjung membuka `localive.id`, frontend fetch data lewat `api.localive.id` (tanpa autentikasi).
2. Backend otomatis memfilter hanya konten `status = published`.
3. Response berisi object JSON penuh `{id, en}` untuk setiap field translatable.
4. Frontend memilih bahasa yang ditampilkan berdasarkan state `i18n.language` (toggle instan, tanpa refetch ke backend saat ganti bahasa).

### 5.4 Alur Upload Gambar
1. Admin upload gambar lewat form (UMKM, artikel, dsb).
2. Backend menjalankan pipeline: validasi ukuran (≤2MB) → resize (max width 1200px) → convert ke `.webp` → kompresi 75–80% → simpan ke disk `public`.
3. URL gambar hasil pipeline disimpan di kolom `image` pada record terkait.

---

## 6. System Architecture

### Architecture Overview
Arsitektur **monolith API terpisah dari frontend** (headless/decoupled): Laravel 13 sebagai backend API murni (tidak render HTML), TanStack Start sebagai frontend terpisah yang mengonsumsi API ini. Keduanya di-deploy di server yang sama (shared hosting cPanel) tapi lewat subdomain berbeda, dihubungkan lewat sesi cookie stateful (Sanctum) berkat konfigurasi `SESSION_DOMAIN` satu level domain (`.localive.id`).

Dipilih monolith (bukan microservices) karena skala proyek kecil (single village website, admin terbatas), constraint shared hosting, dan tim kecil — microservices akan menambah kompleksitas operasional tanpa manfaat nyata di skala ini.

### Architecture Diagram (ASCII)
```
[Pengunjung Browser] ---> [Frontend: TanStack Start @ localive.id]
                                     |
                                     | fetch (no auth, GET published-only)
                                     v
                          [Backend API: Laravel 13 @ api.localive.id]
                                     |
                    +----------------+-----------------+
                    |                |                 |
             [MySQL Database]  [Media Pipeline]   [Sanctum Session
              (JSON columns,     (resize/webp/      Cookie Store]
               status/slug)       compress)               ^
                                     |                     |
                                     v                     |
                           [Disk Storage: public]          |
                                                            |
[Admin Browser] --- login (cookie, CSRF) ------------------+
       |
       v
[Dashboard Admin @ localive.id/admin] --- PATCH/POST/publish/unpublish ---> [Backend API]
```

### Key Components
- **Laravel API (`api.localive.id`)**: mengelola seluruh logic bisnis — validasi, translatable JSON, status draft/publish, RBAC, media pipeline.
- **MySQL**: penyimpanan relasional, field translatable disimpan sebagai kolom `JSON`.
- **Media Pipeline (Intervention Image v3)**: layer terpusat yang memproses semua upload gambar sebelum disimpan ke disk.
- **Sanctum**: autentikasi berbasis cookie session (bukan token API), cocok untuk skenario frontend-backend satu domain utama dengan subdomain.
- **Frontend TanStack Start**: mengonsumsi API, menangani toggle bahasa di client-side (i18next), tidak menyimpan logic bisnis konten.

---

## 7. Tech Stack

| Layer | Technology | Reason |
|---|---|---|
| Frontend | TanStack Start + i18next | Sudah ditentukan tim frontend; instant client-side language toggle. |
| Backend | Laravel 13.x | Ekosistem matang untuk RBAC, validasi, Eloquent ORM, cocok untuk shared hosting cPanel. |
| Database | MySQL | Tersedia standar di shared hosting cPanel, mendukung kolom JSON untuk translatable fields. |
| Translatable Layer | `spatie/laravel-translatable` | Menangani casting JSON↔array per-locale dan fallback locale tanpa reinvent logic. |
| Media Processing | Intervention Image v3 | Resize, convert `.webp`, kompresi terintegrasi baik dengan Laravel. |
| Auth | Laravel Sanctum (cookie/stateful) | Frontend & backend satu domain utama (subdomain berbeda) — cocok pakai cookie session, bukan token Bearer. |
| Hosting / Infra | Shared Hosting cPanel (20GB) | Constraint yang sudah ditetapkan; memengaruhi keputusan image pipeline dan soft delete. |
| CI/CD | Manual Upload | Deployment dilakukan secara manual ke cPanel sesuai kebutuhan. |

---

## 8. Data Model

```
users
- id
- name
- email
- password
- role: enum('super_admin', 'admin')
- remember_token
- timestamps

article_categories / umkm_categories / tour_categories
- id
- slug: string (unique)
- name: JSON {id, en}
- timestamps

articles
- id
- slug: string (unique, auto-generate dari title.id)
- category_id: FK → article_categories
- user_id: FK → users (author)
- title: JSON {id, en}
- content: JSON {id, en}
- date
- image: string
- status: enum('draft', 'published') default 'draft'
- published_at: timestamp (nullable)
- timestamps (+ deleted_at)

umkm
- id
- slug: string (unique)
- title: JSON {id, en}
- description: JSON {id, en}
- category_id: FK → umkm_categories
- maps_link: string
- image: string
- status: enum('draft', 'published') default 'draft'
- published_at: timestamp (nullable)
- timestamps (+ deleted_at)

tour_packages
- id
- slug: string (unique)
- title: JSON {id, en}
- description: JSON {id, en}
- category_id: FK → tour_categories
- image: string
- status: enum('draft', 'published') default 'draft'
- published_at: timestamp (nullable)
- timestamps (+ deleted_at)

partners
- id
- logo: string
- name: JSON {id, en}
- description: JSON {id, en}
- status: enum('draft', 'published') default 'draft'
- published_at: timestamp (nullable)
- timestamps (+ deleted_at)

village_potentials
- id
- image: string
- title: JSON {id, en}
- description: JSON {id, en}
- status: enum('draft', 'published') default 'draft'
- published_at: timestamp (nullable)
- timestamps (+ deleted_at)

track_records
- id
- content: JSON {id, en}
- status: enum('draft', 'published') default 'draft'
- published_at: timestamp (nullable)
- timestamps (+ deleted_at)

whatsapp_numbers
- id
- number: string
- label: JSON {id, en}
- status: enum('draft', 'published') default 'draft'
- published_at: timestamp (nullable)
- timestamps (+ deleted_at)

organization_members
- id
- image: string
- name: JSON {id, en}
- status: enum('draft', 'published') default 'draft'
- published_at: timestamp (nullable)
- timestamps (+ deleted_at)

profiles (singleton)
- id
- business_name: JSON {id, en}
- owner: JSON {id, en}
- founded_date
- location: JSON {id, en}
- phone, email, ig_url, yt_url
- status: enum('draft', 'published') default 'draft'
- published_at: timestamp (nullable)
- timestamps (+ deleted_at)

village_info (singleton)
- id
- background: JSON {id, en}
- vision: JSON {id, en}
- mission: JSON {id, en}
- status: enum('draft', 'published') default 'draft'
- published_at: timestamp (nullable)
- timestamps (+ deleted_at)
```

---

## 9. API Design

> Semua field translatable selalu dikembalikan sebagai object JSON penuh `{id, en}` — tidak ada parameter `?lang=` untuk filtering. Endpoint publik otomatis hanya mengembalikan `status = published`. `PATCH` dipakai untuk update konten (bukan `PUT`), kecuali Admin Management. `DELETE` = soft delete. Data yang terhapus dapat dipulihkan via `POST /api/{resource}/{id}/restore`.

| Method | Endpoint | Deskripsi |
|---|---|---|
| POST | `/api/login` | Login admin/super admin |
| POST | `/api/logout` | Logout |
| POST | `/api/forgot-password` | Kirim link reset password |
| POST | `/api/change-password` | Ganti password (authenticated) |
| GET | `/api/admins` | List akun admin (Super Admin only) |
| POST | `/api/admins` | Buat akun admin (Super Admin only) |
| PUT | `/api/admins/{id}` | Update akun admin (Super Admin only) |
| DELETE | `/api/admins/{id}` | Hapus akun admin (Super Admin only) |
| GET/POST/PATCH/DELETE | `/api/umkm` | CRUD UMKM |
| POST | `/api/umkm/{id}/publish` \| `/unpublish` | Transisi status UMKM |
| GET/POST/PUT/DELETE | `/api/umkm-categories` | CRUD kategori UMKM |
| GET/POST/PATCH/DELETE | `/api/village-potentials` | CRUD Potensi Desa |
| POST | `/api/village-potentials/{id}/publish` \| `/unpublish` | Transisi status |
| GET/POST/PUT/DELETE | `/api/article-categories` | CRUD kategori artikel |
| GET/POST/PATCH/DELETE | `/api/articles` | CRUD Artikel (`user_id` otomatis dari auth user) |
| POST | `/api/articles/{id}/publish` \| `/unpublish` | Transisi status |
| GET/POST/PATCH/DELETE | `/api/tour-packages` | CRUD Paket Wisata (filter `?category=<slug>`) |
| POST | `/api/tour-packages/{id}/publish` \| `/unpublish` | Transisi status |
| GET/POST/PUT/DELETE | `/api/tour-categories` | CRUD kategori wisata |
| GET/POST/PATCH/DELETE | `/api/partners` | CRUD Mitra |
| POST | `/api/partners/{id}/publish` \| `/unpublish` | Transisi status |
| GET/POST/PATCH/DELETE | `/api/whatsapp-numbers` | CRUD Nomor WhatsApp |
| POST | `/api/whatsapp-numbers/{id}/publish` \| `/unpublish` | Transisi status |
| GET/POST/PATCH/DELETE | `/api/organization-members` | CRUD Pengurus Organisasi |
| POST | `/api/organization-members/{id}/publish` \| `/unpublish` | Transisi status |
| GET/POST/PATCH/DELETE | `/api/track-records` | CRUD Track Record |
| POST | `/api/track-records/{id}/publish` \| `/unpublish` | Transisi status |
| GET/PATCH | `/api/profile` | Lihat/edit Profil (singleton) |
| POST | `/api/profile/publish` \| `/unpublish` | Transisi status Profil |
| GET/PATCH | `/api/village-info` | Lihat/edit Visi-Misi-Latar Belakang (singleton) |
| POST | `/api/village-info/publish` \| `/unpublish` | Transisi status Village Info |

---

## 10. Non-Functional Requirements

- **Performance**: Traffic diperkirakan rendah-menengah (website desa wisata, bukan skala nasional). Media pipeline (resize + `.webp` + kompresi) krusial untuk menjaga waktu load halaman tetap cepat meski di shared hosting.
- **Storage**: Hard constraint 20GB total di shared hosting — semua upload gambar **wajib** lewat pipeline optimasi, tidak ada upload mentah yang diizinkan tersimpan permanen.
- **Security**:
  - Auth cookie `HttpOnly`, `SameSite=Lax`, `Secure`.
  - CSRF protection via Sanctum (`/sanctum/csrf-cookie` sebelum login).
  - RBAC di level middleware — endpoint admin management hanya bisa diakses Super Admin.
  - Data yang sudah pernah `published` (mungkin ter-index Google/dibagikan link) dilindungi soft delete, bukan hard delete.
- **Rate Limiting**: API dibatasi maksimal 100 request per menit per IP untuk mencegah abuse.
- **Scalability**: Desain saat ini cukup untuk single-tenant, satu desa. Tidak dirancang multi-tenant — kalau ada kebutuhan replikasi ke desa lain, perlu redesain terpisah (di luar cakupan PRD ini).
- **Availability**: Tidak ada SLA formal disebutkan (proyek desa, bukan skala enterprise) — target wajar untuk website informasi statis: uptime mengikuti standar shared hosting cPanel (~99%+), tanpa redundancy khusus.
- **Konsistensi Bilingual**: Setiap konten yang tampil publik wajib lengkap ID+EN sebelum bisa `published` — ditegakkan lewat validasi di endpoint `/publish`, bukan validasi generik di setiap edit (menjaga fleksibilitas kerja bertahap admin).

---

## 11. Milestones & Phases

| Phase | Scope | Catatan |
|---|---|---|
| **Phase 1** | Base Setup — Laravel 13, Sanctum config, migration awal (termasuk `umkm_categories`, `tour_categories`) | Fondasi proyek |
| **Phase 2** | Image Pipeline & Storage Optimization Service | Intervention Image v3, dijalankan sebelum modul konten karena dipakai semua modul |
| **Phase 3** | Auth System & RBAC (Super Admin vs Admin) | Termasuk middleware otorisasi |
| **Phase 4** | Trait `HasTranslations` + `SoftDeletes` + Base API Resource + Global Scope `published` | Layer reusable dipakai semua modul konten |
| **Phase 5** | CRUD modules (mulai UMKM & Articles) — endpoint kategori, endpoint aksi `/publish` & `/unpublish`, slug generator, `published_at` auto-set | Modul konten utama |
| **Phase 6** | Singleton Profile & Village Info — kolom `status`/`published_at` dan endpoint aksi, identik dengan tabel konten lain | |
| **Phase 7** | Testing (integrasi kontrak response dengan frontend, skenario draft tidak bocor ke publik) & Deployment cPanel | |

---
