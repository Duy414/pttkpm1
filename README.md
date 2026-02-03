# ⚡ WEBSITE HỆ THỐNG BÁN VÉ DU LỊCH

Dự án xây dựng hệ thống bán vé du lịch, phát triển bằng **Laravel**, **MySQL**, **Bootstrap**.

---

## 🗂️ CẤU TRÚC DỰ ÁN

```
project/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Middleware/
│   ├── Models/
│   └── Providers/
├── resources/
│   ├── views/         # Giao diện Blade
│   ├── css/
│   └── js/
├── routes/
│   └── web.php
├── public/
│   ├── images/
│   └── uploads/
└── database/
    └── migrations/
```

---

## ⚙️ CÀI ĐẶT VÀ CHẠY DỰ ÁN

### ✅ Bước 1: Clone dự án

```bash
git clone https://github.com/Duy414/pttkpm.git
cd pttkpm
```

### ✅ Bước 2: Cài đặt dependencies

```bash
composer install
npm install && npm run dev
```

### ✅ Bước 3: Cấu hình môi trường

```bash
cp .env.example .env
php artisan key:generate
```

Mở file `.env` và cấu hình thông tin kết nối MySQL:

```env
DB_DATABASE=k11
DB_USERNAME=root
DB_PASSWORD=
```

### ✅ Bước 4: Tạo cơ sở dữ liệu và seed dữ liệu mẫu

```bash
php artisan migrate --seed
```

### ✅ Bước 5: Chạy server

```bash
php artisan serve
```

> Truy cập tại: [http://localhost:8000](http://localhost:8000)

---

## 🖼️ GIAO DIỆN 

### Trang chủ
<p align="center">
  <img src="./public/images/home.png" alt="Trang chủ" width="600"/>
</p>

### Trang vé
<p align="center">
  <img src="./public/images/product.png" alt="Chi tiết vé" width="600"/>
</p>

### Trang quản trị
<p align="center">
  <img src="./public/images/admin.png" alt="Giao diện Admin" width="600"/>
</p>

---


## 👨‍💻 NHÓM PHÁT TRIỂN NHÓM 12

| Họ và tên | MSV|
|------------|----------|
| **Trần Văn Duy** | 23015552 |
---

## 📄 GIẤY PHÉP & MỤC ĐÍCH

Dự án được xây dựng phục vụ **môn học Phân tích và thiết kế phần mềm**,  
nhằm mục đích học tập và nghiên cứu,

---
---

## MÔ HÌNH 3 TIER
<p align="center">
  <img src="./public/images/tier.png" alt="3tier" width="700"/>
</p>
## 📬 LIÊN HỆ

- **Email:** 23015552@st.phenikaa-uni.edu.vn  
- **GitHub:** [github.com/Duy414](https://github.com/duy414)

<p align="center">
  💡 *Cảm ơn bạn đã quan tâm đến dự án!*
</p>
