# Linux From Scratch tiếng Việt

Bản dịch cộng đồng của [Linux From Scratch](https://www.linuxfromscratch.org/lfs/) 12.4 (System V), kèm "trick lỏ" — mẹo thực chiến khi làm LFS. Trang web: https://linuxfromscratch.wrenevil.tech

## Cấu trúc

| Đường dẫn | Nội dung |
|---|---|
| `upstream/12.4/` | HTML gốc của sách (không sửa tay) |
| `i18n/source/` | Câu gốc tiếng Anh, sinh bởi `bin/extract.php` |
| `i18n/vi/` | Bản dịch: mỗi trang một JSON `{ "English": "Tiếng Việt" }` |
| `i18n/GLOSSARY.md` | Bảng thuật ngữ và quy ước dịch |
| `tricks/*.md` | Trick lỏ (front matter: `title`, `pages`, `tags`) |
| `templates/` | Trang chủ, trang trick, trang đóng góp |
| `assets/` | CSS, JS, favicon |
| `bin/` | Công cụ build |

## Build

Cần PHP 8.4+ (dùng `Dom\HTMLDocument`). Không cần thư viện ngoài.

```bash
php bin/extract.php        # chỉ khi đổi bản sách upstream
php bin/gen-longindex.php  # dịch trang chỉ mục từ tiêu đề các mục
php bin/check-vi.php       # kiểm tra thẻ HTML và câu còn thiếu
php bin/build.php          # sinh site tĩnh vào public/
```

## Đóng góp

Sửa file trong `i18n/vi/` hoặc thêm file vào `tricks/`, chạy `php bin/check-vi.php`, rồi mở pull request. Chi tiết ở trang /dong-gop/.

## Giấy phép

Sách LFS © 1999–2025 Gerard Beekmans, theo [CC BY-NC-SA 2.0](https://creativecommons.org/licenses/by-nc-sa/2.0/); lệnh trong sách theo giấy phép MIT. Bản dịch và trick lỏ phát hành cùng giấy phép CC BY-NC-SA 2.0. Đây không phải dự án chính thức của LFS.

## GitBook

Thư mục `gitbook/` là bản Markdown của sách cho [GitBook Git Sync](https://docs.gitbook.com/getting-started/git-sync) (`.gitbook.yaml` ở gốc repo trỏ vào đó). Sinh lại sau khi build site:

```bash
php bin/build.php && php bin/gitbook.php
```

Đừng sửa tay file trong `gitbook/` — sửa bản dịch ở `i18n/vi/` rồi sinh lại.
